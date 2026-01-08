@extends('layouts.tenant')

@section('title', 'Payment Details')
@section('page-title', 'Payment Details')

@section('content')
<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="/tenant/payments" 
           id="backToPaymentsBtn"
           class="btn btn-sm d-inline-flex align-items-center" 
           style="color: var(--text-secondary); text-decoration: none; cursor: pointer; pointer-events: auto; position: relative; z-index: 1000;">
            <i class="fas fa-arrow-left me-2"></i>
            <span>Back to Payments</span>
        </a>
    </div>
    
    <!-- Payment Information Card -->
    <div class="futuristic-card mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
        <div class="p-4 p-md-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div>
                    <h3 class="h4 fw-bold mb-1" style="color: var(--primary-neon);">Payment Information</h3>
                    <p class="mb-0 small" style="color: var(--text-secondary);">Complete payment details and receipt information.</p>
                </div>
            </div>
            <div class="border-top pt-4" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Payment ID</label>
                            <div style="color: var(--text-primary);">#{{ $payment->payment_id }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Amount</label>
                            <div class="fw-bold" style="color: var(--primary-neon); font-size: 1.5rem;">₱{{ number_format($payment->amount, 2) }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Payment Date</label>
                            <div style="color: var(--text-primary);">{{ $payment->payment_date ? $payment->payment_date->format('F j, Y') : 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Payment Method</label>
                            <div style="color: var(--text-primary);">{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Status</label>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($payment->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($payment->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                  @elseif($payment->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                  @elseif($payment->status == 'refunded') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                  @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>
                    @if($payment->notes)
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Notes</label>
                            <div style="color: var(--text-primary);">{{ $payment->notes }}</div>
                        </div>
                    </div>
                    @endif
                    @if($payment->receipt_image)
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Receipt Image</label>
                            @php
                                $imageUrl = storage_url($payment->receipt_image);
                                $fileExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($payment->receipt_image);
                            @endphp
                            @if(!$fileExists)
                            <div class="alert alert-warning mb-2">
                                <small><strong>Debug:</strong> File path: <code>{{ $payment->receipt_image }}</code><br>
                                URL: <code>{{ $imageUrl }}</code><br>
                                File exists: <strong>{{ $fileExists ? 'Yes' : 'No' }}</strong></small>
                            </div>
                            @endif
                            <div class="d-flex align-items-center gap-3">
                                <button onclick="openReceiptModal('{{ $imageUrl }}')" 
                                        class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-image me-2"></i>View Full Size
                                </button>
                                <div class="position-relative" style="width: 150px; height: 150px;">
                                    <img src="{{ $imageUrl }}" 
                                         alt="Payment Receipt" 
                                         class="img-thumbnail w-100 h-100" 
                                         style="object-fit: cover; border-radius: 12px; border-color: rgba(0, 102, 255, 0.3); cursor: pointer; transition: opacity 0.3s;"
                                         onclick="openReceiptModal('{{ $imageUrl }}')"
                                         onmouseover="this.style.opacity='0.8'"
                                         onmouseout="this.style.opacity='1'"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'150\' height=\'150\'%3E%3Crect width=\'150\' height=\'150\' fill=\'%23f0f0f0\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23999\'%3EImage not found%3C/text%3E%3C/svg%3E';">
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            <small><strong>Debug:</strong> receipt_image column is NULL or empty for this payment.</small>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Created</label>
                            <div style="color: var(--text-primary);">{{ $payment->created_at->format('F j, Y \a\t g:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Information -->
    @if($payment->booking)
    <div class="futuristic-card mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: var(--primary-neon);">Related Booking</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Booking information associated with this payment.</p>
            <div class="border-top pt-4" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Room</label>
                            <div style="color: var(--text-primary);">{{ $payment->booking->room->room_number ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Check In</label>
                            <div style="color: var(--text-primary);">{{ $payment->booking->check_in ? \Carbon\Carbon::parse($payment->booking->check_in)->format('F j, Y') : 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Check Out</label>
                            <div style="color: var(--text-primary);">{{ $payment->booking->check_out ? \Carbon\Carbon::parse($payment->booking->check_out)->format('F j, Y') : 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Booking Status</label>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($payment->booking->status == 'confirmed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($payment->booking->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                  @elseif($payment->booking->status == 'cancelled') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                  @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                {{ ucfirst($payment->booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Invoice Information -->
    @if($payment->invoice)
    <div class="futuristic-card mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: var(--primary-neon);">Related Invoice</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Invoice information associated with this payment.</p>
            <div class="border-top pt-4" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Invoice ID</label>
                            <div style="color: var(--text-primary);">#{{ $payment->invoice->invoice_id }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Due Date</label>
                            <div style="color: var(--text-primary);">{{ $payment->invoice->due_date ? \Carbon\Carbon::parse($payment->invoice->due_date)->format('F j, Y') : 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Invoice Status</label>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($payment->invoice->status == 'paid') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($payment->invoice->status == 'sent') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                  @elseif($payment->invoice->status == 'overdue') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                  @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                {{ ucfirst($payment->invoice->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg" id="receiptModalDialog">
        <div class="modal-content futuristic-card" style="border-color: rgba(0, 102, 255, 0.3); background: white !important;">
            <div class="modal-header border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important; background: white !important;">
                <h5 class="modal-title fw-bold" id="receiptModalLabel" style="color: #0066ff;">Payment Receipt</h5>
                <button type="button" class="btn-close" onclick="closeReceiptModal()" aria-label="Close" style="z-index: 1000; position: relative; pointer-events: auto;"></button>
            </div>
            <div class="modal-body p-4" style="background: white;">
                <div class="text-center">
                    <img id="receiptModalImage" src="" alt="Payment Receipt" class="img-fluid rounded" style="max-width: 100%; max-height: 70vh; object-fit: contain; filter: none !important; -webkit-filter: none !important;">
                </div>
            </div>
            <div class="modal-footer border-top" style="border-color: rgba(0, 102, 255, 0.2) !important; background: white !important;">
                <button type="button" class="btn btn-secondary" onclick="closeReceiptModal()" style="z-index: 1000; position: relative; pointer-events: auto;">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </button>
                <a id="receiptDownloadLink" href="" download class="btn btn-neon" style="z-index: 1000; position: relative; pointer-events: auto;">
                    <i class="fas fa-download me-2"></i>Download Receipt
                </a>
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

// Ensure back button works
document.addEventListener('DOMContentLoaded', function() {
    const backButton = document.getElementById('backToPaymentsBtn');
    if (backButton) {
        // Add click event listener as fallback
        backButton.addEventListener('click', function(e) {
            // If href is empty or route failed, use direct URL
            if (!this.getAttribute('href') || this.getAttribute('href') === '#') {
                e.preventDefault();
                window.location.href = '/tenant/payments';
            }
        });
        
        // Ensure the link is clickable
        backButton.style.pointerEvents = 'auto';
        backButton.style.cursor = 'pointer';
    }
});
</script>
@endsection
