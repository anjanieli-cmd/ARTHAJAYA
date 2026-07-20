<x-app-layout>
  <x-slot name="title">Hubungkan Integrasi</x-slot>

  <style>
    .cc-wrap{max-width:640px;}
    .cc-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:26px;}
    .form-group{margin-bottom:16px;}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;}
    .form-control{width:100%;padding:10px 14px;border-radius:12px;background:var(--surface);border:1px solid var(--border);color:var(--text);font-size:13.5px;outline:none;}
    .hint{font-size:11.5px;color:var(--text-faint);margin-top:4px;}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:12px;font-size:13.5px;font-weight:600;cursor:pointer;border:none;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface);border:1px solid var(--border);color:var(--text);}
  </style>

  <div class="page-head"><div><h1>Hubungkan Integrasi</h1><p>Masukkan kredensial layanan yang ingin dihubungkan.</p></div></div>

  <div class="cc-wrap">
    <div class="cc-card">
      <form method="POST" action="{{ route('integrations.store') }}">
        @csrf
        <div class="form-group">
          <label>Layanan</label>
          <select name="provider" class="form-control" required>
            <option value="">Pilih Layanan</option>
            @foreach($providers as $key => $p)
              <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $p['label'] }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Nama Tampilan</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Misal: WhatsApp Notifikasi Utama" required>
        </div>
        <div class="form-group">
          <label>API Key</label>
          <input type="text" name="api_key" value="{{ old('api_key') }}" class="form-control">
        </div>
        <div class="form-group">
          <label>API Secret</label>
          <input type="password" name="api_secret" value="{{ old('api_secret') }}" class="form-control">
        </div>
        <div class="form-group">
          <label>Webhook URL (opsional)</label>
          <input type="url" name="webhook_url" value="{{ old('webhook_url') }}" class="form-control" placeholder="https://...">
          <div class="hint">Digunakan untuk menerima notifikasi real-time dari layanan ini.</div>
        </div>
        <div style="display:flex;gap:12px;margin-top:20px;">
          <button type="submit" class="btn btn-primary">Hubungkan Sekarang</button>
          <a href="{{ route('integrations.index') }}" class="btn btn-outline">Batal</a>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>