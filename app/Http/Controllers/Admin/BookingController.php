<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('table')
            ->orderByDesc('booking_date')
            ->paginate(20);

        return view('dashboard.admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Booking $booking, string $status)
    {
        $booking->update(['status' => $status]);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated.');
    }
}
