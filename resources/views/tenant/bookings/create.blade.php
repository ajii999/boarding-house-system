@extends('layouts.tenant')

@section('title', 'New Booking')
@section('page-title', 'New Booking')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('tenant.bookings.index') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff;">New Booking</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Select a room and specify your stay dates.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('tenant.bookings.store') }}">
            @csrf
            
            <!-- Booking Details Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Booking Details</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Select a room and specify your stay dates.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="room_id" class="form-label fw-semibold" style="color: var(--text-primary);">Select Room</label>
                                @if($rooms && $rooms->count() > 0)
                                    <select name="room_id" id="room_id" required
                                            class="form-select @error('room_id') is-invalid @enderror">
                                        <option value="">Choose a room</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->room_id }}" 
                                                    data-price="{{ $room->price }}"
                                                    data-type="{{ $room->room_type }}"
                                                    {{ old('room_id') == $room->room_id ? 'selected' : '' }}>
                                                Room {{ $room->room_number }} - {{ $room->room_type }} (₱{{ number_format($room->price, 2) }}/day)
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        No available rooms at the moment. Please contact the administrator.
                                    </div>
                                @endif
                                @error('room_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
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

                            <div class="col-12 col-md-6">
                                <label for="check_in" class="form-label fw-semibold" style="color: var(--text-primary);">Check-in Date</label>
                                <input type="date" name="check_in" id="check_in" required
                                       class="form-control @error('check_in') is-invalid @enderror"
                                       value="{{ old('check_in') }}">
                                @error('check_in')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="check_out" class="form-label fw-semibold" style="color: var(--text-primary);">Check-out Date</label>
                                <input type="date" name="check_out" id="check_out" required
                                       class="form-control @error('check_out') is-invalid @enderror"
                                       value="{{ old('check_out') }}">
                                @error('check_out')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold" style="color: var(--text-primary);">Duration</label>
                                <div class="p-3 futuristic-card" style="border-color: rgba(148, 163, 184, 0.2); background: rgba(148, 163, 184, 0.05);">
                                    <span id="duration" class="small" style="color: var(--text-secondary);">Select dates to see duration</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold" style="color: var(--text-primary);">Total Amount</label>
                                <div class="p-3 futuristic-card" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.05);">
                                    <span id="total_amount" class="h5 fw-bold" style="color: #0066ff;">₱0.00</span>
                                    <span class="small ms-2" style="color: var(--text-secondary);">(Calculated automatically)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preferences Section -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(124, 58, 237, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Preferences</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Tell us about your preferences and special requirements.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="preferences" class="form-label fw-semibold" style="color: var(--text-primary);">Special Requirements</label>
                                <textarea name="preferences" id="preferences" rows="3"
                                          class="form-control @error('preferences') is-invalid @enderror"
                                          placeholder="Any special requirements, dietary restrictions, accessibility needs, etc.">{{ old('preferences') }}</textarea>
                                @error('preferences')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="emergency_contact" class="form-label fw-semibold" style="color: var(--text-primary);">Emergency Contact</label>
                                <input type="text" name="emergency_contact" id="emergency_contact"
                                       class="form-control @error('emergency_contact') is-invalid @enderror"
                                       value="{{ old('emergency_contact') }}"
                                       placeholder="Emergency contact name and number">
                                @error('emergency_contact')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="occupancy_type" class="form-label fw-semibold" style="color: var(--text-primary);">Occupancy Type <span class="text-danger">*</span></label>
                                <select name="occupancy_type" id="occupancy_type" required
                                        class="form-select @error('occupancy_type') is-invalid @enderror">
                                    <option value="">Select occupancy type</option>
                                    <option value="single" {{ old('occupancy_type') == 'single' ? 'selected' : '' }}>Single Occupancy</option>
                                    <option value="shared" {{ old('occupancy_type') == 'shared' ? 'selected' : '' }}>Shared Occupancy</option>
                                </select>
                                @error('occupancy_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('tenant.bookings.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-neon">
                    <i class="fas fa-paper-plane me-2"></i>Submit Booking Request
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomSelect = document.getElementById('room_id');
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const durationSpan = document.getElementById('duration');
    const totalAmountSpan = document.getElementById('total_amount');

    function calculateTotal() {
        const selectedRoom = roomSelect.options[roomSelect.selectedIndex];
        const price = parseFloat(selectedRoom.dataset.price) || 0;
        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);

        if (checkIn && checkOut && checkIn < checkOut) {
            const timeDiff = checkOut.getTime() - checkIn.getTime();
            const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
            const total = price * daysDiff;

            durationSpan.textContent = `${daysDiff} day${daysDiff !== 1 ? 's' : ''}`;
            totalAmountSpan.textContent = `₱${total.toLocaleString('en-US', {minimumFractionDigits: 2})}`;
        } else {
            durationSpan.textContent = 'Select valid dates';
            totalAmountSpan.textContent = '₱0.00';
        }
    }

    roomSelect.addEventListener('change', calculateTotal);
    checkInInput.addEventListener('change', function() {
        if (checkInInput.value) {
            checkOutInput.min = checkInInput.value;
        }
        calculateTotal();
    });
    checkOutInput.addEventListener('change', calculateTotal);

    // Set minimum date for check-in to today
    const today = new Date().toISOString().split('T')[0];
    checkInInput.min = today;
    checkOutInput.min = today;
});
</script>
@endsection
