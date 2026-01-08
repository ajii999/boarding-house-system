@extends('layouts.admin')

@section('title', 'Edit Tenant')
@section('page-title', 'Edit Tenant')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px;">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.tenants.index') }}" class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.35)'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='scale(1)';">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">Edit Tenant</h1>
            <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.9); font-weight: 500;">Update the tenant's basic information</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('admin.tenants.update', $tenant) }}">
            @csrf
            @method('PUT')
            
            <!-- Tenant Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Tenant Information</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Update the tenant's basic information.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label fw-semibold" style="color: var(--text-primary);">Full Name</label>
                                <input type="text" name="name" id="name" required
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $tenant->name) }}">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label fw-semibold" style="color: var(--text-primary);">Email Address</label>
                                <input type="email" name="email" id="email" required
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $tenant->email) }}">
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="contact_number" class="form-label fw-semibold" style="color: var(--text-primary);">Contact Number</label>
                                <input type="tel" name="contact_number" id="contact_number" required
                                       class="form-control @error('contact_number') is-invalid @enderror"
                                       value="{{ old('contact_number', $tenant->contact_number) }}">
                                @error('contact_number')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Profile Information</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Update additional tenant profile details.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="address" class="form-label fw-semibold" style="color: var(--text-primary);">Address</label>
                                <textarea name="address" id="address" rows="3"
                                          class="form-control @error('address') is-invalid @enderror">{{ old('address', $tenant->profile->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="emergency_contact" class="form-label fw-semibold" style="color: var(--text-primary);">Emergency Contact</label>
                                <input type="tel" name="emergency_contact" id="emergency_contact"
                                       class="form-control @error('emergency_contact') is-invalid @enderror"
                                       value="{{ old('emergency_contact', $tenant->profile->emergency_contact ?? '') }}">
                                @error('emergency_contact')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-neon">
                    <i class="fas fa-save me-2"></i>Update Tenant
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
