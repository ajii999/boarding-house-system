<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample tenants
        $tenants = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'contact_number' => '+1234567890',
                'password' => Hash::make('password123'),
                'profile' => [
                    'address' => '123 Main Street, City',
                    'emergency_contact' => '+1234567891',
                    'occupation' => 'Software Developer'
                ]
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'contact_number' => '+1234567892',
                'password' => Hash::make('password123'),
                'profile' => [
                    'address' => '456 Oak Avenue, City',
                    'emergency_contact' => '+1234567893',
                    'occupation' => 'Teacher'
                ]
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'contact_number' => '+1234567894',
                'password' => Hash::make('password123'),
                'profile' => [
                    'address' => '789 Pine Road, City',
                    'emergency_contact' => '+1234567895',
                    'occupation' => 'Engineer'
                ]
            ]
        ];

        foreach ($tenants as $tenantData) {
            $profile = $tenantData['profile'];
            unset($tenantData['profile']);
            
            $tenant = Tenant::updateOrCreate(
                ['email' => $tenantData['email']],
                $tenantData
            );
            
            // Update or create profile
            if (!$tenant->profile) {
                $tenant->profile()->create($profile);
            } else {
                $tenant->profile()->update($profile);
            }
        }

        // Create sample staff (only if they don't exist)
        Staff::updateOrCreate(
            ['email' => 'sarah@boardinghouse.com'],
            [
                'name' => 'Sarah Wilson',
                'role' => 'Maintenance',
                'contact_number' => '+1234567896',
            ]
        );

        Staff::updateOrCreate(
            ['email' => 'tom@boardinghouse.com'],
            [
                'name' => 'Tom Brown',
                'role' => 'Receptionist',
                'contact_number' => '+1234567897',
            ]
        );
    }
}
