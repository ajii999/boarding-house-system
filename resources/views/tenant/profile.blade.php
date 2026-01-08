@extends('layouts.tenant')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(124, 58, 237, 0.15)); border: 2px solid rgba(0, 102, 255, 0.4); box-shadow: 0 0 30px rgba(0, 102, 255, 0.3);">
                <i class="fas fa-user" style="font-size: 2.5rem; color: #0066ff;"></i>
            </div>
            <div>
                <h1 class="h3 fw-bold mb-1" style="background: linear-gradient(135deg, #0066ff, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $tenant->name }}</h1>
                <p class="mb-1" style="color: var(--text-secondary);">{{ $tenant->email }}</p>
                <p class="small mb-0" style="color: var(--text-secondary);">Member since {{ $tenant->created_at->format('F j, Y') }}</p>
            </div>
        </div>
        <button id="edit-toggle" class="btn btn-neon px-4 py-2">
            <i class="fas fa-edit me-2"></i>
            <span id="edit-text">Edit Profile</span>
        </button>
    </div>
</div>

<!-- Profile Information Card -->
<div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded d-flex align-items-center justify-content-center" 
                 style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(0, 102, 255, 0.1)); border: 2px solid rgba(0, 102, 255, 0.5);">
                <i class="fas fa-user-circle" style="color: #0066ff;"></i>
            </div>
            <div>
                <h3 class="h5 fw-bold mb-1" style="color: #0066ff;">Profile Information</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Your personal information and contact details</p>
            </div>
        </div>
    </div>
    
    <!-- View Mode -->
    <div id="view-mode" class="p-4 p-md-5">
        <div class="row g-4">
            <div class="col-12 col-md-6">
                <div class="futuristic-card p-4 mb-3" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(0, 102, 255, 0.1)); border: 2px solid rgba(0, 102, 255, 0.3);">
                            <i class="fas fa-user" style="color: #0066ff;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Full Name</p>
                            <p class="h6 fw-bold mb-0" style="color: var(--text-primary);">{{ $tenant->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="futuristic-card p-4 mb-3" style="border-color: rgba(34, 197, 94, 0.2); background: rgba(34, 197, 94, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.3);">
                            <i class="fas fa-envelope" style="color: #22c55e;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Email Address</p>
                            <p class="h6 fw-bold mb-0" style="color: var(--text-primary);">{{ $tenant->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="futuristic-card p-4" style="border-color: rgba(0, 212, 255, 0.2); background: rgba(0, 212, 255, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.3);">
                            <i class="fas fa-phone" style="color: #00d4ff;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Contact Number</p>
                            <p class="h6 fw-bold mb-0" style="color: var(--text-primary);">{{ $tenant->contact_number }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                @if($tenant->profile)
                <div class="futuristic-card p-4 mb-3" style="border-color: rgba(245, 158, 11, 0.2); background: rgba(245, 158, 11, 0.05);">
                    <div class="d-flex align-items-start">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.1)); border: 2px solid rgba(245, 158, 11, 0.3);">
                            <i class="fas fa-map-marker-alt" style="color: #f59e0b;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Address</p>
                            <p class="h6 fw-bold mb-0" style="color: var(--text-primary);">{{ $tenant->profile->address ?: 'Not provided' }}</p>
                        </div>
                    </div>
                </div>

                <div class="futuristic-card p-4 mb-3" style="border-color: rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1)); border: 2px solid rgba(239, 68, 68, 0.3);">
                            <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Emergency Contact</p>
                            <p class="h6 fw-bold mb-0" style="color: var(--text-primary);">{{ $tenant->profile->emergency_contact ?: 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="futuristic-card p-4" style="border-color: rgba(148, 163, 184, 0.2); background: rgba(148, 163, 184, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(148, 163, 184, 0.2), rgba(148, 163, 184, 0.1)); border: 2px solid rgba(148, 163, 184, 0.3);">
                            <i class="fas fa-calendar" style="color: #94a3b8;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Member Since</p>
                            <p class="h6 fw-bold mb-0" style="color: var(--text-primary);">{{ $tenant->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Mode -->
    <div id="edit-mode" class="p-4 p-md-5 d-none">
        <form method="POST" action="{{ route('tenant.profile.update') }}">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label for="name" class="form-label fw-semibold" style="color: var(--text-primary);">
                        <i class="fas fa-user me-2" style="color: #0066ff;"></i>Full Name
                    </label>
                    <input type="text" name="name" id="name" required
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $tenant->name) }}">
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label for="email" class="form-label fw-semibold" style="color: var(--text-primary);">
                        <i class="fas fa-envelope me-2" style="color: #22c55e;"></i>Email Address
                    </label>
                    <input type="email" name="email" id="email" required
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $tenant->email) }}">
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label for="contact_number" class="form-label fw-semibold" style="color: var(--text-primary);">
                        <i class="fas fa-phone me-2" style="color: #00d4ff;"></i>Contact Number
                    </label>
                    <input type="tel" name="contact_number" id="contact_number" required
                           class="form-control @error('contact_number') is-invalid @enderror"
                           value="{{ old('contact_number', $tenant->contact_number) }}">
                    @error('contact_number')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label for="address" class="form-label fw-semibold" style="color: var(--text-primary);">
                        <i class="fas fa-map-marker-alt me-2" style="color: #f59e0b;"></i>Address
                    </label>
                    <textarea name="address" id="address" rows="3"
                              class="form-control @error('address') is-invalid @enderror">{{ old('address', $tenant->profile->address ?? '') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="emergency_contact" class="form-label fw-semibold" style="color: var(--text-primary);">
                        <i class="fas fa-exclamation-triangle me-2" style="color: #ef4444;"></i>Emergency Contact
                    </label>
                    <input type="tel" name="emergency_contact" id="emergency_contact"
                           class="form-control @error('emergency_contact') is-invalid @enderror"
                           value="{{ old('emergency_contact', $tenant->profile->emergency_contact ?? '') }}">
                    @error('emergency_contact')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 pt-4 border-top mt-4" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <button type="button" id="cancel-edit" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" class="btn btn-neon">
                    <i class="fas fa-save me-2"></i>Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editToggle = document.getElementById('edit-toggle');
    const editText = document.getElementById('edit-text');
    const viewMode = document.getElementById('view-mode');
    const editMode = document.getElementById('edit-mode');
    const cancelEdit = document.getElementById('cancel-edit');

    editToggle.addEventListener('click', function() {
        if (viewMode.classList.contains('d-none')) {
            viewMode.classList.remove('d-none');
            editMode.classList.add('d-none');
            editText.textContent = 'Edit Profile';
            editToggle.classList.remove('btn-danger');
            editToggle.classList.add('btn-neon');
        } else {
            viewMode.classList.add('d-none');
            editMode.classList.remove('d-none');
            editText.textContent = 'View Profile';
            editToggle.classList.remove('btn-neon');
            editToggle.classList.add('btn-danger');
        }
    });

    cancelEdit.addEventListener('click', function() {
        viewMode.classList.remove('d-none');
        editMode.classList.add('d-none');
        editText.textContent = 'Edit Profile';
        editToggle.classList.remove('btn-danger');
        editToggle.classList.add('btn-neon');
    });
});
</script>
@endsection
