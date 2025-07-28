<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Gel Blasters',
                'slug' => 'gel-blasters',
                'description' => 'High-quality gel blasters for recreational use',
                'sort_order' => 1
            ],
            [
                'name' => 'Ammunition',
                'slug' => 'ammunition',
                'description' => 'Gel balls and accessories for your blasters',
                'sort_order' => 2
            ],
            [
                'name' => 'Tactical Gear',
                'slug' => 'tactical-gear',
                'description' => 'Professional tactical equipment and accessories',
                'sort_order' => 3
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Upgrade and customize your gear',
                'sort_order' => 4
            ],
            [
                'name' => 'Safety Equipment',
                'slug' => 'safety-equipment',
                'description' => 'Essential protective gear for safe gameplay',
                'sort_order' => 5
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}