<x-app-layout>
    <x-slot name="title">Detail Karyawan</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        $profile = $employee->employeeProfile ?? null;

        // Gunakan status dari profile, fallback ke 'active'
        $statusValue = $profile->status ?? 'active';
        $statusLabel = ['active' => 'Aktif', 'inactive' => 'Tidak Aktif'];
        $statusPill  = ['active' => 'active', 'inactive' => 'inactive'];

        function formatTanggal($date) {
            if (empty($date)) return '-';
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return $date;
            }
        }

        function formatAngkaPendek($angka, $currency = 'Rp') {
            if ($angka === null || $angka === '') return $currency . '0';

            $angka = (float) $angka;

            if ($angka >= 1000000000) {
                return $currency . number_format($angka / 1000000000, 1, ',', '.') . ' M';
            } elseif ($angka >= 1000000) {
                return $currency . number_format($angka / 1000000, 1, ',', '.') . ' Jt';
            } elseif ($angka >= 1000) {
                return $currency . number_format($angka / 1000, 0, ',', '.') . ' Rb';
            } else {
                return $currency . number_format($angka, 0, ',', '.');
            }
        }
    @endphp

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-user-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <polyline points="16 11 18 13 22 9"/>
            </symbol>
            <symbol id="ic-user-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <line x1="18" y1="8" x2="23" y2="13"/>
                <line x1="23" y1="8" x2="18" y2="13"/>
            </symbol>
            <symbol id="ic-credit-card" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                <line x1="2" y1="11" x2="22" y2="11"/>
            </symbol>
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-chevron-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .emp-detail-wrap {
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

            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;

            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .emp-detail-wrap * { box-sizing: border-box; }
        .emp-detail-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .emp-detail-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .emp-detail-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* ===== HEADER ===== */
        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .detail-header .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .detail-header .back-link:hover {
            color: var(--text-primary);
        }

        .detail-header .back-link .icon {
            width: 16px;
            height: 16px;
        }

        .detail-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .detail-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        /* ===== BUTTONS ===== */
        .emp-btn {
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
            position: relative;
            overflow: hidden;
        }

        .emp-btn .icon { width: 16px; height: 16px; }
        .emp-btn:hover { transform: translateY(-2px); }
        .emp-btn:active { transform: translateY(0) scale(0.97); }

        .emp-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        .emp-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .emp-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .emp-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .emp-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        /* ===== CARD ===== */
        .detail-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .detail-card .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .detail-card .avatar-xl {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 32px;
            color: #fff;
            flex-shrink: 0;
            overflow: hidden;
        }

        /* ===== FOTO PROFIL: Tampilkan gambar jika ada ===== */
        .detail-card .avatar-xl img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .detail-card .header-info h2 {
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 4px;
            color: var(--text-primary);
        }

        .detail-card .header-info .position-text {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .detail-card .header-info .dept-badge {
            display: inline-block;
            font-size: 12px;
            font-weight: 500;
            padding: 4px 14px;
            border-radius: 100px;
            background: var(--bg-card-active);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            margin-top: 6px;
        }

        .detail-card .status-badge-lg {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 18px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-left: auto;
        }

        .detail-card .status-badge-lg.active {
            background: var(--success-soft);
            color: var(--success);
        }

        .detail-card .status-badge-lg.inactive {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .detail-card .card-body {
            padding: 24px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px 40px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-item .label {
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-tertiary);
        }

        .detail-item .value {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .detail-item .value.mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .emp-detail-wrap { padding: 0 12px; }
            .detail-card .card-header { flex-wrap: wrap; }
            .detail-card .status-badge-lg { margin-left: 0; }
            .detail-grid { grid-template-columns: 1fr; gap: 16px; }
            .detail-header { flex-direction: column; align-items: flex-start; }
            .detail-actions { width: 100%; }
            .detail-actions .emp-btn { flex: 1; justify-content: center; }
        }

        @media (max-width: 640px) {
            .emp-detail-wrap { padding: 0 8px; }
            .detail-header h1 { font-size: 22px; }
            .detail-card .avatar-xl { width: 60px; height: 60px; font-size: 24px; }
            .detail-card .header-info h2 { font-size: 17px; }
        }
    </style>

    <div class="emp-detail-wrap">
        <!-- ===== HEADER ===== -->
        <div class="detail-header animate-in" style="animation-delay: 0.05s;">
            <div>
                <a href="{{ route('employees.index') }}" class="back-link">
                    <svg class="icon"><use href="#ic-chevron-left"/></svg>
                    Kembali ke Daftar
                </a>
                <h1>Detail Karyawan</h1>
            </div>
            <div class="detail-actions">
                <a href="{{ route('employees.edit', ['index' => $employee->id]) }}" class="emp-btn emp-btn-primary">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Edit
                </a>
            </div>
        </div>

        <!-- ===== CARD ===== -->
        <div class="detail-card animate-in" style="animation-delay: 0.10s;">
            <div class="card-header">
                @php
                    $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
                    $color = $colors[$employee->id % count($colors)];
                    $initial = mb_substr($employee->name ?? '?', 0, 1);
                @endphp
                <div class="avatar-xl" style="background: {{ $color }};">
                    @if(!empty($employee->profile_photo))
                        <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="{{ $employee->name }}">
                    @else
                        {{ strtoupper($initial) }}
                    @endif
                </div>
                <div class="header-info">
                    <h2>{{ $employee->name ?? 'Nama Tidak Diketahui' }}</h2>
                    <div class="position-text">{{ $profile->position ?? 'Belum diatur' }}</div>
                    <span class="dept-badge">{{ $profile->department ?? '-' }}</span>
                </div>
                <span class="status-badge-lg {{ $statusPill[$statusValue] ?? 'inactive' }}">
                    {{ $statusLabel[$statusValue] ?? 'Tidak Aktif' }}
                </span>
            </div>

            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="label">Nama Lengkap</span>
                        <span class="value">{{ $employee->name ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Posisi / Jabatan</span>
                        <span class="value">{{ $profile->position ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Departemen</span>
                        <span class="value">{{ $profile->department ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Email</span>
                        <span class="value">{{ $employee->email ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Telepon</span>
                        <span class="value">{{ $profile->phone ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Gaji / Bulan</span>
                        <span class="value mono">{{ formatAngkaPendek($profile->basic_salary ?? null, $currencySymbol) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Tanggal Bergabung</span>
                        <span class="value">{{ formatTanggal($profile->joined_date ?? null) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Status</span>
                        <span class="value">
                            <span class="status-badge-lg {{ $statusPill[$statusValue] ?? 'inactive' }}" style="display:inline-block; margin:0; font-size:11px; padding:4px 12px;">
                                {{ $statusLabel[$statusValue] ?? 'Tidak Aktif' }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ripple effect for buttons
            const buttons = document.querySelectorAll('.emp-btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (this.tagName === 'A' && this.getAttribute('href') && this.getAttribute('href') !== '#') {
                        return;
                    }
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>
</x-app-layout>