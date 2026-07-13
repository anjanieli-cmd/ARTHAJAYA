<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Siapkan Akun Bisnismu — Arthajaya</title>

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
    --star-op: 1;
    --emerald-rgb: 52,224,161;
    --glow1-a: 0.16;
    --glow2-a: 0.11;
    --danger: #E8637A;
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
    --star-op: 0;
    --glow1-a: 0.22;
    --glow2-a: 0.16;
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
  .icon{ width:1em; height:1em; }
  button{ font-family:inherit; }

  #starfield{ position:fixed; inset:0; z-index:0; pointer-events:none; overflow:hidden; opacity: var(--star-op); transition: opacity .35s ease; }
  .star{ position:absolute; border-radius:50%; background:#fff; animation: twinkle 3s ease-in-out infinite; }
  @keyframes twinkle{ 0%,100%{opacity:.15;} 50%{opacity:.9;} }
  .bg-glow{ position:fixed; top:-25%; right:-10%; width:900px; height:900px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow1-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }
  .bg-glow-2{ position:fixed; bottom:-15%; left:-15%; width:700px; height:700px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow2-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }

  .topbar{ position:relative; z-index:5; display:flex; align-items:center; justify-content:space-between; padding:22px 32px; max-width:1180px; margin:0 auto; }
  .logo{ display:flex; align-items:center; gap:10px; font-family:'Space Grotesk'; font-weight:700; font-size:18px; }
  .logo-mark{ width:30px; height:30px; border-radius:9px; background:var(--surface-strong); border:1px solid var(--border-hover); display:flex; align-items:center; justify-content:center; overflow:hidden; padding:3px; }
  .logo-mark img{ width:100%; height:100%; object-fit:contain; }
  .logo .dot{ color:var(--emerald); }
  .exit-link{ font-size:13.5px; color:var(--text-mute); display:flex; align-items:center; gap:7px; transition: color .2s ease; background:none; border:none; cursor:pointer; }
  .exit-link:hover{ color:var(--text); }
  .exit-link .icon{ width:14px; height:14px; }

  .wizard-wrap{ position:relative; z-index:2; max-width:1180px; margin:0 auto; padding:10px 32px 80px; display:grid; grid-template-columns:280px 1fr; gap:44px; align-items:start; }

  .stepper{ position:sticky; top:30px; display:flex; flex-direction:column; }
  .stepper .eyebrow-mini{ font-size:12px; color:var(--text-faint); text-transform:uppercase; letter-spacing:.08em; margin-bottom:20px; }
  .step-row{ display:flex; gap:14px; position:relative; padding-bottom:30px; }
  .step-row:last-child{ padding-bottom:0; }
  .step-row::before{ content:''; position:absolute; left:15px; top:32px; bottom:0; width:1.5px; background:var(--border); }
  .step-row:last-child::before{ display:none; }
  .step-row.done::before{ background: var(--emerald-dim); }
  .step-dot{ width:31px; height:31px; border-radius:50%; background:var(--surface); border:1.5px solid var(--border); display:flex; align-items:center; justify-content:center; font-family:'IBM Plex Mono'; font-size:12.5px; color:var(--text-faint); flex-shrink:0; transition: all .3s ease; z-index:1; }
  .step-row.active .step-dot{ border-color:var(--emerald); color:var(--emerald); background:rgba(var(--emerald-rgb),0.1); box-shadow:0 0 0 4px rgba(var(--emerald-rgb),0.08); }
  .step-row.done .step-dot{ border-color:var(--emerald-dim); background:var(--emerald); color:#052117; }
  .step-dot .icon{ width:13px; height:13px; }
  .step-copy{ padding-top:4px; }
  .step-copy .t{ font-size:14.5px; font-weight:600; color:var(--text-mute); transition: color .3s ease; }
  .step-row.active .step-copy .t{ color:var(--text); }
  .step-row.done .step-copy .t{ color:var(--text); }
  .step-copy .d{ font-size:12px; color:var(--text-faint); margin-top:3px; max-width:190px; }

  .mobile-progress{ display:none; z-index:2; position:relative; margin-bottom:26px; }
  .mobile-progress .mp-top{ display:flex; justify-content:space-between; font-size:12.5px; color:var(--text-mute); margin-bottom:10px; }
  .mobile-progress .mp-top b{ color:var(--emerald); font-weight:600; }
  .mp-bar{ height:6px; border-radius:100px; background:var(--surface-strong); overflow:hidden; }
  .mp-fill{ height:100%; background:linear-gradient(90deg,var(--emerald-dim),var(--emerald)); border-radius:100px; transition: width .4s cubic-bezier(.4,0,.2,1); }

  .panel{ background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:40px 44px; backdrop-filter:blur(10px); min-height:480px; display:flex; flex-direction:column; }
  .panel-head{ margin-bottom:30px; }
  .panel-head .tag{ font-size:12.5px; color:var(--emerald); font-weight:600; text-transform:uppercase; letter-spacing:.06em; margin-bottom:10px; display:block; }
  .panel-head h2{ font-size:26px; margin-bottom:8px; }
  .panel-head p{ font-size:14px; color:var(--text-mute); max-width:480px; }

  .field-grid{ display:grid; grid-template-columns:1fr 1fr; gap:18px; }
  .field-grid .full{ grid-column: 1 / -1; }
  .field{ display:flex; flex-direction:column; gap:7px; }
  .field label{ font-size:12.5px; color:var(--text-mute); font-weight:500; }
  .field label .opt{ color:var(--text-faint); font-weight:400; }
  .field input[type=text], .field input[type=number], .field input[type=email], .field input[type=tel], .field select, .field textarea{
    width:100%; padding:12px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border);
    color:var(--text); font-family:'Inter'; font-size:14px; outline:none; transition: border-color .2s ease, background .2s ease;
    appearance:none;
  }
  .field select{
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
    background-repeat:no-repeat; background-position: right 14px center; background-size:14px; padding-right:38px;
  }
  .field input:focus, .field select:focus, .field textarea:focus{ border-color: var(--border-hover); background:var(--surface); }
  .field textarea{ resize:vertical; min-height:80px; font-family:'Inter'; }
  .field-hint{ font-size:11.5px; color:var(--text-faint); }
  .field-error{ font-size:12px; color:var(--danger); margin-top:2px; }

  .choice-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
  .choice-card{ background:var(--surface-strong); border:1px solid var(--border); border-radius:14px; padding:16px 14px; cursor:pointer; transition: all .2s ease; display:flex; flex-direction:column; gap:8px; }
  .choice-card:hover{ border-color:var(--border-hover); }
  .choice-card.selected{ border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.09); }
  .choice-card .ic{ width:32px; height:32px; border-radius:9px; background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); display:flex; align-items:center; justify-content:center; }
  .choice-card .ic .icon{ width:16px; height:16px; }
  .choice-card .name{ font-size:13.5px; font-weight:600; }
  .choice-card .desc{ font-size:11.5px; color:var(--text-faint); line-height:1.4; }

  .logo-upload{ display:flex; align-items:center; gap:16px; }
  .logo-drop{ width:74px; height:74px; border-radius:16px; border:1.5px dashed var(--border); background:var(--surface-strong); display:flex; align-items:center; justify-content:center; color:var(--text-faint); flex-shrink:0; overflow:hidden; cursor:pointer; transition: border-color .2s ease; }
  .logo-drop:hover{ border-color:var(--border-hover); }
  .logo-drop img{ width:100%; height:100%; object-fit:cover; display:none; }
  .logo-drop .icon{ width:22px; height:22px; }
  .logo-upload-copy{ font-size:12.5px; color:var(--text-mute); }
  .logo-upload-copy .btn-outline{ margin-top:8px; padding:8px 14px; font-size:12.5px; }

  .preview-strip{ display:flex; gap:14px; margin-top:6px; }
  .mini-badge{ padding:9px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border); font-size:12.5px; color:var(--text-mute); display:flex; align-items:center; gap:8px; }
  .mini-badge b{ color:var(--text); font-family:'IBM Plex Mono'; font-weight:500; }

  .invite-row{ display:grid; grid-template-columns:1fr 170px 40px; gap:10px; margin-bottom:12px; align-items:center; }
  .invite-remove{ width:38px; height:38px; border-radius:10px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--text-faint); cursor:pointer; transition:all .2s ease; }
  .invite-remove:hover{ color:var(--danger); border-color:var(--danger); }
  .invite-remove .icon{ width:14px; height:14px; }
  .add-invite{ display:inline-flex; align-items:center; gap:8px; font-size:13px; color:var(--emerald); cursor:pointer; margin-top:4px; width:fit-content; background:none; border:none; }
  .add-invite .icon{ width:15px; height:15px; }
  .invite-skip-note{ font-size:12.5px; color:var(--text-faint); margin-top:18px; padding-top:18px; border-top:1px solid var(--border); }

  .summary-list{ display:flex; flex-direction:column; gap:0; border:1px solid var(--border); border-radius:16px; overflow:hidden; }
  .summary-block{ padding:18px 20px; border-bottom:1px solid var(--border); }
  .summary-block:last-child{ border-bottom:none; }
  .summary-block-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
  .summary-block-head span{ font-size:12px; color:var(--text-faint); text-transform:uppercase; letter-spacing:.06em; }
  .summary-block-head a{ font-size:12.5px; color:var(--emerald); font-weight:600; cursor:pointer; }
  .summary-rows{ display:grid; grid-template-columns:1fr 1fr; gap:8px 20px; }
  .summary-rows div{ font-size:13.5px; }
  .summary-rows .k{ color:var(--text-faint); }
  .summary-rows .v{ color:var(--text); font-weight:500; }

  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 24px; border-radius:12px; font-size:14.5px; font-weight:600; cursor:pointer; border:none; transition:all .25s ease; font-family:'Inter'; }
  .btn .icon{ width:16px; height:16px; transition: transform .25s ease; }
  .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 24px rgba(var(--emerald-rgb),0.35); }
  .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 10px 32px rgba(var(--emerald-rgb),0.5); }
  .btn-primary:hover .icon{ transform: translateX(3px); }
  .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .btn-outline:hover{ background:var(--surface-strong); border-color: var(--border-hover); }
  .btn-text{ background:none; color:var(--text-mute); padding:12px 10px; }
  .btn-text:hover{ color:var(--text); }
  .btn:disabled{ opacity:.4; cursor:not-allowed; transform:none !important; box-shadow:none !important; }

  .panel-actions{ margin-top:auto; padding-top:34px; display:flex; justify-content:space-between; align-items:center; }
  .panel-actions .right-actions{ display:flex; gap:10px; align-items:center; }

  .required-flag{ font-size:12px; color:var(--danger); margin-top:-10px; display:none; }
  .required-flag.show{ display:block; }

  .wizard-step{ display:none; animation: stepIn .35s ease; }
  .wizard-step.active{ display:flex; flex-direction:column; flex:1; }
  @keyframes stepIn{ from{ opacity:0; transform: translateY(10px); } to{ opacity:1; transform:translateY(0); } }

  .success-screen{ display:none; position:relative; z-index:2; max-width:560px; margin:70px auto; text-align:center; padding:0 24px; }
  .success-screen.active{ display:block; }
  .success-check{ width:86px; height:86px; border-radius:50%; background:rgba(var(--emerald-rgb),0.12); border:1.5px solid rgba(var(--emerald-rgb),0.4); display:flex; align-items:center; justify-content:center; margin:0 auto 26px; color:var(--emerald); animation: popIn .5s cubic-bezier(.34,1.56,.64,1); }
  .success-check .icon{ width:38px; height:38px; }
  @keyframes popIn{ 0%{ transform:scale(0); opacity:0; } 100%{ transform:scale(1); opacity:1; } }
  .success-screen h1{ font-size:30px; margin-bottom:12px; }
  .success-screen p{ font-size:15px; color:var(--text-mute); margin-bottom:34px; }
  .success-recap{ display:flex; justify-content:center; gap:28px; margin-bottom:38px; flex-wrap:wrap; }
  .success-recap .item{ text-align:left; }
  .success-recap .lbl{ font-size:11.5px; color:var(--text-faint); margin-bottom:4px; }
  .success-recap .val{ font-size:14px; font-weight:600; font-family:'Space Grotesk'; }
  .success-actions{ display:flex; gap:12px; justify-content:center; }

  .settings-fab{ position:fixed; right:22px; bottom:22px; z-index:150; width:50px; height:50px; border-radius:50%; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; cursor:pointer; color:var(--text); box-shadow:0 10px 30px rgba(0,0,0,0.35); backdrop-filter:blur(10px); transition: transform .25s ease, border-color .25s ease; }
  .settings-fab:hover{ transform: translateY(-3px) rotate(20deg); border-color:var(--border-hover); }
  .settings-fab .icon{ width:20px; height:20px; }
  .settings-panel{ position:fixed; right:22px; bottom:82px; z-index:150; width:230px; background:var(--modal-bg); border:1px solid var(--border); border-radius:18px; padding:18px; box-shadow:0 30px 70px rgba(0,0,0,0.45); opacity:0; visibility:hidden; transform: translateY(10px) scale(.97); transition: opacity .22s ease, transform .22s ease, visibility .22s; }
  .settings-panel.open{ opacity:1; visibility:visible; transform: translateY(0) scale(1); }
  .settings-panel h4{ font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); margin-bottom:10px; }
  .settings-block{ margin-bottom:16px; }
  .settings-block:last-child{ margin-bottom:0; }
  .theme-toggle-row{ display:flex; gap:8px; }
  .theme-opt{ flex:1; display:flex; flex-direction:column; align-items:center; gap:5px; padding:9px 6px; border-radius:12px; border:1px solid var(--border); background:var(--surface); color:var(--text-mute); font-size:11px; cursor:pointer; transition: all .2s ease; }
  .theme-opt .icon{ width:14px; height:14px; }
  .theme-opt.active{ color:var(--emerald); border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }
  .accent-row{ display:flex; gap:9px; }
  .accent-dot{ width:24px; height:24px; border-radius:50%; cursor:pointer; border:2px solid transparent; transition: transform .2s ease; }
  .accent-dot:hover{ transform: scale(1.1); }
  .accent-dot.active{ border-color: var(--text); }

  @media (max-width: 900px){
    .wizard-wrap{ grid-template-columns:1fr; padding:0 20px 60px; }
    .stepper{ display:none; }
    .mobile-progress{ display:block; }
    .panel{ padding:28px 22px; }
    .field-grid{ grid-template-columns:1fr; }
    .choice-grid{ grid-template-columns:repeat(2,1fr); }
    .invite-row{ grid-template-columns:1fr; }
    .invite-remove{ width:100%; }
    .summary-rows{ grid-template-columns:1fr; }
    .topbar{ padding:18px 20px; }
  }
  @media (max-width:480px){
    .panel-head h2{ font-size:21px; }
    .choice-grid{ grid-template-columns:1fr 1fr; }
    .panel-actions{ flex-direction:column-reverse; gap:14px; align-items:stretch; }
    .panel-actions .right-actions{ justify-content:space-between; }
    .btn{ width:100%; }
    .success-recap{ gap:18px; }
  }
</style>
</head>
<body>

<div id="starfield"></div>
<div class="bg-glow"></div>
<div class="bg-glow-2"></div>

<svg width="0" height="0" style="position:absolute">
<defs>
  <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></symbol>
  <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
  <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></symbol>
  <symbol id="ic-logout" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></symbol>
  <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/></symbol>
  <symbol id="ic-crown" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m2 18 2-11 5 5 3-7 3 7 5-5 2 11z"/><path d="M4 21h16"/></symbol>
  <symbol id="ic-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></symbol>
  <symbol id="ic-calculator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="11" x2="8" y2="11"/><line x1="12" y1="11" x2="12" y2="11"/><line x1="16" y1="11" x2="16" y2="11"/><line x1="8" y1="15" x2="8" y2="15"/><line x1="12" y1="15" x2="12" y2="15"/><line x1="16" y1="15" x2="16" y2="15"/><line x1="8" y1="19" x2="16" y2="19"/></symbol>
  <symbol id="ic-clipboard" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-2"/></symbol>
  <symbol id="ic-dots-h" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="5" cy="12" r="1.4"/><circle cx="12" cy="12" r="1.4"/><circle cx="19" cy="12" r="1.4"/></symbol>
  <symbol id="ic-image" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></symbol>
  <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
  <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
  <symbol id="ic-gear" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></symbol>
  <symbol id="ic-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4.5"/><path d="M12 2v2.5M12 19.5V22M4.2 4.2l1.8 1.8M18 18l1.8 1.8M2 12h2.5M19.5 12H22M4.2 19.8 6 18M18 6l1.8-1.8"/></symbol>
  <symbol id="ic-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.5a8.5 8.5 0 1 1-9.5-11.4 7 7 0 0 0 9.5 11.4z"/></symbol>
