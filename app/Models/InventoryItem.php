<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'name', 'sku', 'description', 'unit', 'current_quantity',
        'minimum_quantity', 'unit_cost', 'category_id'
    ];

    // RELATIONSHIPS
    
    // Item belongs to one category
    public function category()
    {
        return $this->belongsTo(InventoryCategory::class);
    }

    // Item has many transactions (stock movements)
    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    // Many-to-many: Used in many menu items
    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class, 'menu_item_inventory')
                    ->withPivot('quantity_needed');
    }

    // HELPER METHOD
    public function isLowStock()
    {
        return $this->current_quantity <= $this->minimum_quantity;
    }
}
