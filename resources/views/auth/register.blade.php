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
      var t = localStorage.getItem('aj-theme') || 'light';
      var a = localStorage.getItem('aj-accent') || 'purple';
      document.documentElement.setAttribute('data-theme', t);
      document.documentElement.setAttribute('data-accent', a);
    }catch(e){}
  })();
</script>

<style>
  :root{
    --bg: #ECE9FA;
    --surface: rgba(139,92,246,0.05);
    --surface-strong: rgba(139,92,246,0.09);
    --border: rgba(20,10,40,0.09);
    --border-hover: rgba(var(--emerald-rgb),0.4);
    --emerald: #8B5CF6;
    --emerald-dim: #6E3FD6;
    --blue: #4E8FF0;
    --text: #1C1330;
    --text-mute: #6B6280;
    --text-faint: #9B93AE;
    --radius: 20px;
    --nav-bg: rgba(236,233,250,0.8);
    --mobile-bg: #FFFFFF;
    --modal-bg: #FFFFFF;
    --star-op: 0;
    --emerald-rgb: 139,92,246;
    --glow1-a: 0.14;
    --glow2-a: 0.10;
    --purple-1: #A57CE8;
    --purple-2: #7A4FCE;
    --illu-light: #DAC9F7;
    --illu-lighter: #EFE7FC;
    --illu-bg: #F2ECFB;
  }

  [data-theme="dark"]{
    --bg: #0B0714;
    --surface: rgba(255,255,255,0.04);
    --surface-strong: rgba(255,255,255,0.08);
    --border: rgba(255,255,255,0.09);
    --border-hover: rgba(var(--emerald-rgb),0.4);
    --emerald-dim: #6E3FD6;
    --text: #EDEAF7;
    --text-mute: #A199B8;
    --text-faint: #665C7E;
    --nav-bg: rgba(11,7,20,0.78);
    --mobile-bg: #150E22;
    --modal-bg: #150E22;
    --star-op: 1;
    --glow1-a: 0.2;
    --glow2-a: 0.14;
    --illu-light: #4A3A6A;
    --illu-lighter: #1F1535;
    --illu-bg: #1F1535;
  }

  [data-accent="emerald"]{ 
    --emerald:#34E0A1; --emerald-dim:#1E8F6B; --emerald-rgb:52,224,161; 
    --purple-1:#33C98F; --purple-2:#1E8F6B; 
    --illu-light:#A6EDD2; --illu-lighter:#E1F9EF; --illu-bg:#E1F9EF; 
  }
  [data-accent="blue"]{ 
    --emerald:#4E8FF0; --emerald-dim:#3465C4; --emerald-rgb:78,143,240; 
    --purple-1:#6FA3F5; --purple-2:#3465C4; 
    --illu-light:#BDD8FB; --illu-lighter:#E7F0FE; --illu-bg:#E7F0FE; 
  }
  [data-accent="purple"]{ 
    --emerald:#8B5CF6; --emerald-dim:#6E3FD6; --emerald-rgb:139,92,246; 
    --purple-1:#A57CE8; --purple-2:#7A4FCE; 
    --illu-light:#DAC9F7; --illu-lighter:#EFE7FC; --illu-bg:#F2ECFB; 
  }
  [data-accent="orange"]{ 
    --emerald:#F0A25A; --emerald-dim:#C97A2E; --emerald-rgb:240,162,90; 
    --purple-1:#F3B379; --purple-2:#C97A2E; 
    --illu-light:#F8D2AA; --illu-lighter:#FDEEDD; --illu-bg:#FDEEDD; 
  }
  [data-accent="pink"]{ 
    --emerald:#E85A9C; --emerald-dim:#B83A78; --emerald-rgb:232,90,156; 
    --purple-1:#EE7FB2; --purple-2:#B83A78; 
    --illu-light:#F6BFD8; --illu-lighter:#FCE7F0; --illu-bg:#FCE7F0; 
  }

  *{margin:0;padding:0;box-sizing:border-box;}
  html{ color-scheme: light; }
  html[data-theme="dark"]{ color-scheme: dark; }
  body{
    background: var(--bg);
    color: var(--text);
    font-family:'Inter', sans-serif;
    line-height:1.5;
    overflow-x:hidden;
    transition: background .35s ease, color .35s ease;
  }
  #starfield{ transition: opacity .35s ease; opacity: var(--star-op); }
  .bg-glow, .bg-glow-2{ transition: background .35s ease; }
  h1,h2,h3,.display{ font-family:'Space Grotesk', sans-serif; letter-spacing:-0.02em; }
  .mono{ font-family:'IBM Plex Mono', monospace; }
  a{ text-decoration:none; color:inherit; }
  ul{ list-style:none; }
  svg{ display:block; }
  .icon{ width:1em; height:1em; }

  @media (prefers-reduced-motion: reduce){
    *, *::before, *::after{
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
      scroll-behavior: auto !important;
    }
  }

  #starfield{ position:fixed; inset:0; z-index:0; pointer-events:none; overflow:hidden; }
  .star{ position:absolute; border-radius:50%; background:#fff; animation: twinkle 3s ease-in-out infinite; }
  @keyframes twinkle{ 0%,100%{opacity:.15;} 50%{opacity:.9;} }

  .bg-glow{ position:fixed; top:-25%; right:-10%; width:900px; height:900px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow1-a)) 0%, transparent 70%); pointer-events:none; z-index:0; animation: drift1 22s ease-in-out infinite; }
  .bg-glow-2{ position:fixed; bottom:-15%; left:-15%; width:700px; height:700px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow2-a)) 0%, transparent 70%); pointer-events:none; z-index:0; animation: drift2 26s ease-in-out infinite; }
  @keyframes drift1{ 0%,100%{ transform: translate(0,0) scale(1); } 50%{ transform: translate(-40px, 40px) scale(1.08); } }
  @keyframes drift2{ 0%,100%{ transform: translate(0,0) scale(1); } 50%{ transform: translate(30px, -30px) scale(1.06); } }

  .auth-page{ min-height:100vh; display:flex; align-items:center; justify-content:center; padding:40px 20px; position:relative; z-index:2; }

  /* ====== SPLIT SHELL ====== */
  .auth-shell{
    width:min(920px, 100%);
    display:flex;
    align-items:stretch;
    background:var(--modal-bg);
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 45px 110px rgba(30,10,60,0.22);
    opacity:0;
    transform: translateY(22px) scale(.985);
    animation: cardIn .7s cubic-bezier(.16,1,.3,1) .05s forwards;
    position:relative;
  }
  [data-theme="dark"] .auth-shell{ box-shadow:0 45px 110px rgba(0,0,0,0.5); }
  @keyframes cardIn{ to{ opacity:1; transform:translateY(0) scale(1); } }

  /* LEFT: VISUAL / BRAND PANEL */
  .auth-visual{
    flex:1 1 44%;
    background:linear-gradient(155deg, var(--purple-1), var(--purple-2) 75%);
    padding:42px 38px;
    display:flex;
    flex-direction:column;
    color:#fff;
    position:relative;
    overflow:hidden;
  }
  .auth-visual::before{
    content:'';
    position:absolute; top:-60px; right:-60px; width:220px; height:220px; border-radius:50%;
    background:rgba(255,255,255,0.10);
  }
  .auth-visual::after{
    content:'';
    position:absolute; bottom:-90px; left:-70px; width:260px; height:260px; border-radius:50%;
    background:rgba(255,255,255,0.07);
  }

  .visual-copy{ 
    margin-top:30px;
    position:relative; 
    z-index:1; 
  }
  .visual-copy h2{ 
    font-size:34px;
    line-height:1.3; 
    margin-bottom:10px; 
    text-shadow: 0 2px 16px rgba(0,0,0,0.1);
  }
  .visual-copy p{ 
    font-size:17px;
    color:rgba(255,255,255,0.85); 
    text-shadow: 0 1px 8px rgba(0,0,0,0.08);
    max-width:90%;
  }

  .visual-illustration{ flex:1; display:flex; align-items:center; justify-content:center; position:relative; z-index:1; margin-top:8px; min-height:0; }
  .visual-illustration svg{ width:100%; max-width:330px; height:auto; filter:drop-shadow(0 20px 30px rgba(0,0,0,0.18)); }

  .visual-bubble{
    position:absolute; left:22px; bottom:26px; z-index:2;
    display:flex; align-items:center; gap:8px;
    background:rgba(255,255,255,0.95); 
    color:var(--purple-2);
    padding:9px 14px 9px 10px; border-radius:999px;
    box-shadow:0 12px 28px rgba(0,0,0,0.18);
    font-size:12px; font-weight:600;
    animation: floatBubble 4s ease-in-out infinite;
    backdrop-filter:blur(8px);
  }
  .visual-bubble .bubble-ico{
    width:22px; height:22px; border-radius:50%; background:var(--purple-2); color:#fff;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
  }
  .visual-bubble .bubble-ico svg{ width:12px; height:12px; }
  @keyframes floatBubble{ 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-7px); } }

  /* RIGHT: FORM PANEL */
  .auth-panel{
    flex:1 1 56%;
    padding:40px 42px 34px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    position:relative;
  }

  .back-home{ display:inline-flex; align-items:center; gap:6px; font-size:12.5px; color:var(--text-mute); margin-bottom:16px; transition: color .2s ease, transform .2s ease; align-self:flex-start; }
  .back-home:hover{ color:var(--text); transform: translateX(-3px); }

  .form-logo{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:20px;
  }
  .form-logo .logo-icon{
    width:40px;
    height:40px;
    border-radius:12px;
    overflow:hidden;
    background:var(--surface-strong);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:6px;
    border:1.5px solid var(--border);
    transition: all .3s ease;
  }
  .form-logo .logo-icon img{
    width:100%;
    height:100%;
    object-fit:contain;
  }
  .form-logo .logo-text{
    font-family:'Space Grotesk';
    font-weight:700;
    font-size:22px;
    color:var(--text);
    letter-spacing:-0.02em;
  }
  .form-logo .logo-text .grad{
    background:linear-gradient(135deg, var(--purple-1), var(--purple-2));
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
  }

  .auth-error{
    background:rgba(232,90,90,0.08); border:1px solid rgba(232,90,90,0.35); color:#E24949;
    border-radius:12px; padding:12px 16px; margin-bottom:16px; font-size:13px;
    animation: shakeIn .5s cubic-bezier(.36,.07,.19,.97) both;
  }
  [data-theme="dark"] .auth-error{ color:#F08080; }
  .auth-error ul{ padding-left:18px; list-style:disc; }
  @keyframes shakeIn{
    0%{ opacity:0; transform: translateX(0); } 15%{ opacity:1; transform: translateX(-6px); }
    30%{ transform: translateX(5px); } 45%{ transform: translateX(-4px); }
    60%{ transform: translateX(3px); } 75%{ transform: translateX(-2px); } 100%{ transform: translateX(0); }
  }

  .auth-head{ margin-bottom:18px; }
  .auth-head h2{ font-size:21px; margin-bottom:5px; }
  .auth-head p{ font-size:13px; color:var(--text-mute); }

  .role-select, .auth-social, .auth-divider, .auth-form, .auth-switch{
    opacity:0; transform: translateY(10px);
    animation: fieldIn .55s cubic-bezier(.16,1,.3,1) forwards;
  }
  .role-select{ animation-delay:.14s; }
  .auth-social{ animation-delay:.20s; }
  .auth-divider{ animation-delay:.24s; }
  .auth-form{ animation-delay:.28s; }
  .auth-switch{ animation-delay:.5s; }
  .auth-form .field:nth-child(1){ animation: fieldIn .5s cubic-bezier(.16,1,.3,1) .32s both; }
  .auth-form .field:nth-child(2){ animation: fieldIn .5s cubic-bezier(.16,1,.3,1) .38s both; }
  .auth-form .field:nth-child(3){ animation: fieldIn .5s cubic-bezier(.16,1,.3,1) .42s both; }
  .auth-form .field:nth-child(4){ animation: fieldIn .5s cubic-bezier(.16,1,.3,1) .46s both; }
  .auth-form .field:nth-child(5){ animation: fieldIn .5s cubic-bezier(.16,1,.3,1) .50s both; }
  .auth-form .checkbox{ animation: fieldIn .5s cubic-bezier(.16,1,.3,1) .54s both; }
  .auth-form .auth-submit{ animation: fieldIn .5s cubic-bezier(.16,1,.3,1) .58s both; }
  @keyframes fieldIn{ to{ opacity:1; transform: translateY(0); } }

  /* ROLE TABS */
  .role-select{ margin-bottom:16px; }
  .role-select > span{ display:block; font-size:12px; color:var(--text-mute); font-weight:500; margin-bottom:8px; }
  .role-tabs{ display:flex; gap:8px; }
  .role-tab{
    flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;
    padding:11px 8px; border-radius:12px; border:1px solid var(--border); background:var(--surface);
    color:var(--text-mute); font-size:12px; font-weight:600; cursor:pointer;
    transition: color .25s ease, border-color .25s ease, background .25s ease, transform .2s ease;
    position:relative; overflow:hidden;
  }
  .role-tab .icon{ width:16px; height:16px; transition: transform .3s cubic-bezier(.34,1.56,.64,1); }
  .role-tab:hover:not(.disabled){ color:var(--text); border-color:var(--border-hover); transform: translateY(-2px); }
  .role-tab.active{ color:var(--emerald); border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }
  .role-tab.active .icon{ transform: scale(1.15); }
  .role-tab:active{ transform: translateY(0) scale(.96); }
  .role-tab.disabled{ cursor:not-allowed; opacity:0.4; }
  .role-tab.disabled:hover{ color:var(--text-mute); border-color:var(--border); transform:none; }
  .role-hint{ font-size:11px; color:var(--text-faint); margin-top:8px; line-height:1.5; min-height:32px; }

  .auth-social{ width:100%; margin-bottom:16px; position:relative; overflow:hidden; }
  .auth-social .icon{ width:16px; height:16px; }
  .auth-divider{ display:flex; align-items:center; gap:12px; margin-bottom:16px; }
  .auth-divider::before, .auth-divider::after{ content:''; flex:1; height:1px; background:var(--border); }
  .auth-divider span{ font-size:11px; color:var(--text-faint); white-space:nowrap; }

  .auth-form{ display:flex; flex-direction:column; gap:13px; }
  .field{ display:flex; flex-direction:column; gap:6px; }
  .field > span{ font-size:12px; color:var(--text-mute); font-weight:500; }
  .field-input{
    display:flex; align-items:center; gap:10px; padding:11px 14px; border-radius:12px;
    background:var(--surface); border:1px solid var(--border);
    transition: border-color .2s ease, background .2s ease, box-shadow .2s ease, transform .15s ease;
  }
  .field-input:focus-within{
    border-color: var(--border-hover); background:var(--surface-strong);
    box-shadow: 0 0 0 4px rgba(var(--emerald-rgb),0.12); transform: translateY(-1px);
  }
  .field-input .icon{ width:16px; height:16px; color:var(--text-faint); flex-shrink:0; transition: color .2s ease; }
  .field-input:focus-within .icon{ color: var(--emerald); }
  .field-input input{ flex:1; min-width:0; background:none; border:none; outline:none; color:var(--text); font-family:'Inter'; font-size:13.5px; }
  .field-input input::placeholder{ color:var(--text-faint); }
  .toggle-eye{ cursor:pointer; transition: color .2s ease, transform .2s ease; }
  .toggle-eye:hover{ color:var(--text-mute); transform: scale(1.12); }

  .checkbox{ display:flex; align-items:center; gap:8px; font-size:12px; color:var(--text-mute); cursor:pointer; }
  .checkbox input{ accent-color: var(--emerald); width:15px; height:15px; flex-shrink:0; }
  .checkbox.terms{ align-items:flex-start; line-height:1.5; }
  .checkbox.terms input{ margin-top:2px; }

  .btn{
    display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 22px;
    border-radius:12px; font-size:14px; font-weight:600; cursor:pointer; border:none;
    transition:transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease, background .25s ease, border-color .25s ease;
    position:relative; overflow:hidden;
  }
  .btn .icon{ width:16px; height:16px; transition: transform .25s ease; position:relative; z-index:1; }
  .btn-primary{ background:linear-gradient(135deg, var(--purple-1), var(--purple-2)); color:#fff; box-shadow:0 10px 26px rgba(var(--emerald-rgb),0.38); }
  .btn-primary::after{
    content:''; position:absolute; top:0; left:-60%; width:40%; height:100%;
    background:linear-gradient(120deg, transparent, rgba(255,255,255,.45), transparent);
    transform: skewX(-20deg); transition: left .6s ease;
  }
  .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 14px 34px rgba(var(--emerald-rgb),0.5); }
  .btn-primary:hover::after{ left:130%; }
  .btn-primary:hover .icon{ transform: translateX(3px); }
  .btn-primary:active{ transform: translateY(0) scale(.98); }
  .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .btn-outline:hover{ background:var(--surface-strong); border-color: var(--border-hover); transform: translateY(-2px); }
  .btn-outline:active{ transform: translateY(0) scale(.98); }
  .auth-submit{ width:100%; margin-top:2px; padding:13px 22px; }

  .auth-switch{ text-align:center; font-size:12.5px; color:var(--text-mute); margin-top:18px; }
  .auth-switch a{ color:var(--emerald); font-weight:600; position:relative; }
  .auth-switch a::after{ content:''; position:absolute; left:0; bottom:-2px; width:0; height:1px; background:var(--emerald); transition: width .25s ease; }
  .auth-switch a:hover{ opacity:.85; }
  .auth-switch a:hover::after{ width:100%; }

  .settings-fab{
    position:fixed; right:22px; bottom:22px; z-index:150;
    width:50px; height:50px; border-radius:50%;
    background:var(--surface-strong); border:1px solid var(--border);
    display:flex; align-items:center; justify-content:center; cursor:pointer;
    color:var(--text); box-shadow:0 10px 30px rgba(0,0,0,0.2);
    backdrop-filter:blur(10px); transition: transform .25s ease, border-color .25s ease, background .35s ease, box-shadow .25s ease;
    opacity:0; animation: fabIn .5s cubic-bezier(.16,1,.3,1) .6s forwards;
  }
  @keyframes fabIn{ from{ opacity:0; transform: translateY(14px) scale(.8); } to{ opacity:1; transform: translateY(0) scale(1); } }
  .settings-fab:hover{ transform: translateY(-3px) rotate(20deg); border-color:var(--border-hover); }
  .settings-fab .icon{ width:20px; height:20px; }
  .settings-panel{
    position:fixed; right:22px; bottom:82px; z-index:150;
    width:250px; background:var(--modal-bg); border:1px solid var(--border);
    border-radius:18px; padding:18px; box-shadow:0 30px 70px rgba(30,10,60,0.22);
    opacity:0; visibility:hidden; transform: translateY(10px) scale(.97);
    transition: opacity .22s ease, transform .22s ease, visibility .22s, background .35s ease;
  }
  [data-theme="dark"] .settings-panel{ box-shadow:0 30px 70px rgba(0,0,0,0.45); }
  .settings-panel.open{ opacity:1; visibility:visible; transform: translateY(0) scale(1); }
  .settings-panel h4{ font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); margin-bottom:10px; font-family:'Inter'; }
  .settings-block{ margin-bottom:18px; }
  .settings-block:last-child{ margin-bottom:0; }
  .theme-toggle-row{ display:flex; gap:8px; }
  .theme-opt{ flex:1; display:flex; flex-direction:column; align-items:center; gap:5px; padding:10px 6px; border-radius:12px; border:1px solid var(--border); background:var(--surface); color:var(--text-mute); font-size:11px; cursor:pointer; transition: all .2s ease; }
  .theme-opt .icon{ width:15px; height:15px; transition: transform .3s cubic-bezier(.34,1.56,.64,1); }
  .theme-opt:hover{ color:var(--text); border-color:var(--border-hover); }
  .theme-opt.active{ color:var(--emerald); border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }
  .theme-opt.active .icon{ transform: rotate(-14deg) scale(1.1); }
  .accent-row{ display:flex; gap:9px; flex-wrap:wrap; }
  .accent-dot{ width:26px; height:26px; border-radius:50%; cursor:pointer; border:2px solid transparent; position:relative; transition: transform .2s cubic-bezier(.34,1.56,.64,1), border-color .2s ease; }
  .accent-dot:hover{ transform: scale(1.15); }
  .accent-dot.active{ border-color: var(--text); transform: scale(1.08); }
  .accent-dot.active::after{ content:''; position:absolute; inset:0; border-radius:50%; box-shadow:0 0 0 2px var(--bg); }
  .lang-row{ display:flex; gap:8px; }
  .lang-opt{ flex:1; padding:9px 6px; text-align:center; border-radius:12px; border:1px solid var(--border); background:var(--surface); color:var(--text-mute); font-size:12.5px; font-weight:600; cursor:pointer; transition: all .2s ease; }
  .lang-opt:hover{ color:var(--text); border-color:var(--border-hover); }
  .lang-opt.active{ color:var(--emerald); border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }

  .ripple{ position:absolute; border-radius:50%; transform:scale(0); background: rgba(255,255,255,.4); pointer-events:none; animation: rippleAnim .6s ease-out forwards; }
  .btn-outline .ripple{ background: rgba(0,0,0,.1); }
  [data-theme="dark"] .btn-outline .ripple{ background: rgba(255,255,255,.18); }
  @keyframes rippleAnim{ to{ transform:scale(2.6); opacity:0; } }

  @media (max-width: 820px){
    .auth-shell{ flex-direction:column; border-radius:24px; }
    .auth-visual{ flex:none; padding:30px 28px 40px; }
    .visual-copy h2{ font-size:28px; }
    .visual-illustration{ margin-top:14px; }
    .visual-illustration svg{ max-width:200px; }
    .visual-bubble{ left:16px; bottom:16px; padding:7px 12px 7px 8px; font-size:11px; }
    .auth-panel{ padding:30px 26px 26px; }
    .form-logo .logo-text{ font-size:19px; }
    .form-logo .logo-icon{ width:36px; height:36px; }
  }

  @media (max-width: 640px){
    .auth-page{ padding:16px; }
    .auth-visual{ padding:26px 22px 50px; }
    .visual-illustration{ display:none; }
    .visual-bubble{ display:none; }
    .auth-head h2{ font-size:19px; }
    .field-input{ padding:10px 12px; }
    .field-input input{ font-size:15px; }
    .btn{ font-size:14px; padding:12px 16px; }
    .auth-submit{ padding:14px 16px; }
    .role-tab{ font-size:11px; padding:10px 6px; }
    .visual-copy{ margin-top:0; }
    .visual-copy h2{ font-size:24px; }
    .form-logo .logo-text{ font-size:17px; }
    .form-logo .logo-icon{ width:32px; height:32px; padding:4px; }
    .form-logo{ gap:10px; margin-bottom:16px; }
  }

  @media (max-width: 420px){
    .auth-shell{ border-radius:18px; }
    .auth-visual{ padding:22px 18px 40px; }
    .auth-panel{ padding:24px 18px 20px; }
    .role-tab span{ display:none; }
    .role-tab{ padding:12px 4px; }
    .settings-fab{ right:12px; bottom:12px; width:42px; height:42px; }
    .settings-fab .icon{ width:18px; height:18px; }
    .settings-panel{ right:12px; bottom:66px; width:calc(100vw - 24px); max-width:280px; }
    .visual-copy h2{ font-size:20px; }
    .form-logo .logo-text{ font-size:15px; }
    .form-logo .logo-icon{ width:28px; height:28px; padding:4px; }
    .form-logo{ gap:8px; }
  }
</style>
</head>
<body>

<div id="starfield"></div>
<div class="bg-glow"></div>
<div class="bg-glow-2"></div>

<!-- SETTINGS WIDGET -->
<div class="settings-fab" id="settingsFab" aria-label="Pengaturan tampilan"><svg class="icon"><use href="#ic-gear"/></svg></div>
<div class="settings-panel" id="settingsPanel">
  <div class="settings-block">
    <h4 data-i18n-en="Appearance">Tampilan</h4>
    <div class="theme-toggle-row">
      <div class="theme-opt" data-theme-opt="dark"><svg class="icon"><use href="#ic-moon"/></svg><span data-i18n-en="Dark">Gelap</span></div>
      <div class="theme-opt" data-theme-opt="light"><svg class="icon"><use href="#ic-sun"/></svg><span data-i18n-en="Light">Terang</span></div>
    </div>
  </div>
  <div class="settings-block">
    <h4 data-i18n-en="Accent color">Warna tema</h4>
    <div class="accent-row">
      <div class="accent-dot" data-accent-opt="emerald" style="background:#34E0A1" title="Emerald"></div>
      <div class="accent-dot" data-accent-opt="blue" style="background:#4E8FF0" title="Blue"></div>
      <div class="accent-dot" data-accent-opt="purple" style="background:#8B5CF6" title="Purple"></div>
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

