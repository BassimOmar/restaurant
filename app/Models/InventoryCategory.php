<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    use HasFactory;
     protected $fillable = ['name', 'description'];

    // RELATIONSHIPS
    
    // One category has many inventory items
    public function items()
    {
        return $this->hasMany(InventoryItem::class, 'category_id');
    }
}
