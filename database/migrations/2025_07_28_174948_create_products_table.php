<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('specifications')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('sku')->unique();
            $table->integer('stock_quantity')->default(0);
            $table->boolean('manage_stock')->default(true);
            $table->boolean('in_stock')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('active'); // active, inactive, out_of_stock
            $table->string('brand')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('firing_range')->nullable();
            $table->string('build_material')->nullable();
            $table->integer('views')->default(0);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['status', 'is_featured']);
            $table->index(['category_id', 'status']);
            $table->index(['name']);
            $table->index(['brand']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};