<x-app-layout>
    <x-slot name="title">Semua Faktur</x-slot>

    @php
        $statusMeta = [
            'draft'     => ['label' => 'Draft',       'class' => 'st-draft'],
            'sent'      => ['label' => 'Terkirim',    'class' => 'st-sent'],
            'paid'      => ['label' => 'Lunas',       'class' => 'st-paid'],
            'overdue'   => ['label' => 'Jatuh Tempo', 'class' => 'st-overdue'],
            'cancelled' => ['label' => 'Dibatalkan',  'class' => 'st-cancelled'],
        ];

        function formatRupiahShort($amount) {
            if ($amount >= 1000000000) {
                return 'Rp' . number_format($amount / 1000000000, 1, ',', '') . ' M';
            } elseif ($amount >= 1000000) {
                return 'Rp' . number_format($amount / 1000000, 1, ',', '') . ' Jt';
            } elseif ($amount >= 1000) {
                return 'Rp' . number_format($amount / 1000, 0, ',', '') . ' Rb';
            }
            return 'Rp' . number_format($amount, 0, ',', '.');
        }
    @endphp

    <svg style="display:none;">
        <defs>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-download" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
            </symbol>
            <symbol id="ic-file" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .inv-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .inv-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.55;} }
        @keyframes spin{ to{ transform:rotate(360deg);} }
        @keyframes slideDown{ from{ opacity:0; transform:translateY(-10px) scale(.95);} to{ opacity:1; transform:translateY(0) scale(1);} }
        .inv-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        /* ===== TOAST NOTIFICATION ===== */
        .toast-container{
            position:fixed; top:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:10px; max-width:380px; width:100%;
        }
        .toast{
            background:var(--modal-bg); border:1px solid var(--border); border-radius:var(--radius-md); padding:16px 20px;
            box-shadow:0 20px 60px rgba(0,0,0,0.5); animation:slideDown .35s cubic-bezier(.16,1,.3,1);
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

        /* ===== HEADER ===== */
        .inv-header{ display:flex; justify-content:space-between; align-items:flex-start; gap:24px; flex-wrap:wrap; margin-bottom:26px; }
        .inv-header-left{ flex:1; min-width:220px; }
        .inv-badge{
            display:inline-flex; align-items:center; gap:8px; padding:6px 14px 6px 10px;
            background:var(--accent-glow); border:1px solid var(--accent-glow); border-radius:100px;
            font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:var(--accent);
            margin-bottom:12px;
        }
        .inv-badge .dot{ width:6px; height:6px; border-radius:50%; background:var(--accent); animation:pulseGlow 2s ease-in-out infinite; }
        .inv-header h1{
            font-family:'Space Grotesk', sans-serif; font-size:28px; font-weight:700; margin:0 0 6px; letter-spacing:-.02em;
            background:linear-gradient(135deg, var(--text) 55%, var(--accent)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;
        }
        .inv-header p{ font-size:14px; color:var(--text-mute); margin:0; }
        .inv-header p strong{ color:var(--text); font-weight:600; }

        .head-actions{ display:flex; gap:10px; flex-wrap:wrap; }
        .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 20px; border-radius:var(--radius-sm); font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .22s cubic-bezier(.16,1,.3,1); white-space:nowrap; position:relative; overflow:hidden; text-decoration:none; }
        .btn .icon{ width:15px; height:15px; }
        .btn-primary{ background:linear-gradient(135deg, var(--accent), var(--accent-dim)); color:#052117; box-shadow:0 4px 18px var(--accent-glow); }
        .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 10px 28px var(--accent-glow); }
        .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
        .btn-outline:hover{ background:var(--surface-strong); border-color:var(--border-hover); transform:translateY(-2px); }
        .btn-sm{ padding:8px 14px; font-size:12.5px; }
        .btn-danger{ background:var(--danger); color:#fff; }
        .btn-danger:hover{ background:#d14a4a; transform:translateY(-2px); box-shadow:0 8px 22px rgba(232,90,90,.35); }
        .btn-success{ background:var(--success); color:#052117; }
        .btn-success:hover{ transform:translateY(-2px); box-shadow:0 8px 22px rgba(52,181,131,.35); }

        /* ===== STAT CARDS ===== */
        .stat-row{ display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
        .stat-card{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-md); padding:20px 22px;
            position:relative; overflow:hidden; transition:all .25s ease;
        }
        .stat-card::before{ content:''; position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg, transparent, currentColor, transparent); opacity:0; transition:opacity .3s ease; }
        .stat-card:hover{ transform:translateY(-3px); border-color:var(--border-hover); }
        .stat-card:hover::before{ opacity:.6; }
        .stat-card .sk{ display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
        .stat-card .sk-label{ font-size:11.5px; color:var(--text-faint); text-transform:uppercase; letter-spacing:.06em; font-weight:600; }
        .stat-icon{ width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .stat-icon .icon{ width:16px; height:16px; }
        .stat-card.c-emerald{ color:var(--emerald); }
        .stat-card.c-emerald .stat-icon{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .stat-card.c-info{ color:var(--blue); }
        .stat-card.c-info .stat-icon{ background:rgba(78,143,240,.14); color:var(--blue); }
        .stat-card.c-danger{ color:var(--danger); }
        .stat-card.c-danger .stat-icon{ background:rgba(232,90,90,.14); color:var(--danger); }
        .stat-card .sv{ font-family:'Space Grotesk', sans-serif; font-size:23px; font-weight:700; letter-spacing:-.01em; color:var(--text); }
        .stat-card .sc{ font-size:12px; color:var(--text-faint); margin-top:5px; }

        /* ===== FILTER BAR ===== */
        .filter-bar{ 
            display:flex; 
            align-items:center; 
            gap:12px; 
            margin-bottom:18px; 
            flex-wrap:wrap; 
            background:var(--surface); 
            padding:16px 20px; 
            border-radius:var(--radius-md); 
            border:1px solid var(--border);
        }
        .filter-bar form{ 
            display:flex; 
            align-items:center; 
            gap:12px; 
            flex-wrap:wrap; 
            width:100%; 
        }
        .search-wrap{ 
            position:relative; 
            flex:1; 
            min-width:220px; 
        }
        .search-wrap .icon{ 
            position:absolute; 
            left:14px; 
            top:50%; 
            transform:translateY(-50%); 
            width:16px; 
            height:16px; 
            color:var(--text-muted); 
            pointer-events:none; 
        }
        .filter-bar input[type=text]{ 
            width:100%; 
            padding:10px 16px 10px 42px; 
            border-radius:var(--radius-sm); 
            background:var(--surface-hover); 
            border:1px solid var(--border); 
            color:var(--text); 
            font-size:13px; 
            outline:none; 
            transition:border-color .15s ease, box-shadow .15s ease; 
        }
        .filter-bar input[type=text]:focus{ 
            border-color:var(--accent); 
            background:var(--surface); 
            box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.1); 
        }
        .filter-bar input[type=text]::placeholder {
            color:var(--text-muted);
        }

        .filter-bar select{ 
            padding:10px 38px 10px 16px; 
            border-radius:var(--radius-sm); 
            background:var(--surface-hover); 
            border:1px solid var(--border); 
            color:var(--text); 
            font-size:13px; 
            outline:none; 
            min-width:180px; 
            cursor:pointer; 
            transition:border-color .15s ease, box-shadow .15s ease;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='none' stroke='%239CA3AF' stroke-width='2' d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
            color-scheme: dark;
        }
        .filter-bar select:focus{ 
            border-color:var(--accent); 
            background-color:var(--surface); 
            box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.1); 
        }
        .filter-bar select:hover {
            border-color:var(--border-hover);
        }

        .filter-bar select option {
            background-color: #1a1f2e;
            color: #e8edf5;
            padding: 10px 14px;
            font-size: 14px;
        }
        .filter-bar select option:checked,
        .filter-bar select option:hover {
            background-color: #0d2a1f;
            color: #34d399;
        }

        .filter-actions{ 
            display:flex; 
            gap:8px; 
            align-items:center; 
        }

        /* ===== TABLE CARD ===== */
        .table-card{ background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); overflow:hidden; position:relative; }
        .table-scroll{ overflow-x:auto; }
        table{ width:100%; border-collapse:collapse; min-width:820px; }
        thead th{ text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); font-weight:700; padding:15px 18px; border-bottom:2px solid var(--border); white-space:nowrap; background:var(--surface-hover); }
        tbody tr{ border-bottom:1px solid var(--border); transition:background .18s ease; position:relative; }
        tbody tr:last-child{ border-bottom:none; }
        tbody tr:hover{ background:var(--surface-strong); }
        tbody tr.row-accent td:first-child{ box-shadow: inset 3px 0 0 0 var(--row-color, transparent); }
        tbody td{ padding:15px 18px; font-size:13.5px; vertical-align:middle; }

        .inv-no{ font-family:'IBM Plex Mono', monospace; font-size:12.5px; color:var(--text); }
        .client-cell{ display:flex; align-items:center; gap:10px; }
        .client-avatar{
            width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center;
            font-family:'Space Grotesk', sans-serif; font-size:13px; font-weight:700; color:#fff; flex-shrink:0;
        }
        .client-name{ font-weight:600; font-size:13.5px; color:var(--text); }
        .client-sub{ font-size:11.5px; color:var(--text-faint); margin-top:1px; }
        .amount-cell{ font-family:'Space Grotesk', sans-serif; font-weight:700; color:var(--text); }
        .date-cell{ color:var(--text-mute); font-size:13px; }
        .date-cell .overdue-flag{ color:var(--danger); font-size:11px; display:flex; align-items:center; gap:4px; margin-top:3px; font-weight:600; }
        .date-cell .overdue-flag .icon{ width:11px; height:11px; }

        .status-badge{ display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:100px; font-size:11.5px; font-weight:700; letter-spacing:.01em; }
        .status-badge .sdot{ width:6px; height:6px; border-radius:50%; }
        .st-draft{ background:var(--surface-strong); color:var(--text-mute); }
        .st-draft .sdot{ background:var(--text-faint); }
        .st-sent{ background:rgba(78,143,240,.14); color:var(--blue); }
        .st-sent .sdot{ background:var(--blue); }
        .st-paid{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .st-paid .sdot{ background:var(--emerald); }
        .st-overdue{ background:rgba(232,90,90,.14); color:var(--danger); }
        .st-overdue .sdot{ background:var(--danger); animation:pulseGlow 1.6s ease-in-out infinite; }
        .st-cancelled{ background:var(--surface-strong); color:var(--text-faint); text-decoration:line-through; }
        .st-cancelled .sdot{ background:var(--text-faint); }

        /* ===== ICON ACTIONS ===== */
        .row-actions{ display:flex; align-items:center; gap:6px; justify-content:flex-end; }
        .icon-action{
            width:32px; height:32px; border-radius:9px; display:inline-flex; align-items:center; justify-content:center;
            background:var(--surface); border:1px solid var(--border); color:var(--text-faint); cursor:pointer;
            transition:all .18s ease; position:relative; text-decoration:none;
        }
        .icon-action .icon{ width:15px; height:15px; }
        .icon-action:hover{ transform:translateY(-2px); }
        .icon-action.view:hover{ background:var(--accent-soft); border-color:var(--accent); color:var(--accent); }
        .icon-action.edit:hover{ background:rgba(78,143,240,.14); border-color:var(--blue); color:var(--blue); }
        .icon-action.delete:hover{ background:rgba(232,90,90,.14); border-color:var(--danger); color:var(--danger); }
        .icon-action.send:hover{ background:rgba(78,143,240,.14); border-color:var(--blue); color:var(--blue); }

        .icon-action[data-tip]::after{
            content:attr(data-tip); position:absolute; bottom:calc(100% + 8px); left:50%; transform:translateX(-50%) translateY(4px);
            background:var(--surface); color:var(--text); font-size:11px; font-weight:600; padding:5px 9px; border-radius:7px; white-space:nowrap;
            opacity:0; visibility:hidden; transition:all .16s ease; pointer-events:none; box-shadow:0 6px 18px rgba(0,0,0,.35); border:1px solid var(--border);
        }
        .icon-action[data-tip]::before{
            content:''; position:absolute; bottom:calc(100% + 3px); left:50%; transform:translateX(-50%);
            border:5px solid transparent; border-top-color:var(--surface); opacity:0; visibility:hidden; transition:all .16s ease;
        }
        .icon-action[data-tip]:hover::after, .icon-action[data-tip]:hover::before{ opacity:1; visibility:visible; transform:translateX(-50%) translateY(0); }

        /* ===== EMPTY STATE ===== */
        .empty-state{ text-align:center; padding:64px 30px; }
        .empty-ic{ width:60px; height:60px; border-radius:16px; background:var(--accent-soft); border:1px solid var(--accent-glow); display:flex; align-items:center; justify-content:center; color:var(--accent); margin:0 auto 18px; }
        .empty-ic .icon{ width:26px; height:26px; }
        .empty-state h3{ font-family:'Space Grotesk', sans-serif; font-size:17px; margin-bottom:6px; color:var(--text); }
        .empty-state p{ font-size:13.5px; color:var(--text-mute); max-width:340px; margin:0 auto 22px; }

        .pagination-bar{ display:flex; align-items:center; justify-content:space-between; padding:16px 18px; border-top:1px solid var(--border); flex-wrap:wrap; gap:12px; }
        .pg-info{ font-size:12.5px; color:var(--text-faint); }

        /* ===== DELETE MODAL ===== */
        .modal-overlay{ position:fixed; inset:0; background:rgba(3,6,12,.65); backdrop-filter:blur(8px); z-index:999; display:none; align-items:center; justify-content:center; padding:20px; }
        .modal-overlay.open{ display:flex; }
        @keyframes modalSlideUp{ from{ opacity:0; transform:translateY(24px) scale(.96);} to{ opacity:1; transform:translateY(0) scale(1);} }
        .modal-box{ background:var(--modal-bg); border:1px solid var(--border); border-radius:var(--radius-lg); padding:32px 34px; max-width:420px; width:100%; box-shadow:0 30px 80px rgba(0,0,0,.5); animation:modalSlideUp .3s cubic-bezier(.16,1,.3,1); text-align:center; }
        .modal-ic{ width:54px; height:54px; border-radius:50%; background:rgba(232,90,90,.14); color:var(--danger); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
        .modal-ic .icon{ width:24px; height:24px; }
        .modal-box h3{ font-family:'Space Grotesk', sans-serif; font-size:18px; margin-bottom:8px; color:var(--text); }
        .modal-box p{ font-size:13.5px; color:var(--text-mute); margin-bottom:6px; line-height:1.6; }
        .modal-box p b{ color:var(--text); font-family:'IBM Plex Mono', monospace; background:var(--surface-strong); padding:2px 10px; border-radius:6px; display:inline-block; margin-top:4px; }
        .modal-warn{ font-size:12.5px; color:var(--danger); font-weight:600; margin-top:14px; padding:9px 14px; background:rgba(232,90,90,.1); border-radius:10px; display:inline-block; }
        .modal-actions{ display:flex; gap:10px; justify-content:center; margin-top:22px; }
        .modal-actions .btn{ flex:1; justify-content:center; }

        @media (max-width: 1100px){ .stat-row{ grid-template-columns:repeat(2,1fr); } }
        @media (max-width: 768px){
            .inv-header{ flex-direction:column; }
            .head-actions{ width:100%; }
            .head-actions .btn{ flex:1; }
            .stat-row{ grid-template-columns:1fr 1fr; gap:12px; }
            .stat-card .sv{ font-size:19px; }
            .filter-bar form{ flex-direction:column; align-items:stretch; }
            .search-wrap{ min-width:unset; }
            .filter-bar select{ min-width:unset; width:100%; }
            .filter-actions{ justify-content:stretch; }
            .filter-actions .btn{ flex:1; }
        }
        @media (max-width: 480px){ 
            .stat-row{ grid-template-columns:1fr; } 
            .inv-header h1{ font-size:22px; }
        }
    </style>

    <div class="inv-wrap">

        {{-- ===== TOAST CONTAINER ===== --}}
        <div class="toast-container" id="toastContainer"></div>

        {{-- ===== HEADER ===== --}}
        <div class="inv-header animate-in" style="animation-delay:.05s;">
            <div class="inv-header-left">
                <div class="inv-badge"><span class="dot"></span> Penjualan</div>
                <h1>Semua Faktur</h1>
                <p>Kelola, kirim, dan pantau status semua faktur penjualan <strong>{{ $company->name ?? 'perusahaanmu' }}</strong> di satu tempat.</p>
            </div>
            <div class="head-actions">
                <a href="{{ route('invoices.export', request()->only(['q', 'status', 'from'])) }}" class="btn btn-outline">
                    <svg class="icon"><use href="#ic-download"/></svg> 
                    Ekspor
                </a>
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg> 
                    Buat Faktur
                </a>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="stat-row" id="statCards">
            <div class="stat-card c-emerald animate-in" style="animation-delay:.10s;">
                <div class="sk">
                    <span class="sk-label">Total Faktur</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-file"/></svg></span>
                </div>
                <div class="sv mono">{{ formatRupiahShort($stats['total_amount'] ?? 0) }}</div>
                <div class="sc">{{ $stats['total_count'] ?? 0 }} faktur bulan ini</div>
            </div>
            <div class="stat-card c-emerald animate-in" style="animation-delay:.15s;">
                <div class="sk">
                    <span class="sk-label">Sudah Dibayar</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-check-circle"/></svg></span>
                </div>
                <div class="sv mono">{{ formatRupiahShort($stats['paid_amount'] ?? 0) }}</div>
                <div class="sc">{{ $stats['paid_count'] ?? 0 }} faktur lunas</div>
            </div>
            <div class="stat-card c-info animate-in" style="animation-delay:.20s;">
                <div class="sk">
                    <span class="sk-label">Menunggu Dibayar</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-clock"/></svg></span>
                </div>
                <div class="sv mono">{{ formatRupiahShort($stats['outstanding_amount'] ?? 0) }}</div>
                <div class="sc">{{ $stats['outstanding_count'] ?? 0 }} faktur terkirim</div>
            </div>
            <div class="stat-card c-danger animate-in" style="animation-delay:.25s;">
                <div class="sk">
                    <span class="sk-label">Jatuh Tempo</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-alert-triangle"/></svg></span>
                </div>
                <div class="sv mono">{{ formatRupiahShort($stats['overdue_amount'] ?? 0) }}</div>
                <div class="sc">{{ $stats['overdue_count'] ?? 0 }} faktur terlambat</div>
            </div>
        </div>

        {{-- ===== FILTER ===== --}}
        <div class="filter-bar animate-in" style="animation-delay:.28s;">
            <form method="GET" action="{{ route('invoices.index') }}" id="filterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="invoiceSearchInput" value="{{ request('q') }}" placeholder="Cari nomor faktur atau nama klien..." autocomplete="off">
                </div>
                <select name="status" id="invoiceStatusSelect">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status')==='draft' ? 'selected' : '' }}>Draft</option>
                    <option value="sent" {{ request('status')==='sent' ? 'selected' : '' }}>Terkirim</option>
                    <option value="paid" {{ request('status')==='paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="overdue" {{ request('status')==='overdue' ? 'selected' : '' }}>Jatuh Tempo</option>
                    <option value="cancelled" {{ request('status')==='cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary btn-sm" id="filterBtn">Filter</button>
                    @if(request()->anyFilled(['q','status']))
                        <a href="{{ route('invoices.index') }}" class="btn btn-outline btn-sm" id="resetBtn">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ===== TABLE ===== --}}
        <div class="table-card animate-in" style="animation-delay:.32s;" id="tableContainer">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>No. Faktur</th>
                            <th>Klien</th>
                            <th>Tanggal Terbit</th>
                            <th>Jatuh Tempo</th>
                            <th style="text-align:right;">Jumlah</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($invoices as $invoice)
                            @php
                                $isOverdue = $invoice->status === 'sent' && $invoice->due_date && \Carbon\Carbon::parse($invoice->due_date)->isPast();
                                $statusKey = $isOverdue ? 'overdue' : $invoice->status;
                                $st = $statusMeta[$statusKey] ?? $statusMeta['draft'];
                                $rowColors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
                                $avColor = $rowColors[$loop->index % count($rowColors)];
                                $rowAccent = ['draft' => 'var(--text-faint)', 'sent' => 'var(--blue)', 'paid' => 'var(--emerald)', 'overdue' => 'var(--danger)', 'cancelled' => 'var(--text-faint)'][$statusKey] ?? 'transparent';
                            @endphp
                            <tr class="row-accent" style="--row-color: {{ $rowAccent }};" data-id="{{ $invoice->id }}">
                                <td><span class="inv-no">{{ $invoice->invoice_number }}</span></td>
                                <td>
                                    <div class="client-cell">
                                        <div class="client-avatar" style="background:{{ $avColor }};">{{ strtoupper(substr($invoice->client->name ?? '?', 0, 1)) }}</div>
                                        <div>
                                            <div class="client-name">{{ $invoice->client->name ?? 'Klien terhapus' }}</div>
                                            @if($invoice->client->company_name ?? null)
                                                <div class="client-sub">{{ $invoice->client->company_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="date-cell">{{ optional($invoice->issue_date)->translatedFormat('d M Y') ?? '—' }}</td>
                                <td class="date-cell">
                                    {{ optional($invoice->due_date)->translatedFormat('d M Y') ?? '—' }}
                                    @if($isOverdue)
                                        <span class="overdue-flag"><svg class="icon"><use href="#ic-alert-triangle"/></svg> Terlambat {{ \Carbon\Carbon::parse($invoice->due_date)->diffInDays(now()) }} hari</span>
                                    @endif
                                </td>
                                <td class="amount-cell mono" style="text-align:right;">Rp{{ number_format($invoice->total ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status-badge {{ $st['class'] }}"><span class="sdot"></span>{{ $st['label'] }}</span>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        @if($invoice->status === 'draft')
                                            <button type="button" class="icon-action send" data-tip="Kirim" onclick="sendInvoice('{{ $invoice->id }}', '{{ $invoice->invoice_number }}')">
                                                <svg class="icon"><use href="#ic-send"/></svg>
                                            </button>
                                        @endif
                                        <a href="{{ route('invoices.show', $invoice) }}" class="icon-action view" data-tip="Lihat">
                                            <svg class="icon"><use href="#ic-eye"/></svg>
                                        </a>
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="icon-action edit" data-tip="Edit">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <button type="button" class="icon-action delete" data-tip="Hapus" onclick="openDeleteModal('{{ $invoice->id }}', '{{ $invoice->invoice_number }}')">
                                            <svg class="icon"><use href="#ic-trash"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
                                        <h3>Belum ada faktur</h3>
                                        <p>Faktur yang kamu buat untuk klien akan muncul di sini. Mulai dengan membuat faktur pertamamu.</p>
                                        <a href="{{ route('invoices.create') }}" class="btn btn-primary"><svg class="icon"><use href="#ic-plus"/></svg> Buat Faktur Pertama</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($invoices) && method_exists($invoices, 'total') && $invoices->total() > 0)
                <div class="pagination-bar">
                    <div class="pg-info">
                        Menampilkan {{ $invoices->firstItem() }}–{{ $invoices->lastItem() }} dari {{ $invoices->total() }} faktur
                    </div>
                    <div>
                        {{ $invoices->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>

        {{-- ===== DELETE MODAL ===== --}}
        <div class="modal-overlay" id="deleteModal">
            <div class="modal-box">
                <div class="modal-ic"><svg class="icon"><use href="#ic-alert-triangle"/></svg></div>
                <h3>Hapus faktur ini?</h3>
                <p>Faktur <br><b id="deleteInvoiceNo">—</b></p>
                <p style="margin-top:8px;">akan dihapus permanen dan tidak bisa dikembalikan.</p>
                <div class="modal-warn">Klien tidak akan bisa lagi mengakses tautan faktur ini.</div>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-actions">
                        <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ===== TOAST SYSTEM =====
        function showToast(title, message, type = 'success') {
            const container = document.getElementById('toastContainer');
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
        function openDeleteModal(id, invoiceNo){
            document.getElementById('deleteInvoiceNo').textContent = invoiceNo;
            document.getElementById('deleteForm').action = '{{ url("invoices") }}/' + id;
            document.getElementById('deleteModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal(){
            document.getElementById('deleteModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        document.getElementById('deleteModal').addEventListener('click', function(e){
            if(e.target === this) closeDeleteModal();
        });

        // ===== SEND INVOICE (UBAH STATUS JADI SENT) =====
        function sendInvoice(id, invoiceNo){
            if (!confirm('Kirim faktur ' + invoiceNo + '? (Status akan berubah menjadi Terkirim)')) return;
            
            fetch('{{ url("invoices") }}/' + id + '/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Berhasil!', data.message || 'Faktur berhasil dikirim.', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                }
            })
            .catch(error => {
                showToast('Error', 'Terjadi kesalahan pada server.', 'error');
                console.error('Error:', error);
            });
        }

        // ===== ESC KEY =====
        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape') closeDeleteModal();
        });

        // ===== LIVE SEARCH & FILTER =====
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('invoiceSearchInput');
            var statusSelect = document.getElementById('invoiceStatusSelect');
            var filterBtn = document.getElementById('filterBtn');
            var tableContainer = document.getElementById('tableContainer');
            var tableBody = document.getElementById('tableBody');
            var statCards = document.getElementById('statCards');
            var loadingTimeout = null;

            function updateResults() {
                tableContainer.style.opacity = '0.5';
                tableContainer.style.pointerEvents = 'none';
                
                var q = searchInput ? searchInput.value : '';
                var status = statusSelect ? statusSelect.value : '';
                
                var url = '{{ route("invoices.index") }}?q=' + encodeURIComponent(q) + '&status=' + encodeURIComponent(status);
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(html, 'text/html');
                    
                    var newBody = doc.querySelector('#tableBody');
                    if (newBody) {
                        tableBody.innerHTML = newBody.innerHTML;
                    }
                    
                    var newStats = doc.querySelector('#statCards');
                    if (newStats) {
                        statCards.innerHTML = newStats.innerHTML;
                    }
                    
                    var newPagination = doc.querySelector('.pagination-bar');
                    var oldPagination = document.querySelector('.pagination-bar');
                    if (newPagination && oldPagination) {
                        oldPagination.innerHTML = newPagination.innerHTML;
                    } else if (newPagination && !oldPagination) {
                        var tableCard = document.querySelector('.table-card');
                        if (tableCard) {
                            tableCard.appendChild(newPagination);
                        }
                    } else if (!newPagination && oldPagination) {
                        oldPagination.remove();
                    }
                    
                    tableContainer.style.opacity = '1';
                    tableContainer.style.pointerEvents = 'auto';
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    tableContainer.style.opacity = '1';
                    tableContainer.style.pointerEvents = 'auto';
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    if (loadingTimeout) {
                        clearTimeout(loadingTimeout);
                    }
                    loadingTimeout = setTimeout(function() {
                        updateResults();
                    }, 300);
                });
            }

            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    if (loadingTimeout) {
                        clearTimeout(loadingTimeout);
                    }
                    updateResults();
                });
            }

            if (filterBtn) {
                filterBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (loadingTimeout) {
                        clearTimeout(loadingTimeout);
                    }
                    updateResults();
                });
            }
        });
    </script>
</x-app-layout>