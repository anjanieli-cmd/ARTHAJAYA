<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.activity.index', compact('logs'));
    }

    /**
     * Hapus 1 baris log.
     */
    public function destroy(ActivityLog $log)
    {
        $log->delete();

        return back()->with('success', 'Log berhasil dihapus.');
    }

    /**
     * Hapus semua log sekaligus.
     */
    public function destroyAll()
    {
        $count = ActivityLog::count();
        ActivityLog::truncate();

        return back()->with('success', "{$count} log berhasil dihapus semua.");
    }
}