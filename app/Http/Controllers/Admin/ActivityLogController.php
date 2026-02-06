<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(25);

        return view('dashboard.admin.activity_logs.index', compact('logs'));
    }

    public function show(ActivityLog $log)
    {
        $log->load('user');
        return view('dashboard.admin.activity_logs.show', compact('log'));
    }
}
