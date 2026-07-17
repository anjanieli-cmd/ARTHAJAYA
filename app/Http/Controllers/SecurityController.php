<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = $user->company;

        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(function ($session) {
                $session->is_current = $session->id === session()->getId();
                $session->last_activity_human = \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans();
                return $session;
            });

        return view('security.index', compact('user', 'company', 'sessions'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'          => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password'            => Hash::make($request->password),
            'password_changed_at' => now(),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function toggleTwoFactor(Request $request)
    {
        $user = Auth::user();
        $user->update(['two_factor_enabled' => !$user->two_factor_enabled]);

        $msg = $user->two_factor_enabled
            ? 'Autentikasi dua faktor diaktifkan.'
            : 'Autentikasi dua faktor dinonaktifkan.';

        return back()->with('success', $msg);
    }

    public function revokeSession(Request $request, string $sessionId)
    {
        DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Sesi berhasil diakhiri.');
    }

    public function revokeOtherSessions(Request $request)
    {
        DB::table('sessions')
            ->where('user_id', Auth::id())
            ->where('id', '!=', session()->getId())
            ->delete();

        return back()->with('success', 'Semua sesi lain berhasil diakhiri.');
    }
}