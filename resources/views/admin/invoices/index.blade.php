@extends('layouts.admin')

@section('title', 'Invoice Management')
@section('page-title', 'Invoice Management')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px; position: relative; overflow: hidden;">
    <!-- Animated background glow -->
    <div style="position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent); border-radius: 50%; animation: pulse 4s ease-in-out infinite;"></div>
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3" style="position: relative; z-index: 1;">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'; this.style.background='rgba(255, 255, 255, 0.35)'; this.style.boxShadow='0 6px 20px rgba(255, 255, 255, 0.3)';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(255, 255, 255, 0.25)'; this.style.boxShadow='0 4px 15px rgba(255, 255, 255, 0.2)';">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); letter-spacing: -0.5px;">Invoice Management</h1>
                <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.9); font-weight: 500;">Manage all invoices in your boarding house</p>
            </div>
        </div>
        <a href="{{ route('admin.invoices.create') }}" class="btn d-flex align-items-center" style="background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 12px; transition: all 0.3s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-2px)'; this.style.background='rgba(255, 255, 255, 0.35)'; this.style.boxShadow='0 6px 25px rgba(255, 255, 255, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(255, 255, 255, 0.2)';">
            <i class="fas fa-plus me-2"></i>Create New Invoice
        </a>
    </div>
</div>

<!-- Invoices Table -->
<div class="futuristic-card" style="border: 1px solid rgba(0, 102, 255, 0.25); background: linear-gradient(135deg, rgba(0, 102, 255, 0.05), rgba(124, 58, 237, 0.03)); box-shadow: 0 4px 20px rgba(0, 102, 255, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.05) inset; border-radius: 12px; backdrop-filter: blur(8px); overflow: hidden;">
    <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
        <table class="table table-hover mb-0" style="font-size: 0.875rem; width: 100%;">
            <thead style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.12), rgba(124, 58, 237, 0.08)); border-bottom: 2px solid rgba(0, 102, 255, 0.3);">
                <tr>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">#</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Tenant</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Amount</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Date</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Due Date</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Status</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Payment</th>
                    <th class="text-uppercase small fw-bold py-2 px-2 text-center" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr style="transition: all 0.3s ease; border-bottom: 1px solid rgba(0, 102, 255, 0.1);" onmouseover="this.style.background='rgba(0, 102, 255, 0.05)'; this.style.transform='scale(1.01)';" onmouseout="this.style.background='transparent'; this.style.transform='scale(1)';">
                    <td class="py-2 px-2 fw-semibold" style="color: #0066ff; text-shadow: 0 0 8px rgba(0, 102, 255, 0.3); vertical-align: middle; white-space: nowrap; font-size: 0.85rem;">
                        #{{ $invoice->invoice_id }}
                    </td>
                    <td class="py-2 px-2" style="vertical-align: middle;">
                        <div class="d-flex align-items-center gap-1">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                 style="width: 32px; height: 32px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.15)); border: 2px solid rgba(0, 102, 255, 0.4); box-shadow: 0 4px 15px rgba(0, 102, 255, 0.2), 0 0 20px rgba(0, 102, 255, 0.1) inset; transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1) rotate(5deg)'; this.style.boxShadow='0 6px 20px rgba(0, 102, 255, 0.3), 0 0 30px rgba(0, 102, 255, 0.2) inset';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.2), 0 0 20px rgba(0, 102, 255, 0.1) inset';">
                                <i class="fas fa-user" style="color: #0066ff; text-shadow: 0 0 10px rgba(0, 102, 255, 0.5); font-size: 0.75rem;"></i>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div class="fw-semibold" style="color: var(--text-primary); font-size: 0.8rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px;">{{ $invoice->tenant->name ?? 'N/A' }}</div>
                                <div class="small" style="color: rgba(0, 102, 255, 0.7); font-size: 0.7rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px;">{{ $invoice->tenant->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-2 px-2 fw-bold" style="color: #22c55e; text-shadow: 0 0 10px rgba(34, 197, 94, 0.3); vertical-align: middle; font-size: 0.85rem; white-space: nowrap;">
                        ₱{{ number_format($invoice->amount, 2) }}
                    </td>
                    <td class="py-2 px-2" style="color: var(--text-primary); font-weight: 500; vertical-align: middle; white-space: nowrap; font-size: 0.8rem;">
                        {{ $invoice->date ? $invoice->date->format('M j, Y') : 'N/A' }}
                    </td>
                    <td class="py-2 px-2" style="color: var(--text-primary); font-weight: 500; vertical-align: middle; white-space: nowrap; font-size: 0.8rem;">
                        {{ $invoice->due_date ? $invoice->due_date->format('M j, Y') : 'N/A' }}
                    </td>
                    <td class="py-2 px-2" style="vertical-align: middle;">
                        <span class="badge px-2 py-1 rounded-pill" 
                              style="@if($invoice->status == 'paid') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e; box-shadow: 0 2px 10px rgba(34, 197, 94, 0.2), 0 0 15px rgba(34, 197, 94, 0.1) inset;
                              @elseif($invoice->status == 'sent') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff; box-shadow: 0 2px 10px rgba(0, 102, 255, 0.2), 0 0 15px rgba(0, 102, 255, 0.1) inset;
                              @elseif($invoice->status == 'overdue') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; box-shadow: 0 2px 10px rgba(239, 68, 68, 0.2), 0 0 15px rgba(239, 68, 68, 0.1) inset;
                              @elseif($invoice->status == 'draft') background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; box-shadow: 0 2px 10px rgba(148, 163, 184, 0.2), 0 0 15px rgba(148, 163, 184, 0.1) inset;
                              @elseif($invoice->status == 'cancelled') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; box-shadow: 0 2px 10px rgba(239, 68, 68, 0.2), 0 0 15px rgba(239, 68, 68, 0.1) inset;
                              @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; box-shadow: 0 2px 10px rgba(148, 163, 184, 0.2), 0 0 15px rgba(148, 163, 184, 0.1) inset; @endif font-weight: 600; font-size: 0.7rem; white-space: nowrap;">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td class="py-2 px-2" style="vertical-align: middle;">
                        @if($invoice->payment)
                            <span class="badge px-2 py-1 rounded-pill" 
                                  style="@if($invoice->payment->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e; box-shadow: 0 2px 10px rgba(34, 197, 94, 0.2), 0 0 15px rgba(34, 197, 94, 0.1) inset;
                                  @elseif($invoice->payment->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b; box-shadow: 0 2px 10px rgba(245, 158, 11, 0.2), 0 0 15px rgba(245, 158, 11, 0.1) inset;
                                  @elseif($invoice->payment->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; box-shadow: 0 2px 10px rgba(239, 68, 68, 0.2), 0 0 15px rgba(239, 68, 68, 0.1) inset;
                                  @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; box-shadow: 0 2px 10px rgba(148, 163, 184, 0.2), 0 0 15px rgba(148, 163, 184, 0.1) inset; @endif font-weight: 600; font-size: 0.7rem; white-space: nowrap;">
                                {{ ucfirst($invoice->payment->status) }}
                            </span>
                        @else
                            <span class="small" style="color: rgba(0, 102, 255, 0.6); font-size: 0.7rem;">No Payment</span>
                        @endif
                    </td>
                    <td class="py-2 px-2 text-center" style="vertical-align: middle;">
                        <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; color: #0066ff; background: rgba(0, 102, 255, 0.1); border: 1px solid rgba(0, 102, 255, 0.3); box-shadow: 0 2px 8px rgba(0, 102, 255, 0.2); transition: all 0.3s ease; text-decoration: none; font-size: 0.7rem;" title="View Details" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(0, 102, 255, 0.2)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.3), 0 0 20px rgba(0, 102, 255, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(0, 102, 255, 0.1)'; this.style.boxShadow='0 2px 8px rgba(0, 102, 255, 0.2)';">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; color: #f59e0b; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2); transition: all 0.3s ease; text-decoration: none; font-size: 0.7rem;" title="Edit Invoice" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(245, 158, 11, 0.2)'; this.style.boxShadow='0 4px 15px rgba(245, 158, 11, 0.3), 0 0 20px rgba(245, 158, 11, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(245, 158, 11, 0.1)'; this.style.boxShadow='0 2px 8px rgba(245, 158, 11, 0.2)';">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.invoices.destroy', $invoice) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this invoice?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; color: #ef4444; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2); transition: all 0.3s ease; font-size: 0.7rem;" title="Delete Invoice" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(239, 68, 68, 0.2)'; this.style.boxShadow='0 4px 15px rgba(239, 68, 68, 0.3), 0 0 20px rgba(239, 68, 68, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(239, 68, 68, 0.1)'; this.style.boxShadow='0 2px 8px rgba(239, 68, 68, 0.2)';">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                                 style="width: 100px; height: 100px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(124, 58, 237, 0.1)); border: 3px solid rgba(0, 102, 255, 0.4); box-shadow: 0 8px 30px rgba(0, 102, 255, 0.2), 0 0 40px rgba(0, 102, 255, 0.1) inset;">
                                <i class="fas fa-file-invoice" style="font-size: 2.5rem; color: #0066ff; text-shadow: 0 0 20px rgba(0, 102, 255, 0.5);"></i>
                            </div>
                            <p class="mb-2" style="color: rgba(0, 102, 255, 0.8); font-weight: 500;">No invoices found.</p>
                            <a href="{{ route('admin.invoices.create') }}" class="btn d-flex align-items-center" style="background: linear-gradient(135deg, #0066ff, #7c3aed); border: none; color: white; box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 102, 255, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.3)';">
                                <i class="fas fa-plus me-2"></i>Create the first invoice
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($invoices->hasPages())
<div class="mt-4">
    {{ $invoices->links() }}
</div>
@endif

<style>
@keyframes pulse {
    0%, 100% {
        opacity: 0.5;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.1);
    }
}
</style>
@endsection
