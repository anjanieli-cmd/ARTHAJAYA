<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile.edit', [
            'admin' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $admin = auth()->user();

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $admin->id],
            'phone'    => ['nullable', 'string', 'max:30'],
            'position' => ['nullable', 'string', 'max:100'],
            'avatar'   => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($admin->avatar) {
                Storage::disk('supabase')->delete($admin->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'supabase');
        }

        $admin->update($data);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}