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
        Schema::create('order_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
              ->constrained()
              ->onDelete('cascade');
        // Which order
        
        $table->foreignId('discount_id')
              ->constrained()
              ->onDelete('cascade');
        // Which discount was applied
        
        $table->decimal('discount_amount', 10, 2);
        // Actual amount discounted (stored for history)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_discounts');
    }
};