<!-- Reusable icon defs -->
<svg width="0" height="0" style="position:absolute">
<defs>
  <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/><polyline points="9 12 11 14 15 10"/></symbol>
  <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
  <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></symbol>
  <symbol id="ic-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></symbol>
  <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 6 10 7 10-7"/></symbol>
  <symbol id="ic-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></symbol>
  <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/></symbol>
  <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></symbol>
  <symbol id="ic-google" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.04 12.27c0-.85-.08-1.66-.22-2.45H12v4.64h6.19a5.3 5.3 0 0 1-2.3 3.48v2.9h3.72c2.18-2 3.43-4.96 3.43-8.57z"/><path fill="#34A853" d="M12 23.5c3.1 0 5.7-1.02 7.6-2.77l-3.72-2.9c-1.03.7-2.35 1.1-3.88 1.1-2.98 0-5.5-2-6.4-4.7H1.77v2.98A11.5 11.5 0 0 0 12 23.5z"/><path fill="#FBBC05" d="M5.6 14.23A6.9 6.9 0 0 1 5.24 12c0-.77.13-1.53.36-2.23V6.79H1.77A11.5 11.5 0 0 0 .5 12c0 1.85.44 3.6 1.27 5.21z"/><path fill="#EA4335" d="M12 4.98c1.69 0 3.2.58 4.4 1.72l3.29-3.3C17.7 1.6 15.1.5 12 .5A11.5 11.5 0 0 0 1.77 6.79l3.83 2.98c.9-2.7 3.42-4.79 6.4-4.79z"/></symbol>
  <symbol id="ic-gear" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l-.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></symbol>
  <symbol id="ic-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4.5"/><path d="M12 2v2.5M12 19.5V22M4.2 4.2l1.8 1.8M18 18l1.8 1.8M2 12h2.5M19.5 12H22M4.2 19.8 6 18M18 6l1.8-1.8"/></symbol>
  <symbol id="ic-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.5a8.5 8.5 0 1 1-9.5-11.4 7 7 0 0 0 9.5 11.4z"/></symbol>
  <symbol id="ic-thumb" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 11v9H4a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1h3zm0 0 4-8a2 2 0 0 1 2 2v4h5.2a2 2 0 0 1 1.98 2.29l-1 6A2 2 0 0 1 17.2 20H7"/></symbol>
  <symbol id="ic-badge" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="6"/><path d="M9 14.5 7 22l5-3 5 3-2-7.5"/></symbol>
