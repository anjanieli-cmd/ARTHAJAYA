<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Enums\AccessLevel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan access_level (hak akses sistem)
            // Catatan: sengaja TIDAK pakai redirect()->intended() di sini,
            // karena kalau ada URL lama tersimpan di session (dari percobaan
            // akses sebelum login), intended() akan pakai itu dan mengabaikan
            // tujuan berdasarkan access_level yang sudah kita tentukan.
            if ($user->access_level === AccessLevel::Admin) {
                return redirect('/admin/dashboard');
            }

            if ($user->access_level === AccessLevel::Staff) {
                return redirect('/staff/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        \App\Models\AdminNotification::notify(
            'new_user',
            'User baru mendaftar',
            "{$user->name} ({$user->email}) baru saja membuat akun.",
            'users'
        );

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}