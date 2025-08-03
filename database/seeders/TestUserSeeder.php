<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create verified test user
        User::create([
            'name' => 'Test User',
            'email' => 'user@gelblaster.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '+1-555-0456',
            'is_admin' => false,
            'address_line_1' => '456 User Avenue',
            'city' => 'User City',
            'state' => 'UC',
            'postal_code' => '67890',
            'country' => 'US'
        ]);

        // Create unverified test user
        User::create([
            'name' => 'Unverified User',
            'email' => 'unverified@gelblaster.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '+1-555-0789',
            'is_admin' => false
        ]);
    }
}