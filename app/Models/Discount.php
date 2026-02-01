<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'type', 'value',
        'minimum_order_amount', 'usage_limit', 'used_count',
        'is_active', 'valid_from', 'valid_until'
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    // RELATIONSHIPS
    
    // Many-to-many: Discount can be applied to many orders
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_discounts')
                    ->withPivot('discount_amount');
    }

    // HELPER METHODS
    
    // Check if discount is currently valid
    public function isValid()
    {
        if (!$this->is_active) return false;
        if ($this->valid_from && now()->lt($this->valid_from)) return false;
        if ($this->valid_until && now()->gt($this->valid_until)) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }

    // Calculate discount amount for an order
    public function calculateDiscount($orderAmount)
    {
        if ($this->type === 'percentage') {
            return $orderAmount * ($this->value / 100);
        }
        return $this->value; // fixed amount
    }
}
