<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'phone', 'email', 'birthday', 'notes',
        'total_visits', 'total_spent', 'last_visit', 'is_vip'
    ];

    protected $casts = [
        'birthday' => 'date',
        'last_visit' => 'datetime',
    ];

    // RELATIONSHIPS
    
    // Customer can have many bookings (matched by phone)
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_phone', 'phone');
    }

    // Customer can have many orders (matched by phone)
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_phone', 'phone');
    }
}
