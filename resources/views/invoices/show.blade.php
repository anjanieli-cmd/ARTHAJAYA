<x-app-layout>
    <x-slot name="title">Faktur {{ $invoice->invoice ?? $invoice->invoice_number ?? 'Detail' }} — Arthajaya</x-slot>

    @php
        // Ambil data dari object dengan fallback
        $invoiceNumber = $invoice->invoice ?? $invoice->invoice_number ?? 'N/A';
        $clientName = $invoice->client ?? $invoice->client_name ?? 'Klien terhapus';
        $amount = $invoice->amount ?? $invoice->total ?? 0;
        $date = $invoice->date ?? $invoice->issue_date ?? now();
        $due = $invoice->due ?? $invoice->due_date ?? now();
        $status = $invoice->status ?? 'draft';
        $notes = $invoice->notes ?? '';
        $items = $invoice->items ?? [];
        $invoiceId = $invoice->id ?? 0;

        $statusMap = [
            'draft'     => ['label' => 'Draft', 'class' => 'draft'],
            'sent'      => ['label' => 'Terkirim', 'class' => 'sent'],
            'paid'      => ['label' => 'Lunas', 'class' => 'paid'],
            'overdue'   => ['label' => 'Jatuh Tempo', 'class' => 'overdue'],
            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'cancelled'],
        ];

        // Cek overdue
        $isOverdue = false;
        try {
            $dueDate = \Carbon\Carbon::parse($due);
            $isOverdue = $status === 'sent' && $dueDate->isPast();
        } catch (\Exception $e) {
            $isOverdue = false;
        }

        $st = $isOverdue ? ['label' => 'Jatuh Tempo', 'class' => 'overdue'] : ($statusMap[$status] ?? $statusMap['draft']);

        // Format tanggal
        function formatDate($date) {
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return $date;
            }
        }

        // Format currency
        function formatCurrency($amount) {
            return 'Rp' . number_format($amount, 0, ',', '.');
        }

        // Parse items jika berupa JSON string
        if (is_string($items)) {
            $items = json_decode($items, true) ?? [];
        }
        if (!is_array($items)) {
            $items = [];
        }
    @endphp

    <style>
        .invoice-show-wrap {
            --theme-primary: var(--emerald);
            --theme-soft: rgba(var(--emerald-rgb), 0.12);
            --danger-soft: rgba(232, 90, 122, 0.12);
            --info-soft: rgba(78, 143, 240, 0.12);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 16px 48px rgba(0, 0, 0, 0.4);
        }

        [data-theme="light"] .invoice-show-wrap {
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 16px 48px rgba(0, 0, 0, 0.12);
        }

        .invoice-show-wrap * {
            box-sizing: border-box;
        }

        /* ===== TOPBAR ===== */
        .inv-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .inv-topbar-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-mute);
        }
        .inv-topbar-title b {
            color: var(--text);
            font-weight: 600;
        }
        .inv-topbar-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* ===== CONTENT ===== */
        .inv-content {
            padding: 32px 40px 60px;
            max-width: 900px;
            margin: 0 auto;
        }

        /* ===== BUTTONS ===== */
        .inv-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
        }
        .inv-btn .icon {
            width: 16px;
            height: 16px;
        }
        .inv-btn-primary {
            background: var(--emerald);
            color: #052117;
        }
        .inv-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(var(--emerald-rgb), 0.35);
        }
        .inv-btn-outline {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text);
        }
        .inv-btn-outline:hover {
            background: var(--surface-strong);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }
        .inv-btn-danger {
            background: #E8637A;
            color: #fff;
        }
        .inv-btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 122, 0.35);
        }
        .inv-btn-sm {
            padding: 6px 14px;
            font-size: 12px;
        }

        /* ===== PAGE HEAD ===== */
        .inv-page-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 16px;
        }
        .inv-page-head-left h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }
        .inv-page-head-left p {
            font-size: 14px;
            color: var(--text-mute);
        }
        .inv-page-head-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* ===== INVOICE CARD ===== */
        .inv-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 36px 40px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }
        .inv-card:hover {
            border-color: var(--border-hover);
            box-shadow: var(--shadow-lg);
        }

        /* ===== STATUS BAR ===== */
        .inv-status-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }
        .inv-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 600;
        }
        .inv-status-badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        .inv-status-badge.draft {
            background: var(--surface-strong);
            color: var(--text-mute);
        }
        .inv-status-badge.draft .dot {
            background: var(--text-faint);
        }
        .inv-status-badge.sent {
            background: var(--info-soft);
            color: #4E8FF0;
        }
        .inv-status-badge.sent .dot {
            background: #4E8FF0;
        }
        .inv-status-badge.paid {
            background: var(--theme-soft);
            color: var(--emerald);
        }
        .inv-status-badge.paid .dot {
            background: var(--emerald);
        }
        .inv-status-badge.overdue {
            background: var(--danger-soft);
            color: #E8637A;
        }
        .inv-status-badge.overdue .dot {
            background: #E8637A;
            animation: pulse-red 1.5s ease-in-out infinite;
        }
        .inv-status-badge.cancelled {
            background: var(--surface-strong);
            color: var(--text-faint);
            text-decoration: line-through;
        }
        .inv-status-badge.cancelled .dot {
            background: var(--text-faint);
        }

        @keyframes pulse-red {
            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.5;
                transform: scale(0.9);
            }
        }

        /* ===== AMOUNT ===== */
        .inv-amount-section {
            margin-bottom: 28px;
        }
        .inv-amount-label {
            font-size: 13px;
            color: var(--text-mute);
            font-weight: 500;
        }
        .inv-amount-hero {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 42px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.03em;
            line-height: 1.1;
        }
        .inv-amount-hero .currency {
            font-size: 28px;
            color: var(--text-mute);
            font-weight: 500;
        }

        /* ===== DETAIL GRID ===== */
        .inv-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }
        .inv-detail-item .label {
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-faint);
            margin-bottom: 4px;
        }
        .inv-detail-item .value {
            font-size: 15px;
            font-weight: 500;
            color: var(--text);
        }
        .inv-detail-item .value.mono {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 500;
        }

        /* ===== ITEMS TABLE ===== */
        .inv-items-section {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }
        .inv-items-section .label {
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-faint);
            margin-bottom: 12px;
        }
        .inv-items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }
        .inv-items-table th {
            text-align: left;
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-faint);
            border-bottom: 1px solid var(--border);
        }
        .inv-items-table td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }
        .inv-items-table tbody tr:hover {
            background: var(--surface-hover);
        }
        .inv-items-table tbody tr:last-child td {
            border-bottom: none;
        }
        .inv-items-table .text-right {
            text-align: right;
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 500;
        }
        .inv-items-table .total-row {
            font-weight: 700;
            border-top: 2px solid var(--border);
        }
        .inv-items-table .total-row td {
            padding: 14px 14px 8px;
            font-size: 15px;
        }

        /* ===== NOTES ===== */
        .inv-notes-section {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }
        .inv-notes-section .label {
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-faint);
            margin-bottom: 8px;
        }
        .inv-notes-box {
            background: var(--surface-strong);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 20px;
            font-size: 14px;
            color: var(--text-mute);
            line-height: 1.7;
        }

        /* ===== MODAL ===== */
        .inv-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 0.3s ease;
        }
        .inv-modal-overlay.active {
            display: flex;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .inv-modal-box {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: var(--shadow-lg);
            animation: slideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }
        .inv-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            color: #E8637A;
            margin: 0 auto 16px;
            background: var(--danger-soft);
            border-radius: 50%;
            padding: 12px;
        }
        .inv-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }
        .inv-modal-box p {
            font-size: 14px;
            color: var(--text-mute);
            margin-bottom: 4px;
            line-height: 1.6;
        }
        .inv-modal-box .invoice-number {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            color: var(--text);
            background: var(--surface-strong);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
        }
        .inv-modal-box .warning-text {
            font-size: 13px;
            color: #E8637A;
            font-weight: 500;
            margin-top: 12px;
            padding: 10px 16px;
            background: var(--danger-soft);
            border-radius: 12px;
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
        }
        .inv-modal-actions .inv-btn-danger {
            background: #E8637A;
            color: #fff;
        }
        .inv-modal-actions .inv-btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 122, 0.4);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .inv-content {
                padding: 24px 20px 50px;
            }
            .inv-detail-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .inv-topbar {
                padding: 12px 16px;
                flex-wrap: wrap;
                gap: 8px;
            }
            .inv-topbar-title {
                font-size: 13px;
            }
            .inv-content {
                padding: 16px 14px 40px;
            }
            .inv-page-head {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            .inv-page-head-left h1 {
                font-size: 22px;
            }
            .inv-page-head-actions {
                width: 100%;
            }
            .inv-page-head-actions .inv-btn {
                flex: 1;
                justify-content: center;
            }
            .inv-card {
                padding: 20px 16px;
                border-radius: 16px;
            }
            .inv-amount-hero {
                font-size: 30px;
            }
            .inv-amount-hero .currency {
                font-size: 20px;
            }
            .inv-detail-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            .inv-detail-item .value {
                font-size: 14px;
            }
            .inv-status-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            .inv-items-table {
                font-size: 12px;
            }
            .inv-items-table th,
            .inv-items-table td {
                padding: 8px 10px;
            }
            .inv-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }
            .inv-modal-actions {
                flex-direction: column;
            }
            .inv-modal-actions .inv-btn {
                width: 100%;
            }
        }

        @media (max-width: 380px) {
            .inv-card {
                padding: 16px 12px;
            }
            .inv-amount-hero {
                font-size: 24px;
            }
            .inv-btn {
                font-size: 12px;
                padding: 8px 14px;
            }
        }
    </style>

    <div class="invoice-show-wrap">
        <!-- Topbar -->
        <div class="inv-topbar">
            <div class="inv-topbar-title">
                Penjualan / <a href="{{ route('invoices.index') }}" style="color:var(--text-mute);">Semua Faktur</a> / <b>{{ $invoiceNumber }}</b>
            </div>
            <div class="inv-topbar-actions">
                <a href="{{ route('invoices.index') }}" class="inv-btn inv-btn-outline inv-btn-sm">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5"/>
                        <path d="M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="inv-content">
            <!-- Page Head -->
            <div class="inv-page-head">
                <div class="inv-page-head-left">
                    <h1>Faktur {{ $invoiceNumber }}</h1>
                    <p>Dibuat untuk <strong>{{ $clientName }}</strong></p>
                </div>
                <div class="inv-page-head-actions">
                    <a href="{{ route('invoices.edit', $invoiceId) }}" class="inv-btn inv-btn-primary">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                            <path d="M15 5l4 4"/>
                        </svg>
                        Edit Faktur
                    </a>
                    <button type="button" class="inv-btn inv-btn-danger" onclick="openDeleteModal()">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"/>
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/>
                            <path d="M14 11v6"/>
                        </svg>
                        Hapus
                    </button>
                </div>
            </div>

            <!-- Invoice Card -->
            <div class="inv-card">
                <!-- Status Bar -->
                <div class="inv-status-bar">
                    <span class="inv-status-badge {{ $st['class'] }}">
                        <span class="dot"></span>
                        {{ $st['label'] }}
                    </span>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        @if($status === 'sent' && !$isOverdue)
                            <span class="inv-btn inv-btn-outline inv-btn-sm" style="cursor:default;background:var(--theme-soft);border-color:var(--emerald);color:var(--emerald);">
                                <span class="dot" style="display:inline-block;width:6px;height:6px;border-radius:50%;background:var(--emerald);"></span>
                                Belum Jatuh Tempo
                            </span>
                        @endif
                        @if($isOverdue)
                            <span class="inv-btn inv-btn-outline inv-btn-sm" style="cursor:default;background:var(--danger-soft);border-color:#E8637A;color:#E8637A;">
                                <span class="dot" style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#E8637A;animation:pulse-red 1.5s ease-in-out infinite;"></span>
                                Lewat Jatuh Tempo!
                            </span>
                        @endif
                        @if($status === 'paid')
                            <span class="inv-btn inv-btn-outline inv-btn-sm" style="cursor:default;background:var(--theme-soft);border-color:var(--emerald);color:var(--emerald);">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Lunas
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Amount -->
                <div class="inv-amount-section">
                    <div class="inv-amount-label">Total Tagihan</div>
                    <div class="inv-amount-hero">
                        <span class="currency">Rp</span> {{ number_format($amount, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Detail Grid -->
                <div class="inv-detail-grid">
                    <div class="inv-detail-item">
                        <div class="label">Klien</div>
                        <div class="value">{{ $clientName }}</div>
                    </div>
                    <div class="inv-detail-item">
                        <div class="label">Nomor Faktur</div>
                        <div class="value mono">{{ $invoiceNumber }}</div>
                    </div>
                    <div class="inv-detail-item">
                        <div class="label">Status</div>
                        <div class="value">
                            <span class="inv-status-badge {{ $st['class'] }}" style="padding:2px 12px;font-size:12px;">
                                <span class="dot" style="width:6px;height:6px;"></span>
                                {{ $st['label'] }}
                            </span>
                        </div>
                    </div>
                    <div class="inv-detail-item">
                        <div class="label">Tanggal Terbit</div>
                        <div class="value">{{ formatDate($date) }}</div>
                    </div>
                    <div class="inv-detail-item">
                        <div class="label">Jatuh Tempo</div>
                        <div class="value {{ $isOverdue ? 'overdue' : '' }}" style="{{ $isOverdue ? 'color:#E8637A;' : '' }}">
                            {{ formatDate($due) }}
                            @if($isOverdue)
                                <span style="display:block;font-size:12px;color:#E8637A;font-weight:600;">⚠️ Lewat {{ \Carbon\Carbon::parse($due)->diffInDays(now()) }} hari</span>
                            @endif
                        </div>
                    </div>
                    <div class="inv-detail-item">
                        <div class="label">Jumlah Item</div>
                        <div class="value">{{ count($items) > 0 ? count($items) : '0' }} item</div>
                    </div>
                </div>

                <!-- Items Table -->
                @if(count($items) > 0)
                <div class="inv-items-section">
                    <div class="label">Rincian Item</div>
                    <table class="inv-items-table">
                        <thead>
                            <tr>
                                <th style="width:60%;">Deskripsi</th>
                                <th style="text-align:right;">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $name => $price)
                                @if(is_numeric($price))
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td class="text-right">{{ formatCurrency($price) }}</td>
                                </tr>
                                @endif
                            @endforeach
                            <tr class="total-row">
                                <td><strong>Total</strong></td>
                                <td class="text-right" style="font-size:16px;">{{ formatCurrency($amount) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif

                <!-- Notes -->
                @if($notes)
                <div class="inv-notes-section">
                    <div class="label">Catatan</div>
                    <div class="inv-notes-box">{{ $notes }}</div>
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:20px;justify-content:flex-end;">
                <a href="{{ route('invoices.index') }}" class="inv-btn inv-btn-outline">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5"/>
                        <path d="M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <!-- ===== MODAL DELETE ===== -->
    <div class="inv-modal-overlay" id="deleteModal">
        <div class="inv-modal-box">
            <svg class="icon-danger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <h3>Hapus Faktur?</h3>
            <p>
                Anda yakin ingin menghapus faktur
                <br>
                <span class="invoice-number">{{ $invoiceNumber }}</span>
            </p>
            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>
            <div class="inv-modal-actions">
                <button type="button" class="inv-btn inv-btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form action="{{ route('invoices.destroy', $invoiceId) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inv-btn inv-btn-danger">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                            <path d="M3 6h18"/>
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/>
                            <path d="M14 11v6"/>
                        </svg>
                        Ya, Hapus!
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal when clicking outside
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