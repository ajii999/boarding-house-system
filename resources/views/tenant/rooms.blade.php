@extends('layouts.tenant')

@section('title', 'My Room')
@section('page-title', 'My Room')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <div class="rounded d-flex align-items-center justify-content-center" 
             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(0, 102, 255, 0.1)); border: 2px solid rgba(0, 102, 255, 0.5);">
            <i class="fas fa-bed" style="color: #0066ff;"></i>
        </div>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff;">My Room</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Manage your room assignments and bookings</p>
        </div>
    </div>
</div>

<!-- Helpful Information Banner -->
<div class="futuristic-card mb-4 mb-md-5 p-4" style="border-color: rgba(0, 212, 255, 0.3); background: rgba(0, 212, 255, 0.05);">
    <div class="d-flex">
        <div class="flex-shrink-0 me-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                 style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.3);">
                <i class="fas fa-info-circle" style="color: #00d4ff;"></i>
            </div>
        </div>
        <div>
            <h5 class="fw-bold mb-2" style="color: #00d4ff;">Room Selection Guide</h5>
            <ul class="mb-0" style="color: var(--text-secondary);">
                @if($assignedRoom)
                    <li>You currently have an assigned room. You can request a room change using the button below.</li>
                    <li>Room change requests require admin approval before taking effect.</li>
                @else
                    <li>Select a room from the available options below to submit a booking request.</li>
                    <li>Choose your start date and duration (1-12 months) for your stay.</li>
                    <li>Your booking request will be reviewed by the admin before confirmation.</li>
                @endif
                <li>You can view all available rooms and their monthly rates in the "Available Rooms" section below.</li>
            </ul>
        </div>
    </div>
</div>

<!-- My Assigned Room Section -->
@if($assignedRoom)
<div class="futuristic-card mb-4 mb-md-5" style="border-color: rgba(34, 197, 94, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(34, 197, 94, 0.2) !important;">
        <h3 class="h5 fw-bold mb-1" style="color: #22c55e;">My Assigned Room</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">Your current room assignment.</p>
    </div>
    <div class="p-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
            <div class="d-flex align-items-center mb-3 mb-md-0">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.3); box-shadow: 0 0 20px rgba(34, 197, 94, 0.2);">
                    <i class="fas fa-bed" style="font-size: 2rem; color: #22c55e;"></i>
                </div>
                <div>
                    <h4 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Room {{ $assignedRoom->room_number }}</h4>
                    <p class="small mb-1" style="color: var(--text-secondary);">{{ $assignedRoom->room_type }}</p>
                    <p class="fw-semibold mb-0" style="color: #22c55e;">₱{{ number_format($assignedRoom->price, 2) }} per month</p>
                    @if($assignedRoom->description)
                    <p class="small mt-2 mb-0" style="color: var(--text-secondary);">{{ $assignedRoom->description }}</p>
                    @endif
                </div>
            </div>
            <div class="text-center text-md-end">
                <span class="badge px-3 py-2 mb-2 rounded-pill" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;">Assigned</span>
                <div>
                    <button type="button" onclick="showChangeRoomForm()" class="btn btn-neon">
                        <i class="fas fa-exchange-alt me-2"></i>
                        Request Room Change
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="futuristic-card mb-4 mb-md-5" style="border-color: rgba(148, 163, 184, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(148, 163, 184, 0.2) !important;">
        <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">My Assigned Room</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">You don't have an assigned room at the moment.</p>
    </div>
    <div class="p-4">
        <div class="text-center py-5">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                 style="width: 100px; height: 100px; background: rgba(148, 163, 184, 0.1); border: 2px solid rgba(148, 163, 184, 0.3);">
                <i class="fas fa-bed" style="font-size: 3rem; color: #94a3b8;"></i>
            </div>
            <p class="h5 fw-bold mb-1" style="color: var(--text-primary);">No Assigned Room</p>
            <p class="small mb-0" style="color: var(--text-secondary);">You don't have an active room assignment.</p>
        </div>
    </div>
</div>
@endif

<!-- Change Room Request Section (for assigned tenants) -->
@if($assignedRoom)
<div id="changeRoomForm" class="futuristic-card mb-4 mb-md-5" style="display: none; border-color: rgba(245, 158, 11, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(245, 158, 11, 0.2) !important;">
        <h3 class="h5 fw-bold mb-1" style="color: #f59e0b;">Request Room Change</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">Submit a request to change your current room assignment.</p>
    </div>
    <div class="p-4">
        <form action="{{ route('tenant.rooms.select') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="change_room_id" class="form-label fw-semibold" style="color: var(--text-primary);">Select New Room</label>
                    <select name="room_id" id="change_room_id" class="form-select" required>
                        <option value="">Choose a room...</option>
                        @foreach($availableRooms as $room)
                        <option value="{{ $room->room_id }}" data-price="{{ $room->price }}" data-type="{{ $room->room_type }}">
                            Room {{ $room->room_number }} - {{ $room->room_type }} (₱{{ number_format($room->price, 2) }}/month)
                        </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 col-md-6">
                    <label for="change_start_date" class="form-label fw-semibold" style="color: var(--text-primary);">Start Date</label>
                    <input type="date" name="start_date" id="change_start_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                    @error('start_date')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 col-md-6">
                    <label for="change_duration" class="form-label fw-semibold" style="color: var(--text-primary);">Duration (Months)</label>
                    <select name="duration" id="change_duration" class="form-select" required>
                        <option value="">Select duration...</option>
                        <option value="1">1 Month</option>
                        <option value="2">2 Months</option>
                        <option value="3">3 Months</option>
                        <option value="6">6 Months</option>
                        <option value="12">12 Months</option>
                    </select>
                    @error('duration')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold" style="color: var(--text-primary);">Estimated Total</label>
                    <div class="futuristic-card p-3" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.05);">
                        <div id="change-total-amount" class="h4 fw-bold mb-0" style="color: #0066ff;">₱0.00</div>
                        <p class="small mb-0" style="color: var(--text-secondary);">Amount will be calculated based on selected room and duration</p>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" onclick="hideChangeRoomForm()" class="btn btn-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn btn-neon">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Submit Change Request
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Active Bookings Section -->
<div class="futuristic-card mb-4 mb-md-5" style="border-color: rgba(0, 102, 255, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
        <h3 class="h5 fw-bold mb-1" style="color: #0066ff;">My Current Bookings</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">Your active room bookings and their details.</p>
    </div>
    <div class="p-0">
        @if($activeBookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: rgba(0, 102, 255, 0.05);">
                        <tr>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Room</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Check In</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Check Out</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Amount</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeBookings as $booking)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                         style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(0, 102, 255, 0.1)); border: 2px solid rgba(0, 102, 255, 0.3);">
                                        <i class="fas fa-bed" style="color: #0066ff;"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="color: var(--text-primary);">Room {{ $booking->room->room_number ?? 'N/A' }}</div>
                                        <div class="small" style="color: var(--text-secondary);">{{ $booking->room->room_type ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ $booking->check_in ? $booking->check_in->format('M j, Y') : 'N/A' }}
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ $booking->check_out ? $booking->check_out->format('M j, Y') : 'N/A' }}
                            </td>
                            <td class="fw-semibold" style="color: var(--text-primary);">
                                ₱{{ number_format($booking->total_amount, 2) }}
                            </td>
                            <td>
                                <span class="badge px-3 py-1 rounded-pill" 
                                      style="@if($booking->status == 'confirmed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                      @elseif($booking->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @elseif($booking->status == 'completed') background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(0, 212, 255, 0.2)); border: 1px solid rgba(0, 212, 255, 0.5); color: #00d4ff;
                                      @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 100px; height: 100px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                    <i class="fas fa-bed" style="font-size: 3rem; color: #0066ff;"></i>
                </div>
                <p class="h5 fw-bold mb-1" style="color: var(--text-primary);">No Active Bookings</p>
                <p class="small mb-0" style="color: var(--text-secondary);">You don't have any active room bookings at the moment.</p>
            </div>
        @endif
    </div>
</div>

