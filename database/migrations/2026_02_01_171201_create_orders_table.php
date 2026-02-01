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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
        // Unique identifier: "ORD-20260201-001"
        
        $table->foreignId('table_id')
              ->constrained()
              ->onDelete('cascade');
        // Which table this order is for
        
        $table->foreignId('waiter_id')
              ->constrained('users')
              ->onDelete('cascade');
        // Which waiter took this order
        
        $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])
              ->default('pending');
        // Order lifecycle status
        
        $table->decimal('subtotal', 10, 2)->default(0);
        // Sum of all items before discounts/tax
        
        $table->decimal('discount_amount', 10, 2)->default(0);
        // Total discount applied
        
        $table->decimal('tax_amount', 10, 2)->default(0);
        // Tax calculated
        
        $table->decimal('total', 10, 2)->default(0);
        // Final amount to pay
        
        $table->text('notes')->nullable();
        // Special instructions or notes
        
        $table->timestamp('completed_at')->nullable();
        // When order was completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
