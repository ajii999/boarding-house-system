@extends('layouts.staff')

@section('title', 'Notifications')
@section('page-title', 'My Notifications')

@section('content')
<div class="mb-4">
    <!-- Notifications Header -->
    <div class="futuristic-card">
        <div class="p-3 p-md-4">
            <h3 class="h5 fw-semibold mb-1" style="color: var(--text-primary);">Task Notifications</h3>
            <p class="small text-muted mb-0">Your assigned task notifications and updates.</p>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div class="futuristic-card">
    @if($notifications->count() > 0)
        <div class="list-group list-group-flush">
            @foreach($notifications as $notification)
            <div class="list-group-item border-0 p-3 p-md-4" style="background: transparent;">
                <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-start flex-grow-1 min-width-0">
                        <div class="flex-shrink-0 me-3">
                            @if($notification->status === 'unread')
                                <div class="rounded-circle" style="width: 12px; height: 12px; background: linear-gradient(135deg, var(--primary-neon), var(--secondary-neon)); box-shadow: 0 0 10px rgba(0, 102, 255, 0.5);"></div>
                            @else
                                <div class="rounded-circle bg-secondary" style="width: 12px; height: 12px; opacity: 0.3;"></div>
                            @endif
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                <h4 class="h6 fw-semibold mb-0" style="color: var(--text-primary);">
                                    {{ $notification->title ?? 'Notification' }}
                                </h4>
                                @if($notification->status === 'unread')
                                    <span class="badge bg-primary rounded-pill px-2 py-1" style="font-size: 0.65rem;">New</span>
                                @endif
                            </div>
                            <p class="small text-muted mb-2">
                                {{ $notification->message }}
                            </p>
                            @if($notification->data && isset($notification->data['issue_type']))
                            <div class="small" style="color: var(--text-secondary);">
                                <span class="fw-semibold">Issue Type:</span> {{ $notification->data['issue_type'] }}
                                @if(isset($notification->data['request_id']))
                                    <span class="ms-2">| Request #{{ $notification->data['request_id'] }}</span>
                                    <a href="{{ route('staff.maintenance.show', $notification->data['request_id']) }}" 
                                       class="btn btn-sm btn-outline-primary ms-2" style="font-size: 0.7rem; padding: 0.2rem 0.5rem;">
                                        View Details
                                    </a>
                                @endif
                                @if(isset($notification->data['priority']))
                                    <span class="ms-2">
                                        <span class="badge rounded-pill px-2 py-1
                                            @if($notification->data['priority'] === 'urgent') bg-danger
                                            @elseif($notification->data['priority'] === 'high') bg-warning
                                            @elseif($notification->data['priority'] === 'medium') bg-info
                                            @else bg-success
                                            @endif" style="font-size: 0.65rem;">
                                            {{ ucfirst($notification->data['priority']) }}
                                        </span>
                                    </span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 flex-shrink-0">
                        <div class="small text-muted" style="white-space: nowrap;">
                            {{ $notification->created_at->format('M j, Y g:i A') }}
                        </div>
                        @if($notification->status === 'unread')
                        <form action="{{ route('staff.notifications.mark-read', $notification->notification_id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary" style="border-radius: 8px; font-size: 0.75rem;">
                                Mark as Read
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @if(!$loop->last)
            <hr class="my-0" style="border-color: rgba(0, 102, 255, 0.1);">
            @endif
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="p-3 p-md-4 border-top" style="border-color: rgba(0, 102, 255, 0.1) !important;">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="d-flex flex-column align-items-center">
                <i class="fas fa-bell-slash text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                <h3 class="h5 fw-semibold mb-2" style="color: var(--text-primary);">No Notifications</h3>
                <p class="text-muted mb-0">You don't have any task notifications at the moment.</p>
            </div>
        </div>
    @endif
</div>
@endsection
