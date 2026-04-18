@extends('layouts.dashboard')
@section('page_title', 'Edit Category')

@section('content')
<div class="form-card">
    <h3>Edit — {{ $menuCategory->name }}</h3>
    <form action="{{ route('supervisor.menu_categories.update', $menuCategory) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ $menuCategory->name }}" required />
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="2">{{ $menuCategory->description }}</textarea>
        </div>
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="{{ $menuCategory->sort_order }}" />
        </div>
        <div class="form-group">
            <label class="checkbox-row">
                <input type="checkbox" name="is_active" value="1" {{ $menuCategory->is_active ? 'checked' : '' }} />
                <span>Show on Menu</span>
            </label>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('supervisor.menu_categories.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection