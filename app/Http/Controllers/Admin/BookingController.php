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
    
    public function confirm(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        return redirect()->back()->with('success', 'Booking confirmed successfully.');
    }

    /**
     * Mark the guest as arrived
     */
    public function arrived(Booking $booking)
    {
        $booking->update(['status' => 'arrived']);
        return redirect()->back()->with('success', 'Guest marked as arrived.');
    }

    /**
     * Cancel the booking
     */
    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Booking has been cancelled.');
    }

    public function updateStatus(Booking $booking, string $status)
    {
        $booking->update(['status' => $status]);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated.');
    }
}
