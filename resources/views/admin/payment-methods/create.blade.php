@extends('layouts.admin')

@section('title', 'Create Payment Method')
@section('page-title', 'Create Payment Method')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff;">Create Payment Method</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Enter the payment method details</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form action="{{ route('admin.payment-methods.store') }}" method="POST">
            @csrf
            
            <!-- Payment Method Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Payment Method Information</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Enter the payment method details.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label fw-semibold" style="color: var(--text-primary);">Name</label>
                                <input type="text" name="name" id="name" required
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="e.g., GCash, Bank Transfer">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="type" class="form-label fw-semibold" style="color: var(--text-primary);">Type</label>
                                <select name="type" id="type" required class="form-select @error('type') is-invalid @enderror">
                                    <option value="">Select type</option>
                                    <option value="digital_wallet" {{ old('type') == 'digital_wallet' ? 'selected' : '' }}>Digital Wallet (GCash, PayMaya, etc.)</option>
                                    <option value="bank_transfer" {{ old('type') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="online" {{ old('type') == 'online' ? 'selected' : '' }}>Online Payment</option>
                                    <option value="offline" {{ old('type') == 'offline' ? 'selected' : '' }}>Offline Payment</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold" style="color: var(--text-primary);">Description</label>
                                <textarea name="description" id="description" rows="3"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Optional description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="processing_fee" class="form-label fw-semibold" style="color: var(--text-primary);">Processing Fee (₱)</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" name="processing_fee" id="processing_fee" step="0.01" min="0" required
                                           class="form-control @error('processing_fee') is-invalid @enderror"
                                           value="{{ old('processing_fee', 0) }}" placeholder="0.00">
                                </div>
                                @error('processing_fee')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="processing_time_hours" class="form-label fw-semibold" style="color: var(--text-primary);">Processing Time (hours)</label>
                                <input type="number" name="processing_time_hours" id="processing_time_hours" min="0" required
                                       class="form-control @error('processing_time_hours') is-invalid @enderror"
                                       value="{{ old('processing_time_hours', 24) }}" placeholder="24">
                                @error('processing_time_hours')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" 
                                               class="form-check-input" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label for="is_active" class="form-check-label fw-semibold" style="color: var(--text-primary);">
                                            Active
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" name="requires_verification" id="requires_verification" value="1" 
                                               class="form-check-input"
                                               {{ old('requires_verification') ? 'checked' : '' }}>
                                        <label for="requires_verification" class="form-check-label fw-semibold" style="color: var(--text-primary);">
                                            Requires Verification
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-neon">
                    <i class="fas fa-plus me-2"></i>Create Payment Method
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
