@extends('layouts.dashboard')
@section('page_title', 'Create Category')

@section('content')
<div class="form-card">
    <h3>New Menu Category</h3>
    <form action="{{ route('supervisor.menu_categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" placeholder="Appetizers" value="{{ old('name') }}" required />
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="2" placeholder="Brief description...">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('supervisor.menu_categories.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection