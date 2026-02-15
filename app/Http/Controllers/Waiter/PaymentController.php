<?php

namespace App\Http\Controllers\Waiter;

use App\Http\Controllers\Controller;
use App\Models\{Order, Payment, ActivityLog};
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $order = Order::with(['items.menuItem', 'table', 'discounts', 'waiter'])
            ->findOrFail($request->order);

        return view('waiter.payments.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:cash,card,mobile,other',
            'reference' => 'nullable|string',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Check if already paid
        if ($order->payment && $order->payment->status === 'completed') {
            return redirect()->back()->with('error', 'Order already paid.');
        }

        Payment::create([
            'order_id' => $order->id,
            'payment_number' => 'PAY-' . date('Ymd') . '-' . str_pad(Payment::count() + 1, 4, '0', STR_PAD_LEFT),
            'payment_method' => $request->payment_method,
            'amount' => $order->total,
            'status' => 'completed',
            'reference' => $request->reference,
            'processed_by' => auth()->id(),
            'paid_at' => now(),
        ]);

        $order->update(['status' => 'completed', 'completed_at' => now()]);
        $order->table()->update(['status' => 'available']);

        $order->load('payment');

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Payment',
            'model_id' => $order->payment->id,
            'description' => 'Payment for order ' . $order->order_number . ' via ' . $request->payment_method,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('waiter.orders.index')->with('success', 'Payment processed.');
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
