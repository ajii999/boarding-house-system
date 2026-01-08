@extends('layouts.admin')

@section('title', 'Add New Payment')
@section('page-title', 'Add New Payment')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(34, 197, 94, 0.3); background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(0, 212, 255, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.payments.index') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #22c55e;">Add New Payment</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Enter the payment details</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('admin.payments.store') }}" enctype="multipart/form-data">
        @csrf
            
            <!-- Payment Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Payment Information</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Enter the payment details.</p>
                </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="tenant_id" class="form-label fw-semibold" style="color: var(--text-primary);">Tenant</label>
                                <select name="tenant_id" id="tenant_id" required class="form-select @error('tenant_id') is-invalid @enderror">
                                <option value="">Select a tenant</option>
                                @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->tenant_id }}" {{ old('tenant_id') == $tenant->tenant_id ? 'selected' : '' }}>
                                        {{ $tenant->name }} ({{ $tenant->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('tenant_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="booking_id" id="booking_id" value="{{ old('booking_id') }}">
                        
                        <!-- Booked Room Details Display -->
                            <div class="col-12" id="room-details" style="display: none;">
                                <div class="futuristic-card p-4" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.05), rgba(0, 102, 255, 0.02));">
                                    <h4 class="small fw-semibold mb-3" style="color: #0066ff;">Booked Room Details</h4>
                                    <div id="room-info" class="small" style="color: var(--text-primary);">
                                    <!-- Room details will be populated here -->
                                </div>
                            </div>
                        </div>

                            <div class="col-12 col-md-6">
                                <label for="amount" class="form-label fw-semibold" style="color: var(--text-primary);">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" name="amount" id="amount" step="0.01" min="0" required
                                           class="form-control @error('amount') is-invalid @enderror"
                                           value="{{ old('amount') }}" placeholder="0.00">
                                </div>
                            @error('amount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                            <div class="col-12 col-md-6">
                                <label for="payment_date" class="form-label fw-semibold" style="color: var(--text-primary);">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" required
                                       class="form-control @error('payment_date') is-invalid @enderror"
                                   value="{{ old('payment_date', date('Y-m-d')) }}">
                            @error('payment_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                            <div class="col-12 col-md-6">
                                <label for="method" class="form-label fw-semibold" style="color: var(--text-primary);">Payment Method</label>
                                <select name="method" id="method" required class="form-select @error('method') is-invalid @enderror">
                                <option value="">Select method</option>
                                <option value="cash" {{ old('method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="gcash" {{ old('method') == 'gcash' ? 'selected' : '' }}>GCash</option>
                            </select>
                            @error('method')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="status" value="completed">

                            <div class="col-12">
                                <label for="notes" class="form-label fw-semibold" style="color: var(--text-primary);">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                          class="form-control @error('notes') is-invalid @enderror"
                                      placeholder="Optional payment notes">{{ old('notes') }}</textarea>
                            @error('notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Receipt Upload -->
                            <div class="col-12">
                                <label for="receipt_image" class="form-label fw-semibold" style="color: var(--text-primary);">Receipt Image (Optional)</label>
                                <div class="futuristic-card p-5 text-center border-2 border-dashed" 
                                     style="border-color: rgba(0, 102, 255, 0.3) !important; cursor: pointer;" 
                                     id="receipt-upload-area">
                                    <div>
                                        <i class="fas fa-cloud-upload-alt mb-3" style="font-size: 3rem; color: #0066ff;" id="upload-icon"></i>
                                        <div class="small mb-2">
                                            <label for="receipt_image" class="fw-semibold" style="color: #0066ff; cursor: pointer;">
                                                Upload a receipt image
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
                                            <h4 class="small fw-semibold mb-0" style="color: var(--text-primary);">Receipt Preview</h4>
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
                    <i class="fas fa-plus me-2"></i>Create Payment
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

document.addEventListener('DOMContentLoaded', function() {
    const tenantSelect = document.getElementById('tenant_id');
    const roomDetails = document.getElementById('room-details');
    const roomInfo = document.getElementById('room-info');
    const bookingIdField = document.getElementById('booking_id');
    const amountField = document.getElementById('amount');

    tenantSelect.addEventListener('change', function() {
        const tenantId = this.value;
        
        if (tenantId) {
            fetch(`/admin/tenants/${tenantId}/active-booking`)
                .then(response => response.json())
                .then(data => {
                    if (data.booking) {
                        roomInfo.innerHTML = `
                            <div class="row g-3">
                                <div class="col-6">
                                    <strong>Room:</strong> ${data.booking.room.room_number}<br>
                                    <strong>Type:</strong> ${data.booking.room.room_type}<br>
                                    <strong>Daily Rate:</strong> ₱${parseFloat(data.booking.room.price).toFixed(2)}
                                </div>
                                <div class="col-6">
                                    <strong>Check-in:</strong> ${data.booking.check_in}<br>
                                    <strong>Check-out:</strong> ${data.booking.check_out}<br>
                                    <strong>Total Amount:</strong> ₱${parseFloat(data.booking.total_amount).toFixed(2)}
                                </div>
                            </div>
                        `;
                        
                        bookingIdField.value = data.booking.booking_id;
                        amountField.value = parseFloat(data.booking.total_amount).toFixed(2);
                        
                        roomDetails.style.display = 'block';
                    } else {
                        roomDetails.style.display = 'none';
                        bookingIdField.value = '';
                        amountField.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error fetching booking details:', error);
                    roomDetails.style.display = 'none';
                });
        } else {
            roomDetails.style.display = 'none';
            bookingIdField.value = '';
            amountField.value = '';
        }
    });
});
</script>
@endsection
