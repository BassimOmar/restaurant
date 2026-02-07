{{-- resources/views/dashboard/waiter/orders/create.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'New Order')

@section('styles')
    .order-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    .menu-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .menu-btn {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 6px;
        padding: 14px;
        cursor: pointer;
        transition: border-color 0.2s;
        text-align: left;
        color: var(--text);
        font-family: 'Inter', sans-serif;
    }
    .menu-btn:hover { border-color: var(--gold); }
    .menu-btn .mb-cat { font-size: 0.68rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.8px; }
    .menu-btn .mb-name { font-size: 0.88rem; font-weight: 500; margin: 3px 0; }
    .menu-btn .mb-price { font-size: 0.82rem; color: var(--gold); }

    .cat-tabs { display: flex; gap: 8px; margin-bottom: 14px; flex-wrap: wrap; }
    .cat-tab-btn { padding: 5px 14px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); background: transparent; color: var(--text-muted); font-size: 0.78rem; cursor: pointer; font-family: 'Inter', sans-serif; }
    .cat-tab-btn.active, .cat-tab-btn:hover { border-color: var(--gold); color: var(--gold); }

    .order-item-row { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .order-item-row:last-child { border-bottom: none; }
    .order-item-row .item-name { flex: 1; font-size: 0.88rem; }
    .order-item-row .qty-btn { width: 28px; height: 28px; border-radius: 5px; border: 1px solid rgba(255,255,255,0.12); background: rgba(255,255,255,0.04); color: #fff; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; }
    .order-item-row .qty-btn:hover { border-color: var(--gold); }
    .order-item-row .qty-num { width: 24px; text-align: center; font-size: 0.9rem; }

    .summary-box { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); border-radius: 6px; padding: 18px; margin-top: 16px; }
    .summary-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 0.84rem; color: var(--text-muted); }
    .summary-row.total { color: #fff; font-weight: 600; font-size: 1rem; padding-top: 10px; margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.08); }
@endsection

@section('content')

<div class="order-layout">
    <!-- LEFT: Menu Selection -->
    <div>
        <div class="table-wrap" style="padding:20px;">
            <h3 style="margin-bottom:14px; font-size:0.95rem;">Select Table</h3>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                @foreach($tables as $table)
                    <button type="button" class="table-btn" data-id="{{ $table->id }}" onclick="selectTable(this)"
                        style="padding:10px 18px; border-radius:6px; border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.03); color:var(--text); cursor:pointer; font-family:'Inter',sans-serif; font-size:0.85rem; transition:all 0.2s;">
                        {{ $table->table_number }}
                        <span style="font-size:0.72rem; color:var(--text-muted);"> ({{ $table->capacity }})</span>
                        @if($table->type === 'private_dining') 🔒 @endif
                    </button>
                @endforeach
            </div>
            <input type="hidden" id="selected_table" value="" />
        </div>

        <div class="table-wrap" style="padding:20px; margin-top:16px;">
            <h3 style="margin-bottom:12px; font-size:0.95rem;">Menu</h3>

            <!-- Category Tabs -->
            <div class="cat-tabs">
                <button class="cat-tab-btn active" onclick="filterMenu(this, 'all')">All</button>
                @foreach(collect($menuItems)->pluck('category')->unique('id') as $cat)
                    <button class="cat-tab-btn" onclick="filterMenu(this, '{{ $cat->id }}')">{{ $cat->name }}</button>
                @endforeach
            </div>

            <div class="menu-grid" id="menuGrid">
                @foreach($menuItems as $item)
                <button type="button" class="menu-btn" data-cat="{{ $item->category_id }}" onclick="addItem({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->price }})">
                    <div class="mb-cat">{{ $item->category->name }}</div>
                    <div class="mb-name">{{ $item->name }}</div>
                    <div class="mb-price">${{ number_format($item->price, 2) }}</div>
                </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- RIGHT: Order Summary + Form -->
    <div>
        <div class="table-wrap" style="padding:20px;">
            <h3 style="margin-bottom:14px; font-size:0.95rem;">Current Order</h3>

            <div id="orderItems" style="min-height:60px;">
                <div style="color:var(--text-muted); font-size:0.85rem; padding:20px 0; text-align:center;" id="emptyMsg">No items yet. Tap a dish to add.</div>
            </div>

            <!-- Summary -->
            <div class="summary-box">
                <div class="summary-row"><span>Subtotal</span><span id="subtotalDisplay">$0.00</span></div>
                <div class="summary-row" id="discountRow" style="display:none;"><span style="color:var(--success);">Discount</span><span style="color:var(--success);" id="discountDisplay">-$0.00</span></div>
                <div class="summary-row"><span>Tax (10%)</span><span id="taxDisplay">$0.00</span></div>
                <div class="summary-row total"><span>Total</span><span id="totalDisplay">$0.00</span></div>
            </div>

            <!-- Discount + Notes -->
            <div class="form-group" style="margin-top:16px;">
                <label>Discount Code</label>
                <select name="discount_id" id="discountSelect">
                    <option value="">— None —</option>
                    @foreach($discounts as $d)
                        <option value="{{ $d->id }}" data-type="{{ $d->type }}" data-value="{{ $d->value }}" data-min="{{ $d->minimum_order_amount }}">
                            {{ $d->code }} — {{ $d->type === 'percentage' ? $d->value . '%' : '$' . number_format($d->value, 2) }} off
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Notes</label>
                <textarea id="orderNotes" rows="2" placeholder="Special instructions..."></textarea>
            </div>

            <button type="button" class="btn btn-primary" style="width:100%; padding:12px;" onclick="submitOrder()" id="submitBtn">Place Order</button>
        </div>
    </div>
</div>

<!-- Hidden form that gets submitted -->
<form id="orderForm" action="{{ route('waiter.orders.store') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="table_id" id="formTableId" />
    <div id="formItems"></div>
    <input type="hidden" name="discount_id" id="formDiscountId" />
    <input type="hidden" name="notes" id="formNotes" />
</form>

@endsection

@section('scripts')
<script>
let orderItems = {};

// Table selection
function selectTable(btn) {
    document.querySelectorAll('.table-btn').forEach(b => b.style.borderColor = 'rgba(255,255,255,0.1)');
    btn.style.borderColor = 'var(--gold)';
    document.getElementById('selected_table').value = btn.dataset.id;
}

// Category filter
function filterMenu(btn, catId) {
    document.querySelectorAll('.cat-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.menu-btn').forEach(item => {
        item.style.display = (catId === 'all' || item.dataset.cat === catId) ? '' : 'none';
    });
}

// Add item
function addItem(id, name, price) {
    if (orderItems[id]) {
        orderItems[id].qty++;
    } else {
        orderItems[id] = { id, name, price, qty: 1 };
    }
    renderOrderItems();
    recalculate();
}

function changeQty(id, delta) {
    if (!orderItems[id]) return;
    orderItems[id].qty += delta;
    if (orderItems[id].qty <= 0) delete orderItems[id];
    renderOrderItems();
    recalculate();
}

function renderOrderItems() {
    const container = document.getElementById('orderItems');
    const empty = document.getElementById('emptyMsg');
    const items = Object.values(orderItems);

    if (items.length === 0) {
        container.innerHTML = '<div style="color:var(--text-muted); font-size:0.85rem; padding:20px 0; text-align:center;" id="emptyMsg">No items yet. Tap a dish to add.</div>';
        return;
    }

    container.innerHTML = items.map(item => `
        <div class="order-item-row">
            <div class="item-name">${item.name}</div>
            <button class="qty-btn" onclick="changeQty(${item.id}, -1)">−</button>
            <div class="qty-num">${item.qty}</div>
            <button class="qty-btn" onclick="changeQty(${item.id}, 1)">+</button>
            <div style="width:60px; text-align:right; font-size:0.84rem; color:var(--gold);">\$${(item.price * item.qty).toFixed(2)}</div>
        </div>
    `).join('');
}

function recalculate() {
    let subtotal = Object.values(orderItems).reduce((sum, i) => sum + i.price * i.qty, 0);
    let discount = 0;

    const sel = document.getElementById('discountSelect');
    const opt = sel.options[sel.selectedIndex];
    if (opt && opt.value) {
        const type = opt.dataset.type;
        const value = parseFloat(opt.dataset.value);
        const min = parseFloat(opt.dataset.min);
        if (subtotal >= min) {
            discount = type === 'percentage' ? subtotal * (value / 100) : value;
        }
    }

    const tax = (subtotal - discount) * 0.10;
    const total = subtotal - discount + tax;

    document.getElementById('subtotalDisplay').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('taxDisplay').textContent = '$' + tax.toFixed(2);
    document.getElementById('totalDisplay').textContent = '$' + total.toFixed(2);

    const dRow = document.getElementById('discountRow');
    if (discount > 0) {
        dRow.style.display = 'flex';
        document.getElementById('discountDisplay').textContent = '-$' + discount.toFixed(2);
    } else {
        dRow.style.display = 'none';
    }
}

// Listen for discount change
document.getElementById('discountSelect').addEventListener('change', recalculate);

// Submit
function submitOrder() {
    const tableId = document.getElementById('selected_table').value;
    if (!tableId) { alert('Please select a table.'); return; }
    if (Object.keys(orderItems).length === 0) { alert('Add at least one item.'); return; }

    const form = document.getElementById('orderForm');
    document.getElementById('formTableId').value = tableId;
    document.getElementById('formDiscountId').value = document.getElementById('discountSelect').value;
    document.getElementById('formNotes').value = document.getElementById('orderNotes').value;

    // Build items inputs
    let itemsHtml = '';
    let i = 0;
    Object.values(orderItems).forEach(item => {
        itemsHtml += `<input type="hidden" name="items[${i}][menu_item_id]" value="${item.id}" />`;
        itemsHtml += `<input type="hidden" name="items[${i}][quantity]" value="${item.qty}" />`;
        itemsHtml += `<input type="hidden" name="items[${i}][special_instructions]" value="" />`;
        i++;
    });
    document.getElementById('formItems').innerHTML = itemsHtml;

    form.submit();
}
</script>
@endsection