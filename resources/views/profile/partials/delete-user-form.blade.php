<section>
    <h2>Hapus Akun</h2>
    <div class="desc">Setelah akun dihapus, seluruh data dan aksesmu akan hilang secara permanen. Unduh data penting sebelum melanjutkan.</div>

    <form method="post" action="{{ route('profile.destroy') }}"
        onsubmit="return confirm('Yakin ingin menghapus akun ini secara permanen? Tindakan ini tidak bisa dibatalkan.')">
        @csrf
        @method('delete')

        <div class="form-group" style="max-width:340px;">
            <label for="password">Konfirmasi Password</label>
            <input id="password" name="password" type="password" class="form-control" placeholder="Masukkan password untuk konfirmasi">
            @error('password', 'userDeletion')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-danger">Hapus Akun Saya</button>
        </div>
    </form>
</section>