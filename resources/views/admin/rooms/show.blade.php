@extends('layouts.admin')

@section('title', 'Room Details - ' . $room->room_number)
@section('page-title', 'Room Details')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(34, 197, 94, 0.3); background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(0, 212, 255, 0.1));">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: #22c55e;">Room {{ $room->room_number }}</h1>
                <p class="mb-0 small" style="color: var(--text-secondary);">{{ $room->room_type }} - ₱{{ number_format($room->price, 2) }}
                    @if($room->pricing_period == 'per_night')
                        /night
                    @else
                        /month
                    @endif
                </p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn" style="background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; border: none;">
                <i class="fas fa-edit me-2"></i>Edit Room
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Room Information Card -->
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Room Information</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Complete room details</p>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Room Type</dt>
                        <dd style="color: var(--text-primary);">{{ $room->room_type }}</dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Price</dt>
                        <dd class="fw-bold h5 mb-0" style="color: #22c55e;">₱{{ number_format($room->price, 2) }}
                            @if($room->pricing_period == 'per_night')
                                per night
                            @else
                                per month
                            @endif
                        </dd>
                    </div>
                    @if($room->description)
                    <div class="col-12">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Description</dt>
                        <dd style="color: var(--text-primary);">{{ $room->description }}</dd>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Current Occupant -->
    @if($currentBooking)
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Current Occupant</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Details about the current tenant staying in this room</p>
            </div>
            <div class="p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.3);">
                        <i class="fas fa-user" style="font-size: 1.8rem; color: #0066ff;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h4 class="h5 fw-bold mb-1" style="color: var(--text-primary);">{{ $currentBooking->tenant->name }}</h4>
                                <p class="small mb-1" style="color: var(--text-secondary);">{{ $currentBooking->tenant->email }}</p>
                                <p class="small mb-0" style="color: var(--text-secondary);">{{ $currentBooking->tenant->contact_number }}</p>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold h5 mb-0" style="color: #22c55e;">₱{{ number_format($currentBooking->total_amount, 2) }}</div>
                                <div class="small" style="color: var(--text-secondary);">Total Amount</div>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-12 col-md-4">
                                <dt class="small fw-semibold mb-1" style="color: var(--text-secondary);">Check-in Date</dt>
                                <dd style="color: var(--text-primary);">{{ $currentBooking->check_in->format('M j, Y') }}</dd>
                            </div>
                            <div class="col-12 col-md-4">
                                <dt class="small fw-semibold mb-1" style="color: var(--text-secondary);">Check-out Date</dt>
                                <dd style="color: var(--text-primary);">{{ $currentBooking->check_out->format('M j, Y') }}</dd>
                            </div>
                            <div class="col-12 col-md-4">
                                <dt class="small fw-semibold mb-1" style="color: var(--text-secondary);">Booking Status</dt>
                                <dd>
                                    <span class="badge px-3 py-2 rounded-pill" 
                                          style="@if($currentBooking->status == 'confirmed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                          @elseif($currentBooking->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                          @else background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff; @endif">
                                        {{ ucfirst($currentBooking->status) }}
                                    </span>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-12">
        <div class="futuristic-card text-center py-5" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                    <i class="fas fa-bed" style="font-size: 2rem; color: #0066ff;"></i>
                </div>
                <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">No Current Occupant</h3>
                <p class="mb-0" style="color: var(--text-secondary);">This room is currently available for booking.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Booking History -->
    @if($bookingHistory->count() > 0)
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Booking History</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Previous tenants who have stayed in this room</p>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: rgba(0, 102, 255, 0.05);">
                        <tr>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Tenant</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Check-in</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Check-out</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Amount</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookingHistory as $booking)
                        <tr>
                            <td>
                                <div class="fw-semibold" style="color: var(--text-primary);">{{ $booking->tenant->name }}</div>
                                <div class="small" style="color: var(--text-secondary);">{{ $booking->tenant->email }}</div>
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ $booking->check_in->format('M j, Y') }}
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ $booking->check_out->format('M j, Y') }}
                            </td>
                            <td class="fw-bold" style="color: #22c55e;">
                                ₱{{ number_format($booking->total_amount, 2) }}
                            </td>
                            <td>
                                <span class="badge px-3 py-2 rounded-pill" 
                                      style="background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8;">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
