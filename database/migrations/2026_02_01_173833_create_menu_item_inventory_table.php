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
        Schema::create('menu_item_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')
              ->constrained()
              ->onDelete('cascade');
        // Which menu item
        
        $table->foreignId('inventory_item_id')
              ->constrained()
              ->onDelete('cascade');
        // Which inventory item (ingredient)
        
        $table->decimal('quantity_needed', 10, 2);
        // How much of this ingredient per menu item
        // Example: Caesar Salad needs 0.2 kg of lettuce
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_inventory');
    }
};
