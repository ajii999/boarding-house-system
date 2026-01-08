@extends('layouts.staff')

@section('title', 'My Tasks')
@section('page-title', 'My Tasks')

@section('content')
<div class="mb-4">
    <!-- Tasks Header -->
    <div class="futuristic-card">
        <div class="p-3 p-md-4">
            <h3 class="h5 fw-semibold mb-1" style="color: var(--text-primary);">Assigned Tasks</h3>
            <p class="small text-muted mb-0">Your assigned maintenance tasks and their current status.</p>
        </div>
    </div>
</div>

<!-- Tasks List -->
<div class="futuristic-card">
    @if($tasks->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.05));">
                        <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Request #</th>
                        <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Issue Details</th>
                        <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Status</th>
                        <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Priority</th>
                        <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Assigned Date</th>
                        <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $request)
                    <tr>
                        <td class="align-middle" style="padding: 1rem;">
                            <div class="fw-semibold" style="color: var(--text-primary);">
                                Request #{{ $request->request_id }}
                            </div>
                            @if($request->description)
                            <div class="small text-muted mt-1">
                                {{ Str::limit($request->description, 100) }}
                            </div>
                            @endif
                        </td>
                        <td class="align-middle" style="padding: 1rem;">
                            <div style="color: var(--text-primary);">
                                {{ $request->issue_type }}
                            </div>
                            <div class="small text-muted">
                                Room: {{ $request->room->room_number ?? 'N/A' }}
                            </div>
                            <div class="small text-muted">
                                Tenant: {{ $request->tenant->name ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="align-middle" style="padding: 1rem;">
                            <span class="badge rounded-pill px-3 py-2
                                @if($request->status === 'pending') bg-warning
                                @elseif($request->status === 'assigned') bg-info
                                @elseif($request->status === 'in_progress') bg-primary
                                @elseif($request->status === 'completed') bg-success
                                @elseif($request->status === 'tenant_confirmed') bg-success
                                @elseif($request->status === 'closed') bg-secondary
                                @else bg-secondary
                                @endif" style="font-size: 0.7rem;">
                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                            </span>
                        </td>
                        <td class="align-middle" style="padding: 1rem;">
                            <span class="badge rounded-pill px-3 py-2
                                @if($request->priority === 'urgent') bg-danger
                                @elseif($request->priority === 'high') bg-warning
                                @elseif($request->priority === 'medium') bg-info
                                @else bg-success
                                @endif" style="font-size: 0.7rem;">
                                {{ ucfirst($request->priority) }}
                            </span>
                        </td>
                        <td class="align-middle" style="padding: 1rem; color: var(--text-primary);">
                            {{ $request->assigned_at ? $request->assigned_at->format('M j, Y') : ($request->request_date ? $request->request_date->format('M j, Y') : 'N/A') }}
                        </td>
                        <td class="align-middle" style="padding: 1rem;">
                            <div class="d-flex gap-2">
                                <a href="{{ route('staff.maintenance.show', $request->request_id) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(in_array($request->status, ['assigned', 'pending']))
                                <button onclick="openTaskModal({{ $request->request_id }})" 
                                        class="btn btn-sm btn-neon">
                                    Update Status
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3 p-md-4 border-top" style="border-color: rgba(0, 102, 255, 0.1) !important;">
            {{ $tasks->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="d-flex flex-column align-items-center">
                <i class="fas fa-tasks text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                <h3 class="h5 fw-semibold mb-2" style="color: var(--text-primary);">No Tasks Assigned</h3>
                <p class="text-muted mb-0">You don't have any tasks assigned at the moment.</p>
            </div>
        </div>
    @endif
</div>

<!-- Task Update Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content futuristic-card" style="border-radius: 20px; border: none;">
            <div class="modal-header border-bottom" style="border-color: rgba(0, 102, 255, 0.1) !important;">
                <h5 class="modal-title fw-semibold" id="taskModalLabel" style="color: var(--text-primary);">Update Task Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="taskUpdateForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold" style="color: var(--text-primary);">Status</label>
                        <select name="status" id="status" 
                                class="form-select" 
                                style="border-radius: 12px; border: 1px solid rgba(0, 102, 255, 0.2);" 
                                required>
                            <option value="assigned">Assigned</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold" style="color: var(--text-primary);">Notes</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="form-control" 
                                  style="border-radius: 12px; border: 1px solid rgba(0, 102, 255, 0.2);" 
                                  placeholder="Add any notes about the task..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer border-top" style="border-color: rgba(0, 102, 255, 0.1) !important;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 12px;">Cancel</button>
                    <button type="submit" class="btn btn-neon">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openTaskModal(requestId) {
    const form = document.getElementById('taskUpdateForm');
    form.action = `/staff/tasks/${requestId}`;
    const modal = new bootstrap.Modal(document.getElementById('taskModal'));
    modal.show();
}
</script>
@endsection