</defs>
</svg>

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
      <div class="accent-dot" data-accent-opt="emerald" style="background:#34E0A1"></div>
      <div class="accent-dot" data-accent-opt="blue" style="background:#4E8FF0"></div>
      <div class="accent-dot" data-accent-opt="purple" style="background:#9B7BE0"></div>
      <div class="accent-dot" data-accent-opt="orange" style="background:#F0A25A"></div>
      <div class="accent-dot" data-accent-opt="pink" style="background:#E85A9C"></div>
    </div>
  </div>
</div>

<div class="topbar">
  <div class="logo"><span class="logo-mark"><img src="{{ asset('logo.png') }}" alt="Arthajaya"></span>Artha<span class="dot">jaya</span></div>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="exit-link"><svg class="icon"><use href="#ic-logout"/></svg> Simpan &amp; keluar</button>
  </form>
</div>

@if(session('completed'))
  {{-- ============ SUCCESS SCREEN (ditampilkan sekali setelah submit sukses) ============ --}}
  <div class="success-screen active" id="successScreen">
    <div class="success-check"><svg class="icon"><use href="#ic-check"/></svg></div>
    <h1>Setup selesai, {{ explode(' ', Auth::user()->name)[0] }}!</h1>
    <p>Akun bisnis <b>{{ $company->name ?? 'perusahaanmu' }}</b> sudah siap dipakai. Dashboard keuanganmu sudah menunggu.</p>
    <div class="success-recap">
      <div class="item"><div class="lbl">Perusahaan</div><div class="val">{{ $company->name ?? '—' }}</div></div>
      <div class="item"><div class="lbl">Mata Uang</div><div class="val">{{ $company->currency ?? '—' }}</div></div>
      <div class="item"><div class="lbl">Saldo Awal</div><div class="val">Rp{{ number_format($company->accounts->first()->initial_balance ?? 0, 0, ',', '.') }}</div></div>
    </div>
    <div class="success-actions">
      <a href="{{ route('dashboard') }}" class="btn btn-primary">Masuk ke Dashboard <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
    </div>
  </div>

