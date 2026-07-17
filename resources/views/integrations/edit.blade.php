<x-app-layout>
  <x-slot name="title">Pengaturan Integrasi</x-slot>

  <style>
    .st-wrap{max-width:640px;}
    .st-status{display:flex;justify-content:space-between;align-items:center;background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:18px 22px;margin-bottom:18px;}
    .st-status .l{font-size:12px;color:var(--text-mute);}
    .st-status .v{font-size:15px;font-weight:700;}
    .st-dot{width:9px;height:9px;border-radius:50%;display:inline-block;margin-right:6px;}
    .dot-connected{background:var(--emerald);}
    .dot-disconnected{background:var(--text-faint);}
    .dot-error{background:var(--danger);}
    .st-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:26px;}
    .form-group{margin-bottom:16px;}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;}
    .form-control{width:100%;padding:10px 14px;border-radius:12px;background:var(--surface);border:1px solid var(--border);color:var(--text);font-size:13.5px;outline:none;}
    .danger-zone{border:1px solid rgba(232,90,122,0.3);border-radius:14px;padding:16px 18px;margin-top:18px;}
    .danger-zone h4{color:var(--danger);font-size:13px;margin-bottom:4px;}
    .danger-zone p{font-size:12px;color:var(--text-mute);margin-bottom:10px;}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:12px;font-size:13.5px;font-weight:600;cursor:pointer;border:none;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface);border:1px solid var(--border);color:var(--text);}
    .btn-danger{background:transparent;border:1px solid var(--danger);color:var(--danger);}
  </style>

  <div class="page-head"><div><h1>{{ $integration->name }}</h1><p>{{ $providers[$integration->provider]['label'] ?? $integration->provider }}</p></div></div>

  <div class="st-wrap">
    <div class="st-status">
      <div>
        <div class="l">Status Koneksi</div>
        <div class="v"><span class="st-dot dot-{{ $integration->status }}"></span>{{ ucfirst($integration->status) }}</div>
      </div>
      <div style="text-align:right;">
        <div class="l">Terhubung Sejak</div>
        <div class="v mono" style="font-size:13px;">{{ optional($integration->connected_at)->format('d M Y') ?? '—' }}</div>
      </div>
    </div>

    <div class="st-card">
      <form method="POST" action="{{ route('integrations.update', $integration) }}">
        @csrf @method('PUT')
        <div class="form-group">
          <label>Nama Tampilan</label>
          <input type="text" name="name" value="{{ old('name', $integration->name) }}" class="form-control" required>
        </div>
        <div class="form-group">
          <label>API Key</label>
          <input type="text" name="api_key" value="{{ old('api_key', $integration->api_key) }}" class="form-control">
        </div>
        <div class="form-group">
          <label>API Secret</label>
          <input type="password" name="api_secret" placeholder="•••••••• (kosongkan jika tidak diubah)" class="form-control">
        </div>
        <div class="form-group">
          <label>Webhook URL</label>
          <input type="url" name="webhook_url" value="{{ old('webhook_url', $integration->webhook_url) }}" class="form-control">
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control" required>
            <option value="connected" {{ $integration->status == 'connected' ? 'selected' : '' }}>Aktif</option>
            <option value="disconnected" {{ $integration->status == 'disconnected' ? 'selected' : '' }}>Nonaktif</option>
          </select>
        </div>
        <div style="display:flex;gap:12px;margin-top:20px;">
          <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
          <a href="{{ route('integrations.index') }}" class="btn btn-outline">Kembali</a>
        </div>
      </form>
    </div>

    <div class="danger-zone">
      <h4>Putuskan Integrasi</h4>
      <p>Semua kredensial dan pengaturan layanan ini akan dihapus permanen.</p>
      <form action="{{ route('integrations.destroy', $integration) }}" method="POST" onsubmit="return confirm('Putuskan integrasi ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">Putuskan Integrasi</button>
      </form>
    </div>
  </div>
</x-app-layout>