<x-app-layout>
    <x-slot name="title">Edit Klien</x-slot>

<style>
    .page-head h1 { font-size: 24px; margin-bottom: 6px; }
    .page-head p { font-size: 14px; color: var(--text-mute); margin-bottom: 24px; }
    .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: 20px; padding: 36px 40px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-size: 12.5px; color:var(--text-mute); font-weight: 500; margin-bottom: 7px; }
    .form-group label .required { color: var(--danger); }
    .form-control {
        width: 100%; padding: 12px 14px; border-radius: 12px; background: var(--surface-strong);
        border: 1px solid var(--border); color: var(--text); font-size: 14px; outline: none;
        transition: all .2s ease; font-family: inherit;
    }
    .form-control:focus { border-color: var(--border-hover); background: var(--surface); }
    textarea.form-control { resize: vertical; min-height: 110px; }
    .form-error { color: var(--danger); font-size: 12px; margin-top: 4px; }
    .form-actions { display: flex; justify-content:flex-end; gap: 12px; margin-top: 32px; padding-top:26px; border-top:1px solid var(--border); }
    .btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px 26px; border-radius: 12px; font-size: 13.5px; font-weight: 600;
        cursor: pointer; border: none; transition: all .2s ease;
    }
    .btn-primary { background: var(--emerald); color: #052117; box-shadow: 0 4px 20px rgba(var(--emerald-rgb), 0.3); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 26px rgba(var(--emerald-rgb), 0.45); }
    .btn-outline { background: var(--surface); border: 1px solid var(--border); color: var(--text); }
    .btn-outline:hover { background: var(--surface-strong); border-color: var(--border-hover); }
    .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
    .full { grid-column:1/-1; }
    @media (max-width:1200px){ .grid-3{ grid-template-columns:1fr 1fr; } }
    @media (max-width:700px){ .grid-3{ grid-template-columns:1fr; } .form-card{ padding:24px 20px; } }
</style>

<div class="page-head">
    <div>
        <h1>Edit Klien</h1>
        <p>Perbarui data klien.</p>
    </div>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('clients.update', $client) }}">
        @csrf @method('PUT')

        <div class="grid-3">
            <div class="form-group">
                <label>Nama Klien <span class="required">*</span></label>
                <input type="text" name="name" value="{{ old('name', $client->name) }}" class="form-control" required>
                @error('name') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Nama Perusahaan</label>
                <input type="text" name="company_name" value="{{ old('company_name', $client->company_name) }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $client->email) }}" class="form-control">
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="form-control">
            </div>

            <div class="form-group full">
                <label>Alamat</label>
                <textarea name="address" class="form-control">{{ old('address', $client->address) }}</textarea>
            </div>

            <div class="form-group full">
                <label>Catatan</label>
                <textarea name="notes" class="form-control">{{ old('notes', $client->notes) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('clients.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
</x-app-layout>