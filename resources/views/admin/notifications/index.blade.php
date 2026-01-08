@extends('layouts.admin')

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border-color: rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-neon btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: #0066ff;">Notifications</h1>
                <p class="mb-0 small" style="color: var(--text-secondary);">Manage and view all system notifications</p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="futuristic-card px-3 py-2" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.05);">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-bell" style="color: #0066ff;"></i>
                    <span class="small fw-semibold" style="color: var(--text-primary);">{{ $notifications->whereNull('read_at')->count() }} unread</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div class="futuristic-card" style="border-color: rgba(0, 102, 255, 0.2);">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important; background: rgba(0, 102, 255, 0.02);">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.3);">
                    <i class="fas fa-bell" style="color: #0066ff;"></i>
                </div>
                <div>
                    <h3 class="h5 fw-bold mb-1" style="color: var(--text-primary);">All Notifications</h3>
                    <p class="small mb-0" style="color: var(--text-secondary);">System notifications and alerts</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list" style="color: var(--text-secondary);"></i>
                <span class="small" style="color: var(--text-secondary);">{{ $notifications->total() }} total</span>
            </div>
        </div>
    </div>
    
    <div class="p-4">
        @if($notifications->count() > 0)
            <div class="d-flex flex-column gap-3">
                @foreach($notifications as $notification)
                <div class="futuristic-card p-4" 
                     style="border-left: 4px solid {{ $notification->read_at ? 'rgba(148, 163, 184, 0.5)' : 'rgba(0, 102, 255, 0.5)' }}; 
                            border-color: {{ $notification->read_at ? 'rgba(148, 163, 184, 0.2)' : 'rgba(0, 102, 255, 0.2)' }}; 
                            background: {{ $notification->read_at ? 'linear-gradient(135deg, rgba(148, 163, 184, 0.05), rgba(148, 163, 184, 0.02))' : 'linear-gradient(135deg, rgba(0, 102, 255, 0.05), rgba(124, 58, 237, 0.05))' }};">
                    <div class="d-flex gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                             style="width: 50px; height: 50px; background: {{ $notification->read_at ? 'rgba(148, 163, 184, 0.2)' : 'linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2))' }}; border: 2px solid {{ $notification->read_at ? 'rgba(148, 163, 184, 0.4)' : 'rgba(0, 102, 255, 0.4)' }};">
                            <i class="fas fa-bell" style="color: {{ $notification->read_at ? '#94a3b8' : '#0066ff' }};"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                                <div class="flex-grow-1">
                                    <h4 class="fw-bold mb-2" style="color: var(--text-primary);">{{ $notification->title }}</h4>
                                    <p class="mb-3" style="color: var(--text-secondary);">{{ $notification->message }}</p>
                                    
                                    @if($notification->data)
                                        @php
                                            $data = json_decode($notification->data, true);
                                        @endphp
                                        @if(isset($data['payment_id']))
                                        <div class="futuristic-card p-3 mb-3" style="border-color: rgba(0, 102, 255, 0.2); background: rgba(0, 102, 255, 0.02);">
                                            <div class="row g-3">
                                                @if(isset($data['amount']))
                                                <div class="col-12 col-md-6">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="fas fa-dollar-sign" style="color: #22c55e;"></i>
                                                        <span class="small fw-semibold" style="color: var(--text-primary);">Amount: ₱{{ number_format($data['amount'], 2) }}</span>
                                                    </div>
                                                </div>
                                                @endif
                                                @if(isset($data['method']))
                                                <div class="col-12 col-md-6">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="fas fa-credit-card" style="color: #0066ff;"></i>
                                                        <span class="small fw-semibold" style="color: var(--text-primary);">Method: {{ ucfirst($data['method']) }}</span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                    
                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        <span class="small d-flex align-items-center gap-1" style="color: var(--text-secondary);">
                                            <i class="fas fa-clock"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                        @if($notification->read_at)
                                            <span class="small d-flex align-items-center gap-1" style="color: #22c55e;">
                                                <i class="fas fa-check-circle"></i>
                                                Read {{ $notification->read_at->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="badge px-3 py-1 rounded-pill" style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff;">
                                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Unread
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center gap-2">
                                    @if(!$notification->read_at)
                                    <a href="{{ route('admin.notifications.read', $notification->notification_id) }}" class="btn btn-neon btn-sm">
                                        <i class="fas fa-check me-1"></i>Mark as Read
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($notifications->hasPages())
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" 
                     style="width: 100px; height: 100px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                    <i class="fas fa-bell" style="font-size: 3rem; color: #0066ff;"></i>
                </div>
                <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">No Notifications</h3>
                <p class="mb-0" style="color: var(--text-secondary);">You don't have any notifications yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
