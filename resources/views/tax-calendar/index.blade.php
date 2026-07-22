<x-app-layout>
    <x-slot name="title">Kalender Pajak</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        // DUMMY - ganti dengan query TaxCalendar model nanti
        $calendarEvents = $calendarEvents ?? [
            ['date' => '2026-07-15', 'title' => 'PPh Pasal 21', 'type' => 'pph', 'status' => 'upcoming', 'desc' => 'Laporan PPh 21 masa Juni 2026'],
            ['date' => '2026-07-20', 'title' => 'PPN Masa', 'type' => 'ppn', 'status' => 'upcoming', 'desc' => 'Laporan PPN masa Juni 2026'],
            ['date' => '2026-07-25', 'title' => 'PPh Pasal 23', 'type' => 'pph', 'status' => 'upcoming', 'desc' => 'Laporan PPh 23 masa Juni 2026'],
            ['date' => '2026-08-15', 'title' => 'PPh Pasal 21', 'type' => 'pph', 'status' => 'upcoming', 'desc' => 'Laporan PPh 21 masa Juli 2026'],
            ['date' => '2026-08-20', 'title' => 'PPN Masa', 'type' => 'ppn', 'status' => 'upcoming', 'desc' => 'Laporan PPN masa Juli 2026'],
            ['date' => '2026-08-25', 'title' => 'PPh Pasal 23', 'type' => 'pph', 'status' => 'upcoming', 'desc' => 'Laporan PPh 23 masa Juli 2026'],
        ];

        // PENTING: simpan index asli (posisi di session('calendar_events')) SEBELUM di-groupBy/sort,
        // supaya link Detail/Edit/Hapus selalu mengarah ke item yang benar.
        $calendarCollection = collect($calendarEvents)->map(function ($item, $key) {
            $item['_index'] = $key;
            return $item;
        });

        $currentMonth = now()->format('Y-m');

        // Kelompokkan berdasarkan bulan
        $eventsByMonth = $calendarCollection->groupBy(function($item) {
            return \Carbon\Carbon::parse($item['date'])->format('F Y');
        });

        $typeLabel = ['pph' => 'PPh', 'ppn' => 'PPN', 'other' => 'Lainnya'];
        $typeColor = ['pph' => 'var(--theme-primary)', 'ppn' => 'var(--warning)', 'other' => 'var(--text-tertiary)'];
        $statusLabel = ['upcoming' => 'Akan Datang', 'overdue' => 'Lewat Jatuh Tempo', 'done' => 'Selesai'];
        $statusPill = ['upcoming' => 'upcoming', 'overdue' => 'overdue', 'done' => 'done'];

        // Fungsi helper untuk format tanggal
        function formatTanggal($date) {
            if (empty($date)) return '-';
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return $date;
            }
        }
    @endphp

    <style>
        /* ============================================
           KALENDER PAJAK - Clean & Modern Design
           ============================================ */
        
        .cal-wrap {
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
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            max-width: 100%;
            padding: 0 24px;
        }

        .cal-wrap * { box-sizing: border-box; }
        .cal-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
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

        .cal-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .cal-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* SUCCESS MESSAGE */
        .cal-success {
            background: var(--success-soft);
            border: 1px solid var(--success);
            border-radius: var(--radius-sm);
            padding: 14px 20px;
            margin-bottom: 20px;
            color: var(--success);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cal-success .icon {
            width: 20px;
            height: 20px;
        }

        .cal-success .message {
            font-weight: 500;
        }

        /* HEADER */
        .cal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .cal-header-left { flex: 1; min-width: 200px; }

        .cal-badge {
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

        .cal-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .cal-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .cal-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cal-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .cal-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .cal-btn {
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

        .cal-btn .icon { width: 16px; height: 16px; }
        .cal-btn:hover { transform: translateY(-2px); }
        .cal-btn:active { transform: translateY(0) scale(0.97); }

        .cal-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .cal-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .cal-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cal-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .cal-btn .ripple {
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

        /* MONTHLY SECTION */
        .cal-month {
            margin-bottom: 24px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: border-color 0.22s ease;
        }

        .cal-month:hover { border-color: var(--border-hover); }
        .cal-month:last-child { margin-bottom: 0; }

        .cal-month-header {
            padding: 14px 20px;
            background: var(--bg-card-active);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cal-month-header .month {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .cal-month-header .count {
            font-size: 12px;
            color: var(--text-tertiary);
        }

        /* EVENT LIST */
        .cal-events { padding: 12px; }

        .cal-event {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 16px;
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .cal-event:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
        }

        .cal-event:last-child { margin-bottom: 0; }

        .cal-event .date-badge {
            min-width: 56px;
            text-align: center;
            padding: 4px 8px;
            background: var(--theme-soft);
            border-radius: var(--radius-sm);
        }

        .cal-event .date-badge .day {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            display: block;
        }

        .cal-event .date-badge .month {
            font-size: 10px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .cal-event .info {
            flex: 1;
            min-width: 0;
        }

        .cal-event .info .title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .cal-event .info .desc {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        .cal-event .tags {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .cal-event .tags .type {
            font-size: 10px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            background: var(--bg-card-active);
            color: var(--text-secondary);
        }

        .cal-event .tags .type.pph { background: var(--theme-soft); color: var(--theme-primary); }
        .cal-event .tags .type.ppn { background: var(--warning-soft); color: var(--warning); }

        .cal-event .tags .status {
            font-size: 10px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .cal-event .tags .status.upcoming {
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .cal-event .tags .status.overdue {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .cal-event .tags .status.done {
            background: var(--success-soft);
            color: var(--success);
        }

        /* ============================================
           ACTION BUTTONS - IMPROVED WITH COLORS
           ============================================ */
        .cal-actions-group {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .cal-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            background: var(--bg-card);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .cal-action-btn .icon {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        .cal-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .cal-action-btn:active {
            transform: translateY(0) scale(0.97);
        }

        /* Show / Detail Button - Emerald */
        .cal-action-btn.show {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
            color: var(--theme-primary);
        }

        .cal-action-btn.show:hover {
            background: var(--theme-primary);
            border-color: var(--theme-primary);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        /* Edit Button - Blue */
        .cal-action-btn.edit {
            background: rgba(59, 130, 246, 0.12);
            border-color: #3b82f6;
            color: #3b82f6;
        }

        [data-theme="dark"] .cal-action-btn.edit {
            background: rgba(59, 130, 246, 0.20);
            color: #60a5fa;
        }

        .cal-action-btn.edit:hover {
            background: #3b82f6;
            border-color: #3b82f6;
            color: #fff;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.35);
        }

        [data-theme="dark"] .cal-action-btn.edit:hover {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
        }

        /* Delete Button - Red */
        .cal-action-btn.delete {
            background: var(--danger-soft);
            border-color: var(--danger);
            color: var(--danger);
        }

        .cal-action-btn.delete:hover {
            background: var(--danger);
            border-color: var(--danger);
            color: #fff;
            box-shadow: 0 4px 16px rgba(232, 90, 90, 0.35);
        }

        /* Ripple effect for action buttons */
        .cal-action-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* EMPTY */
        .cal-empty {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-tertiary);
        }

        .cal-empty .icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 12px;
            color: var(--text-tertiary);
            opacity: 0.3;
        }

        .cal-empty p { font-size: 13px; }

        /* ----- MODAL DELETE ----- */
        .cal-modal-overlay {
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
        .cal-modal-overlay.active {
            display: flex;
        }
        .cal-modal-box {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.4);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }
        [data-theme="light"] .cal-modal-box {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
        }
        .cal-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            color: var(--danger);
            margin: 0 auto 16px;
            background: var(--danger-soft);
            border-radius: 50%;
            padding: 12px;
        }
        .cal-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        .cal-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            line-height: 1.6;
        }
        .cal-modal-box .cal-desc-text {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
        }
        .cal-modal-box .warning-text {
            font-size: 13px;
            color: var(--danger);
            font-weight: 500;
            margin-top: 12px;
            padding: 10px 16px;
            background: var(--danger-soft);
            border-radius: var(--radius-sm);
            display: inline-block;
        }
        .cal-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }
        .cal-modal-actions .btn {
            min-width: 100px;
            justify-content: center;
            padding: 10px 22px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .cal-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }
        .cal-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }
        .cal-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }
        .cal-modal-actions .btn-danger {
            background: var(--danger);
            color: #fff;
        }
        .cal-modal-actions .btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .cal-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .cal-wrap { padding: 0 12px; }
            .cal-event {
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .cal-event .date-badge {
                display: flex;
                align-items: center;
                gap: 8px;
                min-width: auto;
            }
            
            .cal-event .date-badge .day {
                display: inline;
                font-size: 16px;
            }
            
            .cal-event .tags {
                width: 100%;
                justify-content: flex-start;
            }
            
            .cal-actions-group {
                width: 100%;
                justify-content: flex-start;
                gap: 8px;
            }
            
            .cal-action-btn {
                padding: 5px 12px;
                font-size: 11px;
            }
            
            .cal-action-btn .icon {
                width: 13px;
                height: 13px;
            }
        }

        @media (max-width: 640px) {
            .cal-header { flex-direction: column; }
            .cal-actions { width: 100%; }
            .cal-actions .cal-btn { flex: 1; justify-content: center; font-size: 12px; padding: 8px 12px; }
        }

        @media (max-width: 380px) {
            .cal-wrap { padding: 0 8px; }
            .cal-header h1 { font-size: 22px; }
            .cal-btn { font-size: 11px; padding: 6px 10px; }
            .cal-btn .icon { width: 13px; height: 13px; }
            .cal-event { padding: 10px 12px; }
            .cal-event .info .title { font-size: 13px; }
            .cal-event .info .desc { font-size: 11px; }
            .cal-action-btn { font-size: 10px; padding: 3px 8px; }
            .cal-action-btn .icon { width: 11px; height: 11px; }
        }
    </style>

    <div class="cal-wrap">

        <!-- ===== HEADER ===== -->
        <div class="cal-header animate-in" style="animation-delay: 0.05s;">
            <div class="cal-header-left">
                <div class="cal-badge">
                    <span class="dot"></span>
                    Pajak
                </div>
                <h1>Kalender Pajak</h1>
                <p class="subtitle">
                    Jadwal pelaporan dan pembayaran pajak — 
                    <strong>{{ $calendarCollection->count() }}</strong> event terdaftar
                </p>
            </div>
            <div class="cal-actions">
                <a href="{{ route('taxes.pph') }}" class="cal-btn cal-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="10" width="20" height="14" rx="2"/>
                        <path d="M12 3L2 10h20L12 3z"/>
                        <line x1="8" y1="14" x2="8" y2="18"/>
                        <line x1="12" y1="14" x2="12" y2="18"/>
                        <line x1="16" y1="14" x2="16" y2="18"/>
                    </svg>
                    PPh
                </a>
                <a href="{{ route('taxes.ppn') }}" class="cal-btn cal-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                    PPN
                </a>
                <a href="{{ route('tax-calendar.create') }}" class="cal-btn cal-btn-primary">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Event
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="cal-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ===== MONTHLY EVENTS ===== -->
        @forelse($eventsByMonth as $month => $events)
            <div class="cal-month animate-in" style="animation-delay: {{ 0.10 + ($loop->index * 0.05) }}s;">
                <div class="cal-month-header">
                    <span class="month">{{ $month }}</span>
                    <span class="count">{{ $events->count() }} event</span>
                </div>
                <div class="cal-events">
                    @foreach($events->sortBy('date') as $event)
                        @php
                            $date = \Carbon\Carbon::parse($event['date']);
                            $isOverdue = $date->isPast() && $event['status'] != 'done';
                            // Pakai index asli dari session('calendar_events'), BUKAN index hasil groupBy/sort.
                            $itemId = $event['_index'];
                        @endphp
                        <div class="cal-event">
                            <div class="date-badge">
                                <span class="day">{{ $date->format('d') }}</span>
                                <span class="month">{{ $date->translatedFormat('M') }}</span>
                            </div>
                            <div class="info">
                                <div class="title">{{ $event['title'] }}</div>
                                <div class="desc">{{ $event['desc'] }}</div>
                            </div>
                            <div class="tags">
                                <span class="type {{ $event['type'] }}">{{ $typeLabel[$event['type']] }}</span>
                                <span class="status {{ $isOverdue ? 'overdue' : $statusPill[$event['status']] }}">
                                    {{ $isOverdue ? 'Lewat Jatuh Tempo' : $statusLabel[$event['status']] }}
                                </span>
                            </div>

                            <!-- ===== ACTION BUTTONS - IMPROVED WITH COLORS ===== -->
                            <div class="cal-actions-group">
                                <a href="{{ route('tax-calendar.show', $itemId) }}" class="cal-action-btn show">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    Detail
                                </a>
                                <a href="{{ route('tax-calendar.edit', $itemId) }}" class="cal-action-btn edit">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                        <path d="M15 5l4 4"/>
                                    </svg>
                                    Edit
                                </a>
                                <button type="button" class="cal-action-btn delete" onclick="openDeleteModal('{{ $itemId }}', '{{ addslashes($event['title']) }}')">
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
                    @endforeach
                </div>
            </div>
        @empty
            <div class="cal-month">
                <div class="cal-empty">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <p>Belum ada event kalender pajak.</p>
                    <a href="{{ route('tax-calendar.create') }}" class="cal-btn cal-btn-primary" style="display: inline-flex; margin-top: 12px;">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Tambah Event Pertama
                    </a>
                </div>
            </div>
        @endforelse

    </div>

    <!-- ===== MODAL DELETE ===== -->
    <div class="cal-modal-overlay" id="deleteModal">
        <div class="cal-modal-box">
            <svg class="icon-danger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <h3>Hapus Event Kalender?</h3>
            <p>
                Anda yakin ingin menghapus event
                <br>
                <span class="cal-desc-text" id="deleteDesc">-</span>
            </p>
            <div class="warning-text">
                Data yang dihapus tidak dapat dikembalikan!
            </div>
            <div class="cal-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
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
        // ===== DELETE MODAL =====
        function openDeleteModal(id, description) {
            document.getElementById('deleteDesc').textContent = description;
            var url = '/tax-calendar/delete/' + id;
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal on overlay click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // ===== RIPPLE EFFECT =====
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.cal-btn, .cal-action-btn');
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
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

</x-app-layout>