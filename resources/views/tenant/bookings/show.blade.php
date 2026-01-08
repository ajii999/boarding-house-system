@extends('layouts.tenant')

@section('title', 'Booking Details')
@section('page-title', 'Booking Details')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('tenant.bookings.index') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff;">Booking Details</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">View your booking information and payment details</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <!-- Stay Dates Card -->
        <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(34, 197, 94, 0.3);">
            <div class="row">
                <div class="col-12 col-md-3 mb-4 mb-md-0">
                    <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Stay Dates</h3>
                    <p class="small mb-0" style="color: var(--text-secondary);">Your check-in and check-out dates</p>
                </div>
                <div class="col-12 col-md-9">
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <div class="futuristic-card p-4" style="border-color: rgba(34, 197, 94, 0.2); background: rgba(34, 197, 94, 0.05);">
                                <div class="d-flex align-items-center">
                                    <div class="rounded d-flex align-items-center justify-content-center me-3" 
                                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.3);">
                                        <i class="fas fa-calendar-check" style="color: #22c55e; font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Check-in</p>
                                        <p class="h5 fw-bold mb-1" style="color: var(--text-primary);">{{ $booking->check_in->format('M j, Y') }}</p>
                                        <p class="small mb-0" style="color: var(--text-secondary);">{{ $booking->check_in->format('l') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="futuristic-card p-4" style="border-color: rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.05);">
                                <div class="d-flex align-items-center">
                                    <div class="rounded d-flex align-items-center justify-content-center me-3" 
                                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1)); border: 2px solid rgba(239, 68, 68, 0.3);">
                                        <i class="fas fa-calendar-times" style="color: #ef4444; font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Check-out</p>
                                        <p class="h5 fw-bold mb-1" style="color: var(--text-primary);">{{ $booking->check_out->format('M j, Y') }}</p>
                                        <p class="small mb-0" style="color: var(--text-secondary);">{{ $booking->check_out->format('l') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Details Card -->
        @if($booking->room)
        <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.3);">
            <div class="row">
                <div class="col-12 col-md-3 mb-4 mb-md-0">
                    <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Room Information</h3>
                    <p class="small mb-0" style="color: var(--text-secondary);">Details about your booked room</p>
                </div>
                <div class="col-12 col-md-9">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small" style="color: var(--text-secondary);">Room Number</label>
                            <p class="mb-0" style="color: var(--text-primary);">{{ $booking->room->room_number }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small" style="color: var(--text-secondary);">Room Type</label>
                            <p class="mb-0" style="color: var(--text-primary);">{{ $booking->room->room_type }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small" style="color: var(--text-secondary);">Daily Rate</label>
                            <p class="mb-0" style="color: var(--text-primary);">₱{{ number_format($booking->room->price, 2) }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small" style="color: var(--text-secondary);">Room Status</label>
                            <p class="mb-0">
                                <span class="badge px-3 py-1 rounded-pill" 
                                      style="@if($booking->room->status == 'available') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                      @elseif($booking->room->status == 'booked') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                      @elseif($booking->room->status == 'maintenance') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                    {{ ucfirst($booking->room->status) }}
                                </span>
                            </p>
                        </div>
                        @if($booking->room->description)
                        <div class="col-12">
                            <label class="form-label fw-semibold small" style="color: var(--text-secondary);">Description</label>
                            <p class="mb-0" style="color: var(--text-primary);">{{ $booking->room->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Payment Method Reservation -->
        @if($booking->status == 'confirmed' && !$booking->payments->where('status', 'completed')->count())
        <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(245, 158, 11, 0.3);">
            <div class="row">
                <div class="col-12 col-md-3 mb-4 mb-md-0">
                    <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Reserve Payment Method</h3>
                    <p class="small mb-0" style="color: var(--text-secondary);">Select and reserve a payment method for your booking.</p>
                </div>
                <div class="col-12 col-md-9">
                    <form action="{{ route('tenant.bookings.reserve-payment', $booking) }}" method="POST" id="payment-reservation-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="method_id" class="form-label fw-semibold" style="color: var(--text-primary);">Payment Method</label>
                                <select name="method_id" id="method_id" required class="form-select">
                                    <option value="">Select payment method</option>
                                    @foreach(\App\Models\PaymentMethod::active()->get() as $method)
                                        <option value="{{ $method->method_id }}" 
                                                data-fee="{{ $method->processing_fee }}"
                                                data-time="{{ $method->processing_time_hours }}"
                                                data-verification="{{ $method->requires_verification ? 'yes' : 'no' }}">
                                            {{ $method->name }} 
                                            @if($method->processing_fee > 0)
                                                (₱{{ number_format($method->processing_fee, 2) }} fee)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-12">
                                <label for="amount" class="form-label fw-semibold" style="color: var(--text-primary);">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: rgba(0, 102, 255, 0.1); border-color: rgba(0, 102, 255, 0.3);">₱</span>
                                    <input type="number" name="amount" id="amount" step="0.01" min="0" 
                                           value="{{ $booking->total_amount }}" required class="form-control">
                                </div>
                            </div>

                            <div id="payment-method-details" class="col-12 d-none">
                                <div class="futuristic-card p-4" style="border-color: rgba(148, 163, 184, 0.2); background: rgba(148, 163, 184, 0.05);">
                                    <h4 class="h6 fw-bold mb-3" style="color: var(--text-primary);">Payment Method Details</h4>
                                    <div class="small" style="color: var(--text-secondary);">
                                        <p id="processing-fee" class="mb-2"></p>
                                        <p id="processing-time" class="mb-2"></p>
                                        <p id="verification-required" class="mb-0"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-neon">
                                        <i class="fas fa-credit-card me-2"></i>Reserve Payment Method
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Payment History -->
        @if($booking->payments && $booking->payments->count() > 0)
        <div class="futuristic-card" style="border-color: rgba(34, 197, 94, 0.3);">
            <div class="p-4 border-bottom" style="border-color: rgba(34, 197, 94, 0.2) !important;">
                <h3 class="h5 mb-0 fw-bold" style="color: #22c55e;">Payment History</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Payments made for this booking.</p>
            </div>
            <div class="p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: rgba(34, 197, 94, 0.05);">
                            <tr>
                                <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Payment Date</th>
                                <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Amount</th>
                                <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Method</th>
                                <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Status</th>
                                <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->payments as $payment)
                            <tr>
                                <td style="color: var(--text-primary);">
                                    {{ $payment->payment_date->format('M j, Y') }}
                                    @if($payment->reservation_expires_at)
                                        <br><small style="color: var(--text-secondary);">Expires: {{ $payment->reservation_expires_at->format('M j, Y H:i') }}</small>
                                    @endif
                                </td>
                                <td style="color: var(--text-primary);">
                                    ₱{{ number_format($payment->amount, 2) }}
                                </td>
                                <td style="color: var(--text-primary);">
                                    <div class="d-flex align-items-center">
                                        @if($payment->paymentMethod)
                                            <span>{{ $payment->paymentMethod->name }}</span>
                                        @else
                                            <span>{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</span>
                                        @endif
                                        @if($payment->verification_code)
                                            <br><small style="color: var(--text-secondary);">Code: {{ $payment->verification_code }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge px-3 py-1 rounded-pill" 
                                          style="@if($payment->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                          @elseif($payment->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                          @elseif($payment->status == 'reserved') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                          @elseif($payment->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                          @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($payment->status == 'reserved' && $payment->isReserved())
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('tenant.payments.complete', $payment) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm" style="color: #22c55e;" title="Complete">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('tenant.payments.cancel', $payment) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm" style="color: #ef4444;" title="Cancel">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($payment->status == 'reserved' && $payment->isExpired())
                                        <span style="color: #ef4444;">Expired</span>
                                    @else
                                        <span style="color: var(--text-secondary);">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const methodSelect = document.getElementById('method_id');
    const detailsDiv = document.getElementById('payment-method-details');
    const processingFee = document.getElementById('processing-fee');
    const processingTime = document.getElementById('processing-time');
    const verificationRequired = document.getElementById('verification-required');

    if (methodSelect) {
        methodSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (this.value) {
                const fee = selectedOption.dataset.fee;
                const time = selectedOption.dataset.time;
                const verification = selectedOption.dataset.verification;
                
                processingFee.textContent = `Processing Fee: ₱${parseFloat(fee).toFixed(2)}`;
                processingTime.textContent = `Processing Time: ${time} hours`;
                verificationRequired.textContent = `Verification Required: ${verification === 'yes' ? 'Yes' : 'No'}`;
                
                detailsDiv.classList.remove('d-none');
            } else {
                detailsDiv.classList.add('d-none');
            }
        });
    }
});
</script>
@endsection
