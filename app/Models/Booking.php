<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number', 'table_id', 'customer_name', 'customer_phone', 
        'customer_email', 'guest_count', 'booking_date', 'duration_minutes',
        'status', 'special_requests', 'created_by'
    ];

    protected $casts = [
        'booking_date' => 'datetime', // Auto convert to Carbon
    ];

    // RELATIONSHIPS
    
    // Booking is for one table
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Booking created by one user (staff member)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
