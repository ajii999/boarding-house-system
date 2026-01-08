<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Room;
use App\Models\Booking;
use App\Models\MaintenanceRequest;
use App\Models\Payment;
use App\Models\Report;
use App\Models\Notification;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalTenants = Tenant::count();
        $availableRooms = Room::where('status', 'available')->count();
        $activeBookings = Booking::whereIn('status', ['pending', 'confirmed'])->count();
        $monthlyRevenue = Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->where('status', 'completed')
            ->sum('amount');
        
        $recentBookings = Booking::with(['tenant', 'room'])
            ->latest()
            ->limit(5)
            ->get();
            
        $pendingMaintenance = MaintenanceRequest::with('tenant')
            ->latest()
            ->limit(5)
            ->get();
            
        $recentReports = Report::with(['generatedBy'])
            ->latest('generated_date')
            ->limit(5)
            ->get();
            
        // Get recent payments for admin dashboard
        $recentPayments = Payment::with(['tenant', 'booking.room'])
            ->latest()
            ->limit(5)
            ->get();
            
        // Get unread notifications
        $unreadNotifications = Notification::whereNull('read_at')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalTenants',
            'availableRooms', 
            'activeBookings',
            'monthlyRevenue',
            'recentBookings',
            'pendingMaintenance',
            'recentReports',
            'recentPayments',
            'unreadNotifications'
        ));
    }

    public function index(Request $request)
    {
        $query = Tenant::with(['profile', 'bookings' => function($query) {
            $query->whereIn('status', ['confirmed', 'completed'])
                  ->with('room')
                  ->latest('check_in');
        }]);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }
        
        $tenants = $query->paginate(10);
        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        return view('admin.tenants.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tenants,email,tenant_id',
            'contact_number' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'room_id' => 'nullable|exists:rooms,room_id',
            'check_in' => 'nullable|date|after_or_equal:today',
            'check_out' => 'nullable|date|after:check_in',
        ]);

        $tenant = Tenant::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'password' => bcrypt($request->password),
        ]);

        $tenant->profile()->create([
            'address' => $request->address ?? '',
            'emergency_contact' => $request->emergency_contact ?? '',
        ]);

        // Auto-assign room and create booking if room is selected
        if ($request->room_id && $request->check_in && $request->check_out) {
            $room = Room::find($request->room_id);
            if ($room && $room->status === 'available') {
                // Calculate total amount
                $checkIn = \Carbon\Carbon::parse($request->check_in);
                $checkOut = \Carbon\Carbon::parse($request->check_out);
                $totalAmount = $room->price * $checkIn->diffInDays($checkOut);

                // Create booking
                $booking = \App\Models\Booking::create([
                    'tenant_id' => $tenant->tenant_id,
                    'room_id' => $request->room_id,
                    'booking_date' => now(),
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    'status' => 'confirmed',
                    'total_amount' => $totalAmount,
                ]);

                // Update room status to booked
                $room->update(['status' => 'booked']);
            }
        }

        return redirect()->route('admin.tenants.index')->with('success', 'Tenant created successfully.');
    }

    public function notifications()
    {
        $notifications = Notification::latest()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        // Find notification by ID
        $notification = Notification::where('notification_id', $id)->first();
        
        if (!$notification) {
            abort(404, 'Notification not found.');
        }
        
        $notification->update([
            'read_at' => now(),
            'status' => 'read'
        ]);
        
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function show(Tenant $tenant)
    {
        $tenant->load('profile', 'bookings.room', 'payments', 'maintenanceRequests');
        return view('admin.tenants.show', compact('tenant'));
    }

    public function getActiveBooking(Tenant $tenant)
    {
        $activeBooking = $tenant->bookings()
            ->whereIn('status', ['confirmed', 'completed'])
            ->with('room')
            ->latest('check_in')
            ->first();

        if ($activeBooking) {
            return response()->json([
                'booking' => [
                    'booking_id' => $activeBooking->booking_id,
                    'room' => [
                        'room_number' => $activeBooking->room->room_number,
                        'room_type' => $activeBooking->room->room_type,
                        'price' => $activeBooking->room->price,
                    ],
                    'check_in' => $activeBooking->check_in->format('M j, Y'),
                    'check_out' => $activeBooking->check_out->format('M j, Y'),
                    'total_amount' => $activeBooking->total_amount,
                ]
            ]);
        }

        return response()->json(['booking' => null]);
    }

    public function edit(Tenant $tenant)
    {
        $tenant->load('profile');
        return view('admin.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
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

        return redirect()->route('admin.tenants.index')->with('success', 'Tenant updated successfully.');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('admin.tenants.index')->with('success', 'Tenant deleted successfully.');
    }

    public function invoices()
    {
        $invoices = \App\Models\Invoice::with(['tenant', 'payment'])->paginate(10);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function createInvoice()
    {
        $tenants = \App\Models\Tenant::all();
        $payments = \App\Models\Payment::where('status', 'completed')->get();
        return view('admin.invoices.create', compact('tenants', 'payments'));
    }

    public function storeInvoice(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,tenant_id',
            'payment_id' => 'nullable|exists:payments,payment_id',
            'date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        \App\Models\Invoice::create($request->all());

        return redirect()->route('admin.invoices')
            ->with('success', 'Invoice created successfully.');
    }

    public function showInvoice(\App\Models\Invoice $invoice)
    {
        $invoice->load(['tenant', 'payment']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function editInvoice(\App\Models\Invoice $invoice)
    {
        $tenants = \App\Models\Tenant::all();
        $payments = \App\Models\Payment::where('status', 'completed')->get();
        return view('admin.invoices.edit', compact('invoice', 'tenants', 'payments'));
    }

    public function updateInvoice(Request $request, \App\Models\Invoice $invoice)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,tenant_id',
            'payment_id' => 'nullable|exists:payments,payment_id',
            'date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $invoice->update($request->all());

        return redirect()->route('admin.invoices')
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroyInvoice(\App\Models\Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoices')
            ->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Approve a booking request
     */
    public function approveBooking(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be approved.');
        }

        // Update booking status
        $booking->update([
            'status' => 'confirmed',
            'admin_notes' => 'Booking approved by admin'
        ]);

        // Update room status to booked
        $booking->room->update(['status' => 'booked']);

        // Create notification for tenant
        Notification::create([
            'notifiable_type' => 'App\Models\Tenant',
            'notifiable_id' => $booking->tenant_id,
            'type' => 'booking_approved',
            'title' => 'Booking Approved',
            'message' => "Your booking for Room {$booking->room->room_number} has been approved. You can now proceed with payment.",
            'data' => json_encode(['booking_id' => $booking->booking_id]),
        ]);

        return back()->with('success', 'Booking approved successfully. Tenant has been notified.');
    }

    /**
     * Decline a booking request
     */
    public function declineBooking(Request $request, Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be declined.');
        }

        $request->validate([
            'admin_notes' => 'required|string|max:500'
        ]);

        // Update booking status
        $booking->update([
            'status' => 'cancelled',
            'admin_notes' => $request->admin_notes
        ]);

        // Create notification for tenant
        Notification::create([
            'notifiable_type' => 'App\Models\Tenant',
            'notifiable_id' => $booking->tenant_id,
            'type' => 'booking_declined',
            'title' => 'Booking Declined',
            'message' => "Your booking for Room {$booking->room->room_number} has been declined. Reason: {$request->admin_notes}",
            'data' => json_encode(['booking_id' => $booking->booking_id]),
        ]);

        return back()->with('success', 'Booking declined successfully. Tenant has been notified.');
    }

    /**
     * Show booking details for admin review
     */
    public function showBooking(Booking $booking)
    {
        $booking->load(['tenant', 'room', 'payments']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Verify a payment
     */
    public function verifyPayment(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Only pending payments can be verified.');
        }

        // Update payment status
        $payment->update(['status' => 'completed']);

        // Create notification for tenant
        Notification::create([
            'notifiable_type' => 'App\Models\Tenant',
            'notifiable_id' => $payment->tenant_id,
            'type' => 'payment_verified',
            'title' => 'Payment Verified',
            'message' => "Your payment of ₱" . number_format($payment->amount, 2) . " has been verified and processed successfully.",
            'data' => json_encode(['payment_id' => $payment->payment_id]),
        ]);

        return back()->with('success', 'Payment verified successfully. Tenant has been notified.');
    }

    /**
     * Reject a payment
     */
    public function rejectPayment(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Only pending payments can be rejected.');
        }

        // Update payment status
        $payment->update(['status' => 'failed']);

        // Create notification for tenant
        Notification::create([
            'notifiable_type' => 'App\Models\Tenant',
            'notifiable_id' => $payment->tenant_id,
            'type' => 'payment_rejected',
            'title' => 'Payment Rejected',
            'message' => "Your payment of ₱" . number_format($payment->amount, 2) . " has been rejected. Please contact admin for more information.",
            'data' => json_encode(['payment_id' => $payment->payment_id]),
        ]);

        return back()->with('success', 'Payment rejected successfully. Tenant has been notified.');
    }

    /**
     * Generate revenue and outstanding balance reports
     */
    public function reports()
    {
        // Revenue statistics
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $monthlyRevenue = Payment::where('status', 'completed')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');
        $yearlyRevenue = Payment::where('status', 'completed')
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        // Outstanding balances
        $outstandingPayments = Payment::where('status', 'pending')->sum('amount');
        $overduePayments = Payment::where('status', 'pending')
            ->where('payment_date', '<', now()->subDays(7))
            ->sum('amount');

        // Booking statistics
        $totalBookings = Booking::count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();

        // Tenant statistics
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::whereHas('bookings', function($query) {
            $query->whereIn('status', ['confirmed', 'completed']);
        })->count();

        // Monthly revenue chart data
        $monthlyRevenueData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = Payment::where('status', 'completed')
                ->whereMonth('payment_date', $month->month)
                ->whereYear('payment_date', $month->year)
                ->sum('amount');
            $monthlyRevenueData[] = [
                'month' => $month->format('M Y'),
                'revenue' => $revenue
            ];
        }

        // Payment method breakdown
        $paymentMethodBreakdown = Payment::where('status', 'completed')
            ->selectRaw('method, SUM(amount) as total_amount, COUNT(*) as count')
            ->groupBy('method')
            ->get();

        // Recent transactions
        $recentTransactions = Payment::with(['tenant', 'booking.room'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalRevenue',
            'monthlyRevenue',
            'yearlyRevenue',
            'outstandingPayments',
            'overduePayments',
            'totalBookings',
            'confirmedBookings',
            'pendingBookings',
            'totalTenants',
            'activeTenants',
            'monthlyRevenueData',
            'paymentMethodBreakdown',
            'recentTransactions'
        ));
    }

    /**
     * Show the form for creating a new report
     */
    public function createReport()
    {
        return view('admin.reports.create');
    }

    /**
     * Store a newly created report
     */
    public function storeReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $report = Report::create([
            'report_type' => $request->report_type,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'generated_by_type' => 'App\Models\Admin',
            'generated_by_id' => session('user_id'),
            'generated_date' => now(),
            'status' => 'pending',
        ]);

        return redirect()->route('admin.reports.show', $report)
            ->with('success', 'Report created successfully.');
    }

    /**
     * Display the specified report
     */
    public function showReport(Report $report)
    {
        return view('admin.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified report
     */
    public function editReport(Report $report)
    {
        return view('admin.reports.edit', compact('report'));
    }

    /**
     * Update the specified report
     */
    public function updateReport(Request $request, Report $report)
    {
        $request->validate([
            'report_type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $report->update($request->all());

        return redirect()->route('admin.reports.show', $report)
            ->with('success', 'Report updated successfully.');
    }

    /**
     * Remove the specified report
     */
    public function destroyReport(Report $report)
    {
        $report->delete();
        return redirect()->route('admin.reports.index')
            ->with('success', 'Report deleted successfully.');
    }

    /**
     * Show maintenance request details (admin view)
     */
    public function showMaintenance($id)
    {
        // Look up maintenance request by request_id
        $requestId = is_numeric($id) ? (int)$id : $id;
        $maintenance = MaintenanceRequest::where('request_id', $requestId)->first();
        
        if (!$maintenance) {
            abort(404, 'Maintenance request not found.');
        }
        
        $maintenance->load(['tenant', 'room', 'tasks', 'assignedStaff']);
        
        return view('admin.maintenance.show', compact('maintenance'));
    }
}
