@extends('layouts.dashboard')
@section('page_title', 'Edit Menu Item')

@section('content')
<div class="form-card" style="max-width:640px;">
    <h3>Edit — {{ $menuItem->name }}</h3>
    <form action="{{ route('supervisor.menu_items.update', $menuItem) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div style="display:grid; grid-template-columns:1.5fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ $menuItem->name }}" required />
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $menuItem->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="2">{{ $menuItem->description }}</textarea>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Price ($)</label>
                <input type="number" name="price" step="0.01" value="{{ $menuItem->price }}" required />
            </div>
            <div class="form-group">
                <label>Image</label>
                @if($menuItem->image)
                    <div style="margin-bottom:6px;">
                        <img src="/storage/{{ $menuItem->image }}" style="height:50px; border-radius:4px; object-fit:cover;" />
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" />
            </div>
        </div>
        <div class="form-group">
            <label>Allergens</label>
            <input type="text" name="allergens[]" value="{{ !empty($menuItem->allergens) ? implode(', ', $menuItem->allergens) : '' }}" />
        </div>
        <div style="display:flex; gap:24px;">
            <label class="checkbox-row" style="flex:1; background:rgba(255,255,255,0.03); padding:10px 14px; border-radius:6px;">
                <input type="checkbox" name="is_available" value="1" {{ $menuItem->is_available ? 'checked' : '' }} />
                <span>Available</span>
            </label>
            <label class="checkbox-row" style="flex:1; background:rgba(255,255,255,0.03); padding:10px 14px; border-radius:6px;">
                <input type="checkbox" name="is_featured" value="1" {{ $menuItem->is_featured ? 'checked' : '' }} />
                <span>Featured</span>
            </label>
        </div>
        <div class="form-actions" style="margin-top:20px;">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('supervisor.menu_items.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection