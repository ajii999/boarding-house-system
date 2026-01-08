@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Futuristic Welcome Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5 position-relative stat-card" style="overflow: visible; z-index: 1;">
    <div class="position-relative z-2">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="mb-3 mb-md-0">
                <h1 class="h2 h3-md fw-bold mb-2" style="background: linear-gradient(135deg, #0066ff, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Welcome back, Admin!
                </h1>
                <p class="mb-0" style="color: var(--text-secondary);">Real-time monitoring and control system</p>
            </div>
            <div class="d-none d-md-block">
                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 100px; height: 100px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(124, 58, 237, 0.15)); border: 2px solid rgba(0, 102, 255, 0.4); box-shadow: 0 0 30px rgba(0, 102, 255, 0.3);">
                    <i class="fas fa-cube" style="font-size: 3rem; color: #0066ff;"></i>
        </div>
            </div>
        </div>
    </div>
</div>

<!-- Futuristic Stats Cards Row -->
<div class="row g-3 g-md-4 mb-4 mb-md-5">
    <!-- Total Tenants Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <a href="{{ route('admin.tenants.index') }}" class="text-decoration-none">
            <div class="futuristic-card stat-card h-100 p-3 p-md-4" style="border-color: rgba(0, 102, 255, 0.3); overflow: visible;">
                <div class="d-flex align-items-center justify-content-between position-relative z-2 flex-wrap" style="gap: 0.5rem;">
                    <div class="flex-grow-1 me-2 me-md-3" style="min-width: 0;">
                        <p class="small mb-2" style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Total Tenants</p>
                        <p class="h2 fw-bold mb-2" style="color: #0066ff; word-break: break-word; font-size: clamp(1.5rem, 3vw, 2rem);">{{ $totalTenants ?? 0 }}</p>
                        <p class="small mb-0" style="color: #0066ff;">
                            <i class="fas fa-arrow-up me-1"></i>+12% Growth
                        </p>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 55px; height: 55px; min-width: 55px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.4); box-shadow: 0 0 20px rgba(0, 102, 255, 0.2);">
                        <i class="fas fa-users" style="font-size: 1.4rem; color: #0066ff;"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Available Rooms Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <a href="{{ route('admin.rooms.index') }}" class="text-decoration-none">
            <div class="futuristic-card stat-card h-100 p-3 p-md-4" style="border-color: rgba(34, 197, 94, 0.3); overflow: visible;">
                <div class="d-flex align-items-center justify-content-between position-relative z-2 flex-wrap" style="gap: 0.5rem;">
                    <div class="flex-grow-1 me-2 me-md-3" style="min-width: 0;">
                        <p class="small mb-2" style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Available Rooms</p>
                        <p class="h2 fw-bold mb-2" style="color: #22c55e; word-break: break-word; font-size: clamp(1.5rem, 3vw, 2rem);">{{ $availableRooms ?? 0 }}</p>
                        <p class="small mb-0" style="color: #22c55e;">
                            <i class="fas fa-bed me-1"></i>Ready
                        </p>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 55px; height: 55px; min-width: 55px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.08)); border: 2px solid rgba(34, 197, 94, 0.4); box-shadow: 0 0 20px rgba(34, 197, 94, 0.2);">
                        <i class="fas fa-bed" style="font-size: 1.4rem; color: #22c55e;"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Active Bookings Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <a href="{{ route('admin.bookings.index') }}" class="text-decoration-none">
            <div class="futuristic-card stat-card h-100 p-3 p-md-4" style="border-color: rgba(251, 191, 36, 0.3); overflow: visible;">
                <div class="d-flex align-items-center justify-content-between position-relative z-2 flex-wrap" style="gap: 0.5rem;">
                    <div class="flex-grow-1 me-2 me-md-3" style="min-width: 0;">
                        <p class="small mb-2" style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Active Bookings</p>
                        <p class="h2 fw-bold mb-2" style="color: #f59e0b; word-break: break-word; font-size: clamp(1.5rem, 3vw, 2rem);">{{ $activeBookings ?? 0 }}</p>
                        <p class="small mb-0" style="color: #f59e0b;">
                            <i class="fas fa-calendar-check me-1"></i>Active
                        </p>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 55px; height: 55px; min-width: 55px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.08)); border: 2px solid rgba(245, 158, 11, 0.4); box-shadow: 0 0 20px rgba(245, 158, 11, 0.2);">
                        <i class="fas fa-calendar-check" style="font-size: 1.4rem; color: #f59e0b;"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Monthly Revenue Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <a href="{{ route('admin.reports.index', ['view' => 'revenue']) }}" class="text-decoration-none">
            <div class="futuristic-card stat-card h-100 p-3 p-md-4" style="border-color: rgba(168, 85, 247, 0.3); overflow: visible;">
                <div class="d-flex align-items-center justify-content-between position-relative z-2 flex-wrap" style="gap: 0.5rem;">
                    <div class="flex-grow-1 me-2 me-md-3" style="min-width: 0;">
                        <p class="small mb-2" style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Monthly Revenue</p>
                        <p class="h2 fw-bold mb-2" style="color: #7c3aed; word-break: break-word; font-size: clamp(1.3rem, 2.5vw, 1.8rem);">₱{{ number_format($monthlyRevenue ?? 0, 2) }}</p>
                        <p class="small mb-0" style="color: #7c3aed;">
                            <i class="fas fa-chart-line me-1"></i>View Earnings
                        </p>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 55px; height: 55px; min-width: 55px; background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(124, 58, 237, 0.08)); border: 2px solid rgba(124, 58, 237, 0.4); box-shadow: 0 0 20px rgba(124, 58, 237, 0.2);">
                        <i class="fas fa-coins" style="font-size: 1.4rem; color: #7c3aed;"></i>
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
        <div class="futuristic-card h-100" style="border-color: rgba(0, 212, 255, 0.3);">
            <div class="p-4 border-bottom" style="border-color: rgba(0, 212, 255, 0.2) !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.5);">
                            <i class="fas fa-calendar-alt" style="color: #0066ff;"></i>
                        </div>
                        <div>
                            <h3 class="h5 mb-0 fw-bold" style="color: #0066ff;">Recent Bookings</h3>
                            <p class="small mb-0" style="color: var(--text-secondary);">{{ count($recentBookings ?? []) }} total</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="d-flex flex-column gap-3">
                    @forelse($recentBookings ?? [] as $booking)
                    <div class="futuristic-card p-3" style="border-color: rgba(0, 212, 255, 0.2); background: rgba(0, 212, 255, 0.05);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.3);">
                                    <i class="fas fa-user" style="color: #0066ff;"></i>
                                </div>
                                <div>
                                    <p class="fw-bold mb-1" style="color: var(--text-primary);">{{ $booking->tenant->name ?? 'N/A' }}</p>
                                    <p class="small mb-1" style="color: var(--text-secondary);">
                                        <i class="fas fa-bed me-2" style="color: #0066ff;"></i>Room {{ $booking->room->room_number ?? 'N/A' }}
                                    </p>
                                    <p class="small mb-0" style="color: var(--text-secondary);">
                                        <i class="fas fa-calendar me-2"></i>{{ $booking->check_in }} - {{ $booking->check_out }}
                                    </p>
                                </div>
                            </div>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($booking->status === 'confirmed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($booking->status === 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                  @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                        </div>
                </div>
                @empty
                    <div class="text-center py-5">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 80px; height: 80px; background: rgba(0, 212, 255, 0.1); border: 2px solid rgba(0, 212, 255, 0.3);">
                            <i class="fas fa-calendar-times" style="font-size: 2rem; color: #0066ff;"></i>
                        </div>
                        <p class="mb-0" style="color: var(--text-secondary);">No recent bookings</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Maintenance Card -->
    <div class="col-12 col-lg-6">
        <div class="futuristic-card h-100" style="border-color: rgba(251, 191, 36, 0.3);">
            <div class="p-4 border-bottom" style="border-color: rgba(251, 191, 36, 0.2) !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(251, 191, 36, 0.1)); border: 2px solid rgba(251, 191, 36, 0.5);">
                            <i class="fas fa-tools" style="color: #f59e0b;"></i>
                        </div>
                        <div>
                            <h3 class="h5 mb-0 fw-bold" style="color: #f59e0b;">Pending Maintenance</h3>
                            <p class="small mb-0" style="color: var(--text-secondary);">{{ count($pendingMaintenance ?? []) }} pending</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="d-flex flex-column gap-3">
                @forelse($pendingMaintenance ?? [] as $request)
                    <div class="futuristic-card p-3" style="border-color: rgba(251, 191, 36, 0.2); background: rgba(251, 191, 36, 0.05);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(251, 191, 36, 0.1)); border: 2px solid rgba(251, 191, 36, 0.3);">
                                    <i class="fas fa-wrench" style="color: #f59e0b;"></i>
                        </div>
                        <div>
                                    <p class="fw-bold mb-1" style="color: var(--text-primary);">{{ $request->tenant->name ?? 'N/A' }}</p>
                                    <p class="small mb-1" style="color: var(--text-secondary);">
                                        <i class="fas fa-exclamation-triangle me-2" style="color: #f59e0b;"></i>{{ $request->issue_type }}
                            </p>
                                    <p class="small mb-0" style="color: var(--text-secondary);">
                                        <i class="fas fa-clock me-2"></i>{{ $request->request_date }}
                            </p>
                        </div>
                    </div>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($request->priority === 'urgent') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                  @elseif($request->priority === 'high') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                  @elseif($request->priority === 'medium') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                  @else background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e; @endif">
                        {{ ucfirst($request->priority) }}
                    </span>
                        </div>
                </div>
                @empty
                    <div class="text-center py-5">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 80px; height: 80px; background: rgba(251, 191, 36, 0.1); border: 2px solid rgba(251, 191, 36, 0.3);">
                            <i class="fas fa-check-circle" style="font-size: 2rem; color: #f59e0b;"></i>
                        </div>
                        <p class="mb-0" style="color: var(--text-secondary);">No pending maintenance requests</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Card -->
<div class="futuristic-card mb-4 mb-md-5" style="border-color: rgba(168, 85, 247, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(168, 85, 247, 0.2) !important;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded d-flex align-items-center justify-content-center" 
                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(168, 85, 247, 0.1)); border: 2px solid rgba(168, 85, 247, 0.5);">
                    <i class="fas fa-bolt" style="color: #7c3aed;"></i>
                </div>
                <div>
                    <h3 class="h5 mb-0 fw-bold" style="color: #7c3aed;">Quick Actions</h3>
                    <p class="small mb-0" style="color: var(--text-secondary);">Fast access controls</p>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4">
        <div class="row g-4">
            <!-- Add New Tenant -->
            <div class="col-12 col-md-4">
                <a href="{{ route('admin.tenants.create') }}" class="text-decoration-none">
                    <div class="futuristic-card h-100 p-4 hover-lift" style="border-color: rgba(0, 212, 255, 0.3);">
                        <div class="d-flex align-items-center">
                            <div class="rounded d-flex align-items-center justify-content-center me-3" 
                                 style="width: 70px; height: 70px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.5); box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);">
                                <i class="fas fa-user-plus" style="font-size: 1.8rem; color: #0066ff;"></i>
                </div>
                <div>
                                <p class="fw-bold mb-1" style="color: #0066ff;">Add New Tenant</p>
                                <p class="small mb-0" style="color: var(--text-secondary);">Register a new tenant</p>
                            </div>
                        </div>
                </div>
            </a>
            </div>
            
            <!-- Add New Room -->
            <div class="col-12 col-md-4">
                <a href="{{ route('admin.rooms.create') }}" class="text-decoration-none">
                    <div class="futuristic-card h-100 p-4 hover-lift" style="border-color: rgba(34, 197, 94, 0.3);">
                        <div class="d-flex align-items-center">
                            <div class="rounded d-flex align-items-center justify-content-center me-3" 
                                 style="width: 70px; height: 70px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.5); box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);">
                                <i class="fas fa-plus" style="font-size: 1.8rem; color: #22c55e;"></i>
                </div>
                <div>
                                <p class="fw-bold mb-1" style="color: #22c55e;">Add New Room</p>
                                <p class="small mb-0" style="color: var(--text-secondary);">Register a new room</p>
                            </div>
                        </div>
                </div>
            </a>
            </div>
            
            <!-- Report and Analytics -->
            <div class="col-12 col-md-4">
                <a href="{{ route('admin.reports.index') }}" class="text-decoration-none">
                    <div class="futuristic-card h-100 p-4 hover-lift" style="border-color: rgba(168, 85, 247, 0.3);">
                        <div class="d-flex align-items-center">
                            <div class="rounded d-flex align-items-center justify-content-center me-3" 
                                 style="width: 70px; height: 70px; background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(168, 85, 247, 0.1)); border: 2px solid rgba(168, 85, 247, 0.5); box-shadow: 0 0 20px rgba(168, 85, 247, 0.3);">
                                <i class="fas fa-chart-line" style="font-size: 1.8rem; color: #7c3aed;"></i>
                </div>
                <div>
                                <p class="fw-bold mb-1" style="color: #7c3aed;">Report & Analytics</p>
                                <p class="small mb-0" style="color: var(--text-secondary);">Create occupancy & revenue reports</p>
                            </div>
                        </div>
                </div>
            </a>
            </div>
        </div>
    </div>
</div>

<!-- Additional Quick Stats Row -->
<div class="row g-4 mb-4 mb-md-5">
    <!-- Today's Bookings -->
    <div class="col-12 col-md-4">
        <div class="futuristic-card h-100 p-4 stat-card" style="border-color: rgba(0, 212, 255, 0.5); background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(124, 58, 237, 0.1));">
            <div class="d-flex align-items-center justify-content-between position-relative z-2">
            <div>
                    <p class="small mb-2" style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Today's Bookings</p>
                    <p class="h2 fw-bold mb-1" style="color: #0066ff;">12</p>
                    <p class="small mb-0" style="color: var(--text-secondary);">+3 from yesterday</p>
                </div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 60px; height: 60px; background: rgba(0, 212, 255, 0.2); border: 2px solid rgba(0, 212, 255, 0.5); box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);">
                    <i class="fas fa-calendar-day" style="color: #0066ff;"></i>
            </div>
            </div>
        </div>
    </div>

    <!-- Occupancy Rate -->
    <div class="col-12 col-md-4">
        <div class="futuristic-card h-100 p-4 stat-card" style="border-color: rgba(34, 197, 94, 0.5); background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(0, 212, 255, 0.1));">
            <div class="d-flex align-items-center justify-content-between position-relative z-2">
            <div>
                    <p class="small mb-2" style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Occupancy Rate</p>
                        <p class="h2 fw-bold mb-1" style="color: #22c55e;">85%</p>
                    <p class="small mb-0" style="color: var(--text-secondary);">Above average</p>
                </div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 60px; height: 60px; background: rgba(34, 197, 94, 0.2); border: 2px solid rgba(34, 197, 94, 0.5); box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);">
                    <i class="fas fa-percentage" style="color: #22c55e;"></i>
            </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Requests -->
    <div class="col-12 col-md-4">
        <div class="futuristic-card h-100 p-4 stat-card" style="border-color: rgba(251, 191, 36, 0.5); background: linear-gradient(135deg, rgba(251, 191, 36, 0.1), rgba(239, 68, 68, 0.1));">
            <div class="d-flex align-items-center justify-content-between position-relative z-2">
            <div>
                    <p class="small mb-2" style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Maintenance Requests</p>
                    <p class="h2 fw-bold mb-1" style="color: #f59e0b;">5</p>
                    <p class="small mb-0" style="color: var(--text-secondary);">2 urgent</p>
                </div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 60px; height: 60px; background: rgba(251, 191, 36, 0.2); border: 2px solid rgba(251, 191, 36, 0.5); box-shadow: 0 0 20px rgba(251, 191, 36, 0.3);">
                    <i class="fas fa-tools" style="color: #f59e0b;"></i>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Payments Section -->
@if(isset($recentPayments) && $recentPayments->count() > 0)
<div class="futuristic-card mb-4 mb-md-5" style="border-color: rgba(34, 197, 94, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(34, 197, 94, 0.2) !important;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded d-flex align-items-center justify-content-center" 
                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.5);">
                    <i class="fas fa-credit-card" style="color: #22c55e;"></i>
                </div>
                <div>
                    <h3 class="h5 mb-0 fw-bold" style="color: #22c55e;">Recent Payments</h3>
                    <p class="small mb-0" style="color: var(--text-secondary);">Latest payment transactions</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="p-4">
        <div class="d-flex flex-column gap-3">
                @foreach($recentPayments as $payment)
            <div class="futuristic-card p-3" style="border-color: rgba(34, 197, 94, 0.2); background: rgba(34, 197, 94, 0.05);">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.3);">
                            <i class="fas fa-dollar-sign" style="color: #22c55e;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1" style="color: var(--text-primary);">{{ $payment->tenant->name ?? 'Unknown Tenant' }}</h5>
                            <p class="small mb-1" style="color: var(--text-secondary);">
                                <i class="fas fa-calendar me-2"></i>
                                {{ $payment->payment_date->format('M j, Y g:i A') }}
                            </p>
                            @if($payment->booking && $payment->booking->room)
                                <p class="small mb-0" style="color: var(--text-secondary);">
                                    <i class="fas fa-bed me-2"></i>
                                    Room {{ $payment->booking->room->room_number }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="text-end">
                        <p class="h4 fw-bold mb-2" style="color: #22c55e;">₱{{ number_format($payment->amount, 2) }}</p>
                        <span class="badge px-3 py-2 rounded-pill" 
                              style="@if($payment->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                              @elseif($payment->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                              @elseif($payment->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                              @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                    </div>
                </div>
            </div>
                @endforeach
            </div>
            
        <div class="text-center mt-4">
            <a href="{{ route('admin.payments.index') }}" class="btn btn-neon">
                <i class="fas fa-list me-2"></i>View All Payments
                </a>
            </div>
    </div>
</div>
@endif

<!-- Notifications Section -->
@if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
<div class="futuristic-card" style="border-color: rgba(0, 212, 255, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 212, 255, 0.2) !important;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded d-flex align-items-center justify-content-center" 
                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.5);">
                    <i class="fas fa-bell" style="color: #00d4ff;"></i>
                </div>
                <div>
                    <h3 class="h5 mb-0 fw-bold" style="color: #00d4ff;">Recent Notifications</h3>
                    <p class="text-muted small mb-0">{{ $unreadNotifications->count() }} unread notifications</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="p-4">
        <div class="d-flex flex-column gap-3">
            @foreach($unreadNotifications->take(5) as $notification)
            <div class="futuristic-card p-3" style="border-color: rgba(0, 212, 255, 0.2); background: rgba(0, 212, 255, 0.05);">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.3);">
                        <i class="fas fa-bell small" style="color: #00d4ff;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold text-white mb-1">{{ $notification->title }}</h5>
                        <p class="text-muted small mb-1">{{ $notification->message }}</p>
                        <p class="text-muted small mb-0">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-neon">
                <i class="fas fa-bell me-2"></i>View All Notifications
            </a>
        </div>
    </div>
</div>
@endif

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
