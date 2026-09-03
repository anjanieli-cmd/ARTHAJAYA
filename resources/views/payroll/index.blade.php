<x-app-layout>
    <x-slot name="title">Slip Gaji</x-slot>

```
@php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    /*
     * DATA PAYROLL SEKARANG LANGSUNG DARI DATABASE
     * melalui PayrollController.
     *
     * Tidak menggunakan dummy data atau session lagi.
     */
    $payrollsCollection = collect($payrolls);

    $statusLabel = [
        'paid' => 'Dibayar',
        'pending' => 'Pending'
    ];

    $statusPill = [
        'paid' => 'paid',
        'pending' => 'pending'
    ];

    $totalPayroll = $payrollsCollection->sum('total');
    $totalPaid = $payrollsCollection
        ->where('status', 'paid')
        ->sum('total');

    $totalPending = $payrollsCollection
        ->where('status', 'pending')
        ->sum('total');

    $countPending = $payrollsCollection
        ->where('status', 'pending')
        ->count();

    $countPaid = $payrollsCollection
        ->where('status', 'paid')
        ->count();

    $periods = $payrollsCollection
        ->pluck('period')
        ->filter()
        ->unique()
        ->sort()
        ->reverse()
        ->values();

    $currentPeriod = $periods->first() ?? 'Juli 2026';

    function formatTanggal($date)
    {
        if (empty($date)) return '-';

        try {
            return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
        } catch (\Exception $e) {
            return $date;
        }
    }

    function formatAngkaPendek($angka, $currency = 'Rp')
    {
        if ($angka === null || $angka === '') {
            return $currency . '0';
        }

        $angka = (float) $angka;

        if ($angka >= 1000000000) {
            return $currency . number_format(
                $angka / 1000000000,
                1,
                ',',
                '.'
            ) . ' M';
        }

        if ($angka >= 1000000) {
            return $currency . number_format(
                $angka / 1000000,
                1,
                ',',
                '.'
            ) . ' Jt';
        }

        if ($angka >= 1000) {
            return $currency . number_format(
                $angka / 1000,
                0,
                ',',
                '.'
            ) . ' Rb';
        }

        return $currency . number_format(
            $angka,
            0,
            ',',
            '.'
        );
    }

    function formatAngkaPendekNoCurrency($angka)
    {
        if ($angka === null || $angka === '') {
            return '0';
        }

        $angka = (float) $angka;

        if ($angka >= 1000000000) {
            return number_format(
                $angka / 1000000000,
                1,
                ',',
                '.'
            ) . ' M';
        }

        if ($angka >= 1000000) {
            return number_format(
                $angka / 1000000,
                1,
                ',',
                '.'
            ) . ' Jt';
        }

        if ($angka >= 1000) {
            return number_format(
                $angka / 1000,
                0,
                ',',
                '.'
            ) . ' Rb';
        }

        return number_format(
            $angka,
            0,
            ',',
            '.'
        );
    }
@endphp

<svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </symbol>

        <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </symbol>

        <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
        </symbol>

        <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
            <path d="M15 5l4 4"/>
        </symbol>

        <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="3 6 5 6 21 6"/>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
        </symbol>

        <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/>
            <line x1="12" y1="17" x2="12.01" y2="17"/>
        </symbol>

        <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
        </symbol>

        <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </symbol>

        <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </symbol>

        <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
        </symbol>
    </defs>
</svg>

<style>
    .payroll-wrap {
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
        --danger-rgb: 232, 90, 90;

        --radius-sm: 10px;
        --radius-md: 16px;
        --radius-lg: 24px;

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--text-primary);
        padding: 0 24px;
    }

    .payroll-wrap * {
        box-sizing: border-box;
    }

    .payroll-wrap .mono {
        font-family: 'IBM Plex Mono', monospace;
        font-variant-numeric: tabular-nums;
        letter-spacing: -0.02em;
    }

    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulseGlow {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.6;
        }
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
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
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    .payroll-wrap .animate-in {
        animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }

    .payroll-wrap .icon {
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

    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 380px;
        width: 100%;
    }

    .toast {
        background: var(--modal-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 16px 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        animation: fadeSlideUp .35s cubic-bezier(.16,1,.3,1);
        display: flex;
        align-items: center;
        gap: 12px;
        backdrop-filter: blur(12px);
    }

    .toast .toast-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .toast .toast-icon.success {
        background: var(--success-soft);
        color: var(--success);
    }

    .toast .toast-icon.error {
        background: var(--danger-soft);
        color: var(--danger);
    }

    .toast .toast-icon .icon {
        width: 18px;
        height: 18px;
    }

    .toast .toast-content {
        flex: 1;
    }

    .toast .toast-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }

    .toast .toast-msg {
        font-size: 12px;
        color: var(--text-mute);
    }

    .toast .toast-close {
        background: none;
        border: none;
        color: var(--text-faint);
        cursor: pointer;
        padding: 4px;
    }

    .toast .toast-close .icon {
        width: 14px;
        height: 14px;
    }

    /* ===== SUCCESS ===== */

    .pay-success {
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

    .pay-success .icon {
        width: 20px;
        height: 20px;
    }

    .pay-success .message {
        font-weight: 500;
    }

    /* ===== HEADER ===== */

    .pay-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 24px;
        flex-wrap: wrap;
        margin-bottom: 28px;
        padding: 0 4px;
    }

    .pay-header-left {
        flex: 1;
        min-width: 200px;
    }

    .pay-badge {
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

    .pay-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--theme-primary);
        animation: pulseGlow 2s ease-in-out infinite;
    }

    .pay-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 6px;
        background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.02em;
    }

    .pay-header .subtitle {
        font-size: 14px;
        color: var(--text-secondary);
        margin: 0;
    }

    .pay-header .subtitle strong {
        color: var(--text-primary);
        font-weight: 600;
    }

    .pay-actions {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
        flex-wrap: wrap;
    }

    .pay-btn {
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

    .pay-btn .icon {
        width: 16px;
        height: 16px;
    }

    .pay-btn:hover {
        transform: translateY(-2px);
    }

    .pay-btn:active {
        transform: translateY(0) scale(0.97);
    }

    .pay-btn-primary {
        background: var(--theme-gradient);
        color: #fff;
        box-shadow: 0 4px 16px var(--theme-glow);
    }

    .pay-btn-primary:hover {
        box-shadow: 0 8px 28px var(--theme-glow);
        transform: translateY(-2px);
        color: #fff;
    }

    .pay-btn-ghost {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }

    .pay-btn-ghost:hover {
        background: var(--bg-card-hover);
        border-color: var(--border-hover);
        color: var(--text-primary);
    }

    .pay-btn .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: scale(0);
        animation: rippleAnim 0.6s ease-out forwards;
        pointer-events: none;
    }

    /* ===== HERO STATS ===== */

    .pay-hero {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 28px 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .pay-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--theme-gradient);
    }

    .pay-hero-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 20px;
    }

    .pay-hero-item .label {
        font-size: 11px;
        color: var(--text-tertiary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }

    .pay-hero-item .value {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .pay-hero-item .value.green {
        color: var(--success);
    }

    .pay-hero-item .value.yellow {
        color: var(--warning);
    }

    .pay-hero-item .value.purple {
        color: var(--theme-primary);
    }

    .pay-hero-item .sub {
        font-size: 12px;
        color: var(--text-tertiary);
        margin-top: 2px;
    }

    /* ===== FILTER BAR ===== */

    .pay-filter {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        padding: 12px 20px;
        margin-bottom: 12px;
    }

    .pay-filter .label {
        font-size: 12px;
        color: var(--text-tertiary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .pay-filter select {
        background: var(--bg-card-active);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        padding: 8px 16px;
        color: var(--text-primary);
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        outline: none;
        transition: all 0.2s ease;
        min-width: 150px;
        font-family: inherit;
    }

    .pay-filter select:hover {
        border-color: var(--border-hover);
    }

    .pay-filter select:focus {
        border-color: var(--theme-primary);
    }

    .pay-filter .info {
        margin-left: auto;
        font-size: 13px;
        color: var(--text-secondary);
    }

    .pay-filter .info strong {
        color: var(--text-primary);
    }

    /* ===== SEARCH BAR ===== */

    .pay-search {
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

    .pay-search:focus-within {
        border-color: var(--theme-primary);
        box-shadow: 0 0 0 3px var(--theme-soft);
    }

    .pay-search form {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        width: 100%;
    }

    .pay-search-wrap {
        position: relative;
        flex: 1;
        min-width: 220px;
    }

    .pay-search-wrap .icon {
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

    .pay-search-wrap:focus-within .icon {
        color: var(--theme-primary);
    }

    .pay-search input[type="text"] {
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

    .pay-search input[type="text"]:focus {
        border-color: var(--theme-primary);
        background: var(--bg-card);
        box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
    }

    .pay-search input[type="text"]::placeholder {
        color: var(--text-tertiary);
    }

    .pay-search-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .pay-search-actions .pay-btn {
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

    /* ===== CARD GRID ===== */

    .pay-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 16px;
    }

    .pay-grid-wrap.loading {
        opacity: 0.5;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .pay-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 20px 22px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }

    .pay-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .pay-card:hover {
        background: var(--bg-card-hover);
        border-color: var(--border-hover);
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .pay-card:hover::before {
        opacity: 1;
    }

    .pay-card.status-paid::before {
        background: var(--success);
    }

    .pay-card.status-pending::before {
        background: var(--warning);
    }

    .pay-card.hidden-card {
        display: none;
    }

    .pay-card.visible-card {
        display: block;
        animation: fadeSlideUp 0.3s ease forwards;
    }

    .pay-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 14px;
    }

    .pay-card-emp {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pay-card-emp .avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        color: #fff;
        flex-shrink: 0;
    }

    .pay-card-emp .info .name {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .pay-card-emp .info .position {
        font-size: 12px;
        color: var(--text-tertiary);
        margin-top: 2px;
    }

    .pay-card-status {
        font-size: 10px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 100px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .pay-card-status.paid {
        background: var(--success-soft);
        color: var(--success);
    }

    .pay-card-status.pending {
        background: var(--warning-soft);
        color: var(--warning);
    }

    .pay-card-details {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
        padding: 14px 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 14px;
    }

    .pay-card-details .item .lbl {
        font-size: 10px;
        color: var(--text-tertiary);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .pay-card-details .item .val {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
        margin-top: 2px;
    }

    .pay-card-details .item .val.danger {
        color: var(--danger);
    }

    .pay-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pay-card-footer .period {
        font-size: 12px;
        color: var(--text-tertiary);
    }

    .pay-card-footer .period strong {
        color: var(--text-secondary);
    }

    .pay-card-footer .actions {
        display: flex;
        gap: 4px;
    }

    .pay-card-footer .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 500;
        color: var(--text-tertiary);
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 6px;
        transition: all 0.2s ease;
        border: 1px solid var(--border-color);
        background: transparent;
        cursor: pointer;
    }

    .pay-card-footer .btn-action .icon {
        width: 13px;
        height: 13px;
    }

    .pay-card-footer .btn-action:hover {
        transform: translateY(-1px);
    }

    .pay-card-footer .btn-action.show {
        color: var(--theme-primary);
        border-color: var(--theme-soft);
    }

    .pay-card-footer .btn-action.show:hover {
        background: var(--theme-soft);
        border-color: var(--theme-primary);
    }

    .pay-card-footer .btn-action.edit {
        color: #4FA6E8;
        border-color: rgba(79, 166, 232, 0.2);
    }

    .pay-card-footer .btn-action.edit:hover {
        background: rgba(79, 166, 232, 0.12);
        border-color: #4FA6E8;
    }

    .pay-card-footer .btn-action.delete {
        color: var(--danger);
        border-color: var(--danger-soft);
    }

    .pay-card-footer .btn-action.delete:hover {
        background: var(--danger-soft);
        border-color: var(--danger);
    }

    /* ===== EMPTY ===== */

    .pay-empty {
        text-align: center;
        padding: 60px 20px;
        background: var(--bg-card);
        border-radius: var(--radius-md);
        border: 2px dashed var(--border-color);
        grid-column: 1 / -1;
    }

    .pay-empty .empty-icon {
        width: 56px;
        height: 56px;
        margin: 0 auto 16px;
        color: var(--theme-primary);
        opacity: 0.5;
    }

    .pay-empty h3 {
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 6px;
        color: var(--text-primary);
    }

    .pay-empty p {
        color: var(--text-secondary);
        margin: 0 0 20px;
        font-size: 14px;
    }

    .pay-empty.hidden {
        display: none;
    }

    /* ============================================================
       MODAL DELETE
       ============================================================ */

    .pay-modal-overlay {
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

    .pay-modal-overlay.active {
        display: flex;
    }

    [data-theme="dark"] .pay-modal-box {
        background: #0F1520;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    [data-theme="light"] .pay-modal-box {
        background: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .pay-modal-box {
        border-radius: 24px;
        max-width: 440px;
        width: 100%;
        padding: 32px 36px;
        box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
        animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        text-align: center;
    }

    [data-theme="light"] .pay-modal-box {
        box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
    }

    .pay-modal-box .icon-danger {
        width: 56px;
        height: 56px;
        background: #FEE2E2;
        border-radius: 50%;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    [data-theme="dark"] .pay-modal-box .icon-danger {
        background: rgba(220, 38, 38, 0.2);
    }

    .pay-modal-box .icon-danger svg {
        width: 28px;
        height: 28px;
        stroke: #DC2626;
    }

    [data-theme="dark"] .pay-modal-box .icon-danger svg {
        stroke: #F87171;
    }

    .pay-modal-box h3 {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 8px 0;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .pay-modal-box p {
        font-size: 14px;
        color: var(--text-secondary);
        margin: 0 0 4px 0;
        line-height: 1.6;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .pay-modal-box .pay-desc-text {
        font-family: 'IBM Plex Mono', monospace;
        font-weight: 600;
        color: var(--text-primary);
        background: var(--bg-card-active);
        padding: 4px 14px;
        border-radius: 8px;
        display: inline-block;
        margin-top: 4px;
        font-size: 15px;
    }

    .pay-modal-box .warning-text {
        font-size: 13px;
        color: #DC2626;
        font-weight: 500;
        margin-top: 16px;
        padding: 10px 16px;
        background: #FEE2E2;
        border-radius: 10px;
        display: inline-block;
    }

    [data-theme="dark"] .pay-modal-box .warning-text {
        color: #F87171;
        background: rgba(220, 38, 38, 0.15);
    }

    .pay-modal-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 24px;
    }

    .pay-modal-actions .btn {
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

    .pay-modal-actions .btn .icon {
        width: 16px;
        height: 16px;
    }

    .pay-modal-actions .btn-outline {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }

    .pay-modal-actions .btn-outline:hover {
        background: var(--bg-card-hover);
        border-color: var(--border-hover);
        transform: translateY(-2px);
        color: var(--text-primary);
    }

    .pay-modal-actions .btn-danger {
        background: #DC2626;
        color: #fff;
    }

    .pay-modal-actions .btn-danger:hover {
        background: #B91C1C;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
    }

    [data-theme="dark"] .pay-modal-actions .btn-danger {
        background: #DC2626;
    }

    [data-theme="dark"] .pay-modal-actions .btn-danger:hover {
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

    /* ===== RESPONSIVE ===== */

    @media (max-width: 1200px) {
        .pay-hero-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 992px) {
        .pay-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .payroll-wrap {
            padding: 0 12px;
        }

        .pay-hero {
            padding: 20px;
        }

        .pay-hero-grid {
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .pay-hero-item .value {
            font-size: 20px;
        }

        .pay-grid {
            grid-template-columns: 1fr;
        }

        .pay-filter {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .pay-filter .info {
            margin-left: 0;
            text-align: center;
        }

        .pay-search {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .pay-search form {
            flex-direction: column;
        }

        .pay-search-wrap {
            min-width: 100%;
        }

        .pay-search-actions {
            width: 100%;
            justify-content: flex-end;
        }

        .pay-card-details {
            grid-template-columns: 1fr 1fr;
        }

        .pay-modal-box {
            padding: 24px 20px;
            margin: 10px;
        }

        .pay-modal-actions {
            flex-direction: column;
        }

        .pay-modal-actions .btn {
            width: 100%;
        }
    }

    @media (max-width: 640px) {
        .pay-header {
            flex-direction: column;
        }

        .pay-actions {
            width: 100%;
        }

        .pay-actions .pay-btn {
            flex: 1;
            justify-content: center;
        }

        .pay-hero-grid {
            grid-template-columns: 1fr;
        }

        .pay-card-footer {
            flex-direction: column;
            gap: 12px;
            align-items: stretch;
        }

        .pay-card-footer .actions {
            justify-content: center;
        }

        .pay-modal-box {
            padding: 20px 16px;
        }

        .pay-modal-box h3 {
            font-size: 18px;
        }

        .pay-modal-box .icon-danger {
            width: 48px;
            height: 48px;
        }

        .pay-modal-box .icon-danger svg {
            width: 24px;
            height: 24px;
        }
    }

    @media (max-width: 380px) {
        .pay-header h1 {
            font-size: 22px;
        }

        .pay-btn {
            font-size: 12px;
            padding: 8px 14px;
        }

        .pay-btn .icon {
            width: 14px;
            height: 14px;
        }

        .pay-card-details {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="payroll-wrap">

    <!-- ===== TOAST CONTAINER ===== -->

    <div class="toast-container" id="toastContainer"></div>

    <!-- ===== HEADER ===== -->

    <div class="pay-header animate-in" style="animation-delay: 0.05s;">
        <div class="pay-header-left">

            <div class="pay-badge">
                <span class="dot"></span>
                HR &amp; Payroll
            </div>

            <h1>Slip Gaji</h1>

            <p class="subtitle">
                Kelola gaji dan slip gaji karyawan —
                <strong id="payTotalCount">
                    {{ $payrollsCollection->count() }}
                </strong>
                slip gaji
            </p>

        </div>

        <div class="pay-actions">

            <a href="{{ route('employees.index') }}" class="pay-btn pay-btn-ghost">
                <svg class="icon">
                    <use href="#ic-users"/>
                </svg>
                Data Karyawan
            </a>

            <a href="{{ route('payroll.create') }}" class="pay-btn pay-btn-primary">
                <svg class="icon">
                    <use href="#ic-plus"/>
                </svg>
                Buat Payroll
            </a>

        </div>
    </div>

    <!-- ===== SUCCESS MESSAGE ===== -->

    @if(session('success'))
        <div class="pay-success animate-in" style="animation-delay: 0.08s;">
            <svg class="icon">
                <use href="#ic-check-circle"/>
            </svg>

            <span class="message">
                {{ session('success') }}
            </span>
        </div>
    @endif

    @if(session('error'))
        <div class="pay-success"
             style="background:var(--danger-soft);border-color:var(--danger);color:var(--danger);">

            <svg class="icon">
                <use href="#ic-alert-triangle"/>
            </svg>

            <span class="message">
                {{ session('error') }}
            </span>

        </div>
    @endif

    <!-- ===== HERO STATS ===== -->

    <div class="pay-hero animate-in"
         style="animation-delay: 0.10s;"
         id="payHeroStats">

        <div class="pay-hero-grid">

            <div class="pay-hero-item">

                <div class="label">
                    Total Payroll
                </div>

                <div class="value purple mono" id="payTotalPayroll">
                    {{ formatAngkaPendek($totalPayroll, $currencySymbol) }}
                </div>

                <div class="sub" id="payTotalCountSub">
                    {{ $payrollsCollection->count() }} slip gaji
                </div>

            </div>

            <div class="pay-hero-item">

                <div class="label">
                    Sudah Dibayar
                </div>

                <div class="value green mono" id="payTotalPaid">
                    {{ formatAngkaPendek($totalPaid, $currencySymbol) }}
                </div>

                <div class="sub" id="payPaidCount">
                    {{ $countPaid }} slip gaji
                </div>

            </div>

            <div class="pay-hero-item">

                <div class="label">
                    Menunggu Pembayaran
                </div>

                <div class="value yellow mono" id="payTotalPending">
                    {{ formatAngkaPendek($totalPending, $currencySymbol) }}
                </div>

                <div class="sub" id="payPendingCount">
                    {{ $countPending }} slip gaji
                </div>

            </div>

            <div class="pay-hero-item">

                <div class="label">
                    Rata-rata Gaji
                </div>

                <div class="value mono" id="payAverage">
                    {{
                        $payrollsCollection->count() > 0
                            ? formatAngkaPendek(
                                round($totalPayroll / $payrollsCollection->count()),
                                $currencySymbol
                            )
                            : $currencySymbol . '0'
                    }}
                </div>

                <div class="sub">
                    Per karyawan
                </div>

            </div>

        </div>
    </div>

    <!-- ===== FILTER PERIODE ===== -->

    <div class="pay-filter animate-in" style="animation-delay: 0.15s;">

        <span class="label">
            Periode
        </span>

        <select id="periodFilter">

            <option value="all">
                Semua Periode
            </option>

            @foreach($periods as $period)
                <option value="{{ $period }}"
                    {{ $period == $currentPeriod ? 'selected' : '' }}>
                    {{ $period }}
                </option>
            @endforeach

        </select>

        <span class="info" id="filterInfo">
            Menampilkan
            <strong id="countDisplay">
                {{ $payrollsCollection->count() }}
            </strong>
            slip gaji
        </span>

    </div>

    <!-- ===== SEARCH BAR ===== -->

    <div class="pay-search animate-in" style="animation-delay: 0.20s;">

        <form id="paySearchForm" onsubmit="return false;">

            <div class="pay-search-wrap">

                <svg class="icon">
                    <use href="#ic-search"/>
                </svg>

                <input
                    type="text"
                    id="paySearchInput"
                    placeholder="Cari karyawan, posisi, atau periode..."
                    autocomplete="off"
                >

            </div>

            <div class="pay-search-actions">

                <span class="search-indicator" id="searchIndicator">
                    <span class="count" id="searchResultCount">
                        0
                    </span>
                    hasil ditemukan
                </span>

                <button
                    type="button"
                    class="pay-btn pay-btn-ghost"
                    id="payResetBtn"
                >
                    <svg class="icon">
                        <use href="#ic-x"/>
                    </svg>
                    Reset
                </button>

            </div>

        </form>

    </div>

    <!-- ===== CARD GRID ===== -->

    <div class="pay-grid-wrap" id="payGridWrap">

        <div class="pay-grid" id="payrollGrid">

            @forelse($payrolls as $index => $p)

                @php
                    $colors = [
                        '#EC4C93',
                        '#34B583',
                        '#F0A83C',
                        '#4E8FF0',
                        '#9B7BE0',
                        '#E85A5A'
                    ];

                    $color = $colors[
                        ($index + $loop->iteration) % count($colors)
                    ];

                    /*
                     * PENTING:
                     * $p adalah Model Payroll dari database.
                     * Jadi gunakan -> bukan ['...'].
                     */
                    $statusClass = $p->status == 'paid'
                        ? 'status-paid'
                        : 'status-pending';

                    /*
                     * PENTING:
                     * Gunakan ID asli dari database.
                     * Jangan gunakan $index karena $index hanya
                     * nomor urut card.
                     */
                    $itemId = $p->id;

                    $period = $p->period ?? '';
                @endphp

                <div
                    class="pay-card {{ $statusClass }} animate-in payroll-item visible-card"
                    style="animation-delay: {{ 0.25 + ($index * 0.04) }}s;"
                    data-period="{{ $period }}"
                    data-employee="{{ strtolower($p->employee) }}"
                    data-position="{{ strtolower($p->position) }}"
                    data-status="{{ $p->status }}"
                >

                    <div class="pay-card-top">

                        <div class="pay-card-emp">

                            <div
                                class="avatar"
                                style="background: {{ $color }};"
                            >
                                {{ mb_substr($p->employee, 0, 1) }}
                            </div>

                            <div class="info">

                                <div class="name">
                                    {{ $p->employee }}
                                </div>

                                <div class="position">
                                    {{ $p->position }}
                                </div>

                            </div>

                        </div>

                        <span class="pay-card-status {{ $statusPill[$p->status] ?? 'pending' }}">
                            {{ $statusLabel[$p->status] ?? ucfirst($p->status) }}
                        </span>

                    </div>

                    <div class="pay-card-details">

                        <div class="item">

                            <div class="lbl">
                                Gaji Pokok
                            </div>

                            <div class="val mono">
                                {{ formatAngkaPendek($p->basic_salary, $currencySymbol) }}
                            </div>

                        </div>

                        <div class="item">

                            <div class="lbl">
                                Tunjangan
                            </div>

                            <div class="val mono">
                                {{ formatAngkaPendek($p->allowance, $currencySymbol) }}
                            </div>

                        </div>

                        <div class="item">

                            <div class="lbl">
                                Potongan
                            </div>

                            <div class="val mono danger">
                                -{{ formatAngkaPendek($p->deduction, $currencySymbol) }}
                            </div>

                        </div>

                    </div>

                    <div class="pay-card-footer">

                        <div class="period">
                            Periode
                            <strong>
                                {{ $p->period }}
                            </strong>
                        </div>

                        <div class="actions">

                            <!-- ===== LIHAT DETAIL ===== -->

                            <a
                                href="{{ route('payroll.show', ['payroll' => $itemId]) }}"
                                class="btn-action show"
                                title="Lihat Detail"
                            >
                                <svg class="icon">
                                    <use href="#ic-eye"/>
                                </svg>
                                Slip
                            </a>

                            <!-- ===== EDIT ===== -->

                            <a
                                href="{{ route('payroll.edit', ['payroll' => $itemId]) }}"
                                class="btn-action edit"
                                title="Edit"
                            >
                                <svg class="icon">
                                    <use href="#ic-edit"/>
                                </svg>
                                Edit
                            </a>

                            <!-- ===== DELETE ===== -->

                            <button
                                type="button"
                                class="btn-action delete"
                                title="Hapus"
                                onclick="openDeleteModal(
                                    '{{ $itemId }}',
                                    '{{ addslashes($p->employee) }}'
                                )"
                            >
                                <svg class="icon">
                                    <use href="#ic-trash"/>
                                </svg>
                                Hapus
                            </button>

                        </div>

                    </div>

                </div>

            @empty

                <div class="pay-empty" id="emptyState">

                    <svg class="empty-icon">
                        <use href="#ic-users"/>
                    </svg>

                    <h3>
                        Belum Ada Slip Gaji
                    </h3>

                    <p>
                        Belum ada slip gaji yang tercatat di sistem.
                    </p>

                    <a
                        href="{{ route('payroll.create') }}"
                        class="pay-btn pay-btn-primary"
                        style="display: inline-flex;"
                    >
                        <svg class="icon">
                            <use href="#ic-plus"/>
                        </svg>
                        Buat Slip Gaji Pertama
                    </a>

                </div>

            @endforelse

        </div>

    </div>

</div>

<!-- ============================================================
     MODAL DELETE
     ============================================================ -->

<div class="pay-modal-overlay" id="deleteModal">

    <div class="pay-modal-box">

        <div class="icon-danger">

            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>

        </div>

        <h3>
            Hapus Slip Gaji?
        </h3>

        <p>
            Anda yakin ingin menghapus slip gaji
            <br>

            <span class="pay-desc-text" id="deleteDesc">
                -
            </span>
        </p>

        <div class="warning-text">
            ⚠️ Data yang dihapus tidak dapat dikembalikan!
        </div>

        <div class="pay-modal-actions">

            <button
                type="button"
                class="btn btn-outline"
                onclick="closeDeleteModal()"
            >
                Batal
            </button>

            <!--
                PENTING:
                Parameter route sekarang adalah {payroll},
                bukan {index}.
            -->
            <form
                id="deleteForm"
                action="{{ route('payroll.destroy', ['payroll' => 0]) }}"
                method="POST"
                style="display:inline;"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-danger"
                >
                    <svg
                        class="icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
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
                <svg class="icon">
                    <use href="#${type === 'success'
                        ? 'ic-check-circle'
                        : 'ic-alert-triangle'}"/>
                </svg>
            </div>

            <div class="toast-content">
                <div class="toast-title">
                    ${title}
                </div>

                <div class="toast-msg">
                    ${message}
                </div>
            </div>

            <button
                class="toast-close"
                onclick="this.parentElement.remove()"
            >
                <svg class="icon">
                    <use href="#ic-x"/>
                </svg>
            </button>
        `;

        container.appendChild(toast);

        setTimeout(() => {

            if (toast.parentElement) {
                toast.remove();
            }

        }, 5000);
    }


    // ===== DELETE MODAL =====

    function openDeleteModal(id, description) {

        document.getElementById('deleteDesc').textContent = description;

        /*
         * Route menghasilkan:
         * /payroll/0
         *
         * Kemudian angka 0 diganti dengan ID payroll
         * yang sebenarnya.
         */
        var url = '{{ route("payroll.destroy", ["payroll" => 0]) }}';

        url = url.replace(/\/0$/, '/' + id);

        document.getElementById('deleteForm').action = url;

        document
            .getElementById('deleteModal')
            .classList
            .add('active');

        document.body.style.overflow = 'hidden';

        document.body.classList.add('aj-modal-open');
    }


    function closeDeleteModal() {

        document
            .getElementById('deleteModal')
            .classList
            .remove('active');

        document.body.style.overflow = '';

        document.body.classList.remove('aj-modal-open');
    }


    document
        .getElementById('deleteModal')
        .addEventListener('click', function(e) {

            if (e.target === this) {
                closeDeleteModal();
            }

        });


    document.addEventListener('keydown', function(e) {

        if (e.key === 'Escape') {
            closeDeleteModal();
        }

    });


    // ===== FILTER & SEARCH =====

    document.addEventListener('DOMContentLoaded', function() {

        const searchInput =
            document.getElementById('paySearchInput');

        const resetBtn =
            document.getElementById('payResetBtn');

        const periodFilter =
            document.getElementById('periodFilter');

        const items =
            document.querySelectorAll('.payroll-item');

        const countDisplay =
            document.getElementById('countDisplay');

        const searchIndicator =
            document.getElementById('searchIndicator');

        const searchResultCount =
            document.getElementById('searchResultCount');

        const totalCountEl =
            document.getElementById('payTotalCount');

        const emptyState =
            document.getElementById('emptyState');

        const gridWrap =
            document.getElementById('payGridWrap');

        const currencySymbol =
            '{{ $currencySymbol }}';

        let debounceTimeout = null;


        function formatNumber(num) {

            if (num >= 1000000000) {

                return (
                    num / 1000000000
                )
                .toFixed(1)
                .replace('.', ',') + ' M';

            }

            if (num >= 1000000) {

                return (
                    num / 1000000
                )
                .toFixed(1)
                .replace('.', ',') + ' Jt';

            }

            if (num >= 1000) {

                return Math.round(num / 1000)
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                    + ' Rb';

            }

            return num
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }


        function resetToInitial() {

            searchInput.value = '';

            periodFilter.value = 'all';

            items.forEach(item => {

                item.classList.remove('hidden-card');

                item.classList.add('visible-card');

            });

            updateStats(items.length);

            totalCountEl.textContent = items.length;

            countDisplay.textContent = items.length;

            searchIndicator.classList.remove('active');


            if (emptyState) {

                emptyState.classList.add('hidden');

                emptyState.style.display = 'none';

            }

            gridWrap.classList.remove('loading');
        }


        function updateStats(visibleCount) {

            const visibleItems =
                document.querySelectorAll(
                    '.payroll-item.visible-card'
                );

            let total = 0;
            let paid = 0;
            let pending = 0;

            let countPaid = 0;
            let countPending = 0;


            visibleItems.forEach(item => {

                const values =
                    item.querySelectorAll(
                        '.pay-card-details .item .val'
                    );


                /*
                 * Hapus Rp, titik, koma, dan karakter lain
                 * supaya bisa dihitung kembali oleh JavaScript.
                 */
                const basic =
                    parseFloat(
                        values[0]
                            ?.textContent
                            ?.replace(/[Rp,.]/g, '')
                        || 0
                    );


                const allowance =
                    parseFloat(
                        values[1]
                            ?.textContent
                            ?.replace(/[Rp,.]/g, '')
                        || 0
                    );


                const deduction =
                    parseFloat(
                        item.querySelector(
                            '.pay-card-details .item .val.danger'
                        )
                            ?.textContent
                            ?.replace(/[Rp,.-]/g, '')
                        || 0
                    );


                const totalAmount =
                    basic + allowance - deduction;

                const status =
                    item.dataset.status || '';


                total += totalAmount;


                if (status === 'paid') {

                    paid += totalAmount;

                    countPaid++;

                } else {

                    pending += totalAmount;

                    countPending++;

                }

            });


            document.getElementById(
                'payTotalPayroll'
            ).textContent =
                currencySymbol + formatNumber(total);


            document.getElementById(
                'payTotalPaid'
            ).textContent =
                currencySymbol + formatNumber(paid);


            document.getElementById(
                'payTotalPending'
            ).textContent =
                currencySymbol + formatNumber(pending);


            document.getElementById(
                'payTotalCountSub'
            ).textContent =
                visibleCount + ' slip gaji';


            document.getElementById(
                'payPaidCount'
            ).textContent =
                countPaid + ' slip gaji';


            document.getElementById(
                'payPendingCount'
            ).textContent =
                countPending + ' slip gaji';


            const avg =
                visibleCount > 0
                    ? currencySymbol +
                      formatNumber(
                          Math.round(
                              total / visibleCount
                          )
                      )
                    : currencySymbol + '0';


            document.getElementById(
                'payAverage'
            ).textContent = avg;


            countDisplay.textContent =
                visibleCount;

            totalCountEl.textContent =
                visibleCount;


            if (emptyState) {

                if (
                    visibleCount === 0 &&
                    items.length > 0
                ) {

                    emptyState.classList.remove('hidden');

                    emptyState.style.display = 'block';

                    emptyState.querySelector('h3')
                        .textContent =
                        'Tidak Ada Hasil Pencarian';

                    emptyState.querySelector('p')
                        .textContent =
                        'Tidak ditemukan slip gaji yang sesuai dengan filter yang dipilih.';

                    const btn =
                        emptyState.querySelector(
                            '.pay-btn'
                        );

                    if (btn) {
                        btn.style.display = 'none';
                    }

                } else if (
                    visibleCount === 0 &&
                    items.length === 0
                ) {

                    emptyState.classList.remove('hidden');

                    emptyState.style.display = 'block';

                    emptyState.querySelector('h3')
                        .textContent =
                        'Belum Ada Slip Gaji';

                    emptyState.querySelector('p')
                        .textContent =
                        'Belum ada slip gaji yang tercatat di sistem.';

                    const btn =
                        emptyState.querySelector(
                            '.pay-btn'
                        );

                    if (btn) {
                        btn.style.display = 'inline-flex';
                    }

                } else {

                    emptyState.classList.add('hidden');

                    emptyState.style.display = 'none';

                }

            }

            gridWrap.classList.remove('loading');
        }


        function filterData() {

            const searchText =
                searchInput
                    ? searchInput.value
                        .trim()
                        .toLowerCase()
                    : '';

            const selectedPeriod =
                periodFilter
                    ? periodFilter.value
                    : 'all';


            let visibleCount = 0;


            items.forEach(item => {

                const employee =
                    item.dataset.employee || '';

                const position =
                    item.dataset.position || '';

                const period =
                    item.dataset.period || '';


                const matchSearch =
                    searchText === '' ||
                    employee.includes(searchText) ||
                    position.includes(searchText) ||
                    period
                        .toLowerCase()
                        .includes(searchText);


                const matchPeriod =
                    selectedPeriod === 'all' ||
                    period === selectedPeriod;


                if (
                    matchSearch &&
                    matchPeriod
                ) {

                    item.classList.remove(
                        'hidden-card'
                    );

                    item.classList.add(
                        'visible-card'
                    );

                    visibleCount++;

                } else {

                    item.classList.remove(
                        'visible-card'
                    );

                    item.classList.add(
                        'hidden-card'
                    );

                }

            });


            if (
                searchText !== '' ||
                selectedPeriod !== 'all'
            ) {

                searchIndicator.classList.add(
                    'active'
                );

                searchResultCount.textContent =
                    visibleCount;

            } else {

                searchIndicator.classList.remove(
                    'active'
                );

            }


            updateStats(visibleCount);
        }


        if (searchInput) {

            searchInput.addEventListener(
                'input',
                function() {

                    gridWrap.classList.add(
                        'loading'
                    );

                    clearTimeout(
                        debounceTimeout
                    );

                    debounceTimeout =
                        setTimeout(
                            function() {
                                filterData();
                            },
                            300
                        );

                }
            );


            document.addEventListener(
                'keydown',
                function(e) {

                    if (
                        (e.ctrlKey || e.metaKey) &&
                        e.key === 'f'
                    ) {

                        e.preventDefault();

                        searchInput.focus();

                        searchInput.select();
                    }


                    if (
                        (e.ctrlKey || e.metaKey) &&
                        e.key === 'k'
                    ) {

                        e.preventDefault();

                        searchInput.focus();

                        searchInput.select();
                    }


                    if (
                        e.key === '/' &&
                        !e.ctrlKey &&
                        !e.metaKey &&
                        !e.altKey
                    ) {

                        const activeElement =
                            document.activeElement;


                        if (
                            activeElement &&
                            (
                                activeElement.tagName === 'INPUT' ||
                                activeElement.tagName === 'TEXTAREA'
                            )
                        ) {
                            return;
                        }


                        e.preventDefault();

                        searchInput.focus();

                        searchInput.select();
                    }

                }
            );

        }


        if (periodFilter) {

            periodFilter.addEventListener(
                'change',
                function() {
                    filterData();
                }
            );

        }


        if (resetBtn) {

            resetBtn.addEventListener(
                'click',
                function(e) {

                    e.preventDefault();

                    resetToInitial();

                    searchIndicator.classList.remove(
                        'active'
                    );

                    gridWrap.classList.remove(
                        'loading'
                    );

                }
            );

        }


        setTimeout(
            function() {
                resetToInitial();
            },
            100
        );


        // ===== RIPPLE EFFECT =====

        document
            .querySelectorAll('.pay-btn')
            .forEach(btn => {

                btn.addEventListener(
                    'click',
                    function(e) {

                        const rect =
                            this.getBoundingClientRect();

                        const ripple =
                            document.createElement(
                                'span'
                            );

                        ripple.className =
                            'ripple';

                        const size =
                            Math.max(
                                rect.width,
                                rect.height
                            );

                        ripple.style.width =
                            ripple.style.height =
                            size + 'px';

                        ripple.style.left =
                            (
                                e.clientX -
                                rect.left -
                                size / 2
                            ) + 'px';

                        ripple.style.top =
                            (
                                e.clientY -
                                rect.top -
                                size / 2
                            ) + 'px';

                        this.appendChild(
                            ripple
                        );

                        setTimeout(
                            () => ripple.remove(),
                            600
                        );

                    }
                );

            });

    });

</script>
```

</x-app-layout>
