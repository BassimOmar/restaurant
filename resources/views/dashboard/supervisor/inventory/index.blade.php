{{-- resources/views/dashboard/supervisor/inventory/index.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Inventory')
@section('topbar_actions')
    <a href="{{ route('supervisor.inventory.create') }}" class="btn btn-primary">+ Add Item</a>
@endsection

@section('styles')
    .adjust-modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:500; justify-content:center; align-items:center; }
    .adjust-modal-overlay.show { display:flex; }
    .adjust-modal { background:#1a2332; border:1px solid rgba(255,255,255,0.08); border-radius:10px; padding:30px; width:400px; max-width:90%; }
    .adjust-modal h4 { margin-bottom:18px; color:#fff; }
    .adjust-modal .form-group { margin-bottom:14px; }
    .adjust-modal .form-group label { display:block; font-size:0.75rem; color:var(--text-muted); margin-bottom:5px; text-transform:uppercase; letter-spacing:0.8px; }
    .adjust-modal .form-group input, .adjust-modal .form-group select, .adjust-modal .form-group textarea {
        width:100%; padding:10px 14px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:5px; color:#fff; font-family:'Inter',sans-serif;
    }
    .adjust-modal .form-group select option { background:#1a2332; }
    .modal-actions { display:flex; gap:10px; margin-top:18px; }
@endsection

@section('content')

<!-- Category filter -->
<div style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
    <button class="btn btn-outline btn-sm cat-filter active" data-cat="all">All</button>
    @foreach($categories as $cat)
        <button class="btn btn-outline btn-sm cat-filter" data-cat="{{ $cat->id }}">{{ $cat->name }}</button>
    @endforeach
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Item</th><th>SKU</th><th>Category</th><th>Stock</th><th>Min</th><th>Unit Cost</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr data-cat="{{ $item->category_id }}">
                <td><strong>{{ $item->name }}</strong></td>
                <td style="color:var(--text-muted); font-size:0.82rem;">{{ $item->sku }}</td>
                <td>{{ $item->category?->name ?? '—' }}</td>
                <td>{{ $item->current_quantity }} {{ $item->unit }}</td>
                <td>{{ $item->minimum_quantity }}</td>
                <td>${{ number_format($item->unit_cost, 2) }}</td>
                <td><span class="badge {{ $item->isLowStock() ? 'low' : 'ok' }}">{{ $item->isLowStock() ? 'Low' : 'OK' }}</span></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-info btn-sm" onclick="openAdjust({{ $item->id }}, '{{ $item->name }}', {{ $item->current_quantity }})">Adjust</button>
                        <a href="{{ route('supervisor.inventory.edit', $item) }}" class="btn btn-outline btn-sm">Edit</a>
                        <form action="{{ route('supervisor.inventory.destroy', $item) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; color:var(--text-muted); padding:30px;">No inventory items.</td></tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Adjust Stock Modal -->
<div class="adjust-modal-overlay" id="adjustModal">
    <div class="adjust-modal">
        <h4 id="adjustModalTitle">Adjust Stock</h4>
        <form id="adjustForm" method="POST">
            @csrf
            <div class="form-group">
                <label>Type</label>
                <select name="type" required>
                    <option value="in">Restock (In)</option>
                    <option value="out">Used (Out)</option>
                    <option value="waste">Waste</option>
                    <option value="adjustment">Adjustment</option>
                </select>
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" step="0.01" min="0" required />
            </div>
            <div class="form-group">
                <label>Reason</label>
                <textarea name="reason" rows="2" placeholder="e.g. Delivery received, spoiled..."></textarea>
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-outline" onclick="closeAdjust()">Cancel</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Category filter
document.querySelectorAll('.cat-filter').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.cat-filter').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const cat = this.dataset.cat;
        document.querySelectorAll('tbody tr[data-cat]').forEach(row => {
            row.style.display = (cat === 'all' || row.dataset.cat === cat) ? '' : 'none';
        });
    });
});

// Adjust modal
function openAdjust(id, name, current) {
    document.getElementById('adjustModalTitle').textContent = `Adjust: ${name} (Current: ${current})`;
    document.getElementById('adjustForm').action = '{{ route("supervisor.inventory.adjust", "__ID__") }}'.replace('__ID__', id);
    document.getElementById('adjustModal').classList.add('show');
}
function closeAdjust() {
    document.getElementById('adjustModal').classList.remove('show');
}
document.getElementById('adjustModal').addEventListener('click', function(e) {
    if (e.target === this) closeAdjust();
});
</script>
@endsection