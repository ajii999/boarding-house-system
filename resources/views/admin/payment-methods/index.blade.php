@extends('layouts.admin')

@section('title', 'Payment Methods')
@section('page-title', 'Payment Methods')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff;">Payment Methods</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Manage payment methods and processing settings</p>
        </div>
        <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-neon">
            <i class="fas fa-plus me-2"></i>Add Payment Method
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Payment Methods List -->
<div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background: rgba(0, 102, 255, 0.05);">
                <tr>
                    <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Method</th>
                    <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Type</th>
                    <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Status</th>
                    <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Processing Fee</th>
                    <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Processing Time</th>
                    <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paymentMethods as $method)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; 
                                        @if($method->type === 'digital_wallet') background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.08)); border: 2px solid rgba(34, 197, 94, 0.3);
                                        @elseif($method->type === 'bank_transfer') background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.3);
                                        @elseif($method->type === 'online') background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(124, 58, 237, 0.08)); border: 2px solid rgba(124, 58, 237, 0.3);
                                        @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.15), rgba(148, 163, 184, 0.08)); border: 2px solid rgba(148, 163, 184, 0.3); @endif">
                                @if($method->type === 'digital_wallet')
                                    <i class="fas fa-mobile-alt" style="color: #22c55e;"></i>
                                @elseif($method->type === 'bank_transfer')
                                    <i class="fas fa-university" style="color: #0066ff;"></i>
                                @elseif($method->type === 'online')
                                    <i class="fas fa-credit-card" style="color: #7c3aed;"></i>
                                @else
                                    <i class="fas fa-money-bill-wave" style="color: #94a3b8;"></i>
                                @endif
                            </div>
                            <div>
                                <div class="fw-semibold" style="color: var(--text-primary);">{{ $method->name }}</div>
                                @if($method->description)
                                    <div class="small" style="color: var(--text-secondary);">{{ Str::limit($method->description, 50) }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color: var(--text-primary);">
                        {{ ucfirst(str_replace('_', ' ', $method->type)) }}
                    </td>
                    <td>
                        <span class="badge px-3 py-2 rounded-pill" 
                              style="@if($method->is_active) background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                              @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; @endif">
                            {{ $method->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="fw-semibold" style="color: var(--text-primary);">
                        ₱{{ number_format($method->processing_fee, 2) }}
                    </td>
                    <td style="color: var(--text-primary);">
                        {{ $method->processing_time_hours }} hours
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('admin.payment-methods.show', $method) }}" class="btn btn-sm" style="color: #0066ff;" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.payment-methods.edit', $method) }}" class="btn btn-sm" style="color: #f59e0b;" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.payment-methods.destroy', $method) }}" 
                                  method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this payment method?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="color: #ef4444;" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                                <i class="fas fa-credit-card" style="font-size: 2rem; color: #0066ff;"></i>
                            </div>
                            <p class="mb-2" style="color: var(--text-secondary);">No payment methods found.</p>
                            <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-neon btn-sm">
                                <i class="fas fa-plus me-2"></i>Add the first payment method
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($paymentMethods->hasPages())
<div class="mt-4">
    {{ $paymentMethods->links() }}
</div>
@endif
@endsection
