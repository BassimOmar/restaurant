<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        // Item name: "Tomatoes", "Chicken Breast", "Olive Oil"
        
        $table->string('sku')->unique();
        // Stock Keeping Unit - unique identifier: "VEG-001"
        
        $table->text('description')->nullable();
        // Details about the item
        
        $table->string('unit');
        // Measurement unit: "kg", "liters", "pieces", "boxes"
        
        $table->decimal('current_quantity', 10, 2)->default(0);
        // How much in stock now
        
        $table->decimal('minimum_quantity', 10, 2)->default(0);
        // Alert threshold - reorder when below this
        
        $table->decimal('unit_cost', 10, 2);
        // Cost per unit (for inventory valuation)
        
        $table->foreignId('category_id')
              ->nullable()
              ->constrained('inventory_categories');
        // Which category (Vegetables, Meats, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
