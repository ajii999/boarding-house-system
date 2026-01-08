@extends('layouts.tenant')

@section('title', 'Add Payment')
@section('page-title', 'Add Payment')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(34, 197, 94, 0.3); background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(0, 212, 255, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('tenant.payments') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #22c55e;">Add New Payment</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Submit a payment via GCash or PayMaya with receipt for verification.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('tenant.payments.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Payment Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Payment Information</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Submit a payment via GCash or PayMaya with receipt for verification.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="amount" class="form-label fw-semibold" style="color: var(--text-primary);">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: rgba(0, 102, 255, 0.1); border-color: rgba(0, 102, 255, 0.3);">₱</span>
                                    <input type="number" name="amount" id="amount" step="0.01" min="0.01" required
                                           class="form-control @error('amount') is-invalid @enderror"
                                           value="{{ old('amount', $tenantBalance > 0 ? number_format($tenantBalance, 2) : '') }}" placeholder="0.00">
                                </div>
                                @if($tenantBalance > 0)
                                    <p class="small mt-1 mb-0" style="color: var(--text-secondary);">Your current balance: ₱{{ number_format($tenantBalance, 2) }}</p>
                                @endif
                                @error('amount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="payment_date" class="form-label fw-semibold" style="color: var(--text-primary);">Payment Date</label>
                                <input type="date" name="payment_date" id="payment_date" required
                                       class="form-control @error('payment_date') is-invalid @enderror"
                                       value="{{ old('payment_date', now()->format('Y-m-d')) }}">
                                @error('payment_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="method" class="form-label fw-semibold" style="color: var(--text-primary);">Payment Method</label>
                                <select name="method" id="method" required class="form-select @error('method') is-invalid @enderror">
                                    <option value="">Select payment method</option>
                                    <option value="cash" {{ old('method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="gcash" {{ old('method') == 'gcash' ? 'selected' : '' }}>GCash</option>
                                    <option value="paymaya" {{ old('method') == 'paymaya' ? 'selected' : '' }}>PayMaya</option>
                                </select>
                                @error('method')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="booking_id" class="form-label fw-semibold" style="color: var(--text-primary);">Related Booking (Optional)</label>
                                <select name="booking_id" id="booking_id" class="form-select @error('booking_id') is-invalid @enderror">
                                    <option value="">Select booking (optional)</option>
                                    @foreach($activeBookings as $booking)
                                        <option value="{{ $booking->booking_id }}" 
                                                data-total-amount="{{ $booking->total_amount }}"
                                                data-room-number="{{ $booking->room->room_number }}"
                                                {{ old('booking_id') == $booking->booking_id ? 'selected' : '' }}>
                                            Room {{ $booking->room->room_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('booking_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="receipt_image" class="form-label fw-semibold" style="color: var(--text-primary);">Receipt Image (Required for Monthly Payments)</label>
                                <div id="receiptUploadArea" class="futuristic-card p-5 text-center border-dashed" style="border-color: rgba(148, 163, 184, 0.3); border-width: 2px; cursor: pointer;">
                                    <div id="uploadContent">
                                        <i class="fas fa-cloud-upload-alt mb-3" style="font-size: 3rem; color: var(--text-secondary);"></i>
                                        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center gap-2">
                                            <label for="receipt_image" class="btn btn-sm btn-neon mb-0" style="cursor: pointer;">
                                                Upload a file
                                            </label>
                                            <span class="small" style="color: var(--text-secondary);">or drag and drop</span>
                                        </div>
                                        <input id="receipt_image" name="receipt_image" type="file" accept="image/*" class="d-none">
                                        <p class="small mt-2 mb-0" style="color: var(--text-secondary);">PNG, JPG, GIF up to 20MB</p>
                                    </div>
                                    <div id="uploadedFileContent" class="d-none">
                                        <i class="fas fa-check-circle mb-3" style="font-size: 3rem; color: #22c55e;"></i>
                                        <p class="small mb-1" id="uploadedFileName" style="color: var(--text-primary);"></p>
                                        <p class="small mb-0" style="color: var(--text-secondary);">Click to change file</p>
                                    </div>
                                </div>
                                @error('receipt_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Receipt Preview Section -->
                            <div id="receiptPreviewContainer" class="col-12 d-none">
                                <div class="futuristic-card p-4" style="border-color: rgba(34, 197, 94, 0.2);">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="h6 fw-bold mb-0" style="color: var(--text-primary);">Receipt Preview</h4>
                                        <button type="button" id="clearReceiptPreview" class="btn btn-sm" style="color: #ef4444;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="text-center">
                                        <img id="receiptPreviewImage" src="" alt="Receipt Preview" class="img-fluid rounded" style="max-height: 400px; border: 1px solid rgba(148, 163, 184, 0.2);">
                                        <p id="receiptPreviewFileName" class="small mt-2 mb-0" style="color: var(--text-secondary);"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label fw-semibold" style="color: var(--text-primary);">Notes (Optional)</label>
                                <textarea name="notes" id="notes" rows="3"
                                          class="form-control @error('notes') is-invalid @enderror"
                                          placeholder="Additional notes about this payment...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Notice -->
            <div class="futuristic-card p-4 mb-4" style="border-color: rgba(245, 158, 11, 0.3); background: rgba(245, 158, 11, 0.05);">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <i class="fas fa-exclamation-triangle" style="color: #f59e0b; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h3 class="h6 fw-bold mb-2" style="color: #f59e0b;">Important Notice</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">
                            Your payment will be reviewed by the admin before being marked as completed. Please ensure all information is accurate and the receipt image is clear.
                        </p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('tenant.payments') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-neon">
                    <i class="fas fa-paper-plane me-2"></i>Submit Payment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('receipt_image');
    const uploadArea = document.getElementById('receiptUploadArea');
    const bookingSelect = document.getElementById('booking_id');
    const amountInput = document.getElementById('amount');
    
    // Handle booking selection
    bookingSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value && selectedOption.dataset.totalAmount) {
            amountInput.value = parseFloat(selectedOption.dataset.totalAmount).toFixed(2);
            
            const existingMessage = document.getElementById('booking-amount-message');
            if (existingMessage) {
                existingMessage.remove();
            }
            
            const message = document.createElement('p');
            message.id = 'booking-amount-message';
            message.className = 'small mt-1 mb-0';
            message.style.color = '#0066ff';
            message.innerHTML = `<i class="fas fa-info-circle me-1"></i>Amount set to booking total for Room ${selectedOption.dataset.roomNumber}`;
            
            bookingSelect.parentNode.appendChild(message);
        } else {
            amountInput.value = '';
            const existingMessage = document.getElementById('booking-amount-message');
            if (existingMessage) {
                existingMessage.remove();
            }
        }
    });
    
    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const fileName = file.name;
            
            document.getElementById('uploadContent').classList.add('d-none');
            document.getElementById('uploadedFileContent').classList.remove('d-none');
            document.getElementById('uploadedFileName').textContent = fileName;
            
            uploadArea.style.borderColor = 'rgba(34, 197, 94, 0.3)';
            uploadArea.style.background = 'rgba(34, 197, 94, 0.05)';
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('receiptPreviewImage').src = e.target.result;
                document.getElementById('receiptPreviewFileName').textContent = fileName;
                document.getElementById('receiptPreviewContainer').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Handle click on upload area
    uploadArea.addEventListener('click', function() {
        fileInput.click();
    });
    
    // Handle clear receipt preview
    document.getElementById('clearReceiptPreview').addEventListener('click', function() {
        fileInput.value = '';
        document.getElementById('uploadContent').classList.remove('d-none');
        document.getElementById('uploadedFileContent').classList.add('d-none');
        uploadArea.style.borderColor = 'rgba(148, 163, 184, 0.3)';
        uploadArea.style.background = '';
        document.getElementById('receiptPreviewContainer').classList.add('d-none');
    });
    
    // Handle drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = 'rgba(0, 102, 255, 0.3)';
        uploadArea.style.background = 'rgba(0, 102, 255, 0.05)';
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = 'rgba(148, 163, 184, 0.3)';
        uploadArea.style.background = '';
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = 'rgba(148, 163, 184, 0.3)';
        uploadArea.style.background = '';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });
});
</script>
@endsection
