@extends('layouts.admin')

@section('title', 'Edit Room - ' . $room->room_number)
@section('page-title', 'Edit Room')

@section('content')
<div class="max-w-2xl mx-auto">
    <form method="POST" action="{{ route('admin.rooms.update', $room) }}" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Room Information</h3>
                    <p class="mt-1 text-sm text-gray-500">Update the room details and pricing.</p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                            <input type="text" name="room_number" id="room_number" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('room_number') border-red-300 @enderror"
                                   value="{{ old('room_number', $room->room_number) }}" placeholder="e.g., 101, A1, etc.">
                            @error('room_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="room_type" class="block text-sm font-medium text-gray-700">Room Type</label>
                            <select name="room_type" id="room_type" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('room_type') border-red-300 @enderror">
                                <option value="">Select room type</option>
                                <option value="Single" {{ old('room_type', $room->room_type) == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Double" {{ old('room_type', $room->room_type) == 'Double' ? 'selected' : '' }}>Double</option>
                                <option value="Twin" {{ old('room_type', $room->room_type) == 'Twin' ? 'selected' : '' }}>Twin</option>
                                <option value="Suite" {{ old('room_type', $room->room_type) == 'Suite' ? 'selected' : '' }}>Suite</option>
                                <option value="Dormitory" {{ old('room_type', $room->room_type) == 'Dormitory' ? 'selected' : '' }}>Dormitory</option>
                            </select>
                            @error('room_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₱</span>
                                </div>
                                <input type="number" name="price" id="price" step="0.01" min="0" required
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md @error('price') border-red-300 @enderror"
                                       value="{{ old('price', $room->price) }}" placeholder="0.00">
                            </div>
                            @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="pricing_period" class="block text-sm font-medium text-gray-700">Pricing Period</label>
                            <select name="pricing_period" id="pricing_period" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('pricing_period') border-red-300 @enderror">
                                <option value="">Select pricing period</option>
                                <option value="per_night" {{ old('pricing_period', $room->pricing_period) == 'per_night' ? 'selected' : '' }}>Per Night</option>
                                <option value="monthly" {{ old('pricing_period', $room->pricing_period) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            </select>
                            @error('pricing_period')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="col-span-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-300 @enderror"
                                      placeholder="Room amenities, features, or special notes...">{{ old('description', $room->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.rooms.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancel
            </a>
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Update Room
            </button>
        </div>
    </form>
</div>
@endsection
