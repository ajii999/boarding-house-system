@extends('layouts.admin')

@section('title', 'Edit Payment')
@section('page-title', 'Edit Payment')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px;">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.payments.index') }}" class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.35)'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='scale(1)';">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">Edit Payment</h1>
            <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.9); font-weight: 500;">Update the payment details</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('admin.payments.update', $payment) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Payment Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Payment Information</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Update the payment details.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="tenant_id" class="form-label fw-semibold" style="color: var(--text-primary);">Tenant</label>
                                <select name="tenant_id" id="tenant_id" required class="form-select @error('tenant_id') is-invalid @enderror">
                                    <option value="">Select a tenant</option>
                                    @foreach($tenants as $tenant)
                                        <option value="{{ $tenant->tenant_id }}" {{ old('tenant_id', $payment->tenant_id) == $tenant->tenant_id ? 'selected' : '' }}>
                                            {{ $tenant->name }} ({{ $tenant->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('tenant_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="booking_id" class="form-label fw-semibold" style="color: var(--text-primary);">Booking (Optional)</label>
                                <select name="booking_id" id="booking_id" class="form-select @error('booking_id') is-invalid @enderror">
                                    <option value="">Select a booking (optional)</option>
                                    @foreach($bookings as $booking)
                                        <option value="{{ $booking->booking_id }}" {{ old('booking_id', $payment->booking_id) == $booking->booking_id ? 'selected' : '' }}>
                                            Room {{ $booking->room->room_number ?? 'N/A' }} - {{ $booking->tenant->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('booking_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="amount" class="form-label fw-semibold" style="color: var(--text-primary);">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" name="amount" id="amount" step="0.01" min="0" required
                                           class="form-control @error('amount') is-invalid @enderror"
                                           value="{{ old('amount', $payment->amount) }}" placeholder="0.00">
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="payment_date" class="form-label fw-semibold" style="color: var(--text-primary);">Payment Date</label>
                                <input type="date" name="payment_date" id="payment_date" required
                                       class="form-control @error('payment_date') is-invalid @enderror"
                                       value="{{ old('payment_date', $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '') }}">
                                @error('payment_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="method" class="form-label fw-semibold" style="color: var(--text-primary);">Payment Method</label>
                                <select name="method" id="method" required class="form-select @error('method') is-invalid @enderror" disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                    <option value="">Select method</option>
                                    <option value="cash" {{ old('method', $payment->method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="gcash" {{ old('method', $payment->method) == 'gcash' ? 'selected' : '' }}>GCash</option>
                                </select>
                                <!-- Hidden input to submit the payment method value (disabled fields don't submit) -->
                                <input type="hidden" name="method" value="{{ old('method', $payment->method) }}">
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-lock me-1"></i>Payment method cannot be changed after creation
                                </small>
                                @error('method')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="status" class="form-label fw-semibold" style="color: var(--text-primary);">Status</label>
                                <select name="status" id="status" required class="form-select @error('status') is-invalid @enderror">
                                    <option value="">Select status</option>
                                    <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ old('status', $payment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ old('status', $payment->status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label fw-semibold" style="color: var(--text-primary);">Notes</label>
                                <textarea name="notes" id="notes" rows="3"
                                          class="form-control @error('notes') is-invalid @enderror"
                                          placeholder="Optional payment notes">{{ old('notes', $payment->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Receipt Image Upload -->
                            <div class="col-12">
                                <label for="receipt_image" class="form-label fw-semibold" style="color: var(--text-primary);">Receipt Image</label>
                                
                                @if($payment->receipt_image)
                                <div class="mb-3">
                                    <p class="small mb-2" style="color: var(--text-secondary);">Current Receipt:</p>
                                    <div class="futuristic-card p-3 d-inline-block" style="border-color: rgba(0, 102, 255, 0.2);">
                                        <img src="{{ Storage::url($payment->receipt_image) }}" 
                                             alt="Current Receipt" 
                                             class="img-thumbnail rounded" 
                                             style="width: 150px; height: 150px; object-fit: cover; border: 2px solid rgba(0, 102, 255, 0.3);">
                                    </div>
                                </div>
                                <p class="small mb-2" style="color: var(--text-secondary);">Upload a new receipt to replace the current one:</p>
                                @endif
                                
                                <div class="futuristic-card p-5 text-center border-2 border-dashed" 
                                     style="border-color: rgba(0, 102, 255, 0.3) !important; cursor: pointer;" 
                                     id="receipt-upload-area">
                                    <div>
                                        <i class="fas fa-cloud-upload-alt mb-3" style="font-size: 3rem; color: #0066ff;" id="upload-icon"></i>
                                        <div class="small mb-2">
                                            <label for="receipt_image" class="fw-semibold" style="color: #0066ff; cursor: pointer;">
                                                {{ $payment->receipt_image ? 'Upload new receipt image' : 'Upload a receipt image' }}
                                            </label>
                                            <span class="ms-1" style="color: var(--text-secondary);">or drag and drop</span>
                                        </div>
                                        <p class="small mb-0" style="color: var(--text-secondary);">PNG, JPG, GIF up to 10MB</p>
                                        <input id="receipt_image" name="receipt_image" type="file" class="d-none" accept="image/*" onchange="previewReceipt(this)">
                                    </div>
                                </div>
                                
                                <!-- Receipt Preview -->
                                <div id="receipt-preview" class="mt-4 d-none">
                                    <div class="futuristic-card p-4" style="border-color: rgba(0, 102, 255, 0.2);">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="small fw-semibold mb-0" style="color: var(--text-primary);">New Receipt Preview</h4>
                                            <button type="button" onclick="removeReceipt()" class="btn btn-sm" style="color: #ef4444;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <img id="receipt-preview-img" src="" alt="Receipt preview" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                                        <p id="receipt-filename" class="small mt-2 mb-0" style="color: var(--text-secondary);"></p>
                                    </div>
                                </div>
                                
                                @error('receipt_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-neon">
                    <i class="fas fa-save me-2"></i>Update Payment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewReceipt(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('receipt-preview');
            const previewImg = document.getElementById('receipt-preview-img');
            const filename = document.getElementById('receipt-filename');
            
            previewImg.src = e.target.result;
            filename.textContent = file.name;
            preview.classList.remove('d-none');
        };
        
        reader.readAsDataURL(file);
    }
}

function removeReceipt() {
    const input = document.getElementById('receipt_image');
    const preview = document.getElementById('receipt-preview');
    
    input.value = '';
    preview.classList.add('d-none');
}

// Drag and drop functionality
const uploadArea = document.getElementById('receipt-upload-area');
const fileInput = document.getElementById('receipt_image');

uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    uploadArea.style.borderColor = 'rgba(0, 102, 255, 0.5)';
    uploadArea.style.background = 'rgba(0, 102, 255, 0.05)';
});

uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    uploadArea.style.borderColor = 'rgba(0, 102, 255, 0.3)';
    uploadArea.style.background = 'transparent';
});

uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    uploadArea.style.borderColor = 'rgba(0, 102, 255, 0.3)';
    uploadArea.style.background = 'transparent';
    
    if (e.dataTransfer.files.length > 0) {
        fileInput.files = e.dataTransfer.files;
        previewReceipt(fileInput);
    }
});

uploadArea.addEventListener('click', function() {
    fileInput.click();
});
</script>
@endsection
