<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Invitation;
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

        $intendedRole = $request->input('intended_role', 'user');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // ===== CROSS-CHECK: klaim role vs access_level asli di DB =====
            $roleMap = [
                'admin' => AccessLevel::Admin,
                'staff' => AccessLevel::Staff,
                'user'  => AccessLevel::User,
            ];

            $claimedLevel = $roleMap[$intendedRole] ?? null;

            if ($claimedLevel !== null && $user->access_level !== $claimedLevel) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $roleLabel = [
                    'admin' => 'Admin',
                    'staff' => 'Staff',
                    'user'  => 'User',
                ][$intendedRole] ?? $intendedRole;

                return back()->withErrors([
                    'email' => "Akun ini bukan role {$roleLabel}. Silakan pilih role yang sesuai dengan akun Anda.",
                ])->onlyInput('email');
            }

            // Redirect berdasarkan access_level
            if ($user->access_level === AccessLevel::Admin) {
                return redirect('/admin/dashboard');
            }

            if ($user->access_level === AccessLevel::Staff) {
                return redirect('/staff/dashboard');
            }

            if ($user->access_level === AccessLevel::User) {
                return redirect('/user/dashboard');
            }

            return redirect('/dashboard');
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
        $intendedRole = $request->input('intended_role', 'staff');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ];

        if ($intendedRole === 'user') {
            $rules['invite_code'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        // ===== USER: register via invite code =====
        if ($intendedRole === 'user') {
            $invitation = Invitation::where('code', strtoupper($validated['invite_code']))->first();

            if (! $invitation || ! $invitation->isValid()) {
                return back()->withErrors([
                    'invite_code' => 'Kode undangan tidak valid atau sudah kedaluwarsa.',
                ])->onlyInput('name', 'email');
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'access_level' => AccessLevel::User,
                'company_id' => $invitation->company_id,
            ]);

            $invitation->update([
                'used_at' => now(),
                'used_by' => $user->id,
            ]);

            \App\Models\AdminNotification::notify(
                'new_user',
                'User baru mendaftar',
                "{$user->name} ({$user->email}) bergabung lewat undangan.",
                'users'
            );

            Auth::login($user);

            return redirect('/user/dashboard');
        }

        // ===== STAFF: self-register (pemilik bisnis) =====
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'access_level' => AccessLevel::Staff,
        ]);

        \App\Models\AdminNotification::notify(
            'new_user',
            'User baru mendaftar',
            "{$user->name} ({$user->email}) baru saja membuat akun.",
            'users'
        );

        Auth::login($user);

        // Staff baru harus onboarding dulu untuk buat company
        return redirect()->route('onboarding.show');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}