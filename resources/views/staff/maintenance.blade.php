@extends('layouts.staff')

@section('title', 'My Maintenance Requests')
@section('page-title', 'My Maintenance Requests')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
    <div>
        <h3 class="h5 fw-semibold mb-1" style="color: var(--text-primary);">Assigned Maintenance Requests</h3>
        <p class="small text-muted mb-0">Manage your assigned maintenance requests</p>
    </div>
</div>

<div class="futuristic-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.05));">
                    <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Request #</th>
                    <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Tenant</th>
                    <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Issue Type</th>
                    <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Room</th>
                    <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Priority</th>
                    <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Status</th>
                    <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Assigned Date</th>
                    <th class="text-uppercase small fw-semibold" style="color: var(--text-primary); padding: 1rem;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($maintenanceRequests as $request)
                <tr>
                    <td class="align-middle" style="padding: 1rem;">
                        <span class="fw-semibold" style="color: var(--text-primary);">#{{ $request->request_id }}</span>
                    </td>
                    <td class="align-middle" style="padding: 1rem;">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 me-3" 
                                 style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(79, 70, 229, 0.2)); border-radius: 50%;">
                                <i class="fas fa-user" style="color: #6366f1;"></i>
                            </div>
                            <div>
                                <div class="fw-medium" style="color: var(--text-primary);">{{ $request->tenant->name ?? 'N/A' }}</div>
                                <div class="small text-muted">{{ $request->tenant->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle" style="padding: 1rem; color: var(--text-primary);">
                        {{ $request->issue_type }}
                    </td>
                    <td class="align-middle" style="padding: 1rem; color: var(--text-primary);">
                        {{ $request->room->room_number ?? 'N/A' }}
                    </td>
                    <td class="align-middle" style="padding: 1rem;">
                        <span class="badge rounded-pill px-3 py-2
                            @if($request->priority == 'urgent') bg-danger
                            @elseif($request->priority == 'high') bg-warning
                            @elseif($request->priority == 'medium') bg-info
                            @else bg-success
                            @endif" style="font-size: 0.7rem;">
                            {{ ucfirst($request->priority) }}
                        </span>
                    </td>
                    <td class="align-middle" style="padding: 1rem;">
                        <span class="badge rounded-pill px-3 py-2
                            @if($request->status == 'assigned') bg-primary
                            @elseif($request->status == 'in_progress') bg-warning
                            @elseif($request->status == 'completed') bg-success
                            @else bg-secondary
                            @endif" style="font-size: 0.7rem;">
                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                        </span>
                    </td>
                    <td class="align-middle" style="padding: 1rem; color: var(--text-primary);">
                        {{ $request->assigned_at ? $request->assigned_at->format('M j, Y') : 'N/A' }}
                    </td>
                    <td class="align-middle" style="padding: 1rem;">
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('staff.maintenance.show', $request) }}" 
                               class="btn btn-sm btn-outline-primary" 
                               title="View Details"
                               style="border-radius: 8px;">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($request->status == 'assigned')
                                <form method="POST" action="{{ route('staff.maintenance.start', $request) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Start Work" style="border-radius: 8px;">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </form>
                            @endif
                            @if($request->status == 'in_progress')
                                <button onclick="openCompleteModal({{ $request->request_id }})" 
                                        class="btn btn-sm btn-outline-success" 
                                        title="Mark Complete"
                                        style="border-radius: 8px;">
                                    <i class="fas fa-check"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-wrench text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                            <p class="text-muted mb-0">No maintenance requests assigned to you.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Complete Modal -->
<div class="modal fade" id="completeModal" tabindex="-1" aria-labelledby="completeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content futuristic-card" style="border-radius: 20px; border: none;">
            <div class="modal-header border-bottom" style="border-color: rgba(0, 102, 255, 0.1) !important;">
                <h5 class="modal-title fw-semibold" id="completeModalLabel" style="color: var(--text-primary);">Complete Maintenance Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="completeForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="staff_report" class="form-label fw-semibold" style="color: var(--text-primary);">Work Report</label>
                        <textarea name="staff_report" id="staff_report" rows="4" required 
                                  class="form-control" 
                                  style="border-radius: 12px; border: 1px solid rgba(0, 102, 255, 0.2);"
                                  placeholder="Describe what was done to fix the issue..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="staff_proof_photo" class="form-label fw-semibold" style="color: var(--text-primary);">Proof Photo (Optional)</label>
                        <input type="file" name="staff_proof_photo" id="staff_proof_photo" accept="image/*" 
                               class="form-control" 
                               style="border-radius: 12px; border: 1px solid rgba(0, 102, 255, 0.2);">
                        <p class="small text-muted mt-2">Upload a photo showing the completed work (max 2MB, JPG/PNG/GIF)</p>
                    </div>
                </div>
                <div class="modal-footer border-top" style="border-color: rgba(0, 102, 255, 0.1) !important;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 12px;">Cancel</button>
                    <button type="submit" class="btn btn-neon">Mark Complete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCompleteModal(requestId) {
    document.getElementById('completeForm').action = `/staff/maintenance/${requestId}/complete`;
    const modal = new bootstrap.Modal(document.getElementById('completeModal'));
    modal.show();
}
</script>
@endsection
