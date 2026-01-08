@extends('layouts.admin')

@section('title', 'Edit Maintenance Request')
@section('page-title', 'Edit Maintenance Request')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px;">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.maintenance.index') }}" class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.35)'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='scale(1)';">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">Edit Maintenance Request</h1>
            <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.9); font-weight: 500;">Update the maintenance request details</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('admin.maintenance.update', $maintenance->request_id) }}">
            @csrf
            @method('PUT')
            
            <!-- Maintenance Request Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Maintenance Request</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Update the maintenance request details.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="tenant_id" class="form-label fw-semibold" style="color: var(--text-primary);">Tenant</label>
                                <select name="tenant_id" id="tenant_id" required class="form-select @error('tenant_id') is-invalid @enderror">
                                    <option value="">Select a tenant</option>
                                    @foreach($tenants as $tenant)
                                        <option value="{{ $tenant->tenant_id }}" {{ old('tenant_id', $maintenance->tenant_id) == $tenant->tenant_id ? 'selected' : '' }}>
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
                                        <option value="{{ $room->room_id }}" {{ old('room_id', $maintenance->room_id) == $room->room_id ? 'selected' : '' }}>
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
                                       value="{{ old('issue_type', $maintenance->issue_type) }}" placeholder="e.g., Plumbing, Electrical, HVAC">
                                @error('issue_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold" style="color: var(--text-primary);">Description</label>
                                <textarea name="description" id="description" rows="4" required
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Describe the maintenance issue in detail">{{ old('description', $maintenance->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="request_date" class="form-label fw-semibold" style="color: var(--text-primary);">Request Date</label>
                                <input type="date" name="request_date" id="request_date" required
                                       class="form-control @error('request_date') is-invalid @enderror"
                                       value="{{ old('request_date', $maintenance->request_date ? $maintenance->request_date->format('Y-m-d') : '') }}">
                                @error('request_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="priority" class="form-label fw-semibold" style="color: var(--text-primary);">Priority</label>
                                <select name="priority" id="priority" required class="form-select @error('priority') is-invalid @enderror">
                                    <option value="">Select priority</option>
                                    <option value="low" {{ old('priority', $maintenance->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', $maintenance->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority', $maintenance->priority) == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ old('priority', $maintenance->priority) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="admin_notes" class="form-label fw-semibold" style="color: var(--text-primary);">Admin Notes</label>
                                <textarea name="admin_notes" id="admin_notes" rows="3"
                                          class="form-control @error('admin_notes') is-invalid @enderror"
                                          placeholder="Optional admin notes">{{ old('admin_notes', $maintenance->admin_notes) }}</textarea>
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
                    <i class="fas fa-save me-2"></i>Update Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
