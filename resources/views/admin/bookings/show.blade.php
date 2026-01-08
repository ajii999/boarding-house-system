@extends('layouts.admin')

@section('title', 'Booking Details')
@section('page-title', 'Booking Details')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.bookings.index') }}" class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.35)'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='scale(1)';">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">Booking #{{ $booking->booking_id }}</h1>
                <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.9); font-weight: 500;">Complete booking details and related information</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn" style="background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='translateY(0)';">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Booking Information Card -->
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Booking Information</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Complete booking details</p>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Booking ID</dt>
                        <dd class="fw-bold" style="color: var(--text-primary);">#{{ $booking->booking_id }}</dd>
                    </div>
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Booking Date</dt>
                        <dd style="color: var(--text-primary);">{{ $booking->booking_date ? $booking->booking_date->format('F j, Y') : 'N/A' }}</dd>
                    </div>
                    <div class="col-12 col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Status</dt>
                        <dd>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($booking->status == 'confirmed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($booking->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                  @elseif($booking->status == 'cancelled') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                  @elseif($booking->status == 'completed') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                  @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Check In Date</dt>
                        <dd style="color: var(--text-primary);">{{ $booking->check_in ? $booking->check_in->format('F j, Y') : 'N/A' }}</dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Check Out Date</dt>
                        <dd style="color: var(--text-primary);">{{ $booking->check_out ? $booking->check_out->format('F j, Y') : 'N/A' }}</dd>
                    </div>
                    <div class="col-12">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Created</dt>
                        <dd style="color: var(--text-primary);">{{ $booking->created_at->format('F j, Y \a\t g:i A') }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tenant Information -->
    @if($booking->tenant)
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
                        <div class="fw-bold" style="color: var(--text-primary);">{{ $booking->tenant->name }}</div>
                        <div class="small" style="color: var(--text-secondary);">{{ $booking->tenant->email }}</div>
                    </div>
                </div>
                <div class="small" style="color: var(--text-primary);">
                    <i class="fas fa-phone me-2" style="color: var(--text-secondary);"></i>{{ $booking->tenant->contact_number }}
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Room Information -->
    @if($booking->room)
    <div class="col-12 col-md-6">
        <div class="futuristic-card h-100" style="border-color: rgba(34, 197, 94, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(34, 197, 94, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Room Information</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Details of the booked room</p>
            </div>
            <div class="p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.08)); border: 2px solid rgba(34, 197, 94, 0.3);">
                        <i class="fas fa-bed" style="font-size: 1.5rem; color: #22c55e;"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="color: var(--text-primary);">Room {{ $booking->room->room_number }}</div>
                        <div class="small" style="color: var(--text-secondary);">{{ $booking->room->room_type }}</div>
                    </div>
                </div>
                <div class="mb-2">
                    <span class="small fw-semibold" style="color: var(--text-secondary);">Price per Night: </span>
                    <span class="fw-bold" style="color: #22c55e;">₱{{ number_format($booking->room->price, 2) }}</span>
                </div>
                <div class="mb-2">
                    <span class="small fw-semibold" style="color: var(--text-secondary);">Room Status: </span>
                    <span class="badge px-3 py-1 rounded-pill" 
                          style="@if($booking->room->status == 'available') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                          @elseif($booking->room->status == 'booked') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                          @else background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b; @endif">
                        {{ ucfirst($booking->room->status) }}
                    </span>
                </div>
                @if($booking->room->description)
                <div class="small mt-2" style="color: var(--text-secondary);">{{ $booking->room->description }}</div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Payment Receipt Information -->
    @if($booking->payment_receipt || $booking->down_payment_amount || $booking->down_payment_receipt)
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(245, 158, 11, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(245, 158, 11, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Payment Receipt Information</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Payment receipt details for this booking</p>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    @if($booking->down_payment_amount)
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Down Payment Amount</dt>
                        <dd class="fw-bold h5 mb-0" style="color: #f59e0b;">₱{{ number_format($booking->down_payment_amount, 2) }}</dd>
                    </div>
                    @endif
                    
                    @if($booking->down_payment_date)
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Down Payment Date</dt>
                        <dd style="color: var(--text-primary);">{{ $booking->down_payment_date->format('F j, Y') }}</dd>
                    </div>
                    @endif
                    
                    @if($booking->payment_receipt)
                    <div class="col-12">
                        <dt class="small fw-semibold mb-3" style="color: var(--text-secondary);">Payment Receipt</dt>
                        <dd>
                            <div class="futuristic-card p-4" style="border-color: rgba(0, 102, 255, 0.2);">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="small fw-semibold mb-0" style="color: var(--text-primary);">Receipt Screenshot</h4>
                                    <div class="d-flex gap-2">
                                        <a href="{{ storage_url($booking->payment_receipt) }}" target="_blank" class="btn btn-sm" style="color: #0066ff;">
                                            <i class="fas fa-external-link-alt me-1"></i>View Full Size
                                        </a>
                                        <a href="{{ storage_url($booking->payment_receipt) }}" download class="btn btn-sm" style="color: #22c55e;">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <img src="{{ storage_url($booking->payment_receipt) }}" 
                                         alt="Payment Receipt" 
                                         class="img-fluid rounded cursor-pointer"
                                         style="max-height: 300px; object-fit: contain; border: 1px solid rgba(0, 102, 255, 0.2);"
                                         onclick="openReceiptModal('{{ storage_url($booking->payment_receipt) }}')"
                                         data-bs-toggle="modal" data-bs-target="#receiptModal">
                                </div>
                                <p class="small mt-2 mb-0" style="color: var(--text-secondary);">
                                    <i class="fas fa-info-circle me-1"></i>Click on the image to view in full size
                                </p>
                            </div>
                        </dd>
                    </div>
                    @endif
                    
                    @if($booking->down_payment_receipt)
                    <div class="col-12">
                        <dt class="small fw-semibold mb-3" style="color: var(--text-secondary);">Down Payment Receipt</dt>
                        <dd>
                            <div class="futuristic-card p-4" style="border-color: rgba(0, 102, 255, 0.2);">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="small fw-semibold mb-0" style="color: var(--text-primary);">Down Payment Receipt Screenshot</h4>
                                    <div class="d-flex gap-2">
                                        <a href="{{ Storage::url($booking->down_payment_receipt) }}" target="_blank" class="btn btn-sm" style="color: #0066ff;">
                                            <i class="fas fa-external-link-alt me-1"></i>View Full Size
                                        </a>
                                        <a href="{{ Storage::url($booking->down_payment_receipt) }}" download class="btn btn-sm" style="color: #22c55e;">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <img src="{{ Storage::url($booking->down_payment_receipt) }}" 
                                         alt="Down Payment Receipt" 
                                         class="img-fluid rounded cursor-pointer"
                                         style="max-height: 300px; object-fit: contain; border: 1px solid rgba(0, 102, 255, 0.2);"
                                         onclick="openReceiptModal('{{ Storage::url($booking->down_payment_receipt) }}')"
                                         data-bs-toggle="modal" data-bs-target="#receiptModal">
                                </div>
                                <p class="small mt-2 mb-0" style="color: var(--text-secondary);">
                                    <i class="fas fa-info-circle me-1"></i>Click on the image to view in full size
                                </p>
                            </div>
                        </dd>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment History with Receipts -->
    @if($booking->payments->count() > 0)
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(34, 197, 94, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(34, 197, 94, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Payment History & Receipts</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Payments and receipts associated with this booking</p>
            </div>
            <div class="p-4">
                @foreach($booking->payments as $index => $payment)
                <div class="futuristic-card p-4 mb-4 {{ $index < $booking->payments->count() - 1 ? 'border-bottom' : '' }}" 
                     style="border-color: rgba(34, 197, 94, 0.2); {{ $index < $booking->payments->count() - 1 ? 'border-bottom: 2px solid rgba(34, 197, 94, 0.1) !important;' : '' }}">
                    <div class="row g-4">
                        <!-- Payment Details -->
                        <div class="col-12 col-md-6">
                            <h5 class="fw-bold mb-3" style="color: var(--text-primary);">Payment #{{ $payment->payment_id }}</h5>
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Payment Date</dt>
                                    <dd style="color: var(--text-primary);">
                                        {{ $payment->payment_date ? $payment->payment_date->format('F j, Y') : 'N/A' }}
                                    </dd>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Amount</dt>
                                    <dd class="fw-bold h5 mb-0" style="color: #22c55e;">
                                        ₱{{ number_format($payment->amount, 2) }}
                                    </dd>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Payment Method</dt>
                                    <dd style="color: var(--text-primary);">
                                        {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                                    </dd>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Status</dt>
                                    <dd>
                                        <span class="badge px-3 py-2 rounded-pill" 
                                              style="@if($payment->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                              @elseif($payment->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                              @elseif($payment->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                              @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </dd>
                                </div>
                                @if($payment->notes)
                                <div class="col-12">
                                    <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Notes</dt>
                                    <dd style="color: var(--text-primary);">{{ $payment->notes }}</dd>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Receipt Image -->
                        <div class="col-12 col-md-6">
                            @if($payment->receipt_image)
                            <dt class="small fw-semibold mb-3" style="color: var(--text-secondary);">Payment Receipt</dt>
                            <dd>
                                <div class="futuristic-card p-3" style="border-color: rgba(0, 102, 255, 0.2);">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="small fw-semibold mb-0" style="color: var(--text-primary);">Receipt Image</h6>
                                        <div class="d-flex gap-2">
                                            <a href="{{ storage_url($payment->receipt_image) }}" target="_blank" class="btn btn-sm" style="color: #0066ff;">
                                                <i class="fas fa-external-link-alt me-1"></i>View Full Size
                                            </a>
                                            <a href="{{ storage_url($payment->receipt_image) }}" download class="btn btn-sm" style="color: #22c55e;">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                    <div class="position-relative">
                                        <img src="{{ storage_url($payment->receipt_image) }}" 
                                             alt="Payment Receipt" 
                                             class="img-fluid rounded cursor-pointer"
                                             style="max-height: 250px; width: 100%; object-fit: contain; border: 1px solid rgba(0, 102, 255, 0.2);"
                                             onclick="openReceiptModal('{{ storage_url($payment->receipt_image) }}')"
                                             data-bs-toggle="modal" data-bs-target="#receiptModal">
                                    </div>
                                    <p class="small mt-2 mb-0" style="color: var(--text-secondary);">
                                        <i class="fas fa-info-circle me-1"></i>Click on the image to view in full size
                                    </p>
                                </div>
                            </dd>
                            @else
                            <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Payment Receipt</dt>
                            <dd>
                                <div class="futuristic-card p-4 text-center" style="border-color: rgba(148, 163, 184, 0.2); background: rgba(148, 163, 184, 0.05);">
                                    <i class="fas fa-image mb-2" style="font-size: 2rem; color: var(--text-secondary);"></i>
                                    <p class="small mb-0" style="color: var(--text-secondary);">No receipt image uploaded</p>
                                </div>
                            </dd>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" id="receiptModalDialog">
        <div class="modal-content futuristic-card h-100" style="border-color: rgba(0, 102, 255, 0.3); max-height: 95vh;">
            <div class="modal-header border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h5 class="modal-title fw-bold" style="color: #0066ff;">Payment Receipt</h5>
                <button type="button" class="btn-close" onclick="closeReceiptModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4" style="overflow-y: auto; max-height: calc(95vh - 140px);">
                <img id="receiptModalImage" src="" alt="Payment Receipt" class="img-fluid rounded" style="max-width: 100%; height: auto; object-fit: contain;">
            </div>
            <div class="modal-footer border-top" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <a id="receiptDownloadLink" href="" download class="btn" style="background: linear-gradient(135deg, #22c55e, #16a34a); color: white; border: none;">
                    <i class="fas fa-download me-2"></i>Download Receipt
                </a>
                <button type="button" class="btn btn-secondary" onclick="closeReceiptModal()">
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
}

#receiptModal {
    background: transparent !important;
}

#receiptModal.show {
    background: transparent !important;
}

/* Position modal on the right side */
#receiptModalDialog {
    position: fixed;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    margin: 0;
    max-width: 60%;
    width: 60%;
    max-height: 95vh;
}

@media (max-width: 1200px) {
    #receiptModalDialog {
        max-width: 70%;
        width: 70%;
    }
}

@media (max-width: 768px) {
    #receiptModalDialog {
        max-width: 90%;
        width: 90%;
        right: 5%;
    }
}

/* Ensure image fits properly */
#receiptModalImage {
    max-width: 100%;
    height: auto;
    object-fit: contain;
    border-radius: 8px;
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
</script>
@endsection
