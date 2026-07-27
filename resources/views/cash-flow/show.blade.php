<x-app-layout>
    <x-slot name="title">Detail Transaksi Arus Kas</x-slot>

    <style>
        .cf-detail-wrap {
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
            --danger-rgb: 232, 90, 90;
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.12);
            --warning-rgb: 240, 168, 60;
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .cf-detail-wrap * { box-sizing: border-box; }
        .cf-detail-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }
        .cf-detail-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .cf-detail-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }

        /* ===== HEADER ===== */
        .cf-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .cf-detail-header-left { flex: 1; min-width: 200px; }

        .cf-detail-badge {
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

        .cf-detail-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .cf-detail-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .cf-detail-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cf-detail-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .cf-detail-header .subtitle .highlight {
            color: var(--theme-primary);
            font-weight: 600;
        }

        .cf-detail-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .cf-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
            position: relative;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .cf-btn .icon { width: 16px; height: 16px; }
        .cf-btn:hover { transform: translateY(-2px); }
        .cf-btn:active { transform: translateY(0) scale(0.97); }

        .cf-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .cf-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            color: #fff;
        }

        .cf-btn-outline {
            background: var(--bg-card);
            border: 1.5px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cf-btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .cf-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        /* ===== HERO CARD ===== */
        .cf-hero {
            display: flex;
            align-items: center;
            gap: 20px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px 28px;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
        }

        .cf-hero:hover {
            border-color: var(--border-hover);
        }

        .cf-hero-icon {
            width: 56px;
            height: 56px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cf-hero-icon .icon {
            width: 24px;
            height: 24px;
        }

        .cf-hero.masuk .cf-hero-icon {
            background: var(--success-soft);
            color: var(--success);
        }

        .cf-hero.keluar .cf-hero-icon {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .cf-hero-info {
            flex: 1;
        }

        .cf-hero-amount {
            font-family: 'Space Grotesk', 'IBM Plex Mono', monospace;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .cf-hero.masuk .cf-hero-amount {
            color: var(--success);
        }

        .cf-hero.keluar .cf-hero-amount {
            color: var(--danger);
        }

        .cf-hero-label {
            font-size: 13px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cf-hero-label .divider {
            color: var(--text-tertiary);
        }

        .cf-hero-direction-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
        }

        .cf-hero.masuk .cf-hero-direction-tag {
            background: var(--success-soft);
            color: var(--success);
        }

        .cf-hero.keluar .cf-hero-direction-tag {
            background: var(--danger-soft);
            color: var(--danger);
        }

        /* ===== DETAIL PANEL ===== */
        .cf-detail-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 0;
            overflow: hidden;
            transition: border-color 0.3s ease;
        }

        .cf-detail-card:hover {
            border-color: var(--border-hover);
        }

        .cf-detail-card .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cf-detail-card .card-header .header-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cf-detail-card .card-header .header-icon .icon {
            width: 16px;
            height: 16px;
        }

        .cf-detail-card .card-header .header-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .cf-detail-card .card-body {
            padding: 8px 24px;
        }

        .cf-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-color);
            gap: 16px;
        }

        .cf-detail-row:last-child {
            border-bottom: none;
        }

        .cf-detail-row .label {
            font-size: 12.5px;
            color: var(--text-tertiary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cf-detail-row .label .icon {
            width: 14px;
            height: 14px;
            opacity: 0.5;
        }

        .cf-detail-row .value {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-primary);
            text-align: right;
        }

        .cf-detail-row .value .mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        .activity-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px 4px 8px;
            border-radius: 100px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .activity-tag .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: inline-block;
        }

        .activity-tag.operasional {
            background: var(--success-soft);
            color: var(--success);
        }

        .activity-tag.operasional .dot {
            background: var(--success);
        }

        .activity-tag.investasi {
            background: var(--info-soft);
            color: var(--info);
        }

        .activity-tag.investasi .dot {
            background: var(--info);
        }

        .activity-tag.pendanaan {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .activity-tag.pendanaan .dot {
            background: var(--warning);
        }

        /* ===== NOTES ===== */
        .cf-notes {
            margin-top: 20px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 0;
            overflow: hidden;
            transition: border-color 0.3s ease;
        }

        .cf-notes:hover {
            border-color: var(--border-hover);
        }

        .cf-notes .notes-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cf-notes .notes-header .icon {
            width: 16px;
            height: 16px;
            color: var(--text-tertiary);
        }

        .cf-notes .notes-header span {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .cf-notes .notes-body {
            padding: 18px 24px;
            font-size: 13.5px;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        .cf-notes .notes-body.empty {
            color: var(--text-tertiary);
            font-style: italic;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .cf-detail-wrap { padding: 0 16px; }
            .cf-detail-header { flex-direction: column; }
            .cf-detail-header h1 { font-size: 22px; }
            .cf-detail-actions { width: 100%; }
            .cf-detail-actions .cf-btn { flex: 1; justify-content: center; }
            .cf-hero { flex-direction: column; text-align: center; padding: 20px; }
            .cf-hero-amount { font-size: 26px; }
            .cf-detail-card .card-body { padding: 0 16px; }
            .cf-detail-card .card-header { padding: 14px 16px; }
            .cf-notes .notes-header { padding: 12px 16px; }
            .cf-notes .notes-body { padding: 14px 16px; }
        }

        @media (max-width: 480px) {
            .cf-detail-wrap { padding: 0 12px; }
            .cf-detail-header h1 { font-size: 20px; }
            .cf-btn { font-size: 12px; padding: 8px 14px; }
            .cf-btn .icon { width: 14px; height: 14px; }
            .cf-hero-amount { font-size: 22px; }
            .cf-hero { padding: 16px; gap: 12px; }
            .cf-hero-icon { width: 44px; height: 44px; }
            .cf-hero-icon .icon { width: 20px; height: 20px; }
        }
    </style>

    <div class="cf-detail-wrap">

        {{-- ===== HEADER ===== --}}
        <div class="cf-detail-header animate-in" style="animation-delay: 0.05s;">
            <div class="cf-detail-header-left">
                <div class="cf-detail-badge">
                    <span class="dot"></span>
                    Detail Transaksi
                </div>
                <h1>{{ $item->name }}</h1>
                <p class="subtitle">
                    Detail transaksi arus kas untuk periode 
                    <span class="highlight">{{ $item->period_label }}</span>
                </p>
            </div>
            <div class="cf-detail-actions">
                <a href="{{ route('cash-flow.index', ['month' => $item->period_month, 'year' => $item->period_year]) }}" class="cf-btn cf-btn-outline">
                    <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
                    Kembali
                </a>
                <a href="{{ route('cash-flow.edit', $item) }}" class="cf-btn cf-btn-primary">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Edit
                </a>
            </div>
        </div>

        {{-- ===== HERO ===== --}}
        <div class="cf-hero {{ $item->direction }} animate-in" style="animation-delay: 0.10s;">
            <div class="cf-hero-icon">
                <svg class="icon"><use href="#{{ $item->direction === 'masuk' ? 'ic-trending-up' : 'ic-trending-down' }}"/></svg>
            </div>
            <div class="cf-hero-info">
                <div class="cf-hero-amount">
                    {{ $item->direction === 'masuk' ? '+' : '-' }}Rp {{ number_format($item->amount, 0, ',', '.') }}
                </div>
                <div class="cf-hero-label">
                    <span>{{ $item->direction === 'masuk' ? 'Kas Masuk' : 'Kas Keluar' }}</span>
                    <span class="divider">•</span>
                    <span class="cf-hero-direction-tag">
                        <svg class="icon" style="width:12px;height:12px;"><use href="#{{ $item->direction === 'masuk' ? 'ic-arrow-up' : 'ic-arrow-down' }}"/></svg>
                        {{ $item->direction === 'masuk' ? 'Penerimaan' : 'Pengeluaran' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ===== DETAIL CARD ===== --}}
        <div class="cf-detail-card animate-in" style="animation-delay: 0.15s;">
            <div class="card-header">
                <div class="header-icon">
                    <svg class="icon"><use href="#ic-info"/></svg>
                </div>
                <span class="header-title">Informasi Transaksi</span>
            </div>
            <div class="card-body">
                <div class="cf-detail-row">
                    <span class="label">
                        <svg class="icon"><use href="#ic-tag"/></svg>
                        Nama Transaksi
                    </span>
                    <span class="value">{{ $item->name }}</span>
                </div>
                <div class="cf-detail-row">
                    <span class="label">
                        <svg class="icon"><use href="#ic-grid"/></svg>
                        Kategori
                    </span>
                    <span class="value">{{ ucfirst($item->category) }}</span>
                </div>
                <div class="cf-detail-row">
                    <span class="label">
                        <svg class="icon"><use href="#ic-activity"/></svg>
                        Aktivitas
                    </span>
                    <span class="value">
                        <span class="activity-tag {{ $item->activity_type }}">
                            <span class="dot"></span>
                            {{ ucfirst($item->activity_type) }}
                        </span>
                    </span>
                </div>
                <div class="cf-detail-row">
                    <span class="label">
                        <svg class="icon"><use href="#ic-calendar"/></svg>
                        Periode
                    </span>
                    <span class="value">{{ $item->period_label }}</span>
                </div>
                <div class="cf-detail-row">
                    <span class="label">
                        <svg class="icon"><use href="#ic-clock"/></svg>
                        Dibuat pada
                    </span>
                    <span class="value">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
                </div>
                <div class="cf-detail-row">
                    <span class="label">
                        <svg class="icon"><use href="#ic-clock"/></svg>
                        Terakhir diperbarui
                    </span>
                    <span class="value">{{ $item->updated_at->translatedFormat('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- ===== NOTES ===== --}}
        <div class="cf-notes animate-in" style="animation-delay: 0.20s;">
            <div class="notes-header">
                <svg class="icon"><use href="#ic-file-text"/></svg>
                <span>Catatan</span>
            </div>
            <div class="notes-body {{ $item->notes ? '' : 'empty' }}">
                @if($item->notes)
                    {{ $item->notes }}
                @else
                    <svg class="icon" style="width:16px;height:16px;display:inline-block;vertical-align:middle;margin-right:6px;opacity:0.5;"><use href="#ic-file"/></svg>
                    Tidak ada catatan untuk transaksi ini
                @endif
            </div>
        </div>

    </div>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
        <symbol id="ic-arrow-up" viewBox="0 0 24 24"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></symbol>
        <symbol id="ic-arrow-down" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></symbol>
        <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></symbol>
        <symbol id="ic-trending-up" viewBox="0 0 24 24"><polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/></symbol>
        <symbol id="ic-trending-down" viewBox="0 0 24 24"><polyline points="3 7 9 13 13 9 21 17"/><polyline points="14 17 21 17 21 10"/></symbol>
        <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
        <symbol id="ic-tag" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></symbol>
        <symbol id="ic-grid" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></symbol>
        <symbol id="ic-activity" viewBox="0 0 24 24"><polyline points="3 12 8 12 10 6 14 18 16 12 21 12"/></symbol>
        <symbol id="ic-calendar" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></symbol>
        <symbol id="ic-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></symbol>
        <symbol id="ic-file-text" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></symbol>
        <symbol id="ic-file" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.cf-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });
        });
    </script>

</x-app-layout>