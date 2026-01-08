<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Staff Member 1
        Staff::updateOrCreate(
            ['email' => 'jeramae@boardinghouse.com'],
            [
                'name' => 'Jeramae',
                'role' => 'Maintenance Supervisor',
                'password' => Hash::make('jeramae2211'),
                'contact_number' => '+63 912 345 6789',
            ]
        );

        // Create Staff Member 2
        Staff::updateOrCreate(
            ['email' => 'johara@boardinghouse.com'],
            [
                'name' => 'Johara',
                'role' => 'Maintenance Technician',
                'password' => Hash::make('johara1122'),
                'contact_number' => '+63 912 345 6790',
            ]
        );
    }
}