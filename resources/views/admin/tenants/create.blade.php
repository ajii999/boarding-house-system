@extends('layouts.admin')

@section('title', 'Add New Tenant')
@section('page-title', 'Add New Tenant')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.tenants.index') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff;">Add New Tenant</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Enter the tenant's basic information</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('admin.tenants.store') }}">
            @csrf
            
            <!-- Tenant Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Tenant Information</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Enter the tenant's basic information.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label fw-semibold" style="color: var(--text-primary);">Full Name</label>
                                <input type="text" name="name" id="name" required
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label fw-semibold" style="color: var(--text-primary);">Email Address</label>
                                <input type="email" name="email" id="email" required
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="contact_number" class="form-label fw-semibold" style="color: var(--text-primary);">Contact Number</label>
                                <input type="tel" name="contact_number" id="contact_number" required
                                       class="form-control @error('contact_number') is-invalid @enderror"
                                       value="{{ old('contact_number') }}">
                                @error('contact_number')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="password" class="form-label fw-semibold" style="color: var(--text-primary);">Password</label>
                                <input type="password" name="password" id="password" required
                                       class="form-control @error('password') is-invalid @enderror">
                                @error('password')
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
                        <p class="small mb-0" style="color: var(--text-secondary);">Additional tenant profile details.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="address" class="form-label fw-semibold" style="color: var(--text-primary);">Address</label>
                                <textarea name="address" id="address" rows="3"
                                          class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="emergency_contact" class="form-label fw-semibold" style="color: var(--text-primary);">Emergency Contact</label>
                                <input type="tel" name="emergency_contact" id="emergency_contact"
                                       class="form-control @error('emergency_contact') is-invalid @enderror"
                                       value="{{ old('emergency_contact') }}">
                                @error('emergency_contact')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Assignment Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Room Assignment</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Optionally assign a room to the tenant immediately.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="room_id" class="form-label fw-semibold" style="color: var(--text-primary);">Room</label>
                                <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror">
                                    <option value="">No room assignment (assign later)</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->room_id }}" {{ old('room_id') == $room->room_id ? 'selected' : '' }}>
                                            Room {{ $room->room_number }} - {{ $room->room_type }} (₱{{ number_format($room->price, 2) }}/night)
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Available Rooms Display -->
                            <div class="col-12">
                                <label class="form-label fw-semibold mb-3" style="color: var(--text-primary);">Available Rooms & Prices</label>
                                <div class="futuristic-card p-4" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.02); max-height: 300px; overflow-y: auto;">
                                    <div class="row g-3">
                                        @forelse($rooms as $room)
                                        <div class="col-12 col-md-6">
                                            <div class="futuristic-card p-3 h-100" style="border-color: rgba(0, 102, 255, 0.2); transition: all 0.3s;">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div>
                                                        <h4 class="small fw-semibold mb-1" style="color: var(--text-primary);">Room {{ $room->room_number }}</h4>
                                                        <p class="small mb-0" style="color: var(--text-secondary);">{{ ucfirst($room->room_type) }}</p>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="fw-bold" style="color: #0066ff;">₱{{ number_format($room->price, 2) }}</span>
                                                        <p class="small mb-0" style="color: var(--text-secondary);">per night</p>
                                                    </div>
                                                </div>
                                                @if($room->description)
                                                    <p class="small mt-2 mb-2" style="color: var(--text-secondary);">{{ $room->description }}</p>
                                                @endif
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span class="badge px-2 py-1 rounded-pill" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;">
                                                        <i class="fas fa-check-circle me-1"></i>Available
                                                    </span>
                                                    <button type="button" onclick="selectRoom({{ $room->room_id }})" 
                                                            class="btn btn-sm p-0 border-0 bg-transparent" style="color: #0066ff;">
                                                        <i class="fas fa-plus me-1"></i>Select
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="col-12 text-center py-5">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                                 style="width: 60px; height: 60px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                                                <i class="fas fa-bed" style="font-size: 1.5rem; color: #0066ff;"></i>
                                            </div>
                                            <p class="mb-0" style="color: var(--text-secondary);">No available rooms</p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                                <p class="small mt-2 mb-0" style="color: var(--text-secondary);">
                                    <i class="fas fa-info-circle me-1"></i>Click "Select" to automatically choose a room, or use the dropdown above
                                </p>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="check_in" class="form-label fw-semibold" style="color: var(--text-primary);">Check-in Date</label>
                                <input type="date" name="check_in" id="check_in"
                                       class="form-control @error('check_in') is-invalid @enderror"
                                       value="{{ old('check_in', date('Y-m-d')) }}">
                                @error('check_in')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="check_out" class="form-label fw-semibold" style="color: var(--text-primary);">Check-out Date</label>
                                <input type="date" name="check_out" id="check_out"
                                       class="form-control @error('check_out') is-invalid @enderror"
                                       value="{{ old('check_out', date('Y-m-d', strtotime('+1 month'))) }}">
                                @error('check_out')
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
                    <i class="fas fa-plus me-2"></i>Create Tenant
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Function to select a room from the available rooms display
function selectRoom(roomId) {
    const roomSelect = document.getElementById('room_id');
    roomSelect.value = roomId;
    
    // Add visual feedback
    roomSelect.classList.add('border', 'border-primary');
    setTimeout(() => {
        roomSelect.classList.remove('border', 'border-primary');
    }, 1000);
}

document.addEventListener('DOMContentLoaded', function() {
    const roomSelect = document.getElementById('room_id');
    const checkInField = document.getElementById('check_in');
    const checkOutField = document.getElementById('check_out');
    const dateFields = [checkInField, checkOutField];
    
    function toggleDateFields() {
        const hasRoom = roomSelect.value !== '';
        dateFields.forEach(field => {
            field.disabled = !hasRoom;
            field.style.opacity = hasRoom ? '1' : '0.5';
        });
    }
    
    // Initial state
    toggleDateFields();
    
    // Listen for room selection changes
    roomSelect.addEventListener('change', toggleDateFields);
    
    // Auto-calculate check-out date when check-in changes
    checkInField.addEventListener('change', function() {
        if (checkInField.value && !checkOutField.value) {
            const checkInDate = new Date(checkInField.value);
            const checkOutDate = new Date(checkInDate);
            checkOutDate.setMonth(checkOutDate.getMonth() + 1);
            checkOutField.value = checkOutDate.toISOString().split('T')[0];
        }
    });
});
</script>
@endsection
