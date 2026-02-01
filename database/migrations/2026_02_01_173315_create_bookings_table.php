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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
        // Unique booking reference: "BK-20260201-001"
        
        $table->foreignId('table_id')
              ->constrained()
              ->onDelete('cascade');
        // Which table is reserved
        
        $table->string('customer_name');
        // Guest name
        
        $table->string('customer_phone');
        // Contact number
        
        $table->string('customer_email')->nullable();
        // Optional email
        
        $table->integer('guest_count');
        // Number of guests (must fit table capacity)
        
        $table->dateTime('booking_date');
        // When the reservation is for
        
        $table->integer('duration_minutes')->default(120);
        // How long table is reserved (default 2 hours)
        
        $table->enum('status', [
            'pending',      // Waiting confirmation
            'confirmed',    // Confirmed by restaurant
            'arrived',      // Customer arrived
            'completed',    // Finished dining
            'cancelled',    // Cancelled
            'no_show'       // Didn't show up
        ])->default('pending');
        
        $table->text('special_requests')->nullable();
        // "Birthday celebration", "Need highchair", etc.
        
        $table->foreignId('created_by')
              ->nullable()
              ->constrained('users');
        // Which staff member created the booking
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
