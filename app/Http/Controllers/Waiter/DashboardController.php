<?php

namespace App\Http\Controllers\Waiter;

use App\Http\Controllers\Controller;
use App\Models\{Order, Table};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'my_active_orders' => Order::where('waiter_id', auth()->id())
                ->whereIn('status', ['pending', 'in_progress'])->count(),
            'my_completed_today' => Order::where('waiter_id', auth()->id())
                ->where('status', 'completed')
                ->whereDate('completed_at', today())->count(),
            'available_tables' => Table::where('status', 'available')->count(),
            'occupied_tables' => Table::where('status', 'occupied')->count(),
        ];

        $activeOrders = Order::where('waiter_id', auth()->id())
            ->whereIn('status', ['pending', 'in_progress'])
            ->with('table', 'items.menuItem')
            ->latest()
            ->get();

        return view('dashboard.waiter.index', compact('stats', 'activeOrders'));
    }
}
