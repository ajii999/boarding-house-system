@extends('layouts.admin')

@section('title', 'Payment Management')
@section('page-title', 'Payment Management')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 1px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.12), rgba(124, 58, 237, 0.08), rgba(59, 130, 246, 0.06)); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px; backdrop-filter: blur(10px); position: relative; overflow: hidden;">
    <!-- Animated background glow -->
    <div style="position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(0, 102, 255, 0.2), transparent); border-radius: 50%; animation: pulse 4s ease-in-out infinite;"></div>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3" style="position: relative; z-index: 1;">
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff; text-shadow: 0 0 20px rgba(0, 102, 255, 0.3), 0 2px 4px rgba(0, 0, 0, 0.1); letter-spacing: -0.5px;">Payment Management</h1>
            <p class="mb-0 small" style="color: rgba(0, 102, 255, 0.8); font-weight: 500; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">Real-time payment tracking from tenants</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center gap-2 small" style="color: rgba(0, 102, 255, 0.8); font-weight: 500;">
                <div class="rounded-circle" style="width: 10px; height: 10px; background: #22c55e; box-shadow: 0 0 10px rgba(34, 197, 94, 0.6); animation: pulse 2s infinite;"></div>
                <span>Live Updates</span>
            </div>
            <a href="{{ route('admin.payments.create') }}" class="btn d-flex align-items-center" style="background: linear-gradient(135deg, #0066ff, #7c3aed); border: none; color: white; box-shadow: 0 4px 20px rgba(0, 102, 255, 0.4), 0 0 30px rgba(0, 102, 255, 0.2) inset; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 12px; transition: all 0.3s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 25px rgba(0, 102, 255, 0.5), 0 0 40px rgba(0, 102, 255, 0.3) inset';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0, 102, 255, 0.4), 0 0 30px rgba(0, 102, 255, 0.2) inset';">
                <i class="fas fa-plus me-2"></i>Add New Payment
            </a>
        </div>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="futuristic-card p-4 mb-4" style="border: 1px solid rgba(0, 102, 255, 0.25); background: linear-gradient(135deg, rgba(0, 102, 255, 0.08), rgba(124, 58, 237, 0.05)); box-shadow: 0 4px 20px rgba(0, 102, 255, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.05) inset; border-radius: 12px; backdrop-filter: blur(8px);">
    <form method="GET" action="{{ route('admin.payments.index') }}" class="d-flex flex-column flex-md-row justify-content-end align-items-end gap-3">
        <div class="w-100" style="max-width: 300px;">
            <label for="search" class="form-label small fw-semibold" style="color: #0066ff; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">Search</label>
            <div class="position-relative">
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       placeholder="Search by tenant name, amount, status, method..." 
                       class="form-control" style="background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(0, 102, 255, 0.3); border-radius: 10px; padding: 0.75rem 1rem 0.75rem 2.5rem; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0, 102, 255, 0.1) inset;" onfocus="this.style.borderColor='rgba(0, 102, 255, 0.6)'; this.style.boxShadow='0 2px 12px rgba(0, 102, 255, 0.2) inset, 0 0 0 3px rgba(0, 102, 255, 0.1)';" onblur="this.style.borderColor='rgba(0, 102, 255, 0.3)'; this.style.boxShadow='0 2px 8px rgba(0, 102, 255, 0.1) inset';">
                <div class="position-absolute top-50 start-0 translate-middle-y ms-3" style="color: rgba(0, 102, 255, 0.6); line-height: 1;">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
        <div style="max-width: 200px;">
            <label for="status" class="form-label small fw-semibold" style="color: #0066ff; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">Status</label>
            <select name="status" id="status" class="form-select" style="background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(0, 102, 255, 0.3); border-radius: 10px; padding: 0.75rem 1rem; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0, 102, 255, 0.1) inset;" onfocus="this.style.borderColor='rgba(0, 102, 255, 0.6)'; this.style.boxShadow='0 2px 12px rgba(0, 102, 255, 0.2) inset, 0 0 0 3px rgba(0, 102, 255, 0.1)';" onblur="this.style.borderColor='rgba(0, 102, 255, 0.3)'; this.style.boxShadow='0 2px 8px rgba(0, 102, 255, 0.1) inset';">
                <option value="">All Status</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
        </div>
        <div class="d-flex align-items-end gap-2">
            <button type="submit" class="btn d-flex align-items-center" style="background: linear-gradient(135deg, #0066ff, #7c3aed); border: none; color: white; box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 102, 255, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.3)';">
                <i class="fas fa-search me-1"></i>Search
            </button>
            <a href="{{ route('admin.payments.index') }}" class="btn d-flex align-items-center" style="background: rgba(0, 102, 255, 0.1); border: 1px solid rgba(0, 102, 255, 0.3); color: #0066ff; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0, 102, 255, 0.1);" onmouseover="this.style.background='rgba(0, 102, 255, 0.15)'; this.style.borderColor='rgba(0, 102, 255, 0.4)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(0, 102, 255, 0.1)'; this.style.borderColor='rgba(0, 102, 255, 0.3)'; this.style.transform='translateY(0)';">
                <i class="fas fa-times me-1"></i>Clear
            </a>
        </div>
    </form>
</div>

<!-- Payments Table -->
<div class="futuristic-card" style="border: 1px solid rgba(0, 102, 255, 0.25); background: linear-gradient(135deg, rgba(0, 102, 255, 0.05), rgba(124, 58, 237, 0.03)); box-shadow: 0 4px 20px rgba(0, 102, 255, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.05) inset; border-radius: 12px; backdrop-filter: blur(8px); overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.12), rgba(124, 58, 237, 0.08)); border-bottom: 2px solid rgba(0, 102, 255, 0.3);">
                <tr>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Tenant</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Amount</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Date</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Method</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Status</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Booking</th>
                    <th class="text-uppercase small fw-bold py-3 text-center" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr style="transition: all 0.3s ease; border-bottom: 1px solid rgba(0, 102, 255, 0.1);" onmouseover="this.style.background='rgba(0, 102, 255, 0.05)'; this.style.transform='scale(1.01)';" onmouseout="this.style.background='transparent'; this.style.transform='scale(1)';">
                    <td class="py-3" style="vertical-align: middle;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.15)); border: 2px solid rgba(0, 102, 255, 0.4); box-shadow: 0 4px 15px rgba(0, 102, 255, 0.2), 0 0 20px rgba(0, 102, 255, 0.1) inset; transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1) rotate(5deg)'; this.style.boxShadow='0 6px 20px rgba(0, 102, 255, 0.3), 0 0 30px rgba(0, 102, 255, 0.2) inset';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.2), 0 0 20px rgba(0, 102, 255, 0.1) inset';">
                                <i class="fas fa-user" style="color: #0066ff; text-shadow: 0 0 10px rgba(0, 102, 255, 0.5);"></i>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div class="fw-semibold" style="color: var(--text-primary); font-size: 0.95rem;">{{ $payment->tenant->name ?? 'N/A' }}</div>
                                <div class="small" style="color: rgba(0, 102, 255, 0.7); font-size: 0.8rem;">{{ $payment->tenant->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 fw-bold" style="color: #22c55e; text-shadow: 0 0 10px rgba(34, 197, 94, 0.3); vertical-align: middle; font-size: 1.05rem;">
                        ₱{{ number_format($payment->amount, 2) }}
                    </td>
                    <td class="py-3" style="color: var(--text-primary); font-weight: 500; vertical-align: middle;">
                        {{ $payment->payment_date ? $payment->payment_date->format('M j, Y') : 'N/A' }}
                    </td>
                    <td class="py-3" style="vertical-align: middle;">
                        <span class="badge px-3 py-2 rounded-pill d-inline-block" 
                              style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.15)); border: 1px solid rgba(0, 102, 255, 0.4); color: #0066ff; font-weight: 600; box-shadow: 0 2px 10px rgba(0, 102, 255, 0.2), 0 0 15px rgba(0, 102, 255, 0.1) inset;">
                            {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                        </span>
                    </td>
                    <td class="py-3" style="vertical-align: middle;">
                        <span class="badge px-3 py-2 rounded-pill" 
                              style="@if($payment->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e; box-shadow: 0 2px 10px rgba(34, 197, 94, 0.2), 0 0 15px rgba(34, 197, 94, 0.1) inset;
                              @elseif($payment->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b; box-shadow: 0 2px 10px rgba(245, 158, 11, 0.2), 0 0 15px rgba(245, 158, 11, 0.1) inset;
                              @elseif($payment->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; box-shadow: 0 2px 10px rgba(239, 68, 68, 0.2), 0 0 15px rgba(239, 68, 68, 0.1) inset;
                              @elseif($payment->status == 'refunded') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff; box-shadow: 0 2px 10px rgba(0, 102, 255, 0.2), 0 0 15px rgba(0, 102, 255, 0.1) inset;
                              @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; box-shadow: 0 2px 10px rgba(148, 163, 184, 0.2), 0 0 15px rgba(148, 163, 184, 0.1) inset; @endif font-weight: 600;">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td class="py-3" style="vertical-align: middle;">
                        @if($payment->booking)
                            <span class="badge px-3 py-2 rounded-pill d-inline-block" 
                                  style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.15)); border: 1px solid rgba(0, 102, 255, 0.4); color: #0066ff; font-weight: 600; box-shadow: 0 2px 10px rgba(0, 102, 255, 0.2), 0 0 15px rgba(0, 102, 255, 0.1) inset;">
                                Room {{ $payment->booking->room->room_number ?? 'N/A' }}
                            </span>
                        @else
                            <span class="small" style="color: rgba(0, 102, 255, 0.6);">N/A</span>
                        @endif
                    </td>
                    <td class="py-3 text-center" style="vertical-align: middle;">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; color: #0066ff; background: rgba(0, 102, 255, 0.1); border: 1px solid rgba(0, 102, 255, 0.3); box-shadow: 0 2px 8px rgba(0, 102, 255, 0.2); transition: all 0.3s ease; text-decoration: none;" title="View Details" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(0, 102, 255, 0.2)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.3), 0 0 20px rgba(0, 102, 255, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(0, 102, 255, 0.1)'; this.style.boxShadow='0 2px 8px rgba(0, 102, 255, 0.2)';">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($payment->status === 'pending')
                                <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="d-inline" onsubmit="return confirm('Verify this payment?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; color: #22c55e; background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); box-shadow: 0 2px 8px rgba(34, 197, 94, 0.2); transition: all 0.3s ease;" title="Verify Payment" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(34, 197, 94, 0.2)'; this.style.boxShadow='0 4px 15px rgba(34, 197, 94, 0.3), 0 0 20px rgba(34, 197, 94, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(34, 197, 94, 0.1)'; this.style.boxShadow='0 2px 8px rgba(34, 197, 94, 0.2)';">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="d-inline" onsubmit="return confirm('Reject this payment?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; color: #ef4444; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2); transition: all 0.3s ease;" title="Reject Payment" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(239, 68, 68, 0.2)'; this.style.boxShadow='0 4px 15px rgba(239, 68, 68, 0.3), 0 0 20px rgba(239, 68, 68, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(239, 68, 68, 0.1)'; this.style.boxShadow='0 2px 8px rgba(239, 68, 68, 0.2)';">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; color: #f59e0b; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2); transition: all 0.3s ease; text-decoration: none;" title="Edit Payment" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(245, 158, 11, 0.2)'; this.style.boxShadow='0 4px 15px rgba(245, 158, 11, 0.3), 0 0 20px rgba(245, 158, 11, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(245, 158, 11, 0.1)'; this.style.boxShadow='0 2px 8px rgba(245, 158, 11, 0.2)';">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this payment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; color: #ef4444; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2); transition: all 0.3s ease;" title="Delete Payment" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(239, 68, 68, 0.2)'; this.style.boxShadow='0 4px 15px rgba(239, 68, 68, 0.3), 0 0 20px rgba(239, 68, 68, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(239, 68, 68, 0.1)'; this.style.boxShadow='0 2px 8px rgba(239, 68, 68, 0.2)';">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                                 style="width: 100px; height: 100px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(124, 58, 237, 0.1)); border: 3px solid rgba(0, 102, 255, 0.4); box-shadow: 0 8px 30px rgba(0, 102, 255, 0.2), 0 0 40px rgba(0, 102, 255, 0.1) inset;">
                                <i class="fas fa-credit-card" style="font-size: 2.5rem; color: #0066ff; text-shadow: 0 0 20px rgba(0, 102, 255, 0.5);"></i>
                            </div>
                            <p class="mb-2" style="color: rgba(0, 102, 255, 0.8); font-weight: 500;">No payments found.</p>
                            <a href="{{ route('admin.payments.create') }}" class="btn d-flex align-items-center" style="background: linear-gradient(135deg, #0066ff, #7c3aed); border: none; color: white; box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 102, 255, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.3)';">
                                <i class="fas fa-plus me-2"></i>Add the first payment
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($payments->hasPages())
<div class="mt-4">
    {{ $payments->links() }}
</div>
@endif

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
</style>
@endsection
