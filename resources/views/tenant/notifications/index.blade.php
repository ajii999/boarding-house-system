@extends('layouts.tenant')

@section('title', 'Payment Due Notifications')
@section('page-title', 'Payment Due Notifications')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 212, 255, 0.3); background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex align-items-center gap-3">
        <div class="rounded d-flex align-items-center justify-content-center" 
             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 212, 255, 0.1)); border: 2px solid rgba(0, 212, 255, 0.5);">
            <i class="fas fa-bell" style="color: #00d4ff;"></i>
        </div>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: #00d4ff;">Payment Due Notifications</h1>
            <p class="mb-0 small" style="color: var(--text-secondary);">Your payment due notifications and upcoming payment reminders</p>
        </div>
    </div>
</div>

<!-- Notification Summary -->
<div class="futuristic-card mb-4 mb-md-5" style="border-color: rgba(0, 102, 255, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important;">
        <h3 class="h5 mb-0 fw-bold" style="color: #0066ff;">Payment Due Summary</h3>
        <p class="small mb-0" style="color: var(--text-secondary);">Overview of your payment due notifications and upcoming payments.</p>
    </div>
    <div class="p-4">
        <div class="row g-3 g-md-4">
            <div class="col-12 col-md-4">
                <div class="futuristic-card p-4" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(0, 102, 255, 0.1)); border: 2px solid rgba(0, 102, 255, 0.3);">
                            <i class="fas fa-bell" style="font-size: 1.5rem; color: #0066ff;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Payment Due Notifications</p>
                            <p class="h4 fw-bold mb-0" style="color: #0066ff;">{{ $notifications->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-4">
                <div class="futuristic-card p-4" style="border-color: rgba(245, 158, 11, 0.2); background: rgba(245, 158, 11, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.1)); border: 2px solid rgba(245, 158, 11, 0.3);">
                            <i class="fas fa-envelope" style="font-size: 1.5rem; color: #f59e0b;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Unread Payment Due</p>
                            <p class="h4 fw-bold mb-0" style="color: #f59e0b;">{{ $notifications->where('status', 'unread')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-4">
                <div class="futuristic-card p-4" style="border-color: rgba(34, 197, 94, 0.2); background: rgba(34, 197, 94, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border: 2px solid rgba(34, 197, 94, 0.3);">
                            <i class="fas fa-check-circle" style="font-size: 1.5rem; color: #22c55e;"></i>
                        </div>
                        <div>
                            <p class="small fw-medium mb-1" style="color: var(--text-secondary);">Read Payment Due</p>
                            <p class="h4 fw-bold mb-0" style="color: #22c55e;">{{ $notifications->where('status', 'read')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div class="futuristic-card" style="border-color: rgba(0, 212, 255, 0.3);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 212, 255, 0.2) !important;">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h3 class="h5 mb-1 fw-bold" style="color: #00d4ff;">Payment Due Notifications</h3>
                <p class="small mb-0" style="color: var(--text-secondary);">Your payment due notifications and upcoming payment reminders.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <form id="markAllReadForm" method="POST" action="{{ route('tenant.notifications.mark-all-read') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-neon btn-sm">
                        <i class="fas fa-check-double me-2"></i>Mark All as Read
                    </button>
                </form>
                <button onclick="clearAllNotifications()" class="btn btn-sm" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1)); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444;">
                    <i class="fas fa-trash me-2"></i>Clear All
                </button>
            </div>
        </div>
    </div>
    <div class="p-0">
        @if($notifications->count() > 0)
            <div class="d-flex flex-column">
                @foreach($notifications as $notification)
                <div class="futuristic-card p-4 mb-0 border-0 border-bottom" 
                     style="@if($notification->status == 'unread') border-color: rgba(0, 102, 255, 0.2) !important; background: rgba(0, 102, 255, 0.05); border-left: 4px solid rgba(0, 102, 255, 0.5) !important; @else border-color: rgba(148, 163, 184, 0.2) !important; @endif">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0 me-3">
                            @if($notification->status == 'unread')
                                <div class="rounded-circle" style="width: 12px; height: 12px; background: #0066ff; margin-top: 8px;"></div>
                            @else
                                <div class="rounded-circle" style="width: 12px; height: 12px; background: #94a3b8; margin-top: 8px;"></div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="flex-grow-1">
                                    <h4 class="h6 fw-bold mb-1" style="color: var(--text-primary); @if($notification->status == 'unread') font-weight: 600; @endif">
                                        <i class="fas fa-exclamation-triangle me-2" style="color: #f59e0b;"></i>Payment Due Reminder
                                    </h4>
                                    <p class="small mb-2" style="color: var(--text-secondary);">
                                        {{ $notification->message ?? 'No message available' }}
                                    </p>
                                    @if($notification->data)
                                        <div class="mt-2">
                                            @if(isset($notification->data['days_until_due']))
                                                <span class="badge px-3 py-1 rounded-pill" 
                                                      style="@if($notification->data['days_until_due'] <= 0) background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444;
                                                      @elseif($notification->data['days_until_due'] == 1) background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b;
                                                      @else background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff; @endif">
                                                    @if($notification->data['days_until_due'] <= 0)
                                                        Overdue
                                                    @elseif($notification->data['days_until_due'] == 1)
                                                        Due Tomorrow
                                                    @else
                                                        Due in {{ $notification->data['days_until_due'] }} days
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="small" style="color: var(--text-secondary);">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    @if($notification->status == 'unread')
                                    <button onclick="markAsRead({{ $notification->notification_id }})" class="btn btn-sm" style="color: #0066ff;" title="Mark as Read">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    @endif
                                    <button onclick="deleteNotification({{ $notification->id }})" class="btn btn-sm" style="color: #ef4444;" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($notifications->hasPages())
            <div class="p-4 border-top" style="border-color: rgba(0, 212, 255, 0.2) !important;">
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; background: rgba(34, 197, 94, 0.1); border: 2px solid rgba(34, 197, 94, 0.3);">
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: #22c55e;"></i>
                </div>
                <h3 class="h5 fw-semibold mb-2" style="color: var(--text-primary);">No Payment Due</h3>
                <p class="mb-0" style="color: var(--text-secondary);">You don't have any payment due notifications at the moment.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function markAsRead(notificationId) {
    fetch(`/tenant/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to mark notification as read'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

// Handle mark all as read form submission
document.addEventListener('DOMContentLoaded', function() {
    const markAllReadForm = document.getElementById('markAllReadForm');
    if (markAllReadForm) {
        markAllReadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('Mark all notifications as read?')) {
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        // If not JSON, treat as success and reload
                        location.reload();
                        return null;
                    }
                })
                .then(data => {
                    if (data) {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + (data.message || 'Failed to mark all notifications as read'));
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Even on error, try to reload in case it worked
                    location.reload();
                });
            }
        });
    }
});

function deleteNotification(notificationId) {
    if (confirm('Delete this notification?')) {
        fetch(`/tenant/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

function clearAllNotifications() {
    if (confirm('Clear all notifications? This action cannot be undone.')) {
        fetch('/tenant/notifications/clear-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
</script>
@endpush
@endsection
