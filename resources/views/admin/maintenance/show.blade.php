@extends('layouts.admin')

@section('title', 'Maintenance Request Details')
@section('page-title', 'Maintenance Request Details')

@section('content')
<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.maintenance.index') }}" class="btn btn-sm" style="color: var(--text-secondary);">
            <i class="fas fa-arrow-left me-2"></i>
            <span>Back to Maintenance Requests</span>
        </a>
    </div>
    
    <!-- Maintenance Request Information Card -->
    <div class="futuristic-card mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
        <div class="p-4 p-md-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div>
                    <h3 class="h4 fw-bold mb-1" style="color: var(--primary-neon);">Request #{{ str_pad($maintenance->request_id, 6, '0', STR_PAD_LEFT) }}</h3>
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
                </div>
            </div>
            <div class="border-top pt-4" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <div class="row g-3 g-md-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Issue Type</label>
                            <div style="color: var(--text-primary);">{{ $maintenance->issue_type ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Priority</label>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($maintenance->priority == 'urgent') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                  @elseif($maintenance->priority == 'high') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                  @elseif($maintenance->priority == 'medium') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                  @else background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e; @endif">
                                {{ ucfirst($maintenance->priority ?? 'N/A') }}
                            </span>
                        </div>
                    </div>
                    @if($maintenance->room)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Room</label>
                            <div style="color: var(--text-primary);">Room {{ $maintenance->room->room_number ?? 'N/A' }} - {{ $maintenance->room->room_type ?? 'N/A' }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Request Date</label>
                            <div style="color: var(--text-primary);">{{ $maintenance->request_date ? $maintenance->request_date->format('M j, Y') : 'N/A' }}</div>
                        </div>
                    </div>
                    @if($maintenance->assignedStaff)
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Assigned To</label>
                            <div class="d-flex align-items-center gap-3">
                                @if($maintenance->assignedStaff->profile_picture)
                                    <img src="{{ asset('storage/' . $maintenance->assignedStaff->profile_picture) }}" 
                                         alt="{{ $maintenance->assignedStaff->name }}"
                                         class="rounded-circle" 
                                         style="width: 50px; height: 50px; object-fit: cover; border: 2px solid rgba(0, 102, 255, 0.3);">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.3);">
                                        <i class="fas fa-user" style="color: #0066ff;"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold" style="color: var(--text-primary);">{{ $maintenance->assignedStaff->name }}</div>
                                    <div class="small" style="color: var(--text-secondary);">{{ $maintenance->assignedStaff->role ?? 'Staff' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($maintenance->description)
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Description</label>
                            <div style="color: var(--text-primary);">{{ $maintenance->description }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tenant Information -->
    @if($maintenance->tenant)
    <div class="futuristic-card mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: var(--primary-neon);">Tenant Information</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Details of the tenant who submitted this request.</p>
            <div class="border-top pt-4" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Name</label>
                            <div style="color: var(--text-primary);">{{ $maintenance->tenant->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Email</label>
                            <div style="color: var(--text-primary);">{{ $maintenance->tenant->email ?? 'N/A' }}</div>
                        </div>
                    </div>
                    @if($maintenance->tenant->contact_number)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Contact Number</label>
                            <div style="color: var(--text-primary);">{{ $maintenance->tenant->contact_number }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Room Information -->
    @if($maintenance->room)
    <div class="futuristic-card mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: var(--primary-neon);">Room Information</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Details of the room where the maintenance is needed.</p>
            <div class="border-top pt-4" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Room Number</label>
                            <div style="color: var(--text-primary);">{{ $maintenance->room->room_number ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Room Type</label>
                            <div style="color: var(--text-primary);">{{ $maintenance->room->room_type ?? 'N/A' }}</div>
                        </div>
                    </div>
                    @if($maintenance->room->status)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Room Status</label>
                            <span class="badge px-3 py-2 rounded-pill" 
                                  style="@if($maintenance->room->status == 'available') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                  @elseif($maintenance->room->status == 'booked') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                  @else background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b; @endif">
                                {{ ucfirst($maintenance->room->status) }}
                            </span>
                        </div>
                    </div>
                    @endif
                    @if($maintenance->room->description)
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="small fw-semibold text-uppercase mb-2 d-block" style="color: var(--text-secondary);">Description</label>
                            <div style="color: var(--text-primary);">{{ $maintenance->room->description }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Related Tasks -->
    @if($maintenance->tasks && $maintenance->tasks->count() > 0)
    <div class="futuristic-card mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: var(--primary-neon);">Related Tasks</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Tasks associated with this maintenance request.</p>
            <div class="border-top pt-4" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: rgba(0, 102, 255, 0.05);">
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
                                <td style="color: var(--text-primary);">{{ $task->task_type ?? 'N/A' }}</td>
                                <td style="color: var(--text-primary);">{{ Str::limit($task->description ?? 'N/A', 50) }}</td>
                                <td style="color: var(--text-primary);">{{ $task->assigned_date ? \Carbon\Carbon::parse($task->assigned_date)->format('M j, Y') : 'N/A' }}</td>
                                <td style="color: var(--text-primary);">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M j, Y') : 'N/A' }}</td>
                                <td>
                                    <span class="badge px-3 py-2 rounded-pill" 
                                          style="@if($task->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e;
                                          @elseif($task->status == 'in_progress') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;
                                          @elseif($task->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                          @else background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; @endif">
                                        {{ ucfirst($task->status ?? 'N/A') }}
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
                <textarea readonly class="form-control" rows="4" style="background: rgba(248, 250, 252, 0.5); border-color: rgba(0, 102, 255, 0.2); color: var(--text-primary);">{{ $maintenance->staff_report }}</textarea>
            </div>
        </div>
    </div>
    @endif

    <!-- Proof Photo Section -->
    @if($maintenance->staff_proof_photo)
    <div class="futuristic-card mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
        <div class="p-4 p-md-5">
            <h4 class="h5 fw-bold mb-3" style="color: var(--primary-neon);">Proof Photo</h4>
            <p class="small mb-4" style="color: var(--text-secondary);">Photo uploaded by staff as proof of completed work.</p>
            <div class="border-top pt-4" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                <div class="position-relative">
                    <div class="d-flex align-items-center justify-content-center p-4" style="background: rgba(248, 250, 252, 0.5); border-radius: 12px; min-height: 150px;">
                        <button onclick="openProofPhotoModal('{{ asset('storage/' . $maintenance->staff_proof_photo) }}')" class="btn btn-link p-0 border-0" style="text-decoration: none;">
                            <img src="{{ asset('storage/' . $maintenance->staff_proof_photo) }}" 
                                 alt="Work completed photo" 
                                 class="img-thumbnail" 
                                 style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 12px; border-color: rgba(0, 102, 255, 0.3); cursor: pointer; transition: opacity 0.3s;">
                        </button>
                    </div>
                    <p class="small text-center mt-3 mb-0" style="color: var(--text-secondary);">
                        <i class="fas fa-info-circle me-1"></i>Click to view full size
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Proof Photo Modal -->
<div class="modal fade" id="proofPhotoModal" tabindex="-1" aria-labelledby="proofPhotoModalLabel" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90%; position: fixed; right: 2rem; top: 50%; transform: translateY(-50%); margin: 0;">
        <div class="modal-content futuristic-card" style="border-color: rgba(0, 102, 255, 0.3); background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
            <div class="modal-header border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important; position: relative; z-index: 1000;">
                <h5 class="modal-title fw-bold" id="proofPhotoModalLabel" style="color: #0066ff;">Staff Proof Photo</h5>
                <button type="button" class="btn-close" onclick="closeProofPhotoModal()" aria-label="Close" style="z-index: 1001; position: relative;"></button>
            </div>
            <div class="modal-body p-4" style="position: relative; z-index: 1000;">
                <p class="small mb-3" style="color: var(--text-secondary);">Request #{{ str_pad($maintenance->request_id, 6, '0', STR_PAD_LEFT) }} - {{ $maintenance->issue_type }}</p>
                <div class="text-center">
                    <img id="proofPhotoModalImage" src="" alt="Staff Proof Photo" class="img-fluid rounded" style="max-width: 100%; max-height: 70vh; object-fit: contain;">
                </div>
            </div>
            <div class="modal-footer border-top" style="border-color: rgba(0, 102, 255, 0.2) !important; position: relative; z-index: 1000;">
                <button type="button" class="btn btn-secondary" onclick="closeProofPhotoModal()" style="z-index: 1001; position: relative;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Remove backdrop completely - no cover */
.modal-backdrop {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
}

.modal-backdrop.show {
    display: none !important;
}

#proofPhotoModal {
    z-index: 1055 !important;
    background: transparent !important;
}

#proofPhotoModal.show {
    z-index: 1055 !important;
    display: block !important;
    pointer-events: none !important;
    background: transparent !important;
}

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

#proofPhotoModal .modal-content {
    z-index: 1057 !important;
    position: relative;
    pointer-events: auto !important;
    background-color: #ffffff !important;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;
    border-radius: 20px;
}

/* Ensure all modal elements are clickable */
#proofPhotoModal button,
#proofPhotoModal .btn-close,
#proofPhotoModal img {
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
// Proof Photo Modal Functions
function openProofPhotoModal(imageSrc) {
    document.getElementById('proofPhotoModalImage').src = imageSrc;
    const modalElement = document.getElementById('proofPhotoModal');
    
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
        
        // Ensure modal is positioned correctly
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
    const modalElement = document.getElementById('proofPhotoModal');
    const modal = bootstrap.Modal.getInstance(modalElement);
    if (modal) {
        modal.hide();
    }
    
    // Clean up backdrop
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(backdrop => {
        backdrop.style.display = 'none';
        backdrop.remove();
    });
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeProofPhotoModal();
    }
});

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modalElement = document.getElementById('proofPhotoModal');
    if (modalElement && modalElement.classList.contains('show')) {
        const modalDialog = modalElement.querySelector('.modal-dialog');
        const modalContent = modalElement.querySelector('.modal-content');
        if (modalDialog && modalContent && !modalContent.contains(event.target)) {
            closeProofPhotoModal();
        }
    }
});

// Clean up when modal is hidden
document.addEventListener('hidden.bs.modal', function(event) {
    if (event.target.id === 'proofPhotoModal') {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.style.display = 'none';
            backdrop.remove();
        });
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
});

// Prevent backdrop from being created
document.addEventListener('DOMContentLoaded', function() {
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
