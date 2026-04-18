<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'menu_item_id', 'quantity', 
        'price', 'subtotal', 'special_instructions', 'status'
    ];

    
    // Each order item belongs to one order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Each order item is for one menu item
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
