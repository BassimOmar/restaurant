@extends('layouts.dashboard')
@section('page_title', 'Add Inventory Item')

@section('content')
<div class="form-card">
    <h3>New Inventory Item</h3>
    <form action="{{ route('supervisor.inventory.store') }}" method="POST">
        @csrf
        <div style="display:grid; grid-template-columns:1.5fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" placeholder="Tomatoes" value="{{ old('name') }}" required />
            </div>
            <div class="form-group">
                <label>SKU</label>
                <input type="text" name="sku" placeholder="VEG-001" value="{{ old('sku') }}" required />
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Category</label>
                <select name="category_id">
                    <option value="">— None —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Unit (kg, liters, pieces...)</label>
                <input type="text" name="unit" placeholder="kg" value="{{ old('unit') }}" required />
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Current Qty</label>
                <input type="number" name="current_quantity" step="0.01" value="{{ old('current_quantity', 0) }}" required />
            </div>
            <div class="form-group">
                <label>Min Qty (Alert)</label>
                <input type="number" name="minimum_quantity" step="0.01" value="{{ old('minimum_quantity', 5) }}" required />
            </div>
            <div class="form-group">
                <label>Unit Cost ($)</label>
                <input type="number" name="unit_cost" step="0.01" value="{{ old('unit_cost') }}" required />
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Add Item</button>
            <a href="{{ route('supervisor.inventory.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection