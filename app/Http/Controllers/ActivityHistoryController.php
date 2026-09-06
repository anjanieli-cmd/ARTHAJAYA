<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        // Ambil semua log milik user-user di company yang sama.
        $userIds = $company
            ? $company->users()->pluck('id')
            : collect([$user->id]);

        $query = ActivityLog::with('user')
            ->whereIn('user_id', $userIds)
            ->latest();

        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(description) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(action) LIKE ?', ["%{$q}%"]);
            });
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $activities = $query->paginate(20)->withQueryString();

        return view('history.index', compact('user', 'company', 'activities'));
    }
}