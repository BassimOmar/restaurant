<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = MenuCategory::withCount('items')->orderBy('sort_order')->get();
        return view('dashboard.supervisor.menu_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.supervisor.menu_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:menu_categories',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        MenuCategory::create($validatedData);

        return redirect()->route('supervisor.menu_categories.index')->with('success', 'Category created.');
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
    public function edit(MenuCategory $menuCategory)
    {
        return view('dashboard.supervisor.menu_categories.edit', compact('menuCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuCategory $menuCategory)
    {
        $validatedData  = $request->validate([
            'name' => 'required|string|unique:menu_categories,name,' . $menuCategory->id,
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $menuCategory->update($validatedData);
        $menuCategory->update(['is_active' => $request->boolean('is_active')]);

        return redirect()->route('supervisor.menu_categories.index')->with('success', 'Category updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuCategory $menuCategory)
    {
        $menuCategory->delete();
        return redirect()->route('supervisor.menu_categories.index')->with('success', 'Category deleted.');
    }
    }
