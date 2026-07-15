<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ isset($title) ? $title.' — ' : '' }}{{ $company->name ?? config('app.name', 'Arthajaya') }}</title>

<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo.png') }}">
<link rel="apple-touch-icon" href="{{ asset('logo.png') }}">

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
  :root{
    --bg: #070B13;
    --surface: rgba(255,255,255,0.04);
    --surface-strong: rgba(255,255,255,0.08);
    --border: rgba(255,255,255,0.09);
    --border-hover: rgba(var(--emerald-rgb),0.35);
    --emerald: #34E0A1;
    --emerald-dim: #1E8F6B;
    --blue: #4E8FF0;
    --text: #EAF0F6;
    --text-mute: #8A96AE;
    --text-faint: #545E73;
    --radius: 20px;
    --nav-bg: rgba(7,11,19,0.75);
    --modal-bg: linear-gradient(160deg, #0F1520, #0A0D14 60%);
    --emerald-rgb: 52,224,161;
    --glow1-a: 0.14;
    --glow2-a: 0.10;
    --danger: #E85A5A;
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
    --nav-bg: rgba(244,246,250,0.82);
    --modal-bg: linear-gradient(160deg, #FFFFFF, #F2F5F9 60%);
    --glow1-a: 0.18;
    --glow2-a: 0.13;
  }
  [data-accent="blue"]{ --emerald:#4E8FF0; --emerald-dim:#3465C4; --emerald-rgb:78,143,240; }
  [data-accent="purple"]{ --emerald:#9B7BE0; --emerald-dim:#6E4FBE; --emerald-rgb:155,123,224; }
  [data-accent="orange"]{ --emerald:#F0A25A; --emerald-dim:#C97A2E; --emerald-rgb:240,162,90; }
  [data-accent="pink"]{ --emerald:#E85A9C; --emerald-dim:#B83A78; --emerald-rgb:232,90,156; }

  *{margin:0;padding:0;box-sizing:border-box;}
  html{ color-scheme: dark; }
  html[data-theme="light"]{ color-scheme: light; }
  body{
    background: var(--bg); color: var(--text); font-family:'Inter', sans-serif;
    line-height:1.5; transition: background .35s ease, color .35s ease;
  }
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
  .sb-logo{ display:flex; align-items:center; gap:10px; font-family:'Space Grotesk'; font-weight:700; font-size:18px; padding:6px 8px 26px; }
  .sb-logo .logo-mark{ width:30px; height:30px; border-radius:9px; background:var(--surface-strong); border:1px solid var(--border-hover); display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0; padding:3px; }
  .sb-logo .logo-mark img{ width:100%; height:100%; object-fit:contain; }
  .sb-logo .dot{ color:var(--emerald); }

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
  .sb-plan a{ font-size:12px; color:var(--emerald); font-weight:600; }

  .topbar{ position:sticky; top:0; z-index:40; display:flex; align-items:center; justify-content:space-between; gap:20px; padding:16px 28px; background:var(--nav-bg); backdrop-filter:blur(16px); border-bottom:1px solid var(--border); }
  .search-box{ display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 14px; width:340px; max-width:100%; transition: border-color .2s ease, background .2s ease; }
  .search-box:focus-within{ border-color:var(--border-hover); background:var(--surface-strong); }
  .search-box .icon{ width:15px; height:15px; color:var(--text-faint); flex-shrink:0; }
  .search-box input{ flex:1; min-width:0; background:none; border:none; outline:none; color:var(--text); font-size:13.5px; }
  .search-box input::placeholder{ color:var(--text-faint); }
  .search-box .kbd{ font-family:'IBM Plex Mono'; font-size:10.5px; color:var(--text-faint); background:var(--surface-strong); border:1px solid var(--border); border-radius:5px; padding:2px 6px; flex-shrink:0; }

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
  .dropdown-head{ padding:10px 12px 12px; border-bottom:1px solid var(--border); margin-bottom:6px; }
  .dropdown-head .n{ font-size:13.5px; font-weight:600; }
  .dropdown-head .e{ font-size:11.5px; color:var(--text-faint); margin-top:2px; }
  .dropdown a, .dropdown button{ display:flex; align-items:center; gap:10px; width:100%; padding:9px 12px; border-radius:10px; font-size:13px; color:var(--text-mute); background:none; border:none; text-align:left; cursor:pointer; transition: all .15s ease; }
  .dropdown a:hover, .dropdown button:hover{ background:var(--surface-strong); color:var(--text); }
  .dropdown .icon{ width:15px; height:15px; }
  .dropdown .danger{ color:var(--danger); }
  .dropdown .danger:hover{ background:rgba(232,90,90,0.1); color:var(--danger); }
  .dropdown hr{ border:none; border-top:1px solid var(--border); margin:6px 0; }

  .sb-toggle{ display:none; width:38px; height:38px; border-radius:11px; background:var(--surface); border:1px solid var(--border); align-items:center; justify-content:center; color:var(--text); cursor:pointer; flex-shrink:0; }
  .sb-toggle .icon{ width:17px; height:17px; }

  main{ padding:28px; position:relative; z-index:1; }
  .page-head{ display:flex; justify-content:space-between; align-items:flex-end; gap:20px; flex-wrap:wrap; margin-bottom:24px; }
  .page-head .eyebrow{ font-size:11.5px; text-transform:uppercase; letter-spacing:.08em; color:var(--emerald); font-weight:600; margin-bottom:8px; display:flex; align-items:center; gap:8px; }
  .page-head h1{ font-size:25px; margin-bottom:6px; }
  .page-head p{ font-size:13.5px; color:var(--text-mute); }
  .page-head .actions{ display:flex; gap:10px; }

  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:10px 18px; border-radius:11px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .22s ease; white-space:nowrap; }
  .btn .icon{ width:15px; height:15px; }
  .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 20px rgba(var(--emerald-rgb),0.3); }
  .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 10px 28px rgba(var(--emerald-rgb),0.45); }
  .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .btn-outline:hover{ background:var(--surface-strong); border-color:var(--border-hover); }

  .company-card{ background:linear-gradient(135deg, rgba(var(--emerald-rgb),0.08), var(--surface) 55%); border:1px solid var(--border); border-radius:20px; padding:22px 24px; margin-bottom:20px; transition: border-color .22s ease; }
  .company-card:hover{ border-color:var(--border-hover); }
  .company-card-inner{ display:flex; align-items:flex-start; gap:20px; flex-wrap:wrap; }
  .company-logo{ width:64px; height:64px; border-radius:16px; background:var(--surface-strong); border:1px solid var(--border-hover); display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden; font-family:'Space Grotesk'; font-weight:700; font-size:20px; color:var(--emerald); }
  .company-logo img{ width:100%; height:100%; object-fit:cover; }
  .company-meta{ flex:1; min-width:240px; }
  .company-meta h2{ font-size:20px; margin-bottom:8px; }
  .company-tags{ display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px; }
  .tag-pill{ font-size:11.5px; font-weight:600; padding:5px 11px; border-radius:100px; background:var(--surface-strong); border:1px solid var(--border); color:var(--text-mute); }
  .company-details{ display:grid; grid-template-columns:repeat(4,1fr); gap:14px 20px; }
  .company-details div{ display:flex; flex-direction:column; gap:3px; }
  .company-details .k{ font-size:10.5px; text-transform:uppercase; letter-spacing:.05em; color:var(--text-faint); }
  .company-details .v{ font-size:13px; font-weight:600; color:var(--text); }
  .company-edit-btn{ flex-shrink:0; }

  .stat-grid{ display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:20px; }
  .stat-card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:20px; transition: border-color .22s ease, transform .22s ease; }
  .stat-card:hover{ border-color:var(--border-hover); transform:translateY(-3px); }
  .stat-head{ display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px; }
  .stat-head .ic{ width:36px; height:36px; border-radius:10px; background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); display:flex; align-items:center; justify-content:center; }
  .stat-head .ic .icon{ width:17px; height:17px; }
  .stat-head .chg{ font-size:11.5px; font-weight:600; padding:4px 8px; border-radius:100px; display:flex; align-items:center; gap:4px; }
  .stat-head .chg .icon{ width:11px; height:11px; }
  .chg.up{ color:var(--emerald); background:rgba(var(--emerald-rgb),0.1); }
  .chg.down{ color:var(--danger); background:rgba(232,90,90,0.1); }
  .stat-card .lbl{ font-size:12px; color:var(--text-faint); margin-bottom:5px; }
  .stat-card .val{ font-family:'Space Grotesk'; font-size:23px; font-weight:700; }

  .dash-layout{ display:grid; grid-template-columns:1.35fr 1fr; gap:16px; align-items:start; }
  .stack{ display:flex; flex-direction:column; gap:16px; }
  .card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:22px; transition: border-color .22s ease; }
  .card:hover{ border-color:var(--border-hover); }
  .card-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; gap:12px; flex-wrap:wrap; }
  .card-head h3{ font-size:15.5px; font-weight:600; }
  .card-head .sub-link{ font-size:12.5px; color:var(--emerald); font-weight:600; display:flex; align-items:center; gap:4px; }
  .card-head .sub-link .icon{ width:13px; height:13px; }

  .balance-card{ background:linear-gradient(150deg, rgba(var(--emerald-rgb),0.14), var(--surface) 65%); border-color:rgba(var(--emerald-rgb),0.25); }
  .balance-top{ display:flex; justify-content:space-between; align-items:flex-start; gap:16px; flex-wrap:wrap; margin-bottom:22px; }
  .balance-lbl{ font-size:12.5px; color:var(--text-mute); margin-bottom:8px; }
  .balance-sub{ font-size:11.5px; color:var(--text-faint); margin-top:2px; }
  .balance-amt{ font-family:'Space Grotesk'; font-size:36px; font-weight:700; }
  .balance-delta{ font-size:12.5px; color:var(--emerald); margin-top:8px; display:flex; align-items:center; gap:6px; }
  .balance-delta .icon{ width:13px; height:13px; }
  .quick-actions{ display:flex; gap:10px; flex-wrap:wrap; }
  .qa-btn{ display:flex; flex-direction:column; align-items:center; gap:7px; font-size:11px; color:var(--text-mute); cursor:pointer; width:72px; text-align:center; }
  .qa-btn .ic{ width:42px; height:42px; border-radius:13px; background:var(--surface-strong); display:flex; align-items:center; justify-content:center; color:var(--text); transition: all .2s ease; }
  .qa-btn .ic .icon{ width:18px; height:18px; }
  .qa-btn:hover .ic{ background:rgba(var(--emerald-rgb),0.16); color:var(--emerald); transform:translateY(-3px); }
  .mini-spark{ display:flex; align-items:flex-end; gap:5px; height:60px; margin-top:6px; }
  .mini-spark i{ flex:1; background:linear-gradient(180deg,var(--emerald),var(--emerald-dim)); border-radius:3px; opacity:.85; height:4%; transition:height 1s cubic-bezier(.16,1,.3,1); }

  .tx-table{ width:100%; border-collapse:collapse; }
  .tx-table th{ text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:var(--text-faint); font-weight:600; padding:0 10px 10px; }
  .tx-table td{ padding:12px 10px; font-size:13.5px; border-top:1px solid var(--border); }
  .tx-table tr{ transition: background .15s ease; }
  .tx-table tbody tr:hover{ background:var(--surface-strong); }
  .tx-who{ display:flex; align-items:center; gap:10px; }
  .tx-ic{ width:34px; height:34px; border-radius:10px; background:var(--surface-strong); display:flex; align-items:center; justify-content:center; color:var(--text-mute); flex-shrink:0; }
  .tx-ic .icon{ width:15px; height:15px; }
  .tx-name{ font-weight:600; font-size:13.5px; }
  .tx-date{ font-size:11.5px; color:var(--text-faint); }
  .status-pill{ font-size:11px; font-weight:600; padding:4px 10px; border-radius:100px; display:inline-block; }
  .status-pill.paid{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
  .status-pill.pending{ background:rgba(240,162,90,0.14); color:#F0A25A; }
  .status-pill.overdue{ background:rgba(232,90,90,0.12); color:var(--danger); }
  .amt-cell{ font-family:'IBM Plex Mono'; font-size:13px; text-align:right; }
  .amt-cell.pos{ color:var(--emerald); }
  .amt-cell.neg{ color:var(--text-mute); }

  .donut-wrap{ display:flex; gap:22px; align-items:center; }
  .donut{ width:118px; height:118px; position:relative; flex-shrink:0; }
  .donut svg{ transform:rotate(-90deg); width:100%; height:100%; }
  .donut circle{ fill:none; stroke-width:13; }
  .donut-center{ position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
  .donut-center .amt{ font-family:'Space Grotesk'; font-size:14px; font-weight:700; }
  .donut-center .lbl{ font-size:9px; color:var(--text-faint); }
  .legend{ flex:1; min-width:0; }
  .legend-row{ display:flex; justify-content:space-between; align-items:center; font-size:12px; padding:6px 4px; color:var(--text-mute); }
  .legend-row .dot{ width:8px; height:8px; border-radius:50%; display:inline-block; margin-right:8px; flex-shrink:0; }
  .legend-row .amt{ font-family:'IBM Plex Mono'; color:var(--text); font-size:11.5px; }

  .progress-bar{ height:8px; border-radius:100px; background:var(--surface-strong); overflow:hidden; margin-top:14px; }
  .progress-fill{ height:100%; background:linear-gradient(90deg,var(--emerald-dim),var(--emerald)); border-radius:100px; width:0%; transition:width 1.4s cubic-bezier(.16,1,.3,1); }
  .progress-labels{ display:flex; justify-content:space-between; font-size:11px; color:var(--text-faint); margin-top:8px; }

  .inv-row{ display:flex; align-items:center; gap:12px; padding:11px 4px; border-top:1px solid var(--border); }
  .inv-row:first-child{ border-top:none; }
  .inv-row .info{ flex:1; min-width:0; }
  .inv-row .n{ font-size:13px; font-weight:600; }
  .inv-row .c{ font-size:11.5px; color:var(--text-faint); }
  .inv-row .amt{ font-family:'IBM Plex Mono'; font-size:12.5px; text-align:right; }

  .team-row{ display:flex; align-items:center; gap:12px; padding:11px 4px; border-top:1px solid var(--border); }
  .team-row:first-child{ border-top:none; }
  .team-avatar{ width:34px; height:34px; border-radius:50%; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk'; font-weight:700; font-size:12px; color:var(--emerald); flex-shrink:0; }
  .team-info{ flex:1; min-width:0; }
  .team-info .n{ font-size:13px; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  .team-info .c{ font-size:11.5px; color:var(--text-faint); }
  .team-role-pill{ font-size:10.5px; font-weight:600; padding:4px 9px; border-radius:100px; background:var(--surface-strong); color:var(--text-mute); flex-shrink:0; }

  .empty-state{ text-align:center; padding:32px 16px; color:var(--text-faint); font-size:13px; }

  .page-header-simple{ background:var(--surface); border-bottom:1px solid var(--border); padding:18px 28px; }
  .page-header-simple h2{ font-size:18px; font-weight:600; }

  @media (max-width: 1180px){
    .dash-layout{ grid-template-columns:1fr; }
    .stat-grid{ grid-template-columns:repeat(2,1fr); }
    .company-details{ grid-template-columns:repeat(2,1fr); }
  }
  @media (max-width: 980px){
    .app-shell{ grid-template-columns:1fr; }
    .sidebar{ position:fixed; left:0; top:0; width:250px; z-index:100; transform:translateX(-100%); transition: transform .3s cubic-bezier(.4,0,.2,1); }
    .sidebar.open{ transform:translateX(0); }
    .sb-toggle{ display:flex; }
    .search-box{ width:220px; }
  }
  @media (max-width: 640px){
    .stat-grid{ grid-template-columns:1fr; }
    .search-box{ display:none; }
    main{ padding:18px; }
    .topbar{ padding:14px 16px; }
    .balance-amt{ font-size:28px; }
    .quick-actions{ justify-content:space-between; }
    .qa-btn{ width:auto; flex:1; }
    .company-card-inner{ flex-direction:column; }
    .company-details{ grid-template-columns:1fr 1fr; }
    .company-edit-btn{ width:100%; }
  }

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
  @media (max-width:480px){
    .settings-fab{ right:16px; bottom:16px; width:46px; height:46px; }
    .settings-panel{ right:16px; bottom:74px; width:calc(100vw - 32px); }
  }
</style>
</head>
<body class="font-sans antialiased">

<div class="bg-glow"></div>
<div class="bg-glow-2"></div>

<!-- icon sprite dipakai semua halaman -->
<svg width="0" height="0" style="position:absolute">
<defs>
  <symbol id="ic-bell" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></symbol>
  <symbol id="ic-invoice" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h12v20l-3-2-3 2-3-2-3 2V2z"/><path d="M9 7h6M9 11h6M9 15h3"/></symbol>
  <symbol id="ic-receive" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="17" y1="7" x2="7" y2="17"/><polyline points="7 7 7 17 17 17"/></symbol>
  <symbol id="ic-bank" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V10l7-6 7 6v11"/><path d="M9 21v-7h6v7"/></symbol>
  <symbol id="ic-dots" viewBox="0 0 24 24" fill="currentColor"><circle cx="6" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="18" cy="12" r="1.6"/></symbol>
  <symbol id="ic-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 12 8 12 10 6 14 18 16 12 21 12"/></symbol>
  <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/><polyline points="9 12 11 14 15 10"/></symbol>
  <symbol id="ic-refresh" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-3-6.7"/><polyline points="21 3 21 9 15 9"/></symbol>
  <symbol id="ic-target" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/></symbol>
  <symbol id="ic-trending" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/></symbol>
  <symbol id="ic-trending-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 7 9 13 13 9 21 17"/><polyline points="14 17 21 17 21 10"/></symbol>
  <symbol id="ic-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></symbol>
  <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
  <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
  <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>
  <symbol id="ic-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></symbol>
  <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/></symbol>
  <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
  <symbol id="ic-doc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/></symbol>
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

  @include('layouts.navigation')

  <div>
    <!-- TOPBAR -->
    <header class="topbar">
      <div style="display:flex; align-items:center; gap:14px;">
        <div class="sb-toggle" id="sbToggle" aria-label="Buka menu"><svg class="icon"><use href="#ic-menu"/></svg></div>
        <div class="search-box">
          <svg class="icon"><use href="#ic-search"/></svg>
          <input type="text" placeholder="Cari faktur, klien, transaksi...">
          <span class="kbd">⌘K</span>
        </div>
      </div>
      <div class="topbar-right">
        <div class="icon-btn" id="notifBtn" aria-label="Notifikasi">
          <svg class="icon"><use href="#ic-bell"/></svg>
          <span class="dot-alert"></span>
        </div>
        <div class="user-menu">
          <div class="user-trigger" id="userTrigger">
            <div class="user-avatar">
              {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <span class="name">{{ Auth::user()->name ?? 'Pengguna' }}</span>
            <svg class="icon"><use href="#ic-chevron"/></svg>
          </div>
          <div class="dropdown" id="userDropdown">
            <div class="dropdown-head">
              <div class="n">{{ Auth::user()->name ?? 'Pengguna' }}</div>
              <div class="e">{{ Auth::user()->email ?? '' }}</div>
            </div>
            <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}"><svg class="icon"><use href="#ic-user"/></svg> Profil Saya</a>
            <a href="#"><svg class="icon"><use href="#ic-settings"/></svg> Pengaturan</a>
            <hr>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="danger"><svg class="icon"><use href="#ic-logout"/></svg> Keluar</button>
            </form>
          </div>
        </div>
      </div>
    </header>

    <!-- PAGE HEADER SEDERHANA (opsional, dari Breeze $header) -->
    @isset($header)
      <div class="page-header-simple">
        <h2>{{ $header }}</h2>
      </div>
    @endisset

    <!-- KONTEN HALAMAN -->
    <main>
      {{ $slot }}
    </main>
  </div>
</div>

<!-- SETTINGS WIDGET -->
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
  <div class="settings-block">
    <h4>Bahasa</h4>
    <div class="lang-row">
      <div class="lang-opt" data-lang-opt="id">Indonesia</div>
      <div class="lang-opt" data-lang-opt="en">English</div>
    </div>
  </div>
</div>

<script>
  // ===== user dropdown =====
  const userTrigger = document.getElementById('userTrigger');
  const userDropdown = document.getElementById('userDropdown');
  if(userTrigger && userDropdown){
    userTrigger.addEventListener('click', (e) => {
      e.stopPropagation();
      userDropdown.classList.toggle('open');
    });
    document.addEventListener('click', (e) => {
      if(userDropdown.classList.contains('open') && !userDropdown.contains(e.target) && e.target !== userTrigger){
        userDropdown.classList.remove('open');
      }
    });
  }

  // ===== mobile sidebar toggle =====
  const sbToggle = document.getElementById('sbToggle');
  const sidebar = document.getElementById('sidebar');
  const menuBackdrop = document.getElementById('menuBackdrop');
  function openSidebar(){ sidebar.classList.add('open'); menuBackdrop.classList.add('open'); document.body.style.overflow='hidden'; }
  function closeSidebar(){ sidebar.classList.remove('open'); menuBackdrop.classList.remove('open'); document.body.style.overflow=''; }
  if(sbToggle) sbToggle.addEventListener('click', openSidebar);
  if(menuBackdrop) menuBackdrop.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', (e) => { if(e.key === 'Escape') closeSidebar(); });

  // ===== SETTINGS WIDGET: theme, accent, language =====
  (function(){
    const root = document.documentElement;
    const fab = document.getElementById('settingsFab');
    const panel = document.getElementById('settingsPanel');

    function getSaved(key, fallback){ try{ return localStorage.getItem(key) || fallback; }catch(e){ return fallback; } }
    function save(key, val){ try{ localStorage.setItem(key, val); }catch(e){} }

    let theme = getSaved('aj-theme', 'dark');
    let accent = getSaved('aj-accent', 'emerald');

    function applyTheme(t){
      theme = t; root.setAttribute('data-theme', t); save('aj-theme', t);
      document.querySelectorAll('.theme-opt').forEach(el => el.classList.toggle('active', el.getAttribute('data-theme-opt') === t));
    }
    function applyAccent(a){
      accent = a; root.setAttribute('data-accent', a); save('aj-accent', a);
      document.querySelectorAll('.accent-dot').forEach(el => el.classList.toggle('active', el.getAttribute('data-accent-opt') === a));
    }
    applyTheme(theme);
    applyAccent(accent);

    if(fab && panel){
      fab.addEventListener('click', (e) => { e.stopPropagation(); panel.classList.toggle('open'); });
      document.addEventListener('click', (e) => {
        if(panel.classList.contains('open') && !panel.contains(e.target) && e.target !== fab){ panel.classList.remove('open'); }
      });
    }
    document.querySelectorAll('.theme-opt').forEach(el => el.addEventListener('click', () => applyTheme(el.getAttribute('data-theme-opt'))));
    document.querySelectorAll('.accent-dot').forEach(el => el.addEventListener('click', () => applyAccent(el.getAttribute('data-accent-opt'))));

    document.querySelectorAll('.lang-opt').forEach(el => {
      el.addEventListener('click', () => {
        const l = el.getAttribute('data-lang-opt');
        save('aj-lang', l);
        document.querySelectorAll('.lang-opt').forEach(o => o.classList.toggle('active', o === el));
      });
    });
    document.querySelectorAll('.lang-opt').forEach(el => {
      el.classList.toggle('active', el.getAttribute('data-lang-opt') === getSaved('aj-lang', 'id'));
    });
  })();
</script>

{{ $scripts ?? '' }}

</body>
</html>