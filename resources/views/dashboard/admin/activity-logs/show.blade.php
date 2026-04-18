@extends('layouts.dashboard')
@section('page_title', 'Log Detail')

@section('content')
<div class="form-card" style="max-width:700px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:22px;">
        <h3 style="margin:0;">Log Detail</h3>
        <span class="badge {{ $log->action === 'created' ? 'active' : ($log->action === 'deleted' ? 'cancelled' : 'pending') }}">{{ $log->action }}</span>
    </div>

    <div style="font-size:0.85rem; line-height:2.4;">
        <div><span style="color:var(--text-muted); width:120px; display:inline-block;">Description</span>{{ $log->description }}</div>
        <div><span style="color:var(--text-muted); width:120px; display:inline-block;">Model</span>{{ $log->model_type }} #{{ $log->model_id ?? '—' }}</div>
        <div><span style="color:var(--text-muted); width:120px; display:inline-block;">User</span>{{ $log->user?->name ?? 'System' }} ({{ $log->user?->role ?? '—' }})</div>
        <div><span style="color:var(--text-muted); width:120px; display:inline-block;">IP</span>{{ $log->ip_address ?? '—' }}</div>
        <div><span style="color:var(--text-muted); width:120px; display:inline-block;">Time</span>{{ $log->created_at->format('F j, Y — g:i A') }}</div>
    </div>

    @if($log->old_values || $log->new_values)
    <div style="margin-top:24px; display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        @if($log->old_values)
        <div style="background:rgba(248,113,113,0.06); border:1px solid rgba(248,113,113,0.15); border-radius:6px; padding:16px;">
            <div style="font-size:0.7rem; color:var(--danger); text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">Before</div>
            @foreach($log->old_values as $key => $value)
                <div style="font-size:0.82rem; margin-bottom:4px;"><span style="color:var(--text-muted);">{{ $key }}:</span> {{ $value }}</div>
            @endforeach
        </div>
        @endif

        @if($log->new_values)
        <div style="background:rgba(52,211,153,0.06); border:1px solid rgba(52,211,153,0.15); border-radius:6px; padding:16px;">
            <div style="font-size:0.7rem; color:var(--success); text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">After</div>
            @foreach($log->new_values as $key => $value)
                <div style="font-size:0.82rem; margin-bottom:4px;"><span style="color:var(--text-muted);">{{ $key }}:</span> {{ $value }}</div>
            @endforeach
        </div>
        @endif
    </div>
    @endif

    <div style="margin-top:22px;">
        <a href="{{ route('admin.logs.index') }}" class="btn btn-outline btn-sm">← Back to Logs</a>
    </div>
</div>
@endsection