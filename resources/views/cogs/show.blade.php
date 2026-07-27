<x-app-layout>
    <x-slot name="title">HPP {{ $entry->item_name }}</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
        
        function formatCurrency($amount, $currency = 'Rp') {
            if ($amount === null || $amount === '') return $currency . '0';
            $amount = (float) $amount;
            if ($amount >= 1000000000) {
                return $currency . number_format($amount / 1000000000, 1, ',', '.') . ' M';
            } elseif ($amount >= 1000000) {
                return $currency . number_format($amount / 1000000, 1, ',', '.') . ' Jt';
            } elseif ($amount >= 1000) {
                return $currency . number_format($amount / 1000, 1, ',', '.') . ' Rb';
            } else {
                return $currency . number_format($amount, 0, ',', '.');
            }
        }
    @endphp

    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-package" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/>
                <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </symbol>
            <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="ic-link" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .cogs-detail-wrap {
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
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
            width: 100%;
            max-width: 100%;
        }

        .cogs-detail-wrap * { box-sizing: border-box; }
        .cogs-detail-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .cogs-detail-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .cogs-detail-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .cogs-detail-wrap .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== BADGE ===== */
        .cogs-detail-badge {
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

        .cogs-detail-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        /* ===== HEADER ===== */
        .cd-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .cd-header-left { flex: 1; min-width: 200px; }

        .cd-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .cd-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cd-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .cd-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .cd-btn {
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
            position: relative;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .cd-btn .icon { width: 16px; height: 16px; }
        .cd-btn:hover { transform: translateY(-2px); }
        .cd-btn:active { transform: translateY(0) scale(0.97); }

        .cd-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .cd-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .cd-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cd-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        /* ===== CARD ===== */
        .cd-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 40px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            width: 100%;
        }

        .cd-card:hover {
            border-color: var(--border-hover);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .cd-card .title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cd-card .title .icon {
            width: 20px;
            height: 20px;
            color: var(--theme-primary);
        }

        .cd-card .title .line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, var(--border-color), transparent);
        }

        /* ===== STATUS BADGE ===== */
        .cd-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
        }

        .cd-status-badge.linked {
            background: var(--info-soft);
            color: var(--info);
        }

        .cd-status-badge.linked .sdot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--info);
        }

        .cd-status-badge.manual {
            background: var(--bg-card-active);
            color: var(--text-tertiary);
        }

        .cd-status-badge.manual .sdot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--text-tertiary);
        }

        /* ===== AMOUNT HERO ===== */
        .cd-amount-hero {
            margin-top: 20px;
            padding: 20px 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .cd-amount-hero .amount {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            font-size: 38px;
            font-weight: 700;
            color: var(--theme-primary);
        }

        .cd-amount-hero .sub {
            font-size: 13px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        /* ===== DETAIL GRID ===== */
        .cd-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 40px;
            margin-top: 24px;
        }

        .cd-detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .cd-detail-item .label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
        }

        .cd-detail-item .value {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .cd-detail-item .value.mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        .cd-detail-item .value.link {
            color: var(--info);
            text-decoration: none;
        }

        .cd-detail-item .value.link:hover {
            text-decoration: underline;
        }

        /* ===== NOTES ===== */
        .cd-notes {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        .cd-notes .label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            margin-bottom: 8px;
        }

        .cd-notes .content {
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .cd-notes .content:empty::before {
            content: 'Tidak ada catatan';
            color: var(--text-tertiary);
            font-style: italic;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .cogs-detail-wrap { padding: 0 12px; }
            .cd-card { padding: 20px 24px; }
            .cd-header { flex-direction: column; }
            .cd-header h1 { font-size: 24px; }
            .cd-actions { width: 100%; }
            .cd-actions .cd-btn { flex: 1; justify-content: center; }
            .cd-detail-grid { grid-template-columns: 1fr; gap: 0; }
            .cd-detail-item:last-child { border-bottom: none; }
            .cd-amount-hero .amount { font-size: 30px; }
        }

        @media (max-width: 640px) {
            .cogs-detail-wrap { padding: 0 8px; }
            .cd-card { padding: 16px; }
            .cd-header h1 { font-size: 20px; }
            .cd-btn { font-size: 12px; padding: 8px 14px; }
            .cd-btn .icon { width: 14px; height: 14px; }
            .cd-amount-hero .amount { font-size: 26px; }
            .cd-detail-item .value { font-size: 14px; }
        }

        @media (max-width: 380px) {
            .cogs-detail-wrap { padding: 0 4px; }
            .cd-card { padding: 12px; }
        }
    </style>

    <div class="cogs-detail-wrap">

        <!-- ===== HEADER ===== -->
        <div class="cd-header animate-in" style="animation-delay: 0.05s;">
            <div class="cd-header-left">
                <div class="cogs-detail-badge">
                    <span class="dot"></span>
                    Akuntansi
                </div>
                <h1>{{ $entry->item_name }}</h1>
                <p class="subtitle">
                    Harga Pokok Penjualan — 
                    <strong>{{ $entry->sale_date->translatedFormat('d M Y') }}</strong>
                </p>
            </div>
            <div class="cd-actions">
                <a href="{{ route('cogs.index') }}" class="cd-btn cd-btn-ghost">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
                <a href="{{ route('cogs.edit', ['entry' => $entry->id]) }}" class="cd-btn cd-btn-primary">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Edit
                </a>
            </div>
        </div>

        <!-- ===== CARD - FULL WIDTH ===== -->
        <div class="cd-card animate-in" style="animation-delay: 0.10s;">
            <div class="title">
                <svg class="icon"><use href="#ic-package"/></svg>
                Detail HPP
                <span class="line"></span>
            </div>

            <!-- Status -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <span class="cd-status-badge {{ $entry->inventoryItem ? 'linked' : 'manual' }}">
                    <span class="sdot"></span>
                    {{ $entry->inventoryItem ? 'Terhubung ke Inventaris' : 'Input Manual' }}
                </span>
                <span style="font-size: 12px; color: var(--text-tertiary);">
                    Dicatat: {{ $entry->created_at->translatedFormat('d M Y, H:i') }}
                </span>
            </div>

            <!-- Amount Hero -->
            <div class="cd-amount-hero">
                <div class="amount mono">{{ formatCurrency($entry->total_cogs, $currencySymbol) }}</div>
                <div class="sub">Total Harga Pokok Penjualan</div>
            </div>

            <!-- Detail Grid -->
            <div class="cd-detail-grid">
                <div class="cd-detail-item">
                    <span class="label">Nama Barang</span>
                    <span class="value">{{ $entry->item_name }}</span>
                </div>
                <div class="cd-detail-item">
                    <span class="label">Barang di Inventaris</span>
                    <span class="value">
                        @if($entry->inventoryItem)
                            <a href="{{ route('inventory.show', $entry->inventoryItem) }}" class="value link">
                                {{ $entry->inventoryItem->name }}
                            </a>
                        @else
                            <span style="color: var(--text-tertiary);">—</span>
                        @endif
                    </span>
                </div>
                <div class="cd-detail-item">
                    <span class="label">Jumlah Terjual</span>
                    <span class="value">{{ number_format($entry->quantity_sold, 0, ',', '.') }} unit</span>
                </div>
                <div class="cd-detail-item">
                    <span class="label">Harga Pokok per Unit</span>
                    <span class="value mono">{{ formatCurrency($entry->unit_cost, $currencySymbol) }}</span>
                </div>
                <div class="cd-detail-item">
                    <span class="label">Tanggal Penjualan</span>
                    <span class="value">{{ $entry->sale_date->translatedFormat('d F Y') }}</span>
                </div>
                <div class="cd-detail-item">
                    <span class="label">Periode</span>
                    <span class="value">{{ $entry->sale_date->translatedFormat('F Y') }}</span>
                </div>
            </div>

            <!-- Notes -->
            <div class="cd-notes">
                <span class="label">Catatan</span>
                <div class="content">{{ $entry->notes ?? '' }}</div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ripple effect
            const buttons = document.querySelectorAll('.cd-btn');
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