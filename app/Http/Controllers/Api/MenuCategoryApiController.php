<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;

class MenuCategoryApiController extends Controller
{
    /**
     * here i made api for menu categories
     * and the show is for showing the category with its items by{id}
     */
    public function index()
    {
        $categories = MenuCategory::where('is_active', true)
            ->withCount(['items' => fn($q) => $q->where('is_available', true)])
            ->orderBy('sort_order')
            ->get();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuCategory $category)
    {
       $category->load(['items' => fn($q) => $q->where('is_available', true)]);
        return response()->json($category); 
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
