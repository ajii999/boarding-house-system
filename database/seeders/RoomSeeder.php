<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            ['room_number' => '101', 'room_type' => 'Single', 'status' => 'available', 'price' => 500.00, 'description' => 'Cozy single room with basic amenities'],
            ['room_number' => '102', 'room_type' => 'Single', 'status' => 'available', 'price' => 500.00, 'description' => 'Cozy single room with basic amenities'],
            ['room_number' => '103', 'room_type' => 'Double', 'status' => 'available', 'price' => 800.00, 'description' => 'Spacious double room for two occupants'],
            ['room_number' => '104', 'room_type' => 'Double', 'status' => 'booked', 'price' => 800.00, 'description' => 'Spacious double room for two occupants'],
            ['room_number' => '105', 'room_type' => 'Triple', 'status' => 'available', 'price' => 1200.00, 'description' => 'Large triple room with shared facilities'],
            ['room_number' => '201', 'room_type' => 'Single', 'status' => 'available', 'price' => 550.00, 'description' => 'Premium single room with AC'],
            ['room_number' => '202', 'room_type' => 'Single', 'status' => 'maintenance', 'price' => 550.00, 'description' => 'Premium single room with AC'],
            ['room_number' => '203', 'room_type' => 'Double', 'status' => 'available', 'price' => 900.00, 'description' => 'Premium double room with AC'],
            ['room_number' => '204', 'room_type' => 'Double', 'status' => 'available', 'price' => 900.00, 'description' => 'Premium double room with AC'],
            ['room_number' => '205', 'room_type' => 'Triple', 'status' => 'available', 'price' => 1300.00, 'description' => 'Premium triple room with AC'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
