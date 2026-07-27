<x-app-layout>
    <x-slot name="title">Detail Pos Laba Rugi</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        // Fungsi format angka ke jutaan (M)
        function formatCompact($number) {
            if ($number >= 1000000000) {
                return round($number / 1000000000, 1) . 'B';
            } elseif ($number >= 1000000) {
                $result = $number / 1000000;
                return ($result == floor($result)) ? number_format($result, 0) . 'M' : number_format($result, 1) . 'M';
            } elseif ($number >= 1000) {
                $result = $number / 1000;
                return ($result == floor($result)) ? number_format($result, 0) . 'K' : number_format($result, 1) . 'K';
            }
            return number_format($number, 0);
        }
    @endphp

    <style>
        .pl-detail {
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
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .pl-detail * { box-sizing: border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .pl-detail .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .pl-detail .icon {
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
        .pl-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .pl-header-left { flex: 1; min-width: 200px; }

        .pl-badge {
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

        .pl-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .pl-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .pl-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .pl-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .pl-header .subtitle .highlight {
            color: var(--theme-primary);
            font-weight: 600;
        }

        .pl-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        /* ===== BUTTONS ===== */
        .pl-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
        }

        .pl-btn .icon {
            width: 16px;
            height: 16px;
        }

        .pl-btn:hover {
            transform: translateY(-2px);
        }

        .pl-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .pl-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .pl-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            color: #fff;
        }

        .pl-btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .pl-btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .pl-btn .ripple {
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

        /* ===== DETAIL CARD ===== */
        .pl-detail-card {
            max-width: 640px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .pl-detail-card:hover {
            border-color: var(--border-hover);
        }

        .pl-detail-banner {
            padding: 32px 36px;
            text-align: center;
            position: relative;
        }

        .pl-detail-banner::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
        }

        .pl-detail-banner.pendapatan {
            background: var(--success-soft);
        }

        .pl-detail-banner.pendapatan::after {
            background: var(--success);
        }

        .pl-detail-banner.beban {
            background: var(--danger-soft);
        }

        .pl-detail-banner.beban::after {
            background: var(--danger);
        }

        .pl-type-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 8px;
            padding: 4px 14px;
            border-radius: 100px;
            background: rgba(255, 255, 255, 0.5);
        }

        .pl-detail-banner.pendapatan .pl-type-label {
            color: var(--success);
        }

        .pl-detail-banner.beban .pl-type-label {
            color: var(--danger);
        }

        .pl-detail-amount {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            font-size: 38px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .pl-detail-banner.pendapatan .pl-detail-amount {
            color: var(--success);
        }

        .pl-detail-banner.beban .pl-detail-amount {
            color: var(--danger);
        }

        .pl-detail-body {
            padding: 28px 36px 36px;
        }

        .pl-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-color);
            gap: 16px;
        }

        .pl-detail-row:last-child {
            border-bottom: none;
        }

        .pl-detail-row .pl-label {
            font-size: 13px;
            color: var(--text-tertiary);
            font-weight: 500;
        }

        .pl-detail-row .pl-value {
            font-size: 14px;
            font-weight: 600;
            text-align: right;
            color: var(--text-primary);
        }

        .pl-detail-row .pl-value .mono {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 500;
        }

        .pl-notes-box {
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            font-size: 13.5px;
            color: var(--text-secondary);
            margin-top: 16px;
            line-height: 1.6;
        }

        .pl-notes-box .label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-tertiary);
            margin-bottom: 6px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .pl-detail { padding: 0 16px; }
            .pl-header { flex-direction: column; }
            .pl-header-actions { width: 100%; }
            .pl-header-actions .pl-btn { flex: 1; justify-content: center; }
            .pl-detail-banner { padding: 24px 20px; }
            .pl-detail-body { padding: 20px 20px 24px; }
            .pl-detail-amount { font-size: 28px; }
        }

        @media (max-width: 480px) {
            .pl-header h1 { font-size: 22px; }
            .pl-detail-amount { font-size: 24px; }
            .pl-detail-row { 
                flex-direction: column; 
                align-items: flex-start;
                gap: 4px;
            }
            .pl-detail-row .pl-value { text-align: left; width: 100%; }
        }
    </style>

    <div class="pl-detail">

        <!-- ===== HEADER ===== -->
        <div class="pl-header animate-in" style="animation-delay: 0.05s;">
            <div class="pl-header-left">
                <div class="pl-badge">
                    <span class="dot"></span>
                    Detail Data
                </div>
                <h1>{{ $item->name }}</h1>
                <p class="subtitle">
                    Detail pos <strong>{{ $item->type === 'pendapatan' ? 'pendapatan' : 'beban' }}</strong> 
                    — periode <span class="highlight">{{ $item->period_label }}</span>
                </p>
            </div>
            <div class="pl-header-actions">
                <a href="{{ route('laba-rugi.index', ['month' => $item->period_month, 'year' => $item->period_year]) }}" class="pl-btn pl-btn-outline">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
                <a href="{{ route('laba-rugi.edit', $item) }}" class="pl-btn pl-btn-primary">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Edit
                </a>
            </div>
        </div>

        <!-- ===== DETAIL CARD ===== -->
        <div class="pl-detail-card animate-in" style="animation-delay: 0.10s;">
            <!-- Banner -->
            <div class="pl-detail-banner {{ $item->type }}">
                <div class="pl-type-label">
                    <svg class="icon" style="width:14px;height:14px;">
                        <use href="{{ $item->type === 'pendapatan' ? '#ic-trending-up' : '#ic-trending-down' }}"/>
                    </svg>
                    {{ $item->type === 'pendapatan' ? 'Pendapatan' : 'Beban' }}
                </div>
                <div class="pl-detail-amount">
                    {{ $currencySymbol }}{{ formatCompact($item->amount) }}
                </div>
            </div>

            <!-- Body -->
            <div class="pl-detail-body">
                <div class="pl-detail-row">
                    <span class="pl-label">Nama Pos</span>
                    <span class="pl-value">{{ $item->name }}</span>
                </div>
                <div class="pl-detail-row">
                    <span class="pl-label">Kategori</span>
                    <span class="pl-value">{{ $item->category }}</span>
                </div>
                <div class="pl-detail-row">
                    <span class="pl-label">Periode</span>
                    <span class="pl-value">{{ $item->period_label }}</span>
                </div>
                <div class="pl-detail-row">
                    <span class="pl-label">Dibuat pada</span>
                    <span class="pl-value">{{ $item->created_at->translatedFormat('d F Y, H:i') }}</span>
                </div>
                <div class="pl-detail-row">
                    <span class="pl-label">Terakhir diupdate</span>
                    <span class="pl-value">{{ $item->updated_at->translatedFormat('d F Y, H:i') }}</span>
                </div>

                @if($item->notes)
                    <div class="pl-notes-box">
                        <div class="label">📝 Catatan</div>
                        {{ $item->notes }}
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-arrow-left" viewBox="0 0 24 24">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </symbol>
        <symbol id="ic-edit" viewBox="0 0 24 24">
            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
            <path d="M15 5l4 4"/>
        </symbol>
        <symbol id="ic-trending-up" viewBox="0 0 24 24">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
            <polyline points="17 6 23 6 23 12"/>
        </symbol>
        <symbol id="ic-trending-down" viewBox="0 0 24 24">
            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/>
            <polyline points="17 18 23 18 23 12"/>
        </symbol>
    </svg>

    <script>
        // ===== RIPPLE EFFECT =====
        document.querySelectorAll('.pl-btn').forEach(btn => {
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
    </script>

</x-app-layout>