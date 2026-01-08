@extends('layouts.tenant')

@section('title', 'My Invoices')
@section('page-title', 'My Invoices')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 212, 255, 0.3); background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <div class="rounded d-flex align-items-center justify-content-center" 
             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.5);">
            <i class="fas fa-file-invoice" style="color: #00d4ff;"></i>
        </div>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #00d4ff;">My Invoices</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">View and manage your invoices and payment history</p>
        </div>
    </div>
</div>

<!-- Balance & Payment Summary -->
<div class="futuristic-card mb-4 mb-md-5" style="border-color: rgba(0, 102, 255, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
        <h3 class="h5 fw-bold mb-1" style="color: #0066ff;">Account Balance & Payment Summary</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">Your current balance and payment information.</p>
    </div>
    <div class="p-4">
        <div class="row g-3 g-md-4">
            <!-- Current Balance -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card p-4 h-100" 
                     style="@if($tenantBalance >= 0) border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.05);
                     @else border-color: rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.05); @endif">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; @if($tenantBalance >= 0) background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(0, 102, 255, 0.1)); border: 2px solid rgba(0, 102, 255, 0.3);
                             @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1)); border: 2px solid rgba(239, 68, 68, 0.3); @endif">
                            <i class="fas fa-wallet" style="font-size: 1.5rem; @if($tenantBalance >= 0) color: #0066ff; @else color: #ef4444; @endif"></i>
                        </div>
                        <div>
                            <p class="small fw-semibold mb-1" style="color: var(--text-secondary);">Current Balance</p>
                            <p class="h4 fw-bold mb-0" style="@if($tenantBalance >= 0) color: #0066ff; @else color: #ef4444; @endif">
                                ₱{{ number_format(abs($tenantBalance), 2) }}
                                @if($tenantBalance < 0)
                                    <span class="small" style="color: #ef4444;">(Overdue)</span>
                                @elseif($tenantBalance > 0)
                                    <span class="small" style="color: #f59e0b;">(Outstanding)</span>
                                @else
                                    <span class="small" style="color: #22c55e;">(Paid Up)</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card p-4 h-100" style="border-color: rgba(0, 212, 255, 0.2); background: rgba(0, 212, 255, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.3);">
                            <i class="fas fa-file-invoice" style="font-size: 1.5rem; color: #00d4ff;"></i>
                        </div>
                        <div>
                            <p class="small fw-semibold mb-1" style="color: var(--text-secondary);">Total Invoices</p>
                            <p class="h4 fw-bold mb-0" style="color: #00d4ff;">{{ $invoices->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card p-4 h-100" style="border-color: rgba(34, 197, 94, 0.2); background: rgba(34, 197, 94, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.3);">
                            <i class="fas fa-check-circle" style="font-size: 1.5rem; color: #22c55e;"></i>
                        </div>
                        <div>
                            <p class="small fw-semibold mb-1" style="color: var(--text-secondary);">Paid Invoices</p>
                            <p class="h4 fw-bold mb-0" style="color: #22c55e;">{{ $invoices->where('status', 'paid')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card p-4 h-100" style="border-color: rgba(245, 158, 11, 0.2); background: rgba(245, 158, 11, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.1)); border: 2px solid rgba(245, 158, 11, 0.3);">
                            <i class="fas fa-clock" style="font-size: 1.5rem; color: #f59e0b;"></i>
                        </div>
                        <div>
                            <p class="small fw-semibold mb-1" style="color: var(--text-secondary);">Pending Invoices</p>
                            <p class="h4 fw-bold mb-0" style="color: #f59e0b;">{{ $invoices->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Payments Section -->
@if($recentPayments->count() > 0)
<div class="futuristic-card mb-4 mb-md-5" style="border-color: rgba(34, 197, 94, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(34, 197, 94, 0.2) !important;">
        <h3 class="h5 fw-bold mb-1" style="color: #22c55e;">Recent Payments</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">Your latest payment transactions for reference.</p>
    </div>
    <div class="p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background: rgba(34, 197, 94, 0.05);">
                    <tr>
                        <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Payment #</th>
                        <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Date</th>
                        <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Amount</th>
                        <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Method</th>
                        <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Room</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPayments as $payment)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-credit-card me-2" style="color: #0066ff;"></i>
                                <span class="font-monospace" style="color: var(--text-primary);">#{{ str_pad($payment->payment_id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </td>
                        <td style="color: var(--text-primary);">
                            {{ $payment->payment_date->format('M j, Y') }}
                        </td>
                        <td>
                            <span class="fw-semibold" style="color: #22c55e;">₱{{ number_format($payment->amount, 2) }}</span>
                        </td>
                        <td>
                            <span class="badge px-3 py-1 rounded-pill" style="background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(0, 212, 255, 0.2)); border: 1px solid rgba(0, 212, 255, 0.5); color: #00d4ff;">
                                {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                            </span>
                        </td>
                        <td style="color: var(--text-primary);">
                            @if($payment->booking && $payment->booking->room)
                                Room {{ $payment->booking->room->room_number }}
                            @else
                                <span style="color: var(--text-secondary);">N/A</span>
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

<!-- Invoice List -->
<div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
        <h3 class="h5 fw-bold mb-1" style="color: #0066ff;">Invoice History</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">All your invoices and their payment status.</p>
    </div>
    <div class="p-0">
        @if($invoices->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: rgba(0, 102, 255, 0.05);">
                        <tr>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Invoice #</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Date</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Due Date</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Amount</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Status</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-invoice me-2" style="color: #0066ff;"></i>
                                    <span class="font-monospace" style="color: var(--text-primary);">#{{ str_pad($invoice->invoice_id, 6, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ $invoice->date->format('M j, Y') }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span style="color: var(--text-primary);">{{ $invoice->due_date->format('M j, Y') }}</span>
                                    @if($invoice->due_date->isPast() && $invoice->status != 'paid')
                                        <i class="fas fa-exclamation-triangle ms-2" style="color: #ef4444;" title="Overdue"></i>
                                    @endif
                                </div>
                            </td>
                            <td style="color: var(--text-primary);">
                                <span class="fw-semibold">₱{{ number_format($invoice->amount, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge px-3 py-1 rounded-pill" 
                                      style="@if($invoice->status == 'paid') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                      @elseif($invoice->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @elseif($invoice->status == 'overdue') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                      @elseif($invoice->status == 'cancelled') background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8;
                                      @else background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(0, 212, 255, 0.2)); border: 1px solid rgba(0, 212, 255, 0.5); color: #00d4ff; @endif">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td>
                                @if($invoice->payment)
                                    <div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-check-circle me-2" style="color: #22c55e;"></i>
                                            <span class="fw-semibold" style="color: #22c55e;">Paid</span>
                                        </div>
                                        <div class="small" style="color: var(--text-secondary);">
                                            <div>Method: {{ ucfirst(str_replace('_', ' ', $invoice->payment->method)) }}</div>
                                            <div>Date: {{ $invoice->payment->payment_date->format('M j, Y') }}</div>
                                            <div>Amount: ₱{{ number_format($invoice->payment->amount, 2) }}</div>
                                            @if($invoice->payment->receipt_image)
                                                <div class="mt-2 d-flex gap-2">
                                                    @php
                                                        $tenantInvoiceReceiptUrl = route('payments.receipt', ['payment' => $invoice->payment->payment_id]);
                                                    @endphp
                                                    <button onclick="openReceiptModal('{{ $tenantInvoiceReceiptUrl }}')" 
                                                            class="btn btn-sm" style="background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 1px solid rgba(0, 212, 255, 0.3); color: #00d4ff;">
                                                        <i class="fas fa-eye me-1"></i>View Receipt
                                                    </button>
                                                    <a href="{{ $tenantInvoiceReceiptUrl }}" download 
                                                       class="btn btn-sm" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 1px solid rgba(34, 197, 94, 0.3); color: #22c55e;">
                                                        <i class="fas fa-download me-1"></i>Download
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-times-circle me-2" style="color: #ef4444;"></i>
                                        <span class="fw-semibold" style="color: #ef4444;">Unpaid</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($invoices->hasPages())
            <div class="p-4 border-top" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                {{ $invoices->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                    <i class="fas fa-file-invoice" style="font-size: 2rem; color: #0066ff;"></i>
                </div>
                <h3 class="h5 fw-semibold mb-2" style="color: var(--text-primary);">No Invoices Found</h3>
                <p class="mb-0" style="color: var(--text-secondary);">You don't have any invoices yet.</p>
            </div>
        @endif
    </div>
</div>

<!-- Invoice Details Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content futuristic-card" style="border: none;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(0, 102, 255, 0.2);">
                <h5 class="modal-title fw-bold" style="color: #0066ff;">Invoice Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="color: var(--text-secondary);">Invoice details will be displayed here.</p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(0, 102, 255, 0.2);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg" id="receiptModalDialog">
        <div class="modal-content futuristic-card" style="border-color: rgba(34, 197, 94, 0.3); background: white !important;">
            <div class="modal-header border-bottom" style="border-color: rgba(34, 197, 94, 0.2) !important; background: white !important;">
                <h5 class="modal-title fw-bold" style="color: #22c55e;">Payment Receipt</h5>
                <button type="button" class="btn-close" onclick="closeReceiptModal()" aria-label="Close" style="z-index: 1000; position: relative; pointer-events: auto;"></button>
            </div>
            <div class="modal-body text-center p-4" style="background: white;">
                <img id="receiptModalImage" src="" alt="Payment Receipt" class="img-fluid rounded shadow" style="max-width: 100%; max-height: 70vh; object-fit: contain; filter: none !important; -webkit-filter: none !important;">
            </div>
            <div class="modal-footer border-top" style="border-color: rgba(34, 197, 94, 0.2) !important; background: white !important;">
                <a id="receiptDownloadLink" href="" download class="btn btn-neon" style="z-index: 1000; position: relative; pointer-events: auto;">
                    <i class="fas fa-download me-2"></i>Download Receipt
                </a>
                <button type="button" class="btn btn-secondary" onclick="closeReceiptModal()" style="z-index: 1000; position: relative; pointer-events: auto;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Hide modal backdrop completely */
.modal-backdrop {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
}

.modal-backdrop.show {
    display: none !important;
}

#receiptModal {
    background: transparent !important;
    z-index: 1055 !important;
}

#receiptModal.show {
    background: transparent !important;
    display: block !important;
    pointer-events: none !important;
}

#receiptModalDialog {
    z-index: 1056 !important;
    position: fixed !important;
    right: 2rem !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    margin: 0 !important;
    pointer-events: auto !important;
    max-width: 60% !important;
}

#receiptModal .modal-content {
    z-index: 1057 !important;
    position: relative;
    pointer-events: auto !important;
    background: white !important;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;
}

/* Ensure all modal elements are clickable */
#receiptModal button,
#receiptModal .btn-close,
#receiptModal a,
#receiptModal img {
    pointer-events: auto !important;
    position: relative;
    z-index: 1058 !important;
}

/* Ensure body doesn't get locked */
body.modal-open {
    overflow: auto !important;
    padding-right: 0 !important;
}
</style>

@push('scripts')
<script>
let receiptModalInstance = null;

function openReceiptModal(imageUrl) {
    const modalElement = document.getElementById('receiptModal');
    const modalImage = document.getElementById('receiptModalImage');
    const downloadLink = document.getElementById('receiptDownloadLink');
    
    modalImage.src = imageUrl;
    downloadLink.href = imageUrl;
    
    // Remove any existing modal instances
    const existingModal = bootstrap.Modal.getInstance(modalElement);
    if (existingModal) {
        existingModal.dispose();
    }
    
    // Create new modal instance with no backdrop
    receiptModalInstance = new bootstrap.Modal(modalElement, {
        backdrop: false,
        keyboard: true,
        focus: true
    });
    
    receiptModalInstance.show();
    
    // Remove backdrop after modal is shown
    modalElement.addEventListener('shown.bs.modal', function() {
        // Remove any backdrops that Bootstrap might have created
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.style.display = 'none';
            backdrop.remove();
        });
        
        // Remove modal-open class and restore body styles
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Ensure modal is properly configured
        modalElement.style.zIndex = '1055';
        modalElement.style.display = 'block';
        modalElement.style.pointerEvents = 'none';
        modalElement.style.background = 'transparent';
        
        const modalDialog = modalElement.querySelector('.modal-dialog');
        if (modalDialog) {
            modalDialog.style.zIndex = '1056';
            modalDialog.style.pointerEvents = 'auto';
        }
        
        const modalContent = modalElement.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.zIndex = '1057';
            modalContent.style.pointerEvents = 'auto';
        }
    }, { once: true });
}

function closeReceiptModal() {
    if (receiptModalInstance) {
        receiptModalInstance.hide();
    }
    
    // Clean up any remaining backdrops
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(backdrop => {
        backdrop.remove();
    });
    
    // Restore body styles
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeReceiptModal();
    }
});

// Close modal when clicking outside (on the modal itself, not backdrop)
document.getElementById('receiptModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeReceiptModal();
    }
});

// Remove any backdrop that Bootstrap might create using MutationObserver
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.addedNodes.length) {
            mutation.addedNodes.forEach(function(node) {
                if (node.classList && node.classList.contains('modal-backdrop')) {
                    node.remove();
                }
            });
        }
    });
});

observer.observe(document.body, {
    childList: true,
    subtree: true
});

function viewInvoice(invoiceId) {
    const modal = new bootstrap.Modal(document.getElementById('invoiceModal'));
    modal.show();
    console.log('View invoice:', invoiceId);
}

function payInvoice(invoiceId) {
    alert('Payment functionality will be implemented here for invoice #' + invoiceId);
}

function downloadInvoice(invoiceId) {
    alert('Download functionality will be implemented here for invoice #' + invoiceId);
}
</script>
@endpush
@endsection