@else
  {{-- ============ WIZARD FORM ============ --}}
  <form id="onboardingForm" method="POST" action="{{ route('onboarding.store') }}" enctype="multipart/form-data">
    @csrf

    <div id="wizardScreen">
      <div class="mobile-progress" style="max-width:1180px;margin:0 auto;padding:0 20px;">
        <div class="mp-top"><span>Langkah <b id="mpCurrent">1</b> dari <span id="mpTotal">7</span></span><span id="mpStepName">Peran Kamu</span></div>
        <div class="mp-bar"><div class="mp-fill" id="mpFill" style="width:14%"></div></div>
      </div>

      <div class="wizard-wrap">
        <aside class="stepper">
          <span class="eyebrow-mini">Setup Akun Bisnis</span>
          <div class="step-row active" data-step-index="0"><div class="step-dot"><span>1</span></div><div class="step-copy"><div class="t">Peran Kamu</div><div class="d">Siapa kamu di perusahaan ini</div></div></div>
          <div class="step-row" data-step-index="1"><div class="step-dot"><span>2</span></div><div class="step-copy"><div class="t">Data Perusahaan</div><div class="d">Profil dan identitas bisnis</div></div></div>
          <div class="step-row" data-step-index="2"><div class="step-dot"><span>3</span></div><div class="step-copy"><div class="t">Regional</div><div class="d">Mata uang &amp; zona waktu</div></div></div>
          <div class="step-row" data-step-index="3"><div class="step-dot"><span>4</span></div><div class="step-copy"><div class="t">Tahun Fiskal</div><div class="d">Periode tahun buku</div></div></div>
          <div class="step-row" data-step-index="4"><div class="step-dot"><span>5</span></div><div class="step-copy"><div class="t">Rekening Awal</div><div class="d">Saldo kas &amp; bank</div></div></div>
          <div class="step-row" data-step-index="5"><div class="step-dot"><span>6</span></div><div class="step-copy"><div class="t">Undang Tim</div><div class="d">Opsional, bisa dilewati</div></div></div>
          <div class="step-row" data-step-index="6"><div class="step-dot"><span>7</span></div><div class="step-copy"><div class="t">Ringkasan</div><div class="d">Cek ulang sebelum mulai</div></div></div>
        </aside>

        <div class="panel">

          {{-- STEP 1: PERAN --}}
          <div class="wizard-step active" data-step="0">
            <div class="panel-head">
              <span class="tag">Langkah 1 dari 7</span>
              <h2>Kamu berperan sebagai apa?</h2>
              <p>Ini membantu kami menyesuaikan tampilan dashboard dan hak akses sesuai posisimu.</p>
            </div>
            <div class="field-grid">
              <div class="field full">
                <label>Nama lengkap</label>
                <input type="text" name="name" id="f-nama" value="{{ old('name', Auth::user()->name) }}" placeholder="cth. Anjani Wulandari">
                @error('name') <div class="field-error">{{ $message }}</div> @enderror
              </div>
              <div class="field full">
                <label>No. HP <span class="opt">(opsional)</span></label>
                <input type="tel" name="phone" id="f-hp" value="{{ old('phone') }}" placeholder="cth. 0812xxxxxxx">
              </div>
            </div>
            <div class="field full" style="margin-top:20px;">
              <label style="margin-bottom:12px;display:block;">Jabatan / peran kamu</label>
              <input type="hidden" name="role" id="f-role" value="{{ old('role') }}">
              <div class="choice-grid" id="roleGrid">
                <div class="choice-card" data-value="Pemilik Bisnis"><div class="ic"><svg class="icon"><use href="#ic-crown"/></svg></div><div class="name">Pemilik Bisnis</div><div class="desc">Owner / Founder</div></div>
                <div class="choice-card" data-value="Direktur / CEO"><div class="ic"><svg class="icon"><use href="#ic-briefcase"/></svg></div><div class="name">Direktur / CEO</div><div class="desc">Pimpinan perusahaan</div></div>
                <div class="choice-card" data-value="Manajer Keuangan"><div class="ic"><svg class="icon"><use href="#ic-calculator"/></svg></div><div class="name">Manajer Keuangan</div><div class="desc">Finance Manager</div></div>
                <div class="choice-card" data-value="Akuntan"><div class="ic"><svg class="icon"><use href="#ic-clipboard"/></svg></div><div class="name">Akuntan</div><div class="desc">Accountant / Bookkeeper</div></div>
                <div class="choice-card" data-value="Staff Administrasi"><div class="ic"><svg class="icon"><use href="#ic-user"/></svg></div><div class="name">Staff Administrasi</div><div class="desc">Admin / Operasional</div></div>
                <div class="choice-card" data-value="Lainnya"><div class="ic"><svg class="icon"><use href="#ic-dots-h"/></svg></div><div class="name">Lainnya</div><div class="desc">Peran lain</div></div>
              </div>
              <div class="required-flag" id="rf-role">Pilih salah satu peran untuk melanjutkan.</div>
              @error('role') <div class="field-error">{{ $message }}</div> @enderror
            </div>
          </div>

          {{-- STEP 2: DATA PERUSAHAAN --}}
          <div class="wizard-step" data-step="1">
            <div class="panel-head">
              <span class="tag">Langkah 2 dari 7</span>
              <h2>Ceritakan tentang perusahaanmu</h2>
              <p>Data ini akan muncul di faktur, laporan, dan dokumen resmi lain yang kamu buat di Arthajaya.</p>
            </div>

            <div class="logo-upload" style="margin-bottom:24px;">
              <div class="logo-drop" id="logoDrop"><svg class="icon"><use href="#ic-image"/></svg><img id="logoPreview" alt=""></div>
              <div class="logo-upload-copy">
                <div>Unggah logo perusahaan <span class="opt">(opsional)</span></div>
                <div class="field-hint">PNG atau JPG, maks 2MB, disarankan rasio 1:1</div>
                <a class="btn btn-outline" style="margin-top:8px;display:inline-flex;">Pilih File</a>
                <input type="file" name="logo" id="logoInput" accept="image/*" style="display:none;">
              </div>
            </div>

            <div class="field-grid">
              <div class="field full">
                <label>Nama perusahaan</label>
                <input type="text" name="company_name" id="f-company" value="{{ old('company_name') }}" placeholder="cth. PT Andalas Maju Bersama">
                @error('company_name') <div class="field-error">{{ $message }}</div> @enderror
              </div>
              <div class="field">
                <label>Jenis industri</label>
                <select name="industry" id="f-industry">
                  <option value="">Pilih industri</option>
                  @foreach(['Retail & E-commerce','Jasa & Konsultasi','Manufaktur','Teknologi / Software','F&B / Kuliner','Logistik & Distribusi','Konstruksi & Properti','Lainnya'] as $opt)
                    <option value="{{ $opt }}" @selected(old('industry')===$opt)>{{ $opt }}</option>
                  @endforeach
                </select>
              </div>
              <div class="field">
                <label>Ukuran bisnis</label>
                <select name="business_size" id="f-size">
                  <option value="">Jumlah karyawan</option>
                  <option @selected(old('business_size')==='1-10')>1–10 karyawan</option>
                  <option @selected(old('business_size')==='11-50')>11–50 karyawan</option>
                  <option @selected(old('business_size')==='51-200')>51–200 karyawan</option>
                  <option @selected(old('business_size')==='200+')>200+ karyawan</option>
                </select>
              </div>
              <div class="field">
                <label>Negara</label>
                <select name="country" id="f-country">
                  <option>Indonesia</option><option>Malaysia</option><option>Singapura</option><option>Lainnya</option>
                </select>
              </div>
              <div class="field">
                <label>Kota</label>
                <input type="text" name="city" id="f-city" value="{{ old('city') }}" placeholder="cth. Surabaya">
              </div>
              <div class="field full">
                <label>Alamat lengkap</label>
                <textarea name="address" id="f-address" placeholder="Jalan, nomor, kecamatan, kode pos">{{ old('address') }}</textarea>
              </div>
            </div>
          </div>

          {{-- STEP 3: REGIONAL --}}
          <div class="wizard-step" data-step="2">
            <div class="panel-head">
              <span class="tag">Langkah 3 dari 7</span>
              <h2>Pengaturan regional</h2>
              <p>Menentukan format mata uang, tanggal, dan zona waktu di seluruh laporan keuanganmu.</p>
            </div>
            <div class="field-grid">
              <div class="field">
                <label>Mata uang utama</label>
                <select name="currency" id="f-currency">
                  <option value="IDR">IDR — Rupiah Indonesia</option>
                  <option value="USD">USD — Dolar Amerika</option>
                  <option value="SGD">SGD — Dolar Singapura</option>
                  <option value="MYR">MYR — Ringgit Malaysia</option>
                </select>
              </div>
              <div class="field">
                <label>Zona waktu</label>
                <select name="timezone" id="f-timezone">
                  <option>WIB — Jakarta (GMT+7)</option>
                  <option>WITA — Makassar (GMT+8)</option>
                  <option>WIT — Jayapura (GMT+9)</option>
                </select>
              </div>
              <div class="field">
                <label>Format tanggal</label>
                <select name="date_format" id="f-dateformat">
                  <option value="DD/MM/YYYY">DD/MM/YYYY — 31/12/2026</option>
                  <option value="MM/DD/YYYY">MM/DD/YYYY — 12/31/2026</option>
                  <option value="YYYY-MM-DD">YYYY-MM-DD — 2026-12-31</option>
                </select>
              </div>
              <div class="field">
                <label>Bahasa laporan</label>
                <select name="report_language" id="f-lang">
                  <option value="id">Bahasa Indonesia</option>
                  <option value="en">English</option>
                </select>
              </div>
            </div>
            <div class="preview-strip">
              <div class="mini-badge">Contoh nominal: <b id="prevCurrency">Rp 1.250.000</b></div>
              <div class="mini-badge">Contoh tanggal: <b id="prevDate">13/07/2026</b></div>
            </div>
          </div>

          {{-- STEP 4: TAHUN FISKAL --}}
          <div class="wizard-step" data-step="3">
            <div class="panel-head">
              <span class="tag">Langkah 4 dari 7</span>
              <h2>Kapan tahun buku dimulai?</h2>
              <p>Tahun fiskal menentukan periode laporan laba rugi dan neraca tahunanmu. Kebanyakan bisnis di Indonesia memakai Januari–Desember.</p>
            </div>
            <div class="field-grid">
              <div class="field">
                <label>Bulan mulai tahun fiskal</label>
                <select name="fiscal_start_month" id="f-fiscalstart">
                  @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m)
                    <option @selected(old('fiscal_start_month')===$m)>{{ $m }}</option>
                  @endforeach
                </select>
              </div>
              <div class="field">
                <label>Tahun buku aktif</label>
                @php($currentYear = date('Y'))
                <select name="fiscal_year" id="f-fiscalyear">
                  <option>{{ $currentYear }}</option>
                  <option>{{ $currentYear + 1 }}</option>
                </select>
              </div>
            </div>
            <div class="field-hint" style="margin-top:14px;">Kamu selalu bisa mengubah pengaturan ini nanti di menu Pengaturan &gt; Keuangan.</div>
          </div>

          {{-- STEP 5: REKENING AWAL --}}
          <div class="wizard-step" data-step="4">
            <div class="panel-head">
              <span class="tag">Langkah 5 dari 7</span>
              <h2>Tambahkan rekening kas atau bank</h2>
              <p>Saldo awal ini jadi titik mulai perhitungan arus kas otomatis. Bisa ditambah lagi nanti di menu Bank.</p>
            </div>
            <div class="field-grid">
              <div class="field">
                <label>Nama bank</label>
                <select name="bank_name" id="f-bank">
                  <option value="">Pilih bank</option>
                  <option>BCA</option><option>BRI</option><option>BNI</option><option>Mandiri</option>
                  <option>CIMB Niaga</option><option>Kas Tunai (tanpa bank)</option><option>Lainnya</option>
                </select>
              </div>
              <div class="field">
                <label>Nama rekening</label>
                <input type="text" name="account_name" id="f-acctname" value="{{ old('account_name') }}" placeholder="cth. PT Andalas Maju Bersama">
              </div>
              <div class="field">
                <label>Nomor rekening <span class="opt">(opsional)</span></label>
                <input type="text" name="account_number" id="f-acctnum" value="{{ old('account_number') }}" placeholder="cth. 1234567890">
              </div>
              <div class="field">
                <label>Saldo awal (Rp)</label>
                <input type="number" name="initial_balance" id="f-balance" value="{{ old('initial_balance', 0) }}" min="0">
              </div>
            </div>
            <div class="field-hint" style="margin-top:14px;">Belum tahu saldo pastinya? Kamu bisa isi 0 dulu dan sesuaikan setelah rekonsiliasi bank.</div>
          </div>

          {{-- STEP 6: UNDANG TIM --}}
          <div class="wizard-step" data-step="5">
            <div class="panel-head">
              <span class="tag">Langkah 6 dari 7 · Opsional</span>
              <h2>Undang anggota tim</h2>
              <p>Ajak rekan kerja untuk kolaborasi langsung. Lewati dulu kalau mau kerjakan sendiri — bisa diundang kapan saja nanti.</p>
            </div>
            <div id="inviteList">
              <div class="invite-row">
                <input type="email" name="invite_email[]" placeholder="nama@perusahaan.com" class="invite-email">
                <select name="invite_role[]" class="invite-role">
                  <option>Akuntan</option>
                  <option>Manajer Keuangan</option>
                  <option>Staff Administrasi</option>
                  <option>Hanya Lihat (Viewer)</option>
                </select>
                <div class="invite-remove" onclick="removeInvite(this)"><svg class="icon"><use href="#ic-trash"/></svg></div>
              </div>
            </div>
            <button type="button" class="add-invite" onclick="addInvite()"><svg class="icon"><use href="#ic-plus"/></svg> Tambah anggota lain</button>
            <div class="invite-skip-note">Kamu bisa klik "Lewati" di bawah untuk melanjutkan tanpa mengundang siapa pun sekarang.</div>
          </div>

          {{-- STEP 7: RINGKASAN --}}
          <div class="wizard-step" data-step="6">
            <div class="panel-head">
              <span class="tag">Langkah 7 dari 7</span>
              <h2>Cek ulang sebelum mulai</h2>
              <p>Pastikan semua informasi sudah benar. Semua ini bisa diubah kapan saja lewat menu Pengaturan.</p>
            </div>
            <div class="summary-list">
              <div class="summary-block">
                <div class="summary-block-head"><span>Peran Kamu</span><a onclick="goTo(0)">Ubah</a></div>
                <div class="summary-rows">
                  <div><div class="k">Nama</div><div class="v" id="sum-nama">—</div></div>
                  <div><div class="k">Jabatan</div><div class="v" id="sum-role">—</div></div>
                </div>
              </div>
              <div class="summary-block">
                <div class="summary-block-head"><span>Perusahaan</span><a onclick="goTo(1)">Ubah</a></div>
                <div class="summary-rows">
                  <div><div class="k">Nama perusahaan</div><div class="v" id="sum-company">—</div></div>
                  <div><div class="k">Industri</div><div class="v" id="sum-industry">—</div></div>
                  <div><div class="k">Kota</div><div class="v" id="sum-city">—</div></div>
                  <div><div class="k">Ukuran</div><div class="v" id="sum-size">—</div></div>
                </div>
              </div>
              <div class="summary-block">
                <div class="summary-block-head"><span>Regional &amp; Fiskal</span><a onclick="goTo(2)">Ubah</a></div>
                <div class="summary-rows">
                  <div><div class="k">Mata uang</div><div class="v" id="sum-currency">—</div></div>
                  <div><div class="k">Zona waktu</div><div class="v" id="sum-timezone">—</div></div>
                  <div><div class="k">Tahun fiskal mulai</div><div class="v" id="sum-fiscal">—</div></div>
                </div>
              </div>
              <div class="summary-block">
                <div class="summary-block-head"><span>Rekening Awal</span><a onclick="goTo(4)">Ubah</a></div>
                <div class="summary-rows">
                  <div><div class="k">Bank</div><div class="v" id="sum-bank">—</div></div>
                  <div><div class="k">Saldo awal</div><div class="v" id="sum-balance">—</div></div>
                </div>
              </div>
              <div class="summary-block">
                <div class="summary-block-head"><span>Anggota Tim</span><a onclick="goTo(5)">Ubah</a></div>
                <div class="summary-rows"><div style="grid-column:1/-1;" id="sum-invites">Belum ada undangan dikirim.</div></div>
              </div>
            </div>
          </div>

          <div class="panel-actions">
            <button type="button" class="btn btn-text" id="btnBack" onclick="prevStep()"><svg class="icon"><use href="#ic-arrow-left"/></svg> Kembali</button>
            <div class="right-actions">
              <button type="button" class="btn btn-text" id="btnSkip" onclick="nextStep(true)" style="display:none;">Lewati</button>
              <button type="button" class="btn btn-primary" id="btnNext" onclick="nextStep(false)">Lanjutkan <svg class="icon"><use href="#ic-arrow-right"/></svg></button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </form>
