<section>
    <h2>Update Password</h2>
    <div class="desc">Gunakan password yang panjang dan acak supaya akunmu tetap aman.</div>

    <form method="post" action="{{ route('security.password.update') }}" class="mt-6">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
            @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="update_password_password">Password Baru</label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">Konfirmasi Password Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
            @error('password_confirmation')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Perbarui Password</button>
            @if (session('success'))
                <span class="form-status">Tersimpan.</span>
            @endif
        </div>
    </form>
</section>