<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'GCash',
                'type' => 'digital_wallet',
                'description' => 'Pay using GCash mobile wallet. Fast and secure digital payment.',
                'configuration' => [
                    'account_number' => '09123456789',
                    'account_name' => 'Boarding House Management',
                    'instructions' => 'Send payment to the provided GCash number and include the verification code in the reference.'
                ],
                'is_active' => true,
                'requires_verification' => true,
                'processing_fee' => 0.00,
                'processing_time_hours' => 1,
            ],
            [
                'name' => 'Cash Payment',
                'type' => 'offline',
                'description' => 'Pay in cash at the office. Available during business hours.',
                'configuration' => [
                    'location' => 'Boarding House Office',
                    'hours' => 'Monday to Friday, 8:00 AM - 5:00 PM',
                    'instructions' => 'Visit the office during business hours with the verification code.'
                ],
                'is_active' => true,
                'requires_verification' => false,
                'processing_fee' => 0.00,
                'processing_time_hours' => 0,
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::updateOrCreate(
                ['name' => $method['name']],
                $method
            );
        }
    }
}
