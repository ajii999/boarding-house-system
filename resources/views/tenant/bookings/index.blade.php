@extends('layouts.tenant')

@section('title', 'My Bookings')
@section('page-title', 'My Bookings')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded d-flex align-items-center justify-content-center" 
                 style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(0, 102, 255, 0.1)); border: 2px solid rgba(0, 102, 255, 0.5);">
                <i class="fas fa-calendar-check" style="color: #0066ff;"></i>
            </div>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff;">My Bookings</h1>
                <p class="mb-0 small" style="color: var(--text-secondary);">Overview of your room bookings and their status.</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <form method="GET" action="{{ route('tenant.bookings.index') }}" class="d-flex">
                <div class="input-group" style="max-width: 250px;">
                    <span class="input-group-text" style="background: rgba(0, 102, 255, 0.1); border-color: rgba(0, 102, 255, 0.3);">
                        <i class="fas fa-search" style="color: #0066ff;"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search..." 
                           class="form-control">
                </div>
            </form>
            <a href="{{ route('tenant.bookings.create') }}" class="btn btn-neon">
                <i class="fas fa-plus me-2"></i>New Booking
            </a>
        </div>
    </div>
</div>

<!-- Booking Summary -->
<div class="futuristic-card mb-4 mb-md-5" style="border-color: rgba(0, 102, 255, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
        <h3 class="h5 mb-0 fw-bold" style="color: #0066ff;">Booking Summary</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">Overview of your room bookings and their status.</p>
    </div>
    <div class="p-4">
        <div class="row g-3 g-md-4">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card p-4" style="border-color: rgba(245, 158, 11, 0.2); background: rgba(245, 158, 11, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.1)); border: 2px solid rgba(245, 158, 11, 0.3);">
                            <i class="fas fa-clock" style="font-size: 1.5rem; color: #f59e0b;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Pending</p>
                            <p class="h4 fw-bold mb-0" style="color: #f59e0b;">{{ $bookings->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card p-4" style="border-color: rgba(34, 197, 94, 0.2); background: rgba(34, 197, 94, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.3);">
                            <i class="fas fa-check-circle" style="font-size: 1.5rem; color: #22c55e;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Confirmed</p>
                            <p class="h4 fw-bold mb-0" style="color: #22c55e;">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card p-4" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(0, 102, 255, 0.1)); border: 2px solid rgba(0, 102, 255, 0.3);">
                            <i class="fas fa-home" style="font-size: 1.5rem; color: #0066ff;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Completed</p>
                            <p class="h4 fw-bold mb-0" style="color: #0066ff;">{{ $bookings->where('status', 'completed')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="futuristic-card p-4" style="border-color: rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1)); border: 2px solid rgba(239, 68, 68, 0.3);">
                            <i class="fas fa-times-circle" style="font-size: 1.5rem; color: #ef4444;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Cancelled</p>
                            <p class="h4 fw-bold mb-0" style="color: #ef4444;">{{ $bookings->where('status', 'cancelled')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bookings List -->
<div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
        <h3 class="h5 mb-0 fw-bold" style="color: #0066ff;">My Bookings</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">All your room bookings and their current status.</p>
    </div>
    <div class="p-0">
        @if($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: rgba(0, 102, 255, 0.05);">
                        <tr>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Booking #</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Room</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Check-in</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Check-out</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Status</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Total Amount</th>
                            <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td style="color: var(--text-primary);">
                                #{{ str_pad($booking->booking_id, 6, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                @if($booking->room)
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-bed me-2" style="color: #0066ff;"></i>
                                        <div>
                                            <div class="fw-semibold" style="color: var(--text-primary);">Room {{ $booking->room->room_number }}</div>
                                            <div class="small" style="color: var(--text-secondary);">{{ $booking->room->room_type }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span style="color: var(--text-secondary);">N/A</span>
                                @endif
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ $booking->check_in->format('M j, Y') }}
                            </td>
                            <td style="color: var(--text-primary);">
                                {{ $booking->check_out->format('M j, Y') }}
                            </td>
                            <td>
                                <span class="badge px-3 py-1 rounded-pill" 
                                      style="@if($booking->status == 'confirmed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                      @elseif($booking->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @elseif($booking->status == 'completed') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                      @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td style="color: var(--text-primary);">
                                ₱{{ number_format($booking->room->price * $booking->check_in->diffInDays($booking->check_out), 2) }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('tenant.bookings.show', $booking) }}" class="btn btn-sm" style="color: #0066ff;" title="View Booking">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tenant.bookings.edit', $booking) }}" class="btn btn-sm" style="color: #f59e0b;" title="Edit Booking">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($bookings->hasPages())
            <div class="p-4 border-top" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                    <i class="fas fa-calendar-check" style="font-size: 2rem; color: #0066ff;"></i>
                </div>
                <h3 class="h5 fw-semibold mb-2" style="color: var(--text-primary);">No Bookings</h3>
                <p class="mb-4" style="color: var(--text-secondary);">You haven't made any room bookings yet.</p>
                <a href="{{ route('tenant.bookings.create') }}" class="btn btn-neon">
                    <i class="fas fa-plus me-2"></i>Make Your First Booking
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
