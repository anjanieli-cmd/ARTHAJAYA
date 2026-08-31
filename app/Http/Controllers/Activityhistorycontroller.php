<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityHistoryController extends Controller
{
    /**
     * Tampilkan riwayat aktivitas milik user yang sedang login.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::where('user_id', auth()->id())
            ->latest();

        // Filter opsional by jenis aksi, misal ?action=set_initial_balance
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter opsional by rentang tanggal
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $activities = $query->paginate(20)->withQueryString();

        // Daftar action unik milik user ini, buat dropdown filter
        $actionTypes = ActivityLog::where('user_id', auth()->id())
            ->select('action')
            ->distinct()
            ->pluck('action');

        return view('history.index', compact('activities', 'actionTypes'));
    }
}