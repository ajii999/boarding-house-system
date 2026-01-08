@extends('layouts.admin')

@section('title', 'Room Management')
@section('page-title', 'Room Management')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px; position: relative; overflow: hidden;">
    <!-- Animated background glow -->
    <div style="position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent); border-radius: 50%; animation: pulse 4s ease-in-out infinite;"></div>
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3" style="position: relative; z-index: 1;">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'; this.style.background='rgba(255, 255, 255, 0.35)'; this.style.boxShadow='0 6px 20px rgba(255, 255, 255, 0.3)';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(255, 255, 255, 0.25)'; this.style.boxShadow='0 4px 15px rgba(255, 255, 255, 0.2)';">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); letter-spacing: -0.5px;">Room Management</h1>
                <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.9); font-weight: 500;">Manage all rooms in your boarding house</p>
            </div>
        </div>
        <a href="{{ route('admin.rooms.create') }}" class="btn d-flex align-items-center" style="background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 12px; transition: all 0.3s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-2px)'; this.style.background='rgba(255, 255, 255, 0.35)'; this.style.boxShadow='0 6px 25px rgba(255, 255, 255, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255, 255, 255, 0.25)'; this.style.boxShadow='0 4px 20px rgba(255, 255, 255, 0.2)';">
            <i class="fas fa-plus me-2"></i>Add New Room
        </a>
    </div>
</div>

<!-- Search Section -->
<div class="futuristic-card p-4 mb-4" style="border: 2px solid rgba(0, 102, 255, 0.3); background: white; box-shadow: 0 4px 20px rgba(0, 102, 255, 0.15), 0 0 0 1px rgba(0, 102, 255, 0.1) inset; border-radius: 12px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <h3 class="h5 fw-bold mb-0" style="color: #0066ff;">All Rooms</h3>
        <form method="GET" action="{{ route('admin.rooms.index') }}" class="d-flex flex-column flex-md-row align-items-end gap-3">
            <div class="w-100" style="max-width: 400px;">
                <label for="search" class="form-label small fw-semibold" style="color: #0066ff;">Search</label>
                <div class="position-relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Search rooms..." 
                           class="form-control" style="background: white; border: 2px solid rgba(0, 102, 255, 0.3); border-radius: 10px; padding: 0.75rem 1rem 0.75rem 2.5rem; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0, 102, 255, 0.1) inset;" onfocus="this.style.borderColor='#0066ff'; this.style.boxShadow='0 2px 12px rgba(0, 102, 255, 0.2) inset, 0 0 0 3px rgba(0, 102, 255, 0.1)';" onblur="this.style.borderColor='rgba(0, 102, 255, 0.3)'; this.style.boxShadow='0 2px 8px rgba(0, 102, 255, 0.1) inset';">
                    <div class="position-absolute top-50 start-0 translate-middle-y ms-3" style="color: #0066ff; line-height: 1;">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-end gap-2">
                <button type="submit" class="btn d-flex align-items-center" style="background: linear-gradient(135deg, #0066ff, #3b82f6); border: none; color: white; box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 102, 255, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.3)';">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                @if(request('search'))
                <a href="{{ route('admin.rooms.index') }}" class="btn d-flex align-items-center" style="background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3); color: #0066ff; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0, 102, 255, 0.1);" onmouseover="this.style.background='rgba(0, 102, 255, 0.15)'; this.style.borderColor='rgba(0, 102, 255, 0.4)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(0, 102, 255, 0.1)'; this.style.borderColor='rgba(0, 102, 255, 0.3)'; this.style.transform='translateY(0)';">
                    <i class="fas fa-times me-1"></i>Clear
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Room Statistics -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="futuristic-card p-4 p-md-5 stat-card" style="border: 2px solid rgba(0, 102, 255, 0.3); background: white; box-shadow: 0 8px 32px rgba(0, 102, 255, 0.15), 0 0 0 1px rgba(0, 102, 255, 0.1) inset; border-radius: 16px;">
            <div class="d-flex align-items-center gap-4">
                <div class="rounded d-flex align-items-center justify-content-center" 
                     style="width: 90px; height: 90px; background: rgba(0, 102, 255, 0.1); border: 3px solid rgba(0, 102, 255, 0.3); box-shadow: 0 4px 15px rgba(0, 102, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1) rotate(5deg)'; this.style.boxShadow='0 6px 20px rgba(0, 102, 255, 0.3)';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.2)';">
                    <i class="fas fa-bed" style="font-size: 2.5rem; color: #0066ff;"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="small mb-2" style="color: #0066ff; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600; font-size: 0.85rem;">Total Rooms</p>
                    <p class="h1 fw-bold mb-0" style="color: #0066ff; letter-spacing: -1px;">{{ $totalRooms }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rooms Grid -->
<div class="row g-4">
    @forelse($rooms as $room)
    <div class="col-12 col-md-6 col-lg-4">
        <div class="futuristic-card h-100 hover-lift" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.3);">
                            <i class="fas fa-bed" style="font-size: 1.5rem; color: #0066ff;"></i>
                        </div>
                        <div>
                            <h4 class="h5 fw-bold mb-0" style="color: var(--text-primary);">Room {{ $room->room_number }}</h4>
                            <p class="small mb-0" style="color: var(--text-secondary);">{{ $room->room_type }}</p>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="h5 fw-bold mb-0" style="color: #0ea5e9;">₱{{ number_format($room->price, 2) }}</div>
                        <div class="small" style="color: var(--text-secondary);">
                            @if($room->pricing_period == 'per_night')
                                per night
                            @else
                                per month
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($room->description)
                <p class="small mb-4" style="color: var(--text-secondary);">{{ Str::limit($room->description, 100) }}</p>
                @endif
                
                <!-- Current Occupant -->
                @if($room->bookings->count() > 0)
                <div class="border-top pt-3 mb-3" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                    <h5 class="small fw-semibold mb-2" style="color: var(--text-primary);">Current Occupant:</h5>
                    <div class="d-flex align-items-center small" style="color: var(--text-primary);">
                        <i class="fas fa-user me-2" style="color: var(--text-secondary);"></i>
                        <span>{{ $room->bookings->first()->tenant->name ?? 'Unknown' }}</span>
                    </div>
                    @if($room->bookings->first()->check_in && $room->bookings->first()->check_out)
                    <div class="small mt-1" style="color: var(--text-secondary);">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ $room->bookings->first()->check_in->format('M j, Y') }} - 
                        {{ $room->bookings->first()->check_out->format('M j, Y') }}
                    </div>
                    @endif
                </div>
                @else
                <div class="border-top pt-3 mb-3" style="border-color: rgba(0, 102, 255, 0.2) !important;">
                    <div class="small" style="color: var(--text-secondary);">
                        <i class="fas fa-bed me-2"></i>
                        No current occupant
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Action Buttons -->
            <div class="border-top p-3 d-flex justify-content-between align-items-center" style="background: rgba(0, 102, 255, 0.02); border-color: rgba(0, 102, 255, 0.2) !important;">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-sm" style="color: #0066ff;">
                        <i class="fas fa-eye me-1"></i>View
                    </a>
                    <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm" style="color: #f59e0b;">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                </div>
                <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this room?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm" style="color: #ef4444;">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="futuristic-card text-center py-5" style="border-color: rgba(0, 102, 255, 0.2);">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                     style="width: 100px; height: 100px; background: rgba(0, 102, 255, 0.1); border: 2px solid rgba(0, 102, 255, 0.3);">
                    <i class="fas fa-bed" style="font-size: 3rem; color: #0066ff;"></i>
                </div>
                <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">No Rooms Found</h3>
                <p class="mb-4" style="color: var(--text-secondary);">Get started by creating your first room.</p>
                <a href="{{ route('admin.rooms.create') }}" class="btn btn-neon">
                    <i class="fas fa-plus me-2"></i>Add New Room
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<style>
@keyframes pulse {
    0%, 100% {
        opacity: 0.5;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.1);
    }
}

.hover-lift {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(14, 165, 233, 0.15) !important;
}
</style>
@endsection