@endif

<script>
  // starfield
  const field = document.getElementById('starfield');
  if(field){
    for(let i=0;i<70;i++){
      const s = document.createElement('div');
      s.className = 'star';
      const size = Math.random()*2 + 0.5;
      s.style.width = size+'px'; s.style.height = size+'px';
      s.style.top = Math.random()*100+'%'; s.style.left = Math.random()*100+'%';
      s.style.animationDelay = (Math.random()*3)+'s';
      s.style.animationDuration = (2 + Math.random()*3)+'s';
      field.appendChild(s);
    }
  }

  // settings widget (theme/accent)
  (function(){
    const root = document.documentElement;
    const fab = document.getElementById('settingsFab');
    const panel = document.getElementById('settingsPanel');
    function getSaved(key, fb){ try{ return localStorage.getItem(key) || fb; }catch(e){ return fb; } }
    function save(key, val){ try{ localStorage.setItem(key, val); }catch(e){} }
    let theme = getSaved('aj-theme','dark');
    let accent = getSaved('aj-accent','emerald');
    function applyTheme(t){ theme=t; root.setAttribute('data-theme',t); save('aj-theme',t);
      document.querySelectorAll('.theme-opt').forEach(el=>el.classList.toggle('active', el.dataset.themeOpt===t)); }
    function applyAccent(a){ accent=a; root.setAttribute('data-accent',a); save('aj-accent',a);
      document.querySelectorAll('.accent-dot').forEach(el=>el.classList.toggle('active', el.dataset.accentOpt===a)); }
    applyTheme(theme); applyAccent(accent);
    if(fab){
      fab.addEventListener('click', e=>{ e.stopPropagation(); panel.classList.toggle('open'); });
      document.addEventListener('click', e=>{ if(panel.classList.contains('open') && !panel.contains(e.target) && e.target!==fab) panel.classList.remove('open'); });
    }
    document.querySelectorAll('.theme-opt').forEach(el=>el.addEventListener('click', ()=>applyTheme(el.dataset.themeOpt)));
    document.querySelectorAll('.accent-dot').forEach(el=>el.addEventListener('click', ()=>applyAccent(el.dataset.accentOpt)));
  })();

  @if(!session('completed'))
  // ===== role choice cards =====
  const roleHidden = document.getElementById('f-role');
  document.querySelectorAll('#roleGrid .choice-card').forEach(card=>{
    if(roleHidden.value && card.dataset.value === roleHidden.value) card.classList.add('selected');
    card.addEventListener('click', ()=>{
      document.querySelectorAll('#roleGrid .choice-card').forEach(c=>c.classList.remove('selected'));
      card.classList.add('selected');
      roleHidden.value = card.dataset.value;
      document.getElementById('rf-role').classList.remove('show');
    });
  });

  // ===== logo upload preview =====
  const logoDrop = document.getElementById('logoDrop');
  const logoInput = document.getElementById('logoInput');
  const logoPreview = document.getElementById('logoPreview');
  logoDrop.addEventListener('click', ()=> logoInput.click());
  logoInput.addEventListener('change', ()=>{
    const file = logoInput.files[0];
    if(file){
      const reader = new FileReader();
      reader.onload = e=>{ logoPreview.src = e.target.result; logoPreview.style.display='block'; };
      reader.readAsDataURL(file);
    }
  });

  // ===== currency/date live preview =====
  function updateRegionalPreview(){
    const cur = document.getElementById('f-currency').value;
    const symbolMap = {IDR:'Rp', USD:'$', SGD:'S$', MYR:'RM'};
    document.getElementById('prevCurrency').textContent = (symbolMap[cur]||'Rp') + ' 1.250.000';
    const fmt = document.getElementById('f-dateformat').value;
    let dateStr = '13/07/2026';
    if(fmt.startsWith('MM')) dateStr = '07/13/2026';
    if(fmt.startsWith('YYYY')) dateStr = '2026-07-13';
    document.getElementById('prevDate').textContent = dateStr;
  }
  document.getElementById('f-currency').addEventListener('change', updateRegionalPreview);
  document.getElementById('f-dateformat').addEventListener('change', updateRegionalPreview);

  // ===== invite rows =====
  function addInvite(){
    const row = document.createElement('div');
    row.className = 'invite-row';
    row.innerHTML = `
      <input type="email" name="invite_email[]" placeholder="nama@perusahaan.com" class="invite-email">
      <select name="invite_role[]" class="invite-role">
        <option>Akuntan</option>
        <option>Manajer Keuangan</option>
        <option>Staff Administrasi</option>
        <option>Hanya Lihat (Viewer)</option>
      </select>
      <div class="invite-remove" onclick="removeInvite(this)"><svg class="icon"><use href="#ic-trash"/></svg></div>`;
    document.getElementById('inviteList').appendChild(row);
  }
  function removeInvite(el){
    const list = document.getElementById('inviteList');
    if(list.children.length > 1) el.closest('.invite-row').remove();
    else el.closest('.invite-row').querySelector('.invite-email').value = '';
  }

  // ===== wizard step logic =====
  const totalSteps = 7;
  let current = {{ $errorStep ?? 0 }};
  const stepNames = ['Peran Kamu','Data Perusahaan','Regional','Tahun Fiskal','Rekening Awal','Undang Tim','Ringkasan'];

  function renderStepUI(){
    document.querySelectorAll('.wizard-step').forEach(el=>{
      el.classList.toggle('active', Number(el.dataset.step) === current);
    });
    document.querySelectorAll('.step-row').forEach(row=>{
      const idx = Number(row.dataset.stepIndex);
      row.classList.toggle('active', idx === current);
      row.classList.toggle('done', idx < current);
      const dot = row.querySelector('.step-dot');
      dot.innerHTML = idx < current ? '<svg class="icon"><use href="#ic-check"/></svg>' : '<span>'+(idx+1)+'</span>';
    });
    document.getElementById('mpCurrent').textContent = current+1;
    document.getElementById('mpTotal').textContent = totalSteps;
    document.getElementById('mpStepName').textContent = stepNames[current];
    document.getElementById('mpFill').style.width = (((current+1)/totalSteps)*100)+'%';
    document.getElementById('btnBack').style.visibility = current === 0 ? 'hidden' : 'visible';
    document.getElementById('btnSkip').style.display = current === 5 ? 'inline-flex' : 'none';
    document.getElementById('btnNext').innerHTML = current === totalSteps-1
      ? 'Selesaikan Setup <svg class="icon"><use href="#ic-arrow-right"/></svg>'
      : 'Lanjutkan <svg class="icon"><use href="#ic-arrow-right"/></svg>';
    if(current === totalSteps-1) buildSummary();
  }

  function validateStep(){
    if(current === 0){
      if(!roleHidden.value){ document.getElementById('rf-role').classList.add('show'); return false; }
      return true;
    }
    if(current === 1){
      const company = document.getElementById('f-company').value.trim();
      if(!company){ document.getElementById('f-company').focus(); document.getElementById('f-company').style.borderColor = 'var(--danger)'; return false; }
      document.getElementById('f-company').style.borderColor = '';
      return true;
    }
    return true;
  }

  function nextStep(skip){
    if(!skip && !validateStep()) return;
    if(current < totalSteps-1){ current++; renderStepUI(); window.scrollTo({top:0, behavior:'smooth'}); }
    else{ document.getElementById('onboardingForm').submit(); }
  }
  function prevStep(){ if(current>0){ current--; renderStepUI(); window.scrollTo({top:0, behavior:'smooth'}); } }
  function goTo(idx){ current = idx; renderStepUI(); window.scrollTo({top:0, behavior:'smooth'}); }

  function buildSummary(){
    const roleCard = document.querySelector('#roleGrid .choice-card.selected');
    document.getElementById('sum-nama').textContent = document.getElementById('f-nama').value || '—';
    document.getElementById('sum-role').textContent = roleCard ? roleCard.dataset.value : '—';
    document.getElementById('sum-company').textContent = document.getElementById('f-company').value || '—';
    document.getElementById('sum-industry').textContent = document.getElementById('f-industry').value || '—';
    document.getElementById('sum-city').textContent = document.getElementById('f-city').value || '—';
    document.getElementById('sum-size').textContent = document.getElementById('f-size').value || '—';
    document.getElementById('sum-currency').textContent = document.getElementById('f-currency').selectedOptions[0].text;
    document.getElementById('sum-timezone').textContent = document.getElementById('f-timezone').value;
    document.getElementById('sum-fiscal').textContent = document.getElementById('f-fiscalstart').value + ' ' + document.getElementById('f-fiscalyear').value;
    document.getElementById('sum-bank').textContent = document.getElementById('f-bank').value || 'Belum diisi';
    const bal = document.getElementById('f-balance').value;
    document.getElementById('sum-balance').textContent = bal ? 'Rp ' + Number(bal).toLocaleString('id-ID') : 'Rp 0';
    const emails = Array.from(document.querySelectorAll('.invite-email')).map(i=>i.value.trim()).filter(Boolean);
    document.getElementById('sum-invites').textContent = emails.length ? emails.join(', ') : 'Belum ada undangan dikirim.';
  }

  updateRegionalPreview();
  renderStepUI();
  @endif
</script>
</body>
</html>