@extends('layouts.tenant')

@section('title', 'Edit Maintenance Request')
@section('page-title', 'Edit Maintenance Request')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.5); background: linear-gradient(135deg, #0066ff, #7c3aed, #6366f1); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.4), 0 0 30px rgba(124, 58, 237, 0.3);">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('tenant.maintenance.index') }}" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);">
            <i class="fas fa-arrow-left" style="color: #0066ff;"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">Edit Maintenance Request</h1>
            <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.95);">Update the maintenance request details</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('tenant.maintenance.update', $maintenance) }}">
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
                                <label for="issue_type" class="form-label fw-semibold" style="color: var(--text-primary);">Issue Type</label>
                                <select name="issue_type" id="issue_type" required class="form-select @error('issue_type') is-invalid @enderror">
                                    <option value="">Select issue type</option>
                                    <option value="Plumbing" {{ old('issue_type', $maintenance->issue_type) == 'Plumbing' ? 'selected' : '' }}>Plumbing</option>
                                    <option value="Electrical" {{ old('issue_type', $maintenance->issue_type) == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                                    <option value="HVAC" {{ old('issue_type', $maintenance->issue_type) == 'HVAC' ? 'selected' : '' }}>HVAC</option>
                                    <option value="Appliance" {{ old('issue_type', $maintenance->issue_type) == 'Appliance' ? 'selected' : '' }}>Appliance</option>
                                    <option value="Furniture" {{ old('issue_type', $maintenance->issue_type) == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                    <option value="Door/Lock" {{ old('issue_type', $maintenance->issue_type) == 'Door/Lock' ? 'selected' : '' }}>Door/Lock</option>
                                    <option value="Window" {{ old('issue_type', $maintenance->issue_type) == 'Window' ? 'selected' : '' }}>Window</option>
                                    <option value="Flooring" {{ old('issue_type', $maintenance->issue_type) == 'Flooring' ? 'selected' : '' }}>Flooring</option>
                                    <option value="Paint" {{ old('issue_type', $maintenance->issue_type) == 'Paint' ? 'selected' : '' }}>Paint</option>
                                    <option value="Other" {{ old('issue_type', $maintenance->issue_type) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('issue_type')
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('tenant.maintenance.index') }}" class="btn btn-secondary">
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
