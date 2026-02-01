<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['table_number', 'capacity', 'type', 'status', 'location'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // One table can have many bookings (reservations)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Get the current active order for this table
    public function currentOrder()
    {
        return $this->hasOne(Order::class)
                    ->where('status', 'in_progress')
                    ->latest();
    }
}
