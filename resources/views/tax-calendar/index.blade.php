<x-app-layout>
  <x-slot name="title">Kalender Pajak</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY - ganti dengan query TaxCalendar model nanti
    $calendarEvents = [
        ['date' => '2026-07-15', 'title' => 'PPh Pasal 21', 'type' => 'pph', 'status' => 'upcoming', 'desc' => 'Laporan PPh 21 masa Juni 2026'],
        ['date' => '2026-07-20', 'title' => 'PPN Masa', 'type' => 'ppn', 'status' => 'upcoming', 'desc' => 'Laporan PPN masa Juni 2026'],
        ['date' => '2026-07-25', 'title' => 'PPh Pasal 23', 'type' => 'pph', 'status' => 'upcoming', 'desc' => 'Laporan PPh 23 masa Juni 2026'],
        ['date' => '2026-08-15', 'title' => 'PPh Pasal 21', 'type' => 'pph', 'status' => 'upcoming', 'desc' => 'Laporan PPh 21 masa Juli 2026'],
        ['date' => '2026-08-20', 'title' => 'PPN Masa', 'type' => 'ppn', 'status' => 'upcoming', 'desc' => 'Laporan PPN masa Juli 2026'],
        ['date' => '2026-08-25', 'title' => 'PPh Pasal 23', 'type' => 'pph', 'status' => 'upcoming', 'desc' => 'Laporan PPh 23 masa Juli 2026'],
    ];

    $calendarCollection = collect($calendarEvents);
    $currentMonth = now()->format('Y-m');
    
    // Kelompokkan berdasarkan bulan
    $eventsByMonth = $calendarCollection->groupBy(function($item) {
        return \Carbon\Carbon::parse($item['date'])->format('F Y');
    });
    
    $typeLabel = ['pph' => 'PPh', 'ppn' => 'PPN', 'other' => 'Lainnya'];
    $typeColor = ['pph' => 'var(--theme-primary)', 'ppn' => 'var(--warning)', 'other' => 'var(--text-tertiary)'];
    $statusLabel = ['upcoming' => 'Akan Datang', 'overdue' => 'Lewat Jatuh Tempo', 'done' => 'Selesai'];
    $statusPill = ['upcoming' => 'upcoming', 'overdue' => 'overdue', 'done' => 'done'];
  @endphp

  <style>
    .cal-wrap {
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
      
      --success: #34B583;
      --success-soft: rgba(52, 181, 131, 0.14);
      --warning: #F0A83C;
      --warning-soft: rgba(240, 168, 60, 0.14);
      --danger: #E85A5A;
      --danger-soft: rgba(232, 90, 90, 0.12);
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .cal-wrap * { box-sizing: border-box; }
    .cal-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .cal-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .cal-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .cal-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .cal-header-left { flex: 1; min-width: 200px; }

    .cal-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 14px 6px 10px;
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

    .cal-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .cal-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .cal-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .cal-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

    .cal-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .cal-btn {
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

    .cal-btn .icon { width: 16px; height: 16px; }
    .cal-btn:hover { transform: translateY(-2px); }
    .cal-btn:active { transform: translateY(0) scale(0.97); }

    .cal-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .cal-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .cal-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .cal-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .cal-btn .ripple {
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

    /* MONTHLY SECTION */
    .cal-month {
      margin-bottom: 24px;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      overflow: hidden;
    }

    .cal-month:last-child { margin-bottom: 0; }

    .cal-month-header {
      padding: 14px 20px;
      background: var(--bg-card-active);
      border-bottom: 1px solid var(--border-color);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .cal-month-header .month {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .cal-month-header .count {
      font-size: 12px;
      color: var(--text-tertiary);
    }

    /* EVENT LIST */
    .cal-events { padding: 12px; }

    .cal-event {
      display: flex;
      align-items: center;
      gap: 16px;
      padding: 12px 16px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      margin-bottom: 8px;
      transition: all 0.3s ease;
    }

    .cal-event:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateX(4px);
    }

    .cal-event:last-child { margin-bottom: 0; }

    .cal-event .date-badge {
      min-width: 56px;
      text-align: center;
      padding: 4px 8px;
      background: var(--theme-soft);
      border-radius: var(--radius-sm);
    }

    .cal-event .date-badge .day {
      font-size: 18px;
      font-weight: 700;
      color: var(--text-primary);
      display: block;
    }

    .cal-event .date-badge .month {
      font-size: 10px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .cal-event .info {
      flex: 1;
      min-width: 0;
    }

    .cal-event .info .title {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .cal-event .info .desc {
      font-size: 12px;
      color: var(--text-tertiary);
      margin-top: 2px;
    }

    .cal-event .tags {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-shrink: 0;
    }

    .cal-event .tags .type {
      font-size: 10px;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 100px;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      background: var(--bg-card-active);
      color: var(--text-secondary);
    }

    .cal-event .tags .type.pph { background: var(--theme-soft); color: var(--theme-primary); }
    .cal-event .tags .type.ppn { background: var(--warning-soft); color: var(--warning); }

    .cal-event .tags .status {
      font-size: 10px;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 100px;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .cal-event .tags .status.upcoming {
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .cal-event .tags .status.overdue {
      background: var(--danger-soft);
      color: var(--danger);
    }

    .cal-event .tags .status.done {
      background: var(--success-soft);
      color: var(--success);
    }

    /* EMPTY */
    .cal-empty {
      text-align: center;
      padding: 40px 20px;
      color: var(--text-tertiary);
    }

    .cal-empty .icon {
      width: 40px;
      height: 40px;
      margin: 0 auto 12px;
      color: var(--text-tertiary);
      opacity: 0.3;
    }

    .cal-empty p { font-size: 13px; }

    @media (max-width: 640px) {
      .cal-header { flex-direction: column; }
      .cal-actions { width: 100%; }
      .cal-actions .cal-btn { flex: 1; justify-content: center; }
      .cal-event { flex-wrap: wrap; gap: 10px; }
      .cal-event .date-badge { display: flex; align-items: center; gap: 8px; min-width: auto; }
      .cal-event .date-badge .day { display: inline; font-size: 16px; }
      .cal-event .tags { width: 100%; justify-content: flex-start; }
    }

    @media (max-width: 380px) {
      .cal-header h1 { font-size: 22px; }
      .cal-btn { font-size: 12px; padding: 8px 14px; }
      .cal-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="cal-wrap">

    <div class="cal-header animate-in" style="animation-delay: 0.05s;">
      <div class="cal-header-left">
        <div class="cal-badge">
          <span class="dot"></span>
          Pajak
        </div>
        <h1>Kalender Pajak</h1>
        <p class="subtitle">
          Jadwal pelaporan dan pembayaran pajak — 
          <strong>{{ $calendarCollection->count() }}</strong> event terdaftar
        </p>
      </div>
      <div class="cal-actions">
        <a href="{{ route('taxes.pph') }}" class="cal-btn cal-btn-ghost">
          <svg class="icon"><use href="#ic-building"/></svg>
          PPh
        </a>
        <a href="{{ route('taxes.ppn') }}" class="cal-btn cal-btn-ghost">
          <svg class="icon"><use href="#ic-invoice"/></svg>
          PPN
        </a>
        <a href="#" class="cal-btn cal-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Tambah Event
        </a>
      </div>
    </div>

    <!-- MONTHLY EVENTS -->
    @forelse($eventsByMonth as $month => $events)
      <div class="cal-month animate-in" style="animation-delay: {{ 0.10 + ($loop->index * 0.05) }}s;">
        <div class="cal-month-header">
          <span class="month">{{ $month }}</span>
          <span class="count">{{ $events->count() }} event</span>
        </div>
        <div class="cal-events">
          @foreach($events->sortBy('date') as $event)
            @php
              $date = \Carbon\Carbon::parse($event['date']);
              $isOverdue = $date->isPast() && $event['status'] != 'done';
            @endphp
            <div class="cal-event">
              <div class="date-badge">
                <span class="day">{{ $date->format('d') }}</span>
                <span class="month">{{ $date->translatedFormat('M') }}</span>
              </div>
              <div class="info">
                <div class="title">{{ $event['title'] }}</div>
                <div class="desc">{{ $event['desc'] }}</div>
              </div>
              <div class="tags">
                <span class="type {{ $event['type'] }}">{{ $typeLabel[$event['type']] }}</span>
                <span class="status {{ $isOverdue ? 'overdue' : $statusPill[$event['status']] }}">
                  {{ $isOverdue ? 'Lewat Jatuh Tempo' : $statusLabel[$event['status']] }}
                </span>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @empty
      <div class="cal-month">
        <div class="cal-empty">
          <svg class="icon"><use href="#ic-calendar"/></svg>
          <p>Belum ada event kalender pajak.</p>
        </div>
      </div>
    @endforelse

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.cal-btn');
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