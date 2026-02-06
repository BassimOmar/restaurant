<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\{Booking, Table, Customer};
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('website.booking');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email',
            'guest_count' => 'required|integer|min:1|max:50',
            'booking_date' => 'required|date|after:now',
            'duration_minutes' => 'nullable|integer|in:60,90,120,180',
            'special_requests' => 'nullable|string',
            'is_private_dining' => 'nullable|boolean',
        ]);

        // Find available table
        $type = $request->boolean('is_private_dining') ? 'private_dining' : 'regular';

        $table = Table::where('type', $type)
            ->where('capacity', '>=', $request->guest_count)
            ->where('status', 'available')
            ->first();

        // If no specific type available, try any available table with enough capacity
        if (!$table) {
            $table = Table::where('capacity', '>=', $request->guest_count)
                ->where('status', 'available')
                ->first();
        }

        if (!$table) {
            return redirect()->back()->with('error', 'No tables available for that date and guest count. Please try another time.');
        }

        // Create or find customer (CRM)
        $customer = Customer::firstOrCreate(
            ['phone' => $request->customer_phone],
            [
                'name' => $request->customer_name,
                'email' => $request->customer_email,
            ]
        );

        // Update customer info if changed
        $customer->update([
            'name' => $request->customer_name,
            'email' => $request->customer_email ?? $customer->email,
            'total_visits' => $customer->total_visits + 1,
            'last_visit' => now(),
        ]);

        // Create booking
        Booking::create([
            'booking_number' => 'BK-' . date('Ymd') . '-' . str_pad(Booking::count() + 1, 4, '0', STR_PAD_LEFT),
            'table_id' => $table->id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'guest_count' => $request->guest_count,
            'booking_date' => $request->booking_date,
            'duration_minutes' => $request->duration_minutes ?? 120,
            'status' => 'confirmed',
            'special_requests' => $request->special_requests,
        ]);

        return redirect()->route('website.booking')->with('success', 'Booking confirmed! Table ' . $table->table_number . ' is reserved for you.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
