@extends('layouts.dashboard')
@section('page_title', 'Edit User')

@section('content')
<div class="form-card">
    <h3>Edit — {{ $user->name }}</h3>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required />
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required />
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role" required>
                <option value="waiter" {{ ($user->role === 'waiter') ? 'selected' : '' }}>Waiter</option>
                <option value="supervisor" {{ ($user->role === 'supervisor') ? 'selected' : '' }}>Supervisor</option>
                <option value="owner" {{ ($user->role === 'owner') ? 'selected' : '' }}>Owner</option>
            </select>
        </div>
        <div class="form-group">
            <label class="checkbox-row">
                <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} />
                <span>Account Active</span>
            </label>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection