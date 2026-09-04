<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        /*
         * Ambil data yang sudah divalidasi.
         */
        $validated = $request->validated();

        /*
         * Jangan masukkan file avatar dan remove_photo
         * ke dalam fill() karena diproses manual.
         */
        unset(
            $validated['avatar'],
            $validated['remove_photo']
        );

        /*
         * ==========================================
         * UPDATE DATA PROFIL
         * ==========================================
         */
        $user->fill($validated);

        /*
         * Jika email berubah,
         * reset verifikasi email.
         */
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        /*
         * ==========================================
         * FOTO PROFIL
         * ==========================================
         */

        /*
         * Simpan avatar lama terlebih dahulu.
         *
         * Contoh:
         * avatars/abc123.jpg
         */
        $oldAvatar = $user->avatar;

        /*
         * ==========================================
         * HAPUS FOTO PROFIL
         * ==========================================
         *
         * Hapus hanya jika:
         *
         * 1. remove_photo dicentang
         * 2. tidak ada foto baru
         * 3. user memiliki avatar
         */
        if (
            $request->boolean('remove_photo') &&
            !$request->hasFile('avatar') &&
            !empty($oldAvatar)
        ) {

            /*
             * Hapus file lama dari:
             *
             * storage/app/public/avatars
             */
            if (Storage::disk('public')->exists($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
            }

            /*
             * Kosongkan avatar di database.
             */
            $user->avatar = null;
        }

        /*
         * ==========================================
         * UPLOAD FOTO BARU
         * ==========================================
         */
        if ($request->hasFile('avatar')) {

            $avatar = $request->file('avatar');

            /*
             * Pastikan file benar-benar valid.
             */
            if ($avatar->isValid()) {

                /*
                 * Hapus avatar lama jika ada.
                 */
                if (!empty($oldAvatar)) {

                    if (
                        Storage::disk('public')->exists(
                            $oldAvatar
                        )
                    ) {
                        Storage::disk('public')->delete(
                            $oldAvatar
                        );
                    }
                }

                /*
                 * Simpan foto baru ke:
                 *
                 * storage/app/public/avatars
                 *
                 * Hasilnya misalnya:
                 *
                 * avatars/AbCdEf123.jpg
                 */
                $newAvatar = $avatar->store(
                    'avatars',
                    'public'
                );

                /*
                 * Simpan path avatar ke database.
                 */
                $user->avatar = $newAvatar;
            }
        }

        /*
         * ==========================================
         * SIMPAN USER
         * ==========================================
         */
        $user->save();

        /*
         * ==========================================
         * KEMBALI KE HALAMAN PROFILE
         * ==========================================
         */
        return Redirect::route('profile.edit')
            ->with(
                'status',
                'profile-updated'
            );
    }

    /**
     * Delete the user's account.
     */
    public function destroy(
        Request $request
    ): RedirectResponse {

        /*
         * ==========================================
         * VALIDASI PASSWORD
         * ==========================================
         */
        $request->validateWithBag(
            'userDeletion',
            [
                'password' => [
                    'required',
                    'current_password',
                ],
            ]
        );

        /*
         * Ambil user yang sedang login.
         */
        $user = $request->user();

        /*
         * ==========================================
         * HAPUS FOTO PROFIL
         * ==========================================
         */
        if (!empty($user->avatar)) {

            if (
                Storage::disk('public')->exists(
                    $user->avatar
                )
            ) {
                Storage::disk('public')->delete(
                    $user->avatar
                );
            }
        }

        /*
         * ==========================================
         * LOGOUT
         * ==========================================
         */
        Auth::logout();

        /*
         * ==========================================
         * HAPUS AKUN
         * ==========================================
         */
        $user->delete();

        /*
         * ==========================================
         * RESET SESSION
         * ==========================================
         */
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        /*
         * ==========================================
         * KEMBALI KE HALAMAN UTAMA
         * ==========================================
         */
        return Redirect::to('/');
    }
}