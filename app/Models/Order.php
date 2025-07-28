<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'status', 'subtotal', 'tax_amount',
        'shipping_amount', 'total_amount', 'currency', 'payment_status',
        'payment_method', 'payment_id', 'shipping_first_name', 'shipping_last_name',
        'shipping_email', 'shipping_phone', 'shipping_address_line_1',
        'shipping_address_line_2', 'shipping_city', 'shipping_state',
        'shipping_postal_code', 'shipping_country', 'notes', 'shipped_at',
        'delivered_at'
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'shipping_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'GB-' . date('Y') . '-' . strtoupper(uniqid());
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Helper methods
    public function getShippingFullNameAttribute()
    {
        return $this->shipping_first_name . ' ' . $this->shipping_last_name;
    }

    public function getShippingFullAddressAttribute()
    {
        $address = $this->shipping_address_line_1;
        if ($this->shipping_address_line_2) {
            $address .= ', ' . $this->shipping_address_line_2;
        }
        $address .= ', ' . $this->shipping_city . ', ' . $this->shipping_state;
        $address .= ' ' . $this->shipping_postal_code . ', ' . $this->shipping_country;
        
        return $address;
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    public function canBeShipped()
    {
        return $this->status === 'processing' && $this->payment_status === 'paid';
    }

    public function markAsShipped()
    {
        $this->update([
            'status' => 'shipped',
            'shipped_at' => now()
        ]);
    }

    public function markAsDelivered()
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now()
        ]);
    }

    public function calculateTotals()
    {
        $subtotal = $this->items->sum('total_price');
        $taxRate = 0.08; // 8% tax rate (configurable)
        $taxAmount = $subtotal * $taxRate;
        $shippingAmount = $this->calculateShipping($subtotal);
        
        $this->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_amount' => $shippingAmount,
            'total_amount' => $subtotal + $taxAmount + $shippingAmount
        ]);
    }

    private function calculateShipping($subtotal)
    {
        // Free shipping over $100
        if ($subtotal >= 100) {
            return 0;
        }
        
        return 9.99; // Standard shipping rate
    }
    public function generateTrackingNumber()
{
    $this->update([
        'tracking_number' => 'GB' . date('Y') . str_pad($this->id, 6, '0', STR_PAD_LEFT)
    ]);
}

public function getStatusBadgeAttribute()
{
    $badges = [
        'pending' => 'status-pending',
        'processing' => 'status-processing', 
        'shipped' => 'status-shipped',
        'delivered' => 'status-delivered',
        'cancelled' => 'status-cancelled'
    ];
    
    return $badges[$this->status] ?? 'badge-info';
}

public function getEstimatedDeliveryAttribute()
{
    if ($this->shipped_at) {
        return $this->shipped_at->addDays(3)->format('M j, Y');
    }
    
    return $this->created_at->addDays(7)->format('M j, Y');
}
}