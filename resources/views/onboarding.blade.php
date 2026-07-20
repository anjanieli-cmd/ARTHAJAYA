<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Siapkan Akun Bisnismu — Arvessa</title>

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
    --gold: #F0C05A;
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
  a{ text-decoration:none; color:inherit; }
  svg{ display:block; }
  .icon{ width:1em; height:1em; }
  button{ font-family:inherit; }
  :focus-visible{ outline: 2px solid var(--emerald); outline-offset: 2px; }

  #starfield{ position:fixed; inset:0; z-index:0; pointer-events:none; overflow:hidden; opacity: var(--star-op); transition: opacity .35s ease; }
  .star{ position:absolute; border-radius:50%; background:#fff; animation: twinkle 3s ease-in-out infinite; }
  @keyframes twinkle{ 0%,100%{opacity:.15;} 50%{opacity:.9;} }
  .bg-glow{ position:fixed; top:-25%; right:-10%; width:900px; height:900px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow1-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }
  .bg-glow-2{ position:fixed; bottom:-15%; left:-15%; width:700px; height:700px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow2-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }

  /* ===== AMBIENT DRIFTING BLOBS ===== */
  .ambient{ position:fixed; inset:0; z-index:0; overflow:hidden; pointer-events:none; }
  .ambient-blob{ position:absolute; border-radius:50%; filter:blur(70px); opacity:.55; }
  .ambient-blob.b1{ width:380px; height:380px; top:8%; left:62%; background:radial-gradient(circle, rgba(var(--emerald-rgb),0.35), transparent 70%); animation: driftA 22s ease-in-out infinite; }
  .ambient-blob.b2{ width:320px; height:320px; top:55%; left:4%; background:radial-gradient(circle, rgba(155,123,224,0.22), transparent 70%); animation: driftB 26s ease-in-out infinite; }
  .ambient-blob.b3{ width:260px; height:260px; top:78%; left:70%; background:radial-gradient(circle, rgba(78,143,240,0.2), transparent 70%); animation: driftC 30s ease-in-out infinite; }
  @keyframes driftA{ 0%,100%{ transform:translate(0,0) scale(1);} 50%{ transform:translate(-40px,50px) scale(1.15);} }
  @keyframes driftB{ 0%,100%{ transform:translate(0,0) scale(1);} 50%{ transform:translate(50px,-30px) scale(.9);} }
  @keyframes driftC{ 0%,100%{ transform:translate(0,0) scale(1);} 50%{ transform:translate(-30px,-40px) scale(1.1);} }
  @media (prefers-reduced-motion: reduce){ .ambient-blob{ animation:none !important; } }

  .topbar{ position:relative; z-index:5; display:flex; align-items:center; justify-content:space-between; padding:22px 40px; max-width:1180px; margin:0 auto; }
  .logo{ display:flex; align-items:center; gap:10px; font-family:'Space Grotesk'; font-weight:700; font-size:18px; }
  .logo-mark{ width:40px; height:40px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border-hover); display:flex; align-items:center; justify-content:center; overflow:hidden; padding:6px; }
  .logo-mark img{ width:100%; height:100%; object-fit:contain; }
  .logo .dot{ color:var(--emerald); }
  .logo .wordmark{
    font-family:'Inter', sans-serif;
    font-weight:800;
    letter-spacing:-0.01em;
    white-space:nowrap;
    word-spacing:0;
    display:inline-flex;
    align-items:baseline;
  }
  .logo .wordmark .dot{ margin:0; padding:0; letter-spacing:inherit; }
  .exit-link{ font-size:13.5px; color:var(--text-mute); display:flex; align-items:center; gap:7px; transition: color .2s ease; background:none; border:none; cursor:pointer; }
  .exit-link:hover{ color:var(--text); }
  .exit-link .icon{ width:14px; height:14px; }

  /* ===== PROGRESS STEPS (desktop, clickable) ===== */
  .progress-row{ max-width:1180px; margin:0 auto; padding:0 40px 8px; position:relative; z-index:5; }
  .progress-track{ display:flex; align-items:center; gap:0; max-width:520px; }
  .progress-step{ display:flex; align-items:center; gap:9px; background:none; border:none; cursor:pointer; padding:4px 2px; border-radius:8px; transition: opacity .2s ease; }
  .progress-step:hover{ opacity:.8; }
  .progress-step .dot{ width:26px; height:26px; border-radius:50%; background:var(--surface-strong); border:1.5px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; font-family:'IBM Plex Mono'; color:var(--text-faint); transition: all .3s ease; flex-shrink:0; }
  .progress-step.active .dot, .progress-step.done .dot{ border-color:var(--emerald); color:var(--emerald); background:rgba(var(--emerald-rgb),0.12); }
  .progress-step.active .dot{ box-shadow: 0 0 0 4px rgba(var(--emerald-rgb),0.14); }
  .progress-step.done .dot{ background:var(--emerald); color:#052117; }
  .progress-step .lbl{ font-size:12.5px; color:var(--text-faint); font-weight:500; white-space:nowrap; }
  .progress-step.active .lbl, .progress-step.done .lbl{ color:var(--text); }
  .progress-line{ width:44px; height:1.5px; background:var(--border); margin:0 8px; transition: background .3s ease; }
  .progress-line.done{ background:var(--emerald); }
  @media (max-width:900px){ .progress-row{ display:none; } }

  /* ===== MOBILE STEP DOTS (compact, sticky) ===== */
  .mobile-steps{ display:none; }
  @media (max-width:900px){
    .mobile-steps{
      display:flex; align-items:center; justify-content:center; gap:8px;
      position:sticky; top:0; z-index:20; padding:10px 20px;
      background:var(--nav-bg, rgba(7,11,19,0.85)); backdrop-filter:blur(12px);
      border-bottom:1px solid var(--border);
    }
    .mobile-steps .m-dot{ width:8px; height:8px; border-radius:50%; background:var(--border); transition: all .3s ease; }
    .mobile-steps .m-dot.active{ background:var(--emerald); width:22px; border-radius:5px; }
    .mobile-steps .m-dot.done{ background:var(--emerald); opacity:.55; }
    .mobile-steps .m-pct{ font-family:'IBM Plex Mono'; font-size:11px; color:var(--emerald); margin-left:8px; font-weight:600; }
  }

  /* ===== OVERALL COMPLETION BAR ===== */
  .completion-row{ max-width:1180px; margin:0 auto; padding:2px 40px 0; position:relative; z-index:5; display:flex; align-items:center; gap:14px; }
  .completion-bar{ flex:1; max-width:520px; height:6px; border-radius:100px; background:var(--surface-strong); overflow:hidden; }
  .completion-fill{ height:100%; width:0%; background:linear-gradient(90deg,var(--emerald-dim),var(--emerald)); border-radius:100px; transition: width .5s cubic-bezier(.4,0,.2,1); position:relative; }
  .completion-fill::after{ content:''; position:absolute; inset:0; background:linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent); width:40%; animation: shimmerBar 2.2s ease-in-out infinite; }
  @keyframes shimmerBar{ 0%{ transform:translateX(-120%); } 100%{ transform:translateX(340%); } }
  .completion-pct{ font-family:'IBM Plex Mono'; font-size:12px; color:var(--emerald); font-weight:600; min-width:38px; }
  @media (max-width:900px){ .completion-row{ display:none; } }

  .wrap{ position:relative; z-index:2; max-width:1180px; margin:0 auto; padding:14px 40px 80px; }

  .intro{ margin-bottom:26px; max-width:600px; }
  .intro .tag{ font-size:12.5px; color:var(--emerald); font-weight:600; text-transform:uppercase; letter-spacing:.06em; margin-bottom:10px; display:flex; align-items:center; gap:7px; }
  .intro .tag .icon{ width:13px; height:13px; }
  .intro h1{ font-size:29px; margin-bottom:8px; }
  .intro h1 .accent{
    background: linear-gradient(100deg, var(--emerald), var(--gold) 60%, var(--emerald));
    background-size: 200% auto;
    -webkit-background-clip: text; background-clip:text; color:transparent;
    animation: shineText 5s ease-in-out infinite;
  }
  @keyframes shineText{ 0%,100%{ background-position: 0% center; } 50%{ background-position: 100% center; } }
  .intro p{ font-size:14px; color:var(--text-mute); max-width:520px; }

  /* ===== LAYOUT 2 KOLOM ===== */
  .setup-grid{ display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start; }
  @media (max-width:980px){ .setup-grid{ grid-template-columns:1fr; } .preview-col{ order:-1; } }

  .panel{
    background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:36px 40px;
    backdrop-filter:blur(10px); position:relative; overflow:hidden;
    background-image: radial-gradient(rgba(255,255,255,0.035) 1px, transparent 1px);
    background-size: 16px 16px;
  }
  .panel::before{
    content:''; position:absolute; top:-30%; right:-20%; width:280px; height:280px; border-radius:50%;
    background:radial-gradient(circle, rgba(var(--emerald-rgb),0.1), transparent 70%); pointer-events:none;
  }

  .section{ margin-bottom:32px; position:relative; z-index:1; opacity:0; transform:translateY(18px); transition: opacity .6s cubic-bezier(.4,0,.2,1), transform .6s cubic-bezier(.4,0,.2,1); scroll-margin-top: 90px; }
  .section.in-view{ opacity:1; transform:translateY(0); }
  .section:last-of-type{ margin-bottom:0; }
  .section-head{ display:flex; align-items:center; gap:12px; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid var(--border); }
  .section-head .num{ width:34px; height:34px; border-radius:11px; background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); display:flex; align-items:center; justify-content:center; flex-shrink:0; transition: background .3s ease, color .3s ease, transform .3s cubic-bezier(.34,1.56,.64,1); }
  .section-head .num .icon{ width:16px; height:16px; }
  .section-head .num.done{ background:var(--emerald); color:#052117; transform: scale(1.08); }
  .section-head h3{ font-size:15.5px; font-weight:600; }
  .section-head .opt-tag{ font-size:11.5px; color:var(--text-faint); font-weight:400; margin-left:auto; }
  .section-head .done-tag{ font-size:11px; color:var(--emerald); font-weight:600; margin-left:auto; display:none; align-items:center; gap:5px; }
  .section-head .done-tag.show{ display:flex; }
  .section-head .done-tag .icon{ width:12px; height:12px; }

  .field-grid{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
  .field-grid .full{ grid-column: 1 / -1; }
  .field{ display:flex; flex-direction:column; gap:7px; }
  .field label{ font-size:12.5px; color:var(--text-mute); font-weight:500; display:flex; align-items:center; gap:6px; }
  .field label .opt{ color:var(--text-faint); font-weight:400; }
  .field-tip{ position:relative; display:inline-flex; }
  .field-tip .qmark{ width:14px; height:14px; border-radius:50%; background:var(--surface-strong); border:1px solid var(--border); color:var(--text-faint); font-size:9.5px; font-weight:700; display:flex; align-items:center; justify-content:center; cursor:help; font-family:'IBM Plex Mono'; }
  .field-tip .tip-bubble{
    position:absolute; bottom:calc(100% + 8px); left:50%; transform:translateX(-50%) translateY(4px);
    width:200px; background:var(--modal-bg); border:1px solid var(--border); border-radius:10px; padding:9px 11px;
    font-size:11px; line-height:1.5; color:var(--text-mute); font-weight:400; text-align:left;
    opacity:0; visibility:hidden; transition: opacity .18s ease, transform .18s ease; z-index:5;
    box-shadow: 0 12px 28px rgba(0,0,0,0.35); pointer-events:none;
  }
  .field-tip:hover .tip-bubble{ opacity:1; visibility:visible; transform:translateX(-50%) translateY(0); }

  .field input[type=text], .field input[type=number], .field select{
    width:100%; padding:12px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border);
    color:var(--text); font-family:'Inter'; font-size:14px; outline:none; transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
    appearance:none;
  }
  .field select{
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
    background-repeat:no-repeat; background-position: right 14px center; background-size:14px; padding-right:38px;
  }
  .field input:focus, .field select:focus{ border-color: var(--border-hover); background:var(--surface); box-shadow: 0 0 0 4px rgba(var(--emerald-rgb),0.1); }
  .field-hint{ font-size:11.5px; color:var(--text-faint); margin-top:6px; }
  .field-error{ font-size:12px; color:var(--danger); margin-top:2px; }

  /* icon-prefixed inputs */
  .field-icon{ position:relative; }
  .field-icon .fi-ic{ position:absolute; left:14px; top:50%; transform:translateY(-50%); width:15px; height:15px; color:var(--text-faint); pointer-events:none; transition: color .2s ease; z-index:1; }
  .field-icon input, .field-icon select{ padding-left:38px !important; }
  .field-icon input:focus ~ .fi-ic, .field-icon:focus-within .fi-ic{ color:var(--emerald); }

  /* valid-state checkmark badge inside field */
  .field-icon .fi-valid{
    position:absolute; right:12px; top:50%; transform:translateY(-50%) scale(.5); width:16px; height:16px;
    border-radius:50%; background:var(--emerald); color:#052117; display:flex; align-items:center; justify-content:center;
    opacity:0; transition: opacity .2s ease, transform .25s cubic-bezier(.34,1.56,.64,1); pointer-events:none;
  }
  .field-icon .fi-valid .icon{ width:9px; height:9px; }
  .field-icon.is-valid .fi-valid{ opacity:1; transform:translateY(-50%) scale(1); }
  .field-icon.is-valid input, .field-icon.is-valid select{ padding-right:34px; }

  .logo-upload{ display:flex; align-items:center; gap:14px; margin-bottom:18px; }
  .logo-drop{
    width:60px; height:60px; border-radius:16px; border:1.5px dashed var(--border); background:var(--surface-strong);
    display:flex; align-items:center; justify-content:center; color:var(--text-faint); flex-shrink:0; overflow:hidden;
    cursor:pointer; transition: border-color .2s ease, transform .2s ease, background .2s ease; position:relative;
  }
  .logo-drop:hover{ border-color:var(--border-hover); transform: scale(1.03); }
  .logo-drop.drag-over{ border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.14); transform: scale(1.06); }
  .logo-drop img{ width:100%; height:100%; object-fit:cover; display:none; }
  .logo-drop .icon{ width:19px; height:19px; }
  .logo-upload-copy{ font-size:12.5px; color:var(--text-mute); }
  .logo-upload-copy .lu-actions{ display:flex; gap:8px; margin-top:6px; }
  .logo-upload-copy button{ padding:7px 12px; font-size:12px; }
  .btn-remove-logo{ display:none; background:none; border:1px solid var(--border); color:var(--danger); border-radius:12px; cursor:pointer; }
  .btn-remove-logo.show{ display:inline-flex; align-items:center; gap:6px; }
  .btn-remove-logo .icon{ width:12px; height:12px; }

  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 24px; border-radius:12px; font-size:14.5px; font-weight:600; cursor:pointer; border:none; transition:all .25s ease; font-family:'Inter'; }
  .btn .icon{ width:16px; height:16px; transition: transform .25s ease; }
  .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 24px rgba(var(--emerald-rgb),0.35); width:100%; padding:14px; font-size:15px; position:relative; overflow:hidden; }
  .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 10px 32px rgba(var(--emerald-rgb),0.5); }
  .btn-primary:hover .icon{ transform: translateX(3px); }
  .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .btn-outline:hover{ background:var(--surface-strong); border-color: var(--border-hover); }
  .btn:disabled{ opacity:.4; cursor:not-allowed; }

  .submit-row{ margin-top:32px; position:relative; z-index:1; }
  .submit-hint{ text-align:center; font-size:12px; color:var(--text-faint); margin-top:12px; }

  .trust-row{ display:flex; justify-content:center; gap:22px; margin-top:22px; flex-wrap:wrap; }
  .trust-row span{ display:flex; align-items:center; gap:7px; font-size:12px; color:var(--text-faint); }
  .trust-row .icon{ width:13px; height:13px; color:var(--emerald); flex-shrink:0; }

  /* ===== LIVE PREVIEW CARD (with torn-receipt signature edge) ===== */
  .preview-col{ position:sticky; top:24px; opacity:0; transform:translateY(18px); transition: opacity .6s cubic-bezier(.4,0,.2,1) .1s, transform .6s cubic-bezier(.4,0,.2,1) .1s; }
  .preview-col.in-view{ opacity:1; transform:translateY(0); }
  .preview-label{ font-size:11.5px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); margin-bottom:12px; display:flex; align-items:center; gap:8px; }
  .preview-label .live-dot{ width:6px; height:6px; border-radius:50%; background:var(--emerald); animation: pulseDot 1.6s ease-in-out infinite; }
  @keyframes pulseDot{ 0%,100%{ opacity:1; } 50%{ opacity:.3; } }

  .preview-card-wrap{ filter: drop-shadow(0 20px 46px rgba(0,0,0,0.28)); transition: filter .3s ease, transform .3s cubic-bezier(.4,0,.2,1); transform-style: preserve-3d; }
  .preview-card-wrap:hover{ filter: drop-shadow(0 28px 58px rgba(0,0,0,0.34)); }

  .preview-card{
    background:linear-gradient(160deg, rgba(var(--emerald-rgb),0.1), var(--surface) 60%);
    border:1px solid var(--border-hover); border-top-left-radius:22px; border-top-right-radius:22px;
    padding:26px 26px 20px; position:relative; overflow:hidden;
    transition: border-color .3s ease;
  }
  .preview-card-wrap:hover .preview-card{ border-color: var(--emerald); }
  .preview-card::before{ content:''; position:absolute; top:-40%; right:-30%; width:200px; height:200px; background:radial-gradient(circle, rgba(var(--emerald-rgb),0.25), transparent 70%); pointer-events:none; }

  /* torn / perforated bottom edge, like a receipt stub — the signature element */
  .receipt-tear{
    height:14px; margin-top:-1px;
    background-image: radial-gradient(circle at 10px 0, transparent 9px, var(--bg) 9.5px);
    background-size: 20px 20px;
    background-position: -2px 0;
    background-repeat: repeat-x;
    position:relative; z-index:2;
  }
  [data-theme="light"] .receipt-tear{ background-image: radial-gradient(circle at 10px 0, transparent 9px, #F4F6FA 9.5px); }
  .receipt-dashes{
    border-bottom: 1.5px dashed var(--border); margin: 0 22px; opacity:.8;
  }

  .pv-head{ display:flex; align-items:center; gap:12px; margin-bottom:18px; position:relative; z-index:1; }
  .pv-logo{ width:46px; height:46px; border-radius:13px; background:var(--surface-strong); border:1px solid var(--border-hover); display:flex; align-items:center; justify-content:center; overflow:hidden; font-family:'Space Grotesk'; font-weight:700; font-size:17px; color:var(--emerald); flex-shrink:0; }
  .pv-logo img{ width:100%; height:100%; object-fit:cover; display:none; }
  .pv-name{ font-size:16px; font-weight:700; font-family:'Space Grotesk'; line-height:1.3; }
  .pv-sub{ font-size:11.5px; color:var(--text-faint); margin-top:2px; }

  .pv-ring-wrap{ position:absolute; top:22px; right:22px; width:44px; height:44px; z-index:1; }
  .pv-ring-wrap svg{ transform:rotate(-90deg); width:100%; height:100%; }
  .pv-ring-wrap circle{ fill:none; stroke-width:4; }
  .pv-ring-pct{ position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-family:'IBM Plex Mono'; font-size:10px; font-weight:600; color:var(--emerald); }

  .pv-rows{ display:flex; flex-direction:column; gap:14px; position:relative; z-index:1; }
  .pv-row{ display:flex; justify-content:space-between; align-items:center; padding-bottom:14px; border-bottom:1px solid var(--border); }
  .pv-row:last-child{ border-bottom:none; padding-bottom:0; }
  .pv-row .k{ font-size:12px; color:var(--text-faint); display:flex; align-items:center; gap:7px; }
  .pv-row .k .icon{ width:12px; height:12px; opacity:.7; }
  .pv-row .v{ font-size:13px; font-weight:600; font-family:'Space Grotesk'; text-align:right; display:flex; align-items:center; gap:6px; }
  .bank-dot{ width:8px; height:8px; border-radius:50%; flex-shrink:0; transition: background .2s ease; }

  .pv-balance{ margin-top:20px; padding-top:20px; border-top:1px dashed var(--border); position:relative; z-index:1; }
  .pv-balance .lbl{ font-size:11px; color:var(--text-faint); margin-bottom:6px; }
  .pv-balance .amt{ font-family:'Space Grotesk'; font-size:24px; font-weight:700; color:var(--emerald); transition: transform .15s ease; }
  .pv-balance .amt.bump{ transform: scale(1.06); }
  .pv-spark{ display:flex; align-items:flex-end; gap:3px; height:26px; margin-top:12px; position:relative; z-index:1; }
  .pv-spark i{ flex:1; background:linear-gradient(180deg,var(--emerald),transparent); border-radius:2px; opacity:.7; height:12%; transition: height .6s cubic-bezier(.4,0,.2,1); }

  .preview-tip{ margin-top:18px; padding:14px 16px; background:var(--surface); border:1px solid var(--border); border-radius:14px; font-size:12px; color:var(--text-mute); line-height:1.6; display:flex; gap:10px; align-items:flex-start; }
  .preview-tip .icon{ width:15px; height:15px; color:var(--emerald); flex-shrink:0; margin-top:1px; }

  /* ===== SUCCESS SCREEN ===== */
  .success-screen{ display:none; position:relative; z-index:2; max-width:620px; margin:60px auto; text-align:center; padding:0 24px; }
  .success-screen.active{ display:block; }
  .success-check{ width:80px; height:80px; border-radius:50%; background:rgba(var(--emerald-rgb),0.12); border:1.5px solid rgba(var(--emerald-rgb),0.4); display:flex; align-items:center; justify-content:center; margin:0 auto 24px; color:var(--emerald); animation: popIn .5s cubic-bezier(.34,1.56,.64,1); position:relative; }
  .success-check .icon{ width:34px; height:34px; }
  .success-check::after{
    content:''; position:absolute; inset:-8px; border-radius:50%; border:1.5px solid rgba(var(--emerald-rgb),0.3);
    animation: ringPulse 1.8s ease-out infinite;
  }
  @keyframes ringPulse{ 0%{ transform:scale(.9); opacity:.8; } 100%{ transform:scale(1.4); opacity:0; } }
  @keyframes popIn{ 0%{ transform:scale(0); opacity:0; } 100%{ transform:scale(1); opacity:1; } }
  .success-screen h1{ font-size:28px; margin-bottom:12px; }
  .success-screen p{ font-size:15px; color:var(--text-mute); margin-bottom:30px; }
  .success-recap{ display:flex; justify-content:center; gap:26px; margin-bottom:34px; flex-wrap:wrap; }
  .success-recap .item{ text-align:left; }
  .success-recap .lbl{ font-size:11.5px; color:var(--text-faint); margin-bottom:4px; }
  .success-recap .val{ font-size:14px; font-weight:600; font-family:'Space Grotesk'; }

  .next-steps{ display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:34px; text-align:left; }
  .next-steps .ns-card{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:16px; transition: border-color .2s ease, transform .2s ease; }
  .next-steps .ns-card:hover{ border-color:var(--border-hover); transform:translateY(-3px); }
  .next-steps .ns-ic{ width:32px; height:32px; border-radius:9px; background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); display:flex; align-items:center; justify-content:center; margin-bottom:10px; }
  .next-steps .ns-ic .icon{ width:15px; height:15px; }
  .next-steps h4{ font-size:12.5px; font-weight:600; margin-bottom:4px; }
  .next-steps p{ font-size:11.5px; color:var(--text-faint); margin:0; line-height:1.5; }
  @media (max-width:640px){ .next-steps{ grid-template-columns:1fr; } }

  #confettiCanvas{ position:fixed; inset:0; z-index:3; pointer-events:none; }

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

  @media (max-width: 640px){
    .topbar, .wrap{ padding-left:20px; padding-right:20px; }
    .panel{ padding:26px 20px; }
    .field-grid{ grid-template-columns:1fr; }
    .success-recap{ gap:16px; }
    .completion-row{ padding-left:20px; padding-right:20px; }
    .trust-row{ gap:14px; }
  }
</style>
</head>
<body>

<div id="starfield"></div>
<div class="bg-glow"></div>
<div class="bg-glow-2"></div>
<div class="ambient" aria-hidden="true">
  <span class="ambient-blob b1"></span>
  <span class="ambient-blob b2"></span>
  <span class="ambient-blob b3"></span>
</div>
<canvas id="confettiCanvas"></canvas>

<svg width="0" height="0" style="position:absolute">
<defs>
  <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></symbol>
  <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
  <symbol id="ic-logout" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></symbol>
  <symbol id="ic-image" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></symbol>
  <symbol id="ic-gear" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></symbol>
  <symbol id="ic-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4.5"/><path d="M12 2v2.5M12 19.5V22M4.2 4.2l1.8 1.8M18 18l1.8 1.8M2 12h2.5M19.5 12H22M4.2 19.8 6 18M18 6l1.8-1.8"/></symbol>
  <symbol id="ic-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.5a8.5 8.5 0 1 1-9.5-11.4 7 7 0 0 0 9.5 11.4z"/></symbol>
  <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/></symbol>
  <symbol id="ic-wallet" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></symbol>
  <symbol id="ic-bank" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V10l7-6 7 6v11"/><path d="M9 21v-7h6v7"/></symbol>
  <symbol id="ic-sparkle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M5.6 18.4l2.8-2.8M15.6 8.4l2.8-2.8"/></symbol>
  <symbol id="ic-map-pin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></symbol>
  <symbol id="ic-tag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.6 12.6 12 21.2 2.8 12 2.8 2.8 12 2.8 20.6 12.6z"/><circle cx="7.5" cy="7.5" r="1.2" fill="currentColor" stroke="none"/></symbol>
  <symbol id="ic-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></symbol>
  <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 16 14"/></symbol>
  <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/><polyline points="9 12 11 14 15 10"/></symbol>
  <symbol id="ic-invoice" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h12v20l-3-2-3 2-3-2-3 2V2z"/><path d="M9 7h6M9 11h6M9 15h3"/></symbol>
  <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
  <symbol id="ic-chart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></symbol>
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
  <div class="logo"><span class="logo-mark"><img src="{{ asset('logos.png') }}" alt="Arvessa"></span><span class="wordmark">Arves<span class="dot">sa</span></span></div>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="exit-link"><svg class="icon"><use href="#ic-logout"/></svg> Simpan &amp; keluar</button>
  </form>
</div>

@if(!session('completed'))
<div class="mobile-steps" id="mobileSteps">
  <span class="m-dot active" data-mdot="1"></span>
  <span class="m-dot" data-mdot="2"></span>
  <span class="m-dot" data-mdot="3"></span>
  <span class="m-pct" id="mobilePct">0%</span>
</div>
<div class="progress-row">
  <div class="progress-track" id="progressTrack">
    <button type="button" class="progress-step active" data-step="1"><span class="dot">1</span><span class="lbl">Profil</span></button>
    <div class="progress-line" id="line1"></div>
    <button type="button" class="progress-step" data-step="2"><span class="dot">2</span><span class="lbl">Keuangan</span></button>
    <div class="progress-line" id="line2"></div>
    <button type="button" class="progress-step" data-step="3"><span class="dot">3</span><span class="lbl">Rekening</span></button>
  </div>
</div>
<div class="completion-row">
  <div class="completion-bar"><div class="completion-fill" id="completionFill"></div></div>
  <div class="completion-pct" id="completionPct">0%</div>
</div>
@endif

@if(session('completed'))
  {{-- ============ SUCCESS SCREEN ============ --}}
  <div class="success-screen active">
    <div class="success-check"><svg class="icon"><use href="#ic-check"/></svg></div>
    <h1>Setup selesai, {{ explode(' ', Auth::user()->name)[0] }}!</h1>
    <p>Akun bisnis <b>{{ $company->name ?? 'perusahaanmu' }}</b> sudah siap dipakai. Dashboard keuanganmu sudah menunggu.</p>
    <div class="success-recap">
      <div class="item"><div class="lbl">Perusahaan</div><div class="val">{{ $company->name ?? '—' }}</div></div>
      <div class="item"><div class="lbl">Mata Uang</div><div class="val">{{ $company->currency ?? '—' }}</div></div>
      <div class="item"><div class="lbl">Saldo Awal</div><div class="val">{{ $company->currency_symbol ?? 'Rp' }}{{ number_format($company?->accounts?->first()?->initial_balance ?? 0, 0, ',', '.') }}</div></div>
    </div>

    <div class="next-steps">
      <div class="ns-card">
        <div class="ns-ic"><svg class="icon"><use href="#ic-invoice"/></svg></div>
        <h4>Buat faktur pertama</h4>
        <p>Kirim tagihan pertamamu ke klien dalam hitungan menit.</p>
      </div>
      <div class="ns-card">
        <div class="ns-ic"><svg class="icon"><use href="#ic-users"/></svg></div>
        <h4>Undang tim</h4>
        <p>Ajak rekan kerja mengelola pembukuan bareng-bareng.</p>
      </div>
      <div class="ns-card">
        <div class="ns-ic"><svg class="icon"><use href="#ic-chart"/></svg></div>
        <h4>Pantau laporan</h4>
        <p>Lihat arus kas dan laba rugi update secara real-time.</p>
      </div>
    </div>

    <a href="{{ route('dashboard') }}" class="btn btn-primary" style="width:auto;display:inline-flex;">Masuk ke Dashboard <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
  </div>

@else
  {{-- ============ FORM 2 KOLOM ============ --}}
  <div class="wrap">
    <div class="intro">
      <span class="tag"><svg class="icon"><use href="#ic-sparkle"/></svg>Setup Akun Bisnis</span>
      <h1>Siapkan data <span class="accent">perusahaanmu</span></h1>
      <p>Cukup isi sekali. Data ini jadi dasar laporan keuangan, faktur, dan saldo awal di Arvessa — bisa diubah kapan saja lewat menu Pengaturan.</p>
    </div>

    <form id="onboardingForm" method="POST" action="{{ route('onboarding.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="setup-grid">

        {{-- ===== KOLOM KIRI: FORM ===== --}}
        <div class="panel">

          {{-- 1. PROFIL PERUSAHAAN --}}
          <div class="section" data-section="1" id="sectionAnchor1">
            <div class="section-head">
              <span class="num" id="numSection1"><svg class="icon"><use href="#ic-building"/></svg></span>
              <h3>Profil Perusahaan</h3>
              <span class="done-tag" id="doneTag1"><svg class="icon"><use href="#ic-check"/></svg> Terisi</span>
            </div>

            <div class="logo-upload">
              <div class="logo-drop" id="logoDrop"><svg class="icon"><use href="#ic-image"/></svg><img id="logoPreview" alt=""></div>
              <div class="logo-upload-copy">
                <div>Logo perusahaan <span class="opt">(opsional)</span></div>
                <div class="lu-actions">
                  <button type="button" class="btn btn-outline" onclick="document.getElementById('logoInput').click()">Pilih File</button>
                  <button type="button" class="btn-remove-logo" id="btnRemoveLogo"><svg class="icon"><use href="#ic-image"/></svg> Hapus</button>
                </div>
                <input type="file" name="logo" id="logoInput" accept="image/*" style="display:none;">
              </div>
            </div>

            <div class="field-grid">
              <div class="field full">
                <label>Nama perusahaan</label>
                <div class="field-icon" id="wrapCompany">
                  <svg class="icon fi-ic"><use href="#ic-tag"/></svg>
                  <input type="text" name="company_name" id="f-company" value="{{ old('company_name') }}" placeholder="cth. PT Andalas Maju Bersama">
                  <span class="fi-valid"><svg class="icon"><use href="#ic-check"/></svg></span>
                </div>
                @error('company_name') <div class="field-error">{{ $message }}</div> @enderror
              </div>
              <div class="field">
                <label>
                  Jenis industri
                  <span class="field-tip"><span class="qmark">?</span><span class="tip-bubble">Membantu kami menyesuaikan kategori laporan dan template faktur yang cocok buat bisnismu.</span></span>
                </label>
                <select name="industry" id="f-industry">
                  <option value="">Pilih industri</option>
                  @foreach(['Retail & E-commerce','Jasa & Konsultasi','Manufaktur','Teknologi / Software','F&B / Kuliner','Logistik & Distribusi','Konstruksi & Properti','Lainnya'] as $opt)
                    <option value="{{ $opt }}" @selected(old('industry')===$opt)>{{ $opt }}</option>
                  @endforeach
                </select>
              </div>
              <div class="field">
                <label>
                  Kota <span class="opt">(untuk faktur)</span>
                  <span class="field-tip"><span class="qmark">?</span><span class="tip-bubble">Dipakai sebagai alamat penerbit di kop faktur dan dokumen resmi lainnya.</span></span>
                </label>
                <div class="field-icon" id="wrapCity">
                  <svg class="icon fi-ic"><use href="#ic-map-pin"/></svg>
                  <input type="text" name="city" id="f-city" value="{{ old('city') }}" placeholder="cth. Surabaya">
                  <span class="fi-valid"><svg class="icon"><use href="#ic-check"/></svg></span>
                </div>
              </div>
            </div>
          </div>

          {{-- 2. PENGATURAN KEUANGAN --}}
          <div class="section" data-section="2" id="sectionAnchor2">
            <div class="section-head">
              <span class="num" id="numSection2"><svg class="icon"><use href="#ic-wallet"/></svg></span>
              <h3>Pengaturan Keuangan</h3>
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
                <label>Tahun buku aktif</label>
                @php($currentYear = date('Y'))
                <select name="fiscal_year" id="f-fiscalyear">
                  <option>{{ $currentYear }}</option>
                  <option>{{ $currentYear + 1 }}</option>
                </select>
              </div>
              <div class="field full">
                <label>Bulan mulai tahun fiskal</label>
                <select name="fiscal_start_month" id="f-fiscalstart">
                  @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m)
                    <option @selected(old('fiscal_start_month')===$m)>{{ $m }}</option>
                  @endforeach
                </select>
                <div class="field-hint">Kebanyakan bisnis di Indonesia pakai Januari–Desember.</div>
              </div>
            </div>
          </div>

          {{-- 3. REKENING AWAL --}}
          <div class="section" data-section="3" id="sectionAnchor3">
            <div class="section-head">
              <span class="num" id="numSection3"><svg class="icon"><use href="#ic-bank"/></svg></span>
              <h3>Rekening Awal</h3>
              <span class="opt-tag" id="optTag3">Untuk perhitungan arus kas</span>
              <span class="done-tag" id="doneTag3"><svg class="icon"><use href="#ic-check"/></svg> Terisi</span>
            </div>
            <div class="field-grid">
              <div class="field">
                <label>Nama bank</label>
                <div class="field-icon" id="wrapBank">
                  <svg class="icon fi-ic"><use href="#ic-bank"/></svg>
                  <select name="bank_name" id="f-bank">
                    <option value="">Pilih bank</option>
                    <option>BCA</option><option>BRI</option><option>BNI</option><option>Mandiri</option>
                    <option>CIMB Niaga</option><option>Kas Tunai (tanpa bank)</option><option>Lainnya</option>
                  </select>
                  <span class="fi-valid"><svg class="icon"><use href="#ic-check"/></svg></span>
                </div>
              </div>
              <div class="field">
                <label>Saldo awal (Rp)</label>
                <input type="number" name="initial_balance" id="f-balance" value="{{ old('initial_balance', 0) }}" min="0">
                <div class="field-hint">Belum tahu pastinya? Isi 0 dulu, sesuaikan nanti.</div>
              </div>
            </div>
          </div>

          <div class="submit-row">
            <button type="submit" class="btn btn-primary" id="submitBtn">Selesaikan Setup <svg class="icon"><use href="#ic-arrow-right"/></svg></button>
            <div class="submit-hint">Semua data bisa diubah kapan saja lewat menu Pengaturan.</div>
            <div class="trust-row">
              <span><svg class="icon"><use href="#ic-lock"/></svg> Data terenkripsi</span>
              <span><svg class="icon"><use href="#ic-clock"/></svg> Setup 2 menit</span>
              <span><svg class="icon"><use href="#ic-shield"/></svg> Bisa diubah kapan saja</span>
            </div>
          </div>

        </div>

        {{-- ===== KOLOM KANAN: LIVE PREVIEW ===== --}}
        <div class="preview-col" id="previewCol">
          <div class="preview-label"><span class="live-dot"></span> Pratinjau Langsung</div>

          <div class="preview-card-wrap">
            <div class="preview-card">
              <div class="pv-ring-wrap">
                <svg viewBox="0 0 44 44">
                  <circle cx="22" cy="22" r="19" style="stroke:var(--surface-strong)"></circle>
                  <circle cx="22" cy="22" r="19" style="stroke:var(--emerald)" stroke-linecap="round" stroke-dasharray="119.4" stroke-dashoffset="119.4" id="pvRingCircle"></circle>
                </svg>
                <div class="pv-ring-pct" id="pvRingPct">0%</div>
              </div>

              <div class="pv-head">
                <div class="pv-logo" id="pvLogo"><span id="pvLogoInitial">A</span><img id="pvLogoImg" alt=""></div>
                <div>
                  <div class="pv-name" id="pvName">Nama Perusahaanmu</div>
                  <div class="pv-sub" id="pvSub">Industri belum diisi</div>
                </div>
              </div>

              <div class="pv-rows">
                <div class="pv-row"><span class="k"><svg class="icon"><use href="#ic-map-pin"/></svg>Kota</span><span class="v" id="pvCity">—</span></div>
                <div class="pv-row"><span class="k"><svg class="icon"><use href="#ic-wallet"/></svg>Mata Uang</span><span class="v" id="pvCurrency">IDR</span></div>
                <div class="pv-row"><span class="k"><svg class="icon"><use href="#ic-clock"/></svg>Tahun Fiskal</span><span class="v" id="pvFiscal">Januari — {{ date('Y') }}</span></div>
                <div class="pv-row"><span class="k"><svg class="icon"><use href="#ic-bank"/></svg>Rekening</span><span class="v"><span class="bank-dot" id="pvBankDot"></span><span id="pvBank">Belum dipilih</span></span></div>
              </div>

              <div class="pv-balance">
                <div class="lbl">Saldo Awal</div>
                <div class="amt" id="pvBalance">Rp0</div>
                <div class="pv-spark" id="pvSpark">
                  <i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i>
                </div>
              </div>
            </div>
            <div class="receipt-tear"></div>
            <div class="receipt-dashes"></div>
          </div>

          <div class="preview-tip">
            <svg class="icon"><use href="#ic-sparkle"/></svg>
            <span>Begini kira-kira tampilan kartu perusahaanmu nanti di dashboard. Terus isi form di sebelah kiri untuk melihat perubahannya.</span>
          </div>
        </div>

      </div>
    </form>
  </div>
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

  @if(session('completed'))
  // ===== confetti burst on success screen =====
  (function(){
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if(reduceMotion) return;
    const canvas = document.getElementById('confettiCanvas');
    const ctx = canvas.getContext('2d');
    function resize(){ canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
    resize(); window.addEventListener('resize', resize);

    const colors = ['#34E0A1','#1E8F6B','#F0C05A','#EAF0F6'];
    const particles = [];
    const count = 90;
    for(let i=0;i<count;i++){
      particles.push({
        x: canvas.width/2 + (Math.random()-0.5)*220,
        y: canvas.height*0.32 + (Math.random()-0.5)*40,
        vx: (Math.random()-0.5)*7,
        vy: -Math.random()*7 - 3,
        size: Math.random()*5 + 3,
        color: colors[Math.floor(Math.random()*colors.length)],
        rot: Math.random()*360,
        vr: (Math.random()-0.5)*10,
        life: 0
      });
    }
    let frame = 0;
    function tick(){
      frame++;
      ctx.clearRect(0,0,canvas.width,canvas.height);
      let alive = false;
      particles.forEach(p => {
        p.vy += 0.16;
        p.x += p.vx;
        p.y += p.vy;
        p.rot += p.vr;
        p.life++;
        if(p.y < canvas.height + 20) alive = true;
        ctx.save();
        ctx.translate(p.x, p.y);
        ctx.rotate(p.rot * Math.PI/180);
        ctx.globalAlpha = Math.max(0, 1 - p.life/140);
        ctx.fillStyle = p.color;
        ctx.fillRect(-p.size/2, -p.size/2, p.size, p.size*0.6);
        ctx.restore();
      });
      if(alive && frame < 220){ requestAnimationFrame(tick); }
      else{ ctx.clearRect(0,0,canvas.width,canvas.height); }
    }
    requestAnimationFrame(tick);
  })();
  @endif

  @if(!session('completed'))
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ===== reveal animation for sections + preview card =====
  const revealTargets = document.querySelectorAll('.section, #previewCol');
  if(reduceMotion){
    revealTargets.forEach(el => el.classList.add('in-view'));
  } else {
    const revealObs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if(entry.isIntersecting){ entry.target.classList.add('in-view'); revealObs.unobserve(entry.target); }
      });
    }, { threshold: 0.15 });
    revealTargets.forEach(el => revealObs.observe(el));
  }

  // ===== logo upload: preview, drag & drop, remove =====
  const logoDrop = document.getElementById('logoDrop');
  const logoInput = document.getElementById('logoInput');
  const logoPreview = document.getElementById('logoPreview');
  const pvLogoImg = document.getElementById('pvLogoImg');
  const pvLogoInitial = document.getElementById('pvLogoInitial');
  const btnRemoveLogo = document.getElementById('btnRemoveLogo');

  function loadLogoFile(file){
    if(!file) return;
    const reader = new FileReader();
    reader.onload = e=>{
      logoPreview.src = e.target.result; logoPreview.style.display='block';
      pvLogoImg.src = e.target.result; pvLogoImg.style.display='block';
      pvLogoInitial.style.display='none';
      btnRemoveLogo.classList.add('show');
      syncPreview();
    };
    reader.readAsDataURL(file);
  }

  if(logoDrop){
    logoDrop.addEventListener('click', ()=> logoInput.click());
    logoInput.addEventListener('change', ()=> loadLogoFile(logoInput.files[0]));

    ['dragenter','dragover'].forEach(evt => {
      logoDrop.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); logoDrop.classList.add('drag-over'); });
    });
    ['dragleave','drop'].forEach(evt => {
      logoDrop.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); logoDrop.classList.remove('drag-over'); });
    });
    logoDrop.addEventListener('drop', e => {
      const file = e.dataTransfer.files && e.dataTransfer.files[0];
      if(file && file.type.startsWith('image/')){
        const dt = new DataTransfer();
        dt.items.add(file);
        logoInput.files = dt.files;
        loadLogoFile(file);
      }
    });
  }
  if(btnRemoveLogo){
    btnRemoveLogo.addEventListener('click', (e) => {
      e.stopPropagation();
      logoInput.value = '';
      logoPreview.src = ''; logoPreview.style.display='none';
      pvLogoImg.src = ''; pvLogoImg.style.display='none';
      pvLogoInitial.style.display='block';
      btnRemoveLogo.classList.remove('show');
      syncPreview();
    });
  }

  // ===== LIVE PREVIEW CARD SYNC =====
  const fCompany = document.getElementById('f-company');
  const fIndustry = document.getElementById('f-industry');
  const fCity = document.getElementById('f-city');
  const fCurrency = document.getElementById('f-currency');
  const fFiscalYear = document.getElementById('f-fiscalyear');
  const fFiscalStart = document.getElementById('f-fiscalstart');
  const fBank = document.getElementById('f-bank');
  const fBalance = document.getElementById('f-balance');

  const pvName = document.getElementById('pvName');
  const pvSub = document.getElementById('pvSub');
  const pvCity = document.getElementById('pvCity');
  const pvCurrency = document.getElementById('pvCurrency');
  const pvFiscal = document.getElementById('pvFiscal');
  const pvBank = document.getElementById('pvBank');
  const pvBankDot = document.getElementById('pvBankDot');
  const pvBalance = document.getElementById('pvBalance');
  const pvSparkBars = document.querySelectorAll('#pvSpark i');

  const numSection1 = document.getElementById('numSection1');
  const numSection3 = document.getElementById('numSection3');
  const doneTag1 = document.getElementById('doneTag1');
  const doneTag3 = document.getElementById('doneTag3');
  const optTag3 = document.getElementById('optTag3');

  const wrapCompany = document.getElementById('wrapCompany');
  const wrapCity = document.getElementById('wrapCity');
  const wrapBank = document.getElementById('wrapBank');

  const completionFill = document.getElementById('completionFill');
  const completionPct = document.getElementById('completionPct');
  const mobilePct = document.getElementById('mobilePct');
  const pvRingCircle = document.getElementById('pvRingCircle');
  const pvRingPct = document.getElementById('pvRingPct');
  const RING_CIRCUMFERENCE = 119.4;

  const currencySymbols = { IDR:'Rp', USD:'$', SGD:'S$', MYR:'RM' };
  const bankColors = {
    'BCA':'#1479C9','BRI':'#00529C','BNI':'#F37021','Mandiri':'#003D79',
    'CIMB Niaga':'#8B1D2C','Kas Tunai (tanpa bank)':'#34E0A1','Lainnya':'#8A96AE'
  };

  function formatRupiah(n){
    n = parseInt(n || 0, 10);
    return n.toLocaleString('id-ID');
  }

  function computeCompletion(){
    let score = 0;
    if(fCompany.value.trim()) score += 25;
    if(fIndustry.value) score += 15;
    if(fCity.value.trim()) score += 10;
    if(pvLogoImg.style.display === 'block') score += 15;
    if(fBank.value) score += 20;
    if(parseInt(fBalance.value || 0, 10) > 0) score += 15;
    return Math.min(score, 100);
  }

  let lastBalanceStr = '';
  function syncPreview(){
    pvName.textContent = fCompany.value.trim() || 'Nama Perusahaanmu';
    pvLogoInitial.textContent = (fCompany.value.trim().substring(0,2) || 'PT').toUpperCase();
    pvSub.textContent = fIndustry.value || 'Industri belum diisi';
    pvCity.textContent = fCity.value.trim() || '—';
    pvCurrency.textContent = fCurrency.value;
    pvFiscal.textContent = fFiscalStart.value + ' — ' + fFiscalYear.value;
    pvBank.textContent = fBank.value || 'Belum dipilih';
    pvBankDot.style.background = fBank.value ? (bankColors[fBank.value] || '#8A96AE') : 'var(--border)';

    const symbol = currencySymbols[fCurrency.value] || 'Rp';
    const newBalanceStr = symbol + formatRupiah(fBalance.value);
    if(newBalanceStr !== lastBalanceStr){
      pvBalance.textContent = newBalanceStr;
      pvBalance.classList.add('bump');
      setTimeout(() => pvBalance.classList.remove('bump'), 160);
      lastBalanceStr = newBalanceStr;
    }

    // field-level valid checkmarks
    wrapCompany.classList.toggle('is-valid', !!fCompany.value.trim());
    wrapCity.classList.toggle('is-valid', !!fCity.value.trim());
    wrapBank.classList.toggle('is-valid', !!fBank.value);

    // section 1 done state
    const section1Done = !!fCompany.value.trim();
    numSection1.classList.toggle('done', section1Done);
    doneTag1.classList.toggle('show', section1Done);
    numSection1.innerHTML = section1Done
      ? '<svg class="icon"><use href="#ic-check"/></svg>'
      : '<svg class="icon"><use href="#ic-building"/></svg>';

    // section 3 done state
    const section3Done = !!fBank.value;
    numSection3.classList.toggle('done', section3Done);
    doneTag3.classList.toggle('show', section3Done);
    optTag3.style.display = section3Done ? 'none' : '';
    numSection3.innerHTML = section3Done
      ? '<svg class="icon"><use href="#ic-check"/></svg>'
      : '<svg class="icon"><use href="#ic-bank"/></svg>';

    // spark bars
    const bal = parseInt(fBalance.value || 0, 10);
    const boost = Math.min(bal / 5000000, 1);
    pvSparkBars.forEach((bar, i) => {
      const base = 25 + ((i * 37) % 55);
      const h = Math.min(base + boost * 30, 95);
      bar.style.height = h + '%';
    });

    // overall completion bar + ring + mobile dots
    const pct = computeCompletion();
    completionFill.style.width = pct + '%';
    completionPct.textContent = pct + '%';
    if(mobilePct) mobilePct.textContent = pct + '%';
    const offset = RING_CIRCUMFERENCE * (1 - pct/100);
    pvRingCircle.style.transition = 'stroke-dashoffset .5s cubic-bezier(.4,0,.2,1)';
    pvRingCircle.style.strokeDashoffset = offset;
    pvRingPct.textContent = pct + '%';
  }
  [fCompany, fIndustry, fCity, fCurrency, fFiscalYear, fFiscalStart, fBank, fBalance].forEach(el => {
    if(el){ el.addEventListener('input', syncPreview); el.addEventListener('change', syncPreview); }
  });
  syncPreview();

  // ===== PROGRESS STEP: highlight + click-to-scroll =====
  const sections = document.querySelectorAll('[data-section]');
  const steps = document.querySelectorAll('.progress-step');
  const mobileDots = document.querySelectorAll('.m-dot');
  const line1 = document.getElementById('line1');
  const line2 = document.getElementById('line2');

  function setActiveStep(n){
    steps.forEach(s => {
      const step = parseInt(s.dataset.step, 10);
      s.classList.remove('active','done');
      if(step < n) s.classList.add('done');
      else if(step === n) s.classList.add('active');
    });
    mobileDots.forEach(d => {
      const step = parseInt(d.dataset.mdot, 10);
      d.classList.remove('active','done');
      if(step < n) d.classList.add('done');
      else if(step === n) d.classList.add('active');
    });
    if(line1) line1.classList.toggle('done', n > 1);
    if(line2) line2.classList.toggle('done', n > 2);
  }

  steps.forEach(btn => {
    btn.addEventListener('click', () => {
      const n = btn.dataset.step;
      const target = document.getElementById('sectionAnchor' + n);
      if(target) target.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
    });
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting){
        setActiveStep(parseInt(entry.target.dataset.section, 10));
      }
    });
  }, { rootMargin: '-30% 0px -60% 0px', threshold: 0 });
  sections.forEach(s => observer.observe(s));

  // ===== submit button loading state =====
  const onboardingForm = document.getElementById('onboardingForm');
  const submitBtn = document.getElementById('submitBtn');
  if(onboardingForm && submitBtn){
    onboardingForm.addEventListener('submit', () => {
      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Menyimpan...';
    });
  }
  @endif
</script>
</body>
</html>