@extends('layouts.admin')

@section('title', 'Edit Room - ' . $room->room_number)
@section('page-title', 'Edit Room')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(34, 197, 94, 0.3); background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(0, 212, 255, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #22c55e;">Edit Room</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Update the room details and pricing</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('admin.rooms.update', $room) }}">
            @csrf
            @method('PUT')
            
            <!-- Room Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Room Information</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Update the room details and pricing.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="room_number" class="form-label fw-semibold" style="color: var(--text-primary);">Room Number</label>
                                <input type="text" name="room_number" id="room_number" required
                                       class="form-control @error('room_number') is-invalid @enderror"
                                       value="{{ old('room_number', $room->room_number) }}" placeholder="e.g., 101, A1, etc.">
                                @error('room_number')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="room_type" class="form-label fw-semibold" style="color: var(--text-primary);">Room Type</label>
                                <select name="room_type" id="room_type" required class="form-select @error('room_type') is-invalid @enderror">
                                    <option value="">Select room type</option>
                                    <option value="Single" {{ old('room_type', $room->room_type) == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Double" {{ old('room_type', $room->room_type) == 'Double' ? 'selected' : '' }}>Double</option>
                                    <option value="Twin" {{ old('room_type', $room->room_type) == 'Twin' ? 'selected' : '' }}>Twin</option>
                                    <option value="Suite" {{ old('room_type', $room->room_type) == 'Suite' ? 'selected' : '' }}>Suite</option>
                                    <option value="Dormitory" {{ old('room_type', $room->room_type) == 'Dormitory' ? 'selected' : '' }}>Dormitory</option>
                                </select>
                                @error('room_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="price" class="form-label fw-semibold" style="color: var(--text-primary);">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" name="price" id="price" step="0.01" min="0" required
                                           class="form-control @error('price') is-invalid @enderror"
                                           value="{{ old('price', $room->price) }}" placeholder="0.00">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="pricing_period" class="form-label fw-semibold" style="color: var(--text-primary);">Pricing Period</label>
                                <select name="pricing_period" id="pricing_period" required class="form-select @error('pricing_period') is-invalid @enderror">
                                    <option value="">Select pricing period</option>
                                    <option value="per_night" {{ old('pricing_period', $room->pricing_period) == 'per_night' ? 'selected' : '' }}>Per Night</option>
                                    <option value="monthly" {{ old('pricing_period', $room->pricing_period) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                </select>
                                @error('pricing_period')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold" style="color: var(--text-primary);">Description</label>
                                <textarea name="description" id="description" rows="3"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Room amenities, features, or special notes...">{{ old('description', $room->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-neon">
                    <i class="fas fa-save me-2"></i>Update Room
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
