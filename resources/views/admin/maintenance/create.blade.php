@extends('layouts.admin')

@section('title', 'Create Maintenance Request')
@section('page-title', 'Create Maintenance Request')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(245, 158, 11, 0.3); background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.maintenance.index') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #f59e0b;">Create Maintenance Request</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Enter the maintenance request details</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('admin.maintenance.store') }}">
            @csrf
            
            <!-- Maintenance Request Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Maintenance Request</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Enter the maintenance request details.</p>
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
                                <label for="room_id" class="form-label fw-semibold" style="color: var(--text-primary);">Room (Optional)</label>
                                <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror">
                                    <option value="">Select a room (optional)</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->room_id }}" {{ old('room_id') == $room->room_id ? 'selected' : '' }}>
                                            Room {{ $room->room_number }} - {{ $room->room_type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="issue_type" class="form-label fw-semibold" style="color: var(--text-primary);">Issue Type</label>
                                <input type="text" name="issue_type" id="issue_type" required
                                       class="form-control @error('issue_type') is-invalid @enderror"
                                       value="{{ old('issue_type') }}" placeholder="e.g., Plumbing, Electrical, HVAC">
                                @error('issue_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold" style="color: var(--text-primary);">Description</label>
                                <textarea name="description" id="description" rows="4" required
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Describe the maintenance issue in detail">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="request_date" class="form-label fw-semibold" style="color: var(--text-primary);">Request Date</label>
                                <input type="date" name="request_date" id="request_date" required
                                       class="form-control @error('request_date') is-invalid @enderror"
                                       value="{{ old('request_date', date('Y-m-d')) }}">
                                @error('request_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="priority" class="form-label fw-semibold" style="color: var(--text-primary);">Priority</label>
                                <select name="priority" id="priority" required class="form-select @error('priority') is-invalid @enderror">
                                    <option value="">Select priority</option>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="admin_notes" class="form-label fw-semibold" style="color: var(--text-primary);">Admin Notes</label>
                                <textarea name="admin_notes" id="admin_notes" rows="3"
                                          class="form-control @error('admin_notes') is-invalid @enderror"
                                          placeholder="Optional admin notes">{{ old('admin_notes') }}</textarea>
                                @error('admin_notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.maintenance.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-neon">
                    <i class="fas fa-plus me-2"></i>Create Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
