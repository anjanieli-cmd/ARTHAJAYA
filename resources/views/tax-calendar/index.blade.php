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

        $calendarCollection = collect($calendarEvents)->map(function ($item, $key) {
            $item['_index'] = $key;
            return $item;
        });

        $currentMonth = now()->format('Y-m');

        $eventsByMonth = $calendarCollection->groupBy(function($item) {
            return \Carbon\Carbon::parse($item['date'])->format('F Y');
        });

        $typeLabel = ['pph' => 'PPh', 'ppn' => 'PPN', 'other' => 'Lainnya'];
        $typeColor = ['pph' => 'var(--theme-primary)', 'ppn' => 'var(--warning)', 'other' => 'var(--text-tertiary)'];
        $statusLabel = ['upcoming' => 'Akan Datang', 'overdue' => 'Lewat Jatuh Tempo', 'done' => 'Selesai'];
        $statusPill = ['upcoming' => 'upcoming', 'overdue' => 'overdue', 'done' => 'done'];

        function formatTanggal($date) {
            if (empty($date)) return '-';
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return $date;
            }
        }
    @endphp

    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </symbol>
            <symbol id="ic-bank" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="10" width="20" height="14" rx="2"/><path d="M12 3L2 10h20L12 3z"/><line x1="8" y1="14" x2="8" y2="18"/><line x1="12" y1="14" x2="12" y2="18"/><line x1="16" y1="14" x2="16" y2="18"/>
            </symbol>
        </defs>
    </svg>

    <style>
        /* ============================================
           KALENDER PAJAK - Clean & Modern Design
           ============================================ */
        
        .cal-modern {
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
            
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .cal-modern * {
            box-sizing: border-box;
        }

        .cal-modern .mono {
            font-family: 'IBM Plex Mono', monospace;
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.02em;
        }

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

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .cal-modern .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .cal-modern .icon {
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

        /* ===== TOAST ===== */
        .toast-container{
            position:fixed; top:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:10px; max-width:380px; width:100%;
        }
        .toast{
            background:var(--modal-bg); border:1px solid var(--border); border-radius:var(--radius-md); padding:16px 20px;
            box-shadow:0 20px 60px rgba(0,0,0,0.5); animation:fadeSlideUp .35s cubic-bezier(.16,1,.3,1);
            display:flex; align-items:center; gap:12px; backdrop-filter:blur(12px);
        }
        .toast .toast-icon{ width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .toast .toast-icon.success{ background:var(--success-soft); color:var(--success); }
        .toast .toast-icon.error{ background:var(--danger-soft); color:var(--danger); }
        .toast .toast-icon .icon{ width:18px; height:18px; }
        .toast .toast-content{ flex:1; }
        .toast .toast-title{ font-size:13px; font-weight:600; color:var(--text); }
        .toast .toast-msg{ font-size:12px; color:var(--text-mute); }
        .toast .toast-close{ background:none; border:none; color:var(--text-faint); cursor:pointer; padding:4px; }
        .toast .toast-close .icon{ width:14px; height:14px; }

        /* ===== SUCCESS MESSAGE ===== */
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

        /* ===== HEADER ===== */
        .cal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .cal-header-left {
            flex: 1;
            min-width: 200px;
        }

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

        .cal-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .cal-header-actions {
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
            font-family: 'Inter', sans-serif;
        }

        .cal-btn .icon {
            width: 16px;
            height: 16px;
        }

        .cal-btn:hover {
            transform: translateY(-2px);
        }

        .cal-btn:active {
            transform: translateY(0) scale(0.97);
        }

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

        /* ===== FILTER BAR ===== */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 12px 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .filter-bar:focus-within {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .filter-bar form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 220px;
        }

        .search-wrap .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--text-tertiary);
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .search-wrap:focus-within .icon {
            color: var(--theme-primary);
        }

        .filter-bar input[type="text"] {
            width: 100%;
            padding: 10px 16px 10px 42px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid transparent;
            color: var(--text-primary);
            font-size: 13px;
            outline: none;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .filter-bar input[type="text"]:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .filter-bar input[type="text"]::placeholder {
            color: var(--text-tertiary);
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .filter-actions .cal-btn {
            padding: 8px 14px;
            font-size: 12px;
        }

        .search-indicator {
            font-size: 12px;
            color: var(--text-tertiary);
            padding: 4px 12px;
            background: var(--bg-card-active);
            border-radius: 20px;
            white-space: nowrap;
            display: none;
            align-items: center;
            gap: 6px;
        }

        .search-indicator.active {
            display: inline-flex;
        }

        .search-indicator .count {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* ===== MONTHLY SECTION ===== */
        .cal-month {
            margin-bottom: 24px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .cal-month:hover {
            border-color: var(--border-hover);
        }
        .cal-month:last-child {
            margin-bottom: 0;
        }

        .cal-month.hidden-month {
            display: none;
        }

        .cal-month.visible-month {
            display: block;
            animation: fadeSlideUp 0.3s ease forwards;
        }

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

        /* ===== EVENT LIST ===== */
        .cal-events {
            padding: 12px;
        }

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

        .cal-event:last-child {
            margin-bottom: 0;
        }

        .cal-event.hidden-event {
            display: none;
        }

        .cal-event.visible-event {
            display: flex;
            animation: fadeSlideUp 0.3s ease forwards;
        }

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

        .cal-event .tags .type.pph {
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .cal-event .tags .type.ppn {
            background: var(--warning-soft);
            color: var(--warning);
        }

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

        /* ===== ACTION BUTTONS (Edit, Show, Delete) ===== */
        .cal-event-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .cal-event-actions .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid transparent;
            background: transparent;
            color: var(--text-tertiary);
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .cal-event-actions .action-btn .icon {
            width: 16px;
            height: 16px;
        }

        .cal-event-actions .action-btn:hover {
            transform: translateY(-1px);
        }

        .cal-event-actions .action-btn.show-btn:hover {
            background: var(--theme-soft);
            color: var(--theme-primary);
            border-color: var(--theme-glow);
        }

        .cal-event-actions .action-btn.edit-btn:hover {
            background: rgba(59, 130, 246, 0.12);
            color: #3b82f6;
            border-color: rgba(59, 130, 246, 0.2);
        }

        .cal-event-actions .action-btn.delete-btn:hover {
            background: var(--danger-soft);
            color: var(--danger);
            border-color: var(--danger-soft);
        }

        /* ===== EMPTY ===== */
        .cal-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-tertiary);
        }

        .cal-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .cal-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .cal-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        /* ============================================================
           MODAL DELETE
           ============================================================ */
        .cal-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: modalFadeIn 0.3s ease;
        }

        .cal-modal-overlay.active {
            display: flex;
        }

        [data-theme="dark"] .cal-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .cal-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .cal-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .cal-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .cal-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .cal-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .cal-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .cal-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .cal-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .cal-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .cal-modal-box .cal-desc-text {
            font-weight: 700;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 4px 14px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 4px;
            font-size: 15px;
        }

        .cal-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .cal-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
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
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
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
            background: #DC2626;
            color: #fff;
        }

        .cal-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .cal-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .cal-modal-actions .btn-danger:hover {
            background: #B91C1C;
        }

        /* CSS UNTUK NAVBAR TIDAK KE-BLUR */
        body.aj-modal-open main {
            position: relative;
            z-index: 9998;
        }

        body.aj-modal-open .sidebar,
        body.aj-modal-open .topbar {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        body.aj-modal-open .sidebar *,
        body.aj-modal-open .topbar * {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .cal-modern {
                padding: 0 16px;
            }
        }

        @media (max-width: 768px) {
            .cal-modern {
                padding: 0 12px;
            }
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

            .cal-event-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                padding: 12px 16px;
            }
            .filter-bar form {
                flex-direction: column;
            }
            .search-wrap {
                min-width: 100%;
            }
            .filter-actions {
                width: 100%;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

            .cal-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }
            .cal-modal-actions {
                flex-direction: column;
            }
            .cal-modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .cal-header {
                flex-direction: column;
            }
            .cal-header-actions {
                width: 100%;
            }
            .cal-header-actions .cal-btn {
                flex: 1;
                justify-content: center;
                font-size: 12px;
                padding: 8px 12px;
            }
            .cal-modal-box {
                padding: 20px 16px;
            }
            .cal-modal-box h3 {
                font-size: 18px;
            }
            .cal-modal-box .icon-danger {
                width: 48px;
                height: 48px;
            }
            .cal-modal-box .icon-danger svg {
                width: 24px;
                height: 24px;
            }
            .cal-event-actions .action-btn {
                width: 28px;
                height: 28px;
            }
            .cal-event-actions .action-btn .icon {
                width: 14px;
                height: 14px;
            }
        }

        @media (max-width: 380px) {
            .cal-modern {
                padding: 0 8px;
            }
            .cal-header h1 {
                font-size: 22px;
            }
            .cal-btn {
                font-size: 11px;
                padding: 6px 10px;
            }
            .cal-btn .icon {
                width: 13px;
                height: 13px;
            }
            .cal-event {
                padding: 10px 12px;
            }
            .cal-event .info .title {
                font-size: 13px;
            }
            .cal-event .info .desc {
                font-size: 11px;
            }
        }
    </style>

    <div class="cal-modern">

        <!-- ===== TOAST CONTAINER ===== -->
        <div class="toast-container" id="toastContainer"></div>

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
                    <strong id="calTotalCount">{{ $calendarCollection->count() }}</strong> event terdaftar
                </p>
            </div>
            <div class="cal-header-actions">
                <a href="{{ route('taxes.pph') }}" class="cal-btn cal-btn-ghost">
                    <svg class="icon"><use href="#ic-bank"/></svg>
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
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Event
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="cal-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ===== FILTER BAR ===== -->
        <div class="filter-bar animate-in" style="animation-delay: 0.10s;">
            <form method="GET" action="{{ route('tax-calendar.index') }}" id="calSearchForm" onsubmit="return false;">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="calSearchInput" value="{{ request('q') }}" 
                           placeholder="Cari event, jenis pajak, atau status..." autocomplete="off">
                </div>
                <div class="filter-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    @if(request()->filled('q'))
                        <a href="{{ route('tax-calendar.index') }}" class="cal-btn cal-btn-ghost" id="calResetBtn">
                            <svg class="icon"><use href="#ic-x"/></svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- ===== MONTHLY EVENTS ===== -->
        <div id="calEventsContainer">
            @forelse($eventsByMonth as $month => $events)
                <div class="cal-month cal-month-data animate-in" 
                     style="animation-delay: {{ 0.10 + ($loop->index * 0.05) }}s;"
                     data-month="{{ $month }}">
                    <div class="cal-month-header">
                        <span class="month">{{ $month }}</span>
                        <span class="count cal-month-count">{{ $events->count() }} event</span>
                    </div>
                    <div class="cal-events">
                        @foreach($events->sortBy('date') as $event)
                            @php
                                $date = \Carbon\Carbon::parse($event['date']);
                                $isOverdue = $date->isPast() && $event['status'] != 'done';
                                $itemId = $event['_index'];
                            @endphp
                            <div class="cal-event cal-event-data visible-event"
                                 data-title="{{ strtolower($event['title']) }}"
                                 data-type="{{ $event['type'] }}"
                                 data-status="{{ $event['status'] }}"
                                 data-desc="{{ strtolower($event['desc']) }}">
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

                                <!-- ===== ACTION BUTTONS (Show, Edit, Delete) ===== -->
                                <div class="cal-event-actions">
                                    <a href="{{ route('tax-calendar.show', $itemId) }}" class="action-btn show-btn" title="Lihat Detail">
                                        <svg class="icon"><use href="#ic-eye"/></svg>
                                    </a>
                                    <a href="{{ route('tax-calendar.edit', $itemId) }}" class="action-btn edit-btn" title="Edit Event">
                                        <svg class="icon"><use href="#ic-edit"/></svg>
                                    </a>
                                    <button class="action-btn delete-btn" onclick="openDeleteModal('{{ $itemId }}', '{{ addslashes($event['title']) }}', '{{ route('tax-calendar.destroy', $itemId) }}')" title="Hapus">
                                        <svg class="icon"><use href="#ic-trash"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="cal-month">
                    <div class="cal-empty">
                        <svg class="empty-icon"><use href="#ic-calendar"/></svg>
                        <h3>Belum Ada Event Kalender</h3>
                        <p>Belum ada event kalender pajak yang tercatat.</p>
                        <a href="{{ route('tax-calendar.create') }}" class="cal-btn cal-btn-primary" style="display: inline-flex;">
                            <svg class="icon"><use href="#ic-plus"/></svg>
                            Tambah Event Pertama
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

    </div>

    <!-- ============================================================
         MODAL DELETE
         ============================================================ -->
    <div class="cal-modal-overlay" id="deleteModal">
        <div class="cal-modal-box">
            <div class="icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <h3>Hapus Event Kalender?</h3>

            <p>
                Anda yakin ingin menghapus event
                <br>
                <span class="cal-desc-text" id="deleteDesc">-</span>
            </p>

            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>

            <div class="cal-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                        Ya, Hapus!
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ===== TOAST SYSTEM =====
        function showToast(title, message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if (!container) return;
            
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `
                <div class="toast-icon ${type}">
                    <svg class="icon"><use href="#${type === 'success' ? 'ic-check-circle' : 'ic-alert-triangle'}"/></svg>
                </div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-msg">${message}</div>
                </div>
                <button class="toast-close" onclick="this.parentElement.remove()">
                    <svg class="icon"><use href="#ic-x"/></svg>
                </button>
            `;
            container.appendChild(toast);
            
            setTimeout(() => {
                if (toast.parentElement) toast.remove();
            }, 5000);
        }

        // ===== DELETE MODAL =====
        function openDeleteModal(id, description, actionUrl) {
            document.getElementById('deleteDesc').textContent = description;
            document.getElementById('deleteForm').action = actionUrl;
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            document.body.classList.add('aj-modal-open');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
            document.body.classList.remove('aj-modal-open');
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // ===== LIVE SEARCH =====
            const searchInput = document.getElementById('calSearchInput');
            const resetBtn = document.getElementById('calResetBtn');
            const searchIndicator = document.getElementById('searchIndicator');
            const searchResultCount = document.getElementById('searchResultCount');
            const totalCountEl = document.getElementById('calTotalCount');
            const eventsContainer = document.getElementById('calEventsContainer');
            let debounceTimeout = null;

            function normalizeText(text) {
                if (!text) return '';
                return text.toLowerCase().trim();
            }

            function resetToInitial() {
                const monthContainers = document.querySelectorAll('.cal-month-data');
                
                monthContainers.forEach(month => {
                    month.classList.remove('hidden-month');
                    month.classList.add('visible-month');
                    
                    const events = month.querySelectorAll('.cal-event-data');
                    let totalEvents = events.length;
                    
                    events.forEach(event => {
                        event.classList.remove('hidden-event');
                        event.classList.add('visible-event');
                    });
                    
                    const countEl = month.querySelector('.cal-month-count');
                    if (countEl) {
                        countEl.textContent = totalEvents + ' event' + (totalEvents !== 1 ? 's' : '');
                    }
                });

                const totalEvents = document.querySelectorAll('.cal-event-data').length;
                totalCountEl.textContent = totalEvents;
                searchIndicator.classList.remove('active');
                
                const emptyState = document.querySelector('.cal-empty');
                if (emptyState && emptyState.closest('.cal-month')) {
                    emptyState.closest('.cal-month').style.display = 'none';
                }
            }

            function filterEvents() {
                const searchText = searchInput ? searchInput.value.trim() : '';
                const normalizedSearch = normalizeText(searchText);
                
                if (searchText === '') {
                    resetToInitial();
                    return;
                }
                
                const monthContainers = document.querySelectorAll('.cal-month-data');
                let totalVisibleEvents = 0;

                monthContainers.forEach(month => {
                    const events = month.querySelectorAll('.cal-event-data');
                    let visibleInMonth = 0;

                    events.forEach(event => {
                        const title = event.dataset.title || '';
                        const type = event.dataset.type || '';
                        const status = event.dataset.status || '';
                        const desc = event.dataset.desc || '';

                        const match = 
                            normalizeText(title).includes(normalizedSearch) ||
                            normalizeText(type).includes(normalizedSearch) ||
                            normalizeText(status).includes(normalizedSearch) ||
                            normalizeText(desc).includes(normalizedSearch);

                        if (match) {
                            event.classList.remove('hidden-event');
                            event.classList.add('visible-event');
                            visibleInMonth++;
                            totalVisibleEvents++;
                        } else {
                            event.classList.remove('visible-event');
                            event.classList.add('hidden-event');
                        }
                    });

                    const countEl = month.querySelector('.cal-month-count');
                    if (countEl) {
                        countEl.textContent = visibleInMonth + ' event' + (visibleInMonth !== 1 ? 's' : '');
                    }

                    if (visibleInMonth === 0) {
                        month.classList.remove('visible-month');
                        month.classList.add('hidden-month');
                    } else {
                        month.classList.remove('hidden-month');
                        month.classList.add('visible-month');
                    }
                });

                searchIndicator.classList.add('active');
                searchResultCount.textContent = totalVisibleEvents;
                totalCountEl.textContent = totalVisibleEvents;

                const emptyState = document.querySelector('.cal-empty');
                if (emptyState) {
                    const monthContainer = emptyState.closest('.cal-month');
                    if (totalVisibleEvents === 0) {
                        if (monthContainer) {
                            monthContainer.style.display = 'block';
                            monthContainer.classList.remove('hidden-month');
                            monthContainer.classList.add('visible-month');
                        }
                        emptyState.style.display = 'block';
                        const titleEl = emptyState.querySelector('h3');
                        if (titleEl) titleEl.textContent = 'Tidak Ada Hasil Pencarian';
                        const descEl = emptyState.querySelector('p');
                        if (descEl) descEl.textContent = 'Tidak ditemukan event yang sesuai dengan kata kunci "' + searchText + '"';
                        const btn = emptyState.querySelector('.cal-btn');
                        if (btn) btn.style.display = 'none';
                    } else {
                        emptyState.style.display = 'none';
                        if (monthContainer) {
                            monthContainer.style.display = '';
                        }
                    }
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(function() {
                        filterEvents();
                        
                        const url = new URL(window.location.href);
                        if (searchInput.value.trim() !== '') {
                            url.searchParams.set('q', searchInput.value.trim());
                        } else {
                            url.searchParams.delete('q');
                        }
                        window.history.replaceState({}, '', url.toString());
                    }, 300);
                });

                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                    if (e.key === '/' && !e.ctrlKey && !e.metaKey && !e.altKey) {
                        const activeElement = document.activeElement;
                        if (activeElement && (activeElement.tagName === 'INPUT' || activeElement.tagName === 'TEXTAREA')) {
                            return;
                        }
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                });
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.value = '';
                    }
                    resetToInitial();
                    const url = new URL(window.location.href);
                    url.searchParams.delete('q');
                    window.history.replaceState({}, '', url.toString());
                });
            }

            // Initial state
            setTimeout(function() {
                resetToInitial();
            }, 100);

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.cal-btn, .btn, .action-btn');
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