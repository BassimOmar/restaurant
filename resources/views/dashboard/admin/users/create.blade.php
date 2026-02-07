{{-- resources/views/dashboard/admin/users/create.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Create User')

@section('content')
<div class="form-card">
    <h3>New User</h3>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required />
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required />
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required />
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role" required>
                <option value="waiter" {{ old('role') === 'waiter' ? 'selected' : '' }}>Waiter</option>
                <option value="supervisor" {{ old('role') === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                <option value="owner" {{ old('role') === 'owner' ? 'selected' : '' }}>Owner</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection