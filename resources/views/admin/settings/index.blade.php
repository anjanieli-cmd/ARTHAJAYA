<x-admin-layout>
    <x-slot name="title">Pengaturan Sistem</x-slot>

    <style>
        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes slideUpBar{ from{ opacity:0; transform:translateY(100%);} to{ opacity:1; transform:translateY(0);} }
        @keyframes checkPop{ 0%{ transform:scale(0.6); opacity:0;} 60%{ transform:scale(1.15);} 100%{ transform:scale(1); opacity:1;} }

        .settings-wrap{ max-width:720px; }
        .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) backwards; }

        .page-head{ margin-bottom:24px; }
        .page-head h1{ font-size:25px; margin-bottom:6px; font-family:'Space Grotesk',sans-serif; }
        .page-head p{ font-size:13.5px; color:var(--text-mute); }

        .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; display:flex; align-items:center; gap:8px; }
        .alert-success .check{ width:18px; height:18px; border-radius:50%; background:var(--emerald); color:#1a1005; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:900; flex-shrink:0; animation:checkPop .4s cubic-bezier(.34,1.56,.64,1); }

        .settings-section{ margin-bottom:28px; }
        .settings-section-label{ font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); font-weight:700; margin-bottom:10px; padding-left:4px; }

        .settings-list{ background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden; }
        .setting-row{ display:flex; align-items:center; gap:16px; padding:18px 22px; border-bottom:1px solid var(--border); transition:background .15s ease; }
        .setting-row:last-child{ border-bottom:none; }
        .setting-row:hover{ background:var(--surface-strong); }
        .setting-row .sr-body{ flex:1; min-width:0; }
        .setting-row .sr-title{ font-size:13.5px; font-weight:600; color:var(--text); margin-bottom:2px; }
        .setting-row .sr-desc{ font-size:12px; color:var(--text-faint); line-height:1.4; }
        .setting-row .sr-control{ flex-shrink:0; }

        .field-inline{ width:220px; padding:9px 12px; border-radius:10px; background:var(--surface-strong); border:1px solid var(--border); color:var(--text); font-size:13px; outline:none; }
        .field-inline:focus{ border-color:var(--border-hover); }
        textarea.field-inline{ width:260px; min-height:60px; resize:vertical; }

        /* Toggle switch */
        .switch{ position:relative; width:44px; height:25px; flex-shrink:0; }
        .switch input{ opacity:0; width:0; height:0; position:absolute; }
        .switch-track{ position:absolute; inset:0; background:var(--surface-strong); border:1px solid var(--border); border-radius:100px; cursor:pointer; transition:.25s; }
        .switch-track::before{ content:''; position:absolute; width:17px; height:17px; left:3px; top:2.5px; background:var(--text-faint); border-radius:50%; transition:.25s cubic-bezier(.34,1.56,.64,1); }
        .switch input:checked + .switch-track{ background:rgba(var(--danger-rgb),0.25); border-color:var(--danger); }
        .switch input:checked + .switch-track::before{ transform:translateX(19px); background:var(--danger); }

        /* Sticky save bar */
        .save-bar{
            position:fixed; left:264px; right:24px; bottom:24px; z-index:120;
            background:var(--modal-bg); border:1px solid var(--border); border-radius:16px;
            padding:14px 20px; display:none; align-items:center; justify-content:space-between; gap:16px;
            box-shadow:0 20px 50px rgba(0,0,0,0.4); animation:slideUpBar .3s cubic-bezier(.16,1,.3,1);
        }
        .save-bar.show{ display:flex; }
        .save-bar .msg{ font-size:13px; color:var(--text-mute); }
        .save-bar .actions{ display:flex; gap:10px; }
        .btn{ display:inline-flex; align-items:center; gap:8px; padding:9px 18px; border-radius:10px; font-size:13px; font-weight:600; cursor:pointer; border:none; transition:transform .15s ease; }
        .btn:active{ transform:scale(.95); }
        .btn-primary{ background:var(--emerald); color:#1a1005; }
        .btn-ghost{ background:none; color:var(--text-mute); border:1px solid var(--border); }

        @media (max-width:900px){ .save-bar{ left:16px; right:16px; } }
        @media (max-width:640px){
            .setting-row{ flex-direction:column; align-items:flex-start; }
            .field-inline, textarea.field-inline{ width:100%; }
        }
    </style>

    <div class="settings-wrap">
        <div class="page-head animate-in" style="animation-delay:.05s;">
            <h1>Pengaturan Sistem</h1>
            <p>Konfigurasi umum untuk seluruh platform Arvessa.</p>
        </div>

        @if(session('success'))
            <div class="alert-success animate-in" style="animation-delay:.08s;">
                <span class="check">✓</span> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}" id="settingsForm">
            @csrf
            @method('PUT')

            <div class="settings-section animate-in" style="animation-delay:.12s;">
                <div class="settings-section-label">Umum</div>
                <div class="settings-list">
                    <div class="setting-row">
                        <div class="sr-body">
                            <div class="sr-title">Nama Aplikasi</div>
                            <div class="sr-desc">Ditampilkan di judul tab browser dan email sistem.</div>
                        </div>
                        <div class="sr-control">
                            <input type="text" name="app_name" class="field-inline" value="{{ old('app_name', $settings['app_name'] ?? 'Arvessa') }}">
                        </div>
                    </div>
                    <div class="setting-row">
                        <div class="sr-body">
                            <div class="sr-title">Email Dukungan</div>
                            <div class="sr-desc">Alamat email yang ditampilkan untuk bantuan pengguna.</div>
                        </div>
                        <div class="sr-control">
                            <input type="email" name="support_email" class="field-inline" placeholder="support@arvessa.com" value="{{ old('support_email', $settings['support_email'] ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings-section animate-in" style="animation-delay:.18s;">
                <div class="settings-section-label">Mode Perawatan</div>
                <div class="settings-list">
                    <div class="setting-row">
                        <div class="sr-body">
                            <div class="sr-title">Aktifkan Mode Maintenance</div>
                            <div class="sr-desc">Jika aktif, semua user (kecuali admin) akan melihat halaman perawatan.</div>
                        </div>
                        <div class="sr-control">
                            <label class="switch">
                                <input type="checkbox" name="maintenance_mode" value="1" {{ old('maintenance_mode', ($settings['maintenance_mode'] ?? '0') == '1') ? 'checked' : '' }}>
                                <span class="switch-track"></span>
                            </label>
                        </div>
                    </div>
                    <div class="setting-row">
                        <div class="sr-body">
                            <div class="sr-title">Pesan Maintenance</div>
                            <div class="sr-desc">Teks yang ditampilkan ke user saat mode perawatan aktif.</div>
                        </div>
                        <div class="sr-control">
                            <textarea name="maintenance_message" class="field-inline" placeholder="Sedang dalam perbaikan, coba lagi nanti.">{{ old('maintenance_message', $settings['maintenance_message'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="save-bar" id="saveBar">
                <div class="msg">Ada perubahan yang belum disimpan.</div>
                <div class="actions">
                    <button type="button" class="btn btn-ghost" onclick="document.getElementById('settingsForm').reset(); document.getElementById('saveBar').classList.remove('show');">Batalkan</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        (function(){
            var form = document.getElementById('settingsForm');
            var bar = document.getElementById('saveBar');
            if(!form || !bar) return;
            form.addEventListener('input', function(){ bar.classList.add('show'); });
            form.addEventListener('change', function(){ bar.classList.add('show'); });
        })();
    </script>
</x-admin-layout>