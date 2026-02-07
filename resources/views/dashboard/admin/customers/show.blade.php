{{-- resources/views/dashboard/admin/customers/show.blade.php --}}
@extends('layouts.dashboard')
@section('page_title', 'Customer Detail')

@section('content')
<div style="display:grid; grid-template-columns: 1fr 1.5fr; gap: 20px;">

    <!-- Customer Card -->
    <div class="table-wrap" style="padding: 28px;">
        <div style="display:flex; align-items:center; gap:16px; margin-bottom:24px;">
            <div style="width:52px;height:52px;border-radius:50%;background:var(--gold);color:#1a1a1a;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:1.2rem;">
                {{ strtoupper(substr($customer->name, 0, 2)) }}
            </div>
            <div>
                <div style="font-weight:600; font-size:1.05rem;">{{ $customer->name }}</div>
                @if($customer->is_vip) <span class="badge vip">VIP</span> @endif
            </div>
        </div>

        <div style="font-size:0.83rem; line-height:2.2;">
            <div><span style="color:var(--text-muted); width:100px; display:inline-block;">Phone</span>{{ $customer->phone }}</div>
            <div><span style="color:var(--text-muted); width:100px; display:inline-block;">Email</span>{{ $customer->email ?? '—' }}</div>
            <div><span style="color:var(--text-muted); width:100px; display:inline-block;">Birthday</span>{{ $customer->birthday ? $customer->birthday->format('M d') : '—' }}</div>
            <div><span style="color:var(--text-muted); width:100px; display:inline-block;">Visits</span>{{ $customer->total_visits }}</div>
            <div><span style="color:var(--text-muted); width:100px; display:inline-block;">Spent</span><span style="color:var(--gold);">${{ number_format($customer->total_spent, 2) }}</span></div>
            <div><span style="color:var(--text-muted); width:100px; display:inline-block;">Last Visit</span>{{ $customer->last_visit ? $customer->last_visit->diffForHumans() : '—' }}</div>
        </div>

        @if($customer->notes)
        <div style="margin-top:18px; padding:14px; background:rgba(255,255,255,0.03); border-radius:6px; font-size:0.82rem; color:#bbb;">
            <div style="color:var(--text-muted); font-size:0.7rem; margin-bottom:4px; text-transform:uppercase; letter-spacing:1px;">Notes</div>
            {{ $customer->notes }}
        </div>
        @endif

        <div style="margin-top:20px;">
            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary btn-sm">Edit Customer</a>
        </div>
    </div>

    <!-- Booking History -->
    <div class="table-wrap">
        <div class="table-header">
            <h3>Booking History</h3>
        </div>
        <table>
            <thead>
                <tr><th>Booking #</th><th>Table</th><th>Date</th><th>Guests</th><th>Status</th></tr>
            </thead>
            <tbody>
                @foreach($customer->bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_number }}</td>
                    <td>{{ $booking->table->table_number }}</td>
                    <td>{{ $booking->booking_date->format('M d, Y — g:i A') }}</td>
                    <td>{{ $booking->guest_count }}</td>
                    <td><span class="badge {{ $booking->status }}">{{ str_replace('_', ' ', $booking->status) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; color:var(--text-muted); padding:24px;">No bookings.</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection