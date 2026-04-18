@extends('layouts.dashboard')
@section('page_title', 'Tables')
@section('topbar_actions')
    <a href="{{ route('admin.tables.create') }}" class="btn btn-primary">+ Add Table</a>
@endsection

@section('content')
<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-label">Total</div>
        <div class="stat-value">{{ $tables->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Available</div>
        <div class="stat-value success">{{ $tables->where('status', 'available')->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Occupied</div>
        <div class="stat-value danger">{{ $tables->where('status', 'occupied')->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Private Dining</div>
        <div class="stat-value gold">{{ $tables->where('type', 'private_dining')->count() }}</div>
    </div>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Table</th><th>Capacity</th><th>Type</th><th>Location</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($tables as $table)
            <tr>
                <td><strong>{{ $table->table_number }}</strong></td>
                <td>{{ $table->capacity }} guests</td>
                <td>{{ $table->type === 'private_dining' ? '🔒 Private' : 'Regular' }}</td>
                <td>{{ $table->location ?? '—' }}</td>
                <td><span class="badge {{ $table->status }}">{{ str_replace('_', ' ', $table->status) }}</span></td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.tables.edit', $table) }}" class="btn btn-outline btn-sm">Edit</a>
                        <form action="{{ route('admin.tables.destroy', $table) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete table?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection