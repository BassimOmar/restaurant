{{-- resources/views/dashboard/admin/discounts/create.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Create Discount')

@section('content')
<div class="form-card">
    <h3>New Discount</h3>
    <form action="{{ route('admin.discounts.store') }}" method="POST">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Code</label>
                <input type="text" name="code" placeholder="SUMMER20" value="{{ old('code') }}" required />
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" placeholder="Summer Sale" value="{{ old('name') }}" required />
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Type</label>
                <select name="type" required>
                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                    <option value="fixed_amount" {{ old('type') === 'fixed_amount' ? 'selected' : '' }}>Fixed Amount</option>
                </select>
            </div>
            <div class="form-group">
                <label>Value</label>
                <input type="number" name="value" step="0.01" placeholder="20" value="{{ old('value') }}" required />
            </div>
            <div class="form-group">
                <label>Min Order ($)</label>
                <input type="number" name="minimum_order_amount" step="0.01" placeholder="0" value="{{ old('minimum_order_amount', 0) }}" />
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Usage Limit</label>
                <input type="number" name="usage_limit" placeholder="Unlimited" value="{{ old('usage_limit') }}" />
            </div>
            <div class="form-group">
                <label>Valid From</label>
                <input type="date" name="valid_from" value="{{ old('valid_from') }}" />
            </div>
            <div class="form-group">
                <label>Valid Until</label>
                <input type="date" name="valid_until" value="{{ old('valid_until') }}" />
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create Discount</button>
            <a href="{{ route('admin.discounts.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection