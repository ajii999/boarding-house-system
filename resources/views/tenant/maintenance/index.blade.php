@extends('layouts.tenant')

@section('title', 'My Maintenance Requests')
@section('page-title', 'My Maintenance Requests')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.4); background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(124, 58, 237, 0.15), rgba(0, 212, 255, 0.1)); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 0 0 30px rgba(0, 102, 255, 0.2);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('tenant.dashboard') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; box-shadow: 0 0 20px rgba(0, 102, 255, 0.4);">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff; text-shadow: 0 0 10px rgba(0, 102, 255, 0.3);">My Maintenance Requests</h1>
                <p class="mb-0 small" style="color: var(--text-secondary);">Manage and track your maintenance requests</p>
            </div>
        </div>
        <a href="{{ route('tenant.maintenance.create') }}" class="btn btn-neon">
            <i class="fas fa-plus me-2"></i>Create New Request
        </a>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="futuristic-card p-4 mb-4" style="border-color: rgba(0, 102, 255, 0.3); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 0 0 20px rgba(0, 102, 255, 0.15);">
    <form method="GET" action="{{ route('tenant.maintenance.index') }}" class="d-flex flex-column flex-md-row align-items-end justify-content-end gap-3">
        <div style="min-width: 300px; max-width: 400px;">
            <label for="search" class="form-label small fw-semibold" style="color: var(--text-primary);">Search</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                   placeholder="Search by issue type, description, priority..." 
                   class="form-control" 
                   style="border: 2px solid rgba(0, 102, 255, 0.3); border-radius: 12px; transition: all 0.3s ease; background: rgba(255, 255, 255, 0.8);"
                   onfocus="this.style.borderColor='rgba(0, 102, 255, 0.6)'; this.style.boxShadow='0 0 20px rgba(0, 102, 255, 0.3)'; this.style.background='rgba(255, 255, 255, 0.95)';"
                   onblur="this.style.borderColor='rgba(0, 102, 255, 0.3)'; this.style.boxShadow='none'; this.style.background='rgba(255, 255, 255, 0.8)';">
        </div>
        <div class="d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-neon">
                <i class="fas fa-search me-1"></i>Search
            </button>
            <a href="{{ route('tenant.maintenance.index') }}" class="btn" style="background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3); color: #0066ff; border-radius: 12px; transition: all 0.3s ease; font-weight: 600;" 
               onmouseover="this.style.background='rgba(0, 102, 255, 0.2)'; this.style.boxShadow='0 0 20px rgba(0, 102, 255, 0.3)'; this.style.transform='translateY(-2px)';"
               onmouseout="this.style.background='rgba(0, 102, 255, 0.1)'; this.style.boxShadow='none'; this.style.transform='translateY(0)';">
                <i class="fas fa-times me-1"></i>Clear
            </a>
        </div>
    </form>
</div>

<!-- Maintenance Requests Table -->
<div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.3); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 0 0 25px rgba(0, 102, 255, 0.15);">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(124, 58, 237, 0.15)); border-bottom: 2px solid rgba(0, 102, 255, 0.3);">
                <tr>
                    <th class="text-uppercase small fw-bold" style="color: #0066ff; text-shadow: 0 0 5px rgba(0, 102, 255, 0.3);">Request #</th>
                    <th class="text-uppercase small fw-bold" style="color: #0066ff; text-shadow: 0 0 5px rgba(0, 102, 255, 0.3);">Issue Type</th>
                    <th class="text-uppercase small fw-bold" style="color: #0066ff; text-shadow: 0 0 5px rgba(0, 102, 255, 0.3);">Room</th>
                    <th class="text-uppercase small fw-bold" style="color: #0066ff; text-shadow: 0 0 5px rgba(0, 102, 255, 0.3);">Priority</th>
                    <th class="text-uppercase small fw-bold" style="color: #0066ff; text-shadow: 0 0 5px rgba(0, 102, 255, 0.3);">Status</th>
                    <th class="text-uppercase small fw-bold" style="color: #0066ff; text-shadow: 0 0 5px rgba(0, 102, 255, 0.3);">Assigned To</th>
                    <th class="text-uppercase small fw-bold" style="color: #0066ff; text-shadow: 0 0 5px rgba(0, 102, 255, 0.3);">Date</th>
                    <th class="text-uppercase small fw-bold" style="color: #0066ff; text-shadow: 0 0 5px rgba(0, 102, 255, 0.3);">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($maintenanceRequests as $request)
                <tr style="transition: all 0.3s ease; border-bottom: 1px solid rgba(0, 102, 255, 0.1);"
                    onmouseover="this.style.background='rgba(0, 102, 255, 0.05)'; this.style.transform='translateX(5px)'; this.style.boxShadow='inset 4px 0 0 rgba(0, 102, 255, 0.5)';"
                    onmouseout="this.style.background='transparent'; this.style.transform='translateX(0)'; this.style.boxShadow='none';">
                    <td class="fw-semibold" style="color: var(--text-primary);">
                        #{{ $request->request_id }}
                    </td>
                    <td style="color: var(--text-primary);">
                        {{ $request->issue_type }}
                    </td>
                    <td style="color: var(--text-primary);">
                        {{ $request->room->room_number ?? 'N/A' }}
                    </td>
                    <td>
                        <span class="badge px-3 py-2 rounded-pill" 
                              style="@if($request->priority == 'urgent') background: linear-gradient(135deg, rgba(239, 68, 68, 0.4), rgba(239, 68, 68, 0.3)); border: 1px solid rgba(239, 68, 68, 0.6); color: #ef4444; box-shadow: 0 0 20px rgba(239, 68, 68, 0.4); text-shadow: 0 0 5px rgba(239, 68, 68, 0.5);
                              @elseif($request->priority == 'high') background: linear-gradient(135deg, rgba(245, 158, 11, 0.4), rgba(245, 158, 11, 0.3)); border: 1px solid rgba(245, 158, 11, 0.6); color: #f59e0b; box-shadow: 0 0 20px rgba(245, 158, 11, 0.4); text-shadow: 0 0 5px rgba(245, 158, 11, 0.5);
                              @elseif($request->priority == 'medium') background: linear-gradient(135deg, rgba(0, 102, 255, 0.4), rgba(124, 58, 237, 0.3)); border: 1px solid rgba(0, 102, 255, 0.6); color: #0066ff; box-shadow: 0 0 25px rgba(0, 102, 255, 0.5); text-shadow: 0 0 5px rgba(0, 102, 255, 0.5);
                              @else background: linear-gradient(135deg, rgba(34, 197, 94, 0.4), rgba(34, 197, 94, 0.3)); border: 1px solid rgba(34, 197, 94, 0.6); color: #22c55e; box-shadow: 0 0 20px rgba(34, 197, 94, 0.4); text-shadow: 0 0 5px rgba(34, 197, 94, 0.5); @endif transition: all 0.3s ease;">
                            {{ ucfirst($request->priority) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge px-3 py-2 rounded-pill" 
                              style="@if($request->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.4), rgba(245, 158, 11, 0.3)); border: 1px solid rgba(245, 158, 11, 0.6); color: #f59e0b; box-shadow: 0 0 20px rgba(245, 158, 11, 0.4); text-shadow: 0 0 5px rgba(245, 158, 11, 0.5);
                              @elseif($request->status == 'assigned') background: linear-gradient(135deg, rgba(0, 102, 255, 0.4), rgba(124, 58, 237, 0.3)); border: 1px solid rgba(0, 102, 255, 0.6); color: #0066ff; box-shadow: 0 0 25px rgba(0, 102, 255, 0.5); text-shadow: 0 0 5px rgba(0, 102, 255, 0.5);
                              @elseif($request->status == 'in_progress') background: linear-gradient(135deg, rgba(245, 158, 11, 0.4), rgba(245, 158, 11, 0.3)); border: 1px solid rgba(245, 158, 11, 0.6); color: #f59e0b; box-shadow: 0 0 20px rgba(245, 158, 11, 0.4); text-shadow: 0 0 5px rgba(245, 158, 11, 0.5);
                              @elseif($request->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.4), rgba(34, 197, 94, 0.3)); border: 1px solid rgba(34, 197, 94, 0.6); color: #22c55e; box-shadow: 0 0 20px rgba(34, 197, 94, 0.4); text-shadow: 0 0 5px rgba(34, 197, 94, 0.5);
                              @elseif($request->status == 'tenant_confirmed') background: linear-gradient(135deg, rgba(124, 58, 237, 0.4), rgba(124, 58, 237, 0.3)); border: 1px solid rgba(124, 58, 237, 0.6); color: #7c3aed; box-shadow: 0 0 20px rgba(124, 58, 237, 0.4); text-shadow: 0 0 5px rgba(124, 58, 237, 0.5);
                              @elseif($request->status == 'closed') background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; box-shadow: 0 0 10px rgba(148, 163, 184, 0.2); text-shadow: 0 0 3px rgba(148, 163, 184, 0.3);
                              @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.4), rgba(239, 68, 68, 0.3)); border: 1px solid rgba(239, 68, 68, 0.6); color: #ef4444; box-shadow: 0 0 20px rgba(239, 68, 68, 0.4); text-shadow: 0 0 5px rgba(239, 68, 68, 0.5); @endif transition: all 0.3s ease;">
                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                        </span>
                    </td>
                    <td style="color: var(--text-primary);">
                        {{ $request->assignedStaff->name ?? 'Unassigned' }}
                    </td>
                    <td style="color: var(--text-primary);">
                        {{ $request->request_date ? $request->request_date->format('M j, Y') : 'N/A' }}
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('tenant.maintenance.show', $request->request_id) }}" 
                               class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                               style="width: 36px; height: 36px; color: #0066ff; border: 2px solid rgba(0, 102, 255, 0.3); background: rgba(0, 102, 255, 0.1); transition: all 0.3s ease;" 
                               title="View Details"
                               onmouseover="this.style.background='rgba(0, 102, 255, 0.2)'; this.style.boxShadow='0 0 20px rgba(0, 102, 255, 0.5)'; this.style.transform='scale(1.15)'; this.style.borderColor='rgba(0, 102, 255, 0.6)';"
                               onmouseout="this.style.background='rgba(0, 102, 255, 0.1)'; this.style.boxShadow='none'; this.style.transform='scale(1)'; this.style.borderColor='rgba(0, 102, 255, 0.3)';">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($request->status == 'pending')
                                <a href="{{ route('tenant.maintenance.edit', $request->request_id) }}" 
                                   class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                                   style="width: 36px; height: 36px; color: #f59e0b; border: 2px solid rgba(245, 158, 11, 0.3); background: rgba(245, 158, 11, 0.1); transition: all 0.3s ease;" 
                                   title="Edit"
                                   onmouseover="this.style.background='rgba(245, 158, 11, 0.2)'; this.style.boxShadow='0 0 20px rgba(245, 158, 11, 0.5)'; this.style.transform='scale(1.15)'; this.style.borderColor='rgba(245, 158, 11, 0.6)';"
                                   onmouseout="this.style.background='rgba(245, 158, 11, 0.1)'; this.style.boxShadow='none'; this.style.transform='scale(1)'; this.style.borderColor='rgba(245, 158, 11, 0.3)';">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endif
                            @if($request->status == 'completed')
                                <form method="POST" action="{{ route('tenant.maintenance.confirm', $request->request_id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                                            style="width: 36px; height: 36px; color: #22c55e; border: 2px solid rgba(34, 197, 94, 0.3); background: rgba(34, 197, 94, 0.1); transition: all 0.3s ease;" 
                                            title="Confirm Completion" 
                                            onclick="return confirm('Confirm that the maintenance work is satisfactory?')"
                                            onmouseover="this.style.background='rgba(34, 197, 94, 0.2)'; this.style.boxShadow='0 0 20px rgba(34, 197, 94, 0.5)'; this.style.transform='scale(1.15)'; this.style.borderColor='rgba(34, 197, 94, 0.6)';"
                                            onmouseout="this.style.background='rgba(34, 197, 94, 0.1)'; this.style.boxShadow='none'; this.style.transform='scale(1)'; this.style.borderColor='rgba(34, 197, 94, 0.3)';">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.2)); border: 2px solid rgba(0, 102, 255, 0.4); box-shadow: 0 0 30px rgba(0, 102, 255, 0.4);">
                                <i class="fas fa-tools" style="font-size: 2rem; color: #0066ff; filter: drop-shadow(0 0 10px rgba(0, 102, 255, 0.5));"></i>
                            </div>
                            <p class="mb-2" style="color: var(--text-secondary);">No maintenance requests found.</p>
                            <a href="{{ route('tenant.maintenance.create') }}" class="btn btn-neon btn-sm">
                                <i class="fas fa-plus me-2"></i>Create the first request
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($maintenanceRequests->hasPages())
<div class="mt-4">
    {{ $maintenanceRequests->links() }}
</div>
@endif
@endsection
