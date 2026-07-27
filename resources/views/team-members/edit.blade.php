<x-app-layout>
    <x-slot name="title">Kelola Akses Anggota</x-slot>

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

        $roleLabels = [
            'Admin' => ['icon' => '👑', 'color' => '#34B583'],
            'Manager' => ['icon' => '📊', 'color' => '#4E8FF0'],
            'Staff' => ['icon' => '📝', 'color' => '#F0A83C'],
            'Viewer' => ['icon' => '👁️', 'color' => '#9B7BE0'],
        ];

        $statusLabels = [
            'active' => ['label' => 'Aktif', 'color' => '#34B583', 'bg' => 'rgba(52,181,131,0.14)'],
            'invited' => ['label' => 'Menunggu Konfirmasi', 'color' => '#4E8FF0', 'bg' => 'rgba(78,143,240,0.14)'],
            'suspended' => ['label' => 'Ditangguhkan', 'color' => '#E85A5A', 'bg' => 'rgba(232,90,90,0.14)'],
        ];

        $colors = ['#34B583', '#4E8FF0', '#F0A83C', '#E85A5A', '#9B7BE0', '#EC4C93'];
        $avatarColor = $colors[($teamMember->id ?? 1) % count($colors)];
    @endphp

    <style>
        /* ============================================
           KELOLA AKSES - Modern Design
           ============================================ */
        
        .manage-wrap {
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
            --danger-rgb: 232, 90, 90;
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .manage-wrap * { box-sizing: border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .manage-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .manage-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* PAGE HEADER */
        .manage-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 24px;
            padding: 0 4px;
        }

        .manage-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .manage-back-btn {
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

        .manage-back-btn .icon { width: 16px; height: 16px; }
        
        .manage-back-btn:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateX(-4px);
        }

        .manage-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .manage-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 2px 0 0;
        }

        /* USER HEADER */
        .manage-user-header {
            display: flex;
            align-items: center;
            gap: 20px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 28px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
            max-width: 960px;
        }

        .manage-user-header:hover {
            border-color: var(--border-hover);
        }

        .manage-avatar {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 24px;
            color: #fff;
            flex-shrink: 0;
            position: relative;
        }

        .manage-avatar .status-dot {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 3px solid var(--bg-card);
        }

        .manage-avatar .status-dot.active { background: var(--success); }
        .manage-avatar .status-dot.invited { background: var(--info); }
        .manage-avatar .status-dot.suspended { background: var(--danger); }

        .manage-user-info .name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .manage-user-info .email {
            font-size: 13.5px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .manage-user-info .badges {
            display: flex;
            gap: 8px;
            margin-top: 6px;
            flex-wrap: wrap;
        }

        .manage-user-info .badge {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 12px;
            border-radius: 100px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-role { background: var(--theme-soft); color: var(--theme-primary); }
        .badge-status { background: var(--success-soft); color: var(--success); }
        .badge-status.invited { background: var(--info-soft); color: var(--info); }
        .badge-status.suspended { background: var(--danger-soft); color: var(--danger); }

        .manage-perm-count {
            margin-left: auto;
            font-size: 12px;
            color: var(--text-tertiary);
            text-align: right;
            flex-shrink: 0;
        }

        .manage-perm-count strong {
            font-size: 18px;
            color: var(--text-primary);
            display: block;
        }

        /* LAYOUT */
        .manage-body {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 24px;
            max-width: 960px;
        }

        @media (max-width: 900px) {
            .manage-body { grid-template-columns: 1fr; }
        }

        /* CARD */
        .manage-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px;
            transition: all 0.3s ease;
        }

        .manage-card:hover {
            border-color: var(--border-hover);
        }

        .manage-card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin: 0 0 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .manage-card-title .icon {
            width: 18px;
            height: 18px;
            color: var(--theme-primary);
        }

        /* FORM */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group:last-child { margin-bottom: 0; }

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

        .form-control option {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .form-hint {
            font-size: 11.5px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        /* PERMISSIONS */
        .perm-module {
            border-bottom: 1px solid var(--border-color);
            padding: 14px 0;
            transition: all 0.2s ease;
        }

        .perm-module:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .perm-module:first-child {
            padding-top: 0;
        }

        .perm-module .mh {
            font-weight: 600;
            font-size: 13px;
            color: var(--text-primary);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .perm-module .mh .count {
            font-size: 10px;
            font-weight: 500;
            color: var(--text-tertiary);
            background: var(--bg-card-active);
            padding: 1px 10px;
            border-radius: 100px;
        }

        .perm-checks {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .perm-checks label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
            transition: all 0.15s ease;
            padding: 2px 0;
        }

        .perm-checks label:hover {
            color: var(--text-primary);
        }

        .perm-checks input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--theme-primary);
            cursor: pointer;
            border-radius: 4px;
        }

        .perm-checks input[type="checkbox"]:checked + span {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* FORM ACTIONS */
        .manage-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            max-width: 960px;
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

        .btn-danger {
            background: transparent;
            border: 1.5px solid var(--danger);
            color: var(--danger);
        }

        .btn-danger:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
            transform: translateY(-2px);
        }

        /* DANGER ZONE */
        .danger-zone {
            border: 1px solid rgba(232, 90, 90, 0.25);
            border-radius: var(--radius-md);
            padding: 20px 24px;
            margin-top: 24px;
            max-width: 960px;
            background: var(--bg-card);
            transition: all 0.3s ease;
        }

        .danger-zone:hover {
            border-color: rgba(232, 90, 90, 0.4);
        }

        .danger-zone .d-title {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--danger);
            font-size: 14px;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .danger-zone .d-title .icon {
            width: 18px;
            height: 18px;
            stroke: var(--danger);
        }

        .danger-zone p {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0 0 12px;
            line-height: 1.6;
        }

        .danger-zone .btn-danger {
            background: transparent;
            border: 1.5px solid var(--danger);
            color: var(--danger);
        }

        .danger-zone .btn-danger:hover {
            background: var(--danger-soft);
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .manage-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .manage-wrap { padding: 0 12px; }
            .manage-user-header { flex-wrap: wrap; padding: 16px 20px; }
            .manage-perm-count { margin-left: 0; width: 100%; text-align: left; }
            .manage-header { flex-direction: column; align-items: stretch; }
            .manage-header-left { flex-wrap: wrap; }
            .manage-header h1 { font-size: 20px; }
            .manage-card { padding: 18px; }
            .manage-actions { flex-direction: column; }
            .manage-actions .btn { width: 100%; justify-content: center; }
        }

        @media (max-width: 640px) {
            .manage-wrap { padding: 0 8px; }
            .manage-user-header { padding: 14px 16px; }
            .manage-avatar { width: 48px; height: 48px; font-size: 18px; }
            .manage-user-info .name { font-size: 16px; }
            .manage-card { padding: 14px; }
            .perm-checks { gap: 10px; }
            .perm-checks label { font-size: 11.5px; }
            .danger-zone { padding: 16px; }
            .btn { font-size: 12px; padding: 10px 16px; }
        }

        @media (max-width: 380px) {
            .manage-wrap { padding: 0 4px; }
            .manage-user-header { flex-direction: column; text-align: center; }
            .manage-user-info .badges { justify-content: center; }
            .manage-perm-count { text-align: center; }
            .perm-module .mh { font-size: 12px; }
            .perm-checks label { font-size: 10.5px; }
        }
    </style>

    <div class="manage-wrap">

        <!-- ===== HEADER ===== -->
        <div class="manage-header animate-in" style="animation-delay: 0.05s;">
            <div class="manage-header-left">
                <a href="{{ route('team-members.index') }}" class="manage-back-btn">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
                <div>
                    <h1>Kelola Akses Anggota</h1>
                    <p>Perbarui role, status, dan hak akses detail.</p>
                </div>
            </div>
            <div style="font-size:12px;color:var(--text-tertiary);display:flex;align-items:center;gap:6px;">
                <span style="background:var(--theme-soft);color:var(--theme-primary);padding:4px 12px;border-radius:100px;font-weight:600;">
                    Edit Mode
                </span>
            </div>
        </div>

        <!-- ===== USER HEADER ===== -->
        <div class="manage-user-header animate-in" style="animation-delay: 0.08s;">
            <div class="manage-avatar" style="background: {{ $avatarColor }};">
                {{ strtoupper(substr($teamMember->name, 0, 1)) }}
                <span class="status-dot {{ $teamMember->status }}"></span>
            </div>
            <div class="manage-user-info">
                <div class="name">{{ $teamMember->name }}</div>
                <div class="email">{{ $teamMember->email }}</div>
                <div class="badges">
                    <span class="badge badge-role">
                        @php
                            $roleIcon = $roleLabels[$teamMember->role]['icon'] ?? '👤';
                        @endphp
                        {{ $roleIcon }} {{ $teamMember->role }}
                    </span>
                    <span class="badge badge-status {{ $teamMember->status }}">
                        {{ $statusLabels[$teamMember->status]['label'] ?? $teamMember->status }}
                    </span>
                </div>
            </div>
            <div class="manage-perm-count">
                <strong>{{ count($teamMember->permissions ?? []) }}</strong>
                <span>Hak Akses</span>
            </div>
        </div>

        <!-- ===== FORM ===== -->
        <form method="POST" action="{{ route('team-members.update', $teamMember) }}">
            @csrf
            @method('PUT')

            <div class="manage-body">

                <!-- ===== LEFT: BASIC INFO ===== -->
                <div class="manage-card animate-in" style="animation-delay: 0.10s;">
                    <div class="manage-card-title">
                        <svg class="icon"><use href="#ic-user"/></svg>
                        Informasi Dasar
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $teamMember->name) }}" class="form-control" required>
                        @error('name')<div class="form-error" style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $teamMember->email) }}" class="form-control" required>
                        @error('email')<div class="form-error" style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Role <span class="required">*</span></label>
                        <select name="role" class="form-control" required>
                            @foreach(['Admin','Manager','Staff','Viewer'] as $r)
                                @php
                                    $icon = $roleLabels[$r]['icon'] ?? '👤';
                                @endphp
                                <option value="{{ $r }}" {{ old('role', $teamMember->role) == $r ? 'selected' : '' }}>
                                    {{ $icon }} {{ $r }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-hint">Role menentukan template default hak akses.</div>
                    </div>

                    <div class="form-group">
                        <label>Status <span class="required">*</span></label>
                        <select name="status" class="form-control" required>
                            @foreach($statusLabels as $key => $status)
                                <option value="{{ $key }}" {{ old('status', $teamMember->status) == $key ? 'selected' : '' }}>
                                    {{ $status['label'] }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-hint">Status menentukan apakah anggota dapat mengakses sistem.</div>
                    </div>
                </div>

                <!-- ===== RIGHT: PERMISSIONS ===== -->
                <div class="manage-card animate-in" style="animation-delay: 0.12s;">
                    <div class="manage-card-title">
                        <svg class="icon"><use href="#ic-shield"/></svg>
                        Hak Akses Detail
                        <span style="font-size:11px;font-weight:400;color:var(--text-tertiary);text-transform:none;margin-left:auto;">
                            Centang untuk memberikan akses
                        </span>
                    </div>

                    @php
                        $currentPermissions = old('permissions', $teamMember->permissions ?? []);
                    @endphp

                    @foreach($modules as $key => $mod)
                        <div class="perm-module">
                            <div class="mh">
                                {{ $mod['label'] }}
                                <span class="count">{{ count($mod['actions']) }} izin</span>
                            </div>
                            <div class="perm-checks">
                                @foreach($mod['actions'] as $action)
                                    @php
                                        $permValue = $key . '.' . $action;
                                        $isChecked = in_array($permValue, $currentPermissions);
                                    @endphp
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{ $permValue }}"
                                            {{ $isChecked ? 'checked' : '' }}>
                                        <span>{{ ucfirst($action) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <!-- ===== ACTIONS ===== -->
            <div class="manage-actions animate-in" style="animation-delay: 0.15s;">
                <button type="submit" class="btn btn-primary">
                    <svg class="icon"><use href="#ic-save"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('team-members.index') }}" class="btn btn-outline">
                    <svg class="icon"><use href="#ic-x"/></svg>
                    Batal
                </a>
                <a href="{{ route('team-members.show', $teamMember) }}" class="btn btn-outline" style="margin-left:auto;">
                    <svg class="icon"><use href="#ic-eye"/></svg>
                    Lihat Detail
                </a>
            </div>

        </form>

        <!-- ===== DANGER ZONE ===== -->
        <div class="danger-zone animate-in" style="animation-delay: 0.18s;">
            <div class="d-title">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                Zona Bahaya
            </div>
            <p>
                <strong>Hapus Anggota</strong> — Anggota ini akan kehilangan seluruh akses ke sistem secara permanen. 
                Data yang dihapus tidak dapat dikembalikan.
            </p>
            <form action="{{ route('team-members.destroy', $teamMember) }}" method="POST" 
                  onsubmit="return confirm('⚠️ Apakah Anda yakin ingin menghapus anggota {{ $teamMember->name }} secara permanen? Tindakan ini tidak dapat dibatalkan!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg class="icon"><use href="#ic-trash"/></svg>
                    Hapus Anggota
                </button>
            </form>
        </div>

    </div>

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-arrow-left" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></symbol>
        <symbol id="ic-user" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
        <symbol id="ic-shield" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></symbol>
        <symbol id="ic-save" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></symbol>
        <symbol id="ic-x" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
        <symbol id="ic-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
        <symbol id="ic-alert-triangle" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></symbol>
        <symbol id="ic-trash" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
    </svg>
</x-app-layout>