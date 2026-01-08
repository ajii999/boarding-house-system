<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\Notification;
use App\Models\Room;
use App\Models\Invoice;
use Carbon\Carbon;

class TenantController extends Controller
{
    public function dashboard()
    {
        $tenantId = session('user_id');
        
        // Check for payment due notifications
        self::checkPaymentDueNotifications();
        
        $activeBookings = Booking::where('tenant_id', $tenantId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
            
        $totalPayments = Payment::where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->sum('amount');
            
        
        $unreadNotifications = Notification::where('notifiable_id', $tenantId)
            ->where('notifiable_type', 'App\Models\Tenant')
            ->where('type', 'payment_due')
            ->where('status', 'unread')
            ->count();
            
        $recentBookings = Booking::with('room')
            ->where('tenant_id', $tenantId)
            ->latest()
            ->limit(5)
            ->get();
            
        $recentPayments = Payment::with(['booking.room', 'tenant'])
            ->where('tenant_id', $tenantId)
            ->latest()
            ->limit(5)
            ->get();
            
        $pendingMaintenance = MaintenanceRequest::where('tenant_id', $tenantId)
            ->whereIn('status', ['pending', 'assigned', 'in_progress'])
            ->count();
            
        return view('tenant.dashboard', compact(
            'activeBookings',
            'totalPayments',
            'unreadNotifications',
            'recentBookings',
            'recentPayments',
            'pendingMaintenance'
        ));
    }

    public function profile()
    {
        $tenant = Tenant::with('profile')->find(session('user_id'));
        return view('tenant.profile', compact('tenant'));
    }

    public function updateProfile(Request $request)
    {
        $tenant = Tenant::find(session('user_id'));
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tenants,email,' . $tenant->tenant_id . ',tenant_id',
            'contact_number' => 'required|string|max:20',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
        ]);

        $tenant->update($request->only(['name', 'email', 'contact_number']));
        
        $tenant->profile->update([
            'address' => $request->address ?? '',
            'emergency_contact' => $request->emergency_contact ?? '',
        ]);

