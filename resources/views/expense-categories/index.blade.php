<x-app-layout>
  <x-slot name="title">Kategori Biaya</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY - ganti dengan query ExpenseCategory model nanti
    $categories = [
        ['name' => 'Bahan Baku',     'desc' => 'Kain, pewarna, malam, dan perlengkapan batik', 'count' => 2, 'total' => 3475000],
        ['name' => 'Transportasi',   'desc' => 'Pengiriman bahan & produk jadi',                'count' => 1, 'total' => 350000],
        ['name' => 'Utilitas',       'desc' => 'Listrik, air, dan internet workshop',           'count' => 1, 'total' => 820000],
        ['name' => 'Produksi',       'desc' => 'Upah pengrajin & biaya proses produksi',        'count' => 1, 'total' => 4200000],
        ['name' => 'Marketing',      'desc' => 'Promosi, konten, dan iklan online',             'count' => 1, 'total' => 600000],
    ];

    $categoriesCollection = collect($categories);
    $totalKategori     = $categoriesCollection->count();
    $totalSemuaBiaya   = $categoriesCollection->sum('total');
    $kategoriTerbesar  = $categoriesCollection->sortByDesc('total')->first();
    $totalTransaksi    = $categoriesCollection->sum('count');
    
    // Warna acak untuk avatar kategori
    $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A', '#14B8A6', '#F97316'];
  @endphp

  <style>
    /* ============================================
       KATEGORI BIAYA - Modern Card Grid Design
       ============================================ */
    
    .cat-modern {
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
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .cat-modern * {
      box-sizing: border-box;
    }

    .cat-modern .mono {
      font-family: 'IBM Plex Mono', monospace;
      font-variant-numeric: tabular-nums;
      letter-spacing: -0.02em;
    }

    /* ----- ANIMATIONS ----- */
    @keyframes fadeSlideUp {
      from {
        opacity: 0;
        transform: translateY(16px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .cat-modern .animate-in {
      animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
      opacity: 0;
    }

    /* ----- SVG ICON BASE ----- */
    .cat-modern .icon {
      width: 18px;
      height: 18px;
      flex-shrink: 0;
      display: inline-block;
      vertical-align: middle;
      fill: none;
      stroke: currentColor;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    /* ----- HEADER SECTION ----- */
    .cat-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .cat-header-left {
      flex: 1;
      min-width: 200px;
    }

    .cat-badge {
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

    .cat-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .cat-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .cat-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .cat-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .cat-header-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .cat-btn {
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

    .cat-btn .icon {
      width: 16px;
      height: 16px;
    }

    .cat-btn:hover {
      transform: translateY(-2px);
    }

    .cat-btn:active {
      transform: translateY(0) scale(0.97);
    }

    .cat-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .cat-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .cat-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .cat-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .cat-btn .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: scale(0);
      animation: rippleAnim 0.6s ease-out forwards;
      pointer-events: none;
    }

    @keyframes rippleAnim {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }

    /* ----- STATS ROW ----- */
    .cat-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 28px;
    }

    .cat-stat-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 22px 24px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
    }

    .cat-stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--theme-light), transparent);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .cat-stat-card:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-2px);
    }

    .cat-stat-card:hover::before {
      opacity: 1;
    }

    .cat-stat-card .stat-head {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 12px;
    }

    .cat-stat-card .stat-head .ic {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .cat-stat-card .stat-head .ic .icon {
      width: 17px;
      height: 17px;
    }

    .cat-stat-card .stat-head .label {
      font-size: 11px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .cat-stat-card .stat-value {
      font-size: 26px;
      font-weight: 700;
      letter-spacing: -0.02em;
      color: var(--text-primary);
      padding-left: 4px;
    }

    .cat-stat-card .stat-value.primary {
      color: var(--theme-primary);
    }

    .cat-stat-card .stat-value.warning {
      color: #F0A83C;
    }

    .cat-stat-card .stat-sub {
      font-size: 12px;
      color: var(--text-tertiary);
      margin-top: 4px;
      padding-left: 4px;
    }

    /* ----- CATEGORY GRID ----- */
    .cat-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 16px;
    }

    .cat-item {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 20px 22px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
    }

    .cat-item:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-4px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .cat-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }

    .cat-item:hover::before {
      opacity: 1;
    }

    .cat-item .cat-top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 14px;
    }

    .cat-item .cat-avatar {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
    }

    .cat-item .cat-actions {
      display: flex;
      gap: 6px;
      opacity: 0;
      transition: opacity 0.2s ease;
    }

    .cat-item:hover .cat-actions {
      opacity: 1;
    }

    .cat-item .cat-actions a {
      width: 28px;
      height: 28px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-tertiary);
      text-decoration: none;
      transition: all 0.2s ease;
      font-size: 12px;
    }

    .cat-item .cat-actions a:hover {
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .cat-item .cat-actions a.danger:hover {
      background: rgba(232, 90, 90, 0.12);
      color: #E85A5A;
    }

    .cat-item .cat-name {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 4px;
    }

    .cat-item .cat-desc {
      font-size: 13px;
      color: var(--text-secondary);
      margin-bottom: 16px;
      line-height: 1.5;
    }

    .cat-item .cat-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 14px;
      border-top: 1px solid var(--border-color);
    }

    .cat-item .cat-footer .stat {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .cat-item .cat-footer .stat .icon {
      width: 14px;
      height: 14px;
      color: var(--text-tertiary);
    }

    .cat-item .cat-footer .stat .label {
      font-size: 12px;
      color: var(--text-tertiary);
    }

    .cat-item .cat-footer .stat .value {
      font-family: 'IBM Plex Mono', monospace;
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .cat-item .cat-footer .total {
      font-family: 'IBM Plex Mono', monospace;
      font-size: 15px;
      font-weight: 700;
      color: var(--theme-primary);
    }

    /* ----- EMPTY STATE ----- */
    .cat-empty {
      text-align: center;
      padding: 60px 20px;
      background: var(--bg-card);
      border-radius: var(--radius-md);
      border: 2px dashed var(--border-color);
      grid-column: 1 / -1;
    }

    .cat-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .cat-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
      color: var(--text-primary);
    }

    .cat-empty p {
      color: var(--text-secondary);
      margin: 0 0 20px;
      font-size: 14px;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 1200px) {
      .cat-stats {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 768px) {
      .cat-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 640px) {
      .cat-header {
        flex-direction: column;
      }
      
      .cat-header-actions {
        width: 100%;
      }
      
      .cat-header-actions .cat-btn {
        flex: 1;
        justify-content: center;
      }

      .cat-stats {
        grid-template-columns: 1fr;
        gap: 12px;
      }

      .cat-stat-card .stat-value {
        font-size: 22px;
      }

      .cat-item {
        padding: 16px 18px;
      }

      .cat-item .cat-actions {
        opacity: 1;
      }
    }

    @media (max-width: 380px) {
      .cat-header h1 {
        font-size: 22px;
      }
      .cat-btn {
        font-size: 12px;
        padding: 8px 14px;
      }
      .cat-btn .icon {
        width: 14px;
        height: 14px;
      }
    }
  </style>

  <div class="cat-modern">

    <!-- ===== HEADER ===== -->
    <div class="cat-header animate-in" style="animation-delay: 0.05s;">
      <div class="cat-header-left">
        <div class="cat-badge">
          <span class="dot"></span>
          Pembelian &amp; Biaya
        </div>
        <h1>Kategori Biaya</h1>
        <p class="subtitle">
          Kelompokkan pengeluaran usaha agar laporan lebih rapi — 
          <strong>{{ $totalKategori }}</strong> kategori aktif
        </p>
      </div>
      <div class="cat-header-actions">
        <a href="{{ Route::has('expenses.index') ? route('expenses.index') : '#' }}" 
           class="cat-btn cat-btn-ghost">
          <svg class="icon"><use href="#ic-trending-down"/></svg>
          Lihat Pengeluaran
        </a>
        <a href="#" class="cat-btn cat-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Kategori Baru
        </a>
      </div>
    </div>

    <!-- ===== STATS ===== -->
    <div class="cat-stats">
      <div class="cat-stat-card animate-in" style="animation-delay: 0.10s;">
        <div class="stat-head">
          <div class="ic"><svg class="icon"><use href="#ic-briefcase"/></svg></div>
          <span class="label">Total Kategori</span>
        </div>
        <div class="stat-value primary">{{ $totalKategori }}</div>
        <div class="stat-sub">Kelompok biaya aktif</div>
      </div>

      <div class="cat-stat-card animate-in" style="animation-delay: 0.15s;">
        <div class="stat-head">
          <div class="ic"><svg class="icon"><use href="#ic-invoice"/></svg></div>
          <span class="label">Total Transaksi</span>
        </div>
        <div class="stat-value">{{ $totalTransaksi }}</div>
        <div class="stat-sub">Pengeluaran tercatat</div>
      </div>

      <div class="cat-stat-card animate-in" style="animation-delay: 0.20s;">
        <div class="stat-head">
          <div class="ic"><svg class="icon"><use href="#ic-trending-down"/></svg></div>
          <span class="label">Total Biaya</span>
        </div>
        <div class="stat-value primary mono">{{ $currencySymbol }}{{ number_format($totalSemuaBiaya, 0, ',', '.') }}</div>
        <div class="stat-sub">Semua kategori</div>
      </div>

      <div class="cat-stat-card animate-in" style="animation-delay: 0.25s;">
        <div class="stat-head">
          <div class="ic"><svg class="icon"><use href="#ic-trending"/></svg></div>
          <span class="label">Kategori Terbesar</span>
        </div>
        <div class="stat-value warning">{{ $kategoriTerbesar['name'] ?? '-' }}</div>
        <div class="stat-sub mono">{{ $kategoriTerbesar ? $currencySymbol . number_format($kategoriTerbesar['total'], 0, ',', '.') : 'Tidak ada data' }}</div>
      </div>
    </div>

    <!-- ===== CATEGORY GRID ===== -->
    <div class="cat-grid">
      @forelse($categories as $index => $c)
        @php
          $color = $colors[$index % count($colors)];
        @endphp
        <div class="cat-item animate-in" style="animation-delay: {{ 0.30 + ($index * 0.05) }}s;">
          <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: {{ $color }}; opacity: 0.7;"></div>
          
          <div class="cat-top">
            <div class="cat-avatar" style="background: {{ $color }};">
              {{ mb_substr($c['name'], 0, 1) }}
            </div>
            <div class="cat-actions">
              <a href="#" title="Edit">
                <svg class="icon" style="width:14px;height:14px;"><use href="#ic-settings"/></svg>
              </a>
              <a href="#" class="danger" title="Hapus">
                <svg class="icon" style="width:14px;height:14px;"><use href="#ic-close"/></svg>
              </a>
            </div>
          </div>

          <div class="cat-name">{{ $c['name'] }}</div>
          <div class="cat-desc">{{ $c['desc'] }}</div>

          <div class="cat-footer">
            <div class="stat">
              <svg class="icon"><use href="#ic-invoice"/></svg>
              <span class="label">Transaksi</span>
              <span class="value mono">{{ $c['count'] }}</span>
            </div>
            <div class="total mono">{{ $currencySymbol }}{{ number_format($c['total'], 0, ',', '.') }}</div>
          </div>
        </div>
      @empty
        <div class="cat-empty animate-in" style="animation-delay: 0.35s;">
          <svg class="empty-icon"><use href="#ic-briefcase"/></svg>
          <h3>Belum Ada Kategori</h3>
          <p>Belum ada kategori biaya yang tercatat di sistem.</p>
          <a href="#" class="cat-btn cat-btn-primary" style="display: inline-flex;">
            <svg class="icon"><use href="#ic-plus"/></svg>
            Buat Kategori Pertama
          </a>
        </div>
      @endforelse
    </div>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ripple effect untuk tombol
      const buttons = document.querySelectorAll('.cat-btn');
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
          setTimeout(() => {
            ripple.remove();
          }, 600);
        });
      });
    });
  </script>

</x-app-layout>