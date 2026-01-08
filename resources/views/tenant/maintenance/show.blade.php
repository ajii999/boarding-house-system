@extends('layouts.tenant')

@section('title', 'Maintenance Request Details')
@section('page-title', 'Maintenance Request Details')

@section('content')
<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="/tenant/maintenance-requests" 
           id="backToMaintenanceBtn"
           class="btn btn-sm d-inline-flex align-items-center" 
           style="color: var(--text-secondary); text-decoration: none; cursor: pointer; pointer-events: auto; position: relative; z-index: 1000;">
            <i class="fas fa-arrow-left me-2"></i>
            <span>Back to Maintenance Requests</span>
        </a>
    </div>
    
    <!-- Maintenance Request Information Card -->
    <div class="futuristic-card mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
        <div class="p-4 p-md-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div>
                    <h3 class="h4 fw-bold mb-1" style="color: var(--primary-neon);">Request #{{ str_pad($maintenance->request_id ?? 0, 6, '0', STR_PAD_LEFT) }}</h3>
                    <p class="mb-0 small" style="color: var(--text-secondary);">{{ $maintenance->issue_type ?? 'N/A' }} - {{ $maintenance->request_date ? $maintenance->request_date->format('M j, Y') : 'N/A' }}</p>
                </div>
                <div class="mt-3 mt-md-0 d-flex flex-wrap align-items-center gap-2">
                    <span class="badge px-3 py-2 rounded-pill" 
                          style="@if($maintenance->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                          @elseif($maintenance->status == 'assigned') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                          @elseif($maintenance->status == 'in_progress') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                          @elseif($maintenance->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                          @elseif($maintenance->status == 'tenant_confirmed') background: linear-gradient(135deg, rgba(124, 58, 237, 0.3), rgba(124, 58, 237, 0.2)); border: 1px solid rgba(124, 58, 237, 0.5); color: #7c3aed;
                          @elseif($maintenance->status == 'closed') background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8;
                          @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; @endif">
                        {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
                    </span>
                    @if($maintenance->status == 'completed')
                        <form method="POST" action="{{ route('tenant.maintenance.confirm', $maintenance->request_id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-neon btn-sm" onclick="return confirm('Confirm that the maintenance work is satisfactory?')">
                                <i class="fas fa-check-circle me-1"></i>Confirm Completion
                            </button>
                        </form>
                    @endif
                    @if($maintenance->status == 'pending')
                        <a href="{{ route('tenant.maintenance.edit', $maintenance) }}" class="btn btn-neon btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit Request
                        </a>
                    @endif
                </div>
            </div>
            <div class="border-top pt-4" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Issue Type</dt>
                            <dd class="mb-0" style="color: var(--text-primary);">{{ $maintenance->issue_type ?? 'N/A' }}</dd>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Priority</dt>
                            <dd class="mb-0">
                                <span class="badge px-3 py-2 rounded-pill" 
                                      style="@if($maintenance->priority == 'urgent') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                      @elseif($maintenance->priority == 'high') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                      @elseif($maintenance->priority == 'medium') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                      @else background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e; @endif">
                                    {{ ucfirst($maintenance->priority) }}
                                </span>
                            </dd>
                        </div>
                    </div>
                    @if($maintenance->room)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Room</dt>
                            <dd class="mb-0" style="color: var(--text-primary);">Room {{ $maintenance->room->room_number ?? 'N/A' }} - {{ $maintenance->room->room_type ?? 'N/A' }}</dd>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6">
                        <div class="mb-3">
                            <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Request Date</dt>
                            <dd class="mb-0" style="color: var(--text-primary);">{{ $maintenance->request_date ? $maintenance->request_date->format('M j, Y') : 'N/A' }}</dd>
                        </div>
                    </div>
                    @if($maintenance->assignedStaff)
                    <div class="col-12">
                        <div class="mb-3">
                            <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Assigned To</dt>
                            <dd class="mb-0 d-flex align-items-center gap-3">
                                @if($maintenance->assignedStaff->profile_picture ?? null)
                                    <button onclick="openProfileModal('{{ asset('storage/' . $maintenance->assignedStaff->profile_picture) }}', '{{ $maintenance->assignedStaff->name ?? 'Staff' }}')" class="btn p-0 border-0">
                                        <img src="{{ asset('storage/' . $maintenance->assignedStaff->profile_picture) }}" 
                                             alt="{{ $maintenance->assignedStaff->name ?? 'Staff' }}"
                                             class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid rgba(0, 102, 255, 0.3);">
                                    </button>
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.3);">
                                        <i class="fas fa-user" style="color: #0066ff;"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold" style="color: var(--text-primary);">{{ $maintenance->assignedStaff->name ?? 'Unassigned' }}</div>
                                    <div class="small" style="color: var(--text-secondary);">{{ $maintenance->assignedStaff->position ?? $maintenance->assignedStaff->role ?? 'Staff Member' }}</div>
                                </div>
                            </dd>
                        </div>
                    </div>
                    @endif
                    @if($maintenance->description)
                    <div class="col-12">
                        <div class="mb-3">
                            <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Description</dt>
                            <dd class="mb-0" style="color: var(--text-primary);">{{ $maintenance->description }}</dd>
                        </div>
                    </div>
                    @endif
                    @if($maintenance->tenant_photo)
                    <div class="col-12">
                        <div class="mb-3">
                            <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Photo of Issue</dt>
                            <dd class="mb-0">
                                <button onclick="openTenantPhotoModal('{{ asset('storage/' . $maintenance->tenant_photo) }}')" class="btn p-0 border-0">
                                    <img src="{{ asset('storage/' . $maintenance->tenant_photo) }}" 
                                         alt="Issue photo" 
                                         class="rounded" 
                                         style="max-height: 200px; cursor: pointer; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease; border: 2px solid rgba(0, 102, 255, 0.3);"
                                         onmouseover="this.style.transform='scale(1.05)'"
                                         onmouseout="this.style.transform='scale(1)'">
                                </button>
                                <p class="small mt-2 mb-0" style="color: var(--text-secondary);">
                                    <i class="fas fa-info-circle me-1"></i>Click to view full size
                                </p>
                            </dd>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Room Information -->
    @if($maintenance->room)
    <div class="futuristic-card mb-4" style="border-color: rgba(34, 197, 94, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: #22c55e;">Room Information</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Details of the room where the maintenance is needed.</p>
            <div class="border-top pt-4" style="border-color: rgba(34, 197, 94, 0.2) !important;">
                <div class="row g-3">
                    <div class="col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Room Number</dt>
                        <dd class="mb-0" style="color: var(--text-primary);">{{ $maintenance->room->room_number }}</dd>
                    </div>
                    <div class="col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Room Type</dt>
                        <dd class="mb-0" style="color: var(--text-primary);">{{ $maintenance->room->room_type }}</dd>
                    </div>
                    <div class="col-md-4">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Room Status</dt>
                        <dd class="mb-0">
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($maintenance->room->status == 'available') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($maintenance->room->status == 'booked') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                  @else background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b; @endif">
                                {{ ucfirst($maintenance->room->status) }}
                            </span>
                        </dd>
                    </div>
                    @if($maintenance->room->description)
                    <div class="col-12">
                        <dt class="small fw-semibold mb-2" style="color: var(--text-secondary);">Description</dt>
                        <dd class="mb-0" style="color: var(--text-primary);">{{ $maintenance->room->description }}</dd>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Related Tasks -->
    @if($maintenance->tasks && $maintenance->tasks->count() > 0)
    <div class="futuristic-card mb-4" style="border-color: rgba(245, 158, 11, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: #f59e0b;">Related Tasks</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Tasks associated with this maintenance request.</p>
            <div class="border-top pt-4" style="border-color: rgba(245, 158, 11, 0.2) !important;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: rgba(245, 158, 11, 0.05);">
                            <tr>
                                <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Task Type</th>
                                <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Description</th>
                                <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Assigned Date</th>
                                <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Due Date</th>
                                <th class="text-uppercase small fw-bold" style="color: var(--text-secondary);">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenance->tasks as $task)
                            <tr>
                                <td style="color: var(--text-primary);">{{ $task->task_type }}</td>
                                <td style="color: var(--text-primary);">{{ Str::limit($task->description, 50) }}</td>
                                <td style="color: var(--text-primary);">{{ $task->assigned_date ? \Carbon\Carbon::parse($task->assigned_date)->format('M j, Y') : 'N/A' }}</td>
                                <td style="color: var(--text-primary);">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M j, Y') : 'N/A' }}</td>
                                <td>
                                    <span class="badge px-3 py-2 rounded-pill" 
                                          style="@if($task->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                          @elseif($task->status == 'in_progress') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                          @elseif($task->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                          @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; @endif">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Work Report Section -->
    @if($maintenance->staff_report)
    <div class="futuristic-card mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: var(--primary-neon);">Work Report</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Report submitted by staff member after completing the work.</p>
            <div class="border-top pt-4" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <textarea readonly class="form-control" rows="6" style="background: rgba(0, 102, 255, 0.05); border-color: rgba(0, 102, 255, 0.2); color: var(--text-primary);">{{ $maintenance->staff_report }}</textarea>
            </div>
        </div>
    </div>
    @endif

    <!-- Proof Photo Section -->
    @if($maintenance->staff_proof_photo)
    <div class="futuristic-card mb-4" style="border-color: rgba(236, 72, 153, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: var(--accent-neon);">Proof Photo</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Photo uploaded by staff as proof of completed work.</p>
            <div class="border-top pt-4" style="border-color: rgba(236, 72, 153, 0.2) !important;">
                <div class="d-flex align-items-center justify-content-center p-4" style="background: rgba(236, 72, 153, 0.05); border-radius: 12px;">
                    <button onclick="openProofPhotoModal('{{ asset('storage/' . $maintenance->staff_proof_photo) }}')" class="btn p-0 border-0">
                        <img src="{{ asset('storage/' . $maintenance->staff_proof_photo) }}" 
                             alt="Work completed photo" 
                             class="img-fluid rounded" 
                             style="max-height: 300px; cursor: pointer; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'">
                    </button>
                </div>
                <p class="text-center mt-3 small" style="color: var(--text-secondary);">
                    <i class="fas fa-info-circle me-1"></i>Click to view full size
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Workflow Timeline -->
    <div class="futuristic-card mb-4" style="border-color: rgba(124, 58, 237, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: var(--secondary-neon);">Workflow Timeline</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Track the progress of your maintenance request.</p>
            <div class="border-top pt-4" style="border-color: rgba(124, 58, 237, 0.2) !important;">
                <ul class="list-unstyled mb-0">
                    <li class="position-relative pb-4" style="border-left: 2px solid rgba(34, 197, 94, 0.3); padding-left: 1.5rem; margin-left: 1rem;">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <span class="badge rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 2px solid rgba(34, 197, 94, 0.5); color: #22c55e; box-shadow: 0 0 15px rgba(34, 197, 94, 0.4);">
                                    <i class="fas fa-plus"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                    <p class="small mb-0 fw-semibold" style="color: var(--text-primary);">Request submitted</p>
                                    <p class="small mb-0 text-md-end" style="color: var(--text-secondary);">{{ $maintenance->request_date->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    @if($maintenance->assigned_at)
                    <li class="position-relative pb-4" style="border-left: 2px solid rgba(0, 102, 255, 0.3); padding-left: 1.5rem; margin-left: 1rem;">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <span class="badge rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 2px solid rgba(0, 102, 255, 0.5); color: #0066ff; box-shadow: 0 0 15px rgba(0, 102, 255, 0.4);">
                                    <i class="fas fa-user-check"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                    <p class="small mb-0 fw-semibold" style="color: var(--text-primary);">Assigned to {{ $maintenance->assignedStaff->name ?? 'staff member' }}</p>
                                    <p class="small mb-0 text-md-end" style="color: var(--text-secondary);">{{ $maintenance->assigned_at->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                    
                    @if($maintenance->started_at)
                    <li class="position-relative pb-4" style="border-left: 2px solid rgba(245, 158, 11, 0.3); padding-left: 1.5rem; margin-left: 1rem;">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <span class="badge rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 2px solid rgba(245, 158, 11, 0.5); color: #f59e0b; box-shadow: 0 0 15px rgba(245, 158, 11, 0.4);">
                                    <i class="fas fa-tools"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                    <p class="small mb-0 fw-semibold" style="color: var(--text-primary);">Work started</p>
                                    <p class="small mb-0 text-md-end" style="color: var(--text-secondary);">{{ $maintenance->started_at->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                    
                    @if($maintenance->completed_at)
                    <li class="position-relative pb-4" style="border-left: 2px solid rgba(34, 197, 94, 0.3); padding-left: 1.5rem; margin-left: 1rem;">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <span class="badge rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 2px solid rgba(34, 197, 94, 0.5); color: #22c55e; box-shadow: 0 0 15px rgba(34, 197, 94, 0.4);">
                                    <i class="fas fa-check"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                    <p class="small mb-0 fw-semibold" style="color: var(--text-primary);">Work completed</p>
                                    <p class="small mb-0 text-md-end" style="color: var(--text-secondary);">{{ $maintenance->completed_at->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                    
                    @if($maintenance->tenant_confirmed_at)
                    <li style="border-left: 2px solid rgba(124, 58, 237, 0.3); padding-left: 1.5rem; margin-left: 1rem;">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <span class="badge rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(124, 58, 237, 0.3), rgba(124, 58, 237, 0.2)); border: 2px solid rgba(124, 58, 237, 0.5); color: #7c3aed; box-shadow: 0 0 15px rgba(124, 58, 237, 0.4);">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                    <p class="small mb-0 fw-semibold" style="color: var(--text-primary);">Completion confirmed by tenant</p>
                                    <p class="small mb-0 text-md-end" style="color: var(--text-secondary);">{{ $maintenance->tenant_confirmed_at->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <!-- Admin Notes -->
    @if($maintenance->admin_notes)
    <div class="futuristic-card mb-4" style="border-color: rgba(245, 158, 11, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: #f59e0b;">Admin Notes</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Updates and notes from the maintenance team.</p>
            <div class="border-top pt-4" style="border-color: rgba(245, 158, 11, 0.2) !important;">
                <p class="mb-0" style="color: var(--text-primary); line-height: 1.6;">{{ $maintenance->admin_notes }}</p>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Profile Picture Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content futuristic-card" style="border-color: rgba(0, 102, 255, 0.3); background: white !important;">
            <div class="modal-header border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important; background: white !important;">
                <h5 class="modal-title fw-bold" id="profileModalName" style="color: var(--primary-neon);">Staff Profile Picture</h5>
                <button type="button" class="btn-close" onclick="closeProfileModal()" aria-label="Close" style="z-index: 1000; position: relative; pointer-events: auto;"></button>
            </div>
            <div class="modal-body text-center p-4" style="background: white;">
                <img id="profileModalImage" src="" alt="Staff Profile Picture" class="img-fluid rounded shadow-lg" style="border: 2px solid rgba(0, 102, 255, 0.2); filter: none !important; -webkit-filter: none !important;">
            </div>
        </div>
    </div>
</div>

<!-- Tenant Photo Modal -->
<div class="modal fade" id="tenantPhotoModal" tabindex="-1" aria-labelledby="tenantPhotoModalLabel" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content futuristic-card" style="border-color: rgba(0, 102, 255, 0.3); background: white !important;">
            <div class="modal-header border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important; background: white !important;">
                <div>
                    <h5 class="modal-title fw-bold" style="color: var(--primary-neon);">Maintenance Request Photo</h5>
                    <p class="small mb-0" style="color: var(--text-secondary);">Request #{{ str_pad($maintenance->request_id ?? 0, 6, '0', STR_PAD_LEFT) }} - {{ $maintenance->issue_type ?? 'N/A' }}</p>
                </div>
                <button type="button" class="btn-close" onclick="closeTenantPhotoModal()" aria-label="Close" style="z-index: 1000; position: relative; pointer-events: auto;"></button>
            </div>
            <div class="modal-body text-center p-4" style="background: white;">
                <img id="tenantPhotoModalImage" src="" alt="Maintenance Request Photo" class="img-fluid rounded shadow-lg mb-3" style="border: 2px solid rgba(0, 102, 255, 0.2); max-width: 100%; max-height: 70vh; object-fit: contain; background: white; filter: none !important; -webkit-filter: none !important;">
            </div>
            <div class="modal-footer border-top" style="border-color: rgba(0, 102, 255, 0.2) !important; background: white !important;">
                <button type="button" class="btn btn-secondary" onclick="closeTenantPhotoModal()" style="z-index: 1000; position: relative; pointer-events: auto;">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Proof Photo Modal -->
<div class="modal fade" id="proofPhotoModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content futuristic-card" style="border-color: rgba(236, 72, 153, 0.3); background: white !important;">
            <div class="modal-header border-bottom" style="border-color: rgba(236, 72, 153, 0.2) !important; background: white !important;">
                <div>
                    <h5 class="modal-title fw-bold" style="color: var(--accent-neon);">Staff Proof Photo</h5>
                    <p class="small mb-0" style="color: var(--text-secondary);">Request #{{ str_pad($maintenance->request_id ?? 0, 6, '0', STR_PAD_LEFT) }} - {{ $maintenance->issue_type ?? 'N/A' }}</p>
                </div>
                <button type="button" class="btn-close" onclick="closeProofPhotoModal()" aria-label="Close" style="z-index: 1000; position: relative; pointer-events: auto;"></button>
            </div>
            <div class="modal-body text-center p-4" style="background: white;">
                <img id="proofPhotoModalImage" src="" alt="Staff Proof Photo" class="img-fluid rounded shadow-lg" style="max-width: 100%; max-height: 70vh; object-fit: contain; background: white; filter: none !important; -webkit-filter: none !important;">
            </div>
            <div class="modal-footer border-top" style="border-color: rgba(236, 72, 153, 0.2) !important; background: white !important;">
                <button type="button" class="btn btn-secondary" onclick="closeProofPhotoModal()" style="z-index: 1000; position: relative; pointer-events: auto;">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Hide modal backdrop completely */
.modal-backdrop {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
}

.modal-backdrop.show {
    display: none !important;
}

#profileModal,
#tenantPhotoModal,
#proofPhotoModal {
    background: transparent !important;
    z-index: 1055 !important;
}

#profileModal.show,
#tenantPhotoModal.show,
#proofPhotoModal.show {
    background: transparent !important;
    display: block !important;
    pointer-events: none !important;
}

#profileModal .modal-dialog,
#tenantPhotoModal .modal-dialog,
#proofPhotoModal .modal-dialog {
    z-index: 1056 !important;
    position: fixed !important;
    right: 2rem !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    margin: 0 !important;
    pointer-events: auto !important;
    max-width: 60% !important;
}

#profileModal .modal-content,
#tenantPhotoModal .modal-content,
#proofPhotoModal .modal-content {
    z-index: 1057 !important;
    position: relative;
    pointer-events: auto !important;
    background: white !important;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;
}

/* Ensure all modal elements are clickable */
#profileModal button,
#profileModal .btn-close,
#profileModal img,
#tenantPhotoModal button,
#tenantPhotoModal .btn-close,
#tenantPhotoModal img,
#proofPhotoModal button,
#proofPhotoModal .btn-close,
#proofPhotoModal img {
    pointer-events: auto !important;
    position: relative;
    z-index: 1058 !important;
}

/* Ensure body doesn't get locked */
body.modal-open {
    overflow: auto !important;
    padding-right: 0 !important;
}
</style>

@push('scripts')
<script>
let profileModalInstance = null;
let tenantPhotoModalInstance = null;
let proofPhotoModalInstance = null;

// Profile Modal Functions
function openProfileModal(imageSrc, staffName) {
    const modalElement = document.getElementById('profileModal');
    const modalImage = document.getElementById('profileModalImage');
    const modalName = document.getElementById('profileModalName');
    
    modalImage.src = imageSrc;
    modalName.textContent = staffName + ' - Profile Picture';
    
    // Remove any existing modal instances
    const existingModal = bootstrap.Modal.getInstance(modalElement);
    if (existingModal) {
        existingModal.dispose();
    }
    
    // Create new modal instance with no backdrop
    profileModalInstance = new bootstrap.Modal(modalElement, {
        backdrop: false,
        keyboard: true,
        focus: true
    });
    
    profileModalInstance.show();
    
    // Remove backdrop after modal is shown
    modalElement.addEventListener('shown.bs.modal', function() {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.style.display = 'none';
            backdrop.remove();
        });
        
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        modalElement.style.zIndex = '1055';
        modalElement.style.display = 'block';
        modalElement.style.pointerEvents = 'none';
        modalElement.style.background = 'transparent';
        
        const modalDialog = modalElement.querySelector('.modal-dialog');
        if (modalDialog) {
            modalDialog.style.zIndex = '1056';
            modalDialog.style.pointerEvents = 'auto';
        }
        
        const modalContent = modalElement.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.zIndex = '1057';
            modalContent.style.pointerEvents = 'auto';
        }
    }, { once: true });
}

function closeProfileModal() {
    if (profileModalInstance) {
        profileModalInstance.hide();
    }
    
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(backdrop => {
        backdrop.remove();
    });
    
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
}

// Tenant Photo Modal Functions
function openTenantPhotoModal(imageSrc) {
    const modalElement = document.getElementById('tenantPhotoModal');
    const modalImage = document.getElementById('tenantPhotoModalImage');
    
    modalImage.src = imageSrc;
    
    // Remove any existing modal instances
    const existingModal = bootstrap.Modal.getInstance(modalElement);
    if (existingModal) {
        existingModal.dispose();
    }
    
    // Create new modal instance with no backdrop
    tenantPhotoModalInstance = new bootstrap.Modal(modalElement, {
        backdrop: false,
        keyboard: true,
        focus: true
    });
    
    tenantPhotoModalInstance.show();
    
    // Remove backdrop after modal is shown
    modalElement.addEventListener('shown.bs.modal', function() {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.style.display = 'none';
            backdrop.remove();
        });
        
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        modalElement.style.zIndex = '1055';
        modalElement.style.display = 'block';
        modalElement.style.pointerEvents = 'none';
        modalElement.style.background = 'transparent';
        
        const modalDialog = modalElement.querySelector('.modal-dialog');
        if (modalDialog) {
            modalDialog.style.zIndex = '1056';
            modalDialog.style.pointerEvents = 'auto';
        }
        
        const modalContent = modalElement.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.zIndex = '1057';
            modalContent.style.pointerEvents = 'auto';
        }
    }, { once: true });
}

function closeTenantPhotoModal() {
    if (tenantPhotoModalInstance) {
        tenantPhotoModalInstance.hide();
    }
    
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(backdrop => {
        backdrop.remove();
    });
    
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
}

// Proof Photo Modal Functions
function openProofPhotoModal(imageSrc) {
    const modalElement = document.getElementById('proofPhotoModal');
    const modalImage = document.getElementById('proofPhotoModalImage');
    
    modalImage.src = imageSrc;
    
    // Remove any existing modal instances
    const existingModal = bootstrap.Modal.getInstance(modalElement);
    if (existingModal) {
        existingModal.dispose();
    }
    
    // Create new modal instance with no backdrop
    proofPhotoModalInstance = new bootstrap.Modal(modalElement, {
        backdrop: false,
        keyboard: true,
        focus: true
    });
    
    proofPhotoModalInstance.show();
    
    // Remove backdrop after modal is shown
    modalElement.addEventListener('shown.bs.modal', function() {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.style.display = 'none';
            backdrop.remove();
        });
        
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        modalElement.style.zIndex = '1055';
        modalElement.style.display = 'block';
        modalElement.style.pointerEvents = 'none';
        modalElement.style.background = 'transparent';
        
        const modalDialog = modalElement.querySelector('.modal-dialog');
        if (modalDialog) {
            modalDialog.style.zIndex = '1056';
            modalDialog.style.pointerEvents = 'auto';
        }
        
        const modalContent = modalElement.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.zIndex = '1057';
            modalContent.style.pointerEvents = 'auto';
        }
    }, { once: true });
}

function closeProofPhotoModal() {
    if (proofPhotoModalInstance) {
        proofPhotoModalInstance.hide();
    }
    
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(backdrop => {
        backdrop.remove();
    });
    
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
}

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProfileModal();
        closeTenantPhotoModal();
        closeProofPhotoModal();
    }
});

// Close modals when clicking outside
document.getElementById('profileModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeProfileModal();
    }
});

document.getElementById('tenantPhotoModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeTenantPhotoModal();
    }
});

document.getElementById('proofPhotoModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeProofPhotoModal();
    }
});

// Remove any backdrop that Bootstrap might create using MutationObserver
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.addedNodes.length) {
            mutation.addedNodes.forEach(function(node) {
                if (node.classList && node.classList.contains('modal-backdrop')) {
                    node.remove();
}
            });
        }
    });
});

observer.observe(document.body, {
    childList: true,
    subtree: true
});

// Ensure back button works
document.addEventListener('DOMContentLoaded', function() {
    const backButton = document.getElementById('backToMaintenanceBtn');
    if (backButton) {
        // Add click event listener as fallback
        backButton.addEventListener('click', function(e) {
            // If href is empty or route failed, use direct URL
            if (!this.getAttribute('href') || this.getAttribute('href') === '#') {
                e.preventDefault();
                window.location.href = '/tenant/maintenance-requests';
            }
        });
        
        // Ensure the link is clickable
        backButton.style.pointerEvents = 'auto';
        backButton.style.cursor = 'pointer';
    }
});
</script>
@endpush
@endsection
