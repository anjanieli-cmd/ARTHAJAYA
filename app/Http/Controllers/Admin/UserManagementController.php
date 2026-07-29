<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AccessLevel;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Tampilkan daftar semua user di sistem.
     */
    public function index()
    {
        $users = User::with('company')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.users.index', [
            'users' => $users,
            'accessLevels' => AccessLevel::options(),
        ]);
    }

    /**
     * Tampilkan form buat user baru (dibuatkan langsung oleh admin).
     */
    public function create()
    {
        return view('admin.users.create', [
            'accessLevels' => AccessLevel::options(),
        ]);
    }

    /**
     * Simpan user baru yang dibuat langsung oleh admin.
     * Karena access_level ditentukan sejak awal, akun ini TIDAK akan
     * pernah kena middleware onboarding (kalau dibuat sebagai admin/staff).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'     => ['required', 'string', 'min:8'],
            'access_level' => ['required', 'in:admin,staff,user'],
        ]);

        $user = User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => Hash::make($data['password']),
            'access_level' => $data['access_level'],
        ]);

        ActivityLog::record(
            'create_user',
            "Membuat akun baru untuk {$user->name} ({$user->email}) dengan access level {$data['access_level']}.",
            $user
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Akun {$user->name} berhasil dibuat.");
    }

    /**
     * Tampilkan form edit access_level untuk 1 user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'targetUser' => $user,
            'accessLevels' => AccessLevel::options(),
        ]);
    }

    /**
     * Simpan perubahan access_level (dan reset password opsional).
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'access_level' => ['required', 'in:admin,staff,user'],
            'new_password' => ['nullable', 'string', 'min:8'],
        ]);

        // Proteksi: admin tidak bisa menurunkan access_level akun sendiri
        // supaya tidak ke-lockout dari panel admin secara tidak sengaja.
        if ($user->id === Auth::id() && $data['access_level'] !== AccessLevel::Admin->value) {
            return back()->withErrors([
                'access_level' => 'Kamu tidak bisa menurunkan access level akunmu sendiri.',
            ]);
        }

        $user->access_level = $data['access_level'];

        if (!empty($data['new_password'])) {
            $user->password = Hash::make($data['new_password']);
        }

        $user->save();

        \App\Models\ActivityLog::record(
            'update_user_access',
            "Mengubah access level {$user->name} menjadi {$user->access_level->value}.",
            $user
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Access level {$user->name} berhasil diperbarui.");
    }

    /**
     * Hapus user dari sistem.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors([
                'delete' => 'Kamu tidak bisa menghapus akunmu sendiri.',
            ]);
        }

        \App\Models\ActivityLog::record(
            'delete_user',
            "Menghapus user {$user->name} ({$user->email}).",
            $user
        );

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}