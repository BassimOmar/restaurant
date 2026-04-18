@extends('layouts.dashboard')

@section('page_title', 'Admin Dashboard')
@section('breadcrumb',)

@section('content')

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Orders Today</div>
        <div class="stat-value">{{ $stats['total_orders_today'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Revenue Today</div>
        <div class="stat-value gold">${{ number_format($stats['revenue_today'], 2) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Tables</div>
        <div class="stat-value">{{ $stats['total_tables'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Occupied</div>
        <div class="stat-value danger">{{ $stats['occupied_tables'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Customers</div>
        <div class="stat-value">{{ $stats['total_customers'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">VIP Members</div>
        <div class="stat-value gold">{{ $stats['vip_customers'] }}</div>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1.4fr 1fr; gap: 20px;">

    <div class="table-wrap">
        <div class="table-header">
            <h3>Recent Orders</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Table</th>
                    <th>Waiter</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order){
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->table->table_number }}</td>
                    <td>{{ $order->waiter->name }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td><span class="badge {{ $order->status }}">{{ $order->status }}</span></td>
                </tr>
                <tr><td colspan="5" style="color: var(--text-muted); text-align:center; padding: 30px;">No orders today.</td></tr>}
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h3>Activity Log</h3>
            <a href="{{ route('admin.logs.index') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        <table>
            <thead>
                <tr><th>Action</th><th>By</th><th>Time</th></tr>
            </thead>
            <tbody>
                @foreach($recentLogs as $log){
                <tr>
                    <td style="font-size:0.82rem;">{{ $log->description }}</td>
                    <td>{{ $log->user?->name ?? 'System' }}</td>
                    <td style="color: var(--text-muted); font-size:0.78rem;">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                <tr><td colspan="3" style="color: var(--text-muted); text-align:center; padding:30px;">No activity.</td></tr>}
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection