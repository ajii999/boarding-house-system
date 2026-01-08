<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Tenant;
use App\Models\Room;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check if this is a tenant request
        if (request()->routeIs('tenant.*')) {
            $query = Booking::where('tenant_id', session('user_id'))
                ->with(['room']);
            
            // Search functionality for tenant
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('booking_id', 'like', "%{$search}%")
                      ->orWhere('check_in', 'like', "%{$search}%")
                      ->orWhere('check_out', 'like', "%{$search}%")
                      ->orWhereHas('room', function($roomQuery) use ($search) {
                          $roomQuery->where('room_number', 'like', "%{$search}%")
                                   ->orWhere('room_type', 'like', "%{$search}%");
                      });
                });
            }
            
            $bookings = $query->latest('booking_date')->paginate(10);
            
            return view('tenant.bookings.index', compact('bookings'));
        }
        
        // Admin view with search functionality
        $query = Booking::with(['tenant', 'room']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_id', 'like', "%{$search}%")
                  ->orWhere('total_amount', 'like', "%{$search}%")
                  ->orWhere('check_in', 'like', "%{$search}%")
                  ->orWhere('check_out', 'like', "%{$search}%")
                  ->orWhereHas('tenant', function($tenantQuery) use ($search) {
                      $tenantQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('room', function($roomQuery) use ($search) {
                      $roomQuery->where('room_number', 'like', "%{$search}%")
                               ->orWhere('room_type', 'like', "%{$search}%");
                  });
            });
        }
        
        $bookings = $query->with(['tenant', 'room', 'payments'])
            ->latest('booking_date')
            ->paginate(10);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if this is a tenant request
        if (request()->routeIs('tenant.*')) {
            $rooms = Room::where('status', 'available')->get();
            return view('tenant.bookings.create', compact('rooms'));
        }
        
        // Admin view
        $tenants = Tenant::all();
        $rooms = Room::where('status', 'available')->get();
        
        return view('admin.bookings.create', compact('tenants', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if this is a tenant request
        if (request()->routeIs('tenant.*')) {
            $request->validate([
                'room_id' => 'required|exists:rooms,room_id',
                'booking_date' => 'required|date',
                'check_in' => 'required|date|after_or_equal:booking_date',
                'check_out' => 'required|date|after:check_in',
                'preferences' => 'nullable|string|max:1000',
                'emergency_contact' => 'nullable|string|max:255',
                'occupancy_type' => 'required|in:single,shared',
            ]);

            // Check room availability
            $room = Room::find($request->room_id);
            if (!$room || $room->status !== 'available') {
                return back()->with('error', 'Selected room is not available for booking.');
            }

            // Check for conflicting bookings
            $conflictingBooking = Booking::where('room_id', $request->room_id)
                ->where('status', '!=', 'cancelled')
                ->where(function($query) use ($request) {
                    $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                          ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                          ->orWhere(function($q) use ($request) {
                              $q->where('check_in', '<=', $request->check_in)
                                ->where('check_out', '>=', $request->check_out);
                          });
                })
                ->first();

            if ($conflictingBooking) {
                return back()->with('error', 'Room is already booked for the selected dates.');
            }

            // Calculate total amount
            $checkIn = \Carbon\Carbon::parse($request->check_in);
            $checkOut = \Carbon\Carbon::parse($request->check_out);
            $totalAmount = $room->price * $checkIn->diffInDays($checkOut);

            try {
                $booking = Booking::create([
                    'tenant_id' => session('user_id'),
                    'room_id' => $request->room_id,
                    'booking_date' => $request->booking_date,
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    'status' => 'pending',
                    'total_amount' => $totalAmount,
                    'preferences' => $request->preferences,
                    'emergency_contact' => $request->emergency_contact,
                    'occupancy_type' => $request->occupancy_type,
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to create booking: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Failed to create booking. Please try again or contact support if the problem persists.');
            }

            // Create notification for admin
            try {
                // Load tenant relationship
                $booking->load('tenant');
                $tenantName = $booking->tenant ? $booking->tenant->name : 'Unknown Tenant';
                
                // Get first admin or use ID 1
                $admin = \App\Models\Admin::first();
                $adminId = $admin ? $admin->admin_id : 1;
                
                \App\Models\Notification::create([
                    'notifiable_type' => 'App\Models\Admin',
                    'notifiable_id' => $adminId,
                    'type' => 'booking_request',
                    'title' => 'New Booking Request',
                    'message' => "New booking request from {$tenantName} for Room {$room->room_number}",
                    'data' => json_encode(['booking_id' => $booking->booking_id]),
                ]);
            } catch (\Exception $e) {
                // Log error but don't fail the booking creation
                \Log::error('Failed to create notification for booking: ' . $e->getMessage());
            }

            return redirect()->route('tenant.bookings.index')
                ->with('success', 'Booking request submitted successfully. You will be notified once it\'s reviewed.');
        }
        
        // Admin validation
        $request->validate([
            'tenant_id' => 'required|exists:tenants,tenant_id',
            'room_id' => 'required|exists:rooms,room_id',
            'booking_date' => 'required|date',
            'check_in' => 'required|date|after_or_equal:booking_date',
            'check_out' => 'required|date|after:check_in',
            'payment_type' => 'required|in:full_payment,down_payment',
            'payment_method' => 'required|in:cash,online',
            'ewallet_type' => 'required_if:payment_method,online|in:gcash,maya',
            'down_payment_amount' => 'required_if:payment_type,down_payment|nullable|numeric|min:100',
            'payment_receipt' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Optional - 10MB max
        ], [
            'tenant_id.required' => 'Please select a tenant.',
            'tenant_id.exists' => 'The selected tenant does not exist.',
            'room_id.required' => 'Please select a room.',
            'room_id.exists' => 'The selected room does not exist.',
            'booking_date.required' => 'Please select a booking date.',
            'check_in.required' => 'Please select a check-in date.',
            'check_in.after_or_equal' => 'Check-in date must be on or after the booking date.',
            'check_out.required' => 'Please select a check-out date.',
            'check_out.after' => 'Check-out date must be after the check-in date.',
            'payment_type.required' => 'Please select a payment type.',
            'payment_method.required' => 'Please select a payment method.',
            'ewallet_type.required_if' => 'Please select an e-wallet type for online payments.',
            'down_payment_amount.required_if' => 'Please enter the down payment amount.',
            'down_payment_amount.min' => 'Down payment amount must be at least ₱100.',
            'payment_receipt.image' => 'Payment receipt must be an image file.',
            'payment_receipt.mimes' => 'Payment receipt must be a JPEG, PNG, JPG, or GIF file.',
            'payment_receipt.max' => 'Payment receipt must not exceed 10MB.',
        ]);

        // Calculate total amount for admin booking
        $room = Room::find($request->room_id);
        if (!$room) {
            return back()->withInput()->with('error', 'Selected room not found.');
        }
        
        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $totalAmount = $room->price * $checkIn->diffInDays($checkOut);

        // Prepare booking data
        $data = [
            'tenant_id' => $request->tenant_id,
            'room_id' => $request->room_id,
            'booking_date' => $request->booking_date,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => $request->status ?? 'confirmed',
            'total_amount' => $totalAmount,
            'payment_type' => $request->payment_type,
            'payment_method' => $request->payment_method,
        ];

        // Handle e-wallet type
        if ($request->payment_method === 'online') {
            $data['ewallet_type'] = $request->ewallet_type;
        } else {
            $data['ewallet_type'] = null;
        }

        // Handle payment receipt upload
        if ($request->hasFile('payment_receipt')) {
            $receiptPath = $request->file('payment_receipt')->store('payment-receipts', 'public');
            $data['payment_receipt'] = $receiptPath;
        } else {
            $data['payment_receipt'] = null;
        }

        // Set down payment amount for down payment type
        if ($request->payment_type === 'down_payment') {
            $data['down_payment_amount'] = $request->down_payment_amount;
            $data['down_payment_date'] = now();
        } else {
            $data['down_payment_amount'] = null;
            $data['down_payment_date'] = null;
        }

        try {
            $booking = Booking::create($data);
            
            // Update room status to booked
            $room->update(['status' => 'booked']);
        } catch (\Exception $e) {
            \Log::error('Failed to create booking: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create booking. Please try again or contact support if the problem persists.');
        }

        // Automatically create a payment record for the booking
        try {
            if ($booking) {
                $paymentAmount = $request->payment_type === 'down_payment' ? 
                    $request->down_payment_amount : $totalAmount;
                
                $paymentMethod = $request->payment_method === 'online' ? 
                    $request->ewallet_type : 'cash';
                
                $paymentData = [
                    'tenant_id' => $booking->tenant_id,
                    'booking_id' => $booking->booking_id,
                    'amount' => $paymentAmount,
                    'payment_date' => now(),
                    'method' => $paymentMethod,
                    'status' => 'completed',
                    'notes' => 'Payment for booking #' . $booking->booking_id . ' - ' . ucfirst($request->payment_type),
                ];
                
                // Copy receipt from booking to payment if exists
                if ($booking->payment_receipt) {
                    $paymentData['receipt_image'] = $booking->payment_receipt;
                }
                
                $payment = Payment::create($paymentData);

                // Automatically create an invoice for the payment
                if ($payment) {
                    try {
                        Invoice::create([
                            'payment_id' => $payment->payment_id,
                            'tenant_id' => $booking->tenant_id,
                            'date' => now(),
                            'due_date' => now()->addDays(30), // 30 days from now
                            'amount' => $totalAmount,
                            'status' => 'paid', // Since payment is completed
                            'notes' => 'Invoice automatically created for booking #' . $booking->booking_id,
                        ]);
                    } catch (\Exception $invoiceError) {
                        \Log::error('Failed to create invoice for booking: ' . $invoiceError->getMessage());
                        // Don't fail the booking if invoice creation fails
                    }
                }
            }
        } catch (\Exception $paymentError) {
            \Log::error('Failed to create payment for booking: ' . $paymentError->getMessage());
            // Don't fail the booking if payment creation fails, but log it
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        // Check if this is a tenant request
        if (request()->routeIs('tenant.*')) {
            // Ensure tenant can only view their own bookings
            if ($booking->tenant_id != session('user_id')) {
                abort(403, 'Unauthorized access to booking.');
            }
            
            $booking->load(['room', 'payments', 'invoices']);
            return view('tenant.bookings.show', compact('booking'));
        }
        
        // Admin view
        $booking->load(['tenant', 'room', 'payments', 'invoices']);
        
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        // Check if this is a tenant request
        if (request()->routeIs('tenant.*')) {
            // Ensure tenant can only edit their own bookings
            if ($booking->tenant_id != session('user_id')) {
                abort(403, 'Unauthorized access to booking.');
            }
            
            $rooms = Room::all();
            return view('tenant.bookings.edit', compact('booking', 'rooms'));
        }
        
        // Admin view
        $tenants = Tenant::all();
        $rooms = Room::all();
        
        return view('admin.bookings.edit', compact('booking', 'tenants', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        // Check if this is a tenant request
        if (request()->routeIs('tenant.*')) {
            // Ensure tenant can only update their own bookings
            if ($booking->tenant_id != session('user_id')) {
                abort(403, 'Unauthorized access to booking.');
            }
            
            $request->validate([
                'room_id' => 'required|exists:rooms,room_id',
                'booking_date' => 'required|date',
                'check_in' => 'required|date|after_or_equal:booking_date',
                'check_out' => 'required|date|after:check_in',
            ]);

            // Calculate total amount
            $room = Room::find($request->room_id);
            $checkIn = \Carbon\Carbon::parse($request->check_in);
            $checkOut = \Carbon\Carbon::parse($request->check_out);
            $totalAmount = $room->price * $checkIn->diffInDays($checkOut);

            $booking->update([
                'room_id' => $request->room_id,
                'booking_date' => $request->booking_date,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'total_amount' => $totalAmount,
            ]);

            return redirect()->route('tenant.bookings.index')
                ->with('success', 'Booking updated successfully.');
        }
        
        // Admin validation
        $request->validate([
            'tenant_id' => 'required|exists:tenants,tenant_id',
            'room_id' => 'required|exists:rooms,room_id',
            'booking_date' => 'required|date',
            'check_in' => 'required|date|after_or_equal:booking_date',
            'check_out' => 'required|date|after:check_in',
        ]);

        // Update room status based on booking status
        $room = Room::find($request->room_id);
        if ($room) {
            if (in_array($request->status, ['confirmed', 'completed'])) {
                $room->update(['status' => 'booked']);
            } elseif ($request->status === 'cancelled') {
                $room->update(['status' => 'available']);
            }
        }

        // Calculate total amount for admin booking update
        $room = Room::find($request->room_id);
        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $totalAmount = $room->price * $checkIn->diffInDays($checkOut);

        $oldStatus = $booking->status;
        $updateData = $request->all();
        $updateData['total_amount'] = $totalAmount;
        $booking->update($updateData);

        // Create payment if status changed to confirmed or completed
        if (in_array($request->status, ['confirmed', 'completed']) && 
            !in_array($oldStatus, ['confirmed', 'completed']) &&
            !$booking->payments()->where('status', 'completed')->exists()) {
            
            // Calculate total amount based on room price and duration
            $room = Room::find($booking->room_id);
            $checkIn = \Carbon\Carbon::parse($booking->check_in);
            $checkOut = \Carbon\Carbon::parse($booking->check_out);
            $totalAmount = $room->price * $checkIn->diffInDays($checkOut);
            
            $payment = Payment::create([
                'tenant_id' => $booking->tenant_id,
                'booking_id' => $booking->booking_id,
                'amount' => $totalAmount,
                'payment_date' => now(),
                'method' => 'cash', // Default to cash payment
                'status' => 'completed',
                'notes' => 'Payment automatically created for booking #' . $booking->booking_id,
            ]);

            // Automatically create an invoice for the payment
            if ($payment) {
                Invoice::create([
                    'payment_id' => $payment->payment_id,
                    'tenant_id' => $booking->tenant_id,
                    'date' => now(),
                    'due_date' => now()->addDays(30), // 30 days from now
                    'amount' => $totalAmount,
                    'status' => 'paid', // Since payment is completed
                    'notes' => 'Invoice automatically created for booking #' . $booking->booking_id,
                ]);
            }
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // Check if this is a tenant request
        if (request()->routeIs('tenant.*')) {
            // Ensure tenant can only delete their own bookings
            if ($booking->tenant_id != session('user_id')) {
                abort(403, 'Unauthorized access to booking.');
            }
            
            // Update room status to available when booking is deleted
            if ($booking->room) {
                $booking->room->update(['status' => 'available']);
            }

            $booking->delete();

            return redirect()->route('tenant.bookings.index')
                ->with('success', 'Booking deleted successfully.');
        }
        
        // Admin view
        // Update room status to available when booking is deleted
        if ($booking->room) {
            $booking->room->update(['status' => 'available']);
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}
