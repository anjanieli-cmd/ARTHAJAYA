<x-app-layout>
    <x-slot name="title">Detail Anggota Tim</x-slot>

    @php
        // Data dummy untuk member
        $member = $member ?? (object) [
            'id' => 1,
            'name' => 'Andi Pratama',
            'email' => 'andi@company.com',
            'role' => 'Admin',
            'status' => 'active',
            'joined_at' => '2024-01-15',
            'last_active' => '2024-02-20 14:30:00',
            'permission_count' => 12,
            'permissions' => [
                'view_dashboard' => true,
                'manage_users' => true,
                'manage_products' => true,
                'manage_orders' => true,
                'manage_reports' => true,
                'manage_settings' => true,
                'view_analytics' => true,
                'export_data' => true,
                'manage_inventory' => true,
                'manage_customers' => true,
                'view_financials' => false,
                'manage_team' => false,
            ],
            'activity_log' => [
                (object) ['action' => 'Login', 'time' => '2024-02-20 14:30:00', 'ip' => '192.168.1.1'],
                (object) ['action' => 'Updated product', 'time' => '2024-02-20 13:15:00', 'ip' => '192.168.1.1'],
                (object) ['action' => 'Generated report', 'time' => '2024-02-19 10:00:00', 'ip' => '192.168.1.5'],
                (object) ['action' => 'Added new user', 'time' => '2024-02-18 16:45:00', 'ip' => '192.168.1.1'],
            ]
        ];

        $roleLabel = [
            'Admin' => 'Admin',
            'Manager' => 'Manager',
            'Staff' => 'Staff',
            'Viewer' => 'Viewer'
        ];
        $roleColor = [
            'Admin' => 'admin',
            'Manager' => 'manager',
            'Staff' => 'staff',
            'Viewer' => 'viewer'
        ];
        $statusLabel = [
            'active' => 'Aktif',
            'invited' => 'Menunggu Konfirmasi',
            'suspended' => 'Ditangguhkan'
        ];
        $statusPill = [
            'active' => 'active',
            'invited' => 'invited',
            'suspended' => 'suspended'
        ];

        // Get permission count safely
        if (method_exists($member, 'permissionCount')) {
            $permCount = $member->permissionCount();
        } elseif (isset($member->permission_count)) {
            $permCount = $member->permission_count;
        } elseif (isset($member->permissionCount)) {
            $permCount = is_callable($member->permissionCount) ? $member->permissionCount() : $member->permissionCount;
        } else {
            $permCount = 0;
        }
    @endphp

    <style>
        /* ============================================
           DETAIL MEMBER - Modern Design
           ============================================ */
        
        .detail-wrap {
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

        .detail-wrap * { box-sizing: border-box; }
        .detail-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .detail-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .detail-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER BACK */
        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 24px;
            padding: 0 4px;
        }

        .detail-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .detail-back-btn {
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

        .detail-back-btn .icon { width: 16px; height: 16px; }
        
        .detail-back-btn:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateX(-4px);
        }

        .detail-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .detail-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .detail-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            background: transparent;
            color: var(--text-secondary);
            font-family: 'Inter', sans-serif;
        }

        .detail-btn .icon { width: 16px; height: 16px; }
        .detail-btn:hover { transform: translateY(-2px); }
        .detail-btn:active { transform: translateY(0) scale(0.97); }

        .detail-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .detail-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .detail-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .detail-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        /* MAIN CONTENT GRID */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 24px;
        }

        /* CARD */
        .detail-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px;
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            border-color: var(--border-hover);
        }

        .detail-card-title {
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

        .detail-card-title .icon {
            width: 18px;
            height: 18px;
            color: var(--theme-primary);
        }

        /* PROFILE SECTION */
        .profile-section {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 32px;
            color: #fff;
            margin: 0 auto 16px;
            position: relative;
        }

        .profile-status-badge {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 3px solid var(--bg-card);
        }

        .profile-status-badge.active { background: var(--success); }
        .profile-status-badge.invited { background: var(--info); }
        .profile-status-badge.suspended { background: var(--danger); }

        .profile-name {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .profile-email {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 12px;
        }

        .profile-tags {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .profile-role-pill {
            padding: 4px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .profile-role-pill.admin {
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .profile-role-pill.manager {
            background: var(--info-soft);
            color: var(--info);
        }

        .profile-role-pill.staff {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .profile-role-pill.viewer {
            background: var(--bg-card-active);
            color: var(--text-tertiary);
        }

        .profile-status-pill {
            padding: 4px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
        }

        .profile-status-pill.active {
            background: var(--success-soft);
            color: var(--success);
        }

        .profile-status-pill.invited {
            background: var(--info-soft);
            color: var(--info);
        }

        .profile-status-pill.suspended {
            background: var(--danger-soft);
            color: var(--danger);
        }

        /* INFO ROWS */
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .info-value {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            text-align: right;
        }

        .info-value .mono {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
        }

        /* PERMISSIONS GRID */
        .permissions-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .permission-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: var(--bg-card-active);
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .permission-item:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
        }

        .permission-item .icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .permission-item .icon-check {
            color: var(--success);
        }

        .permission-item .icon-x {
            color: var(--danger);
        }

        .permission-item .perm-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            flex: 1;
        }

        .permission-item.active {
            border-color: var(--success-soft);
            background: var(--success-soft);
        }

        .permission-item.active .perm-label {
            color: var(--success);
        }

        .permission-item.inactive {
            opacity: 0.6;
        }

        /* ACTIVITY LOG */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            background: var(--bg-card-active);
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
            border-left: 3px solid var(--theme-primary);
        }

        .activity-item:hover {
            background: var(--bg-card-hover);
        }

        .activity-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--theme-soft);
            color: var(--theme-primary);
            flex-shrink: 0;
        }

        .activity-icon .icon {
            width: 16px;
            height: 16px;
        }

        .activity-content {
            flex: 1;
            min-width: 0;
        }

        .activity-action {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .activity-time {
            font-size: 11px;
            color: var(--text-tertiary);
        }

        .activity-ip {
            font-size: 11px;
            color: var(--text-tertiary);
            font-family: 'IBM Plex Mono', monospace;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .detail-grid { grid-template-columns: 1fr; }
            .detail-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .detail-wrap { padding: 0 12px; }
            .detail-header { flex-direction: column; align-items: stretch; }
            .detail-header-actions { width: 100%; }
            .detail-header-actions .detail-btn { flex: 1; justify-content: center; }
            .permissions-grid { grid-template-columns: 1fr; }
            .detail-card { padding: 18px; }
        }

        @media (max-width: 640px) {
            .detail-wrap { padding: 0 8px; }
            .profile-avatar { width: 64px; height: 64px; font-size: 26px; }
            .profile-name { font-size: 18px; }
            .detail-header h1 { font-size: 20px; }
        }

        @media (max-width: 380px) {
            .detail-wrap { padding: 0 4px; }
            .detail-btn { font-size: 11px; padding: 8px 12px; }
            .detail-btn .icon { width: 14px; height: 14px; }
            .permission-item { padding: 8px 10px; }
            .permission-item .perm-label { font-size: 11px; }
            .activity-item { padding: 10px 12px; }
        }
    </style>

    <div class="detail-wrap">

        <!-- ===== HEADER BACK ===== -->
        <div class="detail-header animate-in" style="animation-delay: 0.05s;">
            <div class="detail-header-left">
                <a href="{{ route('team-members.index') }}" class="detail-back-btn">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
                <h1>Detail Anggota</h1>
            </div>
            <div class="detail-header-actions">
                <a href="{{ route('team-members.edit', $member->id) }}" class="detail-btn detail-btn-primary">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Kelola Hak Akses
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="detail-success animate-in" style="animation-delay: 0.08s; background: var(--success-soft); border: 1px solid var(--success); border-radius: var(--radius-sm); padding: 14px 20px; margin-bottom: 20px; color: var(--success); display: flex; align-items: center; gap: 10px;">
                <svg class="icon" style="width: 20px; height: 20px;"><use href="#ic-check-circle"/></svg>
                <span style="font-weight: 500;">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ===== GRID ===== -->
        <div class="detail-grid">

            <!-- LEFT COLUMN -->
            <div class="detail-left">
                <!-- PROFILE CARD -->
                <div class="detail-card animate-in" style="animation-delay: 0.10s;">
                    <div class="profile-section">
                        @php
                            $colors = ['#34B583', '#4E8FF0', '#F0A83C', '#E85A5A', '#9B7BE0', '#EC4C93'];
                            $color = $colors[($member->id ?? 1) % count($colors)];
                        @endphp
                        <div class="profile-avatar" style="background: {{ $color }};">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                            <span class="profile-status-badge {{ $statusPill[$member->status] ?? 'invited' }}"></span>
                        </div>
                        <h2 class="profile-name">{{ $member->name }}</h2>
                        <p class="profile-email">{{ $member->email }}</p>
                        <div class="profile-tags">
                            <span class="profile-role-pill {{ $roleColor[$member->role] ?? 'viewer' }}">{{ $roleLabel[$member->role] ?? $member->role }}</span>
                            <span class="profile-status-pill {{ $statusPill[$member->status] ?? 'invited' }}">{{ $statusLabel[$member->status] ?? $member->status }}</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <span class="info-label">ID Anggota</span>
                        <span class="info-value mono">#{{ str_pad($member->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Bergabung Sejak</span>
                        <span class="info-value">{{ isset($member->joined_at) ? \Carbon\Carbon::parse($member->joined_at)->format('d F Y') : '15 Januari 2024' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Terakhir Aktif</span>
                        <span class="info-value">{{ isset($member->last_active) ? \Carbon\Carbon::parse($member->last_active)->format('d F Y H:i') : '20 Februari 2024 14:30' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total Hak Akses</span>
                        <span class="info-value"><strong>{{ $permCount }}</strong> permission</span>
                    </div>
                </div>

                <!-- PERMISSIONS CARD -->
                <div class="detail-card animate-in" style="animation-delay: 0.15s; margin-top: 20px;">
                    <div class="detail-card-title">
                        <svg class="icon"><use href="#ic-shield"/></svg>
                        Hak Akses & Permission
                    </div>

                    @php
                        $permissions = $member->permissions ?? [
                            'view_dashboard' => true,
                            'manage_users' => true,
                            'manage_products' => true,
                            'manage_orders' => true,
                            'manage_reports' => true,
                            'manage_settings' => true,
                            'view_analytics' => true,
                            'export_data' => true,
                            'manage_inventory' => true,
                            'manage_customers' => true,
                            'view_financials' => false,
                            'manage_team' => false,
                        ];

                        $permLabels = [
                            'view_dashboard' => 'Lihat Dashboard',
                            'manage_users' => 'Kelola User',
                            'manage_products' => 'Kelola Produk',
                            'manage_orders' => 'Kelola Pesanan',
                            'manage_reports' => 'Kelola Laporan',
                            'manage_settings' => 'Kelola Pengaturan',
                            'view_analytics' => 'Lihat Analytics',
                            'export_data' => 'Export Data',
                            'manage_inventory' => 'Kelola Inventory',
                            'manage_customers' => 'Kelola Customer',
                            'view_financials' => 'Lihat Financial',
                            'manage_team' => 'Kelola Tim',
                        ];
                    @endphp

                    <div class="permissions-grid">
                        @foreach($permissions as $key => $value)
                            <div class="permission-item {{ $value ? 'active' : 'inactive' }}">
                                <svg class="icon {{ $value ? 'icon-check' : 'icon-x' }}">
                                    <use href="{{ $value ? '#ic-check' : '#ic-x' }}"/>
                                </svg>
                                <span class="perm-label">{{ $permLabels[$key] ?? $key }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="detail-right">
                <!-- ACTIVITY LOG CARD -->
                <div class="detail-card animate-in" style="animation-delay: 0.20s;">
                    <div class="detail-card-title">
                        <svg class="icon"><use href="#ic-clock"/></svg>
                        Aktivitas Terakhir
                    </div>

                    @php
                        $activities = $member->activity_log ?? [
                            (object) ['action' => 'Login', 'time' => '2024-02-20 14:30:00', 'ip' => '192.168.1.1'],
                            (object) ['action' => 'Updated product', 'time' => '2024-02-20 13:15:00', 'ip' => '192.168.1.1'],
                            (object) ['action' => 'Generated report', 'time' => '2024-02-19 10:00:00', 'ip' => '192.168.1.5'],
                            (object) ['action' => 'Added new user', 'time' => '2024-02-18 16:45:00', 'ip' => '192.168.1.1'],
                        ];
                    @endphp

                    <div class="activity-list">
                        @forelse($activities as $activity)
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <svg class="icon">
                                        <use href="{{ 
                                            str_contains($activity->action, 'Login') ? '#ic-log-in' : 
                                            (str_contains($activity->action, 'Updated') ? '#ic-edit' : 
                                            (str_contains($activity->action, 'Generated') ? '#ic-file' : 
                                            (str_contains($activity->action, 'Added') ? '#ic-plus' : '#ic-activity')))
                                        }}"/>
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-action">{{ $activity->action }}</div>
                                    <div class="activity-time">
                                        {{ \Carbon\Carbon::parse($activity->time)->format('d F Y H:i') }}
                                        <span class="activity-ip">• {{ $activity->ip }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 30px 0; color: var(--text-tertiary);">
                                <svg class="icon" style="width: 40px; height: 40px; margin: 0 auto 12px; opacity: 0.3;"><use href="#ic-activity"/></svg>
                                <p style="font-size: 14px;">Belum ada aktivitas</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- QUICK INFO CARD -->
                <div class="detail-card animate-in" style="animation-delay: 0.25s; margin-top: 20px;">
                    <div class="detail-card-title">
                        <svg class="icon"><use href="#ic-info"/></svg>
                        Informasi Tambahan
                    </div>

                    <div class="info-row">
                        <span class="info-label">Status Akun</span>
                        <span class="info-value">
                            <span class="profile-status-pill {{ $statusPill[$member->status] ?? 'invited' }}" style="font-size: 12px; display: inline-block;">
                                {{ $statusLabel[$member->status] ?? $member->status }}
                            </span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Role</span>
                        <span class="info-value">
                            <span class="profile-role-pill {{ $roleColor[$member->role] ?? 'viewer' }}" style="font-size: 12px; display: inline-block;">
                                {{ $roleLabel[$member->role] ?? $member->role }}
                            </span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total Aktivitas</span>
                        <span class="info-value">{{ count($activities) }} kegiatan</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Terakhir Update</span>
                        <span class="info-value">{{ now()->format('d F Y H:i') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-arrow-left" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></symbol>
        <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></symbol>
        <symbol id="ic-check-circle" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></symbol>
        <symbol id="ic-shield" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></symbol>
        <symbol id="ic-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></symbol>
        <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
        <symbol id="ic-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
        <symbol id="ic-x" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
        <symbol id="ic-log-in" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></symbol>
        <symbol id="ic-file" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></symbol>
        <symbol id="ic-activity" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></symbol>
        <symbol id="ic-plus" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
    </svg>
</x-app-layout>