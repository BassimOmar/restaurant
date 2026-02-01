<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'table_id', 'waiter_id', 'status', 
        'subtotal', 'discount_amount', 'tax_amount', 'total', 
        'notes', 'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime', // Auto convert to Carbon date object
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Order belongs to one waiter (User)
    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    // Order has many order items (individual dishes)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Order has one payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'order_discounts')
                    ->withPivot('discount_amount');
    }
}
