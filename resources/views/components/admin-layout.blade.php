<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ isset($title) ? $title.' — ' : '' }}Admin Arvessa</title>

<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logos.png') }}">
<link rel="apple-touch-icon" href="{{ asset('logos.png') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

<script>
  // Anti-flash: baca preferensi tema/aksen SEBELUM halaman dirender
  (function(){
    try{
      var t = localStorage.getItem('aj-theme') || 'dark';
      var a = localStorage.getItem('aj-accent') || 'orange';
      document.documentElement.setAttribute('data-theme', t);
      document.documentElement.setAttribute('data-accent', a);
    }catch(e){}
  })();
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
  :root{
    --bg:#070B13; --surface:rgba(255,255,255,0.04); --surface-strong:rgba(255,255,255,0.08);
    --border:rgba(255,255,255,0.09); --border-hover:rgba(var(--emerald-rgb),0.35);
    --emerald:#F0A25A; --emerald-dim:#C97A2E; --emerald-rgb:240,162,90;
    --text:#EAF0F6; --text-mute:#8A96AE; --text-faint:#545E73;
    --danger:#E85A5A; --danger-rgb:232,90,90; --radius:20px;
    --nav-bg:rgba(7,11,19,0.75);
    --modal-bg: linear-gradient(160deg, #0F1520, #0A0D14 60%);
  }
  [data-theme="light"]{
    --bg:#F4F6FA; --surface:rgba(15,25,40,0.035); --surface-strong:rgba(15,25,40,0.07);
    --border:rgba(15,25,40,0.10); --border-hover:rgba(var(--emerald-rgb),0.45);
    --text:#131A26; --text-mute:#565F72; --text-faint:#838C9E;
    --nav-bg:rgba(244,246,250,0.82);
    --modal-bg: linear-gradient(160deg, #FFFFFF, #F2F5F9 60%);
  }
  /* ===== ACCENT SWITCHER (sama seperti sisi user) ===== */
  [data-accent="orange"]{ --emerald:#F0A25A; --emerald-dim:#C97A2E; --emerald-rgb:240,162,90; }
  [data-accent="emerald"]{ --emerald:#34E0A1; --emerald-dim:#1E8F6B; --emerald-rgb:52,224,161; }
  [data-accent="blue"]{ --emerald:#4E8FF0; --emerald-dim:#3465C4; --emerald-rgb:78,143,240; }
  [data-accent="purple"]{ --emerald:#9B7BE0; --emerald-dim:#6E4FBE; --emerald-rgb:155,123,224; }
  [data-accent="pink"]{ --emerald:#E85A9C; --emerald-dim:#B83A78; --emerald-rgb:232,90,156; }

  *{margin:0;padding:0;box-sizing:border-box;}
  html{ color-scheme: dark; }
  html[data-theme="light"]{ color-scheme: light; }
  body{ background:var(--bg); color:var(--text); font-family:'Inter',sans-serif; line-height:1.5; transition: background .35s ease, color .35s ease; }
  h1,h2,h3{ font-family:'Space Grotesk',sans-serif; letter-spacing:-0.02em; }
  a{ text-decoration:none; color:inherit; }
  ul{ list-style:none; }
  .icon{ width:1em; height:1em; }
  button{ font-family:inherit; }

  .bg-glow{ position:fixed; top:-25%; right:-10%; width:900px; height:900px; background:radial-gradient(circle, rgba(var(--emerald-rgb),0.12) 0%, transparent 70%); pointer-events:none; z-index:0; }

  .admin-shell{ display:grid; grid-template-columns:240px 1fr; min-height:100vh; position:relative; z-index:1; }

  .admin-sidebar{ background:var(--nav-bg); backdrop-filter:blur(16px); border-right:1px solid var(--border); padding:22px 16px; position:sticky; top:0; height:100vh; overflow-y:auto; transition: background .35s ease, border-color .35s ease; }
  .admin-sidebar::-webkit-scrollbar{ width:5px; }
  .admin-sidebar::-webkit-scrollbar-thumb{ background:var(--border-hover); border-radius:100px; }
  .admin-logo{ display:flex; align-items:center; gap:12px; padding:6px 8px 26px; }
  .admin-logo .logo-mark{ width:38px; height:38px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border-hover); display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0; padding:6px; }
  .admin-logo .logo-mark img{ width:100%; height:100%; object-fit:contain; }
  .admin-wordmark{ font-family:'Inter', sans-serif; font-weight:800; font-size:17px; letter-spacing:-0.01em; white-space:nowrap; color:var(--text); }
  .admin-wordmark .grad{ color:var(--emerald); }
  .admin-wordmark .tag{ display:block; font-size:10px; font-weight:600; color:var(--text-faint); letter-spacing:.06em; text-transform:uppercase; margin-top:1px; }

  .admin-nav-label{ font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); padding:14px 12px 8px; }
  .admin-link{ display:flex; align-items:center; gap:12px; padding:11px 12px; border-radius:12px; font-size:14px; color:var(--text-mute); margin-bottom:2px; transition:all .2s ease; }
  .admin-link:hover{ color:var(--text); background:var(--surface); }
  .admin-link.active{ color:var(--emerald); background:rgba(var(--emerald-rgb),0.1); font-weight:600; }
  .admin-link .icon{ width:16px; height:16px; flex-shrink:0; }

  /* ===== Sidebar item "Segera" (belum aktif) ===== */
  .admin-link.soon{ color:var(--text-faint); cursor:default; pointer-events:none; }
  .admin-link.soon:hover{ background:none; color:var(--text-faint); }
  .admin-link .badge-soon{
    margin-left:auto; font-size:9.5px; font-weight:700; text-transform:uppercase; letter-spacing:.03em;
    color:var(--text-faint); background:var(--surface-strong); padding:2px 7px; border-radius:100px; flex-shrink:0;
  }

  .admin-topbar{ position:sticky; top:0; z-index:40; display:flex; align-items:center; justify-content:space-between; gap:20px; padding:16px 28px; background:var(--nav-bg); backdrop-filter:blur(16px); border-bottom:1px solid var(--border); }
  .admin-title-badge{ display:inline-flex; align-items:center; gap:8px; font-size:12px; font-weight:700; color:var(--emerald); background:rgba(var(--emerald-rgb),0.12); padding:6px 12px; border-radius:100px; }

  .admin-topbar-right{ display:flex; align-items:center; gap:14px; flex-shrink:0; }

  /* ===== ICON BUTTON (notifikasi) ===== */
  .icon-btn{ width:38px; height:38px; border-radius:11px; background:var(--surface); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--text-mute); cursor:pointer; transition: all .2s ease; position:relative; flex-shrink:0; }
  .icon-btn:hover{ color:var(--text); background:var(--surface-strong); border-color:var(--border-hover); }
  .icon-btn .icon{ width:16px; height:16px; }
  .icon-btn .dot-alert{ position:absolute; top:8px; right:9px; width:7px; height:7px; border-radius:50%; background:var(--emerald); box-shadow:0 0 0 2px var(--nav-bg); }

  /* ===== NOTIFIKASI PANEL ===== */
  .user-menu{ position:relative; }
  .notif-panel{ position:absolute; top:calc(100% + 10px); right:0; width:320px; max-height:400px; background:var(--modal-bg); border:1px solid var(--border); border-radius:16px; box-shadow:0 30px 70px rgba(0,0,0,0.4); opacity:0; visibility:hidden; transform: translateY(8px) scale(.97); transition: all .2s ease; z-index:60; overflow:hidden; display:flex; flex-direction:column; }
  .notif-panel.open{ opacity:1; visibility:visible; transform: translateY(0) scale(1); }
  .notif-panel-head{ display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-bottom:1px solid var(--border); flex-shrink:0; }
  .notif-panel-head h4{ margin:0; font-size:13.5px; font-weight:600; }
  .notif-empty{ padding:32px 16px; text-align:center; font-size:13px; color:var(--text-faint); }
  .notif-item{ display:flex; gap:10px; padding:12px 16px; border-top:1px solid var(--border); cursor:pointer; transition: background .15s ease; }
  .notif-item:first-child{ border-top:none; }
  .notif-item:hover{ background:var(--surface-strong); }
  .notif-item.unread{ background:rgba(var(--emerald-rgb),0.05); }
  .notif-item .n-ic{ width:34px; height:34px; border-radius:10px; background:var(--surface-strong); display:flex; align-items:center; justify-content:center; color:var(--text-mute); flex-shrink:0; }
  .notif-item .n-ic .icon{ width:15px; height:15px; }
  .notif-item .n-title{ font-size:13px; font-weight:600; margin-bottom:2px; color:var(--text); }
  .notif-item .n-msg{ font-size:12px; color:var(--text-mute); line-height:1.4; }
  .notif-item .n-time{ font-size:11px; color:var(--text-faint); margin-top:4px; }

  /* ===== USER DROPDOWN ===== */
  .user-trigger{ display:flex; align-items:center; gap:9px; padding:5px 10px 5px 5px; border-radius:100px; border:1px solid var(--border); background:var(--surface); cursor:pointer; transition: all .2s ease; }
  .user-trigger:hover{ border-color:var(--border-hover); background:var(--surface-strong); }
  .user-avatar{ width:30px; height:30px; border-radius:50%; background:linear-gradient(135deg,var(--emerald),var(--emerald-dim)); display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk'; font-weight:700; font-size:12px; color:#1a1005; flex-shrink:0; }
  .user-trigger .name{ font-size:13px; font-weight:600; }
  .user-trigger .icon{ width:13px; height:13px; color:var(--text-faint); }

  .dropdown{ position:absolute; top:calc(100% + 10px); right:0; width:220px; background:var(--modal-bg); border:1px solid var(--border); border-radius:16px; padding:8px; box-shadow:0 30px 70px rgba(0,0,0,0.4); opacity:0; visibility:hidden; transform: translateY(8px) scale(.97); transition: all .2s ease; z-index:60; }
  .dropdown.open{ opacity:1; visibility:visible; transform: translateY(0) scale(1); }
  .dropdown-head{ padding:10px 12px 12px; border-bottom:1px solid var(--border); margin-bottom:6px; }
  .dropdown-head .n{ font-size:13.5px; font-weight:600; }
  .dropdown-head .e{ font-size:11.5px; color:var(--text-faint); margin-top:2px; }
  .dropdown a, .dropdown button{ display:flex; align-items:center; gap:10px; width:100%; padding:9px 12px; border-radius:10px; font-size:13px; color:var(--text-mute); background:none; border:none; text-align:left; cursor:pointer; transition: all .15s ease; }
  .dropdown a:hover, .dropdown button:hover{ background:var(--surface-strong); color:var(--text); }
  .dropdown .icon{ width:15px; height:15px; flex-shrink:0; }
  .dropdown .danger{ color:var(--danger); }
  .dropdown .danger:hover{ background:rgba(232,90,90,0.1); color:var(--danger); }
  .dropdown hr{ border:none; border-top:1px solid var(--border); margin:6px 0; }
  .dropdown a.soon{ color:var(--text-faint); pointer-events:none; cursor:default; }
  .dropdown a.soon .badge-soon{
    margin-left:auto; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:.03em;
    color:var(--text-faint); background:var(--surface-strong); padding:2px 6px; border-radius:100px; flex-shrink:0;
  }

  main{ padding:28px; position:relative; z-index:1; }

  /* ===== FLOATING SETTINGS WIDGET (multi warna) ===== */
  .settings-fab{ position:fixed; right:22px; bottom:22px; z-index:150; width:50px; height:50px; border-radius:50%; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; cursor:pointer; color:var(--text); box-shadow:0 10px 30px rgba(0,0,0,0.35); backdrop-filter:blur(10px); transition: transform .25s ease, border-color .25s ease; }
  .settings-fab:hover{ transform: translateY(-3px) rotate(20deg); border-color:var(--border-hover); }
  .settings-fab .icon{ width:20px; height:20px; }
  .settings-panel{ position:fixed; right:22px; bottom:82px; z-index:150; width:250px; background:var(--modal-bg); border:1px solid var(--border); border-radius:18px; padding:18px; box-shadow:0 30px 70px rgba(0,0,0,0.45); opacity:0; visibility:hidden; transform: translateY(10px) scale(.97); transition: opacity .22s ease, transform .22s ease, visibility .22s; }
  .settings-panel.open{ opacity:1; visibility:visible; transform: translateY(0) scale(1); }
  .settings-panel h4{ font-size:11.5px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); margin-bottom:10px; }
  .settings-block{ margin-bottom:18px; }
  .settings-block:last-child{ margin-bottom:0; }
  .theme-toggle-row{ display:flex; gap:8px; }
  .theme-opt{ flex:1; display:flex; flex-direction:column; align-items:center; gap:5px; padding:10px 6px; border-radius:12px; border:1px solid var(--border); background:var(--surface); color:var(--text-mute); font-size:11px; cursor:pointer; transition: all .2s ease; }
  .theme-opt .icon{ width:15px; height:15px; }
  .theme-opt:hover{ color:var(--text); border-color:var(--border-hover); }
  .theme-opt.active{ color:var(--emerald); border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }
  .accent-row{ display:flex; gap:9px; flex-wrap:wrap; }
  .accent-dot{ width:26px; height:26px; border-radius:50%; cursor:pointer; border:2px solid transparent; position:relative; transition: transform .2s ease, border-color .2s ease; }
  .accent-dot:hover{ transform: scale(1.1); }
  .accent-dot.active{ border-color: var(--text); }
  .lang-row{ display:flex; gap:8px; }
  .lang-opt{ flex:1; padding:9px 6px; text-align:center; border-radius:12px; border:1px solid var(--border); background:var(--surface); color:var(--text-mute); font-size:12.5px; font-weight:600; cursor:pointer; transition: all .2s ease; }
  .lang-opt:hover{ color:var(--text); border-color:var(--border-hover); }
  .lang-opt.active{ color:var(--emerald); border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }

  @media (max-width:900px){
    .admin-shell{ grid-template-columns:1fr; }
    .admin-sidebar{ display:none; }
  }
  @media (max-width:480px){
    .settings-fab{ right:16px; bottom:16px; width:46px; height:46px; }
    .settings-panel{ right:16px; bottom:74px; width:calc(100vw - 32px); }
  }
</style>
</head>
<body>

<div class="bg-glow"></div>

<svg width="0" height="0" style="position:absolute">
<defs>
  <symbol id="ic-a-dashboard" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></symbol>
  <symbol id="ic-a-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
  <symbol id="ic-a-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/></symbol>
  <symbol id="ic-a-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 12 8 12 10 6 14 18 16 12 21 12"/></symbol>
  <symbol id="ic-a-logout" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></symbol>
  <symbol id="ic-bell" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></symbol>
  <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></symbol>
  <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
  <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/></symbol>
  <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/></symbol>
  <symbol id="ic-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></symbol>
  <symbol id="ic-gear" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l-.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></symbol>
  <symbol id="ic-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4.5"/><path d="M12 2v2.5M12 19.5V22M4.2 4.2l1.8 1.8M18 18l1.8 1.8M2 12h2.5M19.5 12H22M4.2 19.8 6 18M18 6l1.8-1.8"/></symbol>
  <symbol id="ic-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.5a8.5 8.5 0 1 1-9.5-11.4 7 7 0 0 0 9.5 11.4z"/></symbol>
  <symbol id="ic-a-history" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 3-6.7"/><polyline points="3 4 3 9 8 9"/><polyline points="12 7 12 12 16 14"/></symbol>
  <symbol id="ic-a-card" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/><line x1="6" y1="15" x2="10" y2="15"/></symbol>
  <symbol id="ic-a-megaphone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11v2a2 2 0 0 0 2 2h1l3 5V6L6 11H5a2 2 0 0 0-2 2z"/><path d="M13 8a4 4 0 0 1 0 8"/><path d="M18 5a8 8 0 0 1 0 14"/></symbol>
  <symbol id="ic-a-help" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 2-3 4"/><line x1="12" y1="17" x2="12.01" y2="17"/></symbol>
  <symbol id="ic-a-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></symbol>
</defs>
</svg>

<div class="admin-shell">

  <div class="admin-sidebar">
    <div class="admin-logo">
      <span class="logo-mark">
        <img src="{{ asset('logos.png') }}" alt="Arvessa">
      </span>
      <span class="admin-wordmark">
        Arves<span class="grad">sa</span>
        <span class="tag">Admin Panel</span>
      </span>
    </div>

    <div class="admin-nav-label">Menu</div>
    <a href="{{ route('admin.dashboard') }}" class="admin-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <svg class="icon"><use href="#ic-a-dashboard"/></svg> Dashboard
    </a>
    <a href="{{ route('admin.users.index') }}" class="admin-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
      <svg class="icon"><use href="#ic-a-users"/></svg> Kelola User
    </a>
    <a href="{{ route('admin.companies.index') }}" class="admin-link {{ request()->routeIs('admin.companies.*') ? 'active' : '' }}">
      <svg class="icon"><use href="#ic-a-building"/></svg> Kelola Company
    </a>
    <a href="{{ route('admin.stats.index') }}" class="admin-link {{ request()->routeIs('admin.stats.*') ? 'active' : '' }}">
      <svg class="icon"><use href="#ic-a-activity"/></svg> Statistik Sistem
    </a>

    {{-- ===== RENCANA PENGEMBANGAN — belum aktif, tinggal pengingat ===== --}}
    <a href="{{ route('admin.activity.index') }}" class="admin-link {{ request()->routeIs('admin.activity.*') ? 'active' : '' }}">
      <svg class="icon"><use href="#ic-a-history"/></svg> Log Aktivitas
    </a>
    <a href="{{ route('admin.subscription-plans.index') }}" class="admin-link {{ request()->routeIs('admin.subscription-plans.*') ? 'active' : '' }}">
      <svg class="icon"><use href="#ic-a-card"/></svg> Kelola Langganan
    </a>
    <a href="{{ route('admin.settings.index') }}" class="admin-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
      <svg class="icon"><use href="#ic-gear"/></svg> Pengaturan Sistem
    </a>
    <a href="{{ route('admin.announcements.index') }}" class="admin-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
      <svg class="icon"><use href="#ic-a-megaphone"/></svg> Broadcast Pengumuman
    </a>
    <a href="#" class="admin-link soon">
      <svg class="icon"><use href="#ic-a-help"/></svg> Support / Tiket
      <span class="badge-soon">Segera</span>
    </a>
  </div>

  <div>
    <header class="admin-topbar">
      <div class="admin-title-badge">🛡️ Panel Admin Sistem</div>

      <div class="admin-topbar-right">
        {{-- ===== NOTIFIKASI (tersambung ke data asli) ===== --}}
        <div class="user-menu">
          <div class="icon-btn" id="adminNotifBtn" aria-label="Notifikasi">
            <svg class="icon"><use href="#ic-bell"/></svg>
            <span class="dot-alert" id="adminNotifDot" style="display:none;"></span>
          </div>
          <div class="notif-panel" id="adminNotifPanel">
            <div class="notif-panel-head">
              <h4>Notifikasi</h4>
              <button type="button" id="adminNotifMarkAll" style="background:none;border:none;color:var(--emerald);font-size:12px;font-weight:600;cursor:pointer;">Tandai semua dibaca</button>
            </div>
            <div class="notif-list" id="adminNotifList" style="overflow-y:auto;max-height:320px;">
              <div class="notif-empty">Memuat notifikasi...</div>
            </div>
          </div>
        </div>

        {{-- ===== USER DROPDOWN ===== --}}
        <div class="user-menu">
          <div class="user-trigger" id="adminUserTrigger">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
            <span class="name">{{ Auth::user()->name ?? 'Admin' }}</span>
            <svg class="icon"><use href="#ic-chevron"/></svg>
          </div>
          <div class="dropdown" id="adminUserDropdown">
            <div class="dropdown-head">
              <div class="n">{{ Auth::user()->name ?? 'Admin' }}</div>
              <div class="e">{{ Auth::user()->email ?? '' }}</div>
            </div>
            <a href="{{ \Route::has('admin.profile.edit') ? route('admin.profile.edit') : '#' }}">
              <svg class="icon"><use href="#ic-user"/></svg> Lihat Profil
            </a>
            <a href="{{ \Route::has('admin.security.index') ? route('admin.security.index') : '#' }}">
              <svg class="icon"><use href="#ic-a-lock"/></svg> Keamanan Akun
            </a>
            <hr>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="danger">
                <svg class="icon"><use href="#ic-a-logout"/></svg> Keluar
              </button>
            </form>
          </div>
        </div>
      </div>
    </header>

    <main>
      {{ $slot }}
    </main>
  </div>

</div>

{{-- ===== FLOATING SETTINGS WIDGET (multi warna, tema, bahasa) ===== --}}
<div class="settings-fab" id="adminSettingsFab" aria-label="Pengaturan tampilan"><svg class="icon"><use href="#ic-gear"/></svg></div>
<div class="settings-panel" id="adminSettingsPanel">
  <div class="settings-block">
    <h4>Tampilan</h4>
    <div class="theme-toggle-row">
      <div class="theme-opt" data-theme-opt="dark"><svg class="icon"><use href="#ic-moon"/></svg><span>Gelap</span></div>
      <div class="theme-opt" data-theme-opt="light"><svg class="icon"><use href="#ic-sun"/></svg><span>Terang</span></div>
    </div>
  </div>
  <div class="settings-block">
    <h4>Warna tema</h4>
    <div class="accent-row">
      <div class="accent-dot" data-accent-opt="orange" style="background:#F0A25A" title="Orange"></div>
      <div class="accent-dot" data-accent-opt="emerald" style="background:#34E0A1" title="Emerald"></div>
      <div class="accent-dot" data-accent-opt="blue" style="background:#4E8FF0" title="Blue"></div>
      <div class="accent-dot" data-accent-opt="purple" style="background:#9B7BE0" title="Purple"></div>
      <div class="accent-dot" data-accent-opt="pink" style="background:#E85A9C" title="Pink"></div>
    </div>
  </div>
  <div class="settings-block">
    <h4>Bahasa</h4>
    <div class="lang-row">
      <div class="lang-opt" data-lang-opt="id">Indonesia</div>
      <div class="lang-opt" data-lang-opt="en">English</div>
    </div>
  </div>
</div>

<script>
  // ===== notifikasi dropdown (tersambung ke data asli) =====
  (function(){
    var btn      = document.getElementById('adminNotifBtn');
    var panel    = document.getElementById('adminNotifPanel');
    var dot      = document.getElementById('adminNotifDot');
    var list     = document.getElementById('adminNotifList');
    var markAllBtn = document.getElementById('adminNotifMarkAll');
    if(!btn || !panel) return;

    function renderDot(count){
      dot.style.display = count > 0 ? 'block' : 'none';
    }

    function renderList(items){
      if(!items.length){
        list.innerHTML = '<div class="notif-empty">Belum ada notifikasi.</div>';
        return;
      }
      list.innerHTML = items.map(function(n){
        return '' +
          '<div class="notif-item ' + (n.is_read ? '' : 'unread') + '" data-id="' + n.id + '" data-url="' + n.url + '">' +
            '<div class="n-ic"><svg class="icon"><use href="#ic-' + n.icon + '"/></svg></div>' +
            '<div>' +
              '<div class="n-title">' + n.title + '</div>' +
              '<div class="n-msg">' + n.message + '</div>' +
              '<div class="n-time">' + n.created_at + '</div>' +
            '</div>' +
          '</div>';
      }).join('');

      list.querySelectorAll('.notif-item').forEach(function(el){
        el.addEventListener('click', function(){
          var id = el.getAttribute('data-id');
          fetch('{{ url("admin/notifications") }}/' + id + '/read', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
              'Accept': 'application/json'
            }
          })
          .then(function(res){ return res.json(); })
          .then(function(d){ renderDot(d.unread_count); })
          .catch(function(err){ console.error('Gagal tandai dibaca:', err); });

          var url = el.getAttribute('data-url');
          if(url && url !== '#'){ window.location.href = url; }
        });
      });
    }

    function loadNotifications(){
      fetch('{{ route("admin.notifications.index") }}', {
        headers: { 'Accept': 'application/json' }
      })
      .then(function(res){
        if(!res.ok) throw new Error('Gagal fetch: ' + res.status);
        return res.json();
      })
      .then(function(data){
        renderDot(data.unread_count);
        renderList(data.notifications);
      })
      .catch(function(err){
        console.error('Gagal memuat notifikasi:', err);
        list.innerHTML = '<div class="notif-empty">Gagal memuat notifikasi.</div>';
      });
    }

    btn.addEventListener('click', function(e){
      e.stopPropagation();
      panel.classList.toggle('open');
    });
    document.addEventListener('click', function(e){
      if(panel.classList.contains('open') && !panel.contains(e.target) && e.target !== btn && !btn.contains(e.target)){
        panel.classList.remove('open');
      }
    });

    if(markAllBtn){
      markAllBtn.addEventListener('click', function(){
        fetch('{{ route("admin.notifications.readAll") }}', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
          }
        })
        .then(function(){ loadNotifications(); })
        .catch(function(err){ console.error('Gagal tandai semua:', err); });
      });
    }

    loadNotifications();
    setInterval(loadNotifications, 30000);
  })();

  // ===== user dropdown =====
  (function(){
    var trigger = document.getElementById('adminUserTrigger');
    var dropdown = document.getElementById('adminUserDropdown');
    if(!trigger || !dropdown) return;
    trigger.addEventListener('click', function(e){
      e.stopPropagation();
      dropdown.classList.toggle('open');
    });
    document.addEventListener('click', function(e){
      if(dropdown.classList.contains('open') && !dropdown.contains(e.target) && e.target !== trigger){
        dropdown.classList.remove('open');
      }
    });
  })();

  // ===== SETTINGS WIDGET: theme, accent, language =====
  (function(){
    var root = document.documentElement;
    var fab = document.getElementById('adminSettingsFab');
    var panel = document.getElementById('adminSettingsPanel');

    function getSaved(key, fallback){ try{ return localStorage.getItem(key) || fallback; }catch(e){ return fallback; } }
    function save(key, val){ try{ localStorage.setItem(key, val); }catch(e){} }

    var theme = getSaved('aj-theme', 'dark');
    var accent = getSaved('aj-accent', 'orange');

    function applyTheme(t){
      theme = t; root.setAttribute('data-theme', t); save('aj-theme', t);
      document.querySelectorAll('.theme-opt').forEach(function(el){ el.classList.toggle('active', el.getAttribute('data-theme-opt') === t); });
    }
    function applyAccent(a){
      accent = a; root.setAttribute('data-accent', a); save('aj-accent', a);
      document.querySelectorAll('.accent-dot').forEach(function(el){ el.classList.toggle('active', el.getAttribute('data-accent-opt') === a); });
    }
    applyTheme(theme);
    applyAccent(accent);

    if(fab && panel){
      fab.addEventListener('click', function(e){ e.stopPropagation(); panel.classList.toggle('open'); });
      document.addEventListener('click', function(e){
        if(panel.classList.contains('open') && !panel.contains(e.target) && e.target !== fab){ panel.classList.remove('open'); }
      });
    }
    document.querySelectorAll('.theme-opt').forEach(function(el){ el.addEventListener('click', function(){ applyTheme(el.getAttribute('data-theme-opt')); }); });
    document.querySelectorAll('.accent-dot').forEach(function(el){ el.addEventListener('click', function(){ applyAccent(el.getAttribute('data-accent-opt')); }); });

    document.querySelectorAll('.lang-opt').forEach(function(el){
      el.addEventListener('click', function(){
        var l = el.getAttribute('data-lang-opt');
        save('aj-lang', l);
        document.querySelectorAll('.lang-opt').forEach(function(o){ o.classList.toggle('active', o === el); });
      });
    });
    document.querySelectorAll('.lang-opt').forEach(function(el){
      el.classList.toggle('active', el.getAttribute('data-lang-opt') === getSaved('aj-lang', 'id'));
    });
  })();
</script>

</body>
</html>