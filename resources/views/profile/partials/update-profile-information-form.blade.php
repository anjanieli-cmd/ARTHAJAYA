<section>
    <h2>Profile Information</h2>
    <div class="desc">Perbarui nama, email, jabatan, dan nomor teleponmu.</div>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="position">Jabatan</label>
            @php
              $positionOptions = ['Owner', 'Direktur', 'Manager', 'Finance Manager', 'Akuntan', 'Staff Administrasi', 'Staff Operasional', 'Lainnya'];
            @endphp
            <select id="position" name="position" class="form-control">
                <option value="">Pilih Jabatan</option>
                @foreach($positionOptions as $opt)
                    <option value="{{ $opt }}" {{ old('position', $user->position) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
            @error('position')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone', $user->phone) }}" autocomplete="tel" placeholder="08xx-xxxx-xxxx">
            @error('phone')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            @if (session('status') === 'profile-updated')
                <span class="form-status">Tersimpan.</span>
            @endif
        </div>
    </form>
</section>