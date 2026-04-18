<?php

namespace App\Http\Controllers\Supervisor;
use App\Models\MenuItem;
use App\Models\MenuCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = MenuItem::with('category')->orderBy('category_id')->get();
        $categories = MenuCategory::all();
        return view('dashboard.supervisor.menu_items.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = MenuCategory::where('is_active', true)->get();
        return view('dashboard.supervisor.menu_items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'allergens' => 'nullable|array',
        ]);


        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu', 'public');
        }

        MenuItem::create($data);

        return redirect()->route('supervisor.menu_items.index')->with('success', 'Menu item created.');
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
    public function edit(MenuItem $menuItem)
    {
        $categories = MenuCategory::where('is_active', true)->get();
        return view('dashboard.supervisor.menu_items.edit', compact('menuItem', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
         $request->validate([
            'category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'allergens' => 'nullable|array',
        ]);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu', 'public');
        }

        $menuItem->update($data);
        $menuItem->update([
            'is_available' => $request->boolean('is_available'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('supervisor.menu_items.index')->with('success', 'Menu item updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return redirect()->route('supervisor.menu_items.index')->with('success', 'Menu item deleted.');
    }
}
