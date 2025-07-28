<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_page_displays_correctly()
    {
        $category = Category::factory()->create();
        $products = Product::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee($products->first()->name);
    }

    public function test_product_detail_page_shows_product_info()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->get("/products/{$product->slug}");

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee($product->description);
        $response->assertSee(number_format($product->price, 2));
    }

    public function test_unverified_user_cannot_add_to_cart()
    {
        $user = User::factory()->create(['is_verified' => false]);
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
                        ->postJson('/cart/add', ['product_id' => $product->id]);

        $response->assertStatus(403);
    }

    public function test_verified_user_can_add_to_cart()
    {
        $user = User::factory()->create(['is_verified' => true]);
        $product = Product::factory()->create(['stock_quantity' => 10]);

        $response = $this->actingAs($user)
                        ->postJson('/cart/add', ['product_id' => $product->id]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }
}