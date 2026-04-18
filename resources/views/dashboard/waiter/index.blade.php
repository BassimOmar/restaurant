@extends('layouts.dashboard')
@section('page_title', 'My Dashboard')

@section('content')

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Active Orders</div>
        <div class="stat-value warning">{{ $stats['my_active_orders'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Completed Today</div>
        <div class="stat-value success">{{ $stats['my_completed_today'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Available Tables</div>
        <div class="stat-value">{{ $stats['available_tables'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Occupied Tables</div>
        <div class="stat-value danger">{{ $stats['occupied_tables'] }}</div>
    </div>
</div>

<!-- Active Orders -->
<div class="table-wrap">
    <div class="table-header">
        <h3>My Active Orders</h3>
        <a href="{{ route('waiter.orders.create') }}" class="btn btn-primary btn-sm">+ New Order</a>
    </div>

    @if($activeOrders->isEmpty())
        <div style="padding:40px; text-align:center; color:var(--text-muted);">No active orders. Start a new one!</div>
    @else
        @foreach($activeOrders as $order)
        <div style="padding:20px 22px; border-bottom:1px solid var(--card-border);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <strong style="font-size:0.95rem;">{{ $order->order_number }}</strong>
                    <span class="badge {{ $order->status }}">{{ str_replace('_', ' ', $order->status) }}</span>
                    <span style="font-size:0.78rem; color:var(--text-muted);">Table {{ $order->table->table_number }}</span>
                </div>
                <div style="display:flex; gap:8px;">
                    <!-- Status Actions -->
                    @if($order->status === 'pending')
                        <form action="{{ route('waiter.orders.start', $order) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-info btn-sm">Start</button>
                        </form>
                    @endif
                    @if($order->status === 'in_progress')
                        <form action="{{ route('waiter.orders.complete', $order) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Complete</button>
                        </form>
                    @endif
                    @if(!$order->payment || $order->payment->status !== 'completed')
                        <a href="{{ route('waiter.payments.create') }}?order={{ $order->id }}" class="btn btn-primary btn-sm">💳 Pay</a>
                    @endif
                    <form action="{{ route('waiter.orders.cancel', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Cancel order?')">Cancel</button>
                    </form>
                </div>
            </div>

            <!-- Order Items -->
            <div style="padding-left:10px;">
                @foreach($order->items as $item)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 0; font-size:0.85rem;">
                    <div>
                        <span style="color:var(--text-muted);">{{ $item->quantity }}x</span>
                        {{ $item->menuItem->name }}
                        @if($item->special_instructions)
                            <span style="font-size:0.75rem; color:var(--warning);"> — {{ $item->special_instructions }}</span>
                        @endif
                    </div>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <span class="badge {{ $item->status }}" style="font-size:0.7rem;">{{ $item->status }}</span>
                        <span style="color:var(--text-muted);">${{ number_format($item->subtotal, 2) }}</span>
                    </div>
                </div>
                @endforeach
                <div style="border-top:1px solid rgba(255,255,255,0.06); margin-top:8px; padding-top:8px; display:flex; justify-content:flex-end; gap:20px; font-size:0.83rem;">
                    @if($order->discount_amount > 0)
                        <span style="color:var(--success);">Discount: -${{ number_format($order->discount_amount, 2) }}</span>
                    @endif
                    <span style="color:var(--text-muted);">Tax: ${{ number_format($order->tax_amount, 2) }}</span>
                    <strong style="color:#fff;">Total: ${{ number_format($order->total, 2) }}</strong>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

@endsection