<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $items = MenuItem::where('is_available', true)
            ->with('category')
            ->orderBy('category_id')
            ->get();

            return response()->json($items);
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
    public function show(MenuItem $menuItem)
    {
        $menuItem->load('category');
        return response()->json($menuItem);
    }

    public function featured()
    {
        $items = MenuItem::where('is_available', true)
        ->where('is_featured', true)
        ->with('category')
        ->get();
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
