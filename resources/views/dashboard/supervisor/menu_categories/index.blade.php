{{-- resources/views/dashboard/supervisor/menu_categories/index.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Menu Categories')
@section('topbar_actions')
    <a href="{{ route('supervisor.menu_categories.create') }}" class="btn btn-primary">+ Add Category</a>
@endsection

@section('content')
<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Name</th><th>Description</th><th>Items</th><th>Order</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
            <tr>
                <td><strong>{{ $cat->name }}</strong></td>
                <td style="color:var(--text-muted); font-size:0.83rem;">{{ $cat->description ?? '—' }}</td>
                <td>{{ $cat->items_count }}</td>
                <td>{{ $cat->sort_order }}</td>
                <td><span class="badge {{ $cat->is_active ? 'active' : 'inactive' }}">{{ $cat->is_active ? 'Active' : 'Hidden' }}</span></td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('supervisor.menu_categories.edit', $cat) }}" class="btn btn-outline btn-sm">Edit</a>
                        <form action="{{ route('supervisor.menu_categories.destroy', $cat) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete category and all its items?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            <tr><td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px;">No categories yet.</td></tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection