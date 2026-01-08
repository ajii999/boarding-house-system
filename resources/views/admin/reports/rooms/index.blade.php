@extends('layouts.admin')

@section('title', 'Room Management')
@section('page-title', 'Room Management')

@section('content')
<!-- Header with Back Button -->
<div class="mb-6 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl shadow-lg p-6 text-white">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full p-3 transition-all duration-300 transform hover:scale-110">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Room Management</h1>
                <p class="text-green-100">Manage all rooms in your boarding house</p>
            </div>
        </div>
        <a href="{{ route('admin.rooms.create') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-all duration-300">
            <i class="fas fa-plus mr-2"></i>Add New Room
        </a>
    </div>
</div>

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-medium text-gray-900">All Rooms</h3>
    <div class="flex items-center space-x-4">
        <!-- Search Bar -->
        <form method="GET" action="{{ route('admin.rooms.index') }}" class="flex items-center">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search rooms..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
            <button type="submit" class="ml-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-search mr-1"></i>Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.rooms.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-times mr-1"></i>Clear
                </a>
            @endif
        </form>
    </div>
</div>

<!-- Room Statistics -->
<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-bed text-2xl text-indigo-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Rooms</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalRooms }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rooms Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($rooms as $room)
    <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12">
                        <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-bed text-indigo-600 text-lg"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-gray-900">Room {{ $room->room_number }}</h4>
                        <p class="text-sm text-gray-500">{{ $room->room_type }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-lg font-semibold text-gray-900">₱{{ number_format($room->price, 2) }}</div>
                    <div class="text-sm text-gray-500">
                        @if($room->pricing_period == 'per_night')
                            per night
                        @else
                            per month
                        @endif
                    </div>
                </div>
            </div>
            
            
            @if($room->description)
            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($room->description, 100) }}</p>
            @endif
            
            <!-- Current Occupant -->
            @if($room->bookings->count() > 0)
            <div class="border-t border-gray-200 pt-4">
                <h5 class="text-sm font-medium text-gray-900 mb-2">Current Occupant:</h5>
                <div class="flex items-center text-sm">
                    <i class="fas fa-user text-gray-400 mr-2"></i>
                    <span class="text-gray-700">{{ $room->bookings->first()->tenant->name ?? 'Unknown' }}</span>
                </div>
                @if($room->bookings->first()->check_in && $room->bookings->first()->check_out)
                <div class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    {{ $room->bookings->first()->check_in->format('M j, Y') }} - 
                    {{ $room->bookings->first()->check_out->format('M j, Y') }}
                </div>
                @endif
            </div>
            @else
            <div class="border-t border-gray-200 pt-4">
                <div class="text-sm text-gray-500">
                    <i class="fas fa-bed text-gray-400 mr-2"></i>
                    No current occupant
                </div>
            </div>
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="bg-gray-50 px-6 py-3 flex justify-between items-center">
            <div class="flex space-x-2">
                <a href="{{ route('admin.rooms.show', $room) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                    <i class="fas fa-eye mr-1"></i>View
                </a>
                <a href="{{ route('admin.rooms.edit', $room) }}" class="text-yellow-600 hover:text-yellow-900 text-sm">
                    <i class="fas fa-edit mr-1"></i>Edit
                </a>
            </div>
            <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this room?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                    <i class="fas fa-trash mr-1"></i>Delete
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <i class="fas fa-bed text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No Rooms Found</h3>
        <p class="text-gray-500 mb-4">Get started by creating your first room.</p>
        <a href="{{ route('admin.rooms.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Add New Room
        </a>
    </div>
    @endforelse
</div>
@endsection
