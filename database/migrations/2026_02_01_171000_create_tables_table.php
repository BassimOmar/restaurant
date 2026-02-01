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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_number')->unique();
        // Table identifier like "T01", "T02" - must be unique
        
            $table->integer('capacity');
        // How many guests can sit (2, 4, 6, etc.)
        
            $table->enum('type', ['regular', 'private_dining'])->default('regular');
        // Table type: regular dining area or private room
        
            $table->enum('status', ['available', 'occupied', 'reserved', 'maintenance'])
              ->default('available');
        // Current table status
        
         $table->string('location')->nullable();
        // Optional: "Section A", "Patio", "Window Side"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
