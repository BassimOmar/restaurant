@extends('layouts.dashboard')
@section('page_title', 'Activity Logs')

@section('content')
<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Action</th><th>Model</th><th>Description</th><th>User</th><th>IP</th><th>Time</th></tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td><span class="badge {{ $log->action === 'created' ? 'active' : ($log->action === 'deleted' ? 'cancelled' : 'pending') }}">{{ $log->action }}</span></td>
                <td style="font-size:0.82rem; color:var(--text-muted);">{{ $log->model_type }}</td>
                <td style="font-size:0.83rem;">{{ $log->description }}</td>
                <td>{{ $log->user?->name ?? 'System' }}</td>
                <td style="font-size:0.78rem; color:var(--text-muted);">{{ $log->ip_address ?? '—' }}</td>
                <td style="font-size:0.78rem; color:var(--text-muted);">{{ $log->created_at->format('M d, Y g:i A') }}</td>
            </tr>
            <tr><td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px;">No logs.</td></tr>
            @endforeach
        </tbody>
    </table>

    @if($logs->hasPages())
    <div style="padding: 16px 22px; border-top: 1px solid var(--card-border);">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection