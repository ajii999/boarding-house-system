<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Tenant;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with(['bookings' => function($query) {
            $query->whereIn('status', ['confirmed', 'completed'])
                  ->with('tenant')
                  ->latest('check_in');
        }]);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                  ->orWhere('room_type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $rooms = $query->orderBy('room_number')->get();
        
        // Get room statistics
        $totalRooms = $rooms->count();
        
        return view('admin.rooms.index', compact('rooms', 'totalRooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number',
            'room_type' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'pricing_period' => 'required|in:per_night,monthly',
            'description' => 'nullable|string|max:500',
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    public function show(Room $room)
    {
        $room->load(['bookings' => function($query) {
            $query->with('tenant')->latest('check_in');
        }]);
        
        $currentBooking = $room->bookings->where('status', 'confirmed')->first();
        $bookingHistory = $room->bookings->where('status', 'completed');
        
        return view('admin.rooms.show', compact('room', 'currentBooking', 'bookingHistory'));
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number,' . $room->room_id . ',room_id',
            'room_type' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'pricing_period' => 'required|in:per_night,monthly',
            'description' => 'nullable|string|max:500',
        ]);

        $room->update($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        // Check if room has active bookings
        $activeBookings = $room->bookings()->whereIn('status', ['confirmed', 'pending'])->count();
        
        if ($activeBookings > 0) {
            return redirect()->route('admin.rooms.index')->with('error', 'Cannot delete room with active bookings.');
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
