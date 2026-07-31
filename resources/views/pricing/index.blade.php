<x-app-layout>
  <x-slot name="title">Pilih Paket</x-slot>

  @php
    $currentPlan = $company->plan ?? 'free';

    $plans = [
        'free' => [
            'name' => 'Free',
            'tagline' => 'Mulai dari sini',
            'price' => 'Rp 0',
            'period' => 'selamanya',
            'desc' => 'Untuk mulai mengelola keuangan bisnis dasar.',
            'icon' => 'ic-activity',
            'accent' => 'plain',
            'features' => [
                ['ic-invoice', 'Faktur & Penawaran'],
                ['ic-receive', 'Manajemen Klien'],
                ['ic-trending-down', 'Pencatatan Pengeluaran'],
            ],
        ],
        'platinum' => [
            'name' => 'Platinum',
            'tagline' => 'Paling dipilih bisnis berkembang',
            'price' => 'Rp 149.000',
            'period' => '/bulan',
            'desc' => 'Untuk bisnis yang butuh laporan lebih lengkap.',
            'icon' => 'ic-trending',
            'accent' => 'emerald',
            'popular' => true,
            'features' => [
                ['ic-activity', 'Semua fitur Free'],
                ['ic-receive', 'Piutang & Utang + Aging Report'],
                ['ic-bank', 'Perbankan & Rekonsiliasi'],
                ['ic-trending', 'Laba Rugi, Neraca, Arus Kas'],
                ['ic-briefcase', 'Manajemen Inventaris'],
            ],
        ],
        'gold' => [
            'name' => 'Gold',
            'tagline' => 'Semua fitur, tanpa batas',
            'price' => 'Rp 349.000',
            'period' => '/bulan',
            'desc' => 'Paket lengkap untuk bisnis yang berkembang.',
            'icon' => 'ic-shield',
            'accent' => 'gold',
            'features' => [
                ['ic-trending', 'Semua fitur Platinum'],
                ['ic-users', 'Payroll & Data Karyawan'],
                ['ic-building', 'Pajak (PPh, PPN, Kalender Pajak)'],
                ['ic-target', 'Anggaran & Forecasting'],
                ['ic-shield', 'Multi-User & Hak Akses'],
            ],
        ],
    ];

    $planOrder = ['free' => 0, 'platinum' => 1, 'gold' => 2];
    $currentRank = $planOrder[$currentPlan] ?? 0;
  @endphp

  <style>
    .pricing-wrap {
      max-width: 1120px;
      margin: 0 auto;
      padding: 40px 20px 56px;
    }

    /* ===== HEADER ===== */
    .pricing-head {
      text-align: center;
      margin-bottom: 40px;
    }

    .pricing-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: var(--emerald);
      background: rgba(var(--emerald-rgb), 0.1);
      padding: 4px 14px;
      border-radius: 100px;
      margin: 0 0 12px;
      line-height: 1;
    }

    .pricing-eyebrow svg {
      width: 11px;
      height: 11px;
    }

    .pricing-head h1 {
      font-size: 32px;
      font-weight: 800;
      letter-spacing: -0.02em;
      margin: 0 0 8px;
      color: var(--text);
      line-height: 1.2;
    }

    .pricing-head p {
      color: var(--text-mute);
      font-size: 15px;
      margin: 0;
    }

    .pricing-head .current-tag {
      color: var(--text);
      font-weight: 700;
      background: var(--surface-strong);
      padding: 3px 14px;
      border-radius: 100px;
      border: 1px solid var(--border);
      display: inline-block;
      font-size: 14px;
      margin-left: 4px;
    }

    /* ===== GRID ===== */
    .pricing-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      align-items: stretch;
    }

    /* ===== CARD ===== */
    .pricing-card {
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 32px 28px 28px;
      background: var(--surface);
      display: flex;
      flex-direction: column;
      position: relative;
      transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
      backdrop-filter: blur(10px);
    }

    .pricing-card:hover {
      transform: translateY(-6px);
      border-color: var(--border-hover);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    /* Free tier */
    .pricing-card[data-accent="plain"] {
      background: var(--surface);
    }

    /* Platinum */
    .pricing-card[data-accent="emerald"] {
      border-color: rgba(var(--emerald-rgb), 0.3);
      background: linear-gradient(180deg, rgba(var(--emerald-rgb), 0.08), var(--surface) 50%);
      box-shadow: 0 8px 32px -8px rgba(var(--emerald-rgb), 0.15);
    }

    .pricing-card[data-accent="emerald"]:hover {
      box-shadow: 0 20px 60px -8px rgba(var(--emerald-rgb), 0.25);
    }

    /* Gold */
    .pricing-card[data-accent="gold"] {
      border-color: rgba(245, 158, 11, 0.3);
      background: linear-gradient(180deg, rgba(245, 158, 11, 0.06), var(--surface) 50%);
    }

    .pricing-card.current {
      border-color: var(--emerald);
      box-shadow: 0 0 0 2px rgba(var(--emerald-rgb), 0.2), 0 12px 40px rgba(var(--emerald-rgb), 0.1);
    }

    /* ===== BADGE ===== */
    .badge-popular,
    .badge-current {
      position: absolute;
      top: -13px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .06em;
      padding: 4px 16px;
      border-radius: 100px;
      white-space: nowrap;
      text-transform: uppercase;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .badge-popular svg,
    .badge-current svg {
      width: 12px;
      height: 12px;
    }

    .badge-popular {
      background: linear-gradient(135deg, #34D399, var(--emerald));
      color: #fff;
      box-shadow: 0 4px 16px rgba(var(--emerald-rgb), 0.4);
    }

    .badge-current {
      background: var(--emerald);
      color: #fff;
      box-shadow: 0 4px 16px rgba(var(--emerald-rgb), 0.3);
    }

    /* ===== ICON ===== */
    .plan-icon {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
      flex-shrink: 0;
    }

    .plan-icon svg {
      width: 22px;
      height: 22px;
    }

    [data-accent="plain"] .plan-icon {
      background: var(--surface-strong);
      color: var(--text-mute);
    }

    [data-accent="emerald"] .plan-icon {
      background: rgba(var(--emerald-rgb), 0.15);
      color: var(--emerald);
    }

    [data-accent="gold"] .plan-icon {
      background: rgba(245, 158, 11, 0.15);
      color: #f59e0b;
    }

    /* ===== TEXT ===== */
    .pricing-card h3 {
      font-size: 20px;
      font-weight: 800;
      margin-bottom: 2px;
      color: var(--text);
      letter-spacing: -0.02em;
    }

    .plan-tagline {
      font-size: 12px;
      font-weight: 600;
      color: var(--text-mute);
      margin-bottom: 14px;
    }

    [data-accent="emerald"] .plan-tagline {
      color: var(--emerald-light);
    }

    [data-accent="gold"] .plan-tagline {
      color: #fbbf24;
    }

    .price {
      font-size: 34px;
      font-weight: 800;
      margin: 4px 0 2px;
      color: var(--text);
      letter-spacing: -0.02em;
    }

    .price span {
      font-size: 14px;
      font-weight: 500;
      color: var(--text-mute);
    }

    .desc {
      font-size: 13px;
      color: var(--text-mute);
      margin: 8px 0 18px;
      min-height: 34px;
      line-height: 1.5;
    }

    /* ===== DIVIDER ===== */
    .plan-divider {
      height: 1px;
      background: var(--border);
      margin-bottom: 18px;
    }

    /* ===== FEATURES ===== */
    .pricing-card ul {
      list-style: none;
      padding: 0;
      margin: 0 0 24px;
      flex: 1;
    }

    .pricing-card ul li {
      font-size: 13.5px;
      padding: 7px 0;
      display: flex;
      gap: 10px;
      align-items: center;
      color: var(--text);
    }

    .feat-icon {
      width: 24px;
      height: 24px;
      border-radius: 8px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .feat-icon svg {
      width: 13px;
      height: 13px;
    }

    [data-accent="plain"] .feat-icon {
      background: var(--surface-strong);
      color: var(--text-mute);
    }

    [data-accent="emerald"] .feat-icon {
      background: rgba(var(--emerald-rgb), 0.12);
      color: var(--emerald);
    }

    [data-accent="gold"] .feat-icon {
      background: rgba(245, 158, 11, 0.12);
      color: #f59e0b;
    }

    /* ===== BUTTONS ===== */
    .pricing-card .btn-upgrade {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 14px 20px;
      border-radius: 12px;
      border: none;
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      text-align: center;
      width: 100%;
      text-decoration: none;
      transition: all 0.3s ease;
      letter-spacing: 0.02em;
      position: relative;
      overflow: hidden;
    }

    .pricing-card .btn-upgrade svg {
      width: 16px;
      height: 16px;
      flex-shrink: 0;
    }

    .pricing-card .btn-upgrade:hover {
      transform: translateY(-2px);
      filter: brightness(1.05);
    }

    .pricing-card .btn-upgrade:active {
      transform: scale(0.97);
    }

    [data-accent="plain"] .btn-upgrade {
      background: var(--surface-strong);
      color: var(--text);
      border: 1px solid var(--border);
    }

    [data-accent="plain"] .btn-upgrade:hover {
      background: var(--surface);
      border-color: var(--border-hover);
    }

    [data-accent="emerald"] .btn-upgrade {
      background: linear-gradient(135deg, #34D399, var(--emerald));
      color: #fff;
      box-shadow: 0 4px 16px rgba(var(--emerald-rgb), 0.3);
    }

    [data-accent="emerald"] .btn-upgrade:hover {
      box-shadow: 0 8px 32px rgba(var(--emerald-rgb), 0.4);
    }

    [data-accent="gold"] .btn-upgrade {
      background: linear-gradient(135deg, #fbbf24, #f59e0b);
      color: #0f172a;
      box-shadow: 0 4px 16px rgba(245, 158, 11, 0.3);
    }

    [data-accent="gold"] .btn-upgrade:hover {
      box-shadow: 0 8px 32px rgba(245, 158, 11, 0.4);
    }

    /* ===== CURRENT BUTTON ===== */
    .btn-current {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 14px 20px;
      border-radius: 12px;
      background: var(--surface-strong);
      color: var(--text-mute);
      cursor: default;
      border: 1px solid var(--border);
      font-weight: 700;
      font-size: 14px;
      width: 100%;
    }

    .btn-current svg {
      width: 16px;
      height: 16px;
      color: var(--emerald);
      flex-shrink: 0;
    }

    /* ===== FOOTER ===== */
    .pricing-foot {
      text-align: center;
      margin-top: 32px;
      padding-top: 20px;
      border-top: 1px solid var(--border);
      font-size: 13px;
      color: var(--text-faint);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }

    .pricing-foot svg {
      width: 14px;
      height: 14px;
      color: var(--text-faint);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
      .pricing-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
      }

      .pricing-card {
        padding: 28px 22px 24px;
      }
    }

    @media (max-width: 768px) {
      .pricing-wrap {
        padding: 28px 16px 40px;
      }

      .pricing-head h1 {
        font-size: 26px;
      }

      .pricing-grid {
        grid-template-columns: 1fr;
        gap: 28px;
        max-width: 480px;
        margin: 0 auto;
      }

      .pricing-card {
        padding: 28px 24px 24px;
      }

      .pricing-card[data-accent="emerald"] {
        transform: none;
      }

      .pricing-card[data-accent="emerald"]:hover {
        transform: translateY(-4px);
      }

      .price {
        font-size: 30px;
      }
    }

    @media (max-width: 480px) {
      .pricing-head h1 {
        font-size: 22px;
      }

      .pricing-head p {
        font-size: 13px;
      }

      .pricing-card {
        padding: 24px 18px 20px;
      }

      .pricing-card .btn-upgrade {
        font-size: 13px;
        padding: 12px 16px;
      }
    }

    /* ===== ANIMATION ===== */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .pricing-card {
      animation: fadeInUp 0.6s ease forwards;
      opacity: 0;
    }

    .pricing-card:nth-child(1) {
      animation-delay: 0.05s;
    }
    .pricing-card:nth-child(2) {
      animation-delay: 0.1s;
    }
    .pricing-card:nth-child(3) {
      animation-delay: 0.15s;
    }
  </style>

  <div class="pricing-wrap">
    <!-- ===== HEADER ===== -->
    <div class="pricing-head">
      <span class="pricing-eyebrow">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path d="M13 2 3 14h8l-1 8 10-12h-8l1-8Z"/>
        </svg>
        Paket Berlangganan
      </span>
      <h1>Pilih paket yang cocok buat bisnismu</h1>
      <p>
        Paket aktif kamu sekarang: 
        <span class="current-tag">{{ ucfirst($currentPlan) }}</span>
      </p>
    </div>

    <!-- ===== GRID ===== -->
    <div class="pricing-grid">
      @foreach($plans as $key => $p)
        @php
          $isCurrent = $currentPlan === $key;
          $isUpgrade = $planOrder[$key] > $currentRank;
          $isDowngrade = $planOrder[$key] < $currentRank;
          $buttonText = $isCurrent ? '' : ($isUpgrade ? 'Pilih ' . $p['name'] : 'Turunkan ke ' . $p['name']);
        @endphp

        <div class="pricing-card {{ $isCurrent ? 'current' : '' }}" data-accent="{{ $p['accent'] }}">
          @if($isCurrent)
            <span class="badge-current">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M20 6 9 17l-5-5"/>
              </svg>
              Paket Aktif
            </span>
          @elseif(!empty($p['popular']))
            <span class="badge-popular">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
              </svg>
              Paling Populer
            </span>
          @endif

          <div class="plan-icon">
            <svg><use href="#{{ $p['icon'] }}"/></svg>
          </div>

          <h3>{{ $p['name'] }}</h3>
          <div class="plan-tagline">{{ $p['tagline'] }}</div>

          <div class="price">{{ $p['price'] }} <span>{{ $p['period'] }}</span></div>
          <div class="desc">{{ $p['desc'] }}</div>

          <div class="plan-divider"></div>

          <ul>
            @foreach($p['features'] as [$icon, $label])
              <li>
                <span class="feat-icon"><svg><use href="#{{ $icon }}"/></svg></span>
                {{ $label }}
              </li>
            @endforeach
          </ul>

          @if($isCurrent)
            <div class="btn-current">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M20 6 9 17l-5-5"/>
              </svg>
              Sedang Digunakan
            </div>
          @else
            @if($key === 'free')
              <form method="POST" action="{{ route('pricing.select', $key) }}" style="width:100%;">
                @csrf
                <button type="submit" class="btn-upgrade">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                  </svg>
                  {{ $buttonText }}
                </button>
              </form>
            @else
              <a href="{{ route('payment.checkout', $key) }}" class="btn-upgrade">
                {{ $buttonText }}
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"/>
                  <polyline points="12 5 19 12 12 19"/>
                </svg>
              </a>
            @endif
          @endif
        </div>
      @endforeach
    </div>

    <p class="pricing-foot">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
        <line x1="1" y1="10" x2="23" y2="10"/>
      </svg>
      Bisa upgrade atau downgrade kapan saja. Tidak ada kontrak jangka panjang.
    </p>
  </div>
</x-app-layout>