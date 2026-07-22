<x-app-layout>
  <x-slot name="title">Detail Event Kalender Pajak</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    $statusColors = [
      'upcoming' => ['bg' => 'var(--success-soft)', 'text' => 'var(--success)', 'label' => 'Akan Datang'],
      'overdue' => ['bg' => 'var(--danger-soft)', 'text' => 'var(--danger)', 'label' => 'Lewat Jatuh Tempo'],
      'done' => ['bg' => 'var(--theme-soft)', 'text' => 'var(--theme-primary)', 'label' => 'Selesai']
    ];

    // PENTING: $event dikirim dari route sebagai ARRAY (session('calendar_events')[$index]),
    // jadi semua akses di bawah pakai $event['...'] bukan $event->...
    $statusColor = $statusColors[$event['status']] ?? $statusColors['upcoming'];

    $typeLabels = [
      'pph' => 'PPh',
      'ppn' => 'PPN',
      'other' => 'Lainnya'
    ];

    $typeLabel = $typeLabels[$event['type']] ?? $event['type'];
  @endphp

  <style>
    /* ============================================
       KALENDER PAJAK SHOW - Premium Design
       ============================================ */
    
    .cal-show-wrap {
      --theme-primary: var(--emerald);
      --theme-light: var(--emerald);
      --theme-dark: var(--emerald-dim);
      --theme-glow: rgba(var(--emerald-rgb), 0.25);
      --theme-soft: rgba(var(--emerald-rgb), 0.12);
      --theme-gradient: linear-gradient(135deg, var(--emerald), var(--emerald-dim));
      
      --text-primary: var(--text);
      --text-secondary: var(--text-mute);
      --text-tertiary: var(--text-faint);
      
      --bg-card: var(--surface);
      --bg-card-hover: var(--surface-strong);
      --bg-card-active: rgba(255, 255, 255, 0.04);
      --border-color: var(--border);
      --border-hover: var(--border-hover);
      
      --danger: #E85A5A;
      --danger-soft: rgba(232, 90, 90, 0.12);
      --success: #34B583;
      --success-soft: rgba(52, 181, 131, 0.14);
      --warning: #F0A83C;
      --warning-soft: rgba(240, 168, 60, 0.14);
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
      max-width: 100%;
      padding: 0 24px;
    }

    .cal-show-wrap * { box-sizing: border-box; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .cal-show-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .cal-show-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .cs-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .cs-header-left { flex: 1; min-width: 200px; }

    .cs-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 16px 6px 12px;
      background: var(--theme-glow);
      border: 1px solid var(--theme-glow);
      border-radius: 100px;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--theme-primary);
      margin-bottom: 12px;
    }

    .cs-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .cs-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .cs-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .cs-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .cs-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .cs-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      border-radius: var(--radius-sm);
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      border: none;
      cursor: pointer;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      background: transparent;
      color: var(--text-secondary);
      position: relative;
      overflow: hidden;
    }

    .cs-btn .icon { width: 16px; height: 16px; }
    .cs-btn:hover { transform: translateY(-2px); }
    .cs-btn:active { transform: translateY(0) scale(0.97); }

    .cs-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .cs-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .cs-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .cs-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .cs-btn .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: scale(0);
      animation: rippleAnim 0.6s ease-out forwards;
      pointer-events: none;
    }

    @keyframes rippleAnim {
      to { transform: scale(4); opacity: 0; }
    }

    /* CONTENT LAYOUT - FULL WIDTH */
    .cs-content {
      width: 100%;
      max-width: 100%;
    }

    .cs-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 32px 40px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      width: 100%;
    }

    .cs-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .cs-card .title {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .cs-card .title .icon {
      width: 20px;
      height: 20px;
      color: var(--theme-primary);
    }

    .cs-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* INFO ITEMS */
    .cs-info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .cs-info-item {
      padding: 16px 20px;
      background: var(--bg-card-active);
      border-radius: var(--radius-sm);
      border: 1px solid var(--border-color);
      transition: all 0.2s ease;
    }

    .cs-info-item:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
    }

    .cs-info-item .label {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--text-tertiary);
      margin-bottom: 6px;
    }

    .cs-info-item .value {
      font-size: 15px;
      font-weight: 500;
      color: var(--text-primary);
      word-break: break-word;
    }

    .cs-info-item .value .status-badge {
      display: inline-block;
      padding: 6px 16px;
      border-radius: 100px;
      font-size: 13px;
      font-weight: 600;
      background: {{ $statusColor['bg'] }};
      color: {{ $statusColor['text'] }};
    }

    .cs-info-item .value .type-badge {
      display: inline-block;
      padding: 6px 16px;
      border-radius: 100px;
      font-size: 13px;
      font-weight: 600;
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .cs-info-item.full-width {
      grid-column: 1 / -1;
    }

    .cs-info-item .value .description-text {
      line-height: 1.8;
      color: var(--text-secondary);
      font-size: 14px;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .cal-show-wrap { padding: 0 16px; }
      .cs-card { padding: 24px 28px; }
    }

    @media (max-width: 768px) {
      .cal-show-wrap { padding: 0 12px; }
      .cs-info-grid { 
        grid-template-columns: 1fr; 
      }
      .cs-card { 
        padding: 20px; 
      }
    }

    @media (max-width: 640px) {
      .cs-header { 
        flex-direction: column; 
      }
      .cs-actions { 
        width: 100%; 
      }
      .cs-actions .cs-btn { 
        flex: 1; 
        justify-content: center; 
      }
      .cs-card { padding: 16px; }
    }

    @media (max-width: 380px) {
      .cal-show-wrap { padding: 0 8px; }
      .cs-header h1 { 
        font-size: 22px; 
      }
      .cs-btn { 
        font-size: 12px; 
        padding: 8px 14px; 
      }
      .cs-btn .icon { 
        width: 14px; 
        height: 14px; 
      }
      .cs-card { padding: 12px; }
      .cs-info-item { padding: 12px 14px; }
      .cs-info-item .value { font-size: 13px; }
    }
  </style>

  <div class="cal-show-wrap">

    <!-- ===== HEADER ===== -->
    <div class="cs-header animate-in" style="animation-delay: 0.05s;">
      <div class="cs-header-left">
        <div class="cs-badge">
          <span class="dot"></span>
          Detail Pajak
        </div>
        <h1>{{ $event['title'] }}</h1>
        <p class="subtitle">
          <strong>Tipe:</strong> {{ $typeLabel }} — <strong>Status:</strong> {{ $statusColor['label'] }}
        </p>
      </div>
      <div class="cs-actions">
        <a href="{{ route('tax-calendar.index') }}" class="cs-btn cs-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
        <a href="{{ route('tax-calendar.edit', $index) }}" class="cs-btn cs-btn-primary">
          <svg class="icon"><use href="#ic-edit"/></svg>
          Edit Event
        </a>
      </div>
    </div>

    <!-- ===== CONTENT ===== -->
    <div class="cs-content">

      <div class="cs-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-calendar"/></svg>
          Informasi Event
          <span class="line"></span>
        </div>

        <!-- Info Grid -->
        <div class="cs-info-grid">
          <!-- Title -->
          <div class="cs-info-item">
            <div class="label">Judul Event</div>
            <div class="value">{{ $event['title'] }}</div>
          </div>

          <!-- Type -->
          <div class="cs-info-item">
            <div class="label">Tipe</div>
            <div class="value">
              <span class="type-badge">{{ $typeLabel }}</span>
            </div>
          </div>

          <!-- Date -->
          <div class="cs-info-item">
            <div class="label">Tanggal</div>
            <div class="value">
              {{ \Carbon\Carbon::parse($event['date'])->translatedFormat('d F Y') }}
            </div>
          </div>

          <!-- Status -->
          <div class="cs-info-item">
            <div class="label">Status</div>
            <div class="value">
              <span class="status-badge">{{ $statusColor['label'] }}</span>
            </div>
          </div>

          <!-- Description (full width) -->
          <div class="cs-info-item full-width">
            <div class="label">Deskripsi</div>
            <div class="value">
              <div class="description-text">{{ $event['desc'] }}</div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></symbol>
    <symbol id="ic-calendar" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ripple effect
      const buttons = document.querySelectorAll('.cs-btn');
      buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
          const rect = this.getBoundingClientRect();
          const ripple = document.createElement('span');
          ripple.className = 'ripple';
          const size = Math.max(rect.width, rect.height);
          ripple.style.width = ripple.style.height = size + 'px';
          ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
          ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
          this.appendChild(ripple);
          setTimeout(() => { ripple.remove(); }, 600);
        });
      });
    });
  </script>

</x-app-layout>