@extends('layouts.admin')

@section('title', 'Tenant Details')
@section('page-title', 'Tenant Details')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.tenants.index') }}" class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.35)'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='scale(1)';">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">Tenant Details</h1>
                <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.9); font-weight: 500;">Complete tenant details and profile information</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.tenants.edit', $tenant) }}" class="btn" style="background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='translateY(0)';">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Tenant Information Card -->
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Tenant Information</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Complete tenant details</p>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Full Name</dt>
                        <dd style="color: var(--text-primary);">{{ $tenant->name }}</dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Email Address</dt>
                        <dd style="color: var(--text-primary);">{{ $tenant->email }}</dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Contact Number</dt>
                        <dd style="color: var(--text-primary);">{{ $tenant->contact_number }}</dd>
                    </div>
                    @if($tenant->profile)
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Address</dt>
                        <dd style="color: var(--text-primary);">{{ $tenant->profile->address ?: 'Not provided' }}</dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Emergency Contact</dt>
                        <dd style="color: var(--text-primary);">{{ $tenant->profile->emergency_contact ?: 'Not provided' }}</dd>
                    </div>
                    @endif
                    <div class="col-12 col-md-6">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Member Since</dt>
                        <dd style="color: var(--text-primary);">{{ $tenant->created_at->format('F j, Y') }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Room Information -->
    @if($tenant->bookings->where('status', 'confirmed')->count() > 0)
    @php
        $currentBooking = $tenant->bookings->where('status', 'confirmed')->first();
    @endphp
    @if($currentBooking && $currentBooking->room)
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Current Room Assignment</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Room where this tenant is currently staying</p>
            </div>
            <div class="p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.3);">
                        <i class="fas fa-bed" style="font-size: 1.8rem; color: #0066ff;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h4 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Room {{ $currentBooking->room->room_number }}</h4>
                                <p class="small mb-1" style="color: var(--text-secondary);">{{ $currentBooking->room->room_type }} - ₱{{ number_format($currentBooking->room->price, 2) }}/night</p>
                                @if($currentBooking->room->description)
                                    <p class="small mt-1 mb-0" style="color: var(--text-secondary);">{{ $currentBooking->room->description }}</p>
                                @endif
                            </div>
                            <div class="text-end">
                                <div class="fw-bold h5 mb-0" style="color: #22c55e;">₱{{ number_format($currentBooking->room->price * $currentBooking->check_in->diffInDays($currentBooking->check_out), 2) }}</div>
                                <div class="small" style="color: var(--text-secondary);">Total Amount</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <dt class="small fw-semibold mb-1" style="color: var(--text-secondary);">Check-in Date</dt>
                                <dd style="color: var(--text-primary);">{{ $currentBooking->check_in->format('M j, Y') }}</dd>
                            </div>
                            <div class="col-12 col-md-4">
                                <dt class="small fw-semibold mb-1" style="color: var(--text-secondary);">Check-out Date</dt>
                                <dd style="color: var(--text-primary);">{{ $currentBooking->check_out->format('M j, Y') }}</dd>
                            </div>
                            <div class="col-12 col-md-4">
                                <dt class="small fw-semibold mb-1" style="color: var(--text-secondary);">Room Status</dt>
                                <dd>
                                    <span class="badge px-3 py-2 rounded-pill" 
                                          style="@if($currentBooking->room->status == 'booked') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                          @elseif($currentBooking->room->status == 'available') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                          @else background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b; @endif">
                                        {{ ucfirst($currentBooking->room->status) }}
                                    </span>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @else
    <div class="col-12">
        <div class="futuristic-card text-center py-5" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                    <i class="fas fa-bed" style="font-size: 2rem; color: #0066ff;"></i>
                </div>
                <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">No Current Room Assignment</h3>
                <p class="mb-0" style="color: var(--text-secondary);">This tenant is not currently assigned to any room.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Bookings Section -->
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Booking History</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">All bookings made by this tenant</p>
            </div>
            <div class="table-responsive">
                @if($tenant->bookings->count() > 0)
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
                        @foreach($tenant->bookings as $booking)
                        <tr>
                            <td style="color: var(--text-primary);">
                                {{ $booking->room->room_number ?? 'N/A' }}
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('M j, Y') : 'N/A' }}
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('M j, Y') : 'N/A' }}
                            </td>
                            <td class="fw-bold" style="color: #22c55e;">
                                ₱{{ number_format($booking->total_amount, 2) }}
                            </td>
                            <td>
                                <span class="badge px-3 py-2 rounded-pill" 
                                      style="@if($booking->status == 'confirmed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                      @elseif($booking->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @elseif($booking->status == 'cancelled') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                      @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-4 text-center" style="color: var(--text-secondary);">
                    No bookings found for this tenant.
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Payments Section -->
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(34, 197, 94, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(34, 197, 94, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Payment History</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">All payments made by this tenant</p>
            </div>
            <div class="table-responsive">
                @if($tenant->payments->count() > 0)
                <table class="table table-hover mb-0">
                    <thead style="background: rgba(34, 197, 94, 0.05);">
                        <tr>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Date</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Amount</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Method</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Status</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenant->payments as $payment)
                        <tr>
                            <td style="color: var(--text-primary);">
                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('M j, Y') }}
                            </td>
                            <td class="fw-bold" style="color: #22c55e;">
                                ₱{{ number_format($payment->amount, 2) }}
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                            </td>
                            <td>
                                <span class="badge px-3 py-2 rounded-pill" 
                                      style="@if($payment->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                      @elseif($payment->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @elseif($payment->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                      @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ $payment->notes ?: 'N/A' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-4 text-center" style="color: var(--text-secondary);">
                    No payments found for this tenant.
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Maintenance Requests Section -->
    <div class="col-12">
        <div class="futuristic-card" style="border-color: rgba(245, 158, 11, 0.2);">
            <div class="p-4 border-bottom" style="border-color: rgba(245, 158, 11, 0.2) !important;">
                <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">Maintenance Requests</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">All maintenance requests submitted by this tenant</p>
            </div>
            <div class="table-responsive">
                @if($tenant->maintenanceRequests->count() > 0)
                <table class="table table-hover mb-0">
                    <thead style="background: rgba(245, 158, 11, 0.05);">
                        <tr>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Issue Type</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Description</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Priority</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Status</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenant->maintenanceRequests as $request)
                        <tr>
                            <td style="color: var(--text-primary);">
                                {{ $request->issue_type }}
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ Str::limit($request->description, 50) }}
                            </td>
                            <td>
                                <span class="badge px-3 py-2 rounded-pill" 
                                      style="@if($request->priority == 'urgent') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                      @elseif($request->priority == 'high') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @elseif($request->priority == 'medium') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @else background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e; @endif">
                                    {{ ucfirst($request->priority) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge px-3 py-2 rounded-pill" 
                                      style="@if($request->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                      @elseif($request->status == 'in_progress') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                      @elseif($request->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; @endif">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ \Carbon\Carbon::parse($request->request_date)->format('M j, Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-4 text-center" style="color: var(--text-secondary);">
                    No maintenance requests found for this tenant.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
