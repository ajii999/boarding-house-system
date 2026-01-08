@extends('layouts.tenant')

@section('title', 'Payment Due Notifications')
@section('page-title', 'Payment Due Notifications')

@section('content')
<div class="space-y-6">
    <!-- Notification Summary -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Payment Due Summary</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Overview of your payment due notifications and upcoming payments.</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-bell text-2xl text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-800">Payment Due Notifications</p>
                            <p class="text-2xl font-semibold text-blue-900">{{ $notifications->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-envelope text-2xl text-yellow-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-yellow-800">Unread Payment Due</p>
                            <p class="text-2xl font-semibold text-yellow-900">{{ $notifications->where('status', 'unread')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-2xl text-green-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-800">Read Payment Due</p>
                            <p class="text-2xl font-semibold text-green-900">{{ $notifications->where('status', 'read')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Payment Due Notifications</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Your payment due notifications and upcoming payment reminders.</p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="markAllAsRead()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors text-sm">
                        <i class="fas fa-check-double mr-2"></i>Mark All as Read
                    </button>
                    <button onclick="clearAllNotifications()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                        <i class="fas fa-trash mr-2"></i>Clear All
                    </button>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200">
            @if($notifications->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($notifications as $notification)
                    <div class="px-6 py-4 hover:bg-gray-50 {{ $notification->status == 'unread' ? 'bg-blue-50 border-l-4 border-blue-400' : '' }}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if($notification->status == 'unread')
                                    <div class="h-3 w-3 bg-blue-600 rounded-full mt-2"></div>
                                @else
                                    <div class="h-3 w-3 bg-gray-300 rounded-full mt-2"></div>
                                @endif
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 {{ $notification->status == 'unread' ? 'font-semibold' : '' }}">
                                            <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>Payment Due Reminder
                                        </h4>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $notification->message ?? 'No message available' }}
                                        </p>
                                        @if($notification->data)
                                            <div class="mt-2 text-xs text-gray-500">
                                                @if(isset($notification->data['days_until_due']))
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                        @if($notification->data['days_until_due'] <= 0) bg-red-100 text-red-800
                                                        @elseif($notification->data['days_until_due'] == 1) bg-yellow-100 text-yellow-800
                                                        @else bg-blue-100 text-blue-800
                                                        @endif">
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
                                    <div class="flex items-center space-x-2 ml-4">
                                        <span class="text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                        @if($notification->status == 'unread')
                                        <button onclick="markAsRead({{ $notification->id }})" class="text-blue-600 hover:text-blue-900 text-sm">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                        <button onclick="deleteNotification({{ $notification->id }})" class="text-red-600 hover:text-red-900 text-sm">
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
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </div>
                @endif
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-check-circle text-6xl text-green-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Payment Due</h3>
                    <p class="text-gray-500">You don't have any payment due notifications at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function markAsRead(notificationId) {
    // Placeholder for marking notification as read
    fetch(`/tenant/notifications/${notificationId}/read`, {
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

function markAllAsRead() {
    // Placeholder for marking all notifications as read
    if (confirm('Mark all notifications as read?')) {
        fetch('/tenant/notifications/mark-all-read', {
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

function deleteNotification(notificationId) {
    // Placeholder for deleting notification
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
    // Placeholder for clearing all notifications
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
