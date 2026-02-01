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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
              ->constrained()
              ->onDelete('cascade');
        // Which order this item belongs to
        
        $table->foreignId('menu_item_id')
              ->constrained()
              ->onDelete('cascade');
        // Which menu item was ordered
        
        $table->integer('quantity');
        // How many of this item
        
        $table->decimal('price', 10, 2);
        // Price per item (stored to preserve historical pricing)
        
        $table->decimal('subtotal', 10, 2);
        // quantity * price
        
        $table->text('special_instructions')->nullable();
        // "No onions", "Extra sauce", etc.
        
        $table->enum('status', ['pending', 'preparing', 'ready', 'served'])
              ->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
