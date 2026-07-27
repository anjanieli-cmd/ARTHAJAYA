<x-app-layout>
    <x-slot name="title">Detail Transaksi Buku Besar</x-slot>

    <style>
        .ledger-detail-wrap {
            --theme-primary: var(--info);
            --theme-light: #4E8FF0;
            --theme-dark: #3a7ad4;
            --theme-glow: rgba(78, 143, 240, 0.25);
            --theme-soft: rgba(78, 143, 240, 0.12);
            --theme-gradient: linear-gradient(135deg, #4E8FF0, #3a7ad4);
            
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
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .ledger-detail-wrap * { box-sizing: border-box; }
        .ledger-detail-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }
        .ledger-detail-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .ledger-detail-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }

        /* ===== HEADER ===== */
        .ledger-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ledger-detail-header-left { flex: 1; min-width: 200px; }

        .ledger-detail-badge {
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

        .ledger-detail-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ledger-detail-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ledger-detail-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ledger-detail-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .ledger-detail-header .subtitle .highlight {
            color: var(--theme-primary);
            font-weight: 600;
        }

        .ledger-detail-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .ledger-btn {
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

        .ledger-btn .icon { width: 16px; height: 16px; }
        .ledger-btn:hover { transform: translateY(-2px); }
        .ledger-btn:active { transform: translateY(0) scale(0.97); }

        .ledger-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ledger-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            color: #fff;
        }

        .ledger-btn-outline {
            background: var(--bg-card);
            border: 1.5px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ledger-btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ledger-btn .ripple {
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

        /* ===== SLIP CARD ===== */
        .ledger-slip {
            max-width: 580px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: border-color 0.3s ease;
            position: relative;
        }

        .ledger-slip:hover {
            border-color: var(--border-hover);
        }

        .ledger-slip .slip-accent {
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--theme-gradient);
            border-radius: 0 4px 4px 0;
        }

        .ledger-slip .slip-header {
            padding: 22px 28px;
            border-bottom: 2px dashed var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .ledger-slip .slip-header .left {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .ledger-slip .slip-header .left .acc-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .ledger-slip .slip-header .left .acc-code {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            color: var(--text-tertiary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
            width: fit-content;
            border: 1px solid var(--border-color);
        }

        .ledger-slip .slip-header .right {
            text-align: right;
        }

        .ledger-slip .slip-header .right .slip-date {
            font-size: 13px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ledger-slip .slip-header .right .slip-date .icon {
            width: 16px;
            height: 16px;
            color: var(--text-tertiary);
        }

        .ledger-slip .slip-header .right .slip-id {
            font-size: 11px;
            color: var(--text-tertiary);
            font-family: 'IBM Plex Mono', monospace;
        }

        .ledger-slip .slip-body {
            padding: 26px 28px;
        }

        .ledger-slip .slip-description {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .ledger-slip .slip-amounts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 22px;
        }

        .ledger-slip .slip-amount-box {
            border-radius: var(--radius-sm);
            padding: 16px 18px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .ledger-slip .slip-amount-box:hover {
            transform: translateY(-2px);
        }

        .ledger-slip .slip-amount-box.debit {
            background: var(--success-soft);
            border: 1px solid rgba(52, 181, 131, 0.3);
        }

        .ledger-slip .slip-amount-box.credit {
            background: var(--danger-soft);
            border: 1px solid rgba(232, 90, 90, 0.3);
        }

        .ledger-slip .slip-amount-box .lbl {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .ledger-slip .slip-amount-box .val {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 20px;
            font-weight: 700;
        }

        .ledger-slip .slip-amount-box.debit .val {
            color: var(--success);
        }

        .ledger-slip .slip-amount-box.credit .val {
            color: var(--danger);
        }

        .ledger-slip .slip-amount-box .empty-val {
            color: var(--text-tertiary);
            font-weight: 400;
            font-size: 16px;
        }

        /* ===== DETAIL ROWS ===== */
        .ledger-slip .slip-details {
            border-top: 1px solid var(--border-color);
            padding-top: 16px;
        }

        .ledger-slip .slip-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            gap: 16px;
        }

        .ledger-slip .slip-row:not(:last-child) {
            border-bottom: 1px solid var(--border-color);
        }

        .ledger-slip .slip-row .label {
            font-size: 12.5px;
            color: var(--text-tertiary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ledger-slip .slip-row .label .icon {
            width: 14px;
            height: 14px;
            opacity: 0.5;
        }

        .ledger-slip .slip-row .value {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            text-align: right;
        }

        .ledger-slip .slip-row .value .mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        /* ===== NOTES ===== */
        .ledger-slip .slip-notes {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }

        .ledger-slip .slip-notes .notes-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .ledger-slip .slip-notes .notes-header .icon {
            width: 16px;
            height: 16px;
            color: var(--text-tertiary);
        }

        .ledger-slip .slip-notes .notes-header span {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .ledger-slip .slip-notes .notes-body {
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            font-size: 13.5px;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        .ledger-slip .slip-notes .notes-body.empty {
            color: var(--text-tertiary);
            font-style: italic;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ledger-slip .slip-notes .notes-body.empty .icon {
            width: 16px;
            height: 16px;
            opacity: 0.4;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 640px) {
            .ledger-detail-wrap { padding: 0 16px; }
            .ledger-detail-header { flex-direction: column; }
            .ledger-detail-header h1 { font-size: 22px; }
            .ledger-detail-actions { width: 100%; }
            .ledger-detail-actions .ledger-btn { flex: 1; justify-content: center; }
            .ledger-slip { max-width: 100%; }
            .ledger-slip .slip-header { flex-direction: column; align-items: flex-start; }
            .ledger-slip .slip-header .right { width: 100%; text-align: left; }
            .ledger-slip .slip-amounts { grid-template-columns: 1fr; }
            .ledger-slip .slip-body { padding: 20px; }
            .ledger-slip .slip-amount-box .val { font-size: 18px; }
        }

        @media (max-width: 480px) {
            .ledger-detail-wrap { padding: 0 12px; }
            .ledger-detail-header h1 { font-size: 20px; }
            .ledger-btn { font-size: 12px; padding: 8px 14px; }
            .ledger-btn .icon { width: 14px; height: 14px; }
            .ledger-slip .slip-header { padding: 16px 18px; }
            .ledger-slip .slip-body { padding: 16px 18px; }
            .ledger-slip .slip-amount-box { padding: 12px 14px; }
            .ledger-slip .slip-amount-box .val { font-size: 16px; }
            .ledger-slip .slip-description { font-size: 14px; }
        }
    </style>

    <div class="ledger-detail-wrap">

        {{-- ===== HEADER ===== --}}
        <div class="ledger-detail-header animate-in" style="animation-delay: 0.05s;">
            <div class="ledger-detail-header-left">
                <div class="ledger-detail-badge">
                    <span class="dot"></span>
                    Detail Transaksi
                </div>
                <h1>Transaksi #{{ $item->id }}</h1>
                <p class="subtitle">
                    Detail transaksi buku besar untuk akun 
                    <span class="highlight">{{ $item->account_name }}</span>
                </p>
            </div>
            <div class="ledger-detail-actions">
                <a href="{{ route('ledger.index', ['account' => $item->account_code]) }}" class="ledger-btn ledger-btn-outline">
                    <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
                    Kembali
                </a>
                <a href="{{ route('ledger.edit', $item) }}" class="ledger-btn ledger-btn-primary">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Edit
                </a>
            </div>
        </div>

        {{-- ===== SLIP ===== --}}
        <div class="ledger-slip animate-in" style="animation-delay: 0.10s;">
            <div class="slip-accent"></div>

            <div class="slip-header">
                <div class="left">
                    <div class="acc-name">{{ $item->account_name }}</div>
                    <span class="acc-code">{{ $item->account_code }}</span>
                </div>
                <div class="right">
                    <div class="slip-date">
                        <svg class="icon"><use href="#ic-calendar"/></svg>
                        {{ $item->transaction_date->translatedFormat('d M Y') }}
                    </div>
                    <div class="slip-id">ID: #{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>

            <div class="slip-body">
                <div class="slip-description">
                    {{ $item->description }}
                </div>

                <div class="slip-amounts">
                    <div class="slip-amount-box debit">
                        <div class="lbl">Debit</div>
                        <div class="val">
                            @if($item->debit > 0)
                                Rp {{ number_format($item->debit, 0, ',', '.') }}
                            @else
                                <span class="empty-val">—</span>
                            @endif
                        </div>
                    </div>
                    <div class="slip-amount-box credit">
                        <div class="lbl">Kredit</div>
                        <div class="val">
                            @if($item->credit > 0)
                                Rp {{ number_format($item->credit, 0, ',', '.') }}
                            @else
                                <span class="empty-val">—</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="slip-details">
                    <div class="slip-row">
                        <span class="label">
                            <svg class="icon"><use href="#ic-tag"/></svg>
                            Kode Akun
                        </span>
                        <span class="value mono">{{ $item->account_code }}</span>
                    </div>
                    <div class="slip-row">
                        <span class="label">
                            <svg class="icon"><use href="#ic-calendar"/></svg>
                            Tanggal Transaksi
                        </span>
                        <span class="value">{{ $item->transaction_date->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="slip-row">
                        <span class="label">
                            <svg class="icon"><use href="#ic-clock"/></svg>
                            Dibuat pada
                        </span>
                        <span class="value">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                    <div class="slip-row">
                        <span class="label">
                            <svg class="icon"><use href="#ic-clock"/></svg>
                            Terakhir diperbarui
                        </span>
                        <span class="value">{{ $item->updated_at->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                </div>

                {{-- ===== NOTES ===== --}}
                <div class="slip-notes">
                    <div class="notes-header">
                        <svg class="icon"><use href="#ic-file-text"/></svg>
                        <span>Catatan</span>
                    </div>
                    <div class="notes-body {{ $item->notes ? '' : 'empty' }}">
                        @if($item->notes)
                            {{ $item->notes }}
                        @else
                            <svg class="icon"><use href="#ic-file"/></svg>
                            Tidak ada catatan untuk transaksi ini
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
        <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></symbol>
        <symbol id="ic-calendar" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></symbol>
        <symbol id="ic-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></symbol>
        <symbol id="ic-tag" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></symbol>
        <symbol id="ic-file-text" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></symbol>
        <symbol id="ic-file" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></symbol>
        <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.ledger-btn').forEach(btn => {
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