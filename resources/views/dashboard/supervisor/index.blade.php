{{-- resources/views/dashboard/supervisor/index.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Supervisor Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Inventory Items</div>
        <div class="stat-value">{{ $stats['total_items'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Low Stock</div>
        <div class="stat-value danger">{{ $stats['low_stock'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Menu Items</div>
        <div class="stat-value">{{ $stats['total_menu_items'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Categories</div>
        <div class="stat-value">{{ $stats['total_categories'] }}</div>
    </div>
</div>

@if(!$lowStockItems->isEmpty())
<div class="table-wrap">
    <div class="table-header">
        <h3 style="color:var(--danger);">⚠️ Low Stock Alert</h3>
    </div>
    <table>
        <thead>
            <tr><th>Item</th><th>Category</th><th>Current</th><th>Minimum</th><th>Unit</th><th>Action</th></tr>
        </thead>
        <tbody>
            @foreach($lowStockItems as $item)
            <tr>
                <td><strong>{{ $item->name }}</strong></td>
                <td>{{ $item->category?->name ?? '—' }}</td>
                <td style="color:var(--danger);">{{ $item->current_quantity }}</td>
                <td>{{ $item->minimum_quantity }}</td>
                <td>{{ $item->unit }}</td>
                <td><a href="{{ route('supervisor.inventory.edit', $item) }}" class="btn btn-primary btn-sm">Restock</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="table-wrap" style="padding:40px; text-align:center;">
    <span style="color:var(--success); font-size:1.1rem;">✓ All inventory levels are healthy.</span>
</div>
@endif
@endsection