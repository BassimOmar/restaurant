{{-- resources/views/dashboard/admin/users/index.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Users')
@section('topbar_actions')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Add User</a>
@endsection

@section('content')
<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge {{ $user->role }}">{{ $user->role }}</span></td>
                <td><span class="badge {{ $user->is_active ? 'active' : 'inactive' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-sm">Edit</a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">Delete</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection