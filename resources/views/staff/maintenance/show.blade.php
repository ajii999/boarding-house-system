@extends('layouts.staff')

@section('title', 'Maintenance Request Details')
@section('page-title', 'Maintenance Request Details')

@section('content')
<div class="row g-3 g-md-4">
    <!-- Request Header -->
    <div class="col-12">
        <div class="futuristic-card">
            <div class="p-3 p-md-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.1) !important;">
                <h3 class="h5 fw-semibold mb-1" style="color: var(--text-primary);">
                    Maintenance Request #{{ $maintenance->request_id }}
                </h3>
                <p class="small text-muted mb-0">
                    {{ $maintenance->issue_type }} - {{ $maintenance->request_date->format('M j, Y') }}
                </p>
            </div>
            <div class="p-0">
                <dl class="mb-0">
                    <div class="p-3 p-md-4" style="background: rgba(248, 250, 252, 0.5);">
                        <div class="row g-2">
                            <dt class="col-12 col-sm-4 fw-semibold small" style="color: var(--text-secondary);">Status</dt>
                            <dd class="col-12 col-sm-8 mb-0">
                                <span class="badge rounded-pill px-3 py-2
                                    @if($maintenance->status == 'assigned') bg-primary
                                    @elseif($maintenance->status == 'in_progress') bg-warning
                                    @elseif($maintenance->status == 'completed') bg-success
                                    @else bg-secondary
                                    @endif" style="font-size: 0.75rem;">
                                    {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
                                </span>
                            </dd>
                        </div>
                    </div>
                    <div class="p-3 p-md-4">
                        <div class="row g-2">
                            <dt class="col-12 col-sm-4 fw-semibold small" style="color: var(--text-secondary);">Priority</dt>
                            <dd class="col-12 col-sm-8 mb-0">
                                <span class="badge rounded-pill px-3 py-2
                                    @if($maintenance->priority == 'urgent') bg-danger
                                    @elseif($maintenance->priority == 'high') bg-warning
                                    @elseif($maintenance->priority == 'medium') bg-info
                                    @else bg-success
                                    @endif" style="font-size: 0.75rem;">
                                    {{ ucfirst($maintenance->priority) }}
                                </span>
                            </dd>
                        </div>
                    </div>
                    <div class="p-3 p-md-4" style="background: rgba(248, 250, 252, 0.5);">
                        <div class="row g-2">
                            <dt class="col-12 col-sm-4 fw-semibold small" style="color: var(--text-secondary);">Tenant</dt>
                            <dd class="col-12 col-sm-8 mb-0" style="color: var(--text-primary);">
                                {{ $maintenance->tenant->name }} ({{ $maintenance->tenant->email }})
                            </dd>
                        </div>
                    </div>
                    <div class="p-3 p-md-4">
                        <div class="row g-2">
                            <dt class="col-12 col-sm-4 fw-semibold small" style="color: var(--text-secondary);">Room</dt>
                            <dd class="col-12 col-sm-8 mb-0" style="color: var(--text-primary);">
                                {{ $maintenance->room->room_number ?? 'N/A' }} - {{ $maintenance->room->room_type ?? 'N/A' }}
                            </dd>
                        </div>
                    </div>
                    <div class="p-3 p-md-4" style="background: rgba(248, 250, 252, 0.5);">
                        <div class="row g-2">
                            <dt class="col-12 col-sm-4 fw-semibold small" style="color: var(--text-secondary);">Description</dt>
                            <dd class="col-12 col-sm-8 mb-0" style="color: var(--text-primary);">
                                {{ $maintenance->description }}
                            </dd>
                        </div>
                    </div>
                    @if($maintenance->assignment_notes)
                    <div class="p-3 p-md-4">
                        <div class="row g-2">
                            <dt class="col-12 col-sm-4 fw-semibold small" style="color: var(--text-secondary);">Assignment Notes</dt>
                            <dd class="col-12 col-sm-8 mb-0" style="color: var(--text-primary);">
                                {{ $maintenance->assignment_notes }}
                            </dd>
                        </div>
                    </div>
                    @endif
                    @if($maintenance->tenant_photo)
                    <div class="p-3 p-md-4" style="background: rgba(248, 250, 252, 0.5);">
                        <div class="row g-2">
                            <dt class="col-12 col-sm-4 fw-semibold small" style="color: var(--text-secondary);">Tenant Photo</dt>
                            <dd class="col-12 col-sm-8 mb-0">
                                <button onclick="openTenantPhotoModal('{{ asset('storage/' . $maintenance->tenant_photo) }}')" 
                                        class="btn p-0 border-0" 
                                        style="background: transparent;">
                                    <img src="{{ asset('storage/' . $maintenance->tenant_photo) }}" 
                                         alt="Issue photo" 
                                         class="rounded-3 shadow-sm" 
                                         style="width: 128px; height: 128px; object-fit: cover; cursor: pointer; transition: transform 0.3s ease;"
                                         onmouseover="this.style.transform='scale(1.05)'"
                                         onmouseout="this.style.transform='scale(1)'">
                                </button>
                                <p class="small text-muted mt-2 mb-0">
                                    <i class="fas fa-info-circle me-1"></i>Click to view full size
                                </p>
                            </dd>
                        </div>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <!-- Staff Actions -->
    <div class="col-12">
        <div class="futuristic-card">
            <div class="p-3 p-md-4">
                <h3 class="h5 fw-semibold mb-3" style="color: var(--text-primary);">Staff Actions</h3>
                
                @if($maintenance->status == 'assigned')
                    <form method="POST" action="{{ route('staff.maintenance.start', $maintenance) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-neon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                            <i class="fas fa-play me-2"></i>Start Work
                        </button>
                    </form>
                @elseif($maintenance->status == 'in_progress')
                    <button onclick="openCompleteModal()" class="btn btn-neon" style="background: linear-gradient(135deg, #22c55e, #16a34a);">
                        <i class="fas fa-check me-2"></i>Mark Complete
                    </button>
                @elseif($maintenance->status == 'completed')
                    <div class="alert alert-success d-flex align-items-start" style="border-radius: 12px; border: 1px solid rgba(34, 197, 94, 0.3);">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-check-circle" style="color: #22c55e; font-size: 1.5rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="alert-heading fw-semibold mb-2" style="color: #15803d;">Work Completed</h4>
                            <p class="mb-2" style="color: #166534;">You have completed this maintenance request. Waiting for tenant confirmation.</p>
                            @if($maintenance->staff_report)
                                <p class="mb-0"><strong>Your Report:</strong> {{ $maintenance->staff_report }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Work Report (if completed) -->
    @if($maintenance->status == 'completed' && $maintenance->staff_report)
    <div class="col-12">
        <div class="futuristic-card">
            <div class="p-3 p-md-4">
                <h3 class="h5 fw-semibold mb-3" style="color: var(--text-primary);">Work Report</h3>
                <div class="p-3 rounded-3" style="background: rgba(248, 250, 252, 0.8);">
                    <p class="small mb-0" style="color: var(--text-primary);">{{ $maintenance->staff_report }}</p>
                </div>
                @if($maintenance->staff_proof_photo)
                    <div class="mt-3">
                        <h4 class="small fw-semibold mb-2" style="color: var(--text-primary);">Proof Photo</h4>
                        <button onclick="openProofPhotoModal('{{ asset('storage/' . $maintenance->staff_proof_photo) }}')" 
                                class="btn p-0 border-0" 
                                style="background: transparent;">
                            <img src="{{ asset('storage/' . $maintenance->staff_proof_photo) }}" 
                                 alt="Work completed photo" 
                                 class="rounded-3 shadow-sm" 
                                 style="width: 192px; height: 192px; object-fit: cover; cursor: pointer; transition: transform 0.3s ease;"
                                 onmouseover="this.style.transform='scale(1.05)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </button>
                        <p class="small text-muted mt-2 mb-0">
                            <i class="fas fa-info-circle me-1"></i>Click to view full size
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Back Button -->
    <div class="col-12">
        <div class="d-flex justify-content-end">
            <a href="{{ route('staff.maintenance') }}" class="btn btn-secondary" style="border-radius: 12px;">
                <i class="fas fa-arrow-left me-2"></i>Back to Maintenance Requests
            </a>
        </div>
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
            <form method="POST" action="{{ route('staff.maintenance.complete', $maintenance) }}" enctype="multipart/form-data">
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
                    <button type="submit" class="btn btn-neon" style="background: linear-gradient(135deg, #22c55e, #16a34a);">Mark Complete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tenant Photo Modal -->
<div class="modal fade" id="tenantPhotoModal" tabindex="-1" aria-labelledby="tenantPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content futuristic-card" style="border-radius: 20px; border: none;">
            <div class="modal-header border-bottom" style="border-color: rgba(0, 102, 255, 0.1) !important;">
                <h5 class="modal-title fw-semibold" id="tenantPhotoModalLabel" style="color: var(--text-primary);">Tenant Uploaded Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <img id="tenantPhotoModalImage" src="" alt="Tenant Photo" class="img-fluid rounded-3 shadow-lg">
            </div>
            <div class="modal-footer border-top" style="border-color: rgba(0, 102, 255, 0.1) !important;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 12px;">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Proof Photo Modal -->
<div class="modal fade" id="proofPhotoModal" tabindex="-1" aria-labelledby="proofPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90%;">
        <div class="modal-content futuristic-card" style="border-radius: 20px; border: none; background: transparent;">
            <div class="modal-header border-bottom" style="border-color: rgba(0, 102, 255, 0.1) !important; background: white;">
                <h5 class="modal-title fw-semibold" id="proofPhotoModalLabel" style="color: var(--text-primary);">Proof Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1000; position: relative;"></button>
            </div>
            <div class="modal-body p-4 text-center" style="background: white; position: relative; z-index: 1000;">
                <img id="proofPhotoModalImage" src="" alt="Proof Photo" class="img-fluid rounded-3 shadow-lg" style="max-width: 100%; max-height: 70vh; object-fit: contain;">
            </div>
            <div class="modal-footer border-top" style="border-color: rgba(0, 102, 255, 0.1) !important; background: white;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 12px; z-index: 1000; position: relative;">
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

#proofPhotoModal,
#tenantPhotoModal {
    z-index: 1055 !important;
}

#proofPhotoModal.show,
#tenantPhotoModal.show {
    z-index: 1055 !important;
    display: block !important;
    pointer-events: none !important;
}

#proofPhotoModal .modal-dialog,
#tenantPhotoModal .modal-dialog {
    z-index: 1056 !important;
    position: relative;
    pointer-events: auto !important;
    margin: 1.75rem auto;
}

#proofPhotoModal .modal-content,
#tenantPhotoModal .modal-content {
    z-index: 1057 !important;
    position: relative;
    pointer-events: auto !important;
    background-color: #ffffff !important;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;
}

/* Ensure all modal elements are clickable */
#proofPhotoModal button,
#proofPhotoModal .btn-close,
#tenantPhotoModal button,
#tenantPhotoModal .btn-close {
    pointer-events: auto !important;
    position: relative;
    z-index: 1058 !important;
}
</style>

<script>
function openCompleteModal() {
    const modal = new bootstrap.Modal(document.getElementById('completeModal'));
    modal.show();
}

// Tenant Photo Modal Functions
function openTenantPhotoModal(imageSrc) {
    document.getElementById('tenantPhotoModalImage').src = imageSrc;
    const modalElement = document.getElementById('tenantPhotoModal');
    
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
    }, { once: true });
}

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
    }, { once: true });
}

// Clean up when modals are hidden
document.addEventListener('hidden.bs.modal', function(event) {
    if (event.target.id === 'proofPhotoModal' || event.target.id === 'tenantPhotoModal') {
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
