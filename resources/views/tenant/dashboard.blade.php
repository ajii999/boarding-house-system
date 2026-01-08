@extends('layouts.tenant')

@section('title', 'Tenant Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Futuristic Welcome Section -->
<div class="mb-4 mb-md-5 futuristic-card outline-gradient p-4 p-md-5 position-relative stat-card" style="overflow: visible;">
    <div class="position-relative z-2">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="mb-3 mb-md-0">
                <h1 class="h2 h3-md fw-bold mb-2" style="background: linear-gradient(135deg, #0066ff, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Welcome back, {{ session('user_name') }}!
                </h1>
                <p class="mb-0" style="color: var(--text-secondary);">Here's what's happening with your boarding house activities</p>
            </div>
            <div class="d-none d-md-block">
                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 100px; height: 100px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(124, 58, 237, 0.15)); border: 2px solid rgba(0, 102, 255, 0.4); box-shadow: 0 0 30px rgba(0, 102, 255, 0.3);">
                    <i class="fas fa-home" style="font-size: 3rem; color: #0066ff;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Futuristic Stats Cards Row -->
<div class="row g-3 g-md-4 mb-4 mb-md-5">
    <!-- Active Bookings Card -->
    <div class="col-12 col-sm-6 col-lg-3">
        <a href="{{ route('tenant.bookings.index') }}" class="text-decoration-none">
            <div class="futuristic-card stat-card outline-primary h-100 p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between position-relative z-2 flex-wrap">
                    <div class="flex-grow-1 me-2 me-md-3" style="min-width: 0;">
                        <p class="small mb-2" style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Active Bookings</p>
                        <p class="h2 fw-bold mb-2" style="color: #0066ff; word-break: break-word; font-size: clamp(1.5rem, 3vw, 2rem);">{{ $activeBookings ?? 0 }}</p>
                        <p class="small mb-0" style="color: #0066ff;">
                            <i class="fas fa-calendar-check me-1"></i>Current reservations
                        </p>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 55px; height: 55px; min-width: 55px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.4); box-shadow: 0 0 20px rgba(0, 102, 255, 0.2);">
                        <i class="fas fa-calendar-check" style="font-size: 1.4rem; color: #0066ff;"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Total Payments Card -->
    <div class="col-12 col-sm-6 col-lg-3">
        <a href="{{ route('tenant.payments') }}" class="text-decoration-none">
            <div class="futuristic-card stat-card outline-success h-100 p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between position-relative z-2 flex-wrap">
                    <div class="flex-grow-1 me-2 me-md-3" style="min-width: 0;">
                        <p class="small mb-2" style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Total Payments</p>
                        <p class="h2 fw-bold mb-2" style="color: #22c55e; word-break: break-word; font-size: clamp(1.3rem, 2.5vw, 1.8rem);">₱{{ number_format($totalPayments ?? 0, 2) }}</p>
                        <p class="small mb-0" style="color: #22c55e;">
                            <i class="fas fa-credit-card me-1"></i>Amount paid
                        </p>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 55px; height: 55px; min-width: 55px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.08)); border: 2px solid rgba(34, 197, 94, 0.4); box-shadow: 0 0 20px rgba(34, 197, 94, 0.2);">
                        <i class="fas fa-credit-card" style="font-size: 1.4rem; color: #22c55e;"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Notifications Card -->
    <div class="col-12 col-sm-6 col-lg-3">
        <a href="{{ route('tenant.notifications') }}" class="text-decoration-none">
            <div class="futuristic-card stat-card outline-info h-100 p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between position-relative z-2 flex-wrap">
                    <div class="flex-grow-1 me-2 me-md-3" style="min-width: 0;">
                        <p class="small mb-2" style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Notifications</p>
                        <p class="h2 fw-bold mb-2" style="color: #00d4ff; word-break: break-word; font-size: clamp(1.5rem, 3vw, 2rem);">{{ $unreadNotifications ?? 0 }}</p>
                        <p class="small mb-0" style="color: #00d4ff;">
                            <i class="fas fa-bell me-1"></i>Unread messages
                        </p>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center position-relative flex-shrink-0" 
                         style="width: 55px; height: 55px; min-width: 55px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.15), rgba(0, 212, 255, 0.08)); border: 2px solid rgba(0, 212, 255, 0.4); box-shadow: 0 0 20px rgba(0, 212, 255, 0.2);">
                        <i class="fas fa-bell" style="font-size: 1.4rem; color: #00d4ff;"></i>
                        @if(($unreadNotifications ?? 0) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="box-shadow: 0 0 10px rgba(239, 68, 68, 0.5); white-space: nowrap; z-index: 10; margin-left: 5px; font-size: 0.65rem; padding: 0.2rem 0.4rem;">{{ $unreadNotifications }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Maintenance Requests Card -->
    <div class="col-12 col-sm-6 col-lg-3">
        <a href="{{ route('tenant.maintenance.index') }}" class="text-decoration-none">
            <div class="futuristic-card stat-card outline-purple h-100 p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between position-relative z-2 flex-wrap">
                    <div class="flex-grow-1 me-2 me-md-3" style="min-width: 0;">
                        <p class="small mb-2" style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Maintenance</p>
                        <p class="h2 fw-bold mb-2" style="color: #7c3aed; word-break: break-word; font-size: clamp(1.5rem, 3vw, 2rem);">{{ $pendingMaintenance ?? 0 }}</p>
                        <p class="small mb-0" style="color: #7c3aed;">
                            <i class="fas fa-tools me-1"></i>Pending requests
                        </p>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 55px; height: 55px; min-width: 55px; background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(124, 58, 237, 0.08)); border: 2px solid rgba(124, 58, 237, 0.4); box-shadow: 0 0 20px rgba(124, 58, 237, 0.2);">
                        <i class="fas fa-tools" style="font-size: 1.4rem; color: #7c3aed;"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Content Sections Row -->
<div class="row g-4 mb-4 mb-md-5">
    <!-- Recent Bookings Card -->
    <div class="col-12 col-lg-6">
        <div class="futuristic-card outline-info h-100">
            <div class="p-3 p-md-4 border-bottom" style="border-color: rgba(0, 212, 255, 0.2) !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-2 me-md-3" 
                             style="width: 45px; height: 45px; min-width: 45px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.5);">
                            <i class="fas fa-calendar-alt" style="color: #0066ff; font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <h3 class="h6 mb-0 fw-bold" style="color: #0066ff;">Recent Bookings</h3>
                            <p class="small mb-0" style="color: var(--text-secondary);">{{ count($recentBookings ?? []) }} total</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 p-md-4">
                <div class="d-flex flex-column gap-2">
                    @forelse($recentBookings ?? [] as $booking)
                    <div class="futuristic-card p-2 p-md-3" style="border-color: rgba(0, 212, 255, 0.2); background: rgba(0, 212, 255, 0.05);">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center flex-grow-1" style="min-width: 0;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" 
                                     style="width: 40px; height: 40px; min-width: 40px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.3);">
                                    <i class="fas fa-bed" style="color: #0066ff; font-size: 0.9rem;"></i>
                                </div>
                                <div class="flex-grow-1" style="min-width: 0;">
                                    <p class="fw-bold mb-1 small" style="color: var(--text-primary); word-break: break-word;">Room {{ $booking->room->room_number ?? 'N/A' }}</p>
                                    <p class="small mb-0" style="color: var(--text-secondary); word-break: break-word; font-size: 0.75rem;">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $booking->check_in ? $booking->check_in->format('M j, Y') : 'N/A' }} - 
                                        {{ $booking->check_out ? $booking->check_out->format('M j, Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <span class="badge px-2 py-1 rounded-pill flex-shrink-0" 
                                  style="@if($booking->status === 'confirmed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($booking->status === 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                  @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; @endif font-size: 0.7rem;">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" 
                             style="width: 60px; height: 60px; background: rgba(0, 212, 255, 0.1); border: 2px solid rgba(0, 212, 255, 0.3);">
                            <i class="fas fa-calendar-times" style="font-size: 1.5rem; color: #0066ff;"></i>
                        </div>
                        <p class="mb-0 small" style="color: var(--text-secondary);">No recent bookings</p>
                    </div>
                    @endforelse
                </div>
                <div class="mt-3">
                    <a href="{{ route('tenant.bookings.index') }}" class="btn btn-neon btn-sm">
                        <i class="fas fa-arrow-right me-2"></i>View all bookings
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Payments Card -->
    <div class="col-12 col-lg-6">
        <div class="futuristic-card outline-success h-100">
            <div class="p-3 p-md-4 border-bottom" style="border-color: rgba(34, 197, 94, 0.2) !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-2 me-md-3" 
                             style="width: 45px; height: 45px; min-width: 45px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.5);">
                            <i class="fas fa-credit-card" style="color: #22c55e; font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <h3 class="h6 mb-0 fw-bold" style="color: #22c55e;">Recent Payments</h3>
                            <p class="small mb-0" style="color: var(--text-secondary);">Latest payment transactions</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 p-md-4">
                <div class="d-flex flex-column gap-2">
                    @forelse($recentPayments ?? [] as $payment)
                    <div class="futuristic-card p-2 p-md-3" style="border-color: rgba(34, 197, 94, 0.2); background: rgba(34, 197, 94, 0.05);">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center flex-grow-1" style="min-width: 0;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" 
                                     style="width: 40px; height: 40px; min-width: 40px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.3);">
                                    <i class="fas fa-dollar-sign" style="color: #22c55e; font-size: 0.9rem;"></i>
                                </div>
                                <div class="flex-grow-1" style="min-width: 0;">
                                    <p class="fw-bold mb-1 small" style="color: var(--text-primary); word-break: break-word;">₱{{ number_format($payment->amount, 2) }}</p>
                                    <p class="small mb-0" style="color: var(--text-secondary); word-break: break-word; font-size: 0.75rem;">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $payment->payment_date->format('M j, Y g:i A') }}
                                    </p>
                                    @if($payment->booking && $payment->booking->room)
                                        <p class="small mb-0" style="color: var(--text-secondary); word-break: break-word; font-size: 0.75rem;">
                                            <i class="fas fa-bed me-1"></i>
                                            Room {{ $payment->booking->room->room_number }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <span class="badge px-2 py-1 rounded-pill flex-shrink-0" 
                                  style="@if($payment->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($payment->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                  @elseif($payment->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                  @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif font-size: 0.7rem;">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" 
                             style="width: 60px; height: 60px; background: rgba(34, 197, 94, 0.1); border: 2px solid rgba(34, 197, 94, 0.3);">
                            <i class="fas fa-credit-card" style="font-size: 1.5rem; color: #22c55e;"></i>
                        </div>
                        <p class="mb-0 small" style="color: var(--text-secondary);">No recent payments</p>
                    </div>
                    @endforelse
                </div>
                <div class="mt-3">
                    <a href="{{ route('tenant.payments') }}" class="btn btn-sm" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 1px solid rgba(34, 197, 94, 0.3); color: #22c55e;">
                        <i class="fas fa-arrow-right me-2"></i>View all payments
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Card -->
<div class="futuristic-card outline-purple mb-4 mb-md-5">
    <div class="p-4 border-bottom" style="border-color: rgba(168, 85, 247, 0.2) !important;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="rounded d-flex align-items-center justify-content-center me-3" 
                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(168, 85, 247, 0.1)); border: 2px solid rgba(168, 85, 247, 0.5);">
                    <i class="fas fa-bolt" style="color: #7c3aed;"></i>
                </div>
                <div>
                    <h3 class="h5 mb-0 fw-bold" style="color: #7c3aed;">Quick Actions</h3>
                    <p class="small mb-0" style="color: var(--text-secondary);">Get things done quickly</p>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4">
        <div class="row g-4">
            <!-- Book a Room -->
            <div class="col-12 col-md-4">
                <a href="{{ route('tenant.bookings.create') }}" class="text-decoration-none">
                    <div class="futuristic-card outline-info h-100 p-3 p-md-4 hover-lift">
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="rounded d-flex align-items-center justify-content-center me-2 me-md-3 flex-shrink-0" 
                                 style="width: 60px; height: 60px; min-width: 60px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.5); box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);">
                                <i class="fas fa-calendar-plus" style="font-size: 1.5rem; color: #0066ff;"></i>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <p class="fw-bold mb-1" style="color: #0066ff; word-break: break-word;">Book a Room</p>
                                <p class="small mb-0" style="color: var(--text-secondary); word-break: break-word;">Make a new room reservation</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Request Maintenance -->
            <div class="col-12 col-md-4">
                <a href="{{ route('tenant.maintenance.create') }}" class="text-decoration-none">
                    <div class="futuristic-card outline-success h-100 p-3 p-md-4 hover-lift">
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="rounded d-flex align-items-center justify-content-center me-2 me-md-3 flex-shrink-0" 
                                 style="width: 60px; height: 60px; min-width: 60px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.5); box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);">
                                <i class="fas fa-tools" style="font-size: 1.5rem; color: #22c55e;"></i>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <p class="fw-bold mb-1" style="color: #22c55e; word-break: break-word;">Request Maintenance</p>
                                <p class="small mb-0" style="color: var(--text-secondary); word-break: break-word;">Report an issue or request service</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- View Payments -->
            <div class="col-12 col-md-4">
                <a href="{{ route('tenant.payments') }}" class="text-decoration-none">
                    <div class="futuristic-card outline-info h-100 p-3 p-md-4 hover-lift">
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="rounded d-flex align-items-center justify-content-center me-2 me-md-3 flex-shrink-0" 
                                 style="width: 60px; height: 60px; min-width: 60px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.5); box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);">
                                <i class="fas fa-credit-card" style="font-size: 1.5rem; color: #00d4ff;"></i>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <p class="fw-bold mb-1" style="color: #00d4ff; word-break: break-word;">View Payments</p>
                                <p class="small mb-0" style="color: var(--text-secondary); word-break: break-word;">Check payment history and status</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Timeline -->
<div class="futuristic-card outline-warning">
    <div class="p-4 border-bottom" style="border-color: rgba(251, 191, 36, 0.2) !important;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="rounded d-flex align-items-center justify-content-center me-3" 
                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(251, 191, 36, 0.1)); border: 2px solid rgba(251, 191, 36, 0.5);">
                    <i class="fas fa-history" style="color: #f59e0b;"></i>
                </div>
                <div>
                    <h3 class="h5 mb-0 fw-bold" style="color: #f59e0b;">Recent Activity</h3>
                    <p class="small mb-0" style="color: var(--text-secondary);">Your latest boarding house activities</p>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4">
        <div class="d-flex flex-column">
            <div class="d-flex align-items-center p-3 futuristic-card mb-3" style="border-color: rgba(0, 212, 255, 0.2); background: rgba(0, 212, 255, 0.05);">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.3);">
                    <i class="fas fa-calendar-check" style="color: #0066ff;"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="fw-bold mb-1" style="color: var(--text-primary);">New booking created</p>
                    <p class="small mb-1" style="color: var(--text-secondary);">Room reservation confirmed</p>
                    <p class="small mb-0" style="color: var(--text-secondary);">2 hours ago</p>
                </div>
            </div>
            
            <div class="d-flex align-items-center p-3 futuristic-card mb-3" style="border-color: rgba(34, 197, 94, 0.2); background: rgba(34, 197, 94, 0.05);">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.3);">
                    <i class="fas fa-credit-card" style="color: #22c55e;"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="fw-bold mb-1" style="color: var(--text-primary);">Payment received</p>
                    <p class="small mb-1" style="color: var(--text-secondary);">Monthly rent payment processed</p>
                    <p class="small mb-0" style="color: var(--text-secondary);">1 day ago</p>
                </div>
            </div>
            
            <div class="d-flex align-items-center p-3 futuristic-card" style="border-color: rgba(251, 191, 36, 0.2); background: rgba(251, 191, 36, 0.05);">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(251, 191, 36, 0.1)); border: 2px solid rgba(251, 191, 36, 0.3);">
                    <i class="fas fa-tools" style="color: #f59e0b;"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="fw-bold mb-1" style="color: var(--text-primary);">Maintenance request updated</p>
                    <p class="small mb-1" style="color: var(--text-secondary);">Your request is now in progress</p>
                    <p class="small mb-0" style="color: var(--text-secondary);">3 days ago</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.hover-lift:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 15px 40px rgba(0, 212, 255, 0.3) !important;
}
</style>

@endsection
