<x-app-layout>
    <x-slot name="title">Detail Kategori</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    @endphp

    <style>
        .detail-wrap {
            --theme-primary: var(--emerald);
            --theme-light: var(--emerald);
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
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            --warning: #F0A83C;

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;

            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);

            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }

        .detail-wrap * { box-sizing: border-box; }
        .detail-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .detail-wrap .animate-in { animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .detail-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .dt-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 32px;
            padding: 0 4px;
        }

        .dt-header-left { flex: 1; min-width: 200px; }

        .dt-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px 6px 12px;
            background: var(--theme-glow);
            border: 1px solid var(--theme-glow);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--theme-primary);
            margin-bottom: 14px;
        }

        .dt-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .dt-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .dt-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .dt-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .dt-btn {
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
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background: transparent;
            color: var(--text-secondary);
            position: relative;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .dt-btn .icon { width: 16px; height: 16px; }
        .dt-btn:hover { transform: translateY(-2px); }
        .dt-btn:active { transform: translateY(0) scale(0.97); }

        .dt-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .dt-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .dt-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .dt-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .dt-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* CARD */
        .dt-card {
            max-width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 36px;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .dt-card:hover {
            border-color: var(--border-hover);
            box-shadow: var(--shadow-md);
        }

        .dt-card-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-color);
        }

        .dt-card-header .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--theme-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px var(--theme-glow);
        }

        .dt-card-header .icon-box .icon {
            width: 22px;
            height: 22px;
        }

        .dt-card-header .title-group {
            flex: 1;
        }

        .dt-card-header .title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        .dt-card-header .sub {
            font-size: 12.5px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        .dt-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .dt-item {
            padding: 16px 20px;
            background: var(--bg-card-active);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .dt-item:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
        }

        .dt-item .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            margin-bottom: 5px;
        }

        .dt-item .value {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .dt-item .value.mono { font-family: 'IBM Plex Mono', monospace; }
        .dt-item .value.primary { color: var(--theme-primary); }

        .dt-divider {
            border: none;
            border-top: 2px solid var(--border-color);
            margin: 24px 0;
        }

        .dt-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .dt-stat {
            padding: 16px 20px;
            background: var(--bg-card-active);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
            text-align: center;
            transition: all 0.2s ease;
        }

        .dt-stat:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
        }

        .dt-stat .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            margin-bottom: 4px;
        }

        .dt-stat .value {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .dt-stat .value.mono { font-family: 'IBM Plex Mono', monospace; }
        .dt-stat .value.primary { color: var(--theme-primary); }
        .dt-stat .value.danger { color: var(--danger); }
        .dt-stat .value.success { color: var(--success); }

        .dt-footer {
            display: flex;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 2px solid var(--border-color);
        }

        .dt-footer .dt-btn {
            flex: 1;
            justify-content: center;
            padding: 12px 24px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .dt-grid { grid-template-columns: 1fr; gap: 12px; }
            .dt-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
            .dt-card { padding: 24px 20px; }
            .dt-header { flex-direction: column; align-items: flex-start; }
            .dt-actions { width: 100%; }
            .dt-actions .dt-btn { flex: 1; justify-content: center; }
            .dt-header h1 { font-size: 24px; }
        }

        @media (max-width: 640px) {
            .dt-card { padding: 20px 16px; border-radius: var(--radius-sm); }
            .dt-stats { grid-template-columns: 1fr; }
            .dt-footer { flex-direction: column; }
            .dt-card-header .icon-box { width: 40px; height: 40px; }
            .dt-card-header .icon-box .icon { width: 18px; height: 18px; }
            .dt-card-header .title { font-size: 15px; }
        }
    </style>

    <div class="detail-wrap">

        <div class="dt-header animate-in" style="animation-delay: 0.05s;">
            <div class="dt-header-left">
                <div class="dt-badge">
                    <span class="dot"></span>
                    Pembelian &amp; Biaya
                </div>
                <h1>Detail Kategori</h1>
                <p class="subtitle">Informasi lengkap kategori biaya</p>
            </div>
            <div class="dt-actions">
                <a href="{{ route('expense-categories.index') }}" class="dt-btn dt-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                    Kembali
                </a>
                <a href="/expense-categories/edit/{{ $index }}" class="dt-btn dt-btn-primary">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                        <path d="M15 5l4 4"/>
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <div class="dt-card animate-in" style="animation-delay: 0.10s;">
            
            <div class="dt-card-header">
                <div class="icon-box">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <div class="title-group">
                    <div class="title">Informasi Kategori</div>
                    <div class="sub">Detail lengkap kategori biaya</div>
                </div>
            </div>

            <div class="dt-grid">
                <div class="dt-item">
                    <div class="label">Nama Kategori</div>
                    <div class="value">{{ $category['name'] }}</div>
                </div>
                <div class="dt-item">
                    <div class="label">Deskripsi</div>
                    <div class="value">{{ $category['desc'] ?? 'Tidak ada deskripsi' }}</div>
                </div>
                <div class="dt-item" style="grid-column: 1 / -1;">
                    <div class="label">Total Pengeluaran</div>
                    <div class="value mono primary" style="font-size: 24px;">
                        {{ $currencySymbol }}{{ number_format($category['total'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <hr class="dt-divider">

            <div class="dt-stats">
                <div class="dt-stat">
                    <div class="label">Total Transaksi</div>
                    <div class="value primary">{{ $category['count'] ?? 0 }}</div>
                </div>
                <div class="dt-stat">
                    <div class="label">Rata-rata per Transaksi</div>
                    <div class="value mono primary">
                        {{ $currencySymbol }}{{ number_format(($category['count'] ?? 0) > 0 ? ($category['total'] ?? 0) / ($category['count'] ?? 1) : 0, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="dt-footer">
                <a href="{{ route('expense-categories.index') }}" class="dt-btn dt-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                    Kembali ke Daftar
                </a>
                <a href="/expense-categories/edit/{{ $index }}" class="dt-btn dt-btn-primary">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                        <path d="M15 5l4 4"/>
                    </svg>
                    Edit Kategori
                </a>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.dt-btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => { ripple.remove(); }, 600);
                });
            });
        });
    </script>

</x-app-layout>