<!-- Room Selection Section -->
@if(!$assignedRoom)
<div class="futuristic-card mb-4 mb-md-5" style="border-color: rgba(0, 102, 255, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
        <div class="d-flex align-items-center">
            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(0, 102, 255, 0.1)); border: 2px solid rgba(0, 102, 255, 0.3);">
                <i class="fas fa-bed" style="color: #0066ff;"></i>
            </div>
            <div>
                <h3 class="h5 fw-bold mb-1" style="color: #0066ff;">Select Your Room</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Choose from available rooms and submit a booking request.</p>
            </div>
        </div>
    </div>
    <div class="p-4">
        <form action="{{ route('tenant.rooms.select') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="room_id" class="form-label fw-semibold" style="color: var(--text-primary);">
                        <i class="fas fa-bed me-1" style="color: #0066ff;"></i>Select Room
                    </label>
                    <select name="room_id" id="room_id" class="form-select" required>
                        <option value="">Choose a room...</option>
                        @foreach($availableRooms as $room)
                        <option value="{{ $room->room_id }}" data-price="{{ $room->price }}" data-type="{{ $room->room_type }}">
                            Room {{ $room->room_number }} - {{ $room->room_type }} (₱{{ number_format($room->price, 2) }}/month)
                        </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    @if($availableRooms->count() == 0)
                        <div class="futuristic-card p-3 mt-2" style="border-color: rgba(245, 158, 11, 0.2); background: rgba(245, 158, 11, 0.05);">
                            <i class="fas fa-exclamation-triangle me-2" style="color: #f59e0b;"></i>
                            <span style="color: var(--text-secondary);">No rooms are currently available for selection.</span>
                        </div>
                    @endif
                </div>
                
                <div class="col-12 col-md-6">
                    <label for="start_date" class="form-label fw-semibold" style="color: var(--text-primary);">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                    @error('start_date')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 col-md-6">
                    <label for="duration" class="form-label fw-semibold" style="color: var(--text-primary);">Duration (Months)</label>
                    <select name="duration" id="duration" class="form-select" required>
                        <option value="">Select duration...</option>
                        <option value="1">1 Month</option>
                        <option value="2">2 Months</option>
                        <option value="3">3 Months</option>
                        <option value="6">6 Months</option>
                        <option value="12">12 Months</option>
                    </select>
                    @error('duration')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold" style="color: var(--text-primary);">Estimated Total</label>
                    <div class="futuristic-card p-3" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.05);">
                        <div id="total-amount" class="h4 fw-bold mb-0" style="color: #0066ff;">₱0.00</div>
                        <p class="small mb-0" style="color: var(--text-secondary);">Amount will be calculated based on selected room and duration</p>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-neon btn-lg">
                    <i class="fas fa-bed me-2"></i>
                    Submit Room Request
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Available Rooms Section -->
<div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
        <h3 class="h5 fw-bold mb-1" style="color: #0066ff;">Available Rooms</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">Rooms that are currently available for booking.</p>
    </div>
    <div class="p-4">
        <div class="row g-4">
            @forelse($availableRooms as $room)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="futuristic-card h-100 p-4" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.05);">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(0, 102, 255, 0.1)); border: 2px solid rgba(0, 102, 255, 0.3);">
                                <i class="fas fa-bed" style="color: #0066ff;"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold mb-0" style="color: var(--text-primary);">Room {{ $room->room_number }}</h4>
                                <p class="small mb-0" style="color: var(--text-secondary);">{{ $room->room_type }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="h5 fw-bold mb-1" style="color: #0066ff;">₱{{ number_format($room->price, 2) }}</div>
                        <div class="small" style="color: var(--text-secondary);">per month</div>
                    </div>
                    
                    <div class="mb-3">
                        <span class="badge px-3 py-1 rounded-pill" 
                              style="@if($room->status == 'available') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                              @elseif($room->status == 'booked') background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(0, 212, 255, 0.2)); border: 1px solid rgba(0, 212, 255, 0.5); color: #00d4ff;
                              @else background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b; @endif">
                            {{ ucfirst($room->status) }}
                        </span>
                    </div>
                    
                    @if($room->description)
                    <p class="small mb-3" style="color: var(--text-secondary);">{{ Str::limit($room->description, 100) }}</p>
                    @endif
                    
                    <!-- Show if this room has any bookings for this tenant -->
                    @if($room->bookings->count() > 0)
                    <div class="border-top pt-3 mt-3" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                        <h6 class="small fw-semibold mb-2" style="color: var(--text-primary);">Your Bookings for this Room:</h6>
                        @foreach($room->bookings as $booking)
                        <div class="small mb-1" style="color: var(--text-secondary);">
                            <span class="fw-medium">{{ $booking->check_in->format('M j, Y') }}</span> to 
                            <span class="fw-medium">{{ $booking->check_out->format('M j, Y') }}</span>
                            <span class="badge ms-2 px-2 py-1 rounded-pill" 
                                  style="@if($booking->status == 'confirmed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($booking->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                  @else background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(0, 212, 255, 0.2)); border: 1px solid rgba(0, 212, 255, 0.5); color: #00d4ff; @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 100px; height: 100px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                        <i class="fas fa-bed" style="font-size: 3rem; color: #0066ff;"></i>
                    </div>
                    <p class="h5 fw-bold mb-1" style="color: var(--text-primary);">No Available Rooms</p>
                    <p class="small mb-0" style="color: var(--text-secondary);">There are no available rooms for booking at the moment.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
// Global functions for room change form
function showChangeRoomForm() {
    document.getElementById('changeRoomForm').style.display = 'block';
    document.getElementById('changeRoomForm').scrollIntoView({ behavior: 'smooth' });
}

function hideChangeRoomForm() {
    document.getElementById('changeRoomForm').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    // Room selection form elements
    const roomSelect = document.getElementById('room_id');
    const startDateInput = document.getElementById('start_date');
    const durationSelect = document.getElementById('duration');
    const totalAmountDiv = document.getElementById('total-amount');

    // Change room form elements
    const changeRoomSelect = document.getElementById('change_room_id');
    const changeStartDateInput = document.getElementById('change_start_date');
    const changeDurationSelect = document.getElementById('change_duration');
    const changeTotalAmountDiv = document.getElementById('change-total-amount');

    function calculateTotal(roomSelect, startDateInput, durationSelect, totalAmountDiv) {
        const selectedOption = roomSelect.options[roomSelect.selectedIndex];
        const startDate = startDateInput.value;
        const duration = durationSelect.value;

        if (selectedOption && selectedOption.value && startDate && duration) {
            const price = parseFloat(selectedOption.dataset.price);
            const months = parseInt(duration);
            
            if (months > 0) {
                const total = price * months;
                totalAmountDiv.textContent = '₱' + total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            } else {
                totalAmountDiv.textContent = '₱0.00';
            }
        } else {
            totalAmountDiv.textContent = '₱0.00';
        }
    }

    // Room selection form handlers
    if (roomSelect && startDateInput && durationSelect && totalAmountDiv) {
        roomSelect.addEventListener('change', () => calculateTotal(roomSelect, startDateInput, durationSelect, totalAmountDiv));
        startDateInput.addEventListener('change', () => calculateTotal(roomSelect, startDateInput, durationSelect, totalAmountDiv));
        durationSelect.addEventListener('change', () => calculateTotal(roomSelect, startDateInput, durationSelect, totalAmountDiv));
    }

    // Change room form handlers
    if (changeRoomSelect && changeStartDateInput && changeDurationSelect && changeTotalAmountDiv) {
        changeRoomSelect.addEventListener('change', () => calculateTotal(changeRoomSelect, changeStartDateInput, changeDurationSelect, changeTotalAmountDiv));
        changeStartDateInput.addEventListener('change', () => calculateTotal(changeRoomSelect, changeStartDateInput, changeDurationSelect, changeTotalAmountDiv));
        changeDurationSelect.addEventListener('change', () => calculateTotal(changeRoomSelect, changeStartDateInput, changeDurationSelect, changeTotalAmountDiv));
    }
});
</script>
@endsection
