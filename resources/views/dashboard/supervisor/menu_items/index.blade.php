{{-- resources/views/dashboard/supervisor/menu_items/index.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Menu Items')
@section('topbar_actions')
    <a href="{{ route('supervisor.menu_items.create') }}" class="btn btn-primary">+ Add Item</a>
@endsection

@section('content')

<!-- Category Filter -->
<div style="display:flex; gap:10px; margin-bottom:18px; flex-wrap:wrap;">
    <button class="btn btn-outline btn-sm cat-filter active" data-cat="all">All</button>
    @foreach($categories as $cat)
        <button class="btn btn-outline btn-sm cat-filter" data-cat="{{ $cat->id }}">{{ $cat->name }}</button>
    @endforeach
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Name</th><th>Category</th><th>Price</th><th>Available</th><th>Featured</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr data-cat="{{ $item->category_id }}">
                <td><strong>{{ $item->name }}</strong></td>
                <td>{{ $item->category->name }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td><span class="badge {{ $item->is_available ? 'active' : 'inactive' }}">{{ $item->is_available ? 'Yes' : 'No' }}</span></td>
                <td>{{ $item->is_featured ? '⭐' : '—' }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('supervisor.menu_items.edit', $item) }}" class="btn btn-outline btn-sm">Edit</a>
                        <form action="{{ route('supervisor.menu_items.destroy', $item) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            <tr><td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px;">No menu items.</td></tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.cat-filter').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.cat-filter').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const cat = this.dataset.cat;
        document.querySelectorAll('tbody tr[data-cat]').forEach(row => {
            row.style.display = (cat === 'all' || row.dataset.cat === cat) ? '' : 'none';
        });
    });
});
</script>
@endsections