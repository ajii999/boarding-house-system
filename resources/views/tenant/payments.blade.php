@extends('layouts.tenant')

@section('title', 'My Payments')
@section('page-title', 'My Payments')

@section('content')
<!-- Amount Due Alert -->
@if($tenantBalance > 0)
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(153, 27, 27, 0.8); background: linear-gradient(135deg, rgba(153, 27, 27, 0.8), rgba(185, 28, 28, 0.75)); box-shadow: 0 8px 32px rgba(153, 27, 27, 0.6);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <div class="rounded-circle d-flex align-items-center justify-content-center me-4" 
                 style="width: 80px; height: 80px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);">
                <i class="fas fa-exclamation-triangle" style="font-size: 2.5rem; color: white;"></i>
            </div>
            <div>
                <h2 class="h3 fw-bold mb-1" style="color: white; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">Payment Due</h2>
                <p class="mb-0" style="color: rgba(255, 255, 255, 0.95);">You have an outstanding balance that needs to be paid</p>
            </div>
        </div>
        <div class="text-center text-md-end">
            <p class="display-4 fw-bold mb-1" style="color: white; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">₱{{ number_format($tenantBalance, 2) }}</p>
            <p class="mb-0" style="color: rgba(255, 255, 255, 0.95);">Amount Due</p>
        </div>
    </div>
    <div class="mt-4 d-flex justify-content-end">
        <a href="{{ route('tenant.payments.create') }}" class="btn btn-light px-4 py-2 fw-semibold" style="box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);">
            <i class="fas fa-credit-card me-2"></i>Pay Now
        </a>
    </div>
</div>
@elseif($tenantBalance < 0)
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(34, 197, 94, 0.3); background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(16, 185, 129, 0.15));">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <div class="rounded-circle d-flex align-items-center justify-content-center me-4" 
                 style="width: 80px; height: 80px; background: rgba(255, 255, 255, 0.2); border: 2px solid rgba(255, 255, 255, 0.3);">
                <i class="fas fa-check-circle" style="font-size: 2.5rem; color: white;"></i>
            </div>
            <div>
                <h2 class="h3 fw-bold mb-1" style="color: white;">Credit Balance</h2>
                <p class="mb-0" style="color: rgba(255, 255, 255, 0.9);">You have a credit balance on your account</p>
            </div>
        </div>
        <div class="text-center text-md-end">
            <p class="display-4 fw-bold mb-1" style="color: white;">₱{{ number_format(abs($tenantBalance), 2) }}</p>
            <p class="mb-0" style="color: rgba(255, 255, 255, 0.9);">Credit Amount</p>
        </div>
    </div>
