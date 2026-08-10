{{--
    Arvessa — Halaman Utama / Landing Page (welcome.blade.php)
    ==========================================================
    Desain konsisten dengan halaman pricing (dark theme, glassmorphism,
    starfield, Space Grotesk / Inter / IBM Plex Mono, aksen emerald).

    Section: Hero (laptop mockup dashboard) → Logo strip → Fitur →
    Dashboard preview → Testimoni → Keamanan → Pricing (Free/Platinum/Gold)
    → FAQ → CTA → Footer. Plus settings widget (tema/aksen/bahasa) &
    mobile menu. Fully responsive (3/2/1 kolom).

    Cara pakai (Laravel):
      1. Simpan sebagai resources/views/welcome.blade.php
      2. Route default Laravel sudah memuatnya di '/' (web.php):
            Route::get('/', fn () => view('welcome'))->name('welcome');
         Pastikan juga ada route pricing:
            Route::get('/pricing', fn () => view('pricing'))->name('pricing');
      3. Login  → {{ route('login') }}   (biasanya /login)
         Daftar → {{ route('register') }} (biasanya /register)
    --}}
<!DOCTYPE html>
<html lang="id" data-theme="dark" data-accent="emerald" data-language="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Arvessa — platform manajemen keuangan & bisnis untuk UMKM Indonesia. Kelola faktur, piutang, payroll, hingga forecasting dalam satu aplikasi. Mulai gratis hari ini.">
    <meta name="theme-color" content="#0a0f14">
    <title>Arvessa — Kelola Keuangan Bisnis UMKM dalam Satu Aplikasi</title>

    {{-- Google Fonts (format URL valid — jangan tambahkan tanda kurung kurawal) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ============================================================
           VARIABEL TEMA — dikontrol lewat atribut [data-theme] pada <html>
           Catatan perbaikan: selector yang benar adalah `[data-theme="light"]`
           (tanpa asterisk di depan — `*[data-theme="light"]*` adalah bug CSS).
           ============================================================ */
        :root,
        [data-theme="dark"] {
            --bg: #0a0f14;
            --bg-elevated: #0e151b;
            --bg-card: rgba(19, 26, 34, 0.72);
            --bg-card-solid: #131a22;
            --bg-soft: rgba(255, 255, 255, 0.03);
            --border: rgba(255, 255, 255, 0.08);
            --border-strong: rgba(255, 255, 255, 0.14);
            --text-primary: #f1f5f9;
            --text-secondary: #9ca3af;
            --text-muted: #64748b;
            --accent: #4ade80;          /* emerald default */
            --accent-soft: rgba(74, 222, 128, 0.14);
            --accent-glow: rgba(74, 222, 128, 0.35);
            --accent-grad-a: #2ecc71;
            --accent-grad-b: #1abc9c;
            --blue: #3b82f6;
            --blue-soft: rgba(59, 130, 246, 0.14);
            --blue-glow: rgba(59, 130, 246, 0.35);
            --blue-grad-a: #4facfe;
            --blue-grad-b: #00f2fe;
            --orange: #f59e0b;
            --orange-soft: rgba(245, 158, 11, 0.14);
            --orange-glow: rgba(245, 158, 11, 0.35);
            --orange-grad-a: #f6d365;
            --orange-grad-b: #fda085;
            --btn-grey-bg: #1e293b;
            --btn-grey-text: #cbd5e1;
            --shadow-card: 0 20px 60px rgba(0, 0, 0, 0.55);
            --shadow-glow: 0 0 40px var(--accent-glow);
            --radius-lg: 20px;
            --radius-md: 14px;
            --font-display: 'Space Grotesk', 'Inter', system-ui, sans-serif;
            --font-body: 'Inter', system-ui, sans-serif;
            --font-mono: 'IBM Plex Mono', ui-monospace, monospace;
        }

        /* Tema terang (opsional — konsisten dengan settings widget) */
        [data-theme="light"] {
            --bg: #f4f6f9;
            --bg-elevated: #ffffff;
            --bg-card: rgba(255, 255, 255, 0.78);
            --bg-card-solid: #ffffff;
            --bg-soft: rgba(15, 23, 42, 0.04);
            --border: rgba(15, 23, 42, 0.10);
            --border-strong: rgba(15, 23, 42, 0.18);
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --accent-soft: rgba(16, 185, 129, 0.12);
            --accent-glow: rgba(16, 185, 129, 0.30);
            --blue-soft: rgba(59, 130, 246, 0.12);
            --orange-soft: rgba(245, 158, 11, 0.12);
            --btn-grey-bg: #e2e8f0;
            --btn-grey-text: #334155;
            --shadow-card: 0 20px 60px rgba(15, 23, 42, 0.12);
            --shadow-glow: 0 0 40px var(--accent-glow);
        }

        /* Aksen tambahan (dipilih lewat settings widget) */
        [data-accent="teal"] {
            --accent: #2dd4bf;
            --accent-soft: rgba(45, 212, 191, 0.14);
            --accent-glow: rgba(45, 212, 191, 0.35);
            --accent-grad-a: #14b8a6;
            --accent-grad-b: #2dd4bf;
        }
        [data-accent="sky"] {
            --accent: #38bdf8;
            --accent-soft: rgba(56, 189, 248, 0.14);
            --accent-glow: rgba(56, 189, 248, 0.35);
            --accent-grad-a: #0ea5e9;
            --accent-grad-b: #38bdf8;
        }
        [data-accent="violet"] {
            --accent: #a78bfa;
            --accent-soft: rgba(167, 139, 250, 0.14);
            --accent-glow: rgba(167, 139, 250, 0.35);
            --accent-grad-a: #8b5cf6;
            --accent-grad-b: #a78bfa;
        }
        [data-accent="rose"] {
            --accent: #fb7185;
            --accent-soft: rgba(251, 113, 133, 0.14);
            --accent-glow: rgba(251, 113, 133, 0.35);
            --accent-grad-a: #f43f5e;
            --accent-grad-b: #fb7185;
        }

        /* ============================================================
           RESET & DASAR
           ============================================================ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            transition: background .4s ease, color .4s ease;
        }

        a { color: inherit; text-decoration: none; }
        ul { list-style: none; }
        img { max-width: 100%; display: block; }
        button { font-family: inherit; cursor: pointer; border: none; background: none; color: inherit; }
        input, select { font-family: inherit; }

        ::selection { background: var(--accent); color: #0a0f14; }

        .container {
            width: 100%;
            max-width: 1200px;
            margin-inline: auto;
            padding-inline: 24px;
        }

        .section { padding: 96px 0; position: relative; }

        /* ============================================================
           STARFIELD BACKGROUND — bintang + nebula, sama seperti
           welcome.blade.php
           ============================================================ */
        .starfield {
            position: fixed;
            inset: 0;
            z-index: -2;
            background: radial-gradient(ellipse 80% 60% at 50% -10%, rgba(74, 222, 128, 0.08), transparent 60%),
                        radial-gradient(ellipse 60% 50% at 85% 110%, rgba(59, 130, 246, 0.06), transparent 60%),
                        var(--bg);
            overflow: hidden;
        }
        .starfield::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(1px 1px at 20% 30%, rgba(255, 255, 255, 0.7), transparent 100%),
                radial-gradient(1px 1px at 40% 70%, rgba(255, 255, 255, 0.5), transparent 100%),
                radial-gradient(1.5px 1.5px at 60% 20%, rgba(255, 255, 255, 0.6), transparent 100%),
                radial-gradient(1px 1px at 80% 50%, rgba(255, 255, 255, 0.4), transparent 100%),
                radial-gradient(1.5px 1.5px at 15% 80%, rgba(255, 255, 255, 0.5), transparent 100%),
                radial-gradient(1px 1px at 70% 85%, rgba(255, 255, 255, 0.6), transparent 100%),
                radial-gradient(1px 1px at 90% 15%, rgba(255, 255, 255, 0.4), transparent 100%),
                radial-gradient(1.2px 1.2px at 30% 10%, rgba(74, 222, 128, 0.6), transparent 100%),
                radial-gradient(1px 1px at 55% 55%, rgba(59, 130, 246, 0.5), transparent 100%),
                radial-gradient(1px 1px at 85% 75%, rgba(245, 158, 11, 0.5), transparent 100%);
            animation: twinkle 8s ease-in-out infinite alternate;
        }
        .starfield::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle 420px at 50% 38%, rgba(74, 222, 128, 0.05), transparent 70%);
            animation: nebula 14s ease-in-out infinite alternate;
        }
        @keyframes twinkle {
            0%   { opacity: .55; }
            100% { opacity: 1; }
        }
        @keyframes nebula {
            0%   { transform: translateX(-3%) scale(1); }
            100% { transform: translateX(3%) scale(1.08); }
        }

        /* ============================================================
           SVG SPRITE (symbols) — ikon yang sama seperti welcome.blade.php
           ============================================================ */
        .icon { width: 20px; height: 20px; flex-shrink: 0; }

        /* ============================================================
           NAVBAR
           ============================================================ */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            background: rgba(10, 15, 20, 0.7);
            border-bottom: 1px solid var(--border);
            transition: background .3s ease, box-shadow .3s ease;
        }
        [data-theme="light"] .navbar { background: rgba(255, 255, 255, 0.75); }
        .navbar.scrolled {
            background: rgba(10, 15, 20, 0.9);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        [data-theme="light"] .navbar.scrolled { background: rgba(255, 255, 255, 0.92); }
        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
            gap: 16px;
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }
        .nav-logo-mark {
            width: 34px; height: 34px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent-grad-a), var(--accent-grad-b));
            color: #06120b;
            box-shadow: 0 0 18px var(--accent-glow);
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .nav-links a {
            padding: 8px 14px;
            border-radius: 10px;
            color: var(--text-secondary);
            transition: color .2s ease, background .2s ease;
        }
        .nav-links a:hover { color: var(--text-primary); background: var(--bg-soft); }
        .nav-links a.active { color: var(--accent); }
        .nav-actions { display: flex; align-items: center; gap: 10px; }

        .btn-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.92rem;
            font-family: var(--font-display);
            letter-spacing: 0.01em;
            border: 1px solid transparent;
            transition: transform .2s ease, box-shadow .25s ease, filter .2s ease, background .25s ease, color .25s ease;
            white-space: nowrap;
        }
        .btn-custom:hover { transform: translateY(-2px); }
        .btn-custom:active { transform: translateY(0) scale(0.98); }

        /* Tombol netral (mis. "Masuk") */
        .btn-grey {
            background: var(--btn-grey-bg);
            color: var(--btn-grey-text);
            border-color: var(--border);
        }
        .btn-grey:hover { filter: brightness(1.15); box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3); }

        /* Tombol aksen emerald (mis. "Mulai Gratis") */
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-grad-a), var(--accent-grad-b));
            color: #06120b;
            box-shadow: 0 4px 20px var(--accent-glow);
        }
        .btn-primary:hover { box-shadow: 0 8px 32px var(--accent-glow); filter: brightness(1.06); }

        /* Tombol biru (Platinum) */
        .btn-blue {
            background: linear-gradient(135deg, var(--blue-grad-a), var(--blue-grad-b));
            color: #061223;
            box-shadow: 0 4px 20px var(--blue-glow);
        }
        .btn-blue:hover { box-shadow: 0 8px 32px var(--blue-glow); filter: brightness(1.06); }

        /* Tombol oranye (Gold) */
        .btn-orange {
            background: linear-gradient(135deg, var(--orange-grad-a), var(--orange-grad-b));
            color: #261204;
            box-shadow: 0 4px 20px var(--orange-glow);
        }
        .btn-orange:hover { box-shadow: 0 8px 32px var(--orange-glow); filter: brightness(1.06); }

        /* Tombol "Paket Aktif" — state disabled */
        .btn-custom[disabled], .btn-custom.disabled {
            opacity: 1;
            cursor: default;
            transform: none !important;
            background: var(--btn-grey-bg);
            color: var(--btn-grey-text);
            border-color: var(--border);
            box-shadow: none;
            filter: none;
        }

        .btn-hamburger {
            display: none;
            width: 42px; height: 42px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: var(--bg-soft);
            align-items: center;
            justify-content: center;
        }
        .btn-hamburger .icon { width: 22px; height: 22px; }

        /* Mobile menu */
        .mobile-menu {
            position: fixed;
            top: 72px; left: 0; right: 0;
            z-index: 99;
            background: rgba(10, 15, 20, 0.97);
            border-bottom: 1px solid var(--border);
            padding: 16px 24px 24px;
            display: none;
            flex-direction: column;
            gap: 4px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        [data-theme="light"] .mobile-menu { background: rgba(255, 255, 255, 0.98); }
        .mobile-menu.open { display: flex; }
        .mobile-menu a {
            padding: 12px 14px;
            border-radius: 12px;
            color: var(--text-secondary);
            font-weight: 500;
        }
        .mobile-menu a:hover, .mobile-menu a.active { color: var(--accent); background: var(--bg-soft); }
        .mobile-menu .mobile-actions { display: flex; gap: 10px; margin-top: 12px; }
        .mobile-menu .mobile-actions .btn-custom { flex: 1; }

        /* ============================================================
           HERO — Halaman utama (welcome): headline + laptop mockup
           ============================================================ */
        .hero-welcome {
            padding: 168px 0 72px;
            position: relative;
            text-align: center;
            overflow: hidden;
        }
        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--bg-soft);
            color: var(--accent);
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-family: var(--font-mono);
            margin-bottom: 24px;
        }
        .hero-eyebrow .icon { width: 14px; height: 14px; }
        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(2.4rem, 6vw, 4.2rem);
            font-weight: 700;
            letter-spacing: -0.03em;
            line-height: 1.12;
            margin-bottom: 20px;
        }
        .hero-title .grad {
            background: linear-gradient(120deg, var(--accent-grad-a), var(--accent-grad-b));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .hero-sub {
            max-width: 640px;
            margin-inline: auto;
            color: var(--text-secondary);
            font-size: 1.08rem;
            margin-bottom: 36px;
        }
        .hero-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        .hero-actions .btn-custom { padding: 14px 30px; font-size: 1rem; }
        .hero-trust {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 22px;
            flex-wrap: wrap;
            margin-top: 30px;
            color: var(--text-muted);
            font-size: 0.84rem;
        }
        .hero-trust .trust-item {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }
        .hero-trust .trust-item .icon { width: 16px; height: 16px; color: var(--accent); }
        .hero-trust .trust-avatars {
            display: inline-flex;
            align-items: center;
        }
        .hero-trust .trust-avatars .ava {
            width: 28px; height: 28px;
            border-radius: 50%;
            border: 2px solid var(--bg);
            margin-left: -8px;
            display: grid;
            place-items: center;
            font-size: 0.66rem;
            font-weight: 700;
            color: #06120b;
        }
        .hero-trust .trust-avatars .ava:first-child { margin-left: 0; }
        .ava-1 { background: linear-gradient(135deg, #4ade80, #2ecc71); }
        .ava-2 { background: linear-gradient(135deg, #4facfe, #00f2fe); }
        .ava-3 { background: linear-gradient(135deg, #f6d365, #fda085); }
        .ava-4 { background: linear-gradient(135deg, #a78bfa, #8b5cf6); }

        /* Laptop mockup dashboard */
        .hero-laptop {
            margin: 72px auto 0;
            max-width: 940px;
            position: relative;
            perspective: 1600px;
        }
        .laptop-glow {
            position: absolute;
            inset: -40px -60px;
            background: radial-gradient(ellipse 60% 60% at 50% 40%, var(--accent-glow), transparent 70%);
            filter: blur(30px);
            pointer-events: none;
            z-index: 0;
        }
        .laptop {
            position: relative;
            z-index: 1;
            background: var(--bg-card-solid);
            border: 1px solid var(--border-strong);
            border-radius: 18px;
            box-shadow: var(--shadow-card), 0 0 0 1px rgba(255, 255, 255, 0.03) inset;
            transform: rotateX(6deg) translateY(6px);
            transform-style: preserve-3d;
            overflow: hidden;
            transition: transform .4s ease;
        }
        .laptop:hover { transform: rotateX(0deg) translateY(0); }
        .laptop-topbar {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
        }
        .laptop-topbar .dot {
            width: 10px; height: 10px;
            border-radius: 50%;
        }
        .laptop-topbar .dot-r { background: #f87171; }
        .laptop-topbar .dot-y { background: #fbbf24; }
        .laptop-topbar .dot-g { background: #34d399; }
        .laptop-topbar .laptop-url {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 7px;
            margin-left: 10px;
            padding: 6px 14px;
            border-radius: 999px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            color: var(--text-muted);
            font-family: var(--font-mono);
            font-size: 0.72rem;
            text-align: left;
            overflow: hidden;
            white-space: nowrap;
        }
        .laptop-url .icon { width: 13px; height: 13px; color: var(--accent); flex-shrink: 0; }
        .laptop-screen {
            display: grid;
            grid-template-columns: 230px 1fr;
            background:
                radial-gradient(circle 300px at 15% 0%, var(--accent-soft), transparent 60%),
                var(--bg-elevated);
        }
        .dash-sidebar {
            border-right: 1px solid var(--border);
            padding: 20px 14px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .dash-sidebar .side-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0 8px 14px;
            color: var(--text-primary);
        }
        .side-logo .mini-mark {
            width: 24px; height: 24px;
            border-radius: 7px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--accent-grad-a), var(--accent-grad-b));
            color: #06120b;
        }
        .side-logo .mini-mark .icon { width: 13px; height: 13px; }
        .side-link {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 9px;
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        .side-link .icon { width: 15px; height: 15px; }
        .side-link.active {
            color: var(--accent);
            background: var(--accent-soft);
        }
        .dash-main {
            padding: 22px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .dash-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .dash-head h4 {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }
        .dash-head .btn-mini {
            padding: 6px 14px;
            border-radius: 9px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #06120b;
            background: linear-gradient(135deg, var(--accent-grad-a), var(--accent-grad-b));
        }
        .dash-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 14px 15px;
        }
        .stat-card .stat-label {
            font-size: 0.68rem;
            color: var(--text-muted);
            margin-bottom: 5px;
        }
        .stat-card .stat-value {
            font-family: var(--font-display);
            font-size: 1.18rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .stat-card .stat-value .up { color: var(--accent); }
        .stat-card .stat-delta {
            font-size: 0.66rem;
            color: var(--accent);
            font-family: var(--font-mono);
            margin-top: 3px;
        }
        .dash-body {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 12px;
        }
        .dash-panel {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 16px;
        }
        .dash-panel .panel-title {
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .panel-title .mini-chip {
            font-family: var(--font-mono);
            font-size: 0.6rem;
            color: var(--accent);
            background: var(--accent-soft);
            padding: 3px 8px;
            border-radius: 999px;
        }
        .chart-bars {
            display: flex;
            align-items: flex-end;
            gap: 9px;
            height: 96px;
        }
        .chart-bars .bar {
            flex: 1;
            border-radius: 5px 5px 2px 2px;
            background: var(--accent-soft);
            border: 1px solid var(--accent);
            opacity: 0.55;
            animation: barRise .8s ease forwards;
            transform-origin: bottom;
        }
        .chart-bars .bar.hi { opacity: 1; background: linear-gradient(180deg, var(--accent-grad-a), var(--accent-grad-b)); }
        .chart-bars .bar.b1 { height: 38%; animation-delay: .05s; }
        .chart-bars .bar.b2 { height: 56%; animation-delay: .12s; }
        .chart-bars .bar.b3 { height: 44%; animation-delay: .19s; }
        .chart-bars .bar.b4 { height: 70%; animation-delay: .26s; }
        .chart-bars .bar.b5 { height: 62%; animation-delay: .33s; }
        .chart-bars .bar.b6 { height: 88%; animation-delay: .40s; }
        .chart-bars .bar.b7 { height: 76%; animation-delay: .47s; }
        @keyframes barRise {
            from { transform: scaleY(0.05); }
            to   { transform: scaleY(1); }
        }
        .invoice-list {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }
        .invoice-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 10px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            font-size: 0.74rem;
        }
        .invoice-row .inv-ic {
            width: 26px; height: 26px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }
        .invoice-row .inv-ic .icon { width: 14px; height: 14px; }
        .inv-ic.green { background: var(--accent-soft); color: var(--accent); }
        .inv-ic.blue { background: var(--blue-soft); color: var(--blue-grad-a); }
        .inv-ic.orange { background: var(--orange-soft); color: var(--orange-grad-a); }
        .invoice-row .inv-info { flex: 1; min-width: 0; }
        .invoice-row .inv-info .inv-name {
            color: var(--text-primary);
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .invoice-row .inv-info .inv-sub { color: var(--text-muted); font-size: 0.66rem; }
        .invoice-row .inv-amount {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            color: var(--text-primary);
            white-space: nowrap;
        }
        .laptop-base {
            height: 12px;
            margin: 0 auto;
            width: 96%;
            border-radius: 0 0 16px 16px;
            background: linear-gradient(180deg, var(--bg-card-solid), var(--bg-elevated));
            border: 1px solid var(--border);
            border-top: none;
        }

        /* ============================================================
           LOGO STRIP
           ============================================================ */
        .logo-strip {
            padding: 0 0 64px;
            text-align: center;
        }
        .logo-strip .strip-label {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 26px;
        }
        .logo-strip .logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 44px;
            flex-wrap: wrap;
        }
        .logo-strip .logo-chip {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.02rem;
            color: var(--text-muted);
            opacity: 0.75;
            transition: opacity .25s ease, color .25s ease;
        }
        .logo-strip .logo-chip:hover { opacity: 1; color: var(--text-primary); }
        .logo-chip .chip-mark {
            width: 26px; height: 26px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            color: var(--accent);
        }
        .logo-chip .chip-mark .icon { width: 14px; height: 14px; }

        /* ============================================================
           FEATURES — icon grid
           ============================================================ */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .feature-card {
            padding: 26px 24px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            border-color: var(--border-strong);
            box-shadow: 0 18px 44px rgba(0, 0, 0, 0.35);
        }
        .feature-card .feat-icon {
            width: 46px; height: 46px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            margin-bottom: 18px;
            background: var(--accent-soft);
            border: 1px solid var(--border);
            color: var(--accent);
        }
        .feature-card .feat-icon .icon { width: 22px; height: 22px; }
        .feature-card h3 {
            font-family: var(--font-display);
            font-size: 1.06rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            margin-bottom: 8px;
        }
        .feature-card p {
            color: var(--text-secondary);
            font-size: 0.88rem;
        }
        .features-more {
            text-align: center;
            margin-top: 36px;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        .features-more a { color: var(--accent); font-weight: 600; }

        /* ============================================================
           DASHBOARD PREVIEW (section 2)
           ============================================================ */
        .preview-wrap {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 56px;
            align-items: center;
        }
        .preview-copy .section-kicker {
            font-family: var(--font-mono);
            font-size: 0.78rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 12px;
        }
        .preview-copy h2 {
            font-family: var(--font-display);
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.18;
            margin-bottom: 16px;
        }
        .preview-copy > p {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 28px;
            max-width: 460px;
        }
        .preview-list { display: flex; flex-direction: column; gap: 14px; }
        .preview-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 0.92rem;
            color: var(--text-secondary);
        }
        .preview-list li .icon { width: 20px; height: 20px; color: var(--accent); margin-top: 2px; }
        .preview-list li strong { color: var(--text-primary); }
        .preview-visual {
            position: relative;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            background: var(--bg-card);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            padding: 26px;
            box-shadow: var(--shadow-card);
        }
        .preview-visual::before {
            content: "";
            position: absolute;
            inset: -30px;
            background: radial-gradient(ellipse 55% 55% at 70% 30%, var(--blue-glow), transparent 70%);
            filter: blur(26px);
            z-index: -1;
            pointer-events: none;
        }
        .pv-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .pv-head h4 {
            font-family: var(--font-display);
            font-size: 0.95rem;
            font-weight: 700;
        }
        .pv-head .pv-chip {
            font-family: var(--font-mono);
            font-size: 0.62rem;
            color: var(--blue-grad-a);
            background: var(--blue-soft);
            border: 1px solid rgba(59, 130, 246, 0.35);
            padding: 4px 10px;
            border-radius: 999px;
        }
        .pv-bars {
            display: flex;
            align-items: flex-end;
            gap: 14px;
            height: 150px;
            margin-bottom: 20px;
        }
        .pv-bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; }
        .pv-bar {
            width: 100%;
            border-radius: 6px 6px 2px 2px;
            background: linear-gradient(180deg, var(--blue-grad-a), var(--blue-grad-b));
            opacity: 0.85;
        }
        .pv-bar.alt { background: linear-gradient(180deg, var(--accent-grad-a), var(--accent-grad-b)); }
        .pv-bar-col span {
            font-family: var(--font-mono);
            font-size: 0.6rem;
            color: var(--text-muted);
        }
        .pv-bar-col .pv-h1 { height: 42%; }
        .pv-bar-col .pv-h2 { height: 68%; }
        .pv-bar-col .pv-h3 { height: 55%; }
        .pv-bar-col .pv-h4 { height: 84%; }
        .pv-bar-col .pv-h5 { height: 74%; }
        .pv-bar-col .pv-h6 { height: 96%; }
        .pv-mini-rows { display: flex; flex-direction: column; gap: 8px; }
        .pv-mini-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            font-size: 0.76rem;
        }
        .pv-mini-row .mini-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .pv-mini-row .mini-dot.d-emerald { background: var(--accent); box-shadow: 0 0 8px var(--accent-glow); }
        .pv-mini-row .mini-dot.d-blue { background: var(--blue-grad-a); box-shadow: 0 0 8px var(--blue-glow); }
        .pv-mini-row .mini-dot.d-orange { background: var(--orange-grad-a); box-shadow: 0 0 8px var(--orange-glow); }
        .pv-mini-row .pv-mini-label { flex: 1; color: var(--text-muted); }
        .pv-mini-row .pv-mini-val {
            font-family: var(--font-mono);
            color: var(--text-primary);
        }
        .pv-float {
            position: absolute;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 11px 15px;
            border-radius: 13px;
            background: var(--bg-card-solid);
            border: 1px solid var(--border-strong);
            box-shadow: 0 16px 44px rgba(0, 0, 0, 0.45);
            font-size: 0.76rem;
            z-index: 2;
        }
        .pv-float .icon { width: 17px; height: 17px; color: var(--accent); }
        .pv-float .f-num { font-family: var(--font-display); font-weight: 700; color: var(--text-primary); }
        .pv-float.f1 { top: -18px; right: -14px; animation: floaty 5s ease-in-out infinite; }
        .pv-float.f2 { bottom: -16px; left: -14px; animation: floaty 5s ease-in-out 1.2s infinite; }
        @keyframes floaty {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-9px); }
        }

        /* ============================================================
           TESTIMONIALS
           ============================================================ */
        .testi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .testi-card {
            padding: 26px 24px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            gap: 16px;
            transition: transform .3s ease, border-color .3s ease;
        }
        .testi-card:hover { transform: translateY(-5px); border-color: var(--border-strong); }
        .testi-card .testi-stars {
            display: flex;
            gap: 3px;
            color: #fbbf24;
        }
        .testi-card .testi-stars .icon { width: 16px; height: 16px; }
        .testi-card .testi-text {
            font-size: 0.92rem;
            color: var(--text-secondary);
            flex: 1;
        }
        .testi-card .testi-text strong { color: var(--text-primary); font-weight: 600; }
        .testi-person {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .testi-person .ava {
            width: 42px; height: 42px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.95rem;
            color: #06120b;
            flex-shrink: 0;
        }
        .testi-person .testi-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        .testi-person .testi-role {
            font-size: 0.76rem;
            color: var(--text-muted);
        }

        /* ============================================================
           SECURITY
           ============================================================ */
        .security-wrap {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 56px;
            align-items: center;
        }
        .security-copy .section-kicker {
            font-family: var(--font-mono);
            font-size: 0.78rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 12px;
        }
        .security-copy h2 {
            font-family: var(--font-display);
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.18;
            margin-bottom: 16px;
        }
        .security-copy > p {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 28px;
            max-width: 460px;
        }
        .security-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        .security-item {
            padding: 20px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: border-color .3s ease, transform .3s ease;
        }
        .security-item:hover { border-color: var(--border-strong); transform: translateY(-3px); }
        .security-item .sec-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            margin-bottom: 14px;
            background: var(--accent-soft);
            border: 1px solid var(--border);
            color: var(--accent);
        }
        .security-item .sec-icon .icon { width: 20px; height: 20px; }
        .security-item h4 {
            font-family: var(--font-display);
            font-size: 0.96rem;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .security-item p {
            color: var(--text-muted);
            font-size: 0.82rem;
        }

        /* ============================================================
           HERO — ringkas, khusus pricing
           ============================================================ */
        .hero-pricing {
            padding: 160px 0 64px;
            text-align: center;
            position: relative;
        }
        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--bg-soft);
            color: var(--accent);
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-family: var(--font-mono);
            margin-bottom: 24px;
        }
        .hero-eyebrow .icon { width: 14px; height: 14px; }
        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(2.4rem, 6vw, 4rem);
            font-weight: 700;
            letter-spacing: -0.03em;
            line-height: 1.12;
            margin-bottom: 20px;
        }
        .hero-title .grad {
            background: linear-gradient(120deg, var(--accent-grad-a), var(--accent-grad-b));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .hero-sub {
            max-width: 620px;
            margin-inline: auto;
            color: var(--text-secondary);
            font-size: 1.08rem;
            margin-bottom: 36px;
        }

        /* Toggle bulanan / tahunan */
        .billing-toggle {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--bg-soft);
            position: relative;
        }
        .billing-toggle button {
            padding: 9px 20px;
            border-radius: 999px;
            font-size: 0.86rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: color .2s ease, background .2s ease;
        }
        .billing-toggle button.active {
            color: var(--text-primary);
            background: var(--bg-card-solid);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        .billing-toggle .save-tag {
            font-family: var(--font-mono);
            font-size: 0.68rem;
            color: var(--accent);
            background: var(--accent-soft);
            padding: 3px 9px;
            border-radius: 999px;
            font-weight: 600;
        }

        /* ============================================================
           PRICING GRID & KARTU — struktur kelas persis seperti
           welcome.blade.php (badge-top-right, price-icon-wrap, dsb.)
           ============================================================ */
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            align-items: stretch;
        }

        .pricing-card {
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 32px 28px 28px;
            border-radius: var(--radius-lg);
            background: var(--bg-card);
            border: 1px solid var(--border);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: var(--shadow-card);
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }
        .pricing-card:hover {
            transform: translateY(-6px);
            border-color: var(--border-strong);
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.6);
        }

        /* Kartu Platinum — paling populer, border glow biru */
        .pricing-card.featured {
            border-color: rgba(59, 130, 246, 0.45);
            box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.15), 0 0 48px var(--blue-glow), var(--shadow-card);
        }
        .pricing-card.featured:hover {
            box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.25), 0 0 64px var(--blue-glow), 0 30px 70px rgba(0, 0, 0, 0.6);
        }
        .pricing-card.featured::before {
            content: "";
            position: absolute;
            top: -1px; left: 16px; right: 16px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--blue), transparent);
            opacity: 0.8;
        }

        /* Badge pojok kanan atas — persis welcome.blade.php */
        .badge-top-right {
            position: absolute;
            top: 16px;
            right: 16px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-family: var(--font-mono);
            background: var(--bg-card-solid);
            border: 1px solid var(--border-strong);
            color: var(--text-secondary);
        }
        .badge-top-right .icon { width: 13px; height: 13px; }
        .badge-top-right.badge-blue {
            background: var(--blue-soft);
            border-color: rgba(59, 130, 246, 0.5);
            color: var(--blue-grad-a);
            box-shadow: 0 0 18px var(--blue-glow);
        }
        .badge-top-right.badge-orange {
            background: var(--orange-soft);
            border-color: rgba(245, 158, 11, 0.5);
            color: var(--orange-grad-a);
        }

        /* Ikon paket */
        .price-icon-wrap {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            margin-bottom: 22px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            position: relative;
        }
        .price-icon-wrap .icon { width: 26px; height: 26px; }
        .pricing-card.free-card .price-icon-wrap { color: var(--accent); }
        .pricing-card.free-card .price-icon-wrap::after {
            content: "";
            position: absolute;
            inset: -6px;
            border-radius: 20px;
            background: radial-gradient(circle, var(--accent-glow), transparent 70%);
            z-index: -1;
        }
        .pricing-card.platinum-card .price-icon-wrap { color: var(--blue); }
        .pricing-card.platinum-card .price-icon-wrap::after {
            content: "";
            position: absolute;
            inset: -6px;
            border-radius: 20px;
            background: radial-gradient(circle, var(--blue-glow), transparent 70%);
            z-index: -1;
        }
        .pricing-card.gold-card .price-icon-wrap { color: var(--orange); }
        .pricing-card.gold-card .price-icon-wrap::after {
            content: "";
            position: absolute;
            inset: -6px;
            border-radius: 20px;
            background: radial-gradient(circle, var(--orange-glow), transparent 70%);
            z-index: -1;
        }

        .price-name {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }
        .price-desc {
            color: var(--text-secondary);
            font-size: 0.92rem;
            margin-bottom: 24px;
            min-height: 2.6em;
        }

        .price-amount {
            font-family: var(--font-display);
            font-size: 2.6rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            line-height: 1.1;
            display: flex;
            align-items: baseline;
            gap: 6px;
        }
        .price-amount .currency {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-secondary);
        }
        .price-period {
            font-size: 0.86rem;
            color: var(--text-muted);
            margin-top: 6px;
            margin-bottom: 20px;
        }
        .price-period .cancel-anytime {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--accent);
            font-size: 0.8rem;
            margin-top: 2px;
        }
        .price-period .cancel-anytime .icon { width: 14px; height: 14px; }

        .price-features {
            display: flex;
            flex-direction: column;
            gap: 13px;
            margin: 8px 0 28px;
            flex: 1;
        }
        .price-features li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }
        .price-features li .icon {
            width: 18px; height: 18px;
            margin-top: 2px;
        }
        .free-card .price-features li .icon { color: var(--accent); }
        .platinum-card .price-features li .icon { color: var(--blue-grad-a); }
        .gold-card .price-features li .icon { color: var(--orange-grad-a); }

        .price-features li strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .pricing-card .btn-custom { width: 100%; margin-top: auto; }

        /* Catatan kecil di bawah grid */
        .pricing-note {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: 28px;
        }
        .pricing-note a { color: var(--accent); }

        /* ============================================================
           COMPARE STRIP — sekilas perbandingan (opsional, ringan)
           ============================================================ */
        .compare-strip {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
            margin-top: 56px;
        }
        .compare-item {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 10px 18px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--bg-soft);
            font-size: 0.84rem;
            color: var(--text-secondary);
        }
        .compare-item .icon { width: 16px; height: 16px; color: var(--accent); }

        /* ============================================================
           FAQ
           ============================================================ */
        .faq-section { max-width: 780px; margin-inline: auto; }
        .section-head {
            text-align: center;
            margin-bottom: 56px;
        }
        .section-head .section-kicker {
            font-family: var(--font-mono);
            font-size: 0.78rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 12px;
        }
        .section-head h2 {
            font-family: var(--font-display);
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 12px;
        }
        .section-head p { color: var(--text-secondary); max-width: 520px; margin-inline: auto; }

        .faq-item {
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            margin-bottom: 12px;
            overflow: hidden;
            transition: border-color .25s ease;
        }
        .faq-item.open { border-color: var(--border-strong); }
        .faq-question {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 22px;
            font-size: 0.98rem;
            font-weight: 600;
            text-align: left;
            color: var(--text-primary);
        }
        .faq-question .faq-icon {
            width: 24px; height: 24px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            color: var(--accent);
            transition: transform .3s ease;
        }
        .faq-item.open .faq-icon { transform: rotate(45deg); }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s ease;
        }
        .faq-answer-inner {
            padding: 0 22px 20px;
            color: var(--text-secondary);
            font-size: 0.92rem;
        }

        /* ============================================================
           CTA BANNER
           ============================================================ */
        .cta-banner {
            position: relative;
            border-radius: var(--radius-lg);
            padding: 64px 48px;
            text-align: center;
            border: 1px solid var(--border);
            background:
                radial-gradient(circle 400px at 20% 0%, var(--accent-soft), transparent 60%),
                radial-gradient(circle 400px at 85% 100%, var(--blue-soft), transparent 60%),
                var(--bg-card);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            overflow: hidden;
        }
        .cta-banner h2 {
            font-family: var(--font-display);
            font-size: clamp(1.7rem, 4vw, 2.5rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 14px;
        }
        .cta-banner p {
            color: var(--text-secondary);
            max-width: 520px;
            margin-inline: auto;
            margin-bottom: 30px;
        }
        .cta-banner .btn-primary { padding: 14px 34px; font-size: 1rem; }

        /* ============================================================
           FOOTER
           ============================================================ */
        .footer {
            border-top: 1px solid var(--border);
            padding: 56px 0 40px;
            margin-top: 96px;
            background: var(--bg-elevated);
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 48px;
        }
        .footer-brand p {
            color: var(--text-muted);
            font-size: 0.88rem;
            margin-top: 14px;
            max-width: 280px;
        }
        .footer-col h4 {
            font-family: var(--font-display);
            font-size: 0.85rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-secondary);
            margin-bottom: 16px;
        }
        .footer-col a {
            display: block;
            padding: 6px 0;
            color: var(--text-muted);
            font-size: 0.9rem;
            transition: color .2s ease;
        }
        .footer-col a:hover { color: var(--accent); }
        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            padding-top: 28px;
            border-top: 1px solid var(--border);
            color: var(--text-muted);
            font-size: 0.84rem;
        }
        .footer-bottom .socials { display: flex; gap: 10px; }
        .footer-bottom .socials a {
            width: 36px; height: 36px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            border: 1px solid var(--border);
            color: var(--text-muted);
            transition: color .2s ease, border-color .2s ease;
        }
        .footer-bottom .socials a:hover { color: var(--accent); border-color: var(--accent); }

        /* ============================================================
           SETTINGS WIDGET — tema / aksen / bahasa
           ============================================================ */
        .settings-fab {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 90;
            width: 52px; height: 52px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: var(--bg-card-solid);
            border: 1px solid var(--border-strong);
            color: var(--text-secondary);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            transition: transform .25s ease, color .2s ease, border-color .2s ease;
        }
        .settings-fab:hover { transform: rotate(45deg); color: var(--accent); border-color: var(--accent); }
        .settings-fab .icon { width: 22px; height: 22px; }
        .settings-fab.rotated { transform: rotate(90deg); }

        .settings-panel {
            position: fixed;
            right: 22px;
            bottom: 88px;
            z-index: 91;
            width: 300px;
            padding: 24px;
            border-radius: var(--radius-lg);
            background: var(--bg-card-solid);
            border: 1px solid var(--border-strong);
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.6);
            opacity: 0;
            visibility: hidden;
            transform: translateY(12px) scale(0.98);
            transition: opacity .25s ease, transform .25s ease, visibility .25s;
        }
        .settings-panel.open { opacity: 1; visibility: visible; transform: translateY(0) scale(1); }
        .settings-panel h3 {
            font-family: var(--font-display);
            font-size: 1rem;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .settings-panel h3 .icon { width: 17px; height: 17px; color: var(--accent); }
        .settings-group { margin-bottom: 18px; }
        .settings-group:last-child { margin-bottom: 0; }
        .settings-label {
            font-size: 0.74rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 10px;
        }
        .theme-options, .accent-options, .lang-options {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .theme-options button, .accent-options button, .lang-options button {
            padding: 7px 13px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--bg-soft);
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            transition: all .2s ease;
        }
        .theme-options button.active, .accent-options button.active, .lang-options button.active {
            color: var(--text-primary);
            border-color: var(--accent);
            background: var(--accent-soft);
            box-shadow: 0 0 14px var(--accent-glow);
        }
        .accent-options button { position: relative; padding-left: 30px; }
        .accent-options button::before {
            content: "";
            position: absolute;
            left: 11px; top: 50%;
            transform: translateY(-50%);
            width: 12px; height: 12px;
            border-radius: 50%;
        }
        .accent-options button[data-accent-value="emerald"]::before { background: #4ade80; box-shadow: 0 0 8px #4ade80; }
        .accent-options button[data-accent-value="teal"]::before { background: #2dd4bf; box-shadow: 0 0 8px #2dd4bf; }
        .accent-options button[data-accent-value="sky"]::before { background: #38bdf8; box-shadow: 0 0 8px #38bdf8; }
        .accent-options button[data-accent-value="violet"]::before { background: #a78bfa; box-shadow: 0 0 8px #a78bfa; }
        .accent-options button[data-accent-value="rose"]::before { background: #fb7185; box-shadow: 0 0 8px #fb7185; }

        /* ============================================================
           RESPONSIVE — 3 kolom desktop, 2 tablet, 1 mobile
           ============================================================ */
        @media (max-width: 1024px) {
            .pricing-grid { grid-template-columns: repeat(2, 1fr); }
            .pricing-card.featured { order: -1; grid-column: 1 / -1; }
            .features-grid, .testi-grid { grid-template-columns: repeat(2, 1fr); }
            .laptop-screen { grid-template-columns: 190px 1fr; }
            .preview-wrap, .security-wrap { gap: 40px; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 767px) {
            .section { padding: 72px 0; }
            .hero-welcome { padding: 136px 0 48px; }
            .hero-pricing { padding: 140px 0 48px; }
            .nav-links { display: none; }
            .nav-actions .btn-custom { display: none; }
            .btn-hamburger { display: inline-flex; }
            .pricing-grid { grid-template-columns: 1fr; }
            .pricing-card.featured { grid-column: auto; order: 0; }
            .features-grid, .testi-grid { grid-template-columns: 1fr; }
            .laptop-screen { grid-template-columns: 1fr; }
            .dash-sidebar { display: none; }
            .dash-stats { grid-template-columns: repeat(3, 1fr); gap: 8px; }
            .dash-body { grid-template-columns: 1fr; }
            .preview-wrap, .security-wrap { grid-template-columns: 1fr; gap: 36px; }
            .preview-visual { order: -1; }
            .security-item { padding: 16px; }
            .pv-float.f1 { right: 0; top: -14px; }
            .pv-float.f2 { left: 0; bottom: -14px; }
            .cta-banner { padding: 48px 24px; }
            .footer-grid { grid-template-columns: 1fr; gap: 32px; }
            .logo-strip .logos { gap: 24px; }
        }

        @media (max-width: 480px) {
            .container { padding-inline: 18px; }
            .price-amount { font-size: 2.2rem; }
            .dash-stats { grid-template-columns: 1fr; }
            .settings-panel { width: calc(100vw - 44px); }
        }

        /* Motion-safe: hormati prefers-reduced-motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>
<body>

    {{-- ============================================================
         SVG SPRITE — definisikan semua symbol yang dipakai
         (ic-check, ic-star, ic-badge, ic-shield, dll. — sama seperti
         welcome.blade.php)
         ============================================================ --}}
    <svg xmlns="http://www.w3.org/2000/svg" style="display:none" aria-hidden="true">
        <symbol id="ic-check" viewBox="0 0 24 24">
            <path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-star" viewBox="0 0 24 24">
            <path d="M12 2l2.9 6.26 6.6.72-4.95 4.56 1.34 6.53L12 16.9 6.11 20.07l1.34-6.53L2.5 8.98l6.6-.72L12 2z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-badge" viewBox="0 0 24 24">
            <path d="M12 2l2.4 2.4 3.3-.6.6 3.3L21 9l-1.8 2.7L21 14.4l-2.7 1.9-.6 3.3-3.3-.6L12 21l-2.4-2.4-3.3.6-.6-3.3L3 14.4 4.8 11.7 3 9l2.7-1.9.6-3.3 3.3.6L12 2z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            <path d="M12 7.5l1.35 2.9 3.15.34-2.35 2.2.6 3.11L12 14.55l-2.75 1.5.6-3.11-2.35-2.2 3.15-.34L12 7.5z" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-shield" viewBox="0 0 24 24">
            <path d="M12 2l8 3.5v5.5c0 5-3.4 9.4-8 11-4.6-1.6-8-6-8-11V5.5L12 2z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            <path d="M9 12l2 2 4-4.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-zap" viewBox="0 0 24 24">
            <path d="M13 2L4 14h6l-1 8 9-12h-6l1-8z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-users" viewBox="0 0 24 24">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <circle cx="9" cy="7" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        </symbol>
        <symbol id="ic-doc" viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            <path d="M14 2v6h6M9 13h6M9 17h6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        </symbol>
        <symbol id="ic-chart" viewBox="0 0 24 24">
            <path d="M3 3v18h18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M7 14l4-4 3 3 5-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-wallet" viewBox="0 0 24 24">
            <path d="M20 7H4a2 2 0 0 1 0-4h14v4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            <path d="M20 7a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5" fill="none" stroke="currentColor" stroke-width="1.8"/>
            <circle cx="17" cy="15" r="1.4" fill="currentColor"/>
        </symbol>
        <symbol id="ic-coin" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/>
            <path d="M14.5 9.5c-.5-.8-1.4-1.3-2.5-1.3-1.6 0-2.8 1-2.8 2.3 0 3.2 5.6 1.6 5.6 4.8 0 1.3-1.2 2.3-2.8 2.3-1.1 0-2-.5-2.5-1.3" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M12 6.5v11" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        </symbol>
        <symbol id="ic-cog" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="3.2" fill="none" stroke="currentColor" stroke-width="1.8"/>
            <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.87l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.7 1.7 0 0 0-1.87-.34 1.7 1.7 0 0 0-1.03 1.56V21a2 2 0 1 1-4 0v-.09A1.7 1.7 0 0 0 8.98 19.4a1.7 1.7 0 0 0-1.87.34l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.7 1.7 0 0 0 .34-1.87 1.7 1.7 0 0 0-1.56-1.03H3a2 2 0 1 1 0-4h.09A1.7 1.7 0 0 0 4.6 8.98a1.7 1.7 0 0 0-.34-1.87l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.7 1.7 0 0 0 1.87.34H9a1.7 1.7 0 0 0 1.03-1.56V3a2 2 0 1 1 4 0v.09c0 .68.4 1.29 1.03 1.56a1.7 1.7 0 0 0 1.87-.34l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.7 1.7 0 0 0-.34 1.87V9c.27.62.88 1.03 1.56 1.03H21a2 2 0 1 1 0 4h-.09a1.7 1.7 0 0 0-1.56 1.03z" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-menu" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </symbol>
        <symbol id="ic-close" viewBox="0 0 24 24">
            <path d="M6 6l12 12M18 6L6 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </symbol>
        <symbol id="ic-chevron-down" viewBox="0 0 24 24">
            <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-plus" viewBox="0 0 24 24">
            <path d="M12 5v14M5 12h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </symbol>
        <symbol id="ic-arrow-right" viewBox="0 0 24 24">
            <path d="M5 12h14M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-globe" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/>
            <path d="M3 12h18M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18z" fill="none" stroke="currentColor" stroke-width="1.8"/>
        </symbol>
        <symbol id="ic-sun" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="4.5" fill="none" stroke="currentColor" stroke-width="1.8"/>
            <path d="M12 2v2.5M12 19.5V22M2 12h2.5M19.5 12H22M4.9 4.9l1.8 1.8M17.3 17.3l1.8 1.8M4.9 19.1l1.8-1.8M17.3 6.7l1.8-1.8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        </symbol>
        <symbol id="ic-moon" viewBox="0 0 24 24">
            <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-infinity" viewBox="0 0 24 24">
            <path d="M6.5 12c-1.6-1.8-3-1.8-4 0-1 1.8 1 3.8 3 3.8 3.5 0 2.5-3 6-3s2.5 3 6 3c2 0 4-2 3-3.8-1-1.8-2.4-1.8-4 0" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        </symbol>
        <symbol id="ic-lock" viewBox="0 0 24 24">
            <rect x="4" y="11" width="16" height="10" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/>
            <path d="M8 11V7a4 4 0 0 1 8 0v4" fill="none" stroke="currentColor" stroke-width="1.8"/>
        </symbol>
        <symbol id="ic-refresh" viewBox="0 0 24 24">
            <path d="M21 12a9 9 0 1 1-2.6-6.4M21 3v6h-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-mail" viewBox="0 0 24 24">
            <rect x="3" y="5" width="18" height="14" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/>
            <path d="M3 7l9 6 9-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-brand" viewBox="0 0 24 24">
            <path d="M12 2l8 4v6c0 5-3.4 9.4-8 11-4.6-1.6-8-6-8-11V6l8-4z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
            <path d="M8.5 12.5l2.5 2.5 4.5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </symbol>
        <symbol id="ic-bolt" viewBox="0 0 24 24">
            <path d="M13 2L4 14h6l-1 8 9-12h-6l1-8z" fill="currentColor"/>
        </symbol>
    </svg>

    {{-- ============================================================
         STARFIELD BACKGROUND
         ============================================================ --}}
    <div class="starfield" aria-hidden="true"></div>

    {{-- ============================================================
         NAVBAR
         ============================================================ --}}
    <header class="navbar" id="navbar">
        <div class="container nav-inner">
            <a href="{{ url('/') }}" class="nav-logo">
                <span class="nav-logo-mark">
                    <svg class="icon"><use xlink:href="#ic-brand"/></svg>
                </span>
                Arvessa
            </a>

            <nav class="nav-links" aria-label="Navigasi utama">
                <a href="#fitur" class="active">Fitur</a>
                <a href="#preview">Dashboard</a>
                <a href="#testimoni">Testimoni</a>
                <a href="#keamanan">Keamanan</a>
                <a href="#harga">Harga</a>
                <a href="#faq">FAQ</a>
            </nav>

            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn-custom btn-grey">Masuk</a>
                <a href="{{ route('register') }}" class="btn-custom btn-primary">Mulai Gratis</a>
                <button class="btn-hamburger" id="btnHamburger" aria-label="Buka menu">
                    <svg class="icon"><use xlink:href="#ic-menu"/></svg>
                </button>
            </div>
        </div>
    </header>

    {{-- Mobile menu --}}
    <div class="mobile-menu" id="mobileMenu">
        <a href="#fitur" class="active">Fitur</a>
        <a href="#preview">Dashboard</a>
        <a href="#testimoni">Testimoni</a>
        <a href="#keamanan">Keamanan</a>
        <a href="#harga">Harga</a>
        <a href="#faq">FAQ</a>
        <div class="mobile-actions">
            <a href="{{ route('login') }}" class="btn-custom btn-grey">Masuk</a>
            <a href="{{ route('register') }}" class="btn-custom btn-primary">Mulai Gratis</a>
        </div>
    </div>

    {{-- ============================================================
         HERO — Halaman utama: headline + laptop mockup dashboard
         ============================================================ --}}
    <section class="hero-welcome" id="beranda">
        <div class="container">
            <span class="hero-eyebrow">
                <svg class="icon"><use xlink:href="#ic-zap"/></svg>
                Keuangan Bisnis, Satu Platform
            </span>
            <h1 class="hero-title">
                Kelola keuangan UMKM<br>
                <span class="grad">dalam satu aplikasi</span>
            </h1>
            <p class="hero-sub">
                Arvessa membantu Anda membuat faktur, memantau piutang, mengelola
                payroll, hingga menyusun anggaran — cepat, akurat, dan aman.
                Tanpa ribet, tanpa aplikasi berantakan.
            </p>

            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn-custom btn-primary">
                    Mulai Gratis Sekarang
                    <svg class="icon"><use xlink:href="#ic-arrow-right"/></svg>
                </a>
                <a href="#fitur" class="btn-custom btn-grey">
                    Lihat Fitur
                </a>
            </div>

            <div class="hero-trust">
                <span class="trust-item">
                    <svg class="icon"><use xlink:href="#ic-check"/></svg>
                    Gratis selamanya untuk mulai
                </span>
                <span class="trust-item">
                    <svg class="icon"><use xlink:href="#ic-lock"/></svg>
                    Data terenkripsi AES-256
                </span>
                <span class="trust-item">
                    <span class="trust-avatars">
                        <span class="ava ava-1">A</span>
                        <span class="ava ava-2">R</span>
                        <span class="ava ava-3">S</span>
                        <span class="ava ava-4">+</span>
                    </span>
                    Dipercaya 2.500+ bisnis
                </span>
            </div>

            <div class="hero-laptop">
                <div class="laptop-glow" aria-hidden="true"></div>
                <div class="laptop">
                    <div class="laptop-topbar">
                        <span class="dot dot-r"></span>
                        <span class="dot dot-y"></span>
                        <span class="dot dot-g"></span>
                        <span class="laptop-url">
                            <svg class="icon"><use xlink:href="#ic-lock"/></svg>
                            app.arvessa.id/dashboard
                        </span>
                    </div>
                    <div class="laptop-screen">
                        <aside class="dash-sidebar">
                            <div class="side-logo">
                                <span class="mini-mark">
                                    <svg class="icon"><use xlink:href="#ic-brand"/></svg>
                                </span>
                                Arvessa
                            </div>
                            <span class="side-link active">
                                <svg class="icon"><use xlink:href="#ic-chart"/></svg>
                                Dashboard
                            </span>
                            <span class="side-link">
                                <svg class="icon"><use xlink:href="#ic-doc"/></svg>
                                Faktur
                            </span>
                            <span class="side-link">
                                <svg class="icon"><use xlink:href="#ic-wallet"/></svg>
                                Piutang
                            </span>
                            <span class="side-link">
                                <svg class="icon"><use xlink:href="#ic-users"/></svg>
                                Klien
                            </span>
                            <span class="side-link">
                                <svg class="icon"><use xlink:href="#ic-cog"/></svg>
                                Pengaturan
                            </span>
                        </aside>
                        <div class="dash-main">
                            <div class="dash-head">
                                <h4>Ringkasan Keuangan</h4>
                                <span class="btn-mini">+ Faktur Baru</span>
                            </div>
                            <div class="dash-stats">
                                <div class="stat-card">
                                    <div class="stat-label">Pendapatan Bulan Ini</div>
                                    <div class="stat-value">Rp86,4<span class="up">jt</span></div>
                                    <div class="stat-delta">▲ +12,4%</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-label">Faktur Dibayar</div>
                                    <div class="stat-value">42<span class="up">/58</span></div>
                                    <div class="stat-delta">▲ +8,1%</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-label">Piutang Berjalan</div>
                                    <div class="stat-value">Rp12,8<span class="up">jt</span></div>
                                    <div class="stat-delta">● 3 jatuh tempo</div>
                                </div>
                            </div>
                            <div class="dash-body">
                                <div class="dash-panel">
                                    <div class="panel-title">
                                        Arus Kas
                                        <span class="mini-chip">30 hari</span>
                                    </div>
                                    <div class="chart-bars">
                                        <span class="bar b1"></span>
                                        <span class="bar b2"></span>
                                        <span class="bar b3"></span>
                                        <span class="bar b4 hi"></span>
                                        <span class="bar b5"></span>
                                        <span class="bar b6 hi"></span>
                                        <span class="bar b7"></span>
                                    </div>
                                </div>
                                <div class="dash-panel">
                                    <div class="panel-title">
                                        Faktur Terbaru
                                        <span class="mini-chip">Hari ini</span>
                                    </div>
                                    <div class="invoice-list">
                                        <div class="invoice-row">
                                            <span class="inv-ic green"><svg class="icon"><use xlink:href="#ic-doc"/></svg></span>
                                            <span class="inv-info">
                                                <span class="inv-name">PT Karya Nusantara</span>
                                                <span class="inv-sub">INV-2026-0042 · Dibayar</span>
                                            </span>
                                            <span class="inv-amount">Rp8,4jt</span>
                                        </div>
                                        <div class="invoice-row">
                                            <span class="inv-ic blue"><svg class="icon"><use xlink:href="#ic-doc"/></svg></span>
                                            <span class="inv-info">
                                                <span class="inv-name">CV Sumber Makmur</span>
                                                <span class="inv-sub">INV-2026-0041 · Jatuh tempo</span>
                                            </span>
                                            <span class="inv-amount">Rp3,2jt</span>
                                        </div>
                                        <div class="invoice-row">
                                            <span class="inv-ic orange"><svg class="icon"><use xlink:href="#ic-doc"/></svg></span>
                                            <span class="inv-info">
                                                <span class="inv-name">Toko Berkah Jaya</span>
                                                <span class="inv-sub">INV-2026-0040 · Draf</span>
                                            </span>
                                            <span class="inv-amount">Rp1,6jt</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="laptop-base"></div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         LOGO STRIP
         ============================================================ --}}
    <section class="logo-strip">
        <div class="container">
            <div class="strip-label">Dipercaya oleh tim keuangan dari</div>
            <div class="logos">
                <span class="logo-chip"><span class="chip-mark"><svg class="icon"><use xlink:href="#ic-brand"/></svg></span>Nusantara</span>
                <span class="logo-chip"><span class="chip-mark"><svg class="icon"><use xlink:href="#ic-zap"/></svg></span>Sinar Abadi</span>
                <span class="logo-chip"><span class="chip-mark"><svg class="icon"><use xlink:href="#ic-chart"/></svg></span>Makmur Group</span>
                <span class="logo-chip"><span class="chip-mark"><svg class="icon"><use xlink:href="#ic-wallet"/></svg></span>Kopi Senja</span>
                <span class="logo-chip"><span class="chip-mark"><svg class="icon"><use xlink:href="#ic-users"/></svg></span>Laksana Jaya</span>
            </div>
        </div>
    </section>

    {{-- ============================================================
         FITUR — icon grid
         ============================================================ --}}
    <section class="section" id="fitur">
        <div class="container">
            <div class="section-head">
                <div class="section-kicker">Fitur</div>
                <h2>Semua yang bisnis Anda butuhkan</h2>
                <p>Satu platform untuk seluruh operasional keuangan — dirancang khusus untuk UMKM Indonesia.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feat-icon"><svg class="icon"><use xlink:href="#ic-doc"/></svg></div>
                    <h3>Faktur &amp; Penawaran</h3>
                    <p>Buat faktur dan penawaran profesional dalam hitungan detik, kirim otomatis, dan pantau status pembayarannya.</p>
                </div>
                <div class="feature-card">
                    <div class="feat-icon"><svg class="icon"><use xlink:href="#ic-wallet"/></svg></div>
                    <h3>Piutang &amp; Utang</h3>
                    <p>Catat piutang dan utang dengan rapi, lengkap dengan aging report dan pengingat jatuh tempo otomatis.</p>
                </div>
                <div class="feature-card">
                    <div class="feat-icon"><svg class="icon"><use xlink:href="#ic-chart"/></svg></div>
                    <h3>Laporan Keuangan</h3>
                    <p>Laba rugi, neraca, dan arus kas tersaji otomatis dari data transaksi — siap untuk kebutuhan pajak &amp; investor.</p>
                </div>
                <div class="feature-card">
                    <div class="feat-icon"><svg class="icon"><use xlink:href="#ic-users"/></svg></div>
                    <h3>Manajemen Klien</h3>
                    <p>Simpan data klien, riwayat transaksi, dan kontak dalam satu tempat. Kolaborasi dengan tim jadi mudah.</p>
                </div>
                <div class="feature-card">
                    <div class="feat-icon"><svg class="icon"><use xlink:href="#ic-coin"/></svg></div>
                    <h3>Payroll &amp; Karyawan</h3>
                    <p>Hitung gaji, bonus, dan potongan otomatis. Slip gaji terkirim langsung ke karyawan via email.</p>
                </div>
                <div class="feature-card">
                    <div class="feat-icon"><svg class="icon"><use xlink:href="#ic-bolt"/></svg></div>
                    <h3>Anggaran &amp; Forecasting</h3>
                    <p>Susun anggaran tahunan dan proyeksikan arus kas ke depan, sehingga keputusan bisnis lebih percaya diri.</p>
                </div>
            </div>

            <p class="features-more">
                Ada lagi? <a href="#harga">Lihat semua fitur di setiap paket →</a>
            </p>
        </div>
    </section>

    {{-- ============================================================
         DASHBOARD PREVIEW
         ============================================================ --}}
    <section class="section" id="preview" style="padding-top: 0;">
        <div class="container">
            <div class="preview-wrap">
                <div class="preview-visual">
                    <div class="pv-head">
                        <h4>Performa Keuangan — 6 Bulan</h4>
                        <span class="pv-chip">LIVE PREVIEW</span>
                    </div>
                    <div class="pv-bars">
                        <div class="pv-bar-col"><span class="pv-bar"></span><span>Mar</span></div>
                        <div class="pv-bar-col"><span class="pv-bar"></span><span>Apr</span></div>
                        <div class="pv-bar-col"><span class="pv-bar alt"></span><span>Mei</span></div>
                        <div class="pv-bar-col"><span class="pv-bar"></span><span>Jun</span></div>
                        <div class="pv-bar-col"><span class="pv-bar alt"></span><span>Jul</span></div>
                        <div class="pv-bar-col"><span class="pv-bar"></span><span>Agu</span></div>
                    </div>
                    <div class="pv-mini-rows">
                        <div class="pv-mini-row">
                            <span class="mini-dot d-emerald"></span>
                            <span class="pv-mini-label">Pendapatan</span>
                            <span class="pv-mini-val">Rp148,2jt</span>
                        </div>
                        <div class="pv-mini-row">
                            <span class="mini-dot d-blue"></span>
                            <span class="pv-mini-label">Biaya Operasional</span>
                            <span class="pv-mini-val">Rp61,8jt</span>
                        </div>
                        <div class="pv-mini-row">
                            <span class="mini-dot d-orange"></span>
                            <span class="pv-mini-label">Laba Bersih</span>
                            <span class="pv-mini-val">Rp86,4jt</span>
                        </div>
                    </div>
                    <div class="pv-float f1">
                        <svg class="icon"><use xlink:href="#ic-chart"/></svg>
                        <span>Laba naik <span class="f-num">+32%</span></span>
                    </div>
                    <div class="pv-float f2">
                        <svg class="icon"><use xlink:href="#ic-check"/></svg>
                        <span>Laporan siap <span class="f-num">otomatis</span></span>
                    </div>
                </div>

                <div class="preview-copy">
                    <div class="section-kicker">Dashboard</div>
                    <h2>Pantau kesehatan keuangan bisnis secara real-time</h2>
                    <p>
                        Semua angka penting — pendapatan, biaya, piutang, dan laba —
                        tampil dalam satu dashboard yang mudah dipahami.
                    </p>
                    <ul class="preview-list">
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span><strong>Update otomatis</strong> setiap transaksi dicatat — tanpa input manual ganda.</span>
                        </li>
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span><strong>Grafik interaktif</strong> arus kas, tren penjualan, dan komposisi pengeluaran.</span>
                        </li>
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span><strong>Export Excel &amp; PDF</strong> sekali klik untuk rapat atau kebutuhan perbankan.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         HERO PRICING — judul section harga + toggle bulanan/tahunan
         ============================================================ --}}
    <section class="hero-pricing" id="harga">
        <div class="container">
            <span class="hero-eyebrow">
                <svg class="icon"><use xlink:href="#ic-badge"/></svg>
                Paket Langganan
            </span>
            <h1 class="hero-title">
                Pilih paket yang tepat untuk<br>
                <span class="grad">bisnis Anda</span>
            </h1>
            <p class="hero-sub">
                Mulai gratis, kembangkan bisnis Anda dengan Arvessa.
                Upgrade kapan saja — tanpa biaya tersembunyi, tanpa kontrak.
            </p>

            <div class="billing-toggle" id="billingToggle" role="group" aria-label="Periode penagihan">
                <button type="button" class="active" data-period="monthly">Bulanan</button>
                <button type="button" data-period="yearly">Tahunan <span class="save-tag">Hemat 20%</span></button>
            </div>
        </div>
    </section>

    {{-- ============================================================
         PRICING CARDS — Free / Platinum / Gold
         ============================================================ --}}
    <section class="section" style="padding-top: 24px;" id="paket">
        <div class="container">
            <div class="pricing-grid">

                {{-- FREE --}}
                <div class="pricing-card free-card">
                    <span class="badge-top-right">
                        <svg class="icon"><use xlink:href="#ic-check"/></svg>
                        Aktif
                    </span>
                    <div class="price-icon-wrap">
                        <svg class="icon"><use xlink:href="#ic-shield"/></svg>
                    </div>
                    <h3 class="price-name">Free</h3>
                    <p class="price-desc">Mulai dari sini, gratis selamanya.</p>
                    <div class="price-amount">
                        <span class="currency">Rp</span>
                        <span data-price-monthly="0" data-price-yearly="0">0</span>
                    </div>
                    <div class="price-period">Gratis selamanya</div>
                    <ul class="price-features">
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span>Maks. <strong>1 pengguna</strong></span>
                        </li>
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span><strong>Faktur &amp; Penawaran</strong></span>
                        </li>
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span><strong>Manajemen Klien</strong></span>
                        </li>
                    </ul>
                    <button type="button" class="btn-custom btn-grey" disabled>
                        <svg class="icon"><use xlink:href="#ic-check"/></svg>
                        Paket Aktif
                    </button>
                </div>

                {{-- PLATINUM --}}
                <div class="pricing-card platinum-card featured">
                    <span class="badge-top-right badge-blue">
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        Paling Populer
                    </span>
                    <div class="price-icon-wrap">
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                    </div>
                    <h3 class="price-name">Platinum</h3>
                    <p class="price-desc">Paling dipilih bisnis berkembang.</p>
                    <div class="price-amount">
                        <span class="currency">Rp</span>
                        <span data-price-monthly="149000" data-price-yearly="119200">149.000</span>
                    </div>
                    <div class="price-period">
                        <span data-period-text="/bulan">/bulan</span>
                        <span class="cancel-anytime">
                            <svg class="icon"><use xlink:href="#ic-refresh"/></svg>
                            Batalkan kapan saja
                        </span>
                    </div>
                    <ul class="price-features">
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span>Semua fitur <strong>Free</strong></span>
                        </li>
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span><strong>Piutang &amp; Utang</strong> + Aging Report</span>
                        </li>
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span><strong>Manajemen Keuangan</strong></span>
                        </li>
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span>Maks. <strong>3 pengguna</strong></span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-custom btn-blue">
                        Upgrade Sekarang
                        <svg class="icon"><use xlink:href="#ic-arrow-right"/></svg>
                    </a>
                </div>

                {{-- GOLD --}}
                <div class="pricing-card gold-card">
                    <span class="badge-top-right badge-orange">
                        <svg class="icon"><use xlink:href="#ic-bolt"/></svg>
                        Gold
                    </span>
                    <div class="price-icon-wrap">
                        <svg class="icon"><use xlink:href="#ic-badge"/></svg>
                    </div>
                    <h3 class="price-name">Gold</h3>
                    <p class="price-desc">Semua fitur, tanpa batas.</p>
                    <div class="price-amount">
                        <span class="currency">Rp</span>
                        <span data-price-monthly="349000" data-price-yearly="279200">349.000</span>
                    </div>
                    <div class="price-period">
                        <span data-period-text="/bulan">/bulan</span>
                        <span class="cancel-anytime">
                            <svg class="icon"><use xlink:href="#ic-refresh"/></svg>
                            Batalkan kapan saja
                        </span>
                    </div>
                    <ul class="price-features">
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span>Semua fitur <strong>Platinum</strong></span>
                        </li>
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span><strong>Payroll</strong> dan Data Karyawan</span>
                        </li>
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span><strong>Anggaran</strong> dan Forecasting</span>
                        </li>
                        <li>
                            <svg class="icon"><use xlink:href="#ic-check"/></svg>
                            <span><strong>Multi User</strong> &amp; Hak Akses</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-custom btn-orange">
                        Upgrade Sekarang
                        <svg class="icon"><use xlink:href="#ic-arrow-right"/></svg>
                    </a>
                </div>

            </div>

            <p class="pricing-note">
                Harga sudah termasuk PPN. Butuh penawaran khusus?
                <a href="mailto:halo@arvessa.id">Hubungi kami</a>.
            </p>

            <div class="compare-strip">
                <span class="compare-item">
                    <svg class="icon"><use xlink:href="#ic-lock"/></svg>
                    Pembayaran aman &amp; terenkripsi
                </span>
                <span class="compare-item">
                    <svg class="icon"><use xlink:href="#ic-refresh"/></svg>
                    Batalkan kapan saja
                </span>
                <span class="compare-item">
                    <svg class="icon"><use xlink:href="#ic-infinity"/></svg>
                    Tanpa kontrak jangka panjang
                </span>
            </div>
        </div>
    </section>

    {{-- ============================================================
         TESTIMONI
         ============================================================ --}}
    <section class="section" id="testimoni">
        <div class="container">
            <div class="section-head">
                <div class="section-kicker">Testimoni</div>
                <h2>Apa kata mereka?</h2>
                <p>Ribuan pemilik bisnis di Indonesia sudah merasakan manfaat Arvessa.</p>
            </div>

            <div class="testi-grid">
                <div class="testi-card">
                    <div class="testi-stars">
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                    </div>
                    <p class="testi-text">
                        "Dulu laporan keuangan toko saya berantakan. Sekarang semua
                        otomatis — <strong>faktur, piutang, sampai laba rugi</strong>.
                        Hemat waktu saya 10 jam per minggu!"
                    </p>
                    <div class="testi-person">
                        <span class="ava ava-1">R</span>
                        <span>
                            <span class="testi-name">Rina Wijaya</span>
                            <span class="testi-role">Pemilik Toko Berkah Jaya</span>
                        </span>
                    </div>
                </div>

                <div class="testi-card">
                    <div class="testi-stars">
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                    </div>
                    <p class="testi-text">
                        "Arvessa <strong>mengubah cara kami mengelola keuangan</strong>.
                        Payroll yang tadinya makan 3 hari, sekarang selesai dalam
                        satu jam. Sangat direkomendasikan!"
                    </p>
                    <div class="testi-person">
                        <span class="ava ava-2">D</span>
                        <span>
                            <span class="testi-name">Dedi Kurniawan</span>
                            <span class="testi-role">Direktur CV Sumber Makmur</span>
                        </span>
                    </div>
                </div>

                <div class="testi-card">
                    <div class="testi-stars">
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                        <svg class="icon"><use xlink:href="#ic-star"/></svg>
                    </div>
                    <p class="testi-text">
                        "Awalnya ragu karena sudah nyaman dengan Excel. Setelah
                        mencoba paket Free, <strong>langsung upgrade ke Platinum</strong>.
                        Dashboard-nya jernih dan mudah dibaca."
                    </p>
                    <div class="testi-person">
                        <span class="ava ava-3">S</span>
                        <span>
                            <span class="testi-name">Sari Amelia</span>
                            <span class="testi-role">CFO PT Karya Nusantara</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         KEAMANAN
         ============================================================ --}}
    <section class="section" id="keamanan" style="padding-top: 0;">
        <div class="container">
            <div class="security-wrap">
                <div class="security-copy">
                    <div class="section-kicker">Keamanan</div>
                    <h2>Data bisnis Anda aman bersama kami</h2>
                    <p>
                        Arvessa dibangun dengan standar keamanan industri.
                        Data Anda terenkripsi, tersimpan di pusat data berstandar
                        internasional, dan di-backup setiap hari.
                    </p>
                    <div class="security-grid">
                        <div class="security-item">
                            <div class="sec-icon"><svg class="icon"><use xlink:href="#ic-lock"/></svg></div>
                            <h4>Enkripsi AES-256</h4>
                            <p>Seluruh data terenkripsi saat disimpan maupun dikirim.</p>
                        </div>
                        <div class="security-item">
                            <div class="sec-icon"><svg class="icon"><use xlink:href="#ic-shield"/></svg></div>
                            <h4>Backup Otomatis</h4>
                            <p>Data di-backup harian dengan pemulihan cepat.</p>
                        </div>
                        <div class="security-item">
                            <div class="sec-icon"><svg class="icon"><use xlink:href="#ic-users"/></svg></div>
                            <h4>Kontrol Akses</h4>
                            <p>Atur hak akses tiap pengguna sesuai peran.</p>
                        </div>
                        <div class="security-item">
                            <div class="sec-icon"><svg class="icon"><use xlink:href="#ic-refresh"/></svg></div>
                            <h4>Pantauan 24/7</h4>
                            <p>Pemantauan keamanan dan uptime sepanjang waktu.</p>
                        </div>
                    </div>
                </div>
                <div class="preview-visual">
                    <div class="pv-head">
                        <h4>Status Keamanan</h4>
                        <span class="pv-chip">PROTECTED</span>
                    </div>
                    <div class="pv-mini-rows">
                        <div class="pv-mini-row">
                            <span class="mini-dot d-emerald"></span>
                            <span class="pv-mini-label">Enkripsi data</span>
                            <span class="pv-mini-val">AES-256</span>
                        </div>
                        <div class="pv-mini-row">
                            <span class="mini-dot d-emerald"></span>
                            <span class="pv-mini-label">Backup terakhir</span>
                            <span class="pv-mini-val">Baru saja</span>
                        </div>
                        <div class="pv-mini-row">
                            <span class="mini-dot d-emerald"></span>
                            <span class="pv-mini-label">Uptime 90 hari</span>
                            <span class="pv-mini-val">99,98%</span>
                        </div>
                        <div class="pv-mini-row">
                            <span class="mini-dot d-emerald"></span>
                            <span class="pv-mini-label">Pemindaian ancaman</span>
                            <span class="pv-mini-val">Aktif</span>
                        </div>
                    </div>
                    <div class="pv-float f1">
                        <svg class="icon"><use xlink:href="#ic-lock"/></svg>
                        <span>SSL <span class="f-num">TLS 1.3</span></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         FAQ
         ============================================================ --}}
    <section class="section faq-section" id="faq">
        <div class="container">
            <div class="section-head">
                <div class="section-kicker">FAQ</div>
                <h2>Pertanyaan yang sering diajukan</h2>
                <p>Masih ragu? Temukan jawaban untuk pertanyaan umum seputar paket langganan Arvessa.</p>
            </div>

            <div class="faq-list">
                <div class="faq-item">
                    <button type="button" class="faq-question">
                        Apakah paket Free benar-benar gratis selamanya?
                        <span class="faq-icon"><svg class="icon"><use xlink:href="#ic-plus"/></svg></span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Ya. Paket Free Arvessa gratis selamanya dan tidak memerlukan kartu kredit.
                            Anda bisa mulai mengelola faktur, penawaran, dan klien tanpa biaya.
                            Upgrade hanya dilakukan saat Anda siap berkembang.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="faq-question">
                        Bagaimana cara upgrade atau downgrade paket?
                        <span class="faq-icon"><svg class="icon"><use xlink:href="#ic-plus"/></svg></span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Anda dapat mengubah paket kapan saja dari halaman Pengaturan → Langganan.
                            Perubahan berlaku langsung dan selisih biaya dihitung secara proporsional.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="faq-question">
                        Metode pembayaran apa saja yang didukung?
                        <span class="faq-icon"><svg class="icon"><use xlink:href="#ic-plus"/></svg></span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Kami mendukung transfer bank (BCA, Mandiri, BRI, BNI), virtual account,
                            kartu kredit/debit, serta e-wallet seperti GoPay, OVO, dan DANA.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="faq-question">
                        Apakah data saya aman jika saya berhenti berlangganan?
                        <span class="faq-icon"><svg class="icon"><use xlink:href="#ic-plus"/></svg></span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Ya. Data Anda tetap tersimpan dan dapat diakses kembali saat Anda
                            berlangganan lagi. Arvessa mengenkripsi seluruh data dengan standar
                            keamanan industri (AES-256) dan backup otomatis setiap hari.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="faq-question">
                        Apakah ada biaya tambahan atau kontrak jangka panjang?
                        <span class="faq-icon"><svg class="icon"><use xlink:href="#ic-plus"/></svg></span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Tidak ada. Semua harga sudah termasuk PPN dan tanpa biaya tersembunyi.
                            Anda bebas berhenti kapan saja tanpa penalti.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         CTA BANNER
         ============================================================ --}}
    <section class="section" style="padding-top: 0;">
        <div class="container">
            <div class="cta-banner">
                <h2>Siap membawa bisnis Anda ke level berikutnya?</h2>
                <p>
                    Bergabung dengan ribuan bisnis di Indonesia yang sudah
                    mempercayakan keuangan mereka pada Arvessa.
                </p>
                <a href="{{ route('register') }}" class="btn-custom btn-primary">
                    Mulai Gratis Sekarang
                    <svg class="icon"><use xlink:href="#ic-arrow-right"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================================
         FOOTER
         ============================================================ --}}
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="{{ url('/') }}" class="nav-logo">
                        <span class="nav-logo-mark">
                            <svg class="icon"><use xlink:href="#ic-brand"/></svg>
                        </span>
                        Arvessa
                    </a>
                    <p>Platform manajemen keuangan &amp; bisnis untuk UMKM Indonesia.
                       Faktur, piutang, payroll, hingga forecasting dalam satu aplikasi.</p>
                </div>
                <div class="footer-col">
                    <h4>Produk</h4>
                    <a href="#fitur">Fitur</a>
                    <a href="#harga">Harga</a>
                    <a href="#preview">Dashboard</a>
                    <a href="#keamanan">Keamanan</a>
                </div>
                <div class="footer-col">
                    <h4>Perusahaan</h4>
                    <a href="#">Tentang Kami</a>
                    <a href="#">Blog</a>
                    <a href="#">Karier</a>
                    <a href="#">Kontak</a>
                </div>
                <div class="footer-col">
                    <h4>Bantuan</h4>
                    <a href="#faq">FAQ</a>
                    <a href="#harga">Paket &amp; Harga</a>
                    <a href="#keamanan">Keamanan Data</a>
                    <a href="#">Kebijakan Privasi</a>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© {{ date('Y') }} Arvessa. Semua hak dilindungi.</span>
                <div class="socials">
                    <a href="#" aria-label="Instagram">
                        <svg class="icon"><use xlink:href="#ic-globe"/></svg>
                    </a>
                    <a href="#" aria-label="Email">
                        <svg class="icon"><use xlink:href="#ic-mail"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ============================================================
         SETTINGS WIDGET — tema / aksen / bahasa
         ============================================================ --}}
    <button class="settings-fab" id="settingsFab" aria-label="Buka pengaturan">
        <svg class="icon"><use xlink:href="#ic-cog"/></svg>
    </button>

    <div class="settings-panel" id="settingsPanel">
        <h3>
            <svg class="icon"><use xlink:href="#ic-cog"/></svg>
            Pengaturan
        </h3>

        <div class="settings-group">
            <div class="settings-label">Tema</div>
            <div class="theme-options" id="themeOptions">
                <button type="button" data-theme-value="dark" class="active">
                    <svg class="icon" style="width:14px;height:14px"><use xlink:href="#ic-moon"/></svg>
                    Gelap
                </button>
                <button type="button" data-theme-value="light">
                    <svg class="icon" style="width:14px;height:14px"><use xlink:href="#ic-sun"/></svg>
                    Terang
                </button>
            </div>
        </div>

        <div class="settings-group">
            <div class="settings-label">Warna aksen</div>
            <div class="accent-options" id="accentOptions">
                <button type="button" data-accent-value="emerald" class="active">Emerald</button>
                <button type="button" data-accent-value="teal">Teal</button>
                <button type="button" data-accent-value="sky">Sky</button>
                <button type="button" data-accent-value="violet">Violet</button>
                <button type="button" data-accent-value="rose">Rose</button>
            </div>
        </div>

        <div class="settings-group">
            <div class="settings-label">Bahasa</div>
            <div class="lang-options" id="langOptions">
                <button type="button" data-lang-value="id" class="active">Indonesia</button>
                <button type="button" data-lang-value="en">English</button>
            </div>
        </div>
    </div>

    <script>
        /* ============================================================
           ARVESSA WELCOME — JavaScript
           (IIFE agar tidak mencemari global scope)
           ============================================================ */
        (function () {
            'use strict';

            var root = document.documentElement;

            /* ---------- Helper ---------- */
            function applyAttr(attr, value, activeClass) {
                root.setAttribute(attr, value);
                var buttons = document.querySelectorAll('[' + attr + '-options] button');
                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].classList.toggle(activeClass, buttons[i].getAttribute(attr + '-value') === value);
                }
            }

            /* ---------- Settings widget ---------- */
            var fab = document.getElementById('settingsFab');
            var panel = document.getElementById('settingsPanel');
            if (fab && panel) {
                fab.addEventListener('click', function () {
                    panel.classList.toggle('open');
                    fab.classList.toggle('rotated');
                });
                document.addEventListener('click', function (e) {
                    if (!panel.contains(e.target) && !fab.contains(e.target)) {
                        panel.classList.remove('open');
                        fab.classList.remove('rotated');
                    }
                });
            }

            /* ---------- Tema ---------- */
            var themeButtons = document.querySelectorAll('#themeOptions button');
            for (var t = 0; t < themeButtons.length; t++) {
                themeButtons[t].addEventListener('click', function () {
                    applyAttr('data-theme', this.getAttribute('data-theme-value'), 'active');
                });
            }

            /* ---------- Aksen ---------- */
            var accentButtons = document.querySelectorAll('#accentOptions button');
            for (var a = 0; a < accentButtons.length; a++) {
                accentButtons[a].addEventListener('click', function () {
                    applyAttr('data-accent', this.getAttribute('data-accent-value'), 'active');
                });
            }

            /* ---------- Bahasa (placeholder: cukup aktifkan tombol) ---------- */
            var langButtons = document.querySelectorAll('#langOptions button');
            for (var l = 0; l < langButtons.length; l++) {
                langButtons[l].addEventListener('click', function () {
                    applyAttr('data-language', this.getAttribute('data-lang-value'), 'active');
                });
            }

            /* ---------- Navbar scroll state ---------- */
            var navbar = document.getElementById('navbar');
            function onScroll() {
                if (!navbar) return;
                if (window.scrollY > 10) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();

            /* ---------- Mobile menu ---------- */
            var btnHamburger = document.getElementById('btnHamburger');
            var mobileMenu = document.getElementById('mobileMenu');
            if (btnHamburger && mobileMenu) {
                btnHamburger.addEventListener('click', function () {
                    var open = mobileMenu.classList.toggle('open');
                    btnHamburger.innerHTML = open
                        ? '<svg class="icon"><use xlink:href="#ic-close"/></svg>'
                        : '<svg class="icon"><use xlink:href="#ic-menu"/></svg>';
                });
                mobileMenu.addEventListener('click', function (e) {
                    if (e.target.tagName === 'A') {
                        mobileMenu.classList.remove('open');
                        btnHamburger.innerHTML = '<svg class="icon"><use xlink:href="#ic-menu"/></svg>';
                    }
                });
            }

            /* ---------- FAQ accordion ---------- */
            var faqItems = document.querySelectorAll('.faq-item');
            for (var f = 0; f < faqItems.length; f++) {
                var question = faqItems[f].querySelector('.faq-question');
                if (!question) continue;
                question.addEventListener('click', (function (item) {
                    return function () {
                        var answer = item.querySelector('.faq-answer');
                        var isOpen = item.classList.contains('open');
                        /* Tutup semua item lain */
                        for (var j = 0; j < faqItems.length; j++) {
                            faqItems[j].classList.remove('open');
                            var a = faqItems[j].querySelector('.faq-answer');
                            if (a) a.style.maxHeight = null;
                        }
                        if (!isOpen) {
                            item.classList.add('open');
                            if (answer) answer.style.maxHeight = answer.scrollHeight + 'px';
                        }
                    };
                })(faqItems[f]));
            }

            /* ---------- Billing toggle (bulanan / tahunan) ---------- */
            var billingToggle = document.getElementById('billingToggle');
            if (billingToggle) {
                var periodButtons = billingToggle.querySelectorAll('button');
                for (var b = 0; b < periodButtons.length; b++) {
                    periodButtons[b].addEventListener('click', function () {
                        for (var k = 0; k < periodButtons.length; k++) {
                            periodButtons[k].classList.remove('active');
                        }
                        this.classList.add('active');
                        var period = this.getAttribute('data-period');
                        updatePrices(period);
                    });
                }
            }

            function formatRupiah(num) {
                return num.toLocaleString('id-ID');
            }

            function updatePrices(period) {
                var amounts = document.querySelectorAll('[data-price-monthly]');
                for (var i = 0; i < amounts.length; i++) {
                    var monthly = parseInt(amounts[i].getAttribute('data-price-monthly'), 10);
                    var yearly = parseInt(amounts[i].getAttribute('data-price-yearly'), 10);
                    var value = (period === 'yearly') ? yearly : monthly;
                    amounts[i].textContent = formatRupiah(value);
                }
                var periodTexts = document.querySelectorAll('[data-period-text]');
                for (var p = 0; p < periodTexts.length; p++) {
                    periodTexts[p].textContent = (period === 'yearly') ? '/tahun' : '/bulan';
                }
            }

            /* ---------- Reveal animation (ringan, IntersectionObserver) ---------- */
            if ('IntersectionObserver' in window) {
                var revealables = document.querySelectorAll(
                    '.pricing-card, .faq-item, .cta-banner, .feature-card, .testi-card, ' +
                    '.security-item, .hero-laptop, .preview-visual'
                );
                var observer = new IntersectionObserver(function (entries) {
                    for (var i = 0; i < entries.length; i++) {
                        if (entries[i].isIntersecting) {
                            entries[i].target.classList.add('revealed');
                            observer.unobserve(entries[i].target);
                        }
                    }
                }, { threshold: 0.15 });
                for (var r = 0; r < revealables.length; r++) {
                    revealables[r].classList.add('reveal');
                    observer.observe(revealables[r]);
                }
                /* Fallback: jamin konten selalu terlihat meski observer tidak
                   menembak (mis. print, screenshot full-page, browser lama). */
                setTimeout(function () {
                    for (var r2 = 0; r2 < revealables.length; r2++) {
                        revealables[r2].classList.add('revealed');
                    }
                }, 1200);
            }
        })();
    </script>

    <style>
        /* Animasi reveal (ditambahkan setelah script agar hanya aktif bila JS jalan) */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .6s ease, transform .6s ease;
        }
        .reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        @media (prefers-reduced-motion: reduce) {
            .reveal { opacity: 1; transform: none; transition: none; }
        }
    </style>
</body>
</html>