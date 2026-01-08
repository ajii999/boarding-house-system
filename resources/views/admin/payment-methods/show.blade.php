@extends('layouts.admin')

@section('title', 'Payment Method Details')
@section('page-title', 'Payment Method Details')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff;">{{ $paymentMethod->name }}</h1>
                <p class="mb-0 small" style="color: var(--text-secondary);">Complete payment method details</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.payment-methods.edit', $paymentMethod) }}" class="btn" style="background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; border: none;">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Payment Method Information Card -->
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; 
                                @if($paymentMethod->type === 'digital_wallet') background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.08)); border: 2px solid rgba(34, 197, 94, 0.3);
                                @elseif($paymentMethod->type === 'bank_transfer') background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.3);
                                @elseif($paymentMethod->type === 'online') background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(124, 58, 237, 0.08)); border: 2px solid rgba(124, 58, 237, 0.3);
                                @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.15), rgba(148, 163, 184, 0.08)); border: 2px solid rgba(148, 163, 184, 0.3); @endif">
                        @if($paymentMethod->type === 'digital_wallet')
                            <i class="fas fa-mobile-alt" style="font-size: 1.5rem; color: #22c55e;"></i>
                        @elseif($paymentMethod->type === 'bank_transfer')
                            <i class="fas fa-university" style="font-size: 1.5rem; color: #0066ff;"></i>
                        @elseif($paymentMethod->type === 'online')
                            <i class="fas fa-credit-card" style="font-size: 1.5rem; color: #7c3aed;"></i>
                        @else
                            <i class="fas fa-money-bill-wave" style="font-size: 1.5rem; color: #94a3b8;"></i>
                        @endif
                    </div>
                    <div>
                        <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">{{ $paymentMethod->name }}</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">{{ ucfirst(str_replace('_', ' ', $paymentMethod->type)) }}</p>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Status</dt>
                        <dd>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($paymentMethod->is_active) background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; @endif">
                                {{ $paymentMethod->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Requires Verification</dt>
                        <dd style="color: var(--text-primary);">
                            @if($paymentMethod->requires_verification)
                                <span class="badge px-3 py-2 rounded-pill" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;">Yes</span>
                            @else
                                <span style="color: var(--text-secondary);">No</span>
                            @endif
                        </dd>
                    </div>
                    <div class="col-12">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Description</dt>
                        <dd style="color: var(--text-primary);">{{ $paymentMethod->description ?: 'No description provided' }}</dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Processing Fee</dt>
                        <dd class="fw-bold h5 mb-0" style="color: #22c55e;">₱{{ number_format($paymentMethod->processing_fee, 2) }}</dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Processing Time</dt>
                        <dd class="fw-bold" style="color: var(--text-primary);">{{ $paymentMethod->processing_time_hours }} hours</dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Created</dt>
                        <dd style="color: var(--text-primary);">{{ $paymentMethod->created_at->format('M d, Y H:i') }}</dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Last Updated</dt>
                        <dd style="color: var(--text-primary);">{{ $paymentMethod->updated_at->format('M d, Y H:i') }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    @if($paymentMethod->payments->count() > 0)
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Recent Payments</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Payments using this method</p>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: rgba(0, 102, 255, 0.05);">
                        <tr>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Amount</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Tenant</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Date</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentMethod->payments->take(10) as $payment)
                        <tr>
                            <td class="fw-bold" style="color: #22c55e;">₱{{ number_format($payment->amount, 2) }}</td>
                            <td style="color: var(--text-primary);">{{ $payment->tenant->first_name }} {{ $payment->tenant->last_name }}</td>
                            <td style="color: var(--text-primary);">{{ $payment->payment_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge px-3 py-1 rounded-pill" 
                                      style="@if($payment->status === 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                      @elseif($payment->status === 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @elseif($payment->status === 'reserved') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                      @elseif($payment->status === 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                      @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
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
@endsection
