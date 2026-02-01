<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    protected $fillable = [
        'inventory_item_id', 'type', 'quantity', 
        'quantity_before', 'quantity_after', 'reason', 'user_id'
    ];

    // RELATIONSHIPS
    
    // Transaction belongs to one inventory item
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    // Transaction recorded by one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
