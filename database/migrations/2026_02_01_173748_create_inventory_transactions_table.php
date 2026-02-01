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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')
              ->constrained()
              ->onDelete('cascade');
        // Which item this transaction is for
        
        $table->enum('type', ['in', 'out', 'adjustment', 'waste']);
        // in = received stock
        // out = used in cooking
        // adjustment = manual correction
        // waste = spoiled/damaged
        
        $table->decimal('quantity', 10, 2);
        // Amount added/removed (positive or negative)
        
        $table->decimal('quantity_before', 10, 2);
        // Stock level before transaction
        
        $table->decimal('quantity_after', 10, 2);
        // Stock level after transaction
        
        $table->text('reason')->nullable();
        // Why: "Delivery received", "Spoiled", "Used for order #123"
        
        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');
        // Which staff recorded this transaction
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
