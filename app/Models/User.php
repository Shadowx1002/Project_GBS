<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone',
        'is_admin', 'address_line_1', 'address_line_2',
        'city', 'state', 'postal_code', 'country'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    // Relationships
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wishlist()
    {
        return $this->hasMany(WishlistItem::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function isEligibleToPurchase()
    {
        return true; // All authenticated users can now purchase
    }
}