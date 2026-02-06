<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\{InventoryItem, MenuItem, MenuCategory};

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_items' => InventoryItem::count(),
            'low_stock' => InventoryItem::where('current_quantity', '<=', 
                DB::raw('minimum_quantity'))->count(),
            'total_menu_items' => MenuItem::count(),
            'total_categories' => MenuCategory::count(),
        ];

        $lowStockItems = InventoryItem::with('category')
            ->where('current_quantity', '<=', DB::raw('minimum_quantity'))
            ->get();

        return view('dashboard.supervisor.index', compact('stats', 'lowStockItems'));
    }
}
