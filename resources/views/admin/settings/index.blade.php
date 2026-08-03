<x-admin-layout>
    <x-slot name="title">Pengaturan Sistem</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-gear" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-globe" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </symbol>
            <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="22 6 12 13 2 6"/>
            </symbol>
            <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/><polyline points="9 12 11 14 15 10"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .settings-wrap {
            --theme-primary: var(--emerald);
            --theme-light: var(--emerald);
            --theme-dark: var(--emerald-dim);
            --theme-glow: rgba(var(--emerald-rgb), 0.25);
            --theme-soft: rgba(var(--emerald-rgb), 0.12);
            --theme-gradient: linear-gradient(135deg, var(--emerald), var(--emerald-dim));
            
            --text-primary: var(--text);
            --text-secondary: var(--text-mute);
            --text-tertiary: var(--text-faint);
            
            --bg-card: var(--surface);
            --bg-card-hover: var(--surface-strong);
            --bg-card-active: rgba(255, 255, 255, 0.04);
            --border-color: var(--border);
            --border-hover: var(--border-hover);
            
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
            width: 100%;
        }

        .settings-wrap * { box-sizing:border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUpBar {
            from { opacity: 0; transform: translateY(100%); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes checkPop {
            0% { transform: scale(0.6); opacity: 0; }
            60% { transform: scale(1.15); }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .settings-wrap .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .settings-wrap .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            display: inline-block;
            vertical-align: middle;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ===== HEADER ===== */
        .settings-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .settings-header-left {
            flex: 1;
            min-width: 200px;
        }

        .settings-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px 6px 10px;
            background: var(--theme-glow);
            border: 1px solid var(--theme-glow);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--theme-primary);
            margin-bottom: 12px;
        }

        .settings-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .settings-header h1 {
            font-size: 32px;
            font-weight: 900;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .settings-header h1 .highlight {
            background: linear-gradient(135deg, var(--text-primary) 55%, var(--theme-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .settings-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        /* ===== ALERT SUCCESS ===== */
        .alert-success {
            background: rgba(var(--emerald-rgb), 0.1);
            border: 1px solid rgba(var(--emerald-rgb), 0.3);
            color: var(--emerald);
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            animation: checkPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* ===== SETTINGS SECTION ===== */
        .settings-section {
            margin-bottom: 28px;
        }

        .settings-section-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-tertiary);
            font-weight: 700;
            margin-bottom: 12px;
            padding-left: 4px;
        }

        .settings-section-label .icon {
            width: 14px;
            height: 14px;
        }

        .settings-list {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: border-color 0.3s ease;
        }

        .settings-list:hover {
            border-color: var(--border-hover);
        }

        .setting-row {
            display: flex;
            align-items: center;
            gap: 24px;
            padding: 22px 28px;
            border-bottom: 1px solid var(--border-color);
            transition: background 0.15s ease;
        }

        .setting-row:last-child {
            border-bottom: none;
        }

        .setting-row:hover {
            background: var(--bg-card-hover);
        }

        .setting-row .sr-body {
            flex: 1;
            min-width: 0;
        }

        .setting-row .sr-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 3px;
        }

        .setting-row .sr-desc {
            font-size: 12.5px;
            color: var(--text-tertiary);
            line-height: 1.6;
            max-width: 520px;
        }

        .setting-row .sr-control {
            flex-shrink: 0;
            width: 380px;
        }

        .field-inline {
            width: 100%;
            padding: 11px 16px;
            border-radius: 10px;
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: all 0.3s ease;
        }

        .field-inline:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
            background: var(--bg-card);
        }

        .field-inline::placeholder {
            color: var(--text-tertiary);
        }

        textarea.field-inline {
            min-height: 80px;
            resize: vertical;
        }

        /* ===== TOGGLE SWITCH ===== */
        .switch {
            position: relative;
            width: 48px;
            height: 26px;
            flex-shrink: 0;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .switch-track {
            position: absolute;
            inset: 0;
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: 100px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .switch-track::before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            left: 3px;
            top: 2.5px;
            background: var(--text-tertiary);
            border-radius: 50%;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .switch input:checked + .switch-track {
            background: var(--danger-soft);
            border-color: var(--danger);
        }

        .switch input:checked + .switch-track::before {
            transform: translateX(22px);
            background: var(--danger);
        }

        .switch input:focus + .switch-track {
            box-shadow: 0 0 0 3px var(--danger-soft);
        }

        /* ===== SAVE BAR ===== */
        .save-bar {
            position: fixed;
            left: 264px;
            right: 24px;
            bottom: 24px;
            z-index: 120;
            background: var(--modal-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 16px 24px;
            display: none;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            animation: slideUpBar 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            backdrop-filter: blur(12px);
        }

        .save-bar.show {
            display: flex;
        }

        .save-bar .msg {
            font-size: 13px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .save-bar .msg .icon {
            width: 16px;
            height: 16px;
            color: var(--theme-primary);
        }

        .save-bar .actions {
            display: flex;
            gap: 10px;
        }

        .settings-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: 'Inter', sans-serif;
        }

        .settings-btn:active {
            transform: scale(0.95);
        }

        .settings-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .settings-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
        }

        .settings-btn-ghost {
            background: none;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .settings-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        .settings-btn .icon {
            width: 16px;
            height: 16px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1100px) {
            .setting-row {
                flex-wrap: wrap;
            }

            .setting-row .sr-control {
                width: 100%;
            }

            .save-bar {
                left: 16px;
                right: 16px;
                bottom: 16px;
                padding: 14px 18px;
                flex-wrap: wrap;
            }

            .save-bar .actions {
                width: 100%;
            }

            .save-bar .actions .settings-btn {
                flex: 1;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .settings-wrap {
                padding: 0 12px;
            }

            .settings-header {
                flex-direction: column;
            }

            .settings-header h1 {
                font-size: 24px;
            }

            .setting-row {
                padding: 18px 20px;
                gap: 16px;
            }

            .setting-row .sr-title {
                font-size: 13px;
            }

            .setting-row .sr-desc {
                font-size: 12px;
            }

            .save-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .save-bar .msg {
                text-align: center;
                justify-content: center;
            }

            .save-bar .actions {
                flex-direction: column;
            }

            .settings-btn {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .settings-header h1 {
                font-size: 20px;
            }

            .settings-header p {
                font-size: 13px;
            }

            .settings-section-label {
                font-size: 10px;
            }

            .setting-row {
                padding: 14px 16px;
            }

            .field-inline {
                font-size: 12.5px;
                padding: 9px 12px;
            }

            .switch {
                width: 42px;
                height: 24px;
            }

            .switch-track::before {
                width: 16px;
                height: 16px;
                left: 2.5px;
                top: 2.5px;
            }

            .switch input:checked + .switch-track::before {
                transform: translateX(19px);
            }
        }

        @media (max-width: 380px) {
            .settings-header h1 {
                font-size: 18px;
            }

            .settings-btn {
                font-size: 12px;
                padding: 8px 14px;
            }

            .settings-btn .icon {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="settings-wrap">

        <!-- ===== HEADER ===== -->
        <div class="settings-header animate-in" style="animation-delay: 0.03s;">
            <div class="settings-header-left">
                <div class="settings-badge">
                    <span class="dot"></span>
                    Konfigurasi
                </div>
                <h1><span class="highlight">Pengaturan Sistem</span></h1>
                <p>Konfigurasi umum untuk seluruh platform Arvessa.</p>
            </div>
        </div>

        <!-- ===== ALERT SUCCESS ===== -->
        @if(session('success'))
            <div class="alert-success animate-in" style="animation-delay: 0.06s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- ===== FORM ===== -->
        <form method="POST" action="{{ route('admin.settings.update') }}" id="settingsForm">
            @csrf
            @method('PUT')

            <!-- ===== SECTION UMUM ===== -->
            <div class="settings-section animate-in" style="animation-delay: 0.1s;">
                <div class="settings-section-label">
                    <svg class="icon"><use href="#ic-gear"/></svg>
                    Umum
                </div>
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

            <!-- ===== SECTION MODE PERAWATAN ===== -->
            <div class="settings-section animate-in" style="animation-delay: 0.16s;">
                <div class="settings-section-label">
                    <svg class="icon"><use href="#ic-shield"/></svg>
                    Mode Perawatan
                </div>
                <div class="settings-list">
                    <div class="setting-row">
                        <div class="sr-body">
                            <div class="sr-title">Aktifkan Mode Maintenance</div>
                            <div class="sr-desc">Jika aktif, semua user (kecuali admin) akan melihat halaman perawatan.</div>
                        </div>
                        <div class="sr-control" style="width:auto;">
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

            <!-- ===== SAVE BAR ===== -->
            <div class="save-bar" id="saveBar">
                <div class="msg">
                    <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                    Ada perubahan yang belum disimpan.
                </div>
                <div class="actions">
                    <button type="button" class="settings-btn settings-btn-ghost" onclick="document.getElementById('settingsForm').reset(); document.getElementById('saveBar').classList.remove('show');">
                        Batalkan
                    </button>
                    <button type="submit" class="settings-btn settings-btn-primary">
                        <svg class="icon"><use href="#ic-check-circle"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        (function(){
            var form = document.getElementById('settingsForm');
            var bar = document.getElementById('saveBar');
            if(!form || !bar) return;

            var initialData = new FormData(form);

            function checkChanges() {
                var currentData = new FormData(form);
                var hasChanges = false;

                for (var pair of initialData.entries()) {
                    var key = pair[0];
                    var initialValue = pair[1];
                    var currentValue = currentData.get(key);
                    if (initialValue !== currentValue) {
                        hasChanges = true;
                        break;
                    }
                }

                // Check checkbox separately
                var checkboxes = form.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(function(cb) {
                    var initialChecked = cb.defaultChecked;
                    var currentChecked = cb.checked;
                    if (initialChecked !== currentChecked) {
                        hasChanges = true;
                    }
                });

                if (hasChanges) {
                    bar.classList.add('show');
                } else {
                    bar.classList.remove('show');
                }
            }

            form.addEventListener('input', checkChanges);
            form.addEventListener('change', checkChanges);

            // Reset button
            var resetBtn = document.querySelector('.settings-btn-ghost');
            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    form.reset();
                    bar.classList.remove('show');
                });
            }
        })();
    </script>
</x-admin-layout>