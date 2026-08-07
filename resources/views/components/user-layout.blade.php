<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ isset($title) ? $title.' — ' : '' }}{{ $company->name ?? config('app.name', 'Arvessa') }}</title>

<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logos.png') }}">
<link rel="apple-touch-icon" href="{{ asset('logos.png') }}">

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

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
  /* ====== SAMA PERSIS DENGAN app.blade.php, di-copy biar konsisten tampilan ====== */
  :root{
    --bg: #070B13; --surface: rgba(255,255,255,0.04); --surface-strong: rgba(255,255,255,0.08);
    --border: rgba(255,255,255,0.09); --border-hover: rgba(var(--emerald-rgb),0.35);
    --emerald: #34E0A1; --emerald-dim: #1E8F6B; --blue: #4E8FF0;
    --text: #EAF0F6; --text-mute: #8A96AE; --text-faint: #545E73;
    --radius: 20px; --nav-bg: rgba(7,11,19,0.75); --modal-bg: linear-gradient(160deg, #0F1520, #0A0D14 60%);
    --emerald-rgb: 52,224,161; --glow1-a: 0.14; --glow2-a: 0.10; --danger: #E85A5A;
  }
  [data-theme="light"]{
    --bg: #F4F6FA; --surface: rgba(15,25,40,0.035); --surface-strong: rgba(15,25,40,0.07);
    --border: rgba(15,25,40,0.10); --border-hover: rgba(var(--emerald-rgb),0.45); --emerald-dim: #17A374;
    --text: #131A26; --text-mute: #565F72; --text-faint: #838C9E;
    --nav-bg: rgba(244,246,250,0.82); --modal-bg: linear-gradient(160deg, #FFFFFF, #F2F5F9 60%);
    --glow1-a: 0.18; --glow2-a: 0.13;
  }
  [data-accent="blue"]{ --emerald:#4E8FF0; --emerald-dim:#3465C4; --emerald-rgb:78,143,240; }
  [data-accent="purple"]{ --emerald:#9B7BE0; --emerald-dim:#6E4FBE; --emerald-rgb:155,123,224; }
  [data-accent="orange"]{ --emerald:#F0A25A; --emerald-dim:#C97A2E; --emerald-rgb:240,162,90; }
  [data-accent="pink"]{ --emerald:#E85A9C; --emerald-dim:#B83A78; --emerald-rgb:232,90,156; }

  *{margin:0;padding:0;box-sizing:border-box;}
  html{ color-scheme: dark; }
  html[data-theme="light"]{ color-scheme: light; }
  body{ background: var(--bg); color: var(--text); font-family:'Inter', sans-serif; line-height:1.5; transition: background .35s ease, color .35s ease; }
  h1,h2,h3,.display{ font-family:'Space Grotesk', sans-serif; letter-spacing:-0.02em; }
  .mono{ font-family:'IBM Plex Mono', monospace; }
  a{ text-decoration:none; color:inherit; }
  ul{ list-style:none; }
  svg{ display:block; }
  .icon{ width:1em; height:1em; }
  button{ font-family:inherit; }

  .bg-glow{ position:fixed; top:-25%; right:-10%; width:900px; height:900px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow1-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }
  .bg-glow-2{ position:fixed; bottom:-15%; left:-15%; width:700px; height:700px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow2-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }

  .app-shell{ display:grid; grid-template-columns:250px 1fr; min-height:100vh; position:relative; z-index:1; }

  .sidebar{ background:var(--nav-bg); backdrop-filter:blur(16px); border-right:1px solid var(--border); display:flex; flex-direction:column; padding:22px 16px; position:sticky; top:0; height:100vh; overflow-y:auto; transition: background .35s ease, border-color .35s ease; }
  .sb-logo{ display:flex; align-items:center; gap:11px; font-family:'Space Grotesk'; font-weight:700; font-size:18px; padding:6px 8px 26px; }
  .sb-logo .logo-mark{ width:38px; height:38px; border-radius:11px; background:var(--surface-strong); border:1px solid var(--border-hover); display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0; padding:4px; }
  .sb-logo .logo-mark img{ width:100%; height:100%; object-fit:contain; }
  .sb-logo .grad{ background:linear-gradient(90deg,var(--emerald),var(--emerald-dim)); -webkit-background-clip:text; background-clip:text; color:transparent; }

  .sb-group-label{ font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); padding:16px 12px 8px; }
  .sb-link{ display:flex; align-items:center; gap:12px; padding:11px 12px; border-radius:12px; font-size:14px; color:var(--text-mute); margin-bottom:2px; transition: all .2s ease; position:relative; }
  .sb-link .icon{ width:17px; height:17px; flex-shrink:0; }
  .sb-link:hover{ color:var(--text); background:var(--surface); }
  .sb-link.active{ color:var(--emerald); background:rgba(var(--emerald-rgb),0.1); font-weight:600; }
  .sb-link .badge{ margin-left:auto; font-size:10.5px; font-family:'IBM Plex Mono'; background:var(--surface-strong); color:var(--text-mute); padding:2px 7px; border-radius:100px; }
  .sb-link.active .badge{ background:rgba(var(--emerald-rgb),0.18); color:var(--emerald); }

  .sb-bottom{ margin-top:auto; padding-top:16px; border-top:1px solid var(--border); }
  .sb-plan{ background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:14px; margin-bottom:10px; }
  .sb-plan .lbl{ font-size:10.5px; color:var(--text-faint); margin-bottom:4px; }
  .sb-plan .name{ font-size:13.5px; font-weight:600; margin-bottom:10px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

  .topbar{ position:sticky; top:0; z-index:40; display:flex; align-items:center; justify-content:space-between; gap:20px; padding:16px 28px; background:var(--nav-bg); backdrop-filter:blur(16px); border-bottom:1px solid var(--border); }

  .search-box{ display:flex; align-items:center; gap:12px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 18px; width:480px; max-width:100%; transition: border-color .2s ease, background .2s ease, box-shadow .2s ease; position:relative; }
  .search-box:focus-within{ border-color:var(--border-hover); background:var(--surface-strong); box-shadow: 0 0 0 4px rgba(var(--emerald-rgb),0.1); }
  .search-box .icon{ width:18px; height:18px; color:var(--text-faint); flex-shrink:0; }
  .search-box input{ flex:1; min-width:0; background:none; border:none; outline:none; color:var(--text); font-size:14px; padding:4px 0; }
  .search-box input::placeholder{ color:var(--text-faint); }
  .search-box .kbd{ font-family:'IBM Plex Mono'; font-size:10.5px; color:var(--text-faint); background:var(--surface-strong); border:1px solid var(--border); border-radius:5px; padding:3px 8px; flex-shrink:0; }
  .search-box .clear-btn{ display:none; background:none; border:none; color:var(--text-faint); cursor:pointer; padding:4px; border-radius:50%; transition: all .2s ease; flex-shrink:0; }
  .search-box .clear-btn:hover{ background:var(--surface-strong); color:var(--text); }
  .search-box .clear-btn .icon{ width:16px; height:16px; }
  .search-box.has-value .clear-btn{ display:flex; }

  .search-results{ position:absolute; top:calc(100% + 8px); left:0; right:0; background:var(--modal-bg); border:1px solid var(--border); border-radius:12px; padding:8px 0; box-shadow:0 20px 60px rgba(0,0,0,0.4); opacity:0; visibility:hidden; transform:translateY(8px) scale(.97); transition:all .2s ease; z-index:100; max-height:400px; overflow-y:auto; }
  .search-results.open{ opacity:1; visibility:visible; transform:translateY(0) scale(1); }
  .search-results .result-item{ display:flex; align-items:center; gap:12px; padding:10px 16px; cursor:pointer; transition:background .15s ease; color:var(--text-mute); }
  .search-results .result-item:hover{ background:var(--surface-strong); color:var(--text); }
  .search-results .result-item .ri-icon{ width:32px; height:32px; border-radius:8px; background:var(--surface-strong); display:flex; align-items:center; justify-content:center; flex-shrink:0; color:var(--text-faint); }
  .search-results .result-item .ri-icon .icon{ width:16px; height:16px; }
  .search-results .result-item .ri-info{ flex:1; min-width:0; }
  .search-results .result-item .ri-title{ font-size:13px; font-weight:500; color:var(--text); }
  .search-results .result-item .ri-desc{ font-size:12px; color:var(--text-faint); }
  .search-results .result-item .ri-badge{ font-size:10px; font-weight:600; padding:2px 10px; border-radius:100px; background:var(--surface-strong); color:var(--text-faint); flex-shrink:0; }
  .search-results .result-empty{ padding:24px 16px; text-align:center; color:var(--text-faint); font-size:13px; }

  .topbar-right{ display:flex; align-items:center; gap:14px; flex-shrink:0; }
  .icon-btn{ width:38px; height:38px; border-radius:11px; background:var(--surface); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--text-mute); cursor:pointer; transition: all .2s ease; position:relative; flex-shrink:0; }
  .icon-btn:hover{ color:var(--text); background:var(--surface-strong); border-color:var(--border-hover); }
  .icon-btn .icon{ width:16px; height:16px; }
  .icon-btn .dot-alert{ position:absolute; top:8px; right:9px; width:7px; height:7px; border-radius:50%; background:var(--emerald); box-shadow:0 0 0 2px var(--nav-bg); }

  .user-menu{ position:relative; }
  .user-trigger{ display:flex; align-items:center; gap:9px; padding:5px 10px 5px 5px; border-radius:100px; border:1px solid var(--border); background:var(--surface); cursor:pointer; transition: all .2s ease; }
  .user-trigger:hover{ border-color:var(--border-hover); background:var(--surface-strong); }
  .user-avatar{ width:30px; height:30px; border-radius:50%; background:linear-gradient(135deg,var(--emerald),var(--emerald-dim)); display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk'; font-weight:700; font-size:12px; color:#052117; flex-shrink:0; overflow:hidden; }
  .user-avatar img{ width:100%; height:100%; object-fit:cover; }
  .user-trigger .name{ font-size:13px; font-weight:600; }
  .user-trigger .icon{ width:13px; height:13px; color:var(--text-faint); }

  .dropdown{ position:absolute; top:calc(100% + 10px); right:0; width:230px; background:var(--modal-bg); border:1px solid var(--border); border-radius:16px; padding:8px; box-shadow:0 30px 70px rgba(0,0,0,0.4); opacity:0; visibility:hidden; transform: translateY(8px) scale(.97); transition: all .2s ease; z-index:60; }
  .dropdown.open{ opacity:1; visibility:visible; transform: translateY(0) scale(1); }
  .dropdown-head{ padding:10px 12px 12px; border-bottom:1px solid var(--border); margin-bottom:6px; display:flex; align-items:center; gap:10px; }
  .dropdown-head-avatar{ width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,var(--emerald),var(--emerald-dim)); display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk'; font-weight:700; font-size:13px; color:#052117; flex-shrink:0; overflow:hidden; }
  .dropdown-head-avatar img{ width:100%; height:100%; object-fit:cover; }
  .dropdown-head .n{ font-size:13.5px; font-weight:600; }
  .dropdown-head .e{ font-size:11.5px; color:var(--text-faint); margin-top:2px; }
  .dropdown a, .dropdown button{ display:flex; align-items:center; gap:10px; width:100%; padding:9px 12px; border-radius:10px; font-size:13px; color:var(--text-mute); background:none; border:none; text-align:left; cursor:pointer; transition: all .15s ease; }
  .dropdown a:hover, .dropdown button:hover{ background:var(--surface-strong); color:var(--text); }
  .dropdown .icon{ width:15px; height:15px; }
  .dropdown .danger{ color:var(--danger); }
  .dropdown .danger:hover{ background:rgba(232,90,90,0.1); color:var(--danger); }
  .dropdown hr{ border:none; border-top:1px solid var(--border); margin:6px 0; }

  .notif-panel{ position:absolute; top:calc(100% + 10px); right:0; width:340px; max-height:420px; background:var(--modal-bg); border:1px solid var(--border); border-radius:16px; box-shadow:0 30px 70px rgba(0,0,0,0.4); opacity:0; visibility:hidden; transform: translateY(8px) scale(.97); transition: all .2s ease; z-index:60; overflow:hidden; display:flex; flex-direction:column; }
  .notif-panel.open{ opacity:1; visibility:visible; transform: translateY(0) scale(1); }
  .notif-panel-head{ display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-bottom:1px solid var(--border); flex-shrink:0; }
  .notif-panel-head h4{ margin:0; font-size:13.5px; font-weight:600; }
  .notif-panel-head button{ background:none; border:none; color:var(--emerald); font-size:12px; font-weight:600; cursor:pointer; padding:0; }
  .notif-list{ overflow-y:auto; max-height:340px; }
  .notif-item{ display:flex; gap:10px; padding:12px 16px; border-top:1px solid var(--border); cursor:pointer; transition: background .15s ease; }
  .notif-item:first-child{ border-top:none; }
  .notif-item:hover{ background:var(--surface-strong); }
  .notif-item.unread{ background:rgba(var(--emerald-rgb),0.05); }
  .notif-item .n-title{ font-size:13px; font-weight:600; margin-bottom:2px; color: var(--text-mute); }
  .notif-item.unread .n-title{ color: var(--danger); font-weight:700; }
  .notif-item .n-msg{ font-size:12px; color:var(--text-mute); line-height:1.4; }
  .notif-item .n-time{ font-size:11px; color:var(--text-faint); margin-top:4px; }
  .notif-empty{ padding:32px 16px; text-align:center; font-size:13px; color:var(--text-faint); }

  .sb-toggle{ display:none; width:38px; height:38px; border-radius:11px; background:var(--surface); border:1px solid var(--border); align-items:center; justify-content:center; color:var(--text); cursor:pointer; flex-shrink:0; }
  .sb-toggle .icon{ width:17px; height:17px; }

  main{ padding:28px; position:relative; z-index:1; }
  body.aj-modal-open main { z-index: 10001; }
  body.aj-modal-open .sidebar, body.aj-modal-open .topbar { backdrop-filter: none !important; }

  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:10px 18px; border-radius:11px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .22s ease; white-space:nowrap; }
  .btn .icon{ width:15px; height:15px; }
  .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 20px rgba(var(--emerald-rgb),0.3); }
  .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 10px 28px rgba(var(--emerald-rgb),0.45); }
  .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .btn-outline:hover{ background:var(--surface-strong); border-color:var(--border-hover); }

  @media (max-width: 1180px){ .search-box{ width:360px; } }
  @media (max-width: 980px){
    .app-shell{ grid-template-columns:1fr; }
    .sidebar{ position:fixed; left:0; top:0; width:250px; z-index:100; transform:translateX(-100%); transition: transform .3s cubic-bezier(.4,0,.2,1); }
    .sidebar.open{ transform:translateX(0); }
    .sb-toggle{ display:flex; }
    .search-box{ width:280px; }
  }
  @media (max-width: 768px){ .search-box{ width:200px; padding:8px 14px; } .search-box input{ font-size:13px; } .search-box .kbd{ display:none; } }
  @media (max-width: 640px){ .search-box{ display:none; } .topbar{ padding:14px 16px; } main{ padding:18px; } .notif-panel{ width:calc(100vw - 32px); right:-8px; } }

  .menu-backdrop{ display:none; position:fixed; inset:0; background:rgba(4,7,12,0.6); backdrop-filter:blur(2px); z-index:90; opacity:0; transition:opacity .3s ease; }
  .menu-backdrop.open{ display:block; opacity:1; }

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
  .accent-row{ display:flex; gap:9px; }
  .accent-dot{ width:26px; height:26px; border-radius:50%; cursor:pointer; border:2px solid transparent; position:relative; transition: transform .2s ease, border-color .2s ease; }
  .accent-dot:hover{ transform: scale(1.1); }
  .accent-dot.active{ border-color: var(--text); }
  .lang-row{ display:flex; gap:8px; }
  .lang-opt{ flex:1; padding:9px 6px; text-align:center; border-radius:12px; border:1px solid var(--border); background:var(--surface); color:var(--text-mute); font-size:12.5px; font-weight:600; cursor:pointer; transition: all .2s ease; }
  .lang-opt:hover{ color:var(--text); border-color:var(--border-hover); }
  .lang-opt.active{ color:var(--emerald); border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }
  @media (max-width:480px){ .settings-fab{ right:16px; bottom:16px; width:46px; height:46px; } .settings-panel{ right:16px; bottom:74px; width:calc(100vw - 32px); } }
</style>
</head>
<body class="font-sans antialiased">

<div class="bg-glow"></div>
<div class="bg-glow-2"></div>

<svg width="0" height="0" style="position:absolute">
<defs>
  <symbol id="ic-bell" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></symbol>
  <symbol id="ic-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 12 8 12 10 6 14 18 16 12 21 12"/></symbol>
  <symbol id="ic-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></symbol>
  <symbol id="ic-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></symbol>
  <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>
  <symbol id="ic-settings" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l-.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></symbol>
  <symbol id="ic-logout" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></symbol>
  <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/></symbol>
  <symbol id="ic-menu" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></symbol>
  <symbol id="ic-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></symbol>
  <symbol id="ic-gear" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l-.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></symbol>
  <symbol id="ic-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4.5"/><path d="M12 2v2.5M12 19.5V22M4.2 4.2l1.8 1.8M18 18l1.8 1.8M2 12h2.5M19.5 12H22M4.2 19.8 6 18M18 6l1.8-1.8"/></symbol>
  <symbol id="ic-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.5a8.5 8.5 0 1 1-9.5-11.4 7 7 0 0 0 9.5 11.4z"/></symbol>
</defs>
</svg>

<div class="menu-backdrop" id="menuBackdrop"></div>

<div class="app-shell">

  @include('layouts.user-navigation')

  <div>
    <header class="topbar">
      <div style="display:flex; align-items:center; gap:14px; flex:1; min-width:0;">
        <div class="sb-toggle" id="sbToggle" aria-label="Buka menu"><svg class="icon"><use href="#ic-menu"/></svg></div>
        <div class="search-box" id="searchBox">
          <svg class="icon"><use href="#ic-search"/></svg>
          <input type="text" id="searchInput" placeholder="Cari halaman..." autocomplete="off">
          <button class="clear-btn" id="searchClear" aria-label="Hapus pencarian"><svg class="icon"><use href="#ic-close"/></svg></button>
          <span class="kbd">⌘K</span>
          <div class="search-results" id="searchResults">
            <div class="result-empty">Mulai ketik untuk mencari halaman...</div>
          </div>
        </div>
      </div>
      <div class="topbar-right">
        <div class="user-menu">
          <div class="icon-btn" id="notifBtn" aria-label="Notifikasi">
            <svg class="icon"><use href="#ic-bell"/></svg>
            <span class="dot-alert" id="notifDot" style="display:none;"></span>
          </div>
          <div class="notif-panel" id="notifPanel">
            <div class="notif-panel-head">
              <h4>Notifikasi</h4>
              <button type="button" id="notifMarkAll">Tandai semua dibaca</button>
            </div>
            <div class="notif-list" id="notifList"><div class="notif-empty">Memuat notifikasi...</div></div>
          </div>
        </div>
        <div class="user-menu">
          <div class="user-trigger" id="userTrigger">
            <div class="user-avatar">
              @if(Auth::user()->profile_photo ?? false)
                <img src="{{ asset('storage/'.Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}">
              @else
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
              @endif
            </div>
            <span class="name">{{ Auth::user()->name ?? 'Pengguna' }}</span>
            <svg class="icon"><use href="#ic-chevron"/></svg>
          </div>
          <div class="dropdown" id="userDropdown">
            <div class="dropdown-head">
              <div class="dropdown-head-avatar">
                @if(Auth::user()->profile_photo ?? false)
                  <img src="{{ asset('storage/'.Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}">
                @else
                  {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                @endif
              </div>
              <div>
                <div class="n">{{ Auth::user()->name ?? 'Pengguna' }}</div>
                <div class="e">{{ Auth::user()->email ?? '' }}</div>
              </div>
            </div>
            <a href="{{ route('user.profile') }}"><svg class="icon"><use href="#ic-user"/></svg> Profil Saya</a>
            <hr>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="danger"><svg class="icon"><use href="#ic-logout"/></svg> Keluar</button>
            </form>
          </div>
        </div>
      </div>
    </header>

    @isset($header)
      <div class="page-header-simple"><h2>{{ $header }}</h2></div>
    @endisset

    <main>
      {{ $slot }}
    </main>
  </div>
</div>

<div class="settings-fab" id="settingsFab" aria-label="Pengaturan tampilan"><svg class="icon"><use href="#ic-gear"/></svg></div>
<div class="settings-panel" id="settingsPanel">
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
      <div class="accent-dot" data-accent-opt="emerald" style="background:#34E0A1" title="Emerald"></div>
      <div class="accent-dot" data-accent-opt="blue" style="background:#4E8FF0" title="Blue"></div>
      <div class="accent-dot" data-accent-opt="purple" style="background:#9B7BE0" title="Purple"></div>
      <div class="accent-dot" data-accent-opt="orange" style="background:#F0A25A" title="Orange"></div>
      <div class="accent-dot" data-accent-opt="pink" style="background:#E85A9C" title="Pink"></div>
    </div>
  </div>
</div>

<script>
  (function() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const searchClear = document.getElementById('searchClear');
    const searchBox = document.getElementById('searchBox');
    let searchTimeout = null;

    const pages = [
      { title: 'Dashboard', desc: 'Ringkasan & status pengajuan', icon: 'ic-activity', url: '{{ route('user.dashboard') }}' },
      { title: 'Ajukan Pengeluaran', desc: 'Kirim pengajuan pengeluaran baru', icon: 'ic-send', url: '{{ route('user.dashboard') }}#ajukan' },
      { title: 'Profil Saya', desc: 'Pengaturan akun pribadi', icon: 'ic-user', url: "{{ route('user.profile') }}" },
    ];

    function performSearch(query) {
      if (!query || query.length < 1) {
        searchResults.innerHTML = '<div class="result-empty">Mulai ketik untuk mencari halaman...</div>';
        searchResults.classList.remove('open');
        searchBox.classList.remove('has-value');
        return;
      }
      searchBox.classList.add('has-value');
      const lower = query.toLowerCase();
      const results = pages.filter(p => p.title.toLowerCase().includes(lower) || p.desc.toLowerCase().includes(lower));

      if (results.length === 0) {
        searchResults.innerHTML = `<div class="result-empty">Tidak ditemukan untuk "<strong>${query}</strong>"</div>`;
      } else {
        searchResults.innerHTML = results.map(p => `
          <div class="result-item" data-url="${p.url}">
            <div class="ri-icon"><svg class="icon"><use href="#${p.icon}"/></svg></div>
            <div class="ri-info"><div class="ri-title">${p.title}</div><div class="ri-desc">${p.desc}</div></div>
            <span class="ri-badge">Halaman</span>
          </div>`).join('');
        searchResults.querySelectorAll('.result-item').forEach(el => {
          el.addEventListener('click', function() { window.location.href = this.dataset.url; });
        });
      }
      searchResults.classList.add('open');
    }

    searchInput.addEventListener('input', function() {
      clearTimeout(searchTimeout);
      const query = this.value.trim();
      searchTimeout = setTimeout(() => performSearch(query), 200);
    });
    searchClear.addEventListener('click', function() {
      searchInput.value = ''; searchBox.classList.remove('has-value');
      searchResults.innerHTML = '<div class="result-empty">Mulai ketik untuk mencari halaman...</div>';
      searchResults.classList.remove('open'); searchInput.focus();
    });
    document.addEventListener('click', function(e) { if (!searchBox.contains(e.target)) searchResults.classList.remove('open'); });
    document.addEventListener('keydown', function(e) {
      if ((e.metaKey || e.ctrlKey) && e.key === 'k') { e.preventDefault(); searchInput.focus(); searchInput.select(); }
      if (e.key === 'Escape' && searchInput.value) {
        searchInput.value = ''; searchBox.classList.remove('has-value');
        searchResults.innerHTML = '<div class="result-empty">Mulai ketik untuk mencari halaman...</div>';
        searchResults.classList.remove('open'); searchInput.blur();
      }
    });
    searchInput.addEventListener('focus', function() { if (this.value.trim()) performSearch(this.value.trim()); });
  })();

  const userTrigger = document.getElementById('userTrigger');
  const userDropdown = document.getElementById('userDropdown');
  if(userTrigger && userDropdown){
    userTrigger.addEventListener('click', (e) => { e.stopPropagation(); userDropdown.classList.toggle('open'); });
    document.addEventListener('click', (e) => {
      if(userDropdown.classList.contains('open') && !userDropdown.contains(e.target) && e.target !== userTrigger){ userDropdown.classList.remove('open'); }
    });
  }

  (function(){
    const notifBtn = document.getElementById('notifBtn');
    const notifPanel = document.getElementById('notifPanel');
    const notifDot = document.getElementById('notifDot');
    const notifList = document.getElementById('notifList');
    const markAllBtn = document.getElementById('notifMarkAll');
    if(!notifBtn || !notifPanel) return;

    async function loadNotifications(){
      try{
        const res = await fetch('{{ route('notifications.index') }}', {
          credentials: 'same-origin',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
        });
        if(!res.ok) throw new Error('Gagal fetch: ' + res.status);
        const data = await res.json();
        renderDot(data.unread_count); renderList(data.notifications);
      }catch(err){ notifList.innerHTML = '<div class="notif-empty">Tidak ada notifikasi.</div>'; }
    }
    function renderDot(count){ notifDot.style.display = count > 0 ? 'block' : 'none'; }
    function renderList(items){
      if(!items.length){ notifList.innerHTML = '<div class="notif-empty">Tidak ada notifikasi.</div>'; return; }
      notifList.innerHTML = items.map(n => `
        <div class="notif-item ${n.is_read ? '' : 'unread'}" data-id="${n.id}" data-url="${n.url}">
          <div><div class="n-title">${n.title}</div><div class="n-msg">${n.message}</div><div class="n-time">${n.created_at}</div></div>
        </div>`).join('');
      notifList.querySelectorAll('.notif-item').forEach(el => {
        el.addEventListener('click', async () => {
          const id = el.dataset.id;
          try{
            const res = await fetch(`/notifications/${id}/read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' } });
            const d = await res.json(); renderDot(d.unread_count);
          }catch(err){}
          window.location.href = el.dataset.url;
        });
      });
    }
    notifBtn.addEventListener('click', (e) => { e.stopPropagation(); notifPanel.classList.toggle('open'); });
    document.addEventListener('click', (e) => {
      if(notifPanel.classList.contains('open') && !notifPanel.contains(e.target) && e.target !== notifBtn && !notifBtn.contains(e.target)){ notifPanel.classList.remove('open'); }
    });
    if(markAllBtn){
      markAllBtn.addEventListener('click', async () => {
        try{ await fetch('{{ route('notifications.readAll') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' } }); loadNotifications(); }catch(err){}
      });
    }
    loadNotifications();
    setInterval(loadNotifications, 30000);
  })();

  const sbToggle = document.getElementById('sbToggle');
  const sidebar = document.getElementById('sidebar');
  const menuBackdrop = document.getElementById('menuBackdrop');
  function openSidebar(){ sidebar.classList.add('open'); menuBackdrop.classList.add('open'); document.body.style.overflow='hidden'; }
  function closeSidebar(){ sidebar.classList.remove('open'); menuBackdrop.classList.remove('open'); document.body.style.overflow=''; }
  if(sbToggle) sbToggle.addEventListener('click', openSidebar);
  if(menuBackdrop) menuBackdrop.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', (e) => { if(e.key === 'Escape') closeSidebar(); });

  (function(){
    const root = document.documentElement;
    const fab = document.getElementById('settingsFab');
    const panel = document.getElementById('settingsPanel');
    function getSaved(key, fallback){ try{ return localStorage.getItem(key) || fallback; }catch(e){ return fallback; } }
    function save(key, val){ try{ localStorage.setItem(key, val); }catch(e){} }
    let theme = getSaved('aj-theme', 'dark');
    let accent = getSaved('aj-accent', 'emerald');
    function applyTheme(t){ theme = t; root.setAttribute('data-theme', t); save('aj-theme', t); document.querySelectorAll('.theme-opt').forEach(el => el.classList.toggle('active', el.getAttribute('data-theme-opt') === t)); }
    function applyAccent(a){ accent = a; root.setAttribute('data-accent', a); save('aj-accent', a); document.querySelectorAll('.accent-dot').forEach(el => el.classList.toggle('active', el.getAttribute('data-accent-opt') === a)); }
    applyTheme(theme); applyAccent(accent);
    if(fab && panel){
      fab.addEventListener('click', (e) => { e.stopPropagation(); panel.classList.toggle('open'); });
      document.addEventListener('click', (e) => { if(panel.classList.contains('open') && !panel.contains(e.target) && e.target !== fab){ panel.classList.remove('open'); } });
    }
    document.querySelectorAll('.theme-opt').forEach(el => el.addEventListener('click', () => applyTheme(el.getAttribute('data-theme-opt'))));
    document.querySelectorAll('.accent-dot').forEach(el => el.addEventListener('click', () => applyAccent(el.getAttribute('data-accent-opt'))));
  })();
</script>

{{ $scripts ?? '' }}

</body>
</html>