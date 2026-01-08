@extends('layouts.staff')

@section('title', 'Staff Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 g-md-4 mb-4">
    <!-- Stats Cards -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="futuristic-card stat-card p-3 p-md-4">
            <div class="d-flex align-items-center flex-wrap">
                <div class="flex-grow-1 min-width-0">
                    <p class="small text-muted mb-1" style="color: var(--text-secondary);">Assigned Tasks</p>
                    <p class="h4 fw-bold mb-0" style="color: var(--text-primary);">{{ $assignedTasks ?? 0 }}</p>
                </div>
                <div class="d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(22, 163, 74, 0.2)); border-radius: 16px; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2);">
                    <i class="fas fa-tasks" style="font-size: 1.5rem; color: #22c55e;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="futuristic-card stat-card p-3 p-md-4">
            <div class="d-flex align-items-center flex-wrap">
                <div class="flex-grow-1 min-width-0">
                    <p class="small text-muted mb-1" style="color: var(--text-secondary);">Completed Tasks</p>
                    <p class="h4 fw-bold mb-0" style="color: var(--text-primary);">{{ $completedTasks ?? 0 }}</p>
                </div>
                <div class="d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.2)); border-radius: 16px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);">
                    <i class="fas fa-check-circle" style="font-size: 1.5rem; color: #3b82f6;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="futuristic-card stat-card p-3 p-md-4">
            <div class="d-flex align-items-center flex-wrap">
                <div class="flex-grow-1 min-width-0">
                    <p class="small text-muted mb-1" style="color: var(--text-secondary);">Maintenance Requests</p>
                    <p class="h4 fw-bold mb-0" style="color: var(--text-primary);">{{ $maintenanceRequests ?? 0 }}</p>
                </div>
                <div class="d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(202, 138, 4, 0.2)); border-radius: 16px; box-shadow: 0 4px 12px rgba(234, 179, 8, 0.2);">
                    <i class="fas fa-wrench" style="font-size: 1.5rem; color: #eab308;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="futuristic-card stat-card p-3 p-md-4">
            <div class="d-flex align-items-center flex-wrap">
                <div class="flex-grow-1 min-width-0">
                    <p class="small text-muted mb-1" style="color: var(--text-secondary);">Unread Notifications</p>
                    <p class="h4 fw-bold mb-0" style="color: var(--text-primary);">{{ $unreadNotifications ?? 0 }}</p>
                </div>
                <div class="d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(147, 51, 234, 0.2)); border-radius: 16px; box-shadow: 0 4px 12px rgba(168, 85, 247, 0.2);">
                    <i class="fas fa-bell" style="font-size: 1.5rem; color: #a855f7;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 g-md-4">
    <!-- My Tasks -->
    <div class="col-12 col-lg-6">
        <div class="futuristic-card">
            <div class="p-3 p-md-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.1) !important;">
                <h3 class="h5 fw-semibold mb-0" style="color: var(--text-primary);">My Recent Tasks</h3>
            </div>
            <div class="p-3 p-md-4">
                <div class="d-flex flex-column gap-3">
                    @forelse($recentTasks ?? [] as $task)
                    <div class="futuristic-card p-3" style="background: rgba(248, 250, 252, 0.8);">
                        <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                            <div class="flex-grow-1 min-width-0">
                                <p class="fw-semibold mb-1" style="color: var(--text-primary);">{{ $task->task_type }}</p>
                                <p class="small text-muted mb-1">{{ Str::limit($task->description, 50) }}</p>
                                <p class="small mb-0" style="color: var(--text-secondary);">Due: {{ $task->due_date }}</p>
                            </div>
                            <span class="badge rounded-pill px-3 py-2 
                                @if($task->status === 'completed') bg-success
                                @elseif($task->status === 'in_progress') bg-primary
                                @elseif($task->status === 'pending') bg-warning
                                @else bg-danger @endif" 
                                style="font-size: 0.7rem; white-space: nowrap; z-index: 10;">
                                {{ ucfirst($task->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center py-4">No recent tasks</p>
                    @endforelse
                </div>
                <div class="mt-3">
                    <a href="{{ route('staff.tasks') }}" class="text-decoration-none" style="color: var(--primary-neon);">
                        <span class="small fw-semibold">View all tasks <i class="fas fa-arrow-right ms-1"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Requests -->
    <div class="col-12 col-lg-6">
        <div class="futuristic-card">
            <div class="p-3 p-md-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.1) !important;">
                <h3 class="h5 fw-semibold mb-0" style="color: var(--text-primary);">Recent Maintenance Requests</h3>
            </div>
            <div class="p-3 p-md-4">
                <div class="d-flex flex-column gap-3">
                    @forelse($recentMaintenance ?? [] as $request)
                    <div class="futuristic-card p-3" style="background: rgba(248, 250, 252, 0.8);">
                        <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                            <div class="flex-grow-1 min-width-0">
                                <p class="fw-semibold mb-1" style="color: var(--text-primary);">{{ $request->issue_type }}</p>
                                <p class="small text-muted mb-1">{{ $request->tenant->name ?? 'N/A' }}</p>
                                <p class="small mb-0" style="color: var(--text-secondary);">{{ $request->request_date }}</p>
                            </div>
                            <span class="badge rounded-pill px-3 py-2 
                                @if($request->priority === 'urgent') bg-danger
                                @elseif($request->priority === 'high') bg-warning
                                @elseif($request->priority === 'medium') bg-info
                                @else bg-success @endif" 
                                style="font-size: 0.7rem; white-space: nowrap; z-index: 10;">
                                {{ ucfirst($request->priority) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center py-4">No maintenance requests</p>
                    @endforelse
                </div>
                <div class="mt-3">
                    <a href="{{ route('staff.maintenance') }}" class="text-decoration-none" style="color: var(--primary-neon);">
                        <span class="small fw-semibold">View all requests <i class="fas fa-arrow-right ms-1"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-4 mt-md-5">
    <div class="futuristic-card">
        <div class="p-3 p-md-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.1) !important;">
            <h3 class="h5 fw-semibold mb-0" style="color: var(--text-primary);">Quick Actions</h3>
        </div>
        <div class="p-3 p-md-4">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <a href="{{ route('staff.tasks') }}" class="text-decoration-none">
                        <div class="futuristic-card p-3 p-md-4 h-100" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(22, 163, 74, 0.05)); border-color: rgba(34, 197, 94, 0.3);">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0 me-3" 
                                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(22, 163, 74, 0.2)); border-radius: 12px;">
                                    <i class="fas fa-tasks" style="font-size: 1.25rem; color: #22c55e;"></i>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <p class="fw-semibold mb-1" style="color: #15803d;">View My Tasks</p>
                                    <p class="small mb-0" style="color: var(--text-secondary);">Check assigned tasks and update status</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-md-4">
                    <a href="{{ route('staff.maintenance') }}" class="text-decoration-none">
                        <div class="futuristic-card p-3 p-md-4 h-100" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(37, 99, 235, 0.05)); border-color: rgba(59, 130, 246, 0.3);">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0 me-3" 
                                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.2)); border-radius: 12px;">
                                    <i class="fas fa-wrench" style="font-size: 1.25rem; color: #3b82f6;"></i>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <p class="fw-semibold mb-1" style="color: #2563eb;">Maintenance Requests</p>
                                    <p class="small mb-0" style="color: var(--text-secondary);">View and manage maintenance requests</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-md-4">
                    <a href="{{ route('staff.notifications') }}" class="text-decoration-none">
                        <div class="futuristic-card p-3 p-md-4 h-100" style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.1), rgba(147, 51, 234, 0.05)); border-color: rgba(168, 85, 247, 0.3);">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0 me-3" 
                                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(147, 51, 234, 0.2)); border-radius: 12px;">
                                    <i class="fas fa-bell" style="font-size: 1.25rem; color: #a855f7;"></i>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <p class="fw-semibold mb-1" style="color: #9333ea;">Notifications</p>
                                    <p class="small mb-0" style="color: var(--text-secondary);">Check task updates and alerts</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
