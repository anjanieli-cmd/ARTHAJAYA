<x-app-layout>
    <x-slot name="title">Undang Anggota Baru</x-slot>

    @php
        // Data dummy untuk modules
        $modules = $modules ?? [
            'invoices' => [
                'label' => 'Invoice',
                'actions' => ['view', 'create', 'edit', 'delete']
            ],
            'quotes' => [
                'label' => 'Quotation',
                'actions' => ['view', 'create', 'edit', 'delete']
            ],
            'clients' => [
                'label' => 'Klien',
                'actions' => ['view', 'create', 'edit', 'delete']
            ],
            'expenses' => [
                'label' => 'Pengeluaran',
                'actions' => ['view', 'create', 'edit']
            ],
            'reports' => [
                'label' => 'Laporan',
                'actions' => ['view', 'export']
            ],
            'settings' => [
                'label' => 'Pengaturan',
                'actions' => ['view', 'manage']
            ],
        ];

        // Template permission per role
        $roleTemplates = [
            'Admin' => [
                'invoices' => ['view', 'create', 'edit', 'delete'],
                'quotes' => ['view', 'create', 'edit', 'delete'],
                'clients' => ['view', 'create', 'edit', 'delete'],
                'expenses' => ['view', 'create', 'edit'],
                'reports' => ['view', 'export'],
                'settings' => ['view', 'manage'],
            ],
            'Manager' => [
                'invoices' => ['view', 'create', 'edit'],
                'quotes' => ['view', 'create', 'edit'],
                'clients' => ['view', 'create', 'edit'],
                'expenses' => ['view', 'create', 'edit'],
                'reports' => ['view', 'export'],
                'settings' => ['view'],
            ],
            'Staff' => [
                'invoices' => ['view', 'create'],
                'quotes' => ['view', 'create'],
                'clients' => ['view'],
                'expenses' => ['view', 'create'],
                'reports' => ['view'],
                'settings' => [],
            ],
            'Viewer' => [
                'invoices' => ['view'],
                'quotes' => ['view'],
                'clients' => ['view'],
                'expenses' => ['view'],
                'reports' => ['view'],
                'settings' => [],
            ],
        ];

        $roleLabels = [
            'Admin' => ['desc' => 'Akses penuh ke semua fitur.', 'icon' => '👑', 'color' => '#34B583'],
            'Manager' => ['desc' => 'Kelola operasional harian.', 'icon' => '📊', 'color' => '#4E8FF0'],
            'Staff' => ['desc' => 'Input data transaksi.', 'icon' => '📝', 'color' => '#F0A83C'],
            'Viewer' => ['desc' => 'Hanya bisa melihat data.', 'icon' => '👁️', 'color' => '#9B7BE0'],
        ];
    @endphp

    <style>
        /* ============================================
           UNDANG ANGGOTA - Modern Design
           ============================================ */
        
        .invite-wrap {
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
            
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .invite-wrap * { box-sizing: border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .invite-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .invite-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* PAGE HEADER */
        .invite-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .invite-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .invite-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: 'Inter', sans-serif;
        }

        .invite-back-btn .icon { width: 16px; height: 16px; }
        
        .invite-back-btn:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateX(-4px);
        }

        .invite-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .invite-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 2px 0 0;
        }

        /* LAYOUT */
        .invite-layout {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1000px) {
            .invite-layout { grid-template-columns: 1fr; }
        }

        /* SIDEBAR */
        .invite-side {
            position: sticky;
            top: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .invite-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px;
            transition: all 0.3s ease;
        }

        .invite-card:hover {
            border-color: var(--border-hover);
        }

        .invite-card h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 4px;
        }

        .invite-card .desc {
            font-size: 12.5px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin: 0 0 20px;
        }

        /* ROLE OPTIONS */
        .role-option {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: var(--radius-sm);
            border: 2px solid var(--border-color);
            background: var(--bg-card-active);
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .role-option:last-child { margin-bottom: 0; }

        .role-option:hover {
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
            transform: translateX(4px);
        }

        .role-option.checked {
            border-color: var(--theme-primary);
            background: var(--theme-soft);
            box-shadow: 0 0 0 4px var(--theme-soft);
        }

        .role-option.checked::before {
            content: '✓';
            position: absolute;
            top: -6px;
            right: -6px;
            width: 22px;
            height: 22px;
            background: var(--theme-primary);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
        }

        .role-radio {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid var(--border-hover);
            flex-shrink: 0;
            margin-top: 2px;
            position: relative;
            transition: all 0.2s ease;
        }

        .role-option.checked .role-radio {
            border-color: var(--theme-primary);
            background: var(--theme-primary);
        }

        .role-option.checked .role-radio:after {
            content: '';
            position: absolute;
            inset: 5px;
            border-radius: 50%;
            background: #fff;
        }

        .role-option input { display: none; }

        .role-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--bg-card);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 18px;
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
        }

        .role-option.checked .role-icon {
            border-color: var(--theme-primary);
            background: var(--theme-soft);
        }

        .role-text .t {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .role-text .d {
            font-size: 11.5px;
            color: var(--text-secondary);
            margin-top: 2px;
            line-height: 1.4;
        }

        .role-badge {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 2px 8px;
            border-radius: 100px;
            background: var(--theme-soft);
            color: var(--theme-primary);
            margin-top: 2px;
        }

        /* HINT */
        .invite-hint {
            background: var(--theme-soft);
            border: 1px solid rgba(var(--emerald-rgb), 0.2);
            border-radius: var(--radius-sm);
            padding: 16px 18px;
        }

        .invite-hint .t {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--theme-primary);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .invite-hint p {
            font-size: 11.5px;
            color: var(--text-secondary);
            line-height: 1.7;
            margin: 0;
        }

        /* MAIN FORM */
        .invite-main {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 28px 32px;
            transition: all 0.3s ease;
        }

        .invite-main:hover {
            border-color: var(--border-hover);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-primary);
        }

        .form-group label .required {
            color: var(--danger);
            margin-left: 2px;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1.5px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13.5px;
            outline: none;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
            background: var(--bg-card);
        }

        .form-control::placeholder {
            color: var(--text-tertiary);
        }

        .form-error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 4px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 640px) {
            .form-row { grid-template-columns: 1fr; }
        }

        /* PERMISSIONS */
        .perm-section-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 28px 0 4px;
            padding-top: 24px;
            border-top: 2px solid var(--border-color);
        }

        .perm-section-title:first-of-type {
            border-top: none;
            padding-top: 0;
            margin-top: 8px;
        }

        .perm-section-sub {
            font-size: 12px;
            color: var(--text-secondary);
            margin-bottom: 18px;
        }

        .perm-module {
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }

        .perm-module:hover {
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
        }

        .perm-module-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .perm-module-head .mh {
            font-weight: 700;
            font-size: 13px;
            color: var(--text-primary);
        }

        .perm-module-head .mh .badge {
            font-size: 10px;
            font-weight: 500;
            color: var(--text-tertiary);
            background: var(--bg-card);
            padding: 2px 10px;
            border-radius: 100px;
            margin-left: 8px;
        }

        .perm-select-all {
            font-size: 11px;
            color: var(--theme-primary);
            font-weight: 600;
            cursor: pointer;
            user-select: none;
            transition: all 0.2s ease;
            padding: 4px 12px;
            border-radius: 6px;
            background: var(--theme-soft);
        }

        .perm-select-all:hover {
            background: var(--theme-glow);
            transform: scale(1.02);
        }

        .perm-checks {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .chk-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
            transition: all 0.15s ease;
            padding: 4px 0;
        }

        .chk-label:hover {
            color: var(--text-primary);
        }

        .chk-box {
            width: 18px;
            height: 18px;
            border-radius: 5px;
            border: 2px solid var(--border-hover);
            background: var(--bg-card);
            flex-shrink: 0;
            position: relative;
            transition: all 0.15s ease;
        }

        .chk-label input { display: none; }

        .chk-label input:checked + .chk-box {
            background: var(--theme-primary);
            border-color: var(--theme-primary);
        }

        .chk-label input:checked + .chk-box:after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 6px;
            height: 10px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .chk-label input:checked ~ .chk-text {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* FORM ACTIONS */
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 2px solid var(--border-color);
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 28px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: 'Inter', sans-serif;
            text-decoration: none;
        }

        .btn .icon {
            width: 16px;
            height: 16px;
        }

        .btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .btn-primary:active {
            transform: translateY(0) scale(0.97);
        }

        .btn-outline {
            background: var(--bg-card-active);
            border: 1.5px solid var(--border-color);
            color: var(--text-secondary);
        }

        .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .invite-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .invite-wrap { padding: 0 12px; }
            .invite-side { position: static; }
            .invite-main { padding: 20px; }
            .invite-header { flex-direction: column; align-items: stretch; }
            .invite-header-left { flex-wrap: wrap; }
            .invite-header h1 { font-size: 20px; }
        }

        @media (max-width: 640px) {
            .invite-wrap { padding: 0 8px; }
            .invite-main { padding: 16px; }
            .role-option { padding: 12px 14px; }
            .perm-module { padding: 14px 16px; }
            .perm-checks { gap: 10px; }
            .btn { flex: 1; justify-content: center; padding: 10px 16px; font-size: 12px; }
            .form-actions { flex-direction: column; }
            .form-actions .btn { width: 100%; }
        }

        @media (max-width: 380px) {
            .invite-wrap { padding: 0 4px; }
            .invite-card { padding: 16px; }
            .invite-main { padding: 12px; }
            .role-option { padding: 10px 12px; }
            .role-icon { width: 30px; height: 30px; font-size: 15px; }
            .role-text .t { font-size: 12px; }
            .role-text .d { font-size: 10.5px; }
            .perm-module-head .mh { font-size: 12px; }
            .chk-label { font-size: 11px; }
        }
    </style>

    <div class="invite-wrap">

        <!-- ===== HEADER ===== -->
        <div class="invite-header animate-in" style="animation-delay: 0.05s;">
            <div class="invite-header-left">
                <a href="{{ route('team-members.index') }}" class="invite-back-btn">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
                <div>
                    <h1>Undang Anggota Baru</h1>
                    <p>Tambahkan anggota tim dan atur hak aksesnya dengan mudah.</p>
                </div>
            </div>
            <div style="font-size:12px;color:var(--text-tertiary);display:flex;align-items:center;gap:6px;">
                <span class="invite-step-badge" style="background:var(--theme-soft);color:var(--theme-primary);padding:4px 12px;border-radius:100px;font-weight:600;">Step 2 dari 2</span>
            </div>
        </div>

        <!-- ===== FORM ===== -->
        <form method="POST" action="{{ route('team-members.store') }}" id="inviteForm">
            @csrf
            <div class="invite-layout">

                <!-- ===== LEFT: ROLE ===== -->
                <div class="invite-side">
                    <div class="invite-card animate-in" style="animation-delay: 0.10s;">
                        <h3>🎯 Pilih Role</h3>
                        <p class="desc">Role menentukan template awal hak akses. Kamu masih bisa mengubah detail izin di sebelah kanan.</p>

                        @foreach($roleLabels as $role => $info)
                            <label class="role-option {{ old('role') == $role || (!old('role') && $role == 'Admin') ? 'checked' : '' }}" data-role-option>
                                <input type="radio" name="role" value="{{ $role }}" data-role-radio {{ old('role', 'Admin') == $role ? 'checked' : '' }} required>
                                <span class="role-radio"></span>
                                <span class="role-icon" style="color: {{ $info['color'] }};">{{ $info['icon'] }}</span>
                                <span class="role-text">
                                    <div class="t">{{ $role }}</div>
                                    <div class="d">{{ $info['desc'] }}</div>
                                </span>
                            </label>
                        @endforeach
                        @error('role')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="invite-hint animate-in" style="animation-delay: 0.15s;">
                        <div class="t">💡 Tips</div>
                        <p>Memilih role otomatis mencentang hak akses standarnya. Kamu tetap bisa menyesuaikan setiap izin secara manual di sebelah kanan sebelum mengirim undangan.</p>
                    </div>
                </div>

                <!-- ===== RIGHT: FORM ===== -->
                <div class="invite-main animate-in" style="animation-delay: 0.12s;">
                    <!-- Name & Email -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Masukkan nama lengkap" required>
                            @error('name')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Masukkan alamat email" required>
                            @error('email')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Permissions -->
                    <div class="perm-section-title">🔐 Hak Akses Detail</div>
                    <div class="perm-section-sub">Centang izin yang boleh diakses anggota ini pada setiap modul.</div>

                    @foreach($modules as $key => $mod)
                        <div class="perm-module" data-module="{{ $key }}">
                            <div class="perm-module-head">
                                <span class="mh">
                                    {{ $mod['label'] }}
                                    <span class="badge">{{ count($mod['actions']) }} izin</span>
                                </span>
                                <span class="perm-select-all" data-select-all="{{ $key }}">Pilih Semua</span>
                            </div>
                            <div class="perm-checks">
                                @foreach($mod['actions'] as $action)
                                    @php
                                        $permValue = $key . '.' . $action;
                                        $isChecked = in_array($permValue, old('permissions', []));
                                    @endphp
                                    <label class="chk-label">
                                        <input type="checkbox" name="permissions[]" value="{{ $permValue }}"
                                            data-module-check="{{ $key }}"
                                            {{ $isChecked ? 'checked' : '' }}>
                                        <span class="chk-box"></span>
                                        <span class="chk-text">{{ ucfirst($action) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <!-- Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <svg class="icon"><use href="#ic-send"/></svg>
                            Kirim Undangan
                        </button>
                        <a href="{{ route('team-members.index') }}" class="btn btn-outline">
                            <svg class="icon"><use href="#ic-x"/></svg>
                            Batal
                        </a>
                    </div>
                </div>

            </div>
        </form>

    </div>

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-arrow-left" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></symbol>
        <symbol id="ic-send" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></symbol>
        <symbol id="ic-x" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
        <symbol id="ic-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== ROLE TEMPLATES =====
            const roleTemplates = @json($roleTemplates);

            function applyRoleTemplate(role) {
                // Uncheck all first
                document.querySelectorAll('[data-module-check]').forEach(chk => {
                    chk.checked = false;
                });

                // Check based on role template
                if (roleTemplates[role]) {
                    const perms = roleTemplates[role];
                    document.querySelectorAll('[data-module-check]').forEach(chk => {
                        const module = chk.dataset.moduleCheck;
                        const action = chk.value.split('.')[1];
                        if (perms[module] && perms[module].includes(action)) {
                            chk.checked = true;
                        }
                    });
                }

                // Update "Pilih Semua" text
                document.querySelectorAll('[data-module]').forEach(module => {
                    updateSelectAllText(module.dataset.module);
                });
            }

            function updateSelectAllText(module) {
                const checks = document.querySelectorAll(`[data-module-check="${module}"]`);
                const checked = Array.from(checks).filter(c => c.checked).length;
                const total = checks.length;
                const btn = document.querySelector(`[data-select-all="${module}"]`);
                if (btn) {
                    if (checked === total && total > 0) {
                        btn.textContent = 'Batal Semua';
                    } else {
                        btn.textContent = 'Pilih Semua';
                    }
                }
            }

            // ===== ROLE SELECTION =====
            document.querySelectorAll('[data-role-radio]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.querySelectorAll('[data-role-option]').forEach(el => {
                        el.classList.remove('checked');
                    });
                    this.closest('[data-role-option]').classList.add('checked');
                    applyRoleTemplate(this.value);
                });
            });

            // ===== SELECT ALL =====
            document.querySelectorAll('[data-select-all]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const mod = this.dataset.selectAll;
                    const checks = document.querySelectorAll(`[data-module-check="${mod}"]`);
                    const allChecked = Array.from(checks).every(c => c.checked);
                    checks.forEach(c => c.checked = !allChecked);
                    updateSelectAllText(mod);
                });
            });

            // ===== INDIVIDUAL CHECK =====
            document.querySelectorAll('[data-module-check]').forEach(chk => {
                chk.addEventListener('change', function() {
                    const mod = this.dataset.moduleCheck;
                    updateSelectAllText(mod);
                });
            });

            // ===== INITIAL PRESET =====
            const defaultRole = document.querySelector('[data-role-radio]:checked');
            if (defaultRole) {
                applyRoleTemplate(defaultRole.value);
            } else {
                // If no radio checked, use Admin
                const adminRadio = document.querySelector('[data-role-radio][value="Admin"]');
                if (adminRadio) {
                    adminRadio.checked = true;
                    document.querySelector('[data-role-option]')?.classList.add('checked');
                    applyRoleTemplate('Admin');
                }
            }
        });
    </script>
</x-app-layout>