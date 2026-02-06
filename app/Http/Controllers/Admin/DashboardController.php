<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order, Payment, Table, Customer, ActivityLog};
class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders_today' => Order::whereDate('created_at', today())->count(),
            'revenue_today' => Payment::whereDate('created_at', today())
                ->where('status', 'completed')->sum('amount'),
            'total_tables' => Table::count(),
            'occupied_tables' => Table::where('status', 'occupied')->count(),
            'total_customers' => Customer::count(),
            'vip_customers' => Customer::where('is_vip', true)->count(),
        ];

        $recentOrders = Order::with('table', 'waiter')
            ->latest()
            ->take(10)
            ->get();

        $recentLogs = ActivityLog::with('user')
            ->latest()
            ->take(15)
            ->get();

        return view('dashboard.admin.index', compact('stats', 'recentOrders', 'recentLogs'));
    }
    }
