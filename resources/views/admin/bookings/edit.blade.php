@extends('layouts.admin')

@section('title', 'Edit Booking')
@section('page-title', 'Edit Booking')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px;">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.bookings.index') }}" class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.35)'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='scale(1)';">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">Edit Booking</h1>
            <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.9); font-weight: 500;">Update the booking details</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
            @csrf
            @method('PUT')
            
            <!-- Booking Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Booking Information</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Update the booking details.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="tenant_id" class="form-label fw-semibold" style="color: var(--text-primary);">Tenant</label>
                                <select name="tenant_id" id="tenant_id" required class="form-select @error('tenant_id') is-invalid @enderror">
                                    <option value="">Select a tenant</option>
                                    @foreach($tenants as $tenant)
                                        <option value="{{ $tenant->tenant_id }}" {{ old('tenant_id', $booking->tenant_id) == $tenant->tenant_id ? 'selected' : '' }}>
                                            {{ $tenant->name }} ({{ $tenant->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('tenant_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="room_id" class="form-label fw-semibold" style="color: var(--text-primary);">Room</label>
                                <select name="room_id" id="room_id" required class="form-select @error('room_id') is-invalid @enderror">
                                    <option value="">Select a room</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->room_id }}" {{ old('room_id', $booking->room_id) == $room->room_id ? 'selected' : '' }}>
                                            Room {{ $room->room_number }} - {{ $room->room_type }} (₱{{ number_format($room->price, 2) }}/night)
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
                                       value="{{ old('booking_date', $booking->booking_date ? $booking->booking_date->format('Y-m-d') : '') }}">
                                @error('booking_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="status" class="form-label fw-semibold" style="color: var(--text-primary);">Status</label>
                                <select name="status" id="status" required class="form-select @error('status') is-invalid @enderror">
                                    <option value="">Select status</option>
                                    <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="check_in" class="form-label fw-semibold" style="color: var(--text-primary);">Check In Date</label>
                                <input type="date" name="check_in" id="check_in" required
                                       class="form-control @error('check_in') is-invalid @enderror"
                                       value="{{ old('check_in', $booking->check_in ? $booking->check_in->format('Y-m-d') : '') }}">
                                @error('check_in')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="check_out" class="form-label fw-semibold" style="color: var(--text-primary);">Check Out Date</label>
                                <input type="date" name="check_out" id="check_out" required
                                       class="form-control @error('check_out') is-invalid @enderror"
                                       value="{{ old('check_out', $booking->check_out ? $booking->check_out->format('Y-m-d') : '') }}">
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
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
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
    const totalAmountInput = document.getElementById('total_amount');
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    
    // Room prices data
    const roomPrices = @json($rooms->pluck('price', 'room_id'));
    
    function calculateTotal() {
        const roomId = roomSelect.value;
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;
        
        if (roomId && checkIn && checkOut) {
            const price = roomPrices[roomId];
            const checkInDate = new Date(checkIn);
            const checkOutDate = new Date(checkOut);
            const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
            
            if (nights > 0 && totalAmountInput) {
                const total = price * nights;
                totalAmountInput.value = total.toFixed(2);
            }
        }
    }
    
    if (roomSelect) roomSelect.addEventListener('change', calculateTotal);
    if (checkInInput) checkInInput.addEventListener('change', calculateTotal);
    if (checkOutInput) checkOutInput.addEventListener('change', calculateTotal);
});
</script>
@endsection
