<?php

namespace App\Http\Controllers\Waiter;

use App\Http\Controllers\Controller;
use App\Models\{Order, OrderItem, MenuItem, Table, Discount, ActivityLog};
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('waiter_id', auth()->id())
            ->with('table', 'items.menuItem')
            ->latest()
            ->get();

        $tables = Table::where('status', 'occupied')->get();

        return view('dashboard.waiter.orders.index', compact('orders', 'tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tables = Table::where('status', 'available')->orWhere('status', 'occupied')->get();
        $menuItems = MenuItem::where('is_available', true)->with('category')->get();
        $discounts = Discount::where('is_active', true)->get();

        return view('dashboard.waiter.orders.create', compact('tables', 'menuItems', 'discounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.special_instructions' => 'nullable|string',
            'discount_id' => 'nullable|exists:discounts,id',
            'notes' => 'nullable|string',
        ]);

        // Calculate subtotal
        $subtotal = 0;
        foreach ($request->items as $item) {
            $menuItem = MenuItem::find($item['menu_item_id']);
            $subtotal += $menuItem->price * $item['quantity'];
        }

        // Apply discount if provided
        $discountAmount = 0;
        $discount = null;
        if ($request->discount_id) {
            $discount = Discount::find($request->discount_id);
            if ($discount && $discount->isValid() && $subtotal >= $discount->minimum_order_amount) {
                $discountAmount = $discount->calculateDiscount($subtotal);
            }
        }

        $tax = ($subtotal - $discountAmount) * 0.10; // 10% tax
        $total = $subtotal - $discountAmount + $tax;

        // Create order
        $order = Order::create([
            'order_number' => 'ORD-' . date('Ymd') . '-' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT),
            'table_id' => $request->table_id,
            'waiter_id' => auth()->id(),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'tax_amount' => $tax,
            'total' => $total,
            'notes' => $request->notes,
        ]);

        // Create order items
        foreach ($request->items as $item) {
            $menuItem = MenuItem::find($item['menu_item_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['menu_item_id'],
                'quantity' => $item['quantity'],
                'price' => $menuItem->price,
                'subtotal' => $menuItem->price * $item['quantity'],
                'special_instructions' => $item['special_instructions'] ?? null,
            ]);
        }

        // Attach discount if applied
        if ($discount && $discountAmount > 0) {
            $order->discounts()->attach($discount->id, ['discount_amount' => $discountAmount]);
            $discount->increment('used_count');
        }

        // Update table status
        Table::find($request->table_id)->update(['status' => 'occupied']);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Order',
            'model_id' => $order->id,
            'description' => 'Order ' . $order->order_number . ' created',
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('waiter.orders.index')->with('success', 'Order created.');
    }

    public function updateItemStatus(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,served',
        ]);

        $orderItem->update(['status' => $request->status]);

        return redirect()->route('waiter.orders.index')->with('success', 'Item status updated.');
    }

    public function cancel(Order $order)
{
    // Prevent canceling already completed, paid, or canceled orders
    if (in_array($order->status, ['completed', 'cancelled'])) {
        return redirect()->back()->with('error', 'This order cannot be cancelled in its current state.');
    }

    // 1. Update the order status
    $order->update(['status' => 'cancelled']);

    // 2. Free up the table so it can be used by others
    if ($order->table) {
        $order->table->update(['status' => 'available']);
    }

    // 3. Log the activity (Following your existing pattern)
    ActivityLog::create([
        'user_id' => auth()->id(),
        'action' => 'cancelled',
        'model_type' => 'Order',
        'model_id' => $order->id,
        'description' => 'Order ' . $order->order_number . ' was cancelled',
        'ip_address' => request()->ip(),
    ]);

    return redirect()->route('waiter.orders.index')->with('success', 'Order cancelled successfully.');
}

public function start(Order $order)
{
    $order->update(['status' => 'in_progress']);
    return redirect()->back()->with('success', 'Order started.');
}

public function complete(Order $order)
{
    $order->update(['status' => 'completed']);
    // Optional: free the table here if you don't wait for payment
    // $order->table->update(['status' => 'available']); 
    return redirect()->back()->with('success', 'Order completed.');
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
