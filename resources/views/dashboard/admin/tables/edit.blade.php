{{-- resources/views/dashboard/admin/tables/edit.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Edit Table')

@section('content')
<div class="form-card">
    <h3>Edit — {{ $table->table_number }}</h3>
    <form action="{{ route('admin.tables.update', $table) }}" method="POST">
        @csrf @method('PUT')
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Table Number</label>
                <input type="text" name="table_number" value="{{ $table->table_number }}" required />
            </div>
            <div class="form-group">
                <label>Capacity</label>
                <input type="number" name="capacity" min="1" value="{{ $table->capacity }}" required />
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Type</label>
                <select name="type" required>
                    <option value="regular" {{ $table->type === 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="private_dining" {{ $table->type === 'private_dining' ? 'selected' : '' }}>Private Dining</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="available" {{ $table->status === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ $table->status === 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="reserved" {{ $table->status === 'reserved' ? 'selected' : '' }}>Reserved</option>
                    <option value="maintenance" {{ $table->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" value="{{ $table->location }}" />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.tables.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection