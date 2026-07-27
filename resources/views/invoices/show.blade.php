<x-app-layout>
    <x-slot name="title">Faktur {{ $invoice->invoice_number }}</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    @endphp

    <style>
        .inv-detail {
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
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .inv-detail * { box-sizing: border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .inv-detail .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .inv-detail .icon {
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
        .inv-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .inv-header-left { flex: 1; min-width: 200px; }

        .inv-badge {
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

        .inv-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .inv-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .inv-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .inv-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .inv-header .subtitle .highlight {
            color: var(--theme-primary);
            font-weight: 600;
        }

        .inv-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        /* ===== BUTTONS ===== */
        .inv-btn {
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

        .inv-btn .icon {
            width: 16px;
            height: 16px;
        }

        .inv-btn:hover {
            transform: translateY(-2px);
        }

        .inv-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .inv-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .inv-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            color: #fff;
        }

        .inv-btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .inv-btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .inv-btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .inv-btn-danger:hover {
            background: #d14a4a;
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
        }

        .inv-btn-ghost-danger {
            background: transparent;
            border: 1px solid rgba(var(--danger-rgb), 0.3);
            color: var(--danger);
        }

        .inv-btn-ghost-danger:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
        }

        .inv-btn .ripple {
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

        /* ===== DETAIL CARD - FULL WIDTH ===== */
        .inv-detail-card {
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        }

        .inv-detail-card:hover {
            border-color: var(--border-hover);
        }

        .inv-detail-banner {
            padding: 40px 48px;
            text-align: center;
            position: relative;
        }

        .inv-detail-banner::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .inv-detail-banner.paid {
            background: var(--success-soft);
        }

        .inv-detail-banner.paid::after {
            background: var(--success);
        }

        .inv-detail-banner.sent {
            background: var(--theme-soft);
        }

        .inv-detail-banner.sent::after {
            background: var(--theme-primary);
        }

        .inv-detail-banner.draft {
            background: var(--bg-card-active);
        }

        .inv-detail-banner.draft::after {
            background: var(--text-tertiary);
        }

        .inv-detail-banner.overdue {
            background: var(--danger-soft);
        }

        .inv-detail-banner.overdue::after {
            background: var(--danger);
        }

        .inv-detail-banner.cancelled {
            background: var(--bg-card-active);
        }

        .inv-detail-banner.cancelled::after {
            background: var(--text-tertiary);
        }

        .inv-type-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 10px;
            padding: 6px 18px;
            border-radius: 100px;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(4px);
        }

        .inv-type-label .icon {
            width: 14px;
            height: 14px;
        }

        .inv-detail-banner.paid .inv-type-label {
            color: var(--success);
        }

        .inv-detail-banner.sent .inv-type-label {
            color: var(--theme-primary);
        }

        .inv-detail-banner.draft .inv-type-label {
            color: var(--text-tertiary);
        }

        .inv-detail-banner.overdue .inv-type-label {
            color: var(--danger);
        }

        .inv-detail-banner.cancelled .inv-type-label {
            color: var(--text-tertiary);
        }

        .inv-detail-amount {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            font-size: 42px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .inv-detail-banner.paid .inv-detail-amount {
            color: var(--success);
        }

        .inv-detail-banner.sent .inv-detail-amount {
            color: var(--theme-primary);
        }

        .inv-detail-banner.draft .inv-detail-amount {
            color: var(--text-secondary);
        }

        .inv-detail-banner.overdue .inv-detail-amount {
            color: var(--danger);
        }

        .inv-detail-banner.cancelled .inv-detail-amount {
            color: var(--text-tertiary);
        }

        .inv-detail-body {
            padding: 32px 48px 48px;
        }

        .inv-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 48px;
        }

        .inv-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-color);
            gap: 16px;
            transition: background 0.15s ease;
        }

        .inv-detail-row:hover {
            background: var(--bg-card-active);
            margin: 0 -8px;
            padding: 14px 8px;
            border-radius: 8px;
        }

        .inv-detail-row:last-child {
            border-bottom: none;
        }

        .inv-detail-row .inv-label {
            font-size: 13px;
            color: var(--text-tertiary);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .inv-detail-row .inv-label .icon {
            width: 16px;
            height: 16px;
            color: var(--text-tertiary);
        }

        .inv-detail-row .inv-value {
            font-size: 14px;
            font-weight: 600;
            text-align: right;
            color: var(--text-primary);
            word-break: break-word;
        }

        .inv-detail-row .inv-value .mono {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 500;
        }

        .inv-detail-row .inv-value.total {
            font-size: 18px;
            color: var(--theme-primary);
        }

        .inv-detail-row.full-width {
            grid-column: 1 / -1;
        }

        .inv-notes-box {
            grid-column: 1 / -1;
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            font-size: 13.5px;
            color: var(--text-secondary);
            margin-top: 8px;
            line-height: 1.6;
        }

        .inv-notes-box .label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-tertiary);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ===== STATUS BADGE ===== */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-badge.draft {
            background: var(--bg-card-active);
            color: var(--text-tertiary);
        }
        .status-badge.draft .dot {
            background: var(--text-tertiary);
        }

        .status-badge.sent {
            background: var(--theme-soft);
            color: var(--theme-primary);
        }
        .status-badge.sent .dot {
            background: var(--theme-primary);
        }

        .status-badge.paid {
            background: var(--success-soft);
            color: var(--success);
        }
        .status-badge.paid .dot {
            background: var(--success);
        }

        .status-badge.overdue {
            background: var(--danger-soft);
            color: var(--danger);
        }
        .status-badge.overdue .dot {
            background: var(--danger);
            animation: pulseGlow 1.6s ease-in-out infinite;
        }

        .status-badge.cancelled {
            background: var(--bg-card-active);
            color: var(--text-tertiary);
            text-decoration: line-through;
        }
        .status-badge.cancelled .dot {
            background: var(--text-tertiary);
        }

        /* ===== MODAL DELETE ===== */
        .inv-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: modalFadeIn 0.3s ease;
        }

        .inv-modal-overlay.active {
            display: flex;
        }

        .inv-modal-box {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.4);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
            position: relative;
        }

        [data-theme="light"] .inv-modal-box {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
        }

        .inv-modal-box .modal-icon {
            width: 56px;
            height: 56px;
            color: var(--danger);
            margin: 0 auto 16px;
            background: var(--danger-soft);
            border-radius: 50%;
            padding: 12px;
        }

        .inv-modal-box .modal-icon .icon {
            width: 28px;
            height: 28px;
        }

        .inv-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .inv-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            line-height: 1.6;
        }

        .inv-modal-box .item-name {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
            margin-top: 4px;
        }

        .inv-modal-box .warning-text {
            font-size: 13px;
            color: var(--danger);
            font-weight: 500;
            margin-top: 12px;
            padding: 10px 16px;
            background: var(--danger-soft);
            border-radius: var(--radius-sm);
            display: inline-block;
        }

        .inv-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .inv-modal-actions .inv-btn {
            min-width: 100px;
            justify-content: center;
            padding: 10px 22px;
            font-size: 13px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .inv-detail-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .inv-detail-row.full-width {
                grid-column: 1;
            }
            .inv-notes-box {
                grid-column: 1;
            }
        }

        @media (max-width: 768px) {
            .inv-detail { padding: 0 16px; }
            .inv-header { flex-direction: column; }
            .inv-header-actions { width: 100%; }
            .inv-header-actions .inv-btn { flex: 1; justify-content: center; }
            .inv-detail-banner { padding: 24px 20px; }
            .inv-detail-body { padding: 20px 20px 24px; }
            .inv-detail-amount { font-size: 28px; }
            .inv-modal-box { padding: 24px 20px; }
            .inv-detail-row:hover {
                margin: 0;
                padding: 14px 0;
            }
            .inv-detail-grid {
                gap: 0;
            }
        }

        @media (max-width: 480px) {
            .inv-header h1 { font-size: 22px; }
            .inv-detail-amount { font-size: 24px; }
            .inv-detail-row { 
                flex-direction: column; 
                align-items: flex-start;
                gap: 4px;
                padding: 12px 0;
            }
            .inv-detail-row .inv-value { text-align: left; width: 100%; }
            .inv-modal-actions { flex-direction: column; }
            .inv-modal-actions .inv-btn { width: 100%; }
            .inv-detail-banner { padding: 20px 16px; }
            .inv-detail-body { padding: 16px; }
        }
    </style>

    @php
        $statusMap = [
            'draft'     => ['label' => 'Draft', 'class' => 'draft', 'icon' => 'ic-file-text'],
            'sent'      => ['label' => 'Terkirim', 'class' => 'sent', 'icon' => 'ic-send'],
            'paid'      => ['label' => 'Lunas', 'class' => 'paid', 'icon' => 'ic-check-circle'],
            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'cancelled', 'icon' => 'ic-alert-triangle'],
        ];
        $isOverdue = $invoice->status === 'sent' && $invoice->due_date && $invoice->due_date->isPast();
        $statusKey = $isOverdue ? 'overdue' : $invoice->status;
        $st = [
            'label' => $isOverdue ? 'Jatuh Tempo' : ($statusMap[$invoice->status]['label'] ?? 'Draft'),
            'class' => $isOverdue ? 'overdue' : ($statusMap[$invoice->status]['class'] ?? 'draft'),
            'icon' => $isOverdue ? 'ic-alert-triangle' : ($statusMap[$invoice->status]['icon'] ?? 'ic-file-text')
        ];
        $canEdit = $invoice->status === 'draft';
        $canDelete = in_array($invoice->status, ['draft', 'cancelled']);
    @endphp

    <div class="inv-detail">

        <!-- ===== HEADER ===== -->
        <div class="inv-header animate-in" style="animation-delay: 0.05s;">
            <div class="inv-header-left">
                <div class="inv-badge">
                    <span class="dot"></span>
                    Detail Data
                </div>
                <h1>Faktur {{ $invoice->invoice_number }}</h1>
                <p class="subtitle">
                    Detail faktur untuk <strong>{{ $invoice->client->name ?? 'klien terhapus' }}</strong>
                    @if($invoice->client->company_name ?? null)
                        · {{ $invoice->client->company_name }}
                    @endif
                    — periode <span class="highlight">{{ $invoice->created_at->translatedFormat('F Y') }}</span>
                </p>
            </div>
            <div class="inv-header-actions">
                <a href="{{ route('invoices.index') }}" class="inv-btn inv-btn-outline">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
                @if($canEdit)
                    <a href="{{ route('invoices.edit', $invoice) }}" class="inv-btn inv-btn-primary">
                        <svg class="icon"><use href="#ic-edit"/></svg>
                        Edit
                    </a>
                @endif
                @if($canDelete)
                    <button type="button" class="inv-btn inv-btn-ghost-danger" onclick="openDeleteModal()">
                        <svg class="icon"><use href="#ic-trash"/></svg>
                        Hapus
                    </button>
                @endif
            </div>
        </div>

        <!-- ===== DETAIL CARD - FULL WIDTH ===== -->
        <div class="inv-detail-card animate-in" style="animation-delay: 0.10s;">
            <!-- Banner -->
            <div class="inv-detail-banner {{ $st['class'] }}">
                <div class="inv-type-label">
                    <svg class="icon"><use href="#{{ $st['icon'] }}"/></svg>
                    {{ $st['label'] }}
                </div>
                <div class="inv-detail-amount">
                    {{ $currencySymbol }}{{ number_format($invoice->total ?? 0, 0, ',', '.') }}
                </div>
            </div>

            <!-- Body -->
            <div class="inv-detail-body">
                <div class="inv-detail-grid">
                    <div class="inv-detail-row">
                        <span class="inv-label">
                            <svg class="icon"><use href="#ic-hash"/></svg>
                            Nomor Faktur
                        </span>
                        <span class="inv-value">{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="inv-detail-row">
                        <span class="inv-label">
                            <svg class="icon"><use href="#ic-user"/></svg>
                            Klien
                        </span>
                        <span class="inv-value">{{ $invoice->client->name ?? '—' }}</span>
                    </div>
                    <div class="inv-detail-row">
                        <span class="inv-label">
                            <svg class="icon"><use href="#ic-building"/></svg>
                            Perusahaan
                        </span>
                        <span class="inv-value">{{ $invoice->client->company_name ?? '—' }}</span>
                    </div>
                    <div class="inv-detail-row">
                        <span class="inv-label">
                            <svg class="icon"><use href="#ic-calendar"/></svg>
                            Tanggal Terbit
                        </span>
                        <span class="inv-value">{{ $invoice->issue_date ? $invoice->issue_date->translatedFormat('d F Y') : '—' }}</span>
                    </div>
                    <div class="inv-detail-row">
                        <span class="inv-label">
                            <svg class="icon"><use href="#ic-clock"/></svg>
                            Jatuh Tempo
                        </span>
                        <span class="inv-value">{{ $invoice->due_date ? $invoice->due_date->translatedFormat('d F Y') : '—' }}</span>
                    </div>
                    <div class="inv-detail-row">
                        <span class="inv-label">
                            <svg class="icon"><use href="#ic-rupiah"/></svg>
                            Subtotal
                        </span>
                        <span class="inv-value mono">{{ $currencySymbol }}{{ number_format($invoice->subtotal ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="inv-detail-row">
                        <span class="inv-label">
                            <svg class="icon"><use href="#ic-file-text"/></svg>
                            Pajak
                        </span>
                        <span class="inv-value mono">{{ $currencySymbol }}{{ number_format($invoice->tax ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="inv-detail-row" style="border-bottom: 2px solid var(--border-color); padding-bottom: 18px;">
                        <span class="inv-label" style="font-weight: 600; color: var(--text-primary);">
                            <svg class="icon" style="color: var(--theme-primary);"><use href="#ic-rupiah"/></svg>
                            Total
                        </span>
                        <span class="inv-value total mono">{{ $currencySymbol }}{{ number_format($invoice->total ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="inv-detail-row">
                        <span class="inv-label">
                            <svg class="icon"><use href="#ic-activity"/></svg>
                            Status
                        </span>
                        <span class="inv-value">
                            <span class="status-badge {{ $st['class'] }}">
                                <span class="dot"></span>
                                {{ $st['label'] }}
                            </span>
                        </span>
                    </div>
                    <div class="inv-detail-row">
                        <span class="inv-label">
                            <svg class="icon"><use href="#ic-clock"/></svg>
                            Dibuat pada
                        </span>
                        <span class="inv-value">{{ $invoice->created_at->translatedFormat('d F Y, H:i') }}</span>
                    </div>
                    <div class="inv-detail-row">
                        <span class="inv-label">
                            <svg class="icon"><use href="#ic-refresh"/></svg>
                            Terakhir diupdate
                        </span>
                        <span class="inv-value">{{ $invoice->updated_at->translatedFormat('d F Y, H:i') }}</span>
                    </div>

                    @if($invoice->notes)
                        <div class="inv-notes-box">
                            <div class="label">
                                <svg class="icon" style="width:16px;height:16px;"><use href="#ic-file-text"/></svg>
                                Catatan
                            </div>
                            {{ $invoice->notes }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- ===== MODAL DELETE ===== -->
    <div class="inv-modal-overlay" id="deleteModal">
        <div class="inv-modal-box">
            <div class="modal-icon">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
            </div>
            <h3>Hapus Faktur Ini?</h3>
            <p>
                Anda yakin ingin menghapus faktur
                <br>
                <span class="item-name">"{{ $invoice->invoice_number }}"</span>
            </p>
            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>
            <div class="inv-modal-actions">
                <button type="button" class="inv-btn inv-btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form id="deleteForm" method="POST" action="{{ route('invoices.destroy', $invoice) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inv-btn inv-btn-danger">
                        <svg class="icon"><use href="#ic-trash"/></svg>
                        Ya, Hapus!
                    </button>
                </form>
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
        <symbol id="ic-trash" viewBox="0 0 24 24">
            <polyline points="3 6 5 6 21 6"/>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
        </symbol>
        <symbol id="ic-alert-triangle" viewBox="0 0 24 24">
            <path d="M12 9v4"/>
            <path d="M12 17h.01"/>
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
        </symbol>
        <symbol id="ic-file-text" viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
        </symbol>
        <symbol id="ic-send" viewBox="0 0 24 24">
            <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
        </symbol>
        <symbol id="ic-check-circle" viewBox="0 0 24 24">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </symbol>
        <symbol id="ic-hash" viewBox="0 0 24 24">
            <line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/>
        </symbol>
        <symbol id="ic-user" viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
        </symbol>
        <symbol id="ic-building" viewBox="0 0 24 24">
            <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="9" y1="22" x2="9" y2="18"/><line x1="15" y1="22" x2="15" y2="18"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="16" y2="10"/><line x1="8" y1="14" x2="12" y2="14"/>
        </symbol>
        <symbol id="ic-calendar" viewBox="0 0 24 24">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
        </symbol>
        <symbol id="ic-clock" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </symbol>
        <symbol id="ic-rupiah" viewBox="0 0 24 24">
            <text x="2" y="18" font-size="18" font-weight="bold" font-family="Arial">Rp</text>
        </symbol>
        <symbol id="ic-activity" viewBox="0 0 24 24">
            <polyline points="3 12 8 12 10 6 14 18 16 12 21 12"/>
        </symbol>
        <symbol id="ic-refresh" viewBox="0 0 24 24">
            <path d="M21 12a9 9 0 1 1-3-6.7"/><polyline points="21 3 21 9 15 9"/>
        </symbol>
    </svg>

    <script>
        // ===== RIPPLE EFFECT =====
        document.querySelectorAll('.inv-btn').forEach(btn => {
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

        // ===== DELETE MODAL =====
        function openDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            document.body.classList.add('aj-modal-open');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
            document.body.classList.remove('aj-modal-open');
        }

        // Close modal when clicking overlay
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>

</x-app-layout>