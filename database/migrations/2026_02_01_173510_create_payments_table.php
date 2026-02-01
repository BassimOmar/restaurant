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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
              ->constrained()
              ->onDelete('cascade');
        // Which order was paid
        
        $table->string('payment_number')->unique();
        // Unique payment reference: "PAY-20260201-001"
        
        $table->enum('payment_method', ['cash', 'card', 'mobile', 'other']);
        // How customer paid
        
        $table->decimal('amount', 10, 2);
        // Amount paid
        
        $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])
              ->default('pending');
        // Payment status
        
        $table->text('reference')->nullable();
        // Transaction ID, check number, etc.
        
        $table->foreignId('processed_by')
              ->constrained('users');
        // Which staff processed payment
        
        $table->timestamp('paid_at')->nullable();
        // When payment was completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
