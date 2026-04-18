@extends('layouts.dashboard')
@section('page_title', 'Edit Customer')

@section('content')
<div class="form-card">
    <h3>Edit — {{ $customer->name }}</h3>
    <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
        @csrf @method('PATCH')
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ $customer->name }}" required />
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ $customer->phone }}" required />
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $customer->email }}" />
            </div>
            <div class="form-group">
                <label>Birthday</label>
                <input type="date" name="birthday" value="{{ $customer->birthday ? $customer->birthday->format('Y-m-d') : '' }}" />
            </div>
        </div>
        <div class="form-group">
            <label>Notes</label>
            <textarea name="notes" rows="3">{{ $customer->notes }}</textarea>
        </div>
        <div class="form-group">
            <label class="checkbox-row">
                <input type="checkbox" name="is_vip" value="1" {{ $customer->is_vip ? 'checked' : '' }} />
                <span>Mark as VIP</span>
            </label>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection