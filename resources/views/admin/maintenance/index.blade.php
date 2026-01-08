@extends('layouts.admin')

@section('title', 'Maintenance Management')
@section('page-title', 'Maintenance Management')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(14, 165, 233, 0.3); background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(56, 189, 248, 0.08), rgba(125, 211, 252, 0.06)); box-shadow: 0 4px 25px rgba(14, 165, 233, 0.12); border-radius: 12px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
    <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #0ea5e9; text-shadow: 0 2px 4px rgba(14, 165, 233, 0.1);">Maintenance Management</h1>
            <p class="mb-0 small" style="color: rgba(14, 165, 233, 0.75); font-weight: 500;">Manage and track maintenance requests</p>
    </div>
        <div class="d-flex flex-column flex-sm-row gap-2 align-items-stretch">
            <form method="GET" action="{{ route('admin.maintenance.index') }}" class="d-flex gap-2 flex-grow-1 flex-sm-grow-0">
                <div class="position-relative" style="min-width: 300px;">
                <input type="text" name="search" value="{{ $search ?? '' }}" 
                       placeholder="Search requests..." 
                           class="form-control" style="width: 100%; min-width: 300px; padding: 0.65rem 0.75rem 0.65rem 2.75rem; border: 2px solid rgba(14, 165, 233, 0.3); background: rgba(255, 255, 255, 0.95); border-radius: 8px; font-size: 0.95rem; height: 42px;">
                    <div class="position-absolute top-50 start-0 translate-middle-y ms-3 d-flex align-items-center justify-content-center" style="color: rgba(14, 165, 233, 0.7); line-height: 1; font-size: 1rem;">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <button type="submit" class="btn d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; color: white; box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3); border-radius: 8px; padding: 0.65rem 1rem; height: 42px; min-width: 42px; font-weight: 500;">
                <i class="fas fa-search"></i>
            </button>
            @if(isset($search) && $search)
                    <a href="{{ route('admin.maintenance.index') }}" class="btn d-flex align-items-center justify-content-center" style="background: rgba(14, 165, 233, 0.1); border: 2px solid rgba(14, 165, 233, 0.3); color: #0ea5e9; border-radius: 8px; padding: 0.65rem 1rem; height: 42px; min-width: 42px;">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
            <a href="{{ route('admin.maintenance.create') }}" class="btn d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; color: white; box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3); border-radius: 8px; padding: 0.65rem 1.25rem; height: 42px; font-weight: 500; white-space: nowrap;">
                <i class="fas fa-plus me-2"></i>Create New Request
        </a>
        </div>
    </div>
</div>

<!-- Maintenance Requests Table -->
<div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(59, 130, 246, 0.08)); border-bottom: 2px solid rgba(0, 102, 255, 0.2);">
                <tr>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle;">Request #</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle;">Tenant</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle;">Issue Type</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle;">Room</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle;">Priority</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle;">Status</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle;">Assigned To</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0066ff; vertical-align: middle;">Date</th>
                    <th class="text-uppercase small fw-bold py-3 text-center" style="color: #0066ff; vertical-align: middle;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($maintenanceRequests as $request)
                <tr>
                    <td class="fw-semibold py-3" style="color: var(--text-primary); vertical-align: middle;">
                        #{{ $request->request_id }}
                    </td>
                    <td class="py-3" style="vertical-align: middle;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                 style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.3);">
                                <i class="fas fa-user" style="color: #0066ff; font-size: 0.85rem;"></i>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div class="fw-semibold text-truncate" style="color: var(--text-primary); font-size: 0.9rem;">{{ $request->tenant->name ?? 'N/A' }}</div>
                                <div class="small text-truncate" style="color: var(--text-secondary); font-size: 0.75rem;">{{ $request->tenant->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3" style="color: var(--text-primary); font-weight: 500; vertical-align: middle;">
                        {{ $request->issue_type }}
                    </td>
                    <td class="py-3" style="color: var(--text-primary); font-weight: 600; vertical-align: middle;">
                        {{ $request->room->room_number ?? 'N/A' }}
                    </td>
                    <td class="py-3" style="vertical-align: middle;">
                        <span class="badge px-3 py-2 rounded-pill" 
                              style="@if($request->priority == 'urgent') background: linear-gradient(135deg, rgba(239, 68, 68, 0.25), rgba(239, 68, 68, 0.15)); border: 1px solid rgba(239, 68, 68, 0.4); color: #ef4444; font-weight: 600;
                              @elseif($request->priority == 'high') background: linear-gradient(135deg, rgba(245, 158, 11, 0.25), rgba(245, 158, 11, 0.15)); border: 1px solid rgba(245, 158, 11, 0.4); color: #f59e0b; font-weight: 600;
                              @elseif($request->priority == 'medium') background: linear-gradient(135deg, rgba(0, 102, 255, 0.25), rgba(0, 102, 255, 0.15)); border: 1px solid rgba(0, 102, 255, 0.4); color: #0066ff; font-weight: 600;
                              @else background: linear-gradient(135deg, rgba(34, 197, 94, 0.25), rgba(34, 197, 94, 0.15)); border: 1px solid rgba(34, 197, 94, 0.4); color: #22c55e; font-weight: 600; @endif">
                            {{ ucfirst($request->priority) }}
                        </span>
                    </td>
                    <td class="py-3" style="vertical-align: middle;">
                        <span class="badge px-3 py-2 rounded-pill" 
                              style="@if($request->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.25), rgba(245, 158, 11, 0.15)); border: 1px solid rgba(245, 158, 11, 0.4); color: #f59e0b; font-weight: 600;
                              @elseif($request->status == 'assigned') background: linear-gradient(135deg, rgba(0, 102, 255, 0.25), rgba(0, 102, 255, 0.15)); border: 1px solid rgba(0, 102, 255, 0.4); color: #0066ff; font-weight: 600;
                              @elseif($request->status == 'in_progress') background: linear-gradient(135deg, rgba(245, 158, 11, 0.25), rgba(245, 158, 11, 0.15)); border: 1px solid rgba(245, 158, 11, 0.4); color: #f59e0b; font-weight: 600;
                              @elseif($request->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.25), rgba(34, 197, 94, 0.15)); border: 1px solid rgba(34, 197, 94, 0.4); color: #22c55e; font-weight: 600;
                              @elseif($request->status == 'tenant_confirmed') background: linear-gradient(135deg, rgba(124, 58, 237, 0.25), rgba(124, 58, 237, 0.15)); border: 1px solid rgba(124, 58, 237, 0.4); color: #7c3aed; font-weight: 600;
                              @elseif($request->status == 'closed') background: linear-gradient(135deg, rgba(148, 163, 184, 0.25), rgba(148, 163, 184, 0.15)); border: 1px solid rgba(148, 163, 184, 0.4); color: #94a3b8; font-weight: 600;
                              @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.25), rgba(239, 68, 68, 0.15)); border: 1px solid rgba(239, 68, 68, 0.4); color: #ef4444; font-weight: 600; @endif">
                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                        </span>
                    </td>
                    <td class="py-3" style="color: var(--text-primary); font-weight: 500; vertical-align: middle;">
                        {{ $request->assignedStaff->name ?? 'Unassigned' }}
                    </td>
                    <td class="py-3" style="color: var(--text-primary); font-weight: 500; vertical-align: middle;">
                        {{ $request->request_date ? $request->request_date->format('M j, Y') : 'N/A' }}
                    </td>
                    <td class="py-3 text-center" style="vertical-align: middle;">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <a href="{{ route('admin.maintenance.show', $request->request_id) }}" class="btn btn-sm d-flex align-items-center justify-content-center" style="color: #0066ff; width: 32px; height: 32px; padding: 0; border: none; background: transparent; text-decoration: none;" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($request->status == 'pending')
                                <button onclick="openAssignModal({{ $request->request_id }})" class="btn btn-sm d-flex align-items-center justify-content-center" style="color: #0066ff; width: 32px; height: 32px; padding: 0; border: none; background: transparent;" title="Assign to Staff">
                                    <i class="fas fa-user-plus"></i>
                                </button>
                            @endif
                            @if($request->status == 'tenant_confirmed')
                                <form method="POST" action="{{ route('admin.maintenance.close', $request->request_id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center" style="color: #22c55e; width: 32px; height: 32px; padding: 0; border: none; background: transparent;" title="Close Request">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.maintenance.edit', $request->request_id) }}" class="btn btn-sm d-flex align-items-center justify-content-center" style="color: #f59e0b; width: 32px; height: 32px; padding: 0; border: none; background: transparent; text-decoration: none;" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.maintenance.destroy', $request->request_id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this maintenance request?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center" style="color: #ef4444; width: 32px; height: 32px; padding: 0; border: none; background: transparent;" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px; background: rgba(245, 158, 11, 0.1); border: 2px solid rgba(245, 158, 11, 0.3);">
                                <i class="fas fa-tools" style="font-size: 2rem; color: #f59e0b;"></i>
                            </div>
                            <p class="mb-2" style="color: var(--text-secondary);">No maintenance requests found.</p>
                            <a href="{{ route('admin.maintenance.create') }}" class="btn btn-neon btn-sm">
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

<!-- Assignment Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content futuristic-card" style="border-color: rgba(0, 102, 255, 0.3);">
            <div class="modal-header border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <h5 class="modal-title fw-bold" id="assignModalLabel" style="color: #0066ff;">Assign Maintenance Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="assigned_staff_id" class="form-label fw-semibold" style="color: var(--text-primary);">Select Staff Member</label>
                        <select name="assigned_staff_id" id="assigned_staff_id" required class="form-select">
                            <option value="">Select staff member</option>
                            @foreach(\App\Models\Staff::whereIn('name', ['Jeramae', 'Johara'])->get() as $staff)
                                <option value="{{ $staff->staff_id }}">{{ $staff->name }} - {{ $staff->role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="assignment_notes" class="form-label fw-semibold" style="color: var(--text-primary);">Assignment Notes (Optional)</label>
                        <textarea name="assignment_notes" id="assignment_notes" rows="3" class="form-control" placeholder="Add any specific instructions..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-neon">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Ensure table stays straight - no hover effects or transformations */
.table tbody tr {
    transform: none !important;
    transition: none !important;
}

.table tbody tr:hover {
    background-color: transparent !important;
    transform: none !important;
}

.table td,
.table th {
    vertical-align: middle !important;
    border: none !important;
}

.table tbody tr td {
    border-bottom: 1px solid rgba(0, 102, 255, 0.1) !important;
}

/* Remove backdrop completely - no cover */
.modal-backdrop {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
}

.modal-backdrop.show {
    display: none !important;
}

#assignModal {
    z-index: 1055 !important;
}

#assignModal.show {
    z-index: 1055 !important;
    display: block !important;
    pointer-events: none !important;
}

#assignModal .modal-dialog {
    z-index: 1056 !important;
    position: relative;
    pointer-events: auto !important;
    margin: 1.75rem auto;
}

#assignModal .modal-content {
    z-index: 1057 !important;
    position: relative;
    pointer-events: auto !important;
    background-color: #ffffff !important;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;
}

/* Ensure all form elements are clickable */
#assignModal select,
#assignModal textarea,
#assignModal input,
#assignModal button,
#assignModal label,
#assignModal .modal-header,
#assignModal .modal-body,
#assignModal .modal-footer {
    pointer-events: auto !important;
    position: relative;
    z-index: 1058 !important;
}

/* Ensure mobile overlay doesn't interfere */
#mobile-overlay {
    z-index: 1035 !important;
}

/* Ensure sidebar doesn't interfere */
.admin-sidebar {
    z-index: 1040 !important;
}
</style>

<script>
function openAssignModal(requestId) {
    // Hide mobile overlay if it's showing
    const mobileOverlay = document.getElementById('mobile-overlay');
    if (mobileOverlay) {
        mobileOverlay.style.display = 'none';
        mobileOverlay.style.zIndex = '1035';
    }
    
    // Set form action
    document.getElementById('assignForm').action = `/admin/maintenance/${requestId}/assign`;
    
    // Reset form fields
    document.getElementById('assigned_staff_id').value = '';
    document.getElementById('assignment_notes').value = '';
    
    // Show modal
    const modalElement = document.getElementById('assignModal');
    
    // Remove any existing modal instances
    const existingModal = bootstrap.Modal.getInstance(modalElement);
    if (existingModal) {
        existingModal.dispose();
    }
    
    const modal = new bootstrap.Modal(modalElement, {
        backdrop: false,
        keyboard: true,
        focus: true
    });
    
    modal.show();
    
    // After modal is shown, ensure proper z-index and clickability
    modalElement.addEventListener('shown.bs.modal', function() {
        // Remove any backdrop that might have been created
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.style.display = 'none';
            backdrop.remove();
        });
        
        // Ensure modal container allows clicks through to dialog
        modalElement.style.zIndex = '1055';
        modalElement.style.display = 'block';
        modalElement.style.pointerEvents = 'none'; // Allow clicks to pass through to dialog
        
        const modalDialog = modalElement.querySelector('.modal-dialog');
        if (modalDialog) {
            modalDialog.style.zIndex = '1056';
            modalDialog.style.pointerEvents = 'auto'; // Dialog captures clicks
            modalDialog.style.position = 'relative';
        }
        
        const modalContent = modalElement.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.zIndex = '1057';
            modalContent.style.pointerEvents = 'auto';
            modalContent.style.position = 'relative';
            modalContent.style.backgroundColor = '#ffffff';
        }
        
        // Ensure all form elements are clickable
        const select = document.getElementById('assigned_staff_id');
        const textarea = document.getElementById('assignment_notes');
        const buttons = modalElement.querySelectorAll('button');
        const labels = modalElement.querySelectorAll('label');
        
        if (select) {
            select.style.pointerEvents = 'auto';
            select.style.zIndex = '1058';
        }
        if (textarea) {
            textarea.style.pointerEvents = 'auto';
            textarea.style.zIndex = '1058';
        }
        buttons.forEach(btn => {
            btn.style.pointerEvents = 'auto';
            btn.style.zIndex = '1058';
        });
        labels.forEach(label => {
            label.style.pointerEvents = 'auto';
            label.style.zIndex = '1058';
        });
        
        // Hide mobile overlay
        if (mobileOverlay) {
            mobileOverlay.style.display = 'none';
        }
    }, { once: true });
}

// Clean up when modal is hidden
document.addEventListener('hidden.bs.modal', function(event) {
    if (event.target.id === 'assignModal') {
        // Remove any lingering backdrop
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.style.display = 'none';
            backdrop.remove();
        });
        
        // Remove modal-open class and restore body styles
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
});

// Prevent backdrop from being created
document.addEventListener('DOMContentLoaded', function() {
    // Watch for any backdrop creation and remove it immediately
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1 && node.classList && node.classList.contains('modal-backdrop')) {
                    node.style.display = 'none';
                    node.remove();
                }
            });
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
</script>
@endsection
