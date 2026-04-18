@extends('layouts.dashboard')
@section('page_title', 'Create Table')

@section('content')
<div class="form-card">
    <h3>New Table</h3>
    <form action="{{ route('admin.tables.store') }}" method="POST">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Table Number</label>
                <input type="text" name="table_number" placeholder="T01" value="{{ old('table_number') }}" required />
            </div>
            <div class="form-group">
                <label>Capacity</label>
                <input type="number" name="capacity" min="1" value="{{ old('capacity', 4) }}" required />
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Type</label>
                <select name="type" required>
                    <option value="regular" {{ old('type') === 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="private_dining" {{ old('type') === 'private_dining' ? 'selected' : '' }}>Private Dining</option>
                </select>
            </div>
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" placeholder="Section A, Patio..." value="{{ old('location') }}" />
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create Table</button>
            <a href="{{ route('admin.tables.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection