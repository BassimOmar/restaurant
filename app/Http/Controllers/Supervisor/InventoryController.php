<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = InventoryItem::with('category')
            ->orderBy('name')
            ->get();

        $categories = InventoryCategory::all();

        return view('dashboard.supervisor.inventory.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = InventoryCategory::all();
        return view('dashboard.supervisor.inventory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'sku' => 'required|unique:inventory_items',
            'unit' => 'required|string',
            'current_quantity' => 'required|numeric|min:0',
            'minimum_quantity' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:inventory_categories,id',
        ]);

        InventoryItem::create($validatedData);

        return redirect()->route('supervisor.inventory.index')->with('success', 'Item added.');
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
    public function edit(InventoryItem $inventoryItem)
    {
        $categories = InventoryCategory::all();
        return view('dashboard.supervisor.inventory.edit', compact('inventoryItem', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $request->validate([
            'name' => 'required|string',
            'sku' => 'required|unique:inventory_items,sku,' . $inventoryItem->id,
            'unit' => 'required|string',
            'minimum_quantity' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:inventory_categories,id',
        ]);

        $inventoryItem->update($request->validated());

        return redirect()->route('supervisor.inventory.index')->with('success', 'Item updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();
        return redirect()->route('supervisor.inventory.index')->with('success', 'Item deleted.');
    }

    public function adjustStock(Request $request, InventoryItem $inventoryItem)
    {
        $request->validate([
            'type' => 'required|in:in,out,adjustment,waste',
            'quantity' => 'required|numeric|min:0',
            'reason' => 'nullable|string',
        ]);

        $before = $inventoryItem->current_quantity;
        $qty = $request->type === 'in' ? $request->quantity : -$request->quantity;
        $after = $before + $qty;

        if ($after < 0) {
            return redirect()->back()->with('error', 'Not enough stock.');
        }

        $inventoryItem->update(['current_quantity' => $after]);

        InventoryTransaction::create([
            'inventory_item_id' => $inventoryItem->id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'quantity_before' => $before,
            'quantity_after' => $after,
            'reason' => $request->reason,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('supervisor.inventory.index')->with('success', 'Stock adjusted.');
    }
}