        return redirect()->route('tenant.profile')->with('success', 'Profile updated successfully.');
    }

    public function payments()
    {
        $tenantId = session('user_id');
        
        $payments = Payment::where('tenant_id', $tenantId)
            ->with('booking.room')
            ->latest()
            ->paginate(10);
            
        // Calculate tenant balance
        $totalInvoices = \App\Models\Invoice::where('tenant_id', $tenantId)->sum('amount');
        $totalPayments = Payment::where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->sum('amount');
        $tenantBalance = $totalInvoices - $totalPayments;
            
        return view('tenant.payments', compact('payments', 'tenantBalance'));
    }

    public function showPayment(Payment $payment)
    {
        $tenantId = session('user_id');
        
        // Ensure the payment belongs to the current tenant
        if ($payment->tenant_id != $tenantId) {
            abort(403, 'Unauthorized access to payment details.');
        }
        
        $payment->load(['tenant', 'booking.room', 'paymentMethod', 'invoice']);
        
        return view('tenant.payments.show', compact('payment'));
    }

    public function invoices()
    {
        $tenantId = session('user_id');
        
        $invoices = \App\Models\Invoice::where('tenant_id', $tenantId)
            ->with(['payment', 'tenant'])
            ->latest()
            ->paginate(10);
            
        // Calculate tenant balance
        $totalInvoices = \App\Models\Invoice::where('tenant_id', $tenantId)->sum('amount');
        $totalPayments = Payment::where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->sum('amount');
        $tenantBalance = $totalInvoices - $totalPayments;
        
        // Get recent payments for context
        $recentPayments = Payment::where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->with('booking.room')
            ->latest()
            ->limit(5)
            ->get();
            
        return view('tenant.invoices', compact('invoices', 'tenantBalance', 'recentPayments'));
    }


    public function rooms()
    {
        $tenantId = session('user_id');
        
        // Get tenant's assigned room (current active booking)
        $assignedRoom = null;
        $activeBooking = Booking::with('room')
            ->where('tenant_id', $tenantId)
            ->whereIn('status', ['confirmed', 'completed'])
            ->where('check_in', '<=', now())
            ->where('check_out', '>=', now())
            ->first();
            
        if ($activeBooking && $activeBooking->room) {
            $assignedRoom = $activeBooking->room;
        }
        
        // Get available rooms (excluding the assigned room)
        // A room is available if:
        // 1. Status is 'available', OR
        // 2. Status is 'booked' but has no active confirmed/completed bookings
        $availableRooms = Room::with(['bookings' => function($query) use ($tenantId) {
                // Load bookings for this tenant to show in the view
                $query->where('tenant_id', $tenantId)
                      ->whereIn('status', ['pending', 'confirmed', 'completed'])
                      ->latest('check_in');
            }])
            ->where(function($query) {
                // Rooms with status 'available'
                $query->where('status', 'available')
                      // OR rooms with status 'booked' that have no active bookings
                      ->orWhere(function($q) {
                          $q->where('status', 'booked')
                            ->whereDoesntHave('bookings', function($bookingQuery) {
                                $bookingQuery->whereIn('status', ['confirmed', 'completed'])
                                             ->where('check_in', '<=', now())
                                             ->where('check_out', '>=', now());
                            });
                      });
            })
            ->where('status', '!=', 'maintenance') // Exclude maintenance rooms
            ->when($assignedRoom, function($query, $assignedRoom) {
                return $query->where('room_id', '!=', $assignedRoom->room_id);
            })
            ->orderBy('room_number')
            ->get();
        
        // Get current active bookings for this tenant
        $activeBookings = Booking::with('room')
            ->where('tenant_id', $tenantId)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->latest('check_in')
            ->get();
            
        return view('tenant.rooms', compact('assignedRoom', 'availableRooms', 'activeBookings'));
    }

    public function selectRoom(Request $request)
    {
        $tenantId = session('user_id');
        
        $request->validate([
            'room_id' => 'required|exists:rooms,room_id',
            'start_date' => 'required|date|after_or_equal:today',
            'duration' => 'required|integer|min:1|max:12',
        ]);

        // Check if room is still available
        $room = Room::find($request->room_id);
        if (!$room) {
            return redirect()->back()->with('error', 'Selected room not found.');
        }
        
        // Check if room is in maintenance
        if ($room->status === 'maintenance') {
            return redirect()->back()->with('error', 'Selected room is currently under maintenance.');
        }
        
        // Check if room is actually available (same logic as rooms() method)
        $isAvailable = false;
        if ($room->status === 'available') {
            $isAvailable = true;
        } elseif ($room->status === 'booked') {
            // Check if room has no active bookings
            $hasActiveBooking = $room->bookings()
                ->whereIn('status', ['confirmed', 'completed'])
                ->where('check_in', '<=', now())
                ->where('check_out', '>=', now())
                ->exists();
            $isAvailable = !$hasActiveBooking;
        }
        
        if (!$isAvailable) {
            return redirect()->back()->with('error', 'Selected room is no longer available.');
        }
        
        // Check for conflicting bookings with the requested dates
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $duration = (int) $request->duration;
        $endDate = $startDate->copy()->addMonths($duration)->endOfMonth();
        
        $conflictingBooking = Booking::where('room_id', $request->room_id)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('check_in', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                      ->orWhereBetween('check_out', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->where('check_in', '<=', $startDate->format('Y-m-d'))
                            ->where('check_out', '>=', $endDate->format('Y-m-d'));
                      });
            })
            ->first();
        
        if ($conflictingBooking) {
            return redirect()->back()->with('error', 'Room is already booked for the selected dates.');
        }

        // Check if tenant already has an active booking
        $existingBooking = Booking::where('tenant_id', $tenantId)
            ->whereIn('status', ['confirmed', 'completed'])
            ->where('check_in', '<=', now())
            ->where('check_out', '>=', now())
            ->first();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'You already have an active room assignment. Please contact admin to change rooms.');
        }

        // Calculate dates based on start date and duration (already calculated above)
        // $startDate and $endDate are already set from the conflict check above
        
        // Calculate total amount (monthly pricing)
        $totalAmount = $room->price * $duration;

        // Create booking request
        $booking = Booking::create([
            'tenant_id' => $tenantId,
            'room_id' => $request->room_id,
            'booking_date' => now(),
            'check_in' => $startDate->format('Y-m-d'),
            'check_out' => $endDate->format('Y-m-d'),
            'status' => 'pending',
            'total_amount' => $totalAmount,
        ]);

        return redirect()->route('tenant.rooms')->with('success', 'Room selection request submitted successfully. Please wait for admin approval.');
    }

    public function createPayment()
    {
        $tenantId = session('user_id');
        
        // Get active bookings for payment reference
        $activeBookings = Booking::where('tenant_id', $tenantId)
            ->whereIn('status', ['confirmed', 'completed'])
            ->with('room')
            ->get();
            
        // Calculate tenant balance
        $totalInvoices = \App\Models\Invoice::where('tenant_id', $tenantId)->sum('amount');
        $totalPayments = Payment::where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->sum('amount');
        $tenantBalance = $totalInvoices - $totalPayments;
            
        return view('tenant.payments.create', compact('activeBookings', 'tenantBalance'));
    }

    public function storePayment(Request $request)
    {
        $tenantId = session('user_id');
        
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,gcash,paymaya',
            'notes' => 'nullable|string|max:500',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'booking_id' => 'nullable|exists:bookings,booking_id',
        ]);

        $paymentData = [
            'tenant_id' => $tenantId,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'method' => $request->method,
            'status' => 'pending',
            'notes' => $request->notes,
            'booking_id' => $request->booking_id,
        ];

        // Handle receipt image upload
        if ($request->hasFile('receipt_image')) {
            $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
            $paymentData['receipt_image'] = $receiptPath;
        }

        $payment = Payment::create($paymentData);

        // Create invoice record for the payment
        if ($payment) {
            \App\Models\Invoice::create([
                'payment_id' => $payment->payment_id,
                'tenant_id' => $tenantId,
                'date' => $request->payment_date,
                'due_date' => \Carbon\Carbon::parse($request->payment_date)->addDays(30), // 30 days from payment date
                'amount' => $request->amount,
                'status' => 'paid', // Since this is a payment submission, mark as paid
                'notes' => 'Monthly fee payment - ' . ($request->notes ?: 'No additional notes'),
            ]);
        }

        // Create notification for admin about new payment
        $admin = \App\Models\Admin::first();
        if ($admin) {
            \App\Models\Notification::create([
                'notifiable_id' => $admin->admin_id,
                'notifiable_type' => 'App\\Models\\Admin',
                'type' => 'payment_received',
                'title' => 'New Payment Received',
                'message' => 'Tenant ' . $payment->tenant->name . ' has submitted a payment of ₱' . number_format($payment->amount, 2),
                'data' => json_encode([
                    'payment_id' => $payment->payment_id,
                    'tenant_id' => $payment->tenant_id,
                    'amount' => $payment->amount,
                    'method' => $payment->method,
                ]),
                'read_at' => null,
            ]);
        }

        return redirect()->route('tenant.payments')
            ->with('success', 'Payment submitted successfully. The admin has been notified.');
    }

    /**
     * Display tenant notifications
     */
    public function notifications()
    {
        $tenantId = session('user_id');
        $notifications = \App\Models\Notification::where('notifiable_type', 'App\Models\Tenant')
            ->where('notifiable_id', $tenantId)
            ->latest()
            ->paginate(10);
            
        return view('tenant.notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read
     */
    public function markNotificationAsRead(\App\Models\Notification $notification)
    {
        if ($notification->notifiable_type === 'App\Models\Tenant' && 
            $notification->notifiable_id == session('user_id')) {
            $notification->update([
                'read_at' => now(),
                'status' => 'read'
            ]);
        }
        
        if (request()->expectsJson() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
        }
        
        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsAsRead()
    {
        $tenantId = session('user_id');
        $updated = \App\Models\Notification::where('notifiable_type', 'App\Models\Tenant')
            ->where('notifiable_id', $tenantId)
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
                'status' => 'read'
            ]);
            
        // Check if request is AJAX or expects JSON
        if (request()->ajax() || 
            request()->expectsJson() || 
            request()->wantsJson() || 
            request()->header('Accept') === 'application/json' ||
            request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true, 
                'message' => 'All notifications marked as read.',
                'updated_count' => $updated
            ]);
        }
        
        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Check and create payment due notifications for tenants
     */
    public static function checkPaymentDueNotifications()
    {
        // Get invoices that are due in the next 3 days and not yet paid
        $upcomingDueInvoices = Invoice::where('status', '!=', 'paid')
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(3))
            ->with('tenant')
            ->get();

        foreach ($upcomingDueInvoices as $invoice) {
            // Check if notification already exists for this invoice
            $existingNotification = Notification::where('notifiable_id', $invoice->tenant_id)
                ->where('notifiable_type', 'App\Models\Tenant')
                ->where('type', 'payment_due')
                ->where('data->invoice_id', $invoice->invoice_id)
                ->first();

            if (!$existingNotification) {
                $daysUntilDue = now()->diffInDays($invoice->due_date, false);
                $message = $daysUntilDue > 0 
                    ? "Payment of ₱" . number_format($invoice->amount, 2) . " is due in {$daysUntilDue} day(s) on " . $invoice->due_date->format('M j, Y')
                    : "Payment of ₱" . number_format($invoice->amount, 2) . " is due today (" . $invoice->due_date->format('M j, Y') . ")";

                Notification::create([
                    'notifiable_id' => $invoice->tenant_id,
                    'notifiable_type' => 'App\Models\Tenant',
                    'type' => 'payment_due',
                    'message' => $message,
                    'status' => 'unread',
                    'data' => [
                        'invoice_id' => $invoice->invoice_id,
                        'amount' => $invoice->amount,
                        'due_date' => $invoice->due_date->format('Y-m-d'),
                        'days_until_due' => $daysUntilDue
                    ]
                ]);
            }
        }

        // Clean up old notifications for paid invoices
        $paidInvoiceIds = Invoice::where('status', 'paid')->pluck('invoice_id');
        Notification::where('type', 'payment_due')
            ->whereIn('data->invoice_id', $paidInvoiceIds)
            ->delete();
    }
}