</div>
@else
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(34, 197, 94, 0.5); background: linear-gradient(135deg, #22c55e, #16a34a, #15803d); box-shadow: 0 8px 32px rgba(34, 197, 94, 0.4), 0 0 30px rgba(34, 197, 94, 0.3);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <div class="rounded-circle d-flex align-items-center justify-content-center me-4" 
                 style="width: 80px; height: 80px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);">
                <i class="fas fa-check-circle" style="font-size: 2.5rem; color: white;"></i>
            </div>
            <div>
                <h2 class="h3 fw-bold mb-1" style="color: white; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">Account Paid Up</h2>
                <p class="mb-0" style="color: rgba(255, 255, 255, 0.95);">Your account is current with no outstanding balance</p>
            </div>
        </div>
        <div class="text-center text-md-end">
            <p class="display-4 fw-bold mb-1" style="color: white; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">₱0.00</p>
            <p class="mb-0" style="color: rgba(255, 255, 255, 0.95);">Current Balance</p>
        </div>
    </div>
</div>
@endif

<!-- Payment Summary -->
<div class="futuristic-card outline-primary mb-4 mb-md-5">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="mb-3 mb-md-0">
                <h3 class="h5 fw-bold mb-1" style="color: #0066ff;">Payment Summary</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Overview of your payment history and status.</p>
            </div>
            <a href="{{ route('tenant.payments.create') }}" class="btn btn-neon">
                <i class="fas fa-plus me-2"></i>Add Payment
            </a>
        </div>
    </div>
    <div class="p-4">
        <div class="row g-3 g-md-4">
            <!-- Amount Due -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card p-4 h-100" 
                     style="@if($tenantBalance > 0) border-color: rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.05);
                     @elseif($tenantBalance < 0) border-color: rgba(34, 197, 94, 0.2); background: rgba(34, 197, 94, 0.05);
                     @else border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.05); @endif">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; @if($tenantBalance > 0) background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1)); border: 2px solid rgba(239, 68, 68, 0.3);
                             @elseif($tenantBalance < 0) background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.3);
                             @else background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(0, 102, 255, 0.1)); border: 2px solid rgba(0, 102, 255, 0.3); @endif">
                            <i class="fas @if($tenantBalance > 0) fa-exclamation-triangle @elseif($tenantBalance < 0) fa-check-circle @else fa-wallet @endif" 
                               style="font-size: 1.5rem; @if($tenantBalance > 0) color: #ef4444; @elseif($tenantBalance < 0) color: #22c55e; @else color: #0066ff; @endif"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">
                                @if($tenantBalance > 0)
                                    Amount Due
                                @elseif($tenantBalance < 0)
                                    Credit Balance
                                @else
                                    Current Balance
                                @endif
                            </p>
                            <p class="h4 fw-bold mb-0" 
                               style="@if($tenantBalance > 0) color: #ef4444;
                               @elseif($tenantBalance < 0) color: #22c55e;
                               @else color: #0066ff; @endif">
                                ₱{{ number_format(abs($tenantBalance), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card outline-success p-4 h-100" style="background: rgba(34, 197, 94, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.3);">
                            <i class="fas fa-check-circle" style="font-size: 1.5rem; color: #22c55e;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Completed Payments</p>
                            <p class="h4 fw-bold mb-0" style="color: #22c55e;">{{ $payments->where('status', 'completed')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card outline-warning p-4 h-100" style="background: rgba(245, 158, 11, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.1)); border: 2px solid rgba(245, 158, 11, 0.3);">
                            <i class="fas fa-clock" style="font-size: 1.5rem; color: #f59e0b;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Pending Payments</p>
                            <p class="h4 fw-bold mb-0" style="color: #f59e0b;">{{ $payments->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card outline-info p-4 h-100" style="background: rgba(0, 212, 255, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.3);">
                            <i class="fas fa-dollar-sign" style="font-size: 1.5rem; color: #00d4ff;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Total Paid</p>
                            <p class="h4 fw-bold mb-0" style="color: #00d4ff;">₱{{ number_format($payments->where('status', 'completed')->sum('amount'), 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment History -->
<div class="futuristic-card" style="border-color: rgba(34, 197, 94, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(34, 197, 94, 0.2) !important;">
        <h3 class="h5 mb-0 fw-bold" style="color: #22c55e;">Payment History</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">All your payment transactions and their details.</p>
    </div>
    <div class="p-0">
        @if($payments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: rgba(34, 197, 94, 0.05);">
                        <tr>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Date</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Room</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Amount</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Method</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Status</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Notes</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td style="color: var(--text-primary);">
                                {{ $payment->payment_date->format('M j, Y') }}
                            </td>
                            <td>
                                @if($payment->booking && $payment->booking->room)
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-bed me-2" style="color: #0066ff;"></i>
                                        <span style="color: var(--text-primary);">Room {{ $payment->booking->room->room_number }}</span>
                                    </div>
                                @else
                                    <span style="color: var(--text-secondary);">N/A</span>
                                @endif
                            </td>
                            <td style="color: var(--text-primary);">
                                <span class="fw-semibold">₱{{ number_format($payment->amount, 2) }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($payment->method == 'gcash')
                                        <i class="fas fa-mobile-alt me-2" style="color: #22c55e;"></i>
                                        <span style="color: var(--text-primary);">Gcash</span>
                                    @elseif($payment->method == 'paymaya')
                                        <i class="fas fa-mobile-alt me-2" style="color: #0066ff;"></i>
                                        <span style="color: var(--text-primary);">Paymaya</span>
                                    @else
                                        <i class="fas fa-wallet me-2" style="color: var(--text-secondary);"></i>
                                        <span style="color: var(--text-primary);">{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge px-3 py-1 rounded-pill" 
                                      style="@if($payment->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                      @elseif($payment->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @elseif($payment->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                      @elseif($payment->status == 'cancelled') background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8;
                                      @else background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(0, 212, 255, 0.2)); border: 1px solid rgba(0, 212, 255, 0.5); color: #00d4ff; @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ $payment->notes ?: 'N/A' }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('tenant.payments.show', $payment) }}" class="btn btn-sm" style="color: #0066ff;" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm" style="color: #f59e0b;" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm" style="color: #ef4444;" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($payments->hasPages())
            <div class="p-4 border-top" style="border-color: rgba(34, 197, 94, 0.2) !important;">
                {{ $payments->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; background: rgba(34, 197, 94, 0.1); border: 2px solid rgba(34, 197, 94, 0.3);">
                    <i class="fas fa-credit-card" style="font-size: 2rem; color: #22c55e;"></i>
                </div>
                <h3 class="h5 fw-semibold mb-2" style="color: var(--text-primary);">No Payments Found</h3>
                <p class="mb-0" style="color: var(--text-secondary);">You haven't made any payments yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
