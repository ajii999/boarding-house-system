@extends('layouts.tenant')

@section('title', 'Edit Booking')
@section('page-title', 'Edit Booking')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('tenant.bookings.index') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff;">Edit Booking</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Update your room booking details.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('tenant.bookings.update', $booking) }}">
            @csrf
            @method('PUT')
            
            <!-- Booking Details Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Booking Details</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Update your room booking details.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="room_id" class="form-label fw-semibold" style="color: var(--text-primary);">Room</label>
                                <select name="room_id" id="room_id" required class="form-select @error('room_id') is-invalid @enderror">
                                    <option value="">Select a room</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->room_id }}" 
                                                {{ old('room_id', $booking->room_id) == $room->room_id ? 'selected' : '' }}
                                                data-price="{{ $room->price }}">
                                            Room {{ $room->room_number }} - {{ $room->room_type }} (₱{{ number_format($room->price, 2) }}/day)
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="booking_date" class="form-label fw-semibold" style="color: var(--text-primary);">Booking Date</label>
                                <input type="date" name="booking_date" id="booking_date" required
                                       class="form-control @error('booking_date') is-invalid @enderror"
                                       value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}">
                                @error('booking_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="check_in" class="form-label fw-semibold" style="color: var(--text-primary);">Check-in Date</label>
                                <input type="date" name="check_in" id="check_in" required
                                       class="form-control @error('check_in') is-invalid @enderror"
                                       value="{{ old('check_in', $booking->check_in->format('Y-m-d')) }}">
                                @error('check_in')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="check_out" class="form-label fw-semibold" style="color: var(--text-primary);">Check-out Date</label>
                                <input type="date" name="check_out" id="check_out" required
                                       class="form-control @error('check_out') is-invalid @enderror"
                                       value="{{ old('check_out', $booking->check_out->format('Y-m-d')) }}">
                                @error('check_out')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Total Amount Display -->
                            <div class="col-12">
                                <div class="futuristic-card p-4" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.05);">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                            <h4 class="h6 fw-bold mb-1" style="color: var(--text-primary);">Estimated Total Amount</h4>
                                            <p class="small mb-0" style="color: var(--text-secondary);">Based on selected room and dates</p>
                                        </div>
                                        <div class="text-end">
                                            <p class="h4 fw-bold mb-1" style="color: #0066ff;" id="total-amount">₱0.00</p>
                                            <p class="small mb-0" style="color: var(--text-secondary);" id="duration-info">0 days</p>
                                        </div>
                                    </div>
                                </div>
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
                    <i class="fas fa-save me-2"></i>Update Booking
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
    const totalAmountElement = document.getElementById('total-amount');
    const durationInfoElement = document.getElementById('duration-info');

    function calculateTotal() {
        const selectedRoom = roomSelect.options[roomSelect.selectedIndex];
        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);
        
        if (selectedRoom && selectedRoom.dataset.price && checkIn && checkOut && checkOut > checkIn) {
            const price = parseFloat(selectedRoom.dataset.price);
            const days = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
            const total = price * days;
            
            totalAmountElement.textContent = `₱${total.toLocaleString('en-US', {minimumFractionDigits: 2})}`;
            durationInfoElement.textContent = `${days} day${days !== 1 ? 's' : ''}`;
        } else {
            totalAmountElement.textContent = '₱0.00';
            durationInfoElement.textContent = '0 days';
        }
    }

    if (roomSelect) roomSelect.addEventListener('change', calculateTotal);
    if (checkInInput) checkInInput.addEventListener('change', calculateTotal);
    if (checkOutInput) checkOutInput.addEventListener('change', calculateTotal);

    // Calculate on page load
    calculateTotal();
});
</script>
@endsection
