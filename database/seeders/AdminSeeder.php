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
        // Check if admin already exists
        $admin = Admin::where('email', 'admin@boardinghouse.com')->first();
        
        if (!$admin) {
            Admin::create([
                'master_id' => 'ADM001',
                'name' => 'System Administrator',
                'email' => 'admin@boardinghouse.com',
                'password' => Hash::make('admin123'),
            ]);
        } else {
            // Update password if admin exists but password might be wrong
            $admin->update([
                'password' => Hash::make('admin123'),
            ]);
        }
    }
}
