{{-- resources/views/dashboard/admin/customers/index.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'CRM — Customers')

@section('content')
<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Name</th><th>Phone</th><th>Email</th><th>Visits</th><th>Total Spent</th><th>VIP</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td><strong>{{ $customer->name }}</strong></td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email ?? '—' }}</td>
                <td>{{ $customer->total_visits }}</td>
                <td>${{ number_format($customer->total_spent, 2) }}</td>
                <td>{{ $customer->is_vip ? '<span class="badge vip">VIP</span>' : '—' }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline btn-sm">View</a>
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-outline btn-sm">Edit</a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:var(--text-muted); padding:30px;">No customers yet.</td></tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->links() }}
</div>
@endsection