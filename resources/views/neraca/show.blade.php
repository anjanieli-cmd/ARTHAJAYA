<x-app-layout>
    <x-slot name="title">Detail Pos Neraca</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
        
        $categoryMap = [
            'aset' => 'Aset',
            'kewajiban' => 'Kewajiban',
            'modal' => 'Modal'
        ];
        
        $categoryLabel = $categoryMap[$item->category] ?? ucfirst($item->category);
        
        $categoryColors = [
            'aset' => ['bg' => 'rgba(var(--emerald-rgb), 0.12)', 'color' => 'var(--emerald)'],
            'kewajiban' => ['bg' => 'rgba(var(--danger-rgb), 0.12)', 'color' => 'var(--danger)'],
            'modal' => ['bg' => 'rgba(var(--info-rgb), 0.12)', 'color' => 'var(--info)']
        ];
        
        $categoryColor = $categoryColors[$item->category] ?? ['bg' => 'var(--theme-soft)', 'color' => 'var(--theme-primary)'];
    @endphp

    <style>
        .neraca-detail-wrap {
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
            --info-rgb: 78, 143, 240;
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }

        .neraca-detail-wrap * { box-sizing: border-box; }
        .neraca-detail-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .neraca-detail-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .neraca-detail-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .nd-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .nd-header-left { flex: 1; min-width: 200px; }

        .nd-badge {
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

        .nd-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .nd-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .nd-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .nd-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .nd-header .subtitle .highlight {
            color: var(--theme-primary);
            font-weight: 600;
        }

        .nd-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .nd-btn {
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
        }

        .nd-btn .icon { width: 16px; height: 16px; }
        .nd-btn:hover { transform: translateY(-2px); }
        .nd-btn:active { transform: translateY(0) scale(0.97); }

        .nd-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .nd-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .nd-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .nd-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .nd-btn .ripple {
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

        /* DETAIL CONTENT */
        .nd-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .nd-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px;
            transition: border-color 0.22s ease;
        }

        .nd-card:hover { border-color: var(--border-hover); }

        .nd-card .title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nd-card .title .icon-box {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-sm);
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .nd-card .title .icon-box .icon {
            width: 16px;
            height: 16px;
        }

        /* Category Pill */
        .nd-type-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        /* Amount Display */
        .nd-amount-label {
            font-size: 12px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .nd-amount-value {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        /* Detail Rows */
        .nd-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            gap: 16px;
        }

        .nd-detail-row:last-child { border-bottom: none; }

        .nd-detail-row .label {
            font-size: 12.5px;
            color: var(--text-tertiary);
        }

        .nd-detail-row .value {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-primary);
            text-align: right;
        }

        .nd-detail-row .value .mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        /* Notes */
        .nd-notes-box {
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 14px;
            line-height: 1.6;
        }

        .nd-notes-box.empty {
            color: var(--text-tertiary);
            font-style: italic;
        }

        /* Empty State */
        .nd-empty-notes {
            text-align: center;
            padding: 24px;
            color: var(--text-tertiary);
        }

        .nd-empty-notes .icon {
            width: 32px;
            height: 32px;
            color: var(--text-tertiary);
            opacity: 0.5;
            margin-bottom: 8px;
        }

        @media (max-width: 992px) {
            .nd-content { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .nd-header { flex-direction: column; }
            .nd-actions { width: 100%; }
            .nd-actions .nd-btn { flex: 1; justify-content: center; }
            .nd-card { padding: 16px; }
            .nd-amount-value { font-size: 26px; }
        }

        @media (max-width: 380px) {
            .nd-header h1 { font-size: 22px; }
            .nd-btn { font-size: 12px; padding: 8px 14px; }
            .nd-btn .icon { width: 14px; height: 14px; }
            .nd-amount-value { font-size: 22px; }
        }
    </style>

    <div class="neraca-detail-wrap">

        <div class="nd-header animate-in" style="animation-delay: 0.05s;">
            <div class="nd-header-left">
                <div class="nd-badge">
                    <span class="dot"></span>
                    Detail Neraca
                </div>
                <h1>{{ $item->name }}</h1>
                <p class="subtitle">
                    Detail pos neraca <strong>{{ $item->name }}</strong> per 
                    <span class="highlight">{{ $item->as_of_date->translatedFormat('d F Y') }}</span>
                </p>
            </div>
            <div class="nd-actions">
                <a href="{{ route('neraca.index', ['as_of_date' => $item->as_of_date->format('Y-m-d')]) }}" class="nd-btn nd-btn-ghost">
                    <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
                    Kembali
                </a>
                <a href="{{ route('neraca.edit', $item) }}" class="nd-btn nd-btn-primary">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Edit
                </a>
            </div>
        </div>

        <div class="nd-content">
            <!-- MAIN DETAIL -->
            <div class="nd-card animate-in" style="animation-delay: 0.10s;">
                <div class="title">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-bank"/></svg>
                    </div>
                    Informasi Pos
                </div>

                <div class="nd-type-pill" style="background:{{ $categoryColor['bg'] }}; color:{{ $categoryColor['color'] }};">
                    <span class="dot" style="width:6px;height:6px;border-radius:50%;background:{{ $categoryColor['color'] }};display:inline-block;"></span>
                    {{ $categoryLabel }}
                </div>

                <div class="nd-amount-label">Jumlah</div>
                <div class="nd-amount-value">{{ $currencySymbol }} {{ number_format($item->amount, 0, ',', '.') }}</div>

                <div style="margin-top:24px; border-top:1px solid var(--border-color); padding-top:16px;">
                    <div class="nd-detail-row">
                        <span class="label">Nama Pos</span>
                        <span class="value">{{ $item->name }}</span>
                    </div>
                    <div class="nd-detail-row">
                        <span class="label">Kategori</span>
                        <span class="value">{{ $categoryLabel }}</span>
                    </div>
                    <div class="nd-detail-row">
                        <span class="label">Per Tanggal</span>
                        <span class="value">{{ $item->as_of_date->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- SIDEBAR / META -->
            <div class="nd-card animate-in" style="animation-delay: 0.15s;">
                <div class="title">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-info"/></svg>
                    </div>
                    Informasi Tambahan
                </div>

                <div class="nd-detail-row">
                    <span class="label">Dibuat pada</span>
                    <span class="value">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
                </div>
                <div class="nd-detail-row">
                    <span class="label">Terakhir diperbarui</span>
                    <span class="value">{{ $item->updated_at->translatedFormat('d M Y, H:i') }}</span>
                </div>
                <div class="nd-detail-row" style="border-bottom: none; padding-bottom: 0;">
                    <span class="label">Catatan</span>
                </div>
                
                @if($item->description)
                    <div class="nd-notes-box">
                        {{ $item->description }}
                    </div>
                @else
                    <div class="nd-notes-box empty">
                        <div class="nd-empty-notes">
                            <svg class="icon" style="display:block;margin:0 auto 8px;"><use href="#ic-file-text"/></svg>
                            Tidak ada catatan
                        </div>
                    </div>
                @endif

                <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--border-color);">
                    <div class="nd-bank-rule" style="background:var(--theme-soft);border-radius:var(--radius-sm);padding:12px 16px;display:flex;align-items:center;gap:10px;font-size:12px;color:var(--text-secondary);">
                        <svg class="icon" style="width:20px;height:20px;color:var(--theme-primary);flex-shrink:0;"><use href="#ic-info"/></svg>
                        <span>Pastikan <strong style="color:var(--theme-primary);">Aset = Kewajiban + Modal</strong> untuk menjaga keseimbangan neraca.</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- SVG Icons -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
        <symbol id="ic-bank" viewBox="0 0 24 24"><rect x="2" y="10" width="20" height="12" rx="2"/><line x1="12" y1="2" x2="12" y2="10"/><line x1="6" y1="6" x2="6" y2="10"/><line x1="18" y1="6" x2="18" y2="10"/></symbol>
        <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></symbol>
        <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
        <symbol id="ic-file-text" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.nd-btn').forEach(btn => {
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