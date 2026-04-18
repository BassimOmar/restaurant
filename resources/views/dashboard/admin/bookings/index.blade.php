@extends('layouts.dashboard')
@section('page_title', 'Bookings')

@section('content')
<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Booking #</th><th>Customer</th><th>Table</th><th>Guests</th><th>Date</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->booking_number }}</td>
                <td>
                    {{ $booking->customer_name }}
                    <div style="font-size:0.78rem; color:var(--text-muted);">{{ $booking->customer_phone }}</div>
                </td>
                <td>{{ $booking->table->table_number }} {{ $booking->table->type === 'private_dining' ? '🔒' : '' }}</td>
                <td>{{ $booking->guest_count }}</td>
                <td>{{ $booking->booking_date->format('M d, Y — g:i A') }}</td>
                <td><span class="badge {{ $booking->status }}">{{ str_replace('_', ' ', $booking->status) }}</span></td>
                <td>
                    <div class="btn-group">
                        @if($booking->status === 'pending')
                            <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                            </form>
                        @endif
                        @if($booking->status === 'confirmed')
                            <form action="{{ route('admin.bookings.arrived', $booking) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-info btn-sm">Arrived</button>
                            </form>
                        @endif
                        @if(in_array($booking->status, ['pending', 'confirmed']))
                            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Cancel this booking?')">Cancel</button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            <tr><td colspan="7" style="text-align:center; color:var(--text-muted); padding:30px;">No bookings.</td></tr>
            @endforeach
        </tbody>
    </table>
    {{ $bookings->links() }}
</div>
@endsection