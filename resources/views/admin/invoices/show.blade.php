@extends('layouts.admin')

@section('title', 'Invoice Details')
@section('page-title', 'Invoice Details')

@push('styles')
<style>
    /* Override admin layout background for invoice page - white background */
    body {
        background: #ffffff !important;
    }
    
    body::before {
        display: none !important;
    }
    
    /* Make main content area white */
    .main-content-wrapper {
        background: #ffffff;
    }
    
    /* Normal card styling - simple white cards */
    .card {
        background: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }
    
    .card-header {
        background: #ffffff !important;
        border-bottom: 1px solid #e5e7eb !important;
    }
    
    /* Normal text colors */
    .card h3,
    .card h4,
    .card h5,
    .card-header h3,
    .card-header h4,
    .card-header h5 {
        color: #1f2937 !important;
    }
    
    .card p,
    .card span,
    .card div,
    .card-header p,
    .card-header span {
        color: #4b5563 !important;
    }
    
    /* Remove gradients from header */
    .futuristic-header {
        background: #ffffff !important;
        border-bottom: 1px solid #e5e7eb !important;
    }
    
    /* Simple button styling */
    .btn-neon {
        background: #0066ff !important;
        color: white !important;
        box-shadow: none !important;
    }
    
    .btn-neon:hover {
        background: #0052cc !important;
        transform: none !important;
    }
    
    /* Normal text colors for main content */
    main {
        background: #ffffff !important;
    }
</style>
@endpush

@section('content')
<!-- Header Section -->
<div class="mb-4 mb-md-5 p-4 p-md-5" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.invoices') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff;">Invoice #{{ $invoice->invoice_id }}</h1>
                <p class="mb-0 small" style="color: var(--text-secondary);">Complete invoice details and related information</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn" style="background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; border: none;">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Invoice Information Card -->
    <div class="col-12">
        <div class="card" style="background: #ffffff; border: 1px solid #e5e7eb;">
            <div class="card-header p-4 border-bottom" style="border-color: #e5e7eb !important; background: #ffffff;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Invoice Information</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Complete invoice details</p>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Invoice ID</dt>
                        <dd class="fw-bold" style="color: var(--text-primary);">#{{ $invoice->invoice_id }}</dd>
                    </div>
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Amount</dt>
                        <dd class="fw-bold h4 mb-0" style="color: #22c55e;">₱{{ number_format($invoice->amount, 2) }}</dd>
                    </div>
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Status</dt>
                        <dd>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($invoice->status == 'paid') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($invoice->status == 'sent') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                  @elseif($invoice->status == 'overdue') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                  @elseif($invoice->status == 'draft') background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8;
                                  @elseif($invoice->status == 'cancelled') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                  @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Invoice Date</dt>
                        <dd style="color: var(--text-primary);">{{ $invoice->date ? $invoice->date->format('F j, Y') : 'N/A' }}</dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Due Date</dt>
                        <dd style="color: var(--text-primary);">{{ $invoice->due_date ? $invoice->due_date->format('F j, Y') : 'N/A' }}</dd>
                    </div>
                    @if($invoice->notes)
                    <div class="col-12">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Notes</dt>
                        <dd style="color: var(--text-primary);">{{ $invoice->notes }}</dd>
                    </div>
                    @endif
                    <div class="col-12">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Created</dt>
                        <dd style="color: var(--text-primary);">{{ $invoice->created_at->format('F j, Y \a\t g:i A') }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tenant Information -->
    @if($invoice->tenant)
    <div class="col-12 col-md-6">
        <div class="card h-100" style="background: #ffffff; border: 1px solid #e5e7eb;">
            <div class="card-header p-4 border-bottom" style="border-color: #e5e7eb !important; background: #ffffff;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Tenant Information</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Details of the tenant</p>
            </div>
            <div class="p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.3);">
                        <i class="fas fa-user" style="font-size: 1.5rem; color: #0066ff;"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="color: var(--text-primary);">{{ $invoice->tenant->name }}</div>
                        <div class="small" style="color: var(--text-secondary);">{{ $invoice->tenant->email }}</div>
                    </div>
                </div>
                <div class="small" style="color: var(--text-primary);">
                    <i class="fas fa-phone me-2" style="color: var(--text-secondary);"></i>{{ $invoice->tenant->contact_number }}
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment Information -->
    @if($invoice->payment)
    <div class="col-12 col-md-6">
        <div class="card h-100" style="background: #ffffff; border: 1px solid #e5e7eb;">
            <div class="card-header p-4 border-bottom" style="border-color: #e5e7eb !important; background: #ffffff;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Related Payment</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Payment information</p>
            </div>
            <div class="p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.08)); border: 2px solid rgba(34, 197, 94, 0.3);">
                        <i class="fas fa-credit-card" style="font-size: 1.5rem; color: #22c55e;"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="color: var(--text-primary);">Payment #{{ $invoice->payment->payment_id }}</div>
                        <div class="small" style="color: var(--text-secondary);">Payment Details</div>
                    </div>
                </div>
                <div class="mb-2">
                    <span class="small fw-semibold" style="color: var(--text-secondary);">Payment Amount: </span>
                    <span class="fw-bold" style="color: #22c55e;">₱{{ number_format($invoice->payment->amount, 2) }}</span>
                </div>
                <div class="mb-2">
                    <span class="small fw-semibold" style="color: var(--text-secondary);">Payment Date: </span>
                    <span style="color: var(--text-primary);">{{ $invoice->payment->payment_date ? $invoice->payment->payment_date->format('F j, Y') : 'N/A' }}</span>
                </div>
                <div class="mb-2">
                    <span class="small fw-semibold" style="color: var(--text-secondary);">Payment Method: </span>
                    <span style="color: var(--text-primary);">{{ ucfirst(str_replace('_', ' ', $invoice->payment->method)) }}</span>
                </div>
                <div class="mb-2">
                    <span class="small fw-semibold" style="color: var(--text-secondary);">Payment Status: </span>
                    <span class="badge px-3 py-1 rounded-pill" 
                          style="@if($invoice->payment->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                          @elseif($invoice->payment->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                          @elseif($invoice->payment->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                          @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                        {{ ucfirst($invoice->payment->status) }}
                    </span>
                </div>
                @if($invoice->payment->notes)
                <div class="mt-3">
                    <span class="small fw-semibold" style="color: var(--text-secondary);">Payment Notes: </span>
                    <p class="small mb-0 mt-1" style="color: var(--text-primary);">{{ $invoice->payment->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="col-12 col-md-6">
        <div class="card h-100 text-center py-5" style="background: #ffffff; border: 1px solid #e5e7eb;">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                    <i class="fas fa-credit-card" style="font-size: 2rem; color: #0066ff;"></i>
                </div>
                <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">No Related Payment</h3>
                <p class="mb-0" style="color: var(--text-secondary);">This invoice is not linked to any payment.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment Receipt Section -->
    @if($invoice->payment && $invoice->payment->receipt_image)
    <div class="col-12">
        <div class="card" style="background: #ffffff; border: 1px solid #e5e7eb;">
            <div class="card-header p-4 border-bottom" style="border-color: #e5e7eb !important; background: #ffffff;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Payment Receipt</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Receipt screenshot for this payment</p>
            </div>
            <div class="p-4">
                <div class="p-4" style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="small fw-semibold mb-0" style="color: var(--text-primary);">Receipt Screenshot</h4>
                        <div class="d-flex gap-2">
                            @php
                                $invoiceReceiptUrl = route('payments.receipt', ['payment' => $invoice->payment->payment_id]);
                            @endphp
                            <a href="{{ $invoiceReceiptUrl }}" target="_blank" class="btn btn-sm" style="color: #0066ff;">
                                <i class="fas fa-external-link-alt me-1"></i>View Full Size
                            </a>
                            <a href="{{ $invoiceReceiptUrl }}" download class="btn btn-sm" style="color: #22c55e;">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                    <div class="position-relative">
                        <img src="{{ $invoiceReceiptUrl }}" 
                             alt="Payment Receipt" 
                             class="img-fluid rounded cursor-pointer"
                             style="max-height: 300px; object-fit: contain; border: 1px solid rgba(0, 102, 255, 0.2); filter: none !important; -webkit-filter: none !important;"
                             onclick="openReceiptModal('{{ $invoiceReceiptUrl }}')"
                             data-bs-toggle="modal" data-bs-target="#receiptModal">
                    </div>
                    <p class="small mt-2 mb-0" style="color: var(--text-secondary);">
                        <i class="fas fa-info-circle me-1"></i>Click on the image to view in full size
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" id="receiptModalDialog">
        <div class="modal-content" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; max-height: 95vh;">
            <div class="modal-header border-bottom" style="border-color: #e5e7eb !important; position: relative; z-index: 1000;">
                <h5 class="modal-title fw-bold" style="color: #1f2937;">Payment Receipt</h5>
                <button type="button" class="btn-close" onclick="closeReceiptModal()" aria-label="Close" style="z-index: 1001; position: relative;"></button>
            </div>
            <div class="modal-body text-center p-4" style="background: #ffffff; overflow-y: auto; max-height: calc(95vh - 140px); position: relative; z-index: 1000;">
                <img id="receiptModalImage" src="" alt="Payment Receipt" class="img-fluid rounded" style="max-width: 100%; height: auto; object-fit: contain; filter: none !important; -webkit-filter: none !important; image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
            </div>
            <div class="modal-footer border-top" style="border-color: #e5e7eb !important; background: #ffffff; position: relative; z-index: 1000;">
                <a id="receiptDownloadLink" href="" download class="btn btn-success" style="z-index: 1001; position: relative;">
                    <i class="fas fa-download me-2"></i>Download Receipt
                </a>
                <button type="button" class="btn btn-secondary" onclick="closeReceiptModal()" style="z-index: 1001; position: relative;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Hide modal backdrop */
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

/* Position modal on the right side */
#receiptModalDialog {
    position: fixed !important;
    top: 50% !important;
    right: 20px !important;
    transform: translateY(-50%) !important;
    margin: 0 !important;
    max-width: 60% !important;
    width: 60% !important;
    max-height: 95vh !important;
    pointer-events: auto !important;
    z-index: 1056 !important;
}

@media (max-width: 1200px) {
    #receiptModalDialog {
        max-width: 70% !important;
        width: 70% !important;
    }
}

@media (max-width: 768px) {
    #receiptModalDialog {
        max-width: 90% !important;
        width: 90% !important;
        right: 5% !important;
    }
}

/* Ensure image displays clearly without blur */
#receiptModalImage {
    max-width: 100%;
    height: auto;
    object-fit: contain;
    border-radius: 8px;
    filter: none !important;
    -webkit-filter: none !important;
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    image-rendering: auto;
}

/* Ensure buttons are clickable */
#receiptModal .btn,
#receiptModal .btn-close {
    z-index: 1001 !important;
    pointer-events: auto !important;
    position: relative;
}

#receiptModal .modal-content {
    z-index: 1057 !important;
    pointer-events: auto !important;
}
</style>

<script>
let receiptModalInstance = null;

function openReceiptModal(imageUrl) {
    const modalElement = document.getElementById('receiptModal');
    const modalImage = document.getElementById('receiptModalImage');
    const downloadLink = document.getElementById('receiptDownloadLink');
    
    modalImage.src = imageUrl;
    downloadLink.href = imageUrl;
    
    // Remove any filters that might cause blur
    modalImage.style.filter = 'none';
    modalImage.style.webkitFilter = 'none';
    modalImage.style.imageRendering = 'auto';
    
    // Create or get modal instance
    if (!receiptModalInstance) {
        receiptModalInstance = new bootstrap.Modal(modalElement, {
            backdrop: false,
            keyboard: true,
            focus: true
        });
    }
    
    receiptModalInstance.show();
    
    // Remove backdrop after modal is shown
    modalElement.addEventListener('shown.bs.modal', function() {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.style.display = 'none';
            backdrop.remove();
        });
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Ensure modal is positioned correctly
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
        
        // Ensure image is clear
        modalImage.style.filter = 'none';
        modalImage.style.webkitFilter = 'none';
    }, { once: true });
}

function closeReceiptModal() {
    if (receiptModalInstance) {
        receiptModalInstance.hide();
    }
    
    // Clean up backdrop
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(backdrop => {
        backdrop.style.display = 'none';
        backdrop.remove();
    });
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
}

// Close modal on ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeReceiptModal();
    }
});

// Close modal when clicking outside
document.getElementById('receiptModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeReceiptModal();
    }
});

// Clean up when modal is hidden
document.addEventListener('hidden.bs.modal', function(event) {
    if (event.target.id === 'receiptModal') {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.style.display = 'none';
            backdrop.remove();
        });
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
});

// Prevent backdrop from being created
document.addEventListener('DOMContentLoaded', function() {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1 && node.classList && node.classList.contains('modal-backdrop')) {
                    node.style.display = 'none';
                    node.remove();
                }
            });
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
</script>
@endsection
