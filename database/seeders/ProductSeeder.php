<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        
        $products = [
            [
                'name' => 'M4A1 Tactical Gel Blaster',
                'category' => 'Gel Blasters',
                'description' => 'Professional-grade M4A1 replica with high accuracy and range. Perfect for tactical gameplay and training exercises.',
                'specifications' => 'Length: 750mm, Weight: 2.5kg, FPS: 280-300, Range: 25-30m',
                'price' => 299.99,
                'sale_price' => 249.99,
                'stock_quantity' => 15,
                'brand' => 'TacticalPro',
                'weight' => 2.5,
                'firing_range' => '25-30m',
                'build_material' => 'Nylon + Metal',
                'is_featured' => true
            ],
            [
                'name' => 'AK-47 Gel Blaster',
                'category' => 'Gel Blasters',
                'description' => 'Iconic AK-47 design with reliable performance and authentic feel.',
                'specifications' => 'Length: 870mm, Weight: 3.2kg, FPS: 290-310, Range: 28-32m',
                'price' => 349.99,
                'stock_quantity' => 12,
                'brand' => 'ReplicaForce',
                'weight' => 3.2,
                'firing_range' => '28-32m',
                'build_material' => 'Metal + Polymer',
                'is_featured' => true
            ],
            [
                'name' => 'Premium Gel Balls 10,000 Pack',
                'category' => 'Ammunition',
                'description' => 'High-quality biodegradable gel balls for consistent performance.',
                'specifications' => 'Size: 7-8mm, Biodegradable, Non-toxic, Water-based',
                'price' => 24.99,
                'stock_quantity' => 50,
                'brand' => 'GelPro',
                'weight' => 0.5,
                'is_featured' => false
            ],
            [
                'name' => 'Tactical Vest with Pouches',
                'category' => 'Tactical Gear',
                'description' => 'Professional tactical vest with multiple magazine pouches and adjustment straps.',
                'specifications' => 'Material: 600D Oxford, Adjustable size, Multiple pouches',
                'price' => 89.99,
                'sale_price' => 69.99,
                'stock_quantity' => 25,
                'brand' => 'TacticalGear',
                'weight' => 1.2,
                'is_featured' => true
            ],
            [
                'name' => 'Red Dot Sight',
                'category' => 'Accessories',
                'description' => 'Precision red dot sight for improved accuracy and target acquisition.',
                'specifications' => 'Magnification: 1x, Reticle: 4 MOA red dot, Battery life: 1000+ hours',
                'price' => 79.99,
                'stock_quantity' => 30,
                'brand' => 'OpticsPro',
                'weight' => 0.3,
                'is_featured' => false
            ],
            [
                'name' => 'Safety Goggles',
                'category' => 'Safety Equipment',
                'description' => 'Essential eye protection with anti-fog coating and comfortable fit.',
                'specifications' => 'Material: Polycarbonate lens, Anti-fog coating, Adjustable strap',
                'price' => 19.99,
                'stock_quantity' => 100,
                'brand' => 'SafetyFirst',
                'weight' => 0.15,
                'is_featured' => false
            ]
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category'])->first();
            
            if ($category) {
                $product = Product::create([
                    'name' => $productData['name'],
                    'category_id' => $category->id,
                    'description' => $productData['description'],
                    'specifications' => $productData['specifications'],
                    'price' => $productData['price'],
                    'sale_price' => $productData['sale_price'] ?? null,
                    'stock_quantity' => $productData['stock_quantity'],
                    'brand' => $productData['brand'],
                    'weight' => $productData['weight'],
                    'firing_range' => $productData['firing_range'] ?? null,
                    'build_material' => $productData['build_material'] ?? null,
                    'is_featured' => $productData['is_featured'],
                    'status' => 'active',
                    'in_stock' => true,
                    'manage_stock' => true
                ]);

                // Create placeholder image
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'products/placeholder.jpg',
                    'alt_text' => $product->name,
                    'is_primary' => true,
                    'sort_order' => 0
                ]);
            }
        }
    }
}