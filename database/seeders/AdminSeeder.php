<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@boardinghouse.com'],
            [
                'master_id' => 'ADM001',
                'name' => 'System Administrator',
                'password' => Hash::make('admin123'),
            ]
        );
        
        $this->command->info('Admin seeded: ' . $admin->email);
    }
}
