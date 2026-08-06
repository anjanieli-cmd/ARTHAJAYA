<x-admin-layout>
    <x-slot name="title">Detail Company</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-pause-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="10" y1="9" x2="10" y2="15"/><line x1="14" y1="9" x2="14" y2="15"/>
            </symbol>
            <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="22 6 12 13 2 6"/>
            </symbol>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-invoice" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2h12v20l-3-2-3 2-3-2-3 2V2z"/><path d="M9 7h6M9 11h6M9 15h3"/>
            </symbol>
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
            </symbol>
            <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>
            </symbol>
            <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .cew {
            --theme-primary: var(--emerald);
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
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px 20px;
        }

        .cew * { box-sizing:border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .cew .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .cew .icon {
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

        /* ===== BACK BUTTON ===== */
        .cew-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 20px;
            text-decoration: none;
            padding: 6px 14px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .cew-back:hover {
            color: var(--text-primary);
            background: var(--bg-card-hover);
        }

        .cew-back .icon {
            width: 16px;
            height: 16px;
        }

        /* ===== HERO ===== */
        .cew-hero {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 32px 34px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            transition: all 0.3s ease;
        }

        .cew-hero:hover {
            border-color: var(--border-hover);
        }

        .cew-hero-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .cew-logo {
            width: 68px;
            height: 68px;
            border-radius: 18px;
            background: var(--theme-gradient);
            border: 1px solid rgba(var(--emerald-rgb), 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 26px;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 8px 24px var(--theme-glow);
            transition: transform 0.3s ease;
        }

        .cew-hero:hover .cew-logo {
            transform: scale(1.03) rotate(-2deg);
        }

        .cew-hero h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--text-primary);
        }

        .cew-hero .sub {
            font-size: 13px;
            color: var(--text-tertiary);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cew-hero .sub .dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--text-tertiary);
        }

        .cew-status-badge {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 6px 16px;
            border-radius: 100px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .cew-status-badge .sdot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .cew-status-badge.active {
            background: rgba(var(--emerald-rgb), 0.14);
            color: var(--emerald);
        }

        .cew-status-badge.active .sdot {
            background: var(--emerald);
            animation: pulseGlow 1.8s ease-in-out infinite;
        }

        .cew-status-badge.suspended {
            background: rgba(232, 90, 90, 0.14);
            color: var(--danger);
        }

        .cew-status-badge.suspended .sdot {
            background: var(--danger);
        }

        /* ===== STAT CARDS ===== */
        .cew-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .cew-stat {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 22px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .cew-stat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--theme-primary), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .cew-stat:hover {
            transform: translateY(-4px);
            border-color: var(--border-hover);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
        }

        .cew-stat:hover::before {
            opacity: 0.6;
        }

        .cew-stat .n {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--theme-primary);
        }

        .cew-stat .l {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        /* ===== 2 KOLOM PANEL ===== */
        .cew-panels {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .cew-panel {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 28px 30px;
            transition: all 0.3s ease;
        }

        .cew-panel:hover {
            border-color: var(--border-hover);
        }

        .cew-panel .panel-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .cew-panel .panel-head .pic {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: var(--theme-soft);
            border: 1px solid rgba(var(--emerald-rgb), 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--theme-primary);
            flex-shrink: 0;
        }

        .cew-panel .panel-head .pic .icon {
            width: 15px;
            height: 15px;
        }

        .cew-panel h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .cew-panel .panel-sub {
            font-size: 12.5px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        /* ===== STATUS TOGGLE ===== */
        .status-toggle {
            display: flex;
            gap: 10px;
            margin-bottom: 18px;
        }

        .status-opt {
            flex: 1;
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid var(--border-color);
            background: var(--bg-card-active);
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .status-opt input {
            display: none;
        }

        .status-opt .icon {
            width: 20px;
            height: 20px;
            margin: 0 auto 6px;
            display: block;
            transition: transform 0.3s ease;
        }

        .status-opt .lbl {
            font-size: 13px;
            font-weight: 600;
        }

        .status-opt:hover {
            transform: translateY(-2px);
        }

        .status-opt.active-opt {
            color: var(--text-secondary);
        }

        .status-opt.active-opt .icon {
            color: var(--text-tertiary);
        }

        .status-opt.suspend-opt {
            color: var(--text-secondary);
        }

        .status-opt.suspend-opt .icon {
            color: var(--text-tertiary);
        }

        .status-opt.selected.active-opt {
            border-color: var(--emerald);
            background: rgba(var(--emerald-rgb), 0.08);
            color: var(--emerald);
        }

        .status-opt.selected.active-opt .icon {
            color: var(--emerald);
            transform: scale(1.1);
        }

        .status-opt.selected.suspend-opt {
            border-color: var(--danger);
            background: rgba(232, 90, 90, 0.08);
            color: var(--danger);
        }

        .status-opt.selected.suspend-opt .icon {
            color: var(--danger);
            transform: scale(1.1);
        }

        /* ===== BUTTON ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            width: 100%;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: inherit;
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
            transform: translateY(-2px);
            box-shadow: 0 8px 28px var(--theme-glow);
        }

        .btn-primary:active {
            transform: scale(0.97);
        }

        /* ===== USER LIST ===== */
        .u-list {
            margin-top: 4px;
        }

        .u-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-top: 1px solid var(--border-color);
            transition: background 0.2s ease;
            padding-left: 8px;
            padding-right: 8px;
            border-radius: 8px;
        }

        .u-row:first-child {
            border-top: none;
        }

        .u-row:hover {
            background: var(--bg-card-hover);
        }

        .u-avatar {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: var(--theme-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: var(--theme-primary);
            flex-shrink: 0;
            border: 1px solid rgba(var(--emerald-rgb), 0.1);
        }

        .u-info {
            flex: 1;
            min-width: 0;
        }

        .u-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .u-email {
            font-size: 11.5px;
            color: var(--text-tertiary);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .u-email .icon {
            width: 12px;
            height: 12px;
        }

        .u-empty {
            font-size: 13px;
            color: var(--text-tertiary);
            padding: 20px 0;
            text-align: center;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .cew-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .cew {
                padding: 0 12px 16px;
            }

            .cew-hero {
                padding: 24px 20px;
                flex-direction: column;
                align-items: flex-start;
            }

            .cew-hero h1 {
                font-size: 20px;
            }

            .cew-logo {
                width: 56px;
                height: 56px;
                font-size: 20px;
            }

            .cew-panels {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .cew-panel {
                padding: 22px 20px;
            }

            .status-toggle {
                flex-direction: row;
            }
        }

        @media (max-width: 480px) {
            .cew-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .cew-stat {
                padding: 14px 12px;
            }

            .cew-stat .n {
                font-size: 20px;
            }

            .cew-hero h1 {
                font-size: 18px;
            }

            .cew-hero {
                padding: 18px 16px;
            }

            .cew-logo {
                width: 48px;
                height: 48px;
                font-size: 18px;
                border-radius: 14px;
            }

            .cew-panel {
                padding: 18px 16px;
            }

            .status-opt {
                padding: 10px 12px;
            }

            .status-opt .icon {
                width: 17px;
                height: 17px;
            }

            .status-opt .lbl {
                font-size: 12px;
            }

            .u-row {
                padding: 8px 4px;
            }

            .u-avatar {
                width: 30px;
                height: 30px;
                font-size: 11px;
            }

            .u-name {
                font-size: 12px;
            }

            .u-email {
                font-size: 10.5px;
            }
        }

        @media (max-width: 380px) {
            .cew-grid {
                grid-template-columns: 1fr;
            }

            .cew-hero h1 {
                font-size: 16px;
            }

            .cew-status-badge {
                font-size: 10px;
                padding: 4px 12px;
            }
        }
    </style>

    <div class="cew">
        {{-- ===== BACK BUTTON ===== --}}
        <a href="{{ route('admin.companies.index') }}" class="cew-back animate-in" style="animation-delay: 0.03s;">
            <svg class="icon"><use href="#ic-arrow-left"/></svg>
            Kembali ke Kelola Company
        </a>

        {{-- ===== HERO ===== --}}
        <div class="cew-hero animate-in" style="animation-delay: 0.06s;">
            <div class="cew-hero-left">
                <div class="cew-logo">{{ strtoupper(substr($company->name, 0, 1)) }}</div>
                <div>
                    <h1>{{ $company->name }}</h1>
                    <div class="sub">
                        <span>Terdaftar {{ $company->created_at->translatedFormat('d F Y') }}</span>
                        <span class="dot"></span>
                        <span>{{ $company->users_count }} User</span>
                    </div>
                </div>
            </div>
            <span class="cew-status-badge {{ $company->status }}">
                <span class="sdot"></span>
                {{ $company->status === 'active' ? 'Aktif' : 'Disuspend' }}
            </span>
        </div>

        {{-- ===== STATS ===== --}}
        <div class="cew-grid animate-in" style="animation-delay: 0.09s;">
            <div class="cew-stat">
                <div class="n">{{ $company->users_count }}</div>
                <div class="l">Total User</div>
            </div>
            <div class="cew-stat">
                <div class="n">{{ $company->invoices_count }}</div>
                <div class="l">Total Faktur</div>
            </div>
            <div class="cew-stat">
                <div class="n">{{ $company->clients_count }}</div>
                <div class="l">Total Klien</div>
            </div>
            <div class="cew-stat">
                <div class="n">{{ $company->quotes_count }}</div>
                <div class="l">Total Penawaran</div>
            </div>
        </div>

        {{-- ===== PANELS ===== --}}
        <div class="cew-panels">
            {{-- STATUS PANEL --}}
            <div class="cew-panel animate-in" style="animation-delay: 0.12s;">
                <div class="panel-head">
                    <span class="pic"><svg class="icon"><use href="#ic-building"/></svg></span>
                    <div>
                        <h3>Status Company</h3>
                        <div class="panel-sub">Ubah status perusahaan</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.companies.update', $company) }}">
                    @csrf
                    @method('PUT')
                    <div class="status-toggle">
                        <label class="status-opt active-opt {{ $company->status === 'active' ? 'selected' : '' }}" onclick="selectStatus(this, 'active')">
                            <input type="radio" name="status" value="active" {{ $company->status === 'active' ? 'checked' : '' }}>
                            <svg class="icon"><use href="#ic-check-circle"/></svg>
                            <div class="lbl">Aktif</div>
                        </label>
                        <label class="status-opt suspend-opt {{ $company->status === 'suspended' ? 'selected' : '' }}" onclick="selectStatus(this, 'suspended')">
                            <input type="radio" name="status" value="suspended" {{ $company->status === 'suspended' ? 'checked' : '' }}>
                            <svg class="icon"><use href="#ic-pause-circle"/></svg>
                            <div class="lbl">Suspend</div>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <svg class="icon"><use href="#ic-check-circle"/></svg>
                        Simpan Status
                    </button>
                </form>
            </div>

            {{-- USERS PANEL --}}
            <div class="cew-panel animate-in" style="animation-delay: 0.15s;">
                <div class="panel-head">
                    <span class="pic"><svg class="icon"><use href="#ic-users"/></svg></span>
                    <div>
                        <h3>User di Company Ini</h3>
                        <div class="panel-sub">{{ $company->users_count }} user terdaftar</div>
                    </div>
                </div>
                <div class="u-list">
                    @forelse($company->users as $u)
                        <div class="u-row">
                            <div class="u-avatar">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                            <div class="u-info">
                                <div class="u-name">{{ $u->name }}</div>
                                <div class="u-email">
                                    <svg class="icon"><use href="#ic-mail"/></svg>
                                    {{ $u->email }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="u-empty">Belum ada user terdaftar.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectStatus(el, val) {
            document.querySelectorAll('.status-opt').forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');
        }
    </script>
</x-admin-layout>