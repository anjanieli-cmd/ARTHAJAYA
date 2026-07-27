<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminSecurityController extends Controller
{
    public function index()
    {
        return view('admin.security.index', [
            'admin' => auth()->user(),
        ]);
    }

    public function updatePassword(Request $request)
    {
        $admin = auth()->user();

        $data = $request->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($data['current_password'], $admin->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai.',
            ]);
        }

        $admin->update([
            'password'            => Hash::make($data['new_password']),
            'password_changed_at' => now(),
        ]);

        return redirect()->route('admin.security.index')
            ->with('success', 'Password berhasil diperbarui.');
    }

    public function toggleTwoFactor(Request $request)
    {
        $admin = auth()->user();
        $admin->update(['two_factor_enabled' => ! $admin->two_factor_enabled]);

        return redirect()->route('admin.security.index')
            ->with('success', $admin->two_factor_enabled
                ? 'Autentikasi dua faktor diaktifkan.'
                : 'Autentikasi dua faktor dinonaktifkan.');
    }
}