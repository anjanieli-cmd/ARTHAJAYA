<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buat Akun — Arthajaya</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Arthajaya — Akuntansi Bisnis, Secepat Langkahmu</title>
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

  /* LIGHT THEME */
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

  /* ACCENT COLOR VARIANTS */
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
  }
  #starfield{ transition: opacity .35s ease; opacity: var(--star-op); }
  .bg-glow, .bg-glow-2{ transition: background .35s ease; }
  h1,h2,h3,.display{ font-family:'Space Grotesk', sans-serif; letter-spacing:-0.02em; }
  .mono{ font-family:'IBM Plex Mono', monospace; }
  a{ text-decoration:none; color:inherit; }
  ul{ list-style:none; }
  svg{ display:block; }
  .icon{ width:1em; height:1em; }

  /* STARFIELD */
  #starfield{ position:fixed; inset:0; z-index:0; pointer-events:none; overflow:hidden; }
  .star{ position:absolute; border-radius:50%; background:#fff; animation: twinkle 3s ease-in-out infinite; }
  @keyframes twinkle{ 0%,100%{opacity:.15;} 50%{opacity:.9;} }

  .bg-glow{ position:fixed; top:-25%; right:-10%; width:900px; height:900px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow1-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }
  .bg-glow-2{ position:fixed; bottom:-15%; left:-15%; width:700px; height:700px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow2-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }

  .wrap{ max-width:1220px; margin:0 auto; padding:0 32px; position:relative; z-index:2; }

  /* reveal on scroll */
  .reveal{ opacity:0; transform: translateY(26px); transition: opacity .7s ease, transform .7s ease; }
  .reveal.in-view{ opacity:1; transform: translateY(0); }

  /* NAV */
  nav{ position:sticky; top:0; z-index:50; background:var(--nav-bg); backdrop-filter:blur(16px); border-bottom:1px solid var(--border); transition: background .35s ease, border-color .35s ease; }
  .nav-inner{ display:flex; align-items:center; justify-content:space-between; padding:18px 32px; max-width:1220px; margin:0 auto; }
  .logo{ display:flex; align-items:center; gap:10px; font-family:'Space Grotesk'; font-weight:700; font-size:19px; }
  .logo-mark{ width:30px; height:30px; border-radius:8px; background:linear-gradient(135deg,var(--emerald),var(--emerald-dim)); display:flex; align-items:center; justify-content:center; font-size:15px; color:#062A1C; font-weight:800; }
  .logo .dot{ color:var(--emerald); }
  .nav-links{ display:flex; gap:34px; font-size:14.5px; color:var(--text-mute); }
  .nav-links a{ display:flex; align-items:center; gap:5px; position:relative; padding:4px 0; transition: color .2s ease; }
  .nav-links a::after{ content:''; position:absolute; left:0; bottom:0; width:0; height:1.5px; background:var(--emerald); transition: width .25s ease; }
  .nav-links a:hover{ color:var(--text); }
  .nav-links a:hover::after{ width:100%; }
  .nav-links .icon{ width:14px; height:14px; }
  .nav-right{ display:flex; align-items:center; gap:22px; }
  .btn-ghost{ font-size:14.5px; color:var(--text-mute); transition: color .2s ease; }
  .btn-ghost:hover{ color:var(--text); }
  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 22px; border-radius:12px; font-size:14.5px; font-weight:600; cursor:pointer; border:none; transition:all .25s ease; }
  .btn .icon{ width:16px; height:16px; transition: transform .25s ease; }
  .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 24px rgba(var(--emerald-rgb),0.35); }
  .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 10px 32px rgba(var(--emerald-rgb),0.5); }
  .btn-primary:hover .icon{ transform: translateX(3px); }
  .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .btn-outline:hover{ background:var(--surface-strong); border-color: var(--border-hover); transform: translateY(-2px); }

  /* HERO */
  .hero{ padding:56px 0 32px; display:grid; grid-template-columns:1.05fr 1fr; gap:30px; align-items:center; position:relative; }
  .eyebrow{ display:inline-flex; align-items:center; gap:8px; padding:7px 14px; border-radius:100px; background:var(--surface); border:1px solid var(--border); font-size:13px; color:var(--emerald); font-weight:500; margin-bottom:24px; }
  .eyebrow::before{ content:''; width:6px; height:6px; border-radius:50%; background:var(--emerald); box-shadow:0 0 8px var(--emerald); }
  .hero h1{ font-size:54px; line-height:1.08; font-weight:700; margin-bottom:22px; }
  .hero h1 .accent{ color:var(--emerald); }
  .hero p.sub{ font-size:17px; color:var(--text-mute); max-width:440px; margin-bottom:32px; }
  .hero-cta{ display:flex; gap:14px; margin-bottom:44px; }
  .stat-row{ display:flex; gap:36px; flex-wrap:wrap; }
  .stat-row .stat{ cursor:default; transition: transform .25s ease; }
  .stat-row .stat:hover{ transform: translateY(-4px); }
  .stat-row .num{ font-family:'Space Grotesk'; font-size:26px; font-weight:700; }
  .stat-row .num.green{ color:var(--emerald); }
  .stat-row .lbl{ font-size:12.5px; color:var(--text-faint); margin-top:3px; }

  /* HERO VISUAL */
  .visual-stage{ position:relative; height:620px; }
  .swirl{ position:absolute; top:50%; left:52%; width:480px; height:480px; margin:-240px 0 0 -240px; border-radius:50%; background: conic-gradient(from 0deg, transparent 0%, rgba(var(--emerald-rgb),0.35) 15%, transparent 32%, transparent 100%); filter: blur(8px); animation: swirlSpin 9s linear infinite; }
  @keyframes swirlSpin{ from{transform:rotate(0deg);} to{transform:rotate(360deg);} }

  .asteroid{ position:absolute; border-radius:50%; background: linear-gradient(160deg, rgba(255,255,255,0.15), rgba(255,255,255,0.02)); border:1px solid rgba(255,255,255,0.12); box-shadow: inset -4px -4px 8px rgba(0,0,0,0.4), 0 6px 16px rgba(0,0,0,0.4); }
  .a1{ width:20px; height:20px; top:10%; left:6%; animation: floatSlow 6s ease-in-out infinite; }
  .a2{ width:14px; height:14px; top:68%; left:2%; animation: floatSlow 7.5s ease-in-out infinite 1s; }
  .a3{ width:26px; height:26px; top:4%; right:4%; animation: floatSlow 8s ease-in-out infinite .5s; }
  .a4{ width:16px; height:16px; top:80%; right:10%; animation: floatSlow 6.5s ease-in-out infinite 1.5s; }
  @keyframes floatSlow{ 0%,100%{transform:translateY(0px);} 50%{transform:translateY(-18px);} }

  /* DASHBOARD LAPTOP MOCKUP — landscape, real laptop proportions */
  .laptop-wrap{
    position:absolute; top:6px; right:-70px; width:600px; z-index:2;
    transform-style:preserve-3d; transition: filter .3s ease, opacity 1.1s cubic-bezier(.16,1,.3,1), transform 1.1s cubic-bezier(.16,1,.3,1);
    opacity:0; transform: scale(.72) translateY(70px) rotateY(-10deg) rotateX(5deg) rotateZ(-1deg);
    filter: blur(14px);
  }
  .laptop-wrap.mockup-in{ opacity:1; filter:blur(0); transform: rotateY(-10deg) rotateX(5deg) rotateZ(-1deg) translateY(0) scale(1); }
  .laptop-wrap.floating{ animation: winFloat 6s ease-in-out infinite; }
  .laptop-wrap:hover{ animation-play-state: paused; filter: brightness(1.05); }
  @keyframes winFloat{ 0%,100%{ transform: rotateY(-10deg) rotateX(5deg) rotateZ(-1deg) translateY(0); } 50%{ transform: rotateY(-5deg) rotateX(3deg) rotateZ(-1deg) translateY(-16px); } }

  .laptop-screen-frame{
    background: linear-gradient(160deg,#1B2029,#101319);
    border-radius: 16px 16px 5px 5px;
    padding: 12px 12px 6px;
    box-shadow: 0 50px 100px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.04);
  }
  .laptop-camera{ width:6px; height:6px; border-radius:50%; background:#3A4150; margin:0 auto 10px; box-shadow: 0 0 4px rgba(255,255,255,0.1) inset; }
  .window{ background:var(--bg); border-radius:8px; border:1px solid var(--border); overflow:hidden; transition: background .35s ease; }

  .laptop-topbar{ display:flex; align-items:center; gap:14px; padding:10px 14px; border-bottom:1px solid var(--border); }
  .tl-dot{ width:8px; height:8px; border-radius:50%; opacity:.7; }
  .tl-dot.r{ background:#ff5f57; } .tl-dot.y{ background:#febc2e; } .tl-dot.g{ background:#28c840; }
  .laptop-tab{ display:flex; align-items:center; gap:7px; margin-left:6px; font-size:10.5px; color:var(--text-faint); background:var(--surface); border:1px solid var(--border); padding:4px 12px; border-radius:7px; }
  .laptop-tab::before{ content:''; width:5px; height:5px; border-radius:50%; background:var(--emerald); box-shadow:0 0 6px var(--emerald); animation: dotPulse 2s ease-in-out infinite; }
  @keyframes dotPulse{ 0%,100%{ opacity:.4; } 50%{ opacity:1; } }

  .dash-shell{ display:grid; grid-template-columns:52px 1fr; }
  .dash-side{ display:flex; flex-direction:column; align-items:center; gap:16px; padding:16px 0; border-right:1px solid var(--border); background:var(--surface); transition: background .35s ease; }
  .side-logo{ width:26px; height:26px; border-radius:8px; background:linear-gradient(135deg,var(--emerald),var(--emerald-dim)); margin-bottom:6px; }
  .side-ic{ width:30px; height:30px; border-radius:9px; display:flex; align-items:center; justify-content:center; color:var(--text-faint); transition: all .2s ease; cursor:pointer; }
  .side-ic .icon{ width:14px; height:14px; }
  .side-ic.active{ background:rgba(var(--emerald-rgb),0.14); color:var(--emerald); }
  .side-ic:hover{ color:var(--text); background:var(--surface-strong); }
  .side-ic.bottom{ margin-top:auto; }

  .dash-main{ padding:18px 20px 16px; min-width:0; }

  .w-greet{ display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; }
  .w-greet .hi{ font-size:14.5px; font-weight:600; }
  .w-bell{ width:28px; height:28px; border-radius:9px; background:var(--surface-strong); display:flex; align-items:center; justify-content:center; color:var(--text-mute); transition: color .2s ease, background .2s ease; }
  .w-bell:hover{ color: var(--emerald); background: var(--surface); cursor:pointer; }
  .w-bell .icon{ width:14px; height:14px; }

  .dash-row-top{ display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:18px; }
  .w-balance-label{ font-size:11px; color:var(--text-faint); margin-bottom:6px; }
  .w-balance{ font-family:'Space Grotesk'; font-size:26px; font-weight:700; margin-bottom:6px; white-space:nowrap; }
  .w-delta{ font-size:11px; color:var(--emerald); display:flex; align-items:center; gap:5px; }
  .w-delta .icon{ width:12px; height:12px; }

  .w-actions{ display:flex; gap:10px; flex-shrink:0; }
  .w-action{ display:flex; flex-direction:column; align-items:center; gap:6px; font-size:9.5px; color:var(--text-mute); cursor:pointer; }
  .w-action .ic{ width:34px; height:34px; border-radius:10px; background:var(--surface-strong); display:flex; align-items:center; justify-content:center; color:var(--text); transition: all .2s ease; }
  .w-action .ic .icon{ width:15px; height:15px; }
  .w-action:hover .ic{ background: rgba(var(--emerald-rgb),0.15); color: var(--emerald); transform: translateY(-3px); }

  .dash-row-bottom{ display:grid; grid-template-columns:1fr 1fr; gap:12px; }

  .w-card{ background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:14px 16px; transition: border-color .2s ease, background .2s ease; }
  .w-card:hover{ border-color: var(--border-hover); background: var(--surface-strong); }
  .w-card .lbl{ font-size:10.5px; color:var(--text-faint); margin-bottom:4px; }
  .w-card .val{ font-family:'Space Grotesk'; font-size:16px; font-weight:700; }
  .w-card .sub{ font-size:10.5px; color:var(--emerald); margin-top:2px; }
  .w-spark{ display:flex; align-items:flex-end; gap:4px; height:44px; margin-top:12px; }
  .w-spark i{ flex:1; background:linear-gradient(180deg,var(--emerald),var(--emerald-dim)); border-radius:2px; opacity:.85; height:4%; transition: height .8s cubic-bezier(.16,1,.3,1); }

  .tx-panel{ background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:12px 14px; overflow:hidden; }
  .w-tx-title{ font-size:10.5px; color:var(--text-faint); margin-bottom:4px; }
  .tx-viewport{ height:110px; overflow:hidden; position:relative; -webkit-mask-image:linear-gradient(180deg, transparent 0%, #000 14%, #000 86%, transparent 100%); mask-image:linear-gradient(180deg, transparent 0%, #000 14%, #000 86%, transparent 100%); }
  .tx-track{ animation: txScroll 9s linear infinite; animation-play-state: paused; }
  .tx-track.playing{ animation-play-state: running; }
  @keyframes txScroll{ 0%{ transform:translateY(0); } 100%{ transform:translateY(-50%); } }
  .w-tx{ display:flex; align-items:center; gap:10px; padding:7px 4px; border-radius:10px; transition: background .2s ease; }
  .w-tx:hover{ background: var(--surface-strong); }
  .w-tx .ic{ width:28px; height:28px; border-radius:9px; background:var(--surface-strong); display:flex; align-items:center; justify-content:center; color:var(--text-mute); flex-shrink:0; }
  .w-tx .ic .icon{ width:14px; height:14px; }
  .w-tx .info{ flex:1; min-width:0; }
  .w-tx .info .n{ font-size:11.5px; font-weight:500; }
  .w-tx .info .d{ font-size:9.5px; color:var(--text-faint); }
  .w-tx .amt{ font-family:'IBM Plex Mono'; font-size:11px; flex-shrink:0; }
  .w-tx .amt.neg{ color:var(--text-mute); }
  .w-tx .amt.pos{ color:var(--emerald); }

  .laptop-base{
    position: relative;
    width: 108%;
    margin-left: -4%;
    height: 16px;
    background: linear-gradient(180deg,#22272F,#12151B);
    border-radius: 0 0 12px 12px;
    box-shadow: 0 14px 28px rgba(0,0,0,0.5);
  }
  .laptop-base::before{
    content:'';
    position:absolute; top:0; left:50%; transform:translateX(-50%);
    width:64px; height:6px;
    background: linear-gradient(180deg,#0B0D11,#080a0d);
    border-radius: 0 0 8px 8px;
  }

  /* LOGO STRIP */
  .logo-strip{ padding:56px 0; border-top:1px solid var(--border); border-bottom:1px solid var(--border); }
  .logo-strip p{ text-align:center; font-size:12.5px; letter-spacing:.08em; text-transform:uppercase; color:var(--text-faint); margin-bottom:30px; }
  .logo-row{ display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:20px; }
  .logo-row span{ color:var(--text-faint); font-family:'Space Grotesk'; font-weight:600; font-size:16.5px; opacity:.5; transition: opacity .2s ease, color .2s ease; cursor:default; }
  .logo-row span:hover{ opacity:1; color:var(--text); }

  /* FEATURES + DASHBOARD PREVIEW */
  .features{ padding:60px 0; display:grid; grid-template-columns:0.85fr 1.15fr; gap:60px; align-items:center; }
  .tag{ color:var(--emerald); font-size:13px; font-weight:600; letter-spacing:.05em; text-transform:uppercase; margin-bottom:14px; display:block; }
  .features h2{ font-size:34px; margin-bottom:30px; line-height:1.15; }
  .feat-item{ display:flex; gap:16px; margin-bottom:10px; padding:14px; border-radius:14px; transition: background .25s ease, transform .25s ease; }
  .feat-item:hover{ background: var(--surface); transform: translateX(6px); }
  .feat-item .ic{ width:44px; height:44px; border-radius:12px; background:rgba(var(--emerald-rgb),0.12); display:flex; align-items:center; justify-content:center; color: var(--emerald); flex-shrink:0; transition: transform .25s ease; }
  .feat-item .ic .icon{ width:20px; height:20px; }
  .feat-item:hover .ic{ transform: scale(1.08) rotate(-4deg); }
  .feat-item h3{ font-size:16px; margin-bottom:6px; font-weight:600; }
  .feat-item p{ font-size:13.5px; color:var(--text-mute); line-height:1.55; }

  .dash-grid{ display:grid; grid-template-columns:1fr; gap:18px; }
  .dash-card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:24px; backdrop-filter: blur(10px); transition: border-color .25s ease, transform .25s ease; }
  .dash-card:hover{ border-color: var(--border-hover); transform: translateY(-4px); }
  .dash-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; font-size:13.5px; color:var(--text-mute); }
  .dash-head .icon{ width:13px; height:13px; }
  .donut-wrap{ display:flex; gap:26px; align-items:center; }
  .donut{ width:130px; height:130px; position:relative; flex-shrink:0; }
  .donut svg{ transform:rotate(-90deg); width:100%; height:100%; }
  .donut circle{ fill:none; stroke-width:14; }
  .donut-center{ position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
  .donut-center .amt{ font-family:'Space Grotesk'; font-size:15px; font-weight:700; }
  .donut-center .lbl{ font-size:9.5px; color:var(--text-faint); }
  .legend{ flex:1; }
  .legend-row{ display:flex; justify-content:space-between; align-items:center; font-size:12.5px; padding:6px 8px; border-radius:8px; color:var(--text-mute); transition: background .2s ease; }
  .legend-row:hover{ background: var(--surface-strong); color:var(--text); }
  .legend-row .dot{ width:8px; height:8px; border-radius:50%; display:inline-block; margin-right:8px; }
  .legend-row .amt{ font-family:'IBM Plex Mono'; color:var(--text); }

  .dash-row2{ display:grid; grid-template-columns:1fr 1fr; gap:18px; }
  .mini-title{ font-size:12.5px; color:var(--text-mute); margin-bottom:14px; display:flex; justify-content:space-between; align-items:center; }
  .mini-title .icon{ width:15px; height:15px; color: var(--emerald); }
  .progress-bar{ height:8px; border-radius:100px; background:var(--surface-strong); overflow:hidden; margin-top:14px; }
  .progress-fill{ height:100%; background:linear-gradient(90deg,var(--emerald-dim),var(--emerald)); border-radius:100px; width:0%; }
  .progress-fill.animate{ animation: fillBar 1.6s ease-out .1s forwards; }
  @keyframes fillBar{ to{ width:42%; } }
  .progress-labels{ display:flex; justify-content:space-between; font-size:11px; color:var(--text-faint); margin-top:8px; }
  .mini-value{ font-family:'Space Grotesk'; font-size:19px; font-weight:700; }
  .mini-sub{ font-size:11.5px; color:var(--emerald); margin-top:2px; }
  .mini-chart{ display:flex; align-items:flex-end; gap:4px; height:36px; margin-top:14px; }
  .mini-chart i{ flex:1; background:linear-gradient(180deg,var(--emerald),transparent); border-radius:2px; opacity:.8; }

  /* TESTIMONIALS */
  .testimonials{ padding:60px 0; }
  .testimonials-head{ text-align:center; max-width:560px; margin:0 auto 44px; }
  .testimonials-head h2{ font-size:32px; margin-top:10px; }
  .testi-scroll{ position:relative; margin:0 -32px; padding:0 32px; }
  .testi-scroll::before, .testi-scroll::after{ content:''; position:absolute; top:0; bottom:0; width:60px; z-index:2; pointer-events:none; }
  .testi-scroll::before{ left:0; background:linear-gradient(90deg, var(--bg), transparent); }
  .testi-scroll::after{ right:0; background:linear-gradient(270deg, var(--bg), transparent); }
  .testi-grid{ display:flex; gap:20px; overflow-x:auto; scroll-snap-type:x proximity; padding-bottom:10px; scrollbar-width:thin; scrollbar-color: var(--border-hover) transparent; }
  .testi-grid::-webkit-scrollbar{ height:6px; }
  .testi-grid::-webkit-scrollbar-track{ background:transparent; }
  .testi-grid::-webkit-scrollbar-thumb{ background:var(--border); border-radius:100px; }
  .testi-grid::-webkit-scrollbar-thumb:hover{ background:var(--border-hover); }
  .testi-card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:26px; transition: border-color .25s ease, transform .25s ease; flex:0 0 340px; scroll-snap-align:start; }
  .testi-card:hover{ border-color:var(--border-hover); transform:translateY(-4px); }
  .testi-stars{ display:flex; gap:3px; margin-bottom:16px; color:var(--emerald); }
  .testi-stars .icon{ width:14px; height:14px; }
  .testi-quote{ font-size:14.5px; color:var(--text); line-height:1.6; margin-bottom:22px; }
  .testi-person{ display:flex; align-items:center; gap:12px; }
  .testi-avatar{ width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg,var(--emerald),var(--emerald-dim)); display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk'; font-weight:700; font-size:13px; color:#052117; flex-shrink:0; }
  .testi-name{ font-size:13.5px; font-weight:600; }
  .testi-role{ font-size:12px; color:var(--text-faint); }

  /* FAQ */
  /* SECURITY */
  .security{ padding:60px 0; }
  .security-head{ text-align:center; max-width:560px; margin:0 auto 44px; }
  .security-head h2{ font-size:32px; margin-top:10px; }
  .security-grid{ display:grid; grid-template-columns:repeat(4,1fr); gap:18px; }
  .sec-card{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px 20px; transition: border-color .25s ease, transform .25s ease; }
  .sec-card:hover{ border-color: var(--border-hover); transform: translateY(-3px); }
  .sec-card .ic{ width:42px; height:42px; border-radius:11px; background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.25); display:flex; align-items:center; justify-content:center; margin-bottom:16px; }
  .sec-card .ic .icon{ width:20px; height:20px; color:var(--emerald); }
  .sec-card h3{ font-size:15.5px; margin-bottom:8px; }
  .sec-card p{ font-size:13.5px; color:var(--text-mute); line-height:1.6; }

  /* PRICING */
  .pricing{ padding:60px 0; }
  .pricing-head{ text-align:center; max-width:560px; margin:0 auto 44px; }
  .pricing-head h2{ font-size:32px; margin-top:10px; }
  .pricing-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:20px; align-items:stretch; }
  .price-card{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:30px 26px; display:flex; flex-direction:column; transition: border-color .25s ease, transform .25s ease; position:relative; }
  .price-card:hover{ border-color: var(--border-hover); transform: translateY(-4px); }
  .price-card.popular{ border-color: var(--emerald); background:linear-gradient(160deg, rgba(var(--emerald-rgb),0.09), var(--surface) 60%); }
  .price-badge{ position:absolute; top:-13px; left:50%; transform:translateX(-50%); background:var(--emerald); color:#052117; font-size:11.5px; font-weight:700; padding:5px 14px; border-radius:100px; white-space:nowrap; }
  .price-name{ font-family:'Space Grotesk'; font-weight:700; font-size:18px; margin-bottom:6px; }
  .price-desc{ font-size:13px; color:var(--text-mute); margin-bottom:20px; min-height:36px; }
  .price-amount{ font-family:'Space Grotesk'; font-size:34px; font-weight:700; margin-bottom:2px; }
  .price-amount span{ font-size:14px; font-weight:500; color:var(--text-mute); }
  .price-period{ font-size:12.5px; color:var(--text-faint); margin-bottom:24px; }
  .price-features{ display:flex; flex-direction:column; gap:12px; margin-bottom:26px; flex:1; }
  .price-features li{ display:flex; align-items:flex-start; gap:10px; font-size:13.5px; color:var(--text-mute); list-style:none; }
  .price-features .icon{ width:16px; height:16px; color:var(--emerald); flex-shrink:0; margin-top:2px; }
  .price-card .btn{ width:100%; justify-content:center; }

  .faq{ padding:60px 0; }
  .faq-head{ text-align:center; max-width:560px; margin:0 auto 40px; }
  .faq-head h2{ font-size:32px; margin-top:10px; }
  .faq-list{ max-width:760px; margin:0 auto; display:flex; flex-direction:column; gap:12px; }
  .faq-item{ background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; transition: border-color .25s ease; }
  .faq-item:hover{ border-color:var(--border-hover); }
  .faq-item.open{ border-color:var(--border-hover); background:var(--surface-strong); }
  .faq-q{ width:100%; display:flex; align-items:center; justify-content:space-between; gap:16px; padding:20px 24px; background:none; border:none; cursor:pointer; text-align:left; font-family:'Inter'; color:var(--text); font-size:15px; font-weight:600; }
  .faq-q-icon{ width:28px; height:28px; border-radius:9px; background:var(--surface-strong); display:flex; align-items:center; justify-content:center; color:var(--text-mute); flex-shrink:0; transition: transform .35s cubic-bezier(.4,0,.2,1), background .25s ease, color .25s ease; }
  .faq-q-icon .icon{ width:14px; height:14px; }
  .faq-item.open .faq-q-icon{ transform: rotate(180deg); background:rgba(var(--emerald-rgb),0.15); color:var(--emerald); }
  .faq-a-wrap{ display:grid; grid-template-rows:0fr; transition: grid-template-rows .38s cubic-bezier(.4,0,.2,1); }
  .faq-item.open .faq-a-wrap{ grid-template-rows:1fr; }
  .faq-a-inner{ overflow:hidden; }
  .faq-a{ padding:0 24px 22px; font-size:14px; color:var(--text-mute); line-height:1.7; max-width:640px; }

  .cta-banner{ margin:0 0 64px; background:linear-gradient(135deg, rgba(var(--emerald-rgb),0.12), rgba(var(--emerald-rgb),0.06)); border:1px solid rgba(var(--emerald-rgb),0.25); border-radius:28px; padding:48px 50px; display:flex; align-items:center; justify-content:space-between; gap:30px; flex-wrap:wrap; transition: border-color .3s ease; }
  .cta-banner:hover{ border-color: rgba(var(--emerald-rgb),0.5); }
  .cta-banner-left{ display:flex; align-items:center; gap:22px; }
  .cta-banner-left .logo-mark{ width:56px; height:56px; border-radius:16px; font-size:24px; }
  .cta-banner h2{ font-size:27px; max-width:420px; }
  .cta-checks{ display:flex; gap:18px; margin-top:12px; flex-wrap:wrap; }
  .cta-checks span{ font-size:12.5px; color:var(--text-mute); display:flex; align-items:center; gap:6px; }
  .cta-checks .icon{ width:13px; height:13px; color:var(--emerald); }

  /* FOOTER */
  footer{ border-top:1px solid var(--border); padding:50px 0 36px; }
  .footer-grid{ display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:40px; margin-bottom:40px; }
  .footer-grid p{ color:var(--text-mute); font-size:13.5px; max-width:260px; margin-top:14px; }
  .footer-col h4{ font-size:13.5px; margin-bottom:16px; }
  .footer-col a{ display:block; font-size:13.5px; color:var(--text-mute); margin-bottom:11px; transition: color .2s ease, transform .2s ease; }
  .footer-col a:hover{ color:var(--emerald); transform: translateX(3px); }
  .footer-bottom{ display:flex; justify-content:space-between; padding-top:26px; border-top:1px solid var(--border); font-size:12.5px; color:var(--text-faint); flex-wrap:wrap; gap:10px; }

  /* AUTH MODAL */
  .auth-backdrop{ display:none; position:fixed; inset:0; background:rgba(4,7,12,0.7); backdrop-filter:blur(4px); z-index:200; opacity:0; transition:opacity .3s ease; }
  .auth-backdrop.open{ display:block; opacity:1; }
  .auth-modal{ display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-48%) scale(.97); width:min(420px, 92vw); max-height:88vh; overflow-y:auto; background:var(--modal-bg); border:1px solid var(--border); border-radius:22px; padding:34px 30px 28px; z-index:201; box-shadow:0 40px 100px rgba(0,0,0,0.55); opacity:0; transition: opacity .25s ease, transform .25s ease, background .35s ease; }
  .auth-modal.open{ display:block; opacity:1; transform:translate(-50%,-50%) scale(1); }
  .auth-modal-close{ position:absolute; top:18px; right:18px; width:32px; height:32px; border-radius:9px; background:var(--surface); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; cursor:pointer; color:var(--text-mute); transition: color .2s ease, background .2s ease; }
  .auth-modal-close:hover{ color:var(--text); background:var(--surface-strong); }
  .auth-modal-close .icon{ width:14px; height:14px; }
  .auth-panel{ display:none; }
  .auth-panel.active{ display:block; }
  .auth-head{ margin-bottom:22px; }
  .auth-head .logo{ margin-bottom:20px; }
  .auth-head h2{ font-size:22px; margin-bottom:6px; }
  .auth-head p{ font-size:13.5px; color:var(--text-mute); }
  .auth-social{ width:100%; margin-bottom:18px; }
  .auth-social .icon{ width:17px; height:17px; }
  .auth-divider{ display:flex; align-items:center; gap:12px; margin-bottom:18px; }
  .auth-divider::before, .auth-divider::after{ content:''; flex:1; height:1px; background:var(--border); }
  .auth-divider span{ font-size:11.5px; color:var(--text-faint); white-space:nowrap; }
  .auth-form{ display:flex; flex-direction:column; gap:15px; }
  .field{ display:flex; flex-direction:column; gap:7px; }
  .field > span{ font-size:12.5px; color:var(--text-mute); font-weight:500; }
  .field-input{ display:flex; align-items:center; gap:10px; padding:12px 14px; border-radius:12px; background:var(--surface); border:1px solid var(--border); transition: border-color .2s ease, background .2s ease; }
  .field-input:focus-within{ border-color: var(--border-hover); background:var(--surface-strong); }
  .field-input .icon{ width:16px; height:16px; color:var(--text-faint); flex-shrink:0; }
  .field-input input{ flex:1; min-width:0; background:none; border:none; outline:none; color:var(--text); font-family:'Inter'; font-size:14px; }
  .field-input input::placeholder{ color:var(--text-faint); }
  .toggle-eye{ cursor:pointer; transition: color .2s ease; }
  .toggle-eye:hover{ color:var(--text-mute); }
  .field-row{ display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; }
  .checkbox{ display:flex; align-items:center; gap:8px; font-size:12.5px; color:var(--text-mute); cursor:pointer; }
  .checkbox input{ accent-color: var(--emerald); width:15px; height:15px; flex-shrink:0; }
  .checkbox.terms{ align-items:flex-start; line-height:1.5; }
  .checkbox.terms input{ margin-top:2px; }
  .auth-link{ font-size:12.5px; color:var(--emerald); transition: opacity .2s ease; }
  .auth-link:hover{ opacity:.8; }
  .auth-submit{ width:100%; margin-top:4px; padding:13px 22px; }
  .auth-switch{ text-align:center; font-size:13px; color:var(--text-mute); margin-top:22px; }
  .auth-switch a{ color:var(--emerald); font-weight:600; }
  .auth-switch a:hover{ opacity:.85; }

  @media (max-width: 480px){
    .auth-modal{ padding:26px 20px 22px; border-radius:18px; }
    .auth-head h2{ font-size:19px; }
  }

  /* MOBILE NAV */
  .nav-toggle{ display:none; width:38px; height:38px; border-radius:10px; background:var(--surface); border:1px solid var(--border); align-items:center; justify-content:center; flex-shrink:0; cursor:pointer; }
  .nav-toggle .icon{ width:18px; height:18px; color:var(--text); }
  .mobile-menu{ display:none; position:fixed; top:0; right:0; height:100vh; width:min(320px, 82vw); background:var(--mobile-bg); border-left:1px solid var(--border); z-index:100; padding:22px; transform:translateX(100%); transition: transform .3s cubic-bezier(.4,0,.2,1), background .35s ease; flex-direction:column; gap:6px; overflow-y:auto; }
  .mobile-menu.open{ transform:translateX(0); }
  .mobile-menu-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:22px; }
  .mobile-menu-close{ width:34px; height:34px; border-radius:9px; background:var(--surface); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; cursor:pointer; }
  .mobile-menu-close .icon{ width:16px; height:16px; }
  .mobile-menu a.mlink{ display:flex; align-items:center; gap:8px; padding:13px 6px; font-size:15.5px; color:var(--text-mute); border-bottom:1px solid var(--border); }
  .mobile-menu a.mlink:hover{ color:var(--text); }
  .mobile-menu .mobile-menu-cta{ display:flex; flex-direction:column; gap:12px; margin-top:20px; }
  .mobile-menu .mobile-menu-cta .btn{ width:100%; }
  .menu-backdrop{ display:none; position:fixed; inset:0; background:rgba(4,7,12,0.6); backdrop-filter:blur(2px); z-index:90; opacity:0; transition:opacity .3s ease; }
  .menu-backdrop.open{ display:block; opacity:1; }

  @media (max-width: 980px){
    .hero, .features{ grid-template-columns:1fr; }
    .security-grid{ grid-template-columns:repeat(2,1fr); }
    .pricing-grid{ grid-template-columns:1fr; max-width:380px; margin:0 auto; }
    .nav-links{ display:none; }
    .nav-toggle{ display:flex; }
    .visual-stage{ height:440px; }
    .laptop-wrap{ position:relative; top:0; right:0; margin:0 auto; }
    .stat-row{ gap:26px; }
    .footer-grid{ grid-template-columns:1fr 1fr; }
  }

  @media (max-width: 760px){
    .wrap{ padding:0 20px; }
    .nav-inner{ padding:16px 20px; }
    .hero{ padding:36px 0 20px; }
    .hero h1{ font-size:38px; }
    .hero p.sub{ font-size:15.5px; max-width:100%; }
    .hero-cta{ flex-wrap:wrap; }
    .visual-stage{ height:360px; overflow:hidden; position:relative; }
    .laptop-scale-wrap{ position:absolute; top:50%; left:50%; width:600px; transform:translate(-50%,-50%) scale(.56); }
    .laptop-wrap{ position:static !important; margin:0 !important; top:auto !important; right:auto !important; }
    .features{ padding:40px 0; gap:36px; }
    .features h2{ font-size:26px; }
    .dash-row2{ grid-template-columns:1fr; }
    .security-grid{ grid-template-columns:1fr; }
    .security-head h2, .pricing-head h2{ font-size:26px; }
    .testi-card{ flex:0 0 280px; }
    .cta-banner{ padding:32px 26px; border-radius:20px; }
    .cta-banner h2{ font-size:22px; }
    .cta-banner-left{ flex-wrap:wrap; }
    .footer-grid{ grid-template-columns:1fr; gap:26px; }
    .footer-bottom{ flex-direction:column; align-items:flex-start; }
  }

  @media (max-width: 480px){
    .logo{ font-size:16.5px; }
    .btn-ghost{ display:none; }
    .hero h1{ font-size:30px; }
    .eyebrow{ font-size:11.5px; padding:6px 12px; }
    .hero-cta{ flex-direction:column; }
    .hero-cta .btn{ width:100%; }
    .stat-row{ gap:18px 26px; }
    .stat-row .num{ font-size:21px; }
    .visual-stage{ height:290px; }
    .laptop-scale-wrap{ transform:translate(-50%,-50%) scale(.42); }
    .logo-strip{ padding:36px 0; }
    .logo-row{ justify-content:center; gap:22px 30px; }
    .testimonials-head h2, .faq-head h2{ font-size:24px; }
    .price-card{ padding:24px 20px; }
    .testi-card{ flex:0 0 250px; padding:20px; }
    .faq-q{ font-size:13.5px; padding:16px 18px; }
    .faq-a{ padding:0 18px 18px; }
    .cta-banner-left{ gap:14px; }
    .cta-banner-left .logo-mark{ width:44px; height:44px; font-size:19px; }
  }

  /* ===== SETTINGS WIDGET (theme / accent / language) ===== */
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
  .accent-row{ display:flex; gap:9px; }
  .accent-dot{ width:26px; height:26px; border-radius:50%; cursor:pointer; border:2px solid transparent; position:relative; transition: transform .2s ease, border-color .2s ease; }
  .accent-dot:hover{ transform: scale(1.1); }
  .accent-dot.active{ border-color: var(--text); }
  .accent-dot.active::after{ content:''; position:absolute; inset:0; border-radius:50%; box-shadow:0 0 0 2px var(--bg); }
  .lang-row{ display:flex; gap:8px; }
  .lang-opt{ flex:1; padding:9px 6px; text-align:center; border-radius:12px; border:1px solid var(--border); background:var(--surface); color:var(--text-mute); font-size:12.5px; font-weight:600; cursor:pointer; transition: all .2s ease; }
  .lang-opt:hover{ color:var(--text); border-color:var(--border-hover); }
  .lang-opt.active{ color:var(--emerald); border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }

  @media (max-width:480px){
    .settings-fab{ right:16px; bottom:16px; width:46px; height:46px; }
    .settings-panel{ right:16px; bottom:74px; width:calc(100vw - 32px); }
  }

.auth-page{ min-height:100vh; display:flex; align-items:center; justify-content:center; padding:40px 20px; position:relative; z-index:2; }
.auth-card{ width:min(420px, 100%); background:var(--modal-bg); border:1px solid var(--border); border-radius:22px; padding:34px 30px 28px; box-shadow:0 40px 100px rgba(0,0,0,0.45); }
.back-home{ display:inline-flex; align-items:center; gap:6px; font-size:13px; color:var(--text-mute); margin-bottom:22px; transition: color .2s ease; }
.back-home:hover{ color:var(--text); }
.auth-error{ background:rgba(232,90,90,0.08); border:1px solid rgba(232,90,90,0.35); color:#E85A5A; border-radius:12px; padding:12px 16px; margin-bottom:18px; font-size:13px; }
.auth-error ul{ padding-left:18px; list-style:disc; }
@media (max-width: 480px){ .auth-card{ padding:26px 20px 22px; border-radius:18px; } }
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


<!-- Reusable icon defs -->
<svg width="0" height="0" style="position:absolute">
<defs>
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

</defs>
</svg>

<div class="auth-page">
  <div class="auth-card">
    <a href="{{ url('/') }}" class="back-home">&larr; <span>Kembali ke beranda</span></a>

    <div class="auth-head">
      <div class="logo"><span class="logo-mark">A</span>Artha<span class="dot">jaya</span></div>
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
  // Starfield generator
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
      const input = icon.previousElementSibling;
      if(input && input.tagName === 'INPUT'){
        input.type = input.type === 'password' ? 'text' : 'password';
      }
    });
  });

  // ===== SETTINGS WIDGET: theme, accent color, language =====
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
