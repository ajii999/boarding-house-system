<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Payment;
use App\Models\Booking;
use Carbon\Carbon;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::active()
            ->orderBy('name')
            ->paginate(10);
        
        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment-methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:online,offline,digital_wallet,bank_transfer',
            'description' => 'nullable|string|max:1000',
            'configuration' => 'nullable|array',
            'is_active' => 'boolean',
            'requires_verification' => 'boolean',
            'processing_fee' => 'required|numeric|min:0',
            'processing_time_hours' => 'required|integer|min:0',
        ]);

        PaymentMethod::create($request->all());

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        $paymentMethod->load('payments');
        return view('admin.payment-methods.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment-methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:online,offline,digital_wallet,bank_transfer',
            'description' => 'nullable|string|max:1000',
            'configuration' => 'nullable|array',
            'is_active' => 'boolean',
            'requires_verification' => 'boolean',
            'processing_fee' => 'required|numeric|min:0',
            'processing_time_hours' => 'required|integer|min:0',
        ]);

        $paymentMethod->update($request->all());

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        // Check if payment method is being used
        if ($paymentMethod->payments()->count() > 0) {
            return redirect()->route('admin.payment-methods.index')
                ->with('error', 'Cannot delete payment method that is being used.');
        }

        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }

    /**
     * Reserve a payment method for a booking
     */
    public function reserve(Request $request, Booking $booking)
    {
        $request->validate([
            'method_id' => 'required|exists:payment_methods,method_id',
            'amount' => 'required|numeric|min:0',
        ]);

        $paymentMethod = PaymentMethod::findOrFail($request->method_id);
        
        if (!$paymentMethod->is_active) {
            return back()->with('error', 'Selected payment method is not available.');
        }

        // Create reserved payment
        $reservationExpiresAt = Carbon::now()->addHours($paymentMethod->processing_time_hours ?: 24);
        $verificationCode = strtoupper(substr(md5(uniqid()), 0, 8));

        $payment = Payment::create([
            'tenant_id' => $booking->tenant_id,
            'booking_id' => $booking->booking_id,
            'method_id' => $paymentMethod->method_id,
            'amount' => $request->amount,
            'payment_date' => now(),
            'method' => $paymentMethod->type,
            'status' => 'reserved',
            'reservation_expires_at' => $reservationExpiresAt,
            'verification_code' => $verificationCode,
            'notes' => "Payment reserved via {$paymentMethod->name}. Verification code: {$verificationCode}",
        ]);

        return redirect()->route('tenant.bookings.show', $booking)
            ->with('success', "Payment method reserved successfully. Verification code: {$verificationCode}. Expires at: {$reservationExpiresAt->format('M d, Y H:i')}");
    }

    /**
     * Complete a reserved payment
     */
    public function complete(Payment $payment)
    {
        if (!$payment->isReserved()) {
            return back()->with('error', 'Payment is not reserved or has expired.');
        }

        $payment->update([
            'status' => 'completed',
            'reservation_expires_at' => null,
        ]);

        // Create invoice record for the completed payment
        if ($payment) {
            \App\Models\Invoice::create([
                'payment_id' => $payment->payment_id,
                'tenant_id' => $payment->tenant_id,
                'date' => now(),
                'due_date' => now()->addDays(30), // 30 days from completion
                'amount' => $payment->amount,
                'status' => 'paid', // Since payment is completed, mark as paid
                'notes' => 'Payment method completed - ' . ($payment->notes ?: 'No additional notes'),
            ]);
        }

        return back()->with('success', 'Payment completed successfully.');
    }

    /**
     * Cancel a reserved payment
     */
    public function cancel(Payment $payment)
    {
        if (!$payment->isReserved()) {
            return back()->with('error', 'Payment is not reserved or has expired.');
        }

        $payment->update([
            'status' => 'cancelled',
            'reservation_expires_at' => null,
        ]);

        return back()->with('success', 'Payment reservation cancelled.');
    }

    /**
     * Get available payment methods for tenant
     */
    public function getAvailableMethods()
    {
        $methods = PaymentMethod::active()
            ->orderBy('name')
            ->get();

        return response()->json($methods);
    }
}
