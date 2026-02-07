{{-- resources/views/dashboard/waiter/payments/create.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Process Payment')

@section('styles')
    .payment-layout { display: grid; grid-template-columns: 1.2fr 1fr; gap: 24px; }
    .receipt-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 8px; }
    .receipt-header { padding: 20px 24px; border-bottom: 1px solid var(--card-border); display: flex; justify-content: space-between; align-items: center; }
    .receipt-header h3 { font-size: 0.95rem; }
    .receipt-body { padding: 20px 24px; }
    .receipt-item { display: flex; justify-content: space-between; padding: 8px 0; font-size: 0.87rem; border-bottom: 1px solid rgba(255,255,255,0.04); }
    .receipt-item:last-child { border: none; }
    .receipt-item .item-left { color: var(--text); }
    .receipt-item .item-right { color: var(--text-muted); }
    .receipt-totals { margin-top: 16px; padding-top: 14px; border-top: 1px solid rgba(255,255,255,0.1); }
    .receipt-totals .receipt-item { font-size: 0.83rem; }
    .receipt-totals .receipt-item.grand { font-size: 1.1rem; font-weight: 600; color: #fff; padding-top: 10px; margin-top: 6px; border-top: 1px solid rgba(255,255,255,0.08); }

    .payment-method-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 20px; }
    .pay-method {
        padding: 18px; border-radius: 6px;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.03);
        cursor: pointer; text-align: center;
        transition: all 0.2s;
    }
    .pay-method:hover { border-color: var(--gold); }
    .pay-method.selected { border-color: var(--gold); background: rgba(201,168,76,0.08); }
    .pay-method .method-icon { font-size: 1.6rem; margin-bottom: 6px; }
    .pay-method .method-label { font-size: 0.82rem; color: var(--text); }
@endsection

@section('content')

<div class="payment-layout">
    <!-- Receipt -->
    <div class="receipt-card">
        <div class="receipt-header">
            <h3>Receipt</h3>
            <span class="badge pending">Unpaid</span>
        </div>
        <div class="receipt-body">
            <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:14px;">
                Order: {{ $order->order_number }} &nbsp;|&nbsp; Table: {{ $order->table->table_number }} &nbsp;|&nbsp; {{ $order->created_at->format('M d, g:i A') }}
            </div>

            @foreach($order->items as $item)
            <div class="receipt-item">
                <span class="item-left">{{ $item->quantity }}x {{ $item->menuItem->name }}</span>
                <span class="item-right">${{ number_format($item->subtotal, 2) }}</span>
            </div>
            @endforeach

            <div class="receipt-totals">
                <div class="receipt-item">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="receipt-item" style="color:var(--success);">
                    <span>Discount</span>
                    <span>-${{ number_format($order->discount_amount, 2) }}</span>
                </div>
                @endif
                <div class="receipt-item">
                    <span>Tax</span>
                    <span>${{ number_format($order->tax_amount, 2) }}</span>
                </div>
                <div class="receipt-item grand">
                    <span>Total</span>
                    <span style="color:var(--gold);">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Form -->
    <div>
        <div class="table-wrap" style="padding:24px;">
            <h3 style="margin-bottom:18px; font-size:0.95rem;">Payment Method</h3>

            <form action="{{ route('waiter.payments.store', $order) }}" method="POST">
                @csrf
                <div class="payment-method-grid">
                    <label class="pay-method selected" onclick="selectMethod(this, 'cash')">
                        <input type="radio" name="payment_method" value="cash" checked style="display:none;" />
                        <div class="method-icon">💵</div>
                        <div class="method-label">Cash</div>
                    </label>
                    <label class="pay-method" onclick="selectMethod(this, 'card')">
                        <input type="radio" name="payment_method" value="card" style="display:none;" />
                        <div class="method-icon">💳</div>
                        <div class="method-label">Card</div>
                    </label>
                    <label class="pay-method" onclick="selectMethod(this, 'mobile')">
                        <input type="radio" name="payment_method" value="mobile" style="display:none;" />
                        <div class="method-icon">📱</div>
                        <div class="method-label">Mobile Pay</div>
                    </label>
                    <label class="pay-method" onclick="selectMethod(this, 'other')">
                        <input type="radio" name="payment_method" value="other" style="display:none;" />
                        <div class="method-icon">🏦</div>
                        <div class="method-label">Other</div>
                    </label>
                </div>

                <div class="form-group">
                    <label>Reference (Optional)</label>
                    <input type="text" name="reference" placeholder="Transaction ID, check #..." />
                </div>

                <div style="margin-top:20px; padding:16px; background:rgba(201,168,76,0.06); border:1px solid rgba(201,168,76,0.15); border-radius:6px; text-align:center; margin-bottom:18px;">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:4px;">Amount Due</div>
                    <div style="font-size:1.8rem; color:var(--gold); font-weight:600;">${{ number_format($order->total, 2) }}</div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; padding:13px; font-size:0.9rem;">✓ Confirm Payment</button>
            </form>

            <div style="margin-top:14px; text-align:center;">
                <a href="{{ route('waiter.orders.index') }}" class="btn btn-outline btn-sm">← Back</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function selectMethod(el, value) {
    document.querySelectorAll('.pay-method').forEach(m => m.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input[type="radio"]').checked = true;
}
</script>
@endsection