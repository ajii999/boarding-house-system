<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\Booking;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['tenant', 'booking', 'paymentMethod']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('amount', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('method', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhereHas('tenant', function($tenantQuery) use ($search) {
                      $tenantQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('paymentMethod', function($methodQuery) use ($search) {
                      $methodQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $payments = $query->latest('payment_date')->paginate(10);
        
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = Tenant::all();
        $bookings = Booking::whereIn('status', ['confirmed', 'completed'])->get();
        $paymentMethods = PaymentMethod::active()->get();
        
        return view('admin.payments.create', compact('tenants', 'bookings', 'paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,tenant_id',
            'booking_id' => 'nullable|exists:bookings,booking_id',
            'method_id' => 'nullable|exists:payment_methods,method_id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,gcash,paymaya',
            'notes' => 'nullable|string|max:1000',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
        ]);

        // Set status to completed automatically
        $request->merge(['status' => 'completed']);

        $data = $request->all();

        // Handle receipt image upload
        if ($request->hasFile('receipt_image')) {
            $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
            $data['receipt_image'] = $receiptPath;
        }

        $payment = Payment::create($data);

        // Create invoice record for the payment
        if ($payment) {
            \App\Models\Invoice::create([
                'payment_id' => $payment->payment_id,
                'tenant_id' => $payment->tenant_id,
                'date' => $request->payment_date,
                'due_date' => \Carbon\Carbon::parse($request->payment_date)->addDays(30), // 30 days from payment date
                'amount' => $request->amount,
                'status' => 'paid', // Since admin creates payment, mark as paid
                'notes' => 'Admin created payment - ' . ($request->notes ?: 'No additional notes'),
            ]);
        }

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['tenant', 'booking', 'invoice', 'paymentMethod']);
        
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $tenants = Tenant::all();
        $bookings = Booking::whereIn('status', ['confirmed', 'completed'])->get();
        $paymentMethods = PaymentMethod::active()->get();
        
        return view('admin.payments.edit', compact('payment', 'tenants', 'bookings', 'paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,tenant_id',
            'booking_id' => 'nullable|exists:bookings,booking_id',
            'method_id' => 'nullable|exists:payment_methods,method_id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,digital_wallet,bank_transfer,credit_card,online,gcash,maya',
            'status' => 'required|in:pending,completed,failed,refunded,reserved',
            'notes' => 'nullable|string|max:1000',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
        ]);

        $data = $request->all();

        // Handle receipt image upload
        if ($request->hasFile('receipt_image')) {
            // Delete old receipt if exists
            if ($payment->receipt_image && Storage::disk('public')->exists($payment->receipt_image)) {
                Storage::disk('public')->delete($payment->receipt_image);
            }
            
            // Store new receipt
            $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
            $data['receipt_image'] = $receiptPath;
        } else {
            // Keep existing receipt_image if no new file is uploaded
            unset($data['receipt_image']);
        }

        $payment->update($data);

        return redirect()->route('admin.payments.show', $payment)
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}
