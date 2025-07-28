<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'quantity', 'price'
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper methods
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function updateQuantity($quantity)
    {
        if ($quantity <= 0) {
            $this->delete();
            return;
        }

        $this->update([
            'quantity' => $quantity,
            'price' => $this->product->current_price
        ]);
    }

    public function isProductAvailable()
    {
        return $this->product && $this->product->isAvailable();
    }

    public function canFulfillQuantity()
    {
        return $this->product && $this->product->canPurchase($this->quantity);
    }
}