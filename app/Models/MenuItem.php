<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
     protected $fillable = [
        'category_id', 'name', 'description', 'price', 
        'image', 'is_available', 'is_featured', 'allergens'
    ];
    
    protected $casts = [
        'allergens' => 'array', // Auto convert JSON to/from array
        'price' => 'decimal:2', // Always 2 decimal places
    ];
    

    public function category()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    // One menu item can appear in many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Many-to-many: Menu items use many inventory items
    public function inventoryItems()
    {
        return $this->belongsToMany(InventoryItem::class, 'menu_item_inventory')
                    ->withPivot('quantity_needed');
        // withPivot lets us access the quantity_needed column
    }
}
