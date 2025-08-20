<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call your individual seeders here, e.g.:
        $this->call(ProductSeeder::class);
        // Add other seeders here if you have more.
    }
}
