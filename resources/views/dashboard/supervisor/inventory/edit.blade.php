{{-- resources/views/dashboard/supervisor/inventory/edit.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Edit Inventory Item')

@section('content')
<div class="form-card">
    <h3>Edit — {{ $inventoryItem->name }}</h3>
    <form action="{{ route('supervisor.inventory.update', $inventoryItem) }}" method="POST">
        @csrf @method('PUT')
        <div style="display:grid; grid-template-columns:1.5fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ $inventoryItem->name }}" required />
            </div>
            <div class="form-group">
                <label>SKU</label>
                <input type="text" name="sku" value="{{ $inventoryItem->sku }}" required />
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Category</label>
                <select name="category_id">
                    <option value="">— None —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $inventoryItem->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="unit" value="{{ $inventoryItem->unit }}" required />
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Min Qty (Alert)</label>
                <input type="number" name="minimum_quantity" step="0.01" value="{{ $inventoryItem->minimum_quantity }}" required />
            </div>
            <div class="form-group">
                <label>Unit Cost ($)</label>
                <input type="number" name="unit_cost" step="0.01" value="{{ $inventoryItem->unit_cost }}" required />
            </div>
        </div>
        <div class="form-group">
            <label>Current Stock</label>
            <input type="text" value="{{ $inventoryItem->current_quantity }} {{ $inventoryItem->unit }}" disabled style="opacity:0.5;" />
            <div style="font-size:0.75rem; color:var(--text-muted); margin-top:4px;">Use "Adjust" button on index page to change stock levels.</div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('supervisor.inventory.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection