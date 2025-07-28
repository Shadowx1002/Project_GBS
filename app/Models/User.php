<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'date_of_birth',
        'is_verified', 'is_admin', 'address_line_1', 'address_line_2',
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
            'date_of_birth' => 'date',
            'is_verified' => 'boolean',
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

    public function verification()
    {
        return $this->hasOne(UserVerification::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isVerified()
    {
        return $this->is_verified;
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    public function isEligibleToPurchase()
    {
        return $this->getAgeAttribute() >= 18 && $this->is_verified;
    }
}