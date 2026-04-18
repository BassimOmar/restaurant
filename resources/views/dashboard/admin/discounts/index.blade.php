@extends('layouts.dashboard')
@section('page_title', 'Discount Codes')

@section('topbar_actions')
    <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">+ New Discount</a>
@endsection

@section('content')
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Min Order</th>
                <th>Valid From</th>
                <th>Valid Until</th>
                <th>Uses</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($discounts as $discount)
            <tr>
                <td><strong>{{ $discount->code }}</strong></td>
                <td>
                    <span class="badge {{ $discount->type === 'percentage' ? 'info' : 'warning' }}">
                        {{ ucfirst($discount->type) }}
                    </span>
                </td>
                <td>
                    @if($discount->type === 'percentage')
                        {{ $discount->value }}%
                    @else
                        ${{ number_format($discount->value, 2) }}
                    @endif
                </td>
                <td>${{ number_format($discount->minimum_order_amount, 2) }}</td>
                <td>{{ $discount->valid_from ? $discount->valid_from->format('M d, Y') : '—' }}</td>
                <td>{{ $discount->valid_until ? $discount->valid_until->format('M d, Y') : '—' }}</td>
                <td>
                    @if($discount->max_uses)
                        {{ $discount->uses_count ?? 0 }} / {{ $discount->max_uses }}
                    @else
                        Unlimited
                    @endif
                </td>
                <td>
                    @if($discount->is_active)
                        <span class="badge completed">Active</span>
                    @else
                        <span class="badge cancelled">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.discounts.edit', $discount) }}" class="btn btn-sm">Edit</a>
                        <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this discount code?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="9" style="text-align:center; color:var(--text-muted); padding:30px;">
                    No discount codes yet. Create one to get started!
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection