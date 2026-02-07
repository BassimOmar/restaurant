{{-- resources/views/dashboard/supervisor/menu_items/create.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Add Menu Item')

@section('content')
<div class="form-card" style="max-width:640px;">
    <h3>New Menu Item</h3>
    <form action="{{ route('supervisor.menu_items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display:grid; grid-template-columns:1.5fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" placeholder="Caesar Salad" value="{{ old('name') }}" required />
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" required>
                    <option value="">— Select —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="2" placeholder="Dish description...">{{ old('description') }}</textarea>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Price ($)</label>
                <input type="number" name="price" step="0.01" placeholder="12.99" value="{{ old('price') }}" required />
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" accept="image/*" />
            </div>
        </div>
        <div class="form-group">
            <label>Allergens (comma-separated)</label>
            <input type="text" name="allergens[]" placeholder="nuts, dairy, gluten" value="{{ old('allergens') ? implode(', ', old('allergens')) : '' }}" />
        </div>
        <div style="display:flex; gap:24px;">
            <label class="checkbox-row" style="flex:1; background:rgba(255,255,255,0.03); padding:10px 14px; border-radius:6px;">
                <input type="checkbox" name="is_available" value="1" checked />
                <span>Available</span>
            </label>
            <label class="checkbox-row" style="flex:1; background:rgba(255,255,255,0.03); padding:10px 14px; border-radius:6px;">
                <input type="checkbox" name="is_featured" value="1" />
                <span>Featured</span>
            </label>
        </div>
        <div class="form-actions" style="margin-top:20px;">
            <button type="submit" class="btn btn-primary">Add Item</button>
            <a href="{{ route('supervisor.menu_items.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection