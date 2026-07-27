<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buat Akun — Arvessa</title>

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
    --blue: #4E8FF0;
    --text: #EAF0F6;
    --text-mute: #8A96AE;
    --text-faint: #545E73;
    --radius: 20px;
    --nav-bg: rgba(7,11,19,0.75);
    --mobile-bg: #0B101B;
    --modal-bg: linear-gradient(160deg, #0F1520, #0A0D14 60%);
    --star-op: 1;
    --emerald-rgb: 52,224,161;
    --glow1-a: 0.16;
    --glow2-a: 0.11;
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
    --nav-bg: rgba(244,246,250,0.78);
    --mobile-bg: #FFFFFF;
    --modal-bg: linear-gradient(160deg, #FFFFFF, #F2F5F9 60%);
    --star-op: 0;
    --glow1-a: 0.22;
    --glow2-a: 0.16;
  }

  [data-accent="blue"]{ --emerald:#4E8FF0; --emerald-dim:#3465C4; --emerald-rgb:78,143,240; }
  [data-accent="purple"]{ --emerald:#9B7BE0; --emerald-dim:#6E4FBE; --emerald-rgb:155,123,224; }
  [data-accent="orange"]{ --emerald:#F0A25A; --emerald-dim:#C97A2E; --emerald-rgb:240,162,90; }
  [data-accent="pink"]{ --emerald:#E85A9C; --emerald-dim:#B83A78; --emerald-rgb:232,90,156; }

  *{margin:0;padding:0;box-sizing:border-box;}
  html{ color-scheme: dark; }
  html[data-theme="light"]{ color-scheme: light; }
  body{
    background: var(--bg);
    color: var(--text);
    font-family:'Inter', sans-serif;
    line-height:1.5;
    overflow-x:hidden;
    transition: background .35s ease, color .35s ease;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
  }
  #starfield{ transition: opacity .35s ease; opacity: var(--star-op); }
  .bg-glow, .bg-glow-2{ transition: background .35s ease; }
  h1,h2,h3,.display{ font-family:'Space Grotesk', sans-serif; letter-spacing:-0.02em; }
  .mono{ font-family:'IBM Plex Mono', monospace; }
  a{ text-decoration:none; color:inherit; }
  ul{ list-style:none; }
  svg{ display:block; }
  .icon{ width:1em; height:1em; }

  #starfield{ position:fixed; inset:0; z-index:0; pointer-events:none; overflow:hidden; }
  .star{ position:absolute; border-radius:50%; background:#fff; animation: twinkle 3s ease-in-out infinite; }
  @keyframes twinkle{ 0%,100%{opacity:.15;} 50%{opacity:.9;} }

  .bg-glow{ position:fixed; top:-25%; right:-10%; width:900px; height:900px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow1-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }
  .bg-glow-2{ position:fixed; bottom:-15%; left:-15%; width:700px; height:700px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow2-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }

  .icon{ width:1em; height:1em; }

  .settings-fab{
    position:fixed; right:22px; bottom:22px; z-index:150;
    width:50px; height:50px; border-radius:50%;
    background:var(--surface-strong); border:1px solid var(--border);
    display:flex; align-items:center; justify-content:center; cursor:pointer;
    color:var(--text); box-shadow:0 10px 30px rgba(0,0,0,0.35);
    backdrop-filter:blur(10px); transition: transform .25s ease, border-color .25s ease, background .35s ease;
  }
  .settings-fab:hover{ transform: translateY(-3px) rotate(20deg); border-color:var(--border-hover); }
  .settings-fab .icon{ width:20px; height:20px; }
  .settings-panel{
    position:fixed; right:22px; bottom:82px; z-index:150;
    width:250px; background:var(--modal-bg); border:1px solid var(--border);
    border-radius:18px; padding:18px; box-shadow:0 30px 70px rgba(0,0,0,0.45);
    opacity:0; visibility:hidden; transform: translateY(10px) scale(.97);
    transition: opacity .22s ease, transform .22s ease, visibility .22s, background .35s ease;
  }
  .settings-panel.open{ opacity:1; visibility:visible; transform: translateY(0) scale(1); }
  .settings-panel h4{ font-size:11.5px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); margin-bottom:10px; font-family:'Inter'; }
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
  .accent-dot.active::after{ content:''; position:absolute; inset:0; border-radius:50%; box-shadow:0 0 0 2px var(--bg); }
  .lang-row{ display:flex; gap:8px; }
  .lang-opt{ flex:1; padding:9px 6px; text-align:center; border-radius:12px; border:1px solid var(--border); background:var(--surface); color:var(--text-mute); font-size:12.5px; font-weight:600; cursor:pointer; transition: all .2s ease; }
  .lang-opt:hover{ color:var(--text); border-color:var(--border-hover); }
  .lang-opt.active{ color:var(--emerald); border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }

  .auth-page{
    width:100%;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
    position:relative;
    z-index:2;
  }
  .auth-card{
    width:min(440px, 100%);
    background:var(--modal-bg);
    border:1px solid var(--border);
    border-radius:22px;
    padding:34px 30px 28px;
    box-shadow:0 40px 100px rgba(0,0,0,0.45);
    margin:20px 0;
    max-height:calc(100vh - 40px);
    overflow-y:auto;
  }
  .back-home{
    display:inline-flex;
    align-items:center;
    gap:6px;
    font-size:13px;
    color:var(--text-mute);
    margin-bottom:22px;
    transition: color .2s ease;
  }
  .back-home:hover{ color:var(--text); }
  .auth-error{
    background:rgba(232,90,90,0.08);
    border:1px solid rgba(232,90,90,0.35);
    color:#E85A5A;
    border-radius:12px;
    padding:12px 16px;
    margin-bottom:18px;
    font-size:13px;
  }
  .auth-error ul{ padding-left:18px; list-style:disc; }

  .auth-head{ margin-bottom:22px; }
  .auth-head .logo{
    display:flex;
    align-items:center;
    gap:10px;
    font-family:'Space Grotesk';
    font-weight:700;
    font-size:19px;
    margin-bottom:20px;
  }
  .auth-head .logo .logo-mark{
    width:30px;
    height:30px;
    border-radius:8px;
    overflow:hidden;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
  }
  .auth-head .logo .logo-mark img{
    width:100%;
    height:100%;
    object-fit:contain;
  }
  .auth-head .logo .dot{ color:var(--emerald); }
  .auth-head h2{ font-size:22px; margin-bottom:6px; }
  .auth-head p{ font-size:13.5px; color:var(--text-mute); }

  .auth-social{ width:100%; margin-bottom:18px; }
  .auth-social .icon{ width:17px; height:17px; }
  .auth-divider{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:18px;
  }
  .auth-divider::before,
  .auth-divider::after{
    content:'';
    flex:1;
    height:1px;
    background:var(--border);
  }
  .auth-divider span{
    font-size:11.5px;
    color:var(--text-faint);
    white-space:nowrap;
  }

  .auth-form{ display:flex; flex-direction:column; gap:15px; }
  .field{ display:flex; flex-direction:column; gap:7px; }
  .field > span{ font-size:12.5px; color:var(--text-mute); font-weight:500; }
  .field-input{
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px 14px;
    border-radius:12px;
    background:var(--surface);
    border:1px solid var(--border);
    transition: border-color .2s ease, background .2s ease;
  }
  .field-input:focus-within{
    border-color: var(--border-hover);
    background:var(--surface-strong);
  }
  .field-input .icon{
    width:16px;
    height:16px;
    color:var(--text-faint);
    flex-shrink:0;
  }
  .field-input input{
    flex:1;
    min-width:0;
    background:none;
    border:none;
    outline:none;
    color:var(--text);
    font-family:'Inter';
    font-size:14px;
    width:100%;
  }
  .field-input input::placeholder{ color:var(--text-faint); }
  .toggle-eye{
    cursor:pointer;
    transition: color .2s ease;
    flex-shrink:0;
  }
  .toggle-eye:hover{ color:var(--text-mute); }

  .checkbox{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:12.5px;
    color:var(--text-mute);
    cursor:pointer;
  }
  .checkbox input{
    accent-color: var(--emerald);
    width:15px;
    height:15px;
    flex-shrink:0;
  }
  .checkbox.terms{
    align-items:flex-start;
    line-height:1.5;
  }
  .checkbox.terms input{ margin-top:2px; }

  .btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:11px 22px;
    border-radius:12px;
    font-size:14.5px;
    font-weight:600;
    cursor:pointer;
    border:none;
    transition:all .25s ease;
  }
  .btn .icon{ width:16px; height:16px; transition: transform .25s ease; }
  .btn-primary{
    background:var(--emerald);
    color:#052117;
    box-shadow:0 4px 24px rgba(var(--emerald-rgb),0.35);
  }
  .btn-primary:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 32px rgba(var(--emerald-rgb),0.5);
  }
  .btn-primary:hover .icon{ transform: translateX(3px); }
  .btn-outline{
    background:var(--surface);
    border:1px solid var(--border);
    color:var(--text);
  }
  .btn-outline:hover{
    background:var(--surface-strong);
    border-color: var(--border-hover);
    transform: translateY(-2px);
  }
  .auth-submit{ width:100%; margin-top:4px; padding:13px 22px; }

  .auth-switch{
    text-align:center;
    font-size:13px;
    color:var(--text-mute);
    margin-top:22px;
  }
  .auth-switch a{
    color:var(--emerald);
    font-weight:600;
  }
  .auth-switch a:hover{ opacity:.85; }

  @media (max-width: 768px){
    .auth-card{
      padding:28px 24px 24px;
      border-radius:18px;
      width:min(420px, 100%);
    }
    .auth-head h2{ font-size:20px; }
    .settings-fab{
      right:16px;
      bottom:16px;
      width:46px;
      height:46px;
    }
    .settings-fab .icon{ width:18px; height:18px; }
    .settings-panel{
      right:16px;
      bottom:74px;
      width:calc(100vw - 32px);
      max-width:280px;
    }
  }

  @media (max-width: 480px){
    .auth-page{ padding:12px; }
    .auth-card{
      padding:22px 18px 20px;
      border-radius:16px;
      width:100%;
      margin:10px 0;
      max-height:calc(100vh - 24px);
    }
    .auth-head .logo{
      font-size:17px;
      margin-bottom:16px;
    }
    .auth-head .logo .logo-mark{
      width:26px;
      height:26px;
    }
    .auth-head h2{
      font-size:18px;
      margin-bottom:4px;
    }
    .auth-head p{
      font-size:12.5px;
    }
    .back-home{
      font-size:12px;
      margin-bottom:16px;
    }
    .auth-form{ gap:12px; }
    .field > span{ font-size:11.5px; }
    .field-input{
      padding:10px 12px;
      border-radius:10px;
    }
    .field-input input{ font-size:13px; }
    .field-input .icon{ width:14px; height:14px; }
    .btn{
      font-size:13px;
      padding:10px 18px;
      border-radius:10px;
    }
    .btn .icon{ width:14px; height:14px; }
    .auth-submit{ padding:12px 18px; }
    .auth-social .icon{ width:15px; height:15px; }
    .auth-divider span{ font-size:10.5px; }
    .checkbox{
      font-size:11.5px;
      gap:6px;
    }
    .checkbox input{ width:14px; height:14px; }
    .auth-switch{
      font-size:12px;
      margin-top:18px;
    }
    .auth-error{
      font-size:12px;
      padding:10px 14px;
    }
    .auth-error ul{ padding-left:14px; }
    .settings-panel{
      right:10px;
      bottom:68px;
      width:calc(100vw - 20px);
      max-width:260px;
      padding:14px;
      border-radius:14px;
    }
    .settings-panel h4{ font-size:10px; }
    .theme-opt{
      font-size:10px;
      padding:8px 4px;
    }
    .theme-opt .icon{ width:13px; height:13px; }
    .accent-dot{ width:22px; height:22px; }
    .lang-opt{
      font-size:11px;
      padding:7px 4px;
    }
    .settings-fab{
      right:10px;
      bottom:10px;
      width:42px;
      height:42px;
    }
    .settings-fab .icon{ width:16px; height:16px; }
  }

  @media (max-width: 360px){
    .auth-card{
      padding:18px 14px 16px;
      border-radius:14px;
    }
    .auth-head h2{ font-size:16px; }
    .field-input{ padding:8px 10px; }
    .field-input input{ font-size:12px; }
    .btn{ font-size:12px; padding:8px 14px; }
    .auth-head .logo{ font-size:15px; }
    .auth-head .logo .logo-mark{ width:22px; height:22px; }
    .settings-panel{ max-width:220px; }
  }

  @media (max-height: 700px){
    .auth-card{
      padding:20px 24px 18px;
      max-height:calc(100vh - 20px);
    }
    .auth-head{ margin-bottom:16px; }
    .auth-head .logo{ margin-bottom:14px; }
    .auth-form{ gap:10px; }
    .auth-switch{ margin-top:14px; }
  }
</style>
</head>
<body>

<div id="starfield"></div>
<div class="bg-glow"></div>
<div class="bg-glow-2"></div>

<!-- SETTINGS WIDGET -->
<div class="settings-fab" id="settingsFab" aria-label="Pengaturan tampilan">
  <svg class="icon"><use href="#ic-gear"/></svg>
</div>
<div class="settings-panel" id="settingsPanel">
  <div class="settings-block">
    <h4 data-i18n-en="Appearance">Tampilan</h4>
    <div class="theme-toggle-row">
      <div class="theme-opt" data-theme-opt="dark">
        <svg class="icon"><use href="#ic-moon"/></svg>
        <span data-i18n-en="Dark">Gelap</span>
      </div>
      <div class="theme-opt" data-theme-opt="light">
        <svg class="icon"><use href="#ic-sun"/></svg>
        <span data-i18n-en="Light">Terang</span>
      </div>
    </div>
  </div>
  <div class="settings-block">
    <h4 data-i18n-en="Accent color">Warna tema</h4>
    <div class="accent-row">
      <div class="accent-dot" data-accent-opt="emerald" style="background:#34E0A1" title="Emerald"></div>
      <div class="accent-dot" data-accent-opt="blue" style="background:#4E8FF0" title="Blue"></div>
      <div class="accent-dot" data-accent-opt="purple" style="background:#9B7BE0" title="Purple"></div>
      <div class="accent-dot" data-accent-opt="orange" style="background:#F0A25A" title="Orange"></div>
      <div class="accent-dot" data-accent-opt="pink" style="background:#E85A9C" title="Pink"></div>
    </div>
  </div>
  <div class="settings-block">
    <h4 data-i18n-en="Language">Bahasa</h4>
    <div class="lang-row">
      <div class="lang-opt" data-lang-opt="id">Indonesia</div>
      <div class="lang-opt" data-lang-opt="en">English</div>
    </div>
  </div>
</div>

<!-- SVG Icons -->
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
  <symbol id="ic-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></symbol>
  <symbol id="ic-play" viewBox="0 0 24 24" fill="currentColor"><polygon points="6 4 20 12 6 20"/></symbol>
  <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
  <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></symbol>
  <symbol id="ic-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></symbol>
  <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/></symbol>
  <symbol id="ic-badge" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="6"/><path d="M9 14.5 7 22l5-3 5 3-2-7.5"/></symbol>
  <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
  <symbol id="ic-star" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15 9 22 9.5 16.5 14 18.5 21 12 17 5.5 21 7.5 14 2 9.5 9 9"/></symbol>
  <symbol id="ic-menu" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></symbol>
  <symbol id="ic-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></symbol>
  <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 6 10 7 10-7"/></symbol>
  <symbol id="ic-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></symbol>
  <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/></symbol>
  <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></symbol>
  <symbol id="ic-google" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.04 12.27c0-.85-.08-1.66-.22-2.45H12v4.64h6.19a5.3 5.3 0 0 1-2.3 3.48v2.9h3.72c2.18-2 3.43-4.96 3.43-8.57z"/><path fill="#34A853" d="M12 23.5c3.1 0 5.7-1.02 7.6-2.77l-3.72-2.9c-1.03.7-2.35 1.1-3.88 1.1-2.98 0-5.5-2-6.4-4.7H1.77v2.98A11.5 11.5 0 0 0 12 23.5z"/><path fill="#FBBC05" d="M5.6 14.23A6.9 6.9 0 0 1 5.24 12c0-.77.13-1.53.36-2.23V6.79H1.77A11.5 11.5 0 0 0 .5 12c0 1.85.44 3.6 1.27 5.21z"/><path fill="#EA4335" d="M12 4.98c1.69 0 3.2.58 4.4 1.72l3.29-3.3C17.7 1.6 15.1.5 12 .5A11.5 11.5 0 0 0 1.77 6.79l3.83 2.98c.9-2.7 3.42-4.79 6.4-4.79z"/></symbol>
  <symbol id="ic-gear" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></symbol>
  <symbol id="ic-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4.5"/><path d="M12 2v2.5M12 19.5V22M4.2 4.2l1.8 1.8M18 18l1.8 1.8M2 12h2.5M19.5 12H22M4.2 19.8 6 18M18 6l1.8-1.8"/></symbol>
  <symbol id="ic-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.5a8.5 8.5 0 1 1-9.5-11.4 7 7 0 0 0 9.5 11.4z"/></symbol>
  <symbol id="ic-globe" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18z"/></symbol>
</defs>
</svg>

<div class="auth-page">
  <div class="auth-card">
    <a href="{{ url('/') }}" class="back-home">&larr; <span>Kembali ke beranda</span></a>

    <div class="auth-head">
      <div class="logo">
        <span class="logo-mark"><img src="{{ asset('logos.png') }}" alt="Arvessa"></span>
        Arvessa
      </div>
      <h2>Buat akun bisnis</h2>
      <p>Gratis 14 hari, tanpa kartu kredit.</p>
    </div>

    <button type="button" class="btn btn-outline auth-social">
      <svg class="icon"><use href="#ic-google"/></svg> Daftar dengan Google
    </button>
    <div class="auth-divider"><span>atau pakai email</span></div>

    @if ($errors->any())
      <div class="auth-error">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form class="auth-form" method="POST" action="{{ route('register') }}">
      @csrf
      <label class="field">
        <span>Nama lengkap</span>
        <div class="field-input">
          <svg class="icon"><use href="#ic-user"/></svg>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama kamu" required autofocus>
        </div>
      </label>
      <label class="field">
        <span>Email kerja</span>
        <div class="field-input">
          <svg class="icon"><use href="#ic-mail"/></svg>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@perusahaan.com" required>
        </div>
      </label>
      <label class="field">
        <span>Kata sandi</span>
        <div class="field-input">
          <svg class="icon"><use href="#ic-lock"/></svg>
          <input type="password" name="password" placeholder="Minimal 8 karakter" required>
          <svg class="icon toggle-eye"><use href="#ic-eye"/></svg>
        </div>
      </label>
      <label class="field">
        <span>Konfirmasi kata sandi</span>
        <div class="field-input">
          <svg class="icon"><use href="#ic-lock"/></svg>
          <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" required>
        </div>
      </label>
      <label class="checkbox terms">
        <input type="checkbox" name="terms" required>
        <span>Saya setuju dengan Syarat Layanan &amp; Kebijakan Privasi</span>
      </label>
      <button type="submit" class="btn btn-primary auth-submit">
        Buat Akun Gratis <svg class="icon"><use href="#ic-arrow-right"/></svg>
      </button>
    </form>

    <p class="auth-switch">
      Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </p>
  </div>
</div>

<script>
  const field = document.getElementById('starfield');
  for(let i=0;i<90;i++){
    const s = document.createElement('div');
    s.className = 'star';
    const size = Math.random()*2 + 0.5;
    s.style.width = size+'px';
    s.style.height = size+'px';
    s.style.top = Math.random()*100+'%';
    s.style.left = Math.random()*100+'%';
    s.style.animationDelay = (Math.random()*3)+'s';
    s.style.animationDuration = (2 + Math.random()*3)+'s';
    field.appendChild(s);
  }

  document.querySelectorAll('.toggle-eye').forEach(icon => {
    icon.addEventListener('click', () => {
      const input = icon.parentElement.querySelector('input');
      if(input){
        input.type = input.type === 'password' ? 'text' : 'password';
      }
    });
  });

  (function(){
    const root = document.documentElement;
    const fab = document.getElementById('settingsFab');
    const panel = document.getElementById('settingsPanel');

    function getSaved(key, fallback){
      try{ return localStorage.getItem(key) || fallback; }catch(e){ return fallback; }
    }
    function save(key, val){
      try{ localStorage.setItem(key, val); }catch(e){}
    }

    let theme = getSaved('aj-theme', 'dark');
    let accent = getSaved('aj-accent', 'emerald');
    let lang = getSaved('aj-lang', 'id');

    function applyTheme(t){
      theme = t;
      root.setAttribute('data-theme', t);
      save('aj-theme', t);
      document.querySelectorAll('.theme-opt').forEach(el => {
        el.classList.toggle('active', el.getAttribute('data-theme-opt') === t);
      });
    }
    function applyAccent(a){
      accent = a;
      root.setAttribute('data-accent', a);
      save('aj-accent', a);
      document.querySelectorAll('.accent-dot').forEach(el => {
        el.classList.toggle('active', el.getAttribute('data-accent-opt') === a);
      });
    }
    function applyLang(l){
      lang = l;
      save('aj-lang', l);
      root.setAttribute('lang', l === 'en' ? 'en' : 'id');
      document.querySelectorAll('[data-i18n-en]').forEach(el => {
        if(!el.dataset.i18nId) el.dataset.i18nId = el.textContent;
        el.textContent = l === 'en' ? el.getAttribute('data-i18n-en') : el.dataset.i18nId;
      });
      document.querySelectorAll('.lang-opt').forEach(el => {
        el.classList.toggle('active', el.getAttribute('data-lang-opt') === l);
      });
    }

    applyTheme(theme);
    applyAccent(accent);
    applyLang(lang);

    if(fab && panel){
      fab.addEventListener('click', (e) => {
        e.stopPropagation();
        panel.classList.toggle('open');
      });
      document.addEventListener('click', (e) => {
        if(panel.classList.contains('open') && !panel.contains(e.target) && e.target !== fab){
          panel.classList.remove('open');
        }
      });
    }
    document.querySelectorAll('.theme-opt').forEach(el => {
      el.addEventListener('click', () => applyTheme(el.getAttribute('data-theme-opt')));
    });
    document.querySelectorAll('.accent-dot').forEach(el => {
      el.addEventListener('click', () => applyAccent(el.getAttribute('data-accent-opt')));
    });
    document.querySelectorAll('.lang-opt').forEach(el => {
      el.addEventListener('click', () => applyLang(el.getAttribute('data-lang-opt')));
    });
  })();
</script>

</body>
</html>