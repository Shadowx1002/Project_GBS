<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);
        $price = fake()->randomFloat(2, 50, 500);
        $salePrice = fake()->boolean(30) ? fake()->randomFloat(2, 30, $price - 10) : null;
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(3, true),
            'specifications' => fake()->paragraph(),
            'price' => $price,
            'sale_price' => $salePrice,
            'sku' => 'GB-' . strtoupper(Str::random(8)),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'manage_stock' => true,
            'in_stock' => true,
            'is_featured' => fake()->boolean(20),
            'status' => 'active',
            'brand' => fake()->company(),
            'weight' => fake()->randomFloat(2, 0.5, 5),
            'firing_range' => fake()->numberBetween(20, 40) . 'm',
            'build_material' => fake()->randomElement(['Plastic', 'Metal', 'Nylon', 'Polymer']),
            'views' => fake()->numberBetween(0, 1000),
            'category_id' => Category::factory(),
        ];
    }
}