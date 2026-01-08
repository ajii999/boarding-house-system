@extends('layouts.admin')

@section('title', 'Create New Booking')
@section('page-title', 'Create New Booking')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(245, 158, 11, 0.3); background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #f59e0b;">Create New Booking</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Enter the booking details</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <!-- Display Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show futuristic-card mb-4" role="alert" style="border-color: rgba(239, 68, 68, 0.5);">
                <h5 class="alert-heading fw-bold mb-2">
                    <i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:
                </h5>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <form method="POST" action="{{ route('admin.bookings.store') }}" enctype="multipart/form-data" id="booking-form">
            @csrf
            
            <!-- Booking Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Booking Information</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Enter the booking details.</p>
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

                            <div class="col-12">
                                <label class="form-label fw-semibold" style="color: var(--text-primary);">Available Rooms <span class="text-danger">*</span></label>
                                <div class="futuristic-card p-3" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.02); max-height: 300px; overflow-y: auto;" id="room-selection">
                                    @if($rooms && $rooms->count() > 0)
                                        @foreach($rooms as $room)
                                            <label class="d-flex align-items-center p-3 mb-2 rounded futuristic-card cursor-pointer" 
                                                   style="border-color: rgba(0, 102, 255, 0.2); transition: all 0.3s;">
                                                <input type="radio" name="room_id" value="{{ $room->room_id }}" 
                                                       {{ old('room_id') == $room->room_id ? 'checked' : '' }}
                                                       class="form-check-input me-3" required>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <div>
                                                        <span class="fw-semibold" style="color: var(--text-primary);">Room {{ $room->room_number }}</span>
                                                        <span class="small ms-2" style="color: var(--text-secondary);">{{ $room->room_type }}</span>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="fw-bold" style="color: #0066ff;">₱{{ number_format($room->price, 2) }}</span>
                                                        <span class="small d-block" style="color: var(--text-secondary);">per night</span>
                                                    </div>
                                                </div>
                                                @if($room->description)
                                                    <p class="small mb-0" style="color: var(--text-secondary);">{{ $room->description }}</p>
                                                @endif
                                            </div>
                                        </label>
                                        @endforeach
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            No available rooms at the moment. Please add rooms first.
                                        </div>
                                    @endif
                                </div>
                                @error('room_id')
                                    <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="booking_date" class="form-label fw-semibold" style="color: var(--text-primary);">Booking Date</label>
                                <input type="date" name="booking_date" id="booking_date" required
                                       class="form-control @error('booking_date') is-invalid @enderror"
                                       value="{{ old('booking_date', date('Y-m-d')) }}">
                                @error('booking_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="status" value="confirmed">

                            <div class="col-12 col-md-6">
                                <label for="check_in" class="form-label fw-semibold" style="color: var(--text-primary);">Check In Date</label>
                                <input type="date" name="check_in" id="check_in" required
                                       class="form-control @error('check_in') is-invalid @enderror"
                                       value="{{ old('check_in') }}">
                                @error('check_in')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="check_out" class="form-label fw-semibold" style="color: var(--text-primary);">Check Out Date</label>
                                <input type="date" name="check_out" id="check_out" required
                                       class="form-control @error('check_out') is-invalid @enderror"
                                       value="{{ old('check_out') }}">
                                @error('check_out')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Section -->
                            <div class="col-12">
                                <h4 class="h5 fw-bold mb-3" style="color: var(--text-primary);">Payment Information</h4>
                            </div>

                            <!-- Payment Type Selection -->
                            <div class="col-12">
                                <label class="form-label fw-semibold mb-3" style="color: var(--text-primary);">Payment Type <span class="text-danger">*</span></label>
                                <div class="d-flex flex-column gap-3">
                                    <label class="futuristic-card p-4 cursor-pointer" 
                                           style="border-color: rgba(0, 102, 255, 0.2); transition: all 0.3s;">
                                        <input type="radio" name="payment_type" value="full_payment" class="form-check-input me-3" {{ old('payment_type', 'full_payment') == 'full_payment' ? 'checked' : '' }} required>
                                        <div class="d-inline-block">
                                            <div class="fw-semibold" style="color: var(--text-primary);">Full Payment</div>
                                            <div class="small" style="color: var(--text-secondary);">Pay the complete amount upfront</div>
                                        </div>
                                    </label>
                                    
                                    <label class="futuristic-card p-4 cursor-pointer" 
                                           style="border-color: rgba(0, 102, 255, 0.2); transition: all 0.3s;">
                                        <input type="radio" name="payment_type" value="down_payment" class="form-check-input me-3" {{ old('payment_type') == 'down_payment' ? 'checked' : '' }}>
                                        <div class="d-inline-block">
                                            <div class="fw-semibold" style="color: var(--text-primary);">Down Payment</div>
                                            <div class="small" style="color: var(--text-secondary);">Pay a portion now, remainder later</div>
                                        </div>
                                    </label>
                                </div>
                                @error('payment_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Method Selection -->
                            <div class="col-12" id="payment-method-section">
                                <label class="form-label fw-semibold mb-3" style="color: var(--text-primary);">Payment Method <span class="text-danger">*</span></label>
                                <div class="d-flex flex-column gap-3">
                                    <label class="futuristic-card p-4 cursor-pointer" 
                                           style="border-color: rgba(0, 102, 255, 0.2); transition: all 0.3s;">
                                        <input type="radio" name="payment_method" value="cash" class="form-check-input me-3" {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }} required>
                                        <div class="d-inline-block">
                                            <div class="fw-semibold" style="color: var(--text-primary);">Cash Payment</div>
                                            <div class="small" style="color: var(--text-secondary);">Pay in cash at the office</div>
                                        </div>
                                    </label>
                                    
                                    <label class="futuristic-card p-4 cursor-pointer" 
                                           style="border-color: rgba(0, 102, 255, 0.2); transition: all 0.3s;">
                                        <input type="radio" name="payment_method" value="online" class="form-check-input me-3" {{ old('payment_method') == 'online' ? 'checked' : '' }}>
                                        <div class="d-inline-block">
                                            <div class="fw-semibold" style="color: var(--text-primary);">Online Payment</div>
                                            <div class="small" style="color: var(--text-secondary);">Pay via e-wallet (GCash/Maya)</div>
                                        </div>
                                    </label>
                                </div>
                                @error('payment_method')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- E-Wallet Selection -->
                            <div class="col-12" id="ewallet-section" style="display: none;">
                                <label class="form-label fw-semibold mb-3" style="color: var(--text-primary);">Select E-Wallet</label>
                                <div class="d-flex flex-column gap-3">
                                    <label class="futuristic-card p-4 cursor-pointer" 
                                           style="border-color: rgba(0, 102, 255, 0.2); transition: all 0.3s;">
                                        <input type="radio" name="ewallet_type" value="gcash" class="form-check-input me-3" {{ old('ewallet_type') == 'gcash' ? 'checked' : '' }}>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                                                <i class="fas fa-mobile-alt" style="color: #0066ff;"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold" style="color: var(--text-primary);">GCash</div>
                                                <div class="small" style="color: var(--text-secondary);">Pay via GCash QR code</div>
                                            </div>
                                        </div>
                                    </label>
                                    
                                    <label class="futuristic-card p-4 cursor-pointer" 
                                           style="border-color: rgba(124, 58, 237, 0.2); transition: all 0.3s;">
                                        <input type="radio" name="ewallet_type" value="maya" class="form-check-input me-3" {{ old('ewallet_type') == 'maya' ? 'checked' : '' }}>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px; background: rgba(124, 58, 237, 0.1); border: 2px solid rgba(124, 58, 237, 0.3);">
                                                <i class="fas fa-wallet" style="color: #7c3aed;"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold" style="color: var(--text-primary);">Maya</div>
                                                <div class="small" style="color: var(--text-secondary);">Pay via Maya QR code</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @error('ewallet_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Down Payment Amount -->
                            <div class="col-12" id="down-payment-amount-section" style="display: none;">
                                <label for="down_payment_amount" class="form-label fw-semibold" style="color: var(--text-primary);">Down Payment Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" name="down_payment_amount" id="down_payment_amount" step="0.01" min="100"
                                           class="form-control @error('down_payment_amount') is-invalid @enderror"
                                           value="{{ old('down_payment_amount') }}" placeholder="0.00">
                                </div>
                                <p class="small mt-1" style="color: var(--text-secondary);">Minimum amount: ₱100.00</p>
                                @error('down_payment_amount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Receipt Upload -->
                            <div class="col-12" id="receipt-upload-section">
                                <label for="payment_receipt" class="form-label fw-semibold" style="color: var(--text-primary);">Payment Receipt <span class="small text-muted">(Optional for cash payments)</span></label>
                                <div class="futuristic-card p-5 text-center border-2 border-dashed" 
                                     style="border-color: rgba(0, 102, 255, 0.3) !important; cursor: pointer;" 
                                     id="payment-upload-area">
                                    <div>
                                        <i class="fas fa-cloud-upload-alt mb-3" style="font-size: 3rem; color: #0066ff;" id="payment-upload-icon"></i>
                                        <div class="small mb-2">
                                            <label for="payment_receipt" class="fw-semibold" style="color: #0066ff; cursor: pointer;">
                                                Upload payment receipt
                                            </label>
                                            <span class="ms-1" style="color: var(--text-secondary);">or drag and drop</span>
                                        </div>
                                        <p class="small mb-0" style="color: var(--text-secondary);">PNG, JPG, GIF up to 10MB</p>
                                        <input id="payment_receipt" name="payment_receipt" type="file" class="d-none" accept="image/*" onchange="previewPaymentReceipt(this)">
                                    </div>
                                </div>
                                
                                <!-- Payment Receipt Preview -->
                                <div id="payment-receipt-preview" class="mt-4 d-none">
                                    <div class="futuristic-card p-4" style="border-color: rgba(0, 102, 255, 0.2);">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="small fw-semibold mb-0" style="color: var(--text-primary);">Payment Receipt Preview</h4>
                                            <button type="button" onclick="removePaymentReceipt()" class="btn btn-sm" style="color: #ef4444;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <img id="payment-receipt-preview-img" src="" alt="Payment receipt preview" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                                        <p id="payment-receipt-filename" class="small mt-2 mb-0" style="color: var(--text-secondary);"></p>
                                    </div>
                                </div>
                                
                                @error('payment_receipt')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- QR Code Display -->
                            <div class="col-12" id="qr-code-section" style="display: none;">
                                <div class="futuristic-card p-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.05), rgba(124, 58, 237, 0.05));">
                                    <div class="text-center">
                                        <h4 class="h5 fw-bold mb-4" style="color: var(--text-primary);">Scan QR Code to Pay</h4>
                                        <div class="futuristic-card p-4 d-inline-block" style="border-color: rgba(0, 102, 255, 0.2);">
                                            <div id="qr-code-display" class="d-flex align-items-center justify-content-center" style="width: 200px; height: 200px; background: rgba(0, 102, 255, 0.05); border-radius: 12px;">
                                                <div class="text-center">
                                                    <i class="fas fa-qrcode mb-2" style="font-size: 3rem; color: #0066ff;"></i>
                                                    <p class="small mb-0" style="color: var(--text-secondary);">QR Code will appear here</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="small mt-4 mb-0" style="color: var(--text-secondary);">Scan this QR code with your e-wallet app to complete payment</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-neon" id="submit-btn">
                    <i class="fas fa-plus me-2"></i>Create Booking
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Payment receipt preview functions
function previewPaymentReceipt(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('payment-receipt-preview');
            const previewImg = document.getElementById('payment-receipt-preview-img');
            const filename = document.getElementById('payment-receipt-filename');
            
            previewImg.src = e.target.result;
            filename.textContent = file.name;
            preview.classList.remove('d-none');
        };
        
        reader.readAsDataURL(file);
    }
}

function removePaymentReceipt() {
    const input = document.getElementById('payment_receipt');
    const preview = document.getElementById('payment-receipt-preview');
    
    input.value = '';
    preview.classList.add('d-none');
}

// Generate QR Code for e-wallet payments
function generateQRCode(ewalletType, amount) {
    const qrDisplay = document.getElementById('qr-code-display');
    qrDisplay.innerHTML = `
        <div class="text-center">
            <div class="d-inline-block p-3 rounded" style="background: rgba(0, 102, 255, 0.1);">
                <i class="fas fa-qrcode mb-2" style="font-size: 4rem; color: #0066ff;"></i>
            </div>
            <p class="small fw-semibold mt-2 mb-0" style="color: var(--text-primary);">${ewalletType.toUpperCase()} QR Code</p>
            <p class="small mb-0" style="color: var(--text-secondary);">Amount: ₱${amount}</p>
        </div>
    `;
}

document.addEventListener('DOMContentLoaded', function() {
    const paymentTypeRadios = document.querySelectorAll('input[name="payment_type"]');
    const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
    const ewalletRadios = document.querySelectorAll('input[name="ewallet_type"]');
    
    const downPaymentSection = document.getElementById('down-payment-amount-section');
    const ewalletSection = document.getElementById('ewallet-section');
    const receiptSection = document.getElementById('receipt-upload-section');
    const qrCodeSection = document.getElementById('qr-code-section');
    
    // Payment type change handler
    paymentTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const downPaymentInput = document.getElementById('down_payment_amount');
            if (this.value === 'down_payment') {
                downPaymentSection.style.display = 'block';
                if (downPaymentInput) {
                    downPaymentInput.setAttribute('required', 'required');
                }
            } else {
                downPaymentSection.style.display = 'none';
                if (downPaymentInput) {
                    downPaymentInput.removeAttribute('required');
                    downPaymentInput.value = ''; // Clear the value when hidden
                }
            }
        });
    });
    
    // Payment method change handler
    paymentMethodRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'online') {
                ewalletSection.style.display = 'block';
                receiptSection.style.display = 'block';
            } else {
                ewalletSection.style.display = 'none';
                qrCodeSection.style.display = 'none';
                receiptSection.style.display = 'block';
            }
        });
    });
    
    // Trigger initial state
    const initialPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
    if (initialPaymentMethod) {
        initialPaymentMethod.dispatchEvent(new Event('change'));
    }
    
    // E-wallet selection handler
    ewalletRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                qrCodeSection.style.display = 'block';
                
                const paymentType = document.querySelector('input[name="payment_type"]:checked');
                let amount = 0;
                
                if (paymentType && paymentType.value === 'down_payment') {
                    const downPaymentAmount = document.getElementById('down_payment_amount').value;
                    amount = downPaymentAmount || 0;
                } else {
                    amount = 1000; // Placeholder amount
                }
                
                generateQRCode(this.value, amount);
            }
        });
    });
    
    // Down payment amount change handler
    const downPaymentAmountInput = document.getElementById('down_payment_amount');
    if (downPaymentAmountInput) {
        downPaymentAmountInput.addEventListener('input', function() {
            const selectedEwallet = document.querySelector('input[name="ewallet_type"]:checked');
            if (selectedEwallet) {
                generateQRCode(selectedEwallet.value, this.value);
            }
        });
    }
    
    // Initialize form state
    const selectedPaymentType = document.querySelector('input[name="payment_type"]:checked');
    const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
    
    if (selectedPaymentType && selectedPaymentType.value === 'down_payment') {
        downPaymentSection.style.display = 'block';
    }
    
    // Receipt section is always visible now, but e-wallet section depends on payment method
    if (selectedPaymentMethod && selectedPaymentMethod.value === 'online') {
        ewalletSection.style.display = 'block';
    } else {
        ewalletSection.style.display = 'none';
        qrCodeSection.style.display = 'none';
    }
    
    // Form submission handler
    const form = document.getElementById('booking-form');
    const submitBtn = document.getElementById('submit-btn');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            // Clear down payment amount if full payment is selected
            const selectedPaymentType = document.querySelector('input[name="payment_type"]:checked');
            const downPaymentInput = document.getElementById('down_payment_amount');
            
            if (selectedPaymentType && selectedPaymentType.value === 'full_payment' && downPaymentInput) {
                downPaymentInput.value = '';
                downPaymentInput.removeAttribute('required');
            }
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
            
            // Let the form submit normally
        });
    }
});
</script>
@endsection
