@extends('layouts.admin')

@section('title', 'Room Details - ' . $room->room_number)
@section('page-title', 'Room Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Room Header -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Room {{ $room->room_number }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $room->room_type }} - ₱{{ number_format($room->price, 2) }}
                        @if($room->pricing_period == 'per_night')
                            /night
                        @else
                            /month
                        @endif
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.rooms.edit', $room) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit Room
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Room Type</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $room->room_type }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Price</dt>
                    <dd class="mt-1 text-sm text-gray-900">₱{{ number_format($room->price, 2) }}
                        @if($room->pricing_period == 'per_night')
                            per night
                        @else
                            per month
                        @endif
                    </dd>
                </div>
                @if($room->description)
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $room->description }}</dd>
                </div>
                @endif
            </dl>
        </div>
    </div>

    <!-- Current Occupant -->
    @if($currentBooking)
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Current Occupant</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Details about the current tenant staying in this room.</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12">
                    <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-user text-indigo-600"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">{{ $currentBooking->tenant->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $currentBooking->tenant->email }}</p>
                            <p class="text-sm text-gray-500">{{ $currentBooking->tenant->contact_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ number_format($currentBooking->total_amount, 2) }}</p>
                            <p class="text-sm text-gray-500">Total Amount</p>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Check-in Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $currentBooking->check_in->format('M j, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Check-out Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $currentBooking->check_out->format('M j, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Booking Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($currentBooking->status == 'confirmed') bg-green-100 text-green-800
                                    @elseif($currentBooking->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst($currentBooking->status) }}
                                </span>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <div class="text-center">
                <i class="fas fa-bed text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Current Occupant</h3>
                <p class="text-gray-500">This room is currently available for booking.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Booking History -->
    @if($bookingHistory->count() > 0)
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Booking History</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Previous tenants who have stayed in this room.</p>
        </div>
        <div class="border-t border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-in</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-out</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookingHistory as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $booking->tenant->name }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->tenant->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $booking->check_in->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $booking->check_out->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($booking->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
