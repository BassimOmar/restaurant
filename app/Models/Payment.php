<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'payment_number', 'payment_method', 
        'amount', 'status', 'reference', 'processed_by', 'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    
    // Payment belongs to one order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Payment processed by one user (cashier/waiter)
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
