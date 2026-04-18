@extends('layouts.dashboard')
@section('page_title', 'My Orders')
@section('topbar_actions')
    <a href="{{ route('waiter.orders.create') }}" class="btn btn-primary">+ New Order</a>
@endsection

@section('content')
<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Order #</th><th>Table</th><th>Items</th><th>Total</th><th>Status</th><th>Payment</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>{{ $order->table->table_number }}</td>
                <td>{{ $order->items->count() }} item{{ $order->items->count() > 1 ? 's' : '' }}</td>
                <td>${{ number_format($order->total, 2) }}</td>
                <td><span class="badge {{ $order->status }}">{{ str_replace('_', ' ', $order->status) }}</span></td>
                <td>
                    @if($order->payment && $order->payment->status === 'completed')
                        <span class="badge completed">Paid</span>
                    @else
                        <span class="badge pending">Unpaid</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
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
                        @if(in_array($order->status, ['pending', 'in_progress']))
                            <form action="{{ route('waiter.orders.cancel', $order) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Cancel?')">Cancel</button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            <tr><td colspan="7" style="text-align:center; color:var(--text-muted); padding:30px;">No orders yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection