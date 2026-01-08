@extends('layouts.admin')

@section('title', 'Payment Details')
@section('page-title', 'Payment Details')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.payments.index') }}" class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.35)'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='scale(1)';">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">Payment #{{ $payment->payment_id }}</h1>
                <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.9); font-weight: 500;">Complete payment details and related information</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.payments.edit', $payment) }}" class="btn" style="background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='translateY(0)';">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Payment Information Card -->
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Payment Information</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Complete payment details</p>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Payment ID</dt>
                        <dd class="fw-bold" style="color: var(--text-primary);">#{{ $payment->payment_id }}</dd>
                    </div>
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Amount</dt>
                        <dd class="fw-bold h4 mb-0" style="color: #22c55e;">₱{{ number_format($payment->amount, 2) }}</dd>
                    </div>
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Status</dt>
                        <dd>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($payment->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($payment->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                  @elseif($payment->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                  @elseif($payment->status == 'refunded') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                  @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Payment Date</dt>
                        <dd style="color: var(--text-primary);">{{ $payment->payment_date ? $payment->payment_date->format('F j, Y') : 'N/A' }}</dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Payment Method</dt>
                        <dd style="color: var(--text-primary);">{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</dd>
                    </div>
                    @if($payment->notes)
                    <div class="col-12">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Notes</dt>
                        <dd style="color: var(--text-primary);">{{ $payment->notes }}</dd>
                    </div>
                    @endif
                    @php
                        // Check payment receipt_image first, then fallback to booking's payment_receipt
                        $receiptImage = $payment->receipt_image;
                        if (!$receiptImage && $payment->booking && $payment->booking->payment_receipt) {
                            $receiptImage = $payment->booking->payment_receipt;
                        }
                    @endphp
                    @if($receiptImage)
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Receipt Image</label>
                            <div class="d-flex align-items-center gap-3">
                                <button onclick="openReceiptModal('{{ Storage::url($receiptImage) }}')" 
                                        class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-image me-2"></i>View Full Size
                                </button>
                                <div class="position-relative" style="width: 150px; height: 150px;">
                                    <img src="{{ Storage::url($receiptImage) }}" 
                                         alt="Payment Receipt" 
                                         class="img-thumbnail w-100 h-100" 
                                         style="object-fit: cover; border-radius: 12px; border-color: rgba(0, 102, 255, 0.3); cursor: pointer; transition: opacity 0.3s;"
                                         onclick="openReceiptModal('{{ Storage::url($receiptImage) }}')"
                                         onmouseover="this.style.opacity='0.8'"
                                         onmouseout="this.style.opacity='1'">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-12">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Created</dt>
                        <dd style="color: var(--text-primary);">{{ $payment->created_at->format('F j, Y \a\t g:i A') }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tenant Information -->
    @if($payment->tenant)
    <div class="col-12 col-md-6">
        <div class="futuristic-card h-100" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
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
                        <div class="fw-bold" style="color: var(--text-primary);">{{ $payment->tenant->name }}</div>
                        <div class="small" style="color: var(--text-secondary);">{{ $payment->tenant->email }}</div>
                    </div>
                </div>
                <div class="small" style="color: var(--text-primary);">
                    <i class="fas fa-phone me-2" style="color: var(--text-secondary);"></i>{{ $payment->tenant->contact_number }}
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Booking Information -->
    @if($payment->booking)
    <div class="col-12 col-md-6">
        <div class="futuristic-card h-100" style="border-color: rgba(34, 197, 94, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(34, 197, 94, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Related Booking</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Booking information</p>
            </div>
            <div class="p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.08)); border: 2px solid rgba(34, 197, 94, 0.3);">
                        <i class="fas fa-bed" style="font-size: 1.5rem; color: #22c55e;"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="color: var(--text-primary);">Room {{ $payment->booking->room->room_number ?? 'N/A' }}</div>
                        <div class="small" style="color: var(--text-secondary);">Booking Details</div>
                    </div>
                </div>
                <div class="mb-2">
                    <span class="small fw-semibold" style="color: var(--text-secondary);">Check In: </span>
                    <span style="color: var(--text-primary);">{{ $payment->booking->check_in ? \Carbon\Carbon::parse($payment->booking->check_in)->format('F j, Y') : 'N/A' }}</span>
                </div>
                <div class="mb-2">
                    <span class="small fw-semibold" style="color: var(--text-secondary);">Check Out: </span>
                    <span style="color: var(--text-primary);">{{ $payment->booking->check_out ? \Carbon\Carbon::parse($payment->booking->check_out)->format('F j, Y') : 'N/A' }}</span>
                </div>
                <div>
                    <span class="small fw-semibold" style="color: var(--text-secondary);">Booking Status: </span>
                    <span class="badge px-3 py-1 rounded-pill" 
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
    @endif

    <!-- Invoice Information -->
    @if($payment->invoice)
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Related Invoice</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Invoice information associated with this payment</p>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Invoice ID</dt>
                        <dd class="fw-bold" style="color: var(--text-primary);">#{{ $payment->invoice->invoice_id }}</dd>
                    </div>
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Due Date</dt>
                        <dd style="color: var(--text-primary);">{{ $payment->invoice->due_date ? \Carbon\Carbon::parse($payment->invoice->due_date)->format('F j, Y') : 'N/A' }}</dd>
                    </div>
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Invoice Status</dt>
                        <dd>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($payment->invoice->status == 'paid') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($payment->invoice->status == 'sent') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                  @elseif($payment->invoice->status == 'overdue') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                  @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                {{ ucfirst($payment->invoice->status) }}
                            </span>
                        </dd>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" id="receiptModalDialog">
        <div class="modal-content futuristic-card h-100" style="border-color: rgba(0, 102, 255, 0.3); max-height: 95vh; background: white !important;">
            <div class="modal-header border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important; background: white !important;">
                <h5 class="modal-title fw-bold" style="color: #0066ff;">Payment Receipt</h5>
                <button type="button" class="btn-close" onclick="closeReceiptModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4 d-flex align-items-center justify-content-center" style="overflow-y: auto; max-height: calc(95vh - 140px); background: white;">
                <img id="receiptModalImage" src="" alt="Payment Receipt" class="img-fluid rounded" style="max-width: 100%; max-height: calc(95vh - 200px); height: auto; object-fit: contain; margin: 0 auto; display: block;">
            </div>
            <div class="modal-footer border-top" style="border-color: rgba(0, 102, 255, 0.2) !important; background: white !important;">
                <button type="button" class="btn btn-secondary" onclick="closeReceiptModal()">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </button>
                <a id="receiptDownloadLink" href="" download class="btn btn-neon">
                    <i class="fas fa-download me-2"></i>Download Receipt
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Hide modal backdrop */
.modal-backdrop {
    display: none !important;
}

#receiptModal {
    background: transparent !important;
}

#receiptModal.show {
    background: transparent !important;
}

/* Position modal on the right side */
#receiptModalDialog {
    position: fixed !important;
    right: 2rem !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    margin: 0 !important;
    max-width: 60% !important;
    max-height: 95vh;
}

@media (max-width: 1200px) {
    #receiptModalDialog {
        max-width: 70%;
        right: 1.5rem !important;
    }
}

@media (max-width: 768px) {
    #receiptModalDialog {
        max-width: 90%;
        right: 1rem !important;
    }
}

/* Ensure image fits properly and is centered */
#receiptModalImage {
    max-width: 100%;
    height: auto;
    object-fit: contain;
    border-radius: 8px;
    filter: none !important;
    -webkit-filter: none !important;
}

/* Ensure modal content has white background */
#receiptModal .modal-content {
    background: white !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
}

/* Ensure buttons are clickable */
#receiptModal .btn,
#receiptModal .btn-close {
    z-index: 1000;
    pointer-events: auto;
    position: relative;
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
    
    // Create or get modal instance
    if (!receiptModalInstance) {
        receiptModalInstance = new bootstrap.Modal(modalElement, {
            backdrop: false,
            keyboard: true
        });
    }
    
    receiptModalInstance.show();
}

function closeReceiptModal() {
    if (receiptModalInstance) {
        receiptModalInstance.hide();
    }
}

// Close modal on ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeReceiptModal();
    }
});

// Close modal when clicking outside (on the modal itself, not backdrop)
document.getElementById('receiptModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeReceiptModal();
    }
});

// Remove any backdrop that Bootstrap might create
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
</script>
@endsection
