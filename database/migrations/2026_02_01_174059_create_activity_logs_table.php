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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
              ->nullable()
              ->constrained()
              ->onDelete('set null');
        // Who performed the action (null if user deleted)
        
        $table->string('action');
        // Action type: "created", "updated", "deleted", "logged_in"
        
        $table->string('model_type');
        // What was affected: "Order", "Table", "MenuItem"
        
        $table->unsignedBigInteger('model_id')->nullable();
        // ID of the affected record
        
        $table->text('description');
        // Human-readable description: "Updated Order #123"
        
        $table->json('old_values')->nullable();
        // Before changes (for updates)
        
        $table->json('new_values')->nullable();
        // After changes (for updates)
        
        $table->string('ip_address')->nullable();
        // User's IP address
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
