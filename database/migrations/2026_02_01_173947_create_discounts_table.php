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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
        // Discount code: "SUMMER20", "BIRTHDAY50"
        
        $table->string('name');
        // Display name: "Summer Sale", "Birthday Discount"
        
        $table->text('description')->nullable();
        // Details about the discount
        
        $table->enum('type', ['percentage', 'fixed_amount']);
        // percentage: 20% off
        // fixed_amount: $5 off
        
        $table->decimal('value', 10, 2);
        // The discount value (20 for 20%, or 5.00 for $5)
        
        $table->decimal('minimum_order_amount', 10, 2)->default(0);
        // Must spend at least this much to use discount
        
        $table->integer('usage_limit')->nullable();
        // Max times this can be used (null = unlimited)
        
        $table->integer('used_count')->default(0);
        // How many times it's been used
        
        $table->boolean('is_active')->default(true);
        // Enable/disable without deleting
        
        $table->dateTime('valid_from')->nullable();
        // When discount becomes valid
        
        $table->dateTime('valid_until')->nullable();
        // When discount expires
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