</defs>
</svg>

<div class="auth-page">
  <div class="auth-shell">

    <!-- LEFT: BRAND / VISUAL PANEL -->
    <div class="auth-visual">

      <div class="visual-copy">
        <h2>Buat Akun<br>Bisnis</h2>
        <p>Gratis 14 hari, tanpa kartu kredit. Mulai kelola bisnismu dengan mudah.</p>
      </div>

      <div class="visual-illustration">
        <svg viewBox="0 0 260 320" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="130" cy="300" rx="90" ry="12" fill="rgba(0,0,0,0.12)"/>
          <path d="M40 250 C40 230 55 218 75 224 C88 205 118 208 122 228 C140 220 158 235 150 252 C165 258 162 280 145 282 L55 282 C35 280 30 258 40 250 Z" fill="rgba(255,255,255,0.16)"/>
          <rect x="58" y="8" width="144" height="284" rx="28" fill="#ffffff"/>
          <rect x="70" y="24" width="120" height="252" rx="10" fill="var(--illu-bg)"/>
          <circle cx="130" cy="54" r="15" fill="var(--illu-light)"/>
          <path d="M112 78c4-10 32-10 36 0" stroke="var(--illu-light)" stroke-width="4" stroke-linecap="round" fill="none"/>
          <rect x="90" y="98" width="80" height="7" rx="3.5" fill="var(--illu-light)"/>
          <rect x="90" y="114" width="58" height="7" rx="3.5" fill="var(--illu-lighter)"/>
          <rect x="90" y="130" width="80" height="7" rx="3.5" fill="var(--illu-light)"/>
          <rect x="90" y="146" width="46" height="7" rx="3.5" fill="var(--illu-lighter)"/>
          <rect x="90" y="170" width="80" height="16" rx="8" fill="var(--illu-lighter)" stroke="var(--illu-light)"/>
          <circle cx="100" cy="178" r="3" fill="var(--emerald)"/>
          <circle cx="111" cy="178" r="3" fill="var(--emerald)"/>
          <circle cx="122" cy="178" r="3" fill="var(--emerald)"/>
          <circle cx="133" cy="178" r="3" fill="var(--emerald)"/>
          <circle cx="144" cy="178" r="3" fill="var(--emerald)"/>
          <circle cx="155" cy="178" r="3" fill="var(--emerald)"/>
          <rect x="90" y="248" width="80" height="28" rx="14" fill="var(--emerald)"/>
          <rect x="112" y="259" width="36" height="6" rx="3" fill="rgba(255,255,255,0.85)"/>
          <circle cx="190" cy="66" r="27" fill="var(--emerald-dim)"/>
          <rect x="178" y="64" width="24" height="18" rx="4" fill="#fff"/>
          <path d="M182 64v-6a8 8 0 0 1 16 0v6" stroke="#fff" stroke-width="4" fill="none" stroke-linecap="round"/>
          <circle cx="190" cy="73" r="2.6" fill="var(--emerald-dim)"/>
        </svg>
      </div>

      <div class="visual-bubble">
        <span class="bubble-ico"><svg><use href="#ic-thumb"/></svg></span>
        Mulai gratis 14 hari
      </div>
    </div>

    <!-- RIGHT: FORM PANEL -->
    <div class="auth-panel">
      <a href="{{ url('/') }}" class="back-home">&larr; <span>Kembali ke beranda</span></a>

      <div class="form-logo">
        <span class="logo-icon"><img src="{{ asset('logos.png') }}" alt="Arvessa"></span>
        <span class="logo-text">Arve<span class="grad">ssa</span></span>
      </div>

      <div class="auth-head">
        <h2>Buat Akun Bisnis</h2>
        <p>Gratis 14 hari, tanpa kartu kredit.</p>
      </div>

      <div class="role-select">
        <span>Daftar sebagai</span>
        <div class="role-tabs">
          <div class="role-tab disabled" data-role="admin" title="Akun Admin hanya bisa dibuat oleh Admin lain">
            <svg class="icon"><use href="#ic-shield"/></svg>
            <span>Admin</span>
          </div>
          <div class="role-tab active" data-role="staff">
            <svg class="icon"><use href="#ic-briefcase"/></svg>
            <span>Staff</span>
          </div>
          <div class="role-tab" data-role="user">
            <svg class="icon"><use href="#ic-user"/></svg>
            <span>User</span>
          </div>
        </div>
        <p class="role-hint" id="roleHint">Staff = pemilik bisnis, bikin perusahaan sendiri lewat onboarding.</p>
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
        <input type="hidden" name="intended_role" id="intendedRoleInput" value="staff">

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

        <!-- INVITE CODE FIELD - hidden by default, muncul saat User dipilih -->
        <label class="field" id="inviteCodeField" style="display:none;">
          <span>Kode undangan</span>
          <div class="field-input">
            <svg class="icon"><use href="#ic-badge"/></svg>
            <input type="text" name="invite_code" id="inviteCodeInput" value="{{ old('invite_code') }}" placeholder="Contoh: A1B2C3D4" style="text-transform:uppercase;">
          </div>
          @error('invite_code')
            <div style="font-size:12px;color:#E85A5A;margin-top:4px;">{{ $message }}</div>
          @enderror
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

  // ROLE TAB SELECTOR - dengan toggle invite code
  (function(){
    const tabs = document.querySelectorAll('.role-tab');
    const hiddenInput = document.getElementById('intendedRoleInput');
    const inviteField = document.getElementById('inviteCodeField');
    const inviteInput = document.getElementById('inviteCodeInput');
    const hint = document.getElementById('roleHint');

    const hints = {
      staff: 'Staff = pemilik bisnis, bikin perusahaan sendiri lewat onboarding.',
      user: 'User = bergabung ke perusahaan yang sudah ada pakai kode undangan dari Staff.'
    };

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        if(tab.classList.contains('disabled')) return;
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        const role = tab.getAttribute('data-role');
        hiddenInput.value = role;
        hint.textContent = hints[role] || '';

        if(role === 'user'){
          inviteField.style.display = 'flex';
          inviteInput.required = true;
        } else {
          inviteField.style.display = 'none';
          inviteInput.required = false;
        }
      });
    });
  })();

  // RIPPLE MICRO-INTERACTION
  (function(){
    function addRipple(e){
      const el = e.currentTarget;
      const rect = el.getBoundingClientRect();
      const ripple = document.createElement('span');
      const size = Math.max(rect.width, rect.height);
      ripple.className = 'ripple';
      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
      ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
      const prevPos = getComputedStyle(el).position;
      if(prevPos === 'static') el.style.position = 'relative';
      el.style.overflow = el.style.overflow || 'hidden';
      el.appendChild(ripple);
      ripple.addEventListener('animationend', () => ripple.remove());
    }
    document.querySelectorAll('.btn, .role-tab').forEach(el => {
      el.addEventListener('click', addRipple);
    });
  })();

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

    let theme = getSaved('aj-theme', 'light');
    let accent = getSaved('aj-accent', 'purple');
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