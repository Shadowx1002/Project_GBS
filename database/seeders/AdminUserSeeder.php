<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gelblaster.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '+1-555-0123',
            'is_admin' => true,
            'address_line_1' => '123 Admin Street',
            'city' => 'Admin City',
            'state' => 'AC',
            'postal_code' => '12345',
            'country' => 'US'
        ]);
    }
}