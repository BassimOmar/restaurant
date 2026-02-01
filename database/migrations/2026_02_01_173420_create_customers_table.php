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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        // Customer full name
        
        $table->string('phone')->unique();
        // Primary contact - must be unique
        
        $table->string('email')->unique()->nullable();
        // Email address
        
        $table->date('birthday')->nullable();
        // For birthday promotions
        
        $table->text('notes')->nullable();
        // Preferences: "Allergic to shellfish", "Likes window seats"
        
        $table->integer('total_visits')->default(0);
        // Track how many times they've visited
        
        $table->decimal('total_spent', 10, 2)->default(0);
        // Lifetime spending
        
        $table->timestamp('last_visit')->nullable();
        // Most recent visit date
        
        $table->boolean('is_vip')->default(false);
        // Mark special/important customers
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
