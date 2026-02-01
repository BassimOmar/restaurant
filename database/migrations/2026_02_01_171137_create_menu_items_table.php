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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
              ->constrained('menu_categories')
              ->onDelete('cascade');
        // Links to menu category - if category deleted, delete items too
        
        $table->string('name');
        // Item name: "Caesar Salad", "Grilled Salmon"
        
        $table->text('description')->nullable();
        // Detailed description of the dish
        
        $table->decimal('price', 10, 2);
        // Price: 10 digits total, 2 after decimal (e.g., 12345678.99)
        
        $table->string('image')->nullable();
        // Path to item image
        
        $table->boolean('is_available')->default(true);
        // Mark as available/sold out without deletion
        
        $table->boolean('is_featured')->default(false);
        // Highlight special dishes
        
        $table->json('allergens')->nullable();
        // Store array of allergens: ["nuts", "dairy", "gluten"]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
