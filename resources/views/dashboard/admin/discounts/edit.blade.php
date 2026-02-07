{{-- resources/views/dashboard/admin/discounts/edit.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Edit Discount')

@section('content')
<div class="form-card">
    <h3>Edit — {{ $discount->code }}</h3>
    <form action="{{ route('admin.discounts.update', $discount) }}" method="POST">
        @csrf @method('PUT')
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Code</label>
                <input type="text" name="code" value="{{ $discount->code }}" required />
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ $discount->name }}" required />
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Type</label>
                <select name="type" required>
                    <option value="percentage" {{ $discount->type === 'percentage' ? 'selected' : '' }}>Percentage</option>
                    <option value="fixed_amount" {{ $discount->type === 'fixed_amount' ? 'selected' : '' }}>Fixed Amount</option>
                </select>
            </div>
            <div class="form-group">
                <label>Value</label>
                <input type="number" name="value" step="0.01" value="{{ $discount->value }}" required />
            </div>
            <div class="form-group">
                <label>Min Order ($)</label>
                <input type="number" name="minimum_order_amount" step="0.01" value="{{ $discount->minimum_order_amount }}" />
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
            <div class="form-group">
                <label>Usage Limit</label>
                <input type="number" name="usage_limit" value="{{ $discount->usage_limit }}" />
            </div>
            <div class="form-group">
                <label>Valid From</label>
                <input type="date" name="valid_from" value="{{ $discount->valid_from ? $discount->valid_from->format('Y-m-d') : '' }}" />
            </div>
            <div class="form-group">
                <label>Valid Until</label>
                <input type="date" name="valid_until" value="{{ $discount->valid_until ? $discount->valid_until->format('Y-m-d') : '' }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="checkbox-row">
                <input type="checkbox" name="is_active" value="1" {{ $discount->is_active ? 'checked' : '' }} />
                <span>Active</span>
            </label>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.discounts.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection