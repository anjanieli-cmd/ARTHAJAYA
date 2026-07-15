<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Semua Faktur — Arthajaya</title>

<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo.png') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

<script>
  (function(){
    try{
      var t = localStorage.getItem('aj-theme') || 'dark';
      var a = localStorage.getItem('aj-accent') || 'emerald';
      document.documentElement.setAttribute('data-theme', t);
      document.documentElement.setAttribute('data-accent', a);
    }catch(e){}
  })();
</script>

<style>
  :root{
    --bg: #070B13;
    --surface: rgba(255,255,255,0.04);
    --surface-strong: rgba(255,255,255,0.08);
    --border: rgba(255,255,255,0.09);
    --border-hover: rgba(var(--emerald-rgb),0.35);
    --emerald: #34E0A1;
    --emerald-dim: #1E8F6B;
    --text: #EAF0F6;
    --text-mute: #8A96AE;
    --text-faint: #545E73;
    --radius: 20px;
    --modal-bg: linear-gradient(160deg, #0F1520, #0A0D14 60%);
    --emerald-rgb: 52,224,161;
    --danger: #E8637A;
    --danger-rgb: 232,90,122;
    --warning: #E8A23A;
    --warning-rgb: 232,162,58;
    --info: #4E8FF0;
    --info-rgb: 78,143,240;
  }
  [data-theme="light"]{
    --bg: #F4F6FA;
    --surface: rgba(15,25,40,0.035);
    --surface-strong: rgba(15,25,40,0.07);
    --border: rgba(15,25,40,0.10);
    --border-hover: rgba(var(--emerald-rgb),0.45);
    --emerald-dim: #17A374;
    --text: #131A26;
    --text-mute: #565F72;
    --text-faint: #838C9E;
    --modal-bg: linear-gradient(160deg, #FFFFFF, #F2F5F9 60%);
  }
  [data-accent="blue"]{ --emerald:#4E8FF0; --emerald-dim:#3465C4; --emerald-rgb:78,143,240; }
  [data-accent="purple"]{ --emerald:#9B7BE0; --emerald-dim:#6E4FBE; --emerald-rgb:155,123,224; }
  [data-accent="orange"]{ --emerald:#F0A25A; --emerald-dim:#C97A2E; --emerald-rgb:240,162,90; }
  [data-accent="pink"]{ --emerald:#E85A9C; --emerald-dim:#B83A78; --emerald-rgb:232,90,156; }

  *{ margin:0; padding:0; box-sizing:border-box; }
  html{ color-scheme: dark; }
  html[data-theme="light"]{ color-scheme: light; }
  body{
    background: var(--bg); color: var(--text); font-family:'Inter', sans-serif;
    line-height:1.5; min-height:100vh; transition: background .35s ease, color .35s ease;
  }
  h1,h2,h3,.display{ font-family:'Space Grotesk', sans-serif; letter-spacing:-0.02em; }
  .mono{ font-family:'IBM Plex Mono', monospace; }
  a{ text-decoration:none; color:inherit; }
  svg{ display:block; }
  .icon{ width:1em; height:1em; flex-shrink:0; }
  button{ font-family:inherit; }
  ::selection{ background: rgba(var(--emerald-rgb),0.25); }

  /* ===== APP SHELL ===== */
  .app-shell{ display:flex; min-height:100vh; }

  .sidebar{
    width:262px; flex-shrink:0; background:var(--surface); border-right:1px solid var(--border);
    padding:22px 16px; display:flex; flex-direction:column; gap:2px; position:sticky; top:0; height:100vh; overflow-y:auto;
  }
  .sb-logo{ display:flex; align-items:center; gap:10px; font-family:'Space Grotesk'; font-weight:700; font-size:17px; padding:6px 10px 22px; }
  .logo-mark{ width:28px; height:28px; border-radius:8px; background:var(--surface-strong); border:1px solid var(--border-hover); display:flex; align-items:center; justify-content:center; overflow:hidden; padding:3px; }
  .logo-mark img{ width:100%; height:100%; object-fit:contain; }
  .sb-logo .dot{ color:var(--emerald); }
  .sb-group-label{ font-size:11px; text-transform:uppercase; letter-spacing:.08em; color:var(--text-faint); padding:16px 12px 8px; }
  .sb-link{ display:flex; align-items:center; gap:11px; padding:10px 12px; border-radius:11px; font-size:13.5px; font-weight:500; color:var(--text-mute); transition:all .2s ease; }
  .sb-link .icon{ width:16px; height:16px; }
  .sb-link:hover{ background:var(--surface-strong); color:var(--text); }
  .sb-link.active{ background:rgba(var(--emerald-rgb),0.1); color:var(--emerald); }
  .sb-link .badge{ margin-left:auto; background:var(--emerald); color:#052117; font-size:10.5px; font-weight:700; padding:2px 7px; border-radius:100px; }
  .sb-accordion{ margin-bottom:2px; }
  .sb-parent{ width:100%; background:none; border:none; cursor:pointer; text-align:left; }
  .sb-parent .chevron{ margin-left:auto; width:14px; height:14px; transition: transform .25s ease; flex-shrink:0; }
  .sb-parent .badge + .chevron{ margin-left:8px; }
  .sb-accordion.open > .sb-parent .chevron{ transform: rotate(180deg); }
  .sb-accordion.open > .sb-parent{ color:var(--text); }
  .sb-submenu{ display:grid; grid-template-rows: 0fr; transition: grid-template-rows .28s ease; }
  .sb-submenu-inner{ overflow:hidden; min-height:0; margin-left:14px; padding-left:15px; border-left:1px solid var(--border); opacity:0; transition: opacity .18s ease; }
  .sb-accordion.open .sb-submenu{ grid-template-rows:1fr; }
  .sb-accordion.open .sb-submenu-inner{ opacity:1; transition: opacity .25s ease .08s; }
  .sb-sublink{ display:block; padding:9px 12px; border-radius:10px; font-size:13px; color:var(--text-mute); transition: all .2s ease; margin:1px 0; }
  .sb-sublink:hover{ color:var(--text); background:var(--surface); }
  .sb-sublink.active{ color:var(--emerald); background:rgba(var(--emerald-rgb),0.1); font-weight:600; }
  .sb-bottom{ margin-top:auto; padding-top:16px; }
  .sb-plan{ background:var(--surface-strong); border:1px solid var(--border); border-radius:14px; padding:14px; }
  .sb-plan .lbl{ font-size:11px; color:var(--text-faint); }
  .sb-plan .name{ font-size:13.5px; font-weight:600; margin:3px 0 8px; }
  .sb-plan a{ font-size:12px; color:var(--emerald); font-weight:600; }

  .main{ flex:1; min-width:0; }
  .topbar{ display:flex; align-items:center; justify-content:space-between; padding:18px 32px; border-bottom:1px solid var(--border); position:sticky; top:0; background:var(--bg); z-index:20; }
  .topbar-title{ font-size:15px; font-weight:600; color:var(--text-mute); }
  .topbar-title b{ color:var(--text); }
  .topbar-right{ display:flex; align-items:center; gap:14px; }
  .icon-btn{ width:38px; height:38px; border-radius:11px; background:var(--surface); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--text-mute); cursor:pointer; transition:all .2s ease; }
  .icon-btn:hover{ color:var(--text); border-color:var(--border-hover); }
  .icon-btn .icon{ width:17px; height:17px; }
  .avatar{ width:36px; height:36px; border-radius:50%; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:600; color:var(--emerald); }

  .content{ padding:30px 32px 60px; max-width:1400px; }

  /* ===== PAGE HEADER ===== */
  .page-head{ display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:26px; flex-wrap:wrap; }
  .page-head h1{ font-size:26px; margin-bottom:6px; }
  .page-head p{ font-size:14px; color:var(--text-mute); }
  .head-actions{ display:flex; gap:10px; }

  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; white-space:nowrap; }
  .btn .icon{ width:15px; height:15px; }
  .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 20px rgba(var(--emerald-rgb),0.3); }
  .btn-primary:hover{ transform:translateY(-1px); box-shadow:0 8px 26px rgba(var(--emerald-rgb),0.45); }
  .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .btn-outline:hover{ background:var(--surface-strong); border-color:var(--border-hover); }
  .btn-ghost{ background:none; color:var(--text-mute); padding:11px 12px; }
  .btn-ghost:hover{ color:var(--text); }
  .btn-danger-ghost{ background:none; color:var(--danger); }
  .btn-sm{ padding:8px 14px; font-size:12.5px; }

  /* ===== STAT CARDS ===== */
  .stat-row{ display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:26px; }
  .stat-card{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:20px 22px; position:relative; overflow:hidden; }
  .stat-card .sk{ display:flex; align-items:center; gap:8px; font-size:12.5px; color:var(--text-mute); margin-bottom:12px; }
  .stat-card .sk .icon{ width:14px; height:14px; }
  .stat-card .sv{ font-family:'Space Grotesk'; font-size:24px; font-weight:600; }
  .stat-card .sc{ font-size:12px; color:var(--text-faint); margin-top:4px; }
  .stat-card.acc-emerald{ border-color: rgba(var(--emerald-rgb),0.25); }
  .stat-card.acc-emerald .sk{ color: var(--emerald); }
  .stat-card.acc-info .sk{ color: var(--info); }
  .stat-card.acc-warning .sk{ color: var(--warning); }
  .stat-card.acc-danger .sk{ color: var(--danger); }

  /* ===== TOOLBAR ===== */
  .toolbar{ display:flex; align-items:center; gap:12px; margin-bottom:16px; flex-wrap:wrap; }
  .search-box{ flex:1; min-width:220px; position:relative; }
  .search-box .icon{ position:absolute; left:14px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:var(--text-faint); }
  .search-box input{
    width:100%; padding:11px 14px 11px 40px; border-radius:12px; background:var(--surface); border:1px solid var(--border);
    color:var(--text); font-size:13.5px; outline:none; transition:all .2s ease;
  }
  .search-box input:focus{ border-color:var(--border-hover); background:var(--surface-strong); }
  .filter-chip{
    display:inline-flex; align-items:center; gap:7px; padding:10px 14px; border-radius:12px; background:var(--surface);
    border:1px solid var(--border); font-size:13px; color:var(--text-mute); cursor:pointer; transition:all .2s ease; position:relative;
  }
  .filter-chip:hover{ border-color:var(--border-hover); color:var(--text); }
  .filter-chip.active{ border-color:var(--emerald); color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }
  .filter-chip .icon{ width:14px; height:14px; }
  .filter-chip .chevron{ width:12px; height:12px; margin-left:2px; }

  .filter-dropdown{
    position:absolute; top:calc(100% + 8px); left:0; min-width:190px; background:var(--modal-bg); border:1px solid var(--border);
    border-radius:14px; padding:8px; box-shadow:0 24px 60px rgba(0,0,0,0.4); z-index:30; opacity:0; visibility:hidden;
    transform:translateY(6px); transition: all .18s ease;
  }
  .filter-dropdown.open{ opacity:1; visibility:visible; transform:translateY(0); }
  .fd-item{ display:flex; align-items:center; gap:9px; padding:9px 10px; border-radius:9px; font-size:13px; color:var(--text-mute); cursor:pointer; transition:all .15s ease; }
  .fd-item:hover{ background:var(--surface-strong); color:var(--text); }
  .fd-item.active{ color:var(--text); }
  .fd-dot{ width:8px; height:8px; border-radius:50%; flex-shrink:0; }

  /* ===== BULK BAR ===== */
  .bulk-bar{
    display:none; align-items:center; justify-content:space-between; background:rgba(var(--emerald-rgb),0.08); border:1px solid rgba(var(--emerald-rgb),0.3);
    border-radius:14px; padding:12px 18px; margin-bottom:14px; font-size:13.5px;
  }
  .bulk-bar.show{ display:flex; }
  .bulk-bar b{ color:var(--emerald); }
  .bulk-actions{ display:flex; gap:8px; }

  /* ===== TABLE ===== */
  .table-card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden; }
  .table-scroll{ overflow-x:auto; }
  table{ width:100%; border-collapse:collapse; min-width:920px; }
  thead th{
    text-align:left; font-size:11.5px; text-transform:uppercase; letter-spacing:.05em; color:var(--text-faint);
    font-weight:600; padding:14px 18px; border-bottom:1px solid var(--border); white-space:nowrap;
  }
  thead th.sortable{ cursor:pointer; user-select:none; }
  thead th.sortable:hover{ color:var(--text-mute); }
  thead th .sort-ic{ width:11px; height:11px; margin-left:4px; opacity:.5; }
  tbody tr{ border-bottom:1px solid var(--border); transition: background .15s ease; }
  tbody tr:last-child{ border-bottom:none; }
  tbody tr:hover{ background:var(--surface-strong); }
  tbody td{ padding:14px 18px; font-size:13.5px; vertical-align:middle; }
  td.chk, th.chk{ width:44px; padding-left:18px; }
  input[type=checkbox]{
    width:17px; height:17px; border-radius:5px; accent-color:var(--emerald); cursor:pointer;
  }
  .inv-no{ font-family:'IBM Plex Mono'; font-size:13px; color:var(--text); }
  .client-cell{ display:flex; align-items:center; gap:10px; }
  .client-avatar{ width:32px; height:32px; border-radius:9px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:600; color:var(--text-mute); flex-shrink:0; }
  .client-name{ font-weight:600; font-size:13.5px; }
  .client-sub{ font-size:11.5px; color:var(--text-faint); }
  .amount-cell{ font-family:'Space Grotesk'; font-weight:600; }
  .date-cell{ color:var(--text-mute); font-size:13px; }
  .date-cell .overdue-flag{ color:var(--danger); font-size:11px; display:block; margin-top:2px; }

  .status-badge{ display:inline-flex; align-items:center; gap:6px; padding:5px 11px; border-radius:100px; font-size:12px; font-weight:600; }
  .status-badge .sdot{ width:6px; height:6px; border-radius:50%; }
  .status-draft{ background:var(--surface-strong); color:var(--text-mute); }
  .status-draft .sdot{ background:var(--text-faint); }
  .status-sent{ background:rgba(var(--info-rgb),0.12); color:var(--info); }
  .status-sent .sdot{ background:var(--info); }
  .status-paid{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
  .status-paid .sdot{ background:var(--emerald); }
  .status-overdue{ background:rgba(var(--danger-rgb),0.12); color:var(--danger); }
  .status-overdue .sdot{ background:var(--danger); }
  .status-cancelled{ background:var(--surface-strong); color:var(--text-faint); text-decoration:line-through; }
  .status-cancelled .sdot{ background:var(--text-faint); }

  .row-actions{ display:flex; align-items:center; gap:4px; justify-content:flex-end; position:relative; }
  .ra-btn{ width:32px; height:32px; border-radius:9px; background:transparent; border:none; display:flex; align-items:center; justify-content:center; color:var(--text-faint); cursor:pointer; transition:all .15s ease; }
  .ra-btn:hover{ background:var(--surface-strong); color:var(--text); }
  .ra-btn .icon{ width:15px; height:15px; }
  .row-menu{
    position:absolute; top:calc(100% + 6px); right:0; min-width:180px; background:var(--modal-bg); border:1px solid var(--border);
    border-radius:14px; padding:8px; box-shadow:0 24px 60px rgba(0,0,0,0.4); z-index:40; opacity:0; visibility:hidden;
    transform:translateY(6px); transition:all .18s ease;
  }
  .row-menu.open{ opacity:1; visibility:visible; transform:translateY(0); }
  .rm-item{ display:flex; align-items:center; gap:10px; padding:9px 11px; border-radius:9px; font-size:13px; color:var(--text-mute); cursor:pointer; transition:all .15s ease; width:100%; background:none; border:none; text-align:left; }
  .rm-item:hover{ background:var(--surface-strong); color:var(--text); }
  .rm-item.danger{ color:var(--danger); }
  .rm-item.danger:hover{ background:rgba(var(--danger-rgb),0.1); }
  .rm-item .icon{ width:14px; height:14px; }
  .rm-divider{ height:1px; background:var(--border); margin:6px 4px; }

  /* ===== EMPTY STATE ===== */
  .empty-state{ text-align:center; padding:70px 30px; }
  .empty-ic{ width:64px; height:64px; border-radius:18px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--text-faint); margin:0 auto 18px; }
  .empty-ic .icon{ width:28px; height:28px; }
  .empty-state h3{ font-size:17px; margin-bottom:6px; }
  .empty-state p{ font-size:13.5px; color:var(--text-mute); max-width:340px; margin:0 auto 20px; }

  /* ===== PAGINATION ===== */
  .pagination-bar{ display:flex; align-items:center; justify-content:space-between; padding:16px 18px; border-top:1px solid var(--border); flex-wrap:wrap; gap:12px; }
  .pg-info{ font-size:12.5px; color:var(--text-faint); }
  .pg-nav{ display:flex; gap:6px; }
  .pg-btn{ min-width:34px; height:34px; padding:0 10px; border-radius:9px; background:var(--surface); border:1px solid var(--border); color:var(--text-mute); font-size:13px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all .15s ease; }
  .pg-btn:hover{ border-color:var(--border-hover); color:var(--text); }
  .pg-btn.active{ background:var(--emerald); border-color:var(--emerald); color:#052117; font-weight:700; }
  .pg-btn:disabled{ opacity:.4; cursor:not-allowed; }

  /* ===== DELETE MODAL ===== */
  .modal-overlay{ position:fixed; inset:0; background:rgba(3,6,12,0.6); backdrop-filter:blur(4px); z-index:200; display:none; align-items:center; justify-content:center; padding:20px; }
  .modal-overlay.open{ display:flex; }
  .modal-box{ background:var(--modal-bg); border:1px solid var(--border); border-radius:20px; padding:28px; max-width:400px; width:100%; box-shadow:0 40px 90px rgba(0,0,0,0.5); }
  .modal-ic{ width:52px; height:52px; border-radius:14px; background:rgba(var(--danger-rgb),0.12); color:var(--danger); display:flex; align-items:center; justify-content:center; margin-bottom:16px; }
  .modal-ic .icon{ width:24px; height:24px; }
  .modal-box h3{ font-size:17px; margin-bottom:8px; }
  .modal-box p{ font-size:13.5px; color:var(--text-mute); margin-bottom:22px; }
  .modal-box p b{ color:var(--text); }
  .modal-actions{ display:flex; gap:10px; justify-content:flex-end; }

  @media (max-width: 1100px){
    .stat-row{ grid-template-columns:repeat(2,1fr); }
  }
  @media (max-width: 900px){
    .sidebar{ display:none; }
    .content{ padding:24px 18px 50px; }
    .stat-row{ grid-template-columns:1fr 1fr; gap:12px; }
  }
  @media (max-width: 560px){
    .stat-row{ grid-template-columns:1fr; }
    .page-head{ flex-direction:column; }
    .head-actions{ width:100%; }
    .head-actions .btn{ flex:1; }
  }
</style>
</head>
<body>

<svg width="0" height="0" style="position:absolute">
<defs>
  <symbol id="ic-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></symbol>
  <symbol id="ic-invoice" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="13" y2="17"/></symbol>
  <symbol id="ic-receive" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M2 12h20"/></symbol>
  <symbol id="ic-trending-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></symbol>
  <symbol id="ic-trending" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></symbol>
  <symbol id="ic-bank" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="21" x2="21" y2="21"/><line x1="5" y1="21" x2="5" y2="10"/><line x1="19" y1="21" x2="19" y2="10"/><polygon points="12 3 21 9 3 9"/></symbol>
  <symbol id="ic-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></symbol>
  <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
  <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="1"/><line x1="9" y1="7" x2="9" y2="7"/><line x1="15" y1="7" x2="15" y2="7"/><line x1="9" y1="12" x2="9" y2="12"/><line x1="15" y1="12" x2="15" y2="12"/><line x1="9" y1="17" x2="15" y2="17"/></symbol>
  <symbol id="ic-target" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></symbol>
  <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></symbol>
  <symbol id="ic-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></symbol>
  <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
  <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>
  <symbol id="ic-filter" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></symbol>
  <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></symbol>
  <symbol id="ic-download" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></symbol>
  <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
  <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/></symbol>
  <symbol id="ic-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></symbol>
  <symbol id="ic-copy" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></symbol>
  <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
  <symbol id="ic-dots-v" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="1.4"/><circle cx="12" cy="12" r="1.4"/><circle cx="12" cy="19" r="1.4"/></symbol>
  <symbol id="ic-bell" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></symbol>
  <symbol id="ic-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12" y2="17"/></symbol>
  <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></symbol>
</defs>
</svg>

<div class="app-shell">

  @include('layouts.navigation')

  <div class="main">
    <div class="topbar">
      <div class="topbar-title">Penjualan / <b>Semua Faktur</b></div>
      <div class="topbar-right">
        <div class="icon-btn"><svg class="icon"><use href="#ic-bell"/></svg></div>
        <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</div>
      </div>
    </div>

    <div class="content">

      {{-- ===== PAGE HEADER ===== --}}
      <div class="page-head">
        <div>
          <h1>Semua Faktur</h1>
          <p>Kelola, kirim, dan pantau status semua faktur penjualan {{ $company->name ?? 'perusahaanmu' }} di satu tempat.</p>
        </div>
        <div class="head-actions">
          <button type="button" class="btn btn-outline"><svg class="icon"><use href="#ic-download"/></svg> Ekspor</button>
          <a href="{{ route('invoices.create') }}" class="btn btn-primary"><svg class="icon"><use href="#ic-plus"/></svg> Buat Faktur</a>
        </div>
      </div>

      {{-- ===== STAT CARDS ===== --}}
      <div class="stat-row">
        <div class="stat-card acc-emerald">
          <div class="sk"><svg class="icon"><use href="#ic-invoice"/></svg> Total Faktur</div>
          <div class="sv mono">Rp{{ number_format($stats['total_amount'] ?? 0, 0, ',', '.') }}</div>
          <div class="sc">{{ $stats['total_count'] ?? 0 }} faktur bulan ini</div>
        </div>
        <div class="stat-card acc-emerald">
          <div class="sk"><svg class="icon"><use href="#ic-activity"/></svg> Sudah Dibayar</div>
          <div class="sv mono">Rp{{ number_format($stats['paid_amount'] ?? 0, 0, ',', '.') }}</div>
          <div class="sc">{{ $stats['paid_count'] ?? 0 }} faktur lunas</div>
        </div>
        <div class="stat-card acc-info">
          <div class="sk"><svg class="icon"><use href="#ic-send"/></svg> Menunggu Dibayar</div>
          <div class="sv mono">Rp{{ number_format($stats['outstanding_amount'] ?? 0, 0, ',', '.') }}</div>
          <div class="sc">{{ $stats['outstanding_count'] ?? 0 }} faktur terkirim</div>
        </div>
        <div class="stat-card acc-danger">
          <div class="sk"><svg class="icon"><use href="#ic-alert"/></svg> Jatuh Tempo</div>
          <div class="sv mono">Rp{{ number_format($stats['overdue_amount'] ?? 0, 0, ',', '.') }}</div>
          <div class="sc">{{ $stats['overdue_count'] ?? 0 }} faktur terlambat</div>
        </div>
      </div>

      {{-- ===== TOOLBAR ===== --}}
      <form method="GET" action="{{ route('invoices.index') }}" id="filterForm">
        <div class="toolbar">
          <div class="search-box">
            <svg class="icon"><use href="#ic-search"/></svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor faktur atau nama klien...">
          </div>

          <div class="filter-chip" data-dd-toggle="status" id="statusChip">
            <svg class="icon"><use href="#ic-filter"/></svg>
            <span id="statusChipLabel">{{ $statusLabels[request('status')] ?? 'Semua Status' }}</span>
            <svg class="icon chevron"><use href="#ic-chevron"/></svg>
            <div class="filter-dropdown" id="statusDropdown">
              <div class="fd-item {{ !request('status') ? 'active' : '' }}" data-status-opt="">
                <span class="fd-dot" style="background:var(--text-faint)"></span> Semua Status
              </div>
              <div class="fd-item {{ request('status')==='draft' ? 'active' : '' }}" data-status-opt="draft">
                <span class="fd-dot" style="background:var(--text-faint)"></span> Draft
              </div>
              <div class="fd-item {{ request('status')==='sent' ? 'active' : '' }}" data-status-opt="sent">
                <span class="fd-dot" style="background:var(--info)"></span> Terkirim
              </div>
              <div class="fd-item {{ request('status')==='paid' ? 'active' : '' }}" data-status-opt="paid">
                <span class="fd-dot" style="background:var(--emerald)"></span> Lunas
              </div>
              <div class="fd-item {{ request('status')==='overdue' ? 'active' : '' }}" data-status-opt="overdue">
                <span class="fd-dot" style="background:var(--danger)"></span> Jatuh Tempo
              </div>
              <div class="fd-item {{ request('status')==='cancelled' ? 'active' : '' }}" data-status-opt="cancelled">
                <span class="fd-dot" style="background:var(--text-faint)"></span> Dibatalkan
              </div>
            </div>
          </div>
          <input type="hidden" name="status" id="statusInput" value="{{ request('status') }}">

          <label class="filter-chip" style="cursor:pointer;">
            <svg class="icon"><use href="#ic-calendar"/></svg>
            <span>Periode</span>
            <input type="date" name="from" value="{{ request('from') }}" style="position:absolute;opacity:0;pointer-events:none;width:0;">
          </label>

          <button type="submit" class="btn btn-outline btn-sm">Terapkan</button>
          @if(request()->anyFilled(['q','status','from']))
            <a href="{{ route('invoices.index') }}" class="btn btn-ghost btn-sm">Reset</a>
          @endif
        </div>
      </form>

      {{-- ===== BULK ACTIONS BAR ===== --}}
      <div class="bulk-bar" id="bulkBar">
        <span><b id="bulkCount">0</b> faktur dipilih</span>
        <div class="bulk-actions">
          <button type="button" class="btn btn-outline btn-sm"><svg class="icon"><use href="#ic-send"/></svg> Kirim</button>
          <button type="button" class="btn btn-outline btn-sm"><svg class="icon"><use href="#ic-download"/></svg> Unduh PDF</button>
          <button type="button" class="btn btn-danger-ghost btn-sm" onclick="openBulkDeleteModal()"><svg class="icon"><use href="#ic-trash"/></svg> Hapus</button>
        </div>
      </div>

      {{-- ===== TABLE ===== --}}
      <div class="table-card">
        <div class="table-scroll">
          <table>
            <thead>
              <tr>
                <th class="chk"><input type="checkbox" id="checkAll"></th>
                <th class="sortable">No. Faktur</th>
                <th>Klien</th>
                <th class="sortable">Tanggal Terbit</th>
                <th class="sortable">Jatuh Tempo</th>
                <th class="sortable" style="text-align:right;">Jumlah</th>
                <th>Status</th>
                <th style="text-align:right;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($invoices as $invoice)
                @php
                  $isOverdue = $invoice->status === 'sent' && $invoice->due_date && \Carbon\Carbon::parse($invoice->due_date)->isPast();
                  $statusKey = $isOverdue ? 'overdue' : $invoice->status;
                  $statusMap = [
                    'draft'     => ['label' => 'Draft',        'class' => 'status-draft'],
                    'sent'      => ['label' => 'Terkirim',     'class' => 'status-sent'],
                    'paid'      => ['label' => 'Lunas',        'class' => 'status-paid'],
                    'overdue'   => ['label' => 'Jatuh Tempo',  'class' => 'status-overdue'],
                    'cancelled' => ['label' => 'Dibatalkan',   'class' => 'status-cancelled'],
                  ];
                  $st = $statusMap[$statusKey] ?? $statusMap['draft'];
                @endphp
                <tr>
                  <td class="chk"><input type="checkbox" class="rowCheck" value="{{ $invoice->id }}"></td>
                  <td><span class="inv-no">{{ $invoice->invoice_number }}</span></td>
                  <td>
                    <div class="client-cell">
                      <div class="client-avatar">{{ strtoupper(substr($invoice->client->name ?? '?', 0, 1)) }}</div>
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
                      <span class="overdue-flag">Terlambat {{ \Carbon\Carbon::parse($invoice->due_date)->diffInDays(now()) }} hari</span>
                    @endif
                  </td>
                  <td class="amount-cell mono" style="text-align:right;">Rp{{ number_format($invoice->total ?? 0, 0, ',', '.') }}</td>
                  <td>
                    <span class="status-badge {{ $st['class'] }}"><span class="sdot"></span>{{ $st['label'] }}</span>
                  </td>
                  <td>
                    <div class="row-actions">
                      <a href="{{ route('invoices.show', $invoice) }}" class="ra-btn" title="Lihat"><svg class="icon"><use href="#ic-eye"/></svg></a>
                      <a href="{{ route('invoices.edit', $invoice) }}" class="ra-btn" title="Edit"><svg class="icon"><use href="#ic-edit"/></svg></a>
                      <button type="button" class="ra-btn" title="Lainnya" data-row-menu-toggle="{{ $invoice->id }}"><svg class="icon"><use href="#ic-dots-v"/></svg></button>
                      <div class="row-menu" id="rowMenu-{{ $invoice->id }}">
                        <button type="button" class="rm-item"><svg class="icon"><use href="#ic-send"/></svg> Kirim ke klien</button>
                        <button type="button" class="rm-item"><svg class="icon"><use href="#ic-download"/></svg> Unduh PDF</button>
                        <button type="button" class="rm-item"><svg class="icon"><use href="#ic-copy"/></svg> Duplikat</button>
                        <div class="rm-divider"></div>
                        <button type="button" class="rm-item danger" onclick="openDeleteModal('{{ $invoice->id }}', '{{ $invoice->invoice_number }}')">
                          <svg class="icon"><use href="#ic-trash"/></svg> Hapus faktur
                        </button>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8">
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
            <div class="pg-nav">
              {{ $invoices->onEachSide(1)->links('pagination::simple-default') }}
            </div>
          </div>
        @endif
      </div>

    </div>
  </div>
</div>

{{-- ===== DELETE CONFIRM MODAL ===== --}}
<div class="modal-overlay" id="deleteModal">
  <div class="modal-box">
    <div class="modal-ic"><svg class="icon"><use href="#ic-alert"/></svg></div>
    <h3>Hapus faktur ini?</h3>
    <p>Faktur <b id="deleteInvoiceNo">—</b> akan dihapus permanen dan tidak bisa dikembalikan. Klien tidak akan bisa lagi mengakses tautan faktur ini.</p>
    <form method="POST" id="deleteForm">
      @csrf
      @method('DELETE')
      <div class="modal-actions">
        <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
        <button type="submit" class="btn" style="background:var(--danger); color:#fff;">Ya, Hapus</button>
      </div>
    </form>
  </div>
</div>

<script>
  // ===== status filter dropdown =====
  document.querySelectorAll('[data-dd-toggle]').forEach(function(chip){
    chip.addEventListener('click', function(e){
      e.stopPropagation();
      var dd = chip.querySelector('.filter-dropdown');
      var wasOpen = dd.classList.contains('open');
      document.querySelectorAll('.filter-dropdown.open').forEach(function(d){ d.classList.remove('open'); });
      dd.classList.toggle('open', !wasOpen);
    });
  });
  document.querySelectorAll('[data-status-opt]').forEach(function(item){
    item.addEventListener('click', function(){
      var val = item.getAttribute('data-status-opt');
      document.getElementById('statusInput').value = val;
      document.getElementById('statusChipLabel').textContent = item.textContent.trim();
      document.getElementById('filterForm').submit();
    });
  });

  // ===== row "more" menu =====
  document.querySelectorAll('[data-row-menu-toggle]').forEach(function(btn){
    btn.addEventListener('click', function(e){
      e.stopPropagation();
      var id = btn.getAttribute('data-row-menu-toggle');
      var menu = document.getElementById('rowMenu-'+id);
      var wasOpen = menu.classList.contains('open');
      document.querySelectorAll('.row-menu.open').forEach(function(m){ m.classList.remove('open'); });
      menu.classList.toggle('open', !wasOpen);
    });
  });

  document.addEventListener('click', function(){
    document.querySelectorAll('.filter-dropdown.open, .row-menu.open').forEach(function(el){ el.classList.remove('open'); });
  });

  // ===== select all / bulk bar =====
  var checkAll = document.getElementById('checkAll');
  var bulkBar = document.getElementById('bulkBar');
  var bulkCount = document.getElementById('bulkCount');

  function refreshBulkBar(){
    var checked = document.querySelectorAll('.rowCheck:checked');
    if(checked.length > 0){
      bulkBar.classList.add('show');
      bulkCount.textContent = checked.length;
    } else {
      bulkBar.classList.remove('show');
    }
  }
  if(checkAll){
    checkAll.addEventListener('change', function(){
      document.querySelectorAll('.rowCheck').forEach(function(cb){ cb.checked = checkAll.checked; });
      refreshBulkBar();
    });
  }
  document.querySelectorAll('.rowCheck').forEach(function(cb){
    cb.addEventListener('change', refreshBulkBar);
  });

  // ===== delete modal =====
  function openDeleteModal(id, invoiceNo){
    document.getElementById('deleteInvoiceNo').textContent = invoiceNo;
    document.getElementById('deleteForm').action = '{{ url("invoices") }}/' + id;
    document.getElementById('deleteModal').classList.add('open');
  }
  function closeDeleteModal(){
    document.getElementById('deleteModal').classList.remove('open');
  }
  function openBulkDeleteModal(){
    var ids = Array.from(document.querySelectorAll('.rowCheck:checked')).map(function(cb){ return cb.value; });
    document.getElementById('deleteInvoiceNo').textContent = ids.length + ' faktur terpilih';
    document.getElementById('deleteForm').action = '{{ route("invoices.bulk-destroy") }}';
    document.getElementById('deleteModal').classList.add('open');
  }
  document.getElementById('deleteModal').addEventListener('click', function(e){
    if(e.target === this) closeDeleteModal();
  });
</script>
</body>
</html>