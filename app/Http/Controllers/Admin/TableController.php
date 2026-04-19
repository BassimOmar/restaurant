<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::withCount('orders')->get();
        return view('dashboard.admin.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'table_number' => 'required|unique:tables',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:regular,private_dining',
            'location' => 'nullable|string',
        ]);


        Table::create($validatedData);
        return redirect()->route('admin.tables.index')->with('success', 'Table created.');
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
    public function edit(Table $table)
    {
        return view('dashboard.admin.tables.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Table $table)
    {
        $validatedData = $request->validate([
            'table_number' => 'required|unique:tables,table_number,' . $table->id,
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:regular,private_dining',
            'status' => 'required|in:available,occupied,reserved,maintenance',
            'location' => 'nullable|string',
        ]);

        $table->update($validatedData);

        return redirect()->route('admin.tables.index')->with('success', 'Table updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('admin.tables.index')->with('success', 'Table deleted.');
    }
}
