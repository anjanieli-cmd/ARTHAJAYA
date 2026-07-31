<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="ic-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="11" width="18" height="11" rx="2"></rect>
    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
  </symbol>
</svg>

<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <span class="logo-mark">
      <img src="{{ asset('logos.png') }}" alt="{{ $company->name ?? 'Arvessa' }}">
    </span>
    <span class="sb-wordmark">Arves<span class="grad">sa</span></span>
  </div>

  @php
    // Helper lokal: kembalikan URL kalau route ada, atau '#' kalau belum dibuat.
    if (!function_exists('sb_url')) {
        function sb_url(string $name, array $params = []): string {
            return \Route::has($name) ? route($name, $params) : '#';
        }
    }

    // Plan aktif company (fallback 'free' kalau kolomnya null)
    $currentPlan = $company->plan ?? 'free';
    // Null safety untuk company
    $hasFeature = function($feature) use ($company) {
        return $company && method_exists($company, 'hasFeature') ? $company->hasFeature($feature) : false;
    };
  @endphp

  {{-- ===== DASHBOARD ===== --}}
  <div class="sb-group-label">Menu</div>
  <a href="{{ route('dashboard') }}" class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <span class="sb-link-main">
      <svg class="icon"><use href="#ic-activity"/></svg>
      <span class="sb-link-text">Dashboard</span>
    </span>
  </a>

  {{-- ===== PENJUALAN (dropdown) — FREE ===== --}}
  @php $g1 = request()->routeIs(['invoices.*','quotes.*','clients.*']); @endphp
  <div class="sb-accordion {{ $g1 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <span class="sb-link-main">
        <svg class="icon"><use href="#ic-invoice"/></svg>
        <span class="sb-link-text">Penjualan</span>
      </span>
      <span class="sb-link-end">
        <span class="badge">3</span>
        <svg class="icon chevron"><use href="#ic-chevron"/></svg>
      </span>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        <a href="{{ sb_url('invoices.index') }}" class="sb-sublink {{ request()->routeIs('invoices.*') ? 'active' : '' }} {{ \Route::has('invoices.index') ? '' : 'soon' }}">Semua Faktur</a>
        <a href="{{ sb_url('quotes.index') }}" class="sb-sublink {{ request()->routeIs('quotes.*') ? 'active' : '' }} {{ \Route::has('quotes.index') ? '' : 'soon' }}">Penawaran / Quotation</a>
        <a href="{{ sb_url('clients.index') }}" class="sb-sublink {{ request()->routeIs('clients.*') ? 'active' : '' }} {{ \Route::has('clients.index') ? '' : 'soon' }}">Klien</a>
      </div>
    </div>
  </div>

  {{-- ===== PIUTANG & UTANG — PLATINUM/GOLD ===== --}}
  @php
    $locked2 = !$hasFeature('piutang_utang');
    $g2 = request()->routeIs(['receivables.*','payables.*','aging.*']);
  @endphp
  <div class="sb-accordion {{ $g2 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <span class="sb-link-main">
        <svg class="icon"><use href="#ic-receive"/></svg>
        <span class="sb-link-text">Piutang &amp; Utang</span>
      </span>
      <span class="sb-link-end">
        @if($locked2)
          <span class="badge badge-lock"><svg class="icon-lock"><use href="#ic-lock"/></svg><span>Upgrade</span></span>
        @endif
        <svg class="icon chevron"><use href="#ic-chevron"/></svg>
      </span>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        @if($locked2)
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Piutang Usaha (AR)</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Utang Usaha (AP)</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Aging Report (30/60/90 hari)</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
        @else
          <a href="{{ sb_url('receivables.index') }}" class="sb-sublink {{ request()->routeIs('receivables.*') ? 'active' : '' }} {{ \Route::has('receivables.index') ? '' : 'soon' }}">Piutang Usaha (AR)</a>
          <a href="{{ sb_url('payables.index') }}" class="sb-sublink {{ request()->routeIs('payables.*') ? 'active' : '' }} {{ \Route::has('payables.index') ? '' : 'soon' }}">Utang Usaha (AP)</a>
          <a href="{{ sb_url('aging.index') }}" class="sb-sublink {{ request()->routeIs('aging.*') ? 'active' : '' }} {{ \Route::has('aging.index') ? '' : 'soon' }}">Aging Report (30/60/90 hari)</a>
        @endif
      </div>
    </div>
  </div>

  {{-- ===== PEMBELIAN & BIAYA — FREE ===== --}}
  @php $g3 = request()->routeIs(['expenses.*','expense-categories.*']); @endphp
  <div class="sb-accordion {{ $g3 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <span class="sb-link-main">
        <svg class="icon"><use href="#ic-trending-down"/></svg>
        <span class="sb-link-text">Pembelian &amp; Biaya</span>
      </span>
      <span class="sb-link-end">
        <svg class="icon chevron"><use href="#ic-chevron"/></svg>
      </span>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        <a href="{{ sb_url('expenses.index') }}" class="sb-sublink {{ request()->routeIs('expenses.*') ? 'active' : '' }} {{ \Route::has('expenses.index') ? '' : 'soon' }}">Pengeluaran</a>
        <a href="{{ sb_url('expense-categories.index') }}" class="sb-sublink {{ request()->routeIs('expense-categories.*') ? 'active' : '' }} {{ \Route::has('expense-categories.index') ? '' : 'soon' }}">Kategori Biaya</a>
      </div>
    </div>
  </div>

  {{-- ===== PERBANKAN — PLATINUM/GOLD ===== --}}
  @php
    $locked4 = !$hasFeature('perbankan');
    $g4 = request()->routeIs(['reconciliation.*','bank-mutations.*']);
  @endphp
  <div class="sb-accordion {{ $g4 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <span class="sb-link-main">
        <svg class="icon"><use href="#ic-bank"/></svg>
        <span class="sb-link-text">Perbankan</span>
      </span>
      <span class="sb-link-end">
        @if($locked4)
          <span class="badge badge-lock"><svg class="icon-lock"><use href="#ic-lock"/></svg><span>Upgrade</span></span>
        @endif
        <svg class="icon chevron"><use href="#ic-chevron"/></svg>
      </span>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        @if($locked4)
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Rekonsiliasi Bank</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Mutasi Rekening</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
        @else
          <a href="{{ sb_url('reconciliation.index') }}" class="sb-sublink {{ request()->routeIs('reconciliation.*') ? 'active' : '' }} {{ \Route::has('reconciliation.index') ? '' : 'soon' }}">Rekonsiliasi Bank</a>
          <a href="{{ sb_url('bank-mutations.index') }}" class="sb-sublink {{ request()->routeIs('bank-mutations.*') ? 'active' : '' }} {{ \Route::has('bank-mutations.index') ? '' : 'soon' }}">Mutasi Rekening</a>
        @endif
      </div>
    </div>
  </div>

  {{-- ===== LAPORAN — PLATINUM/GOLD ===== --}}
  @php
    $locked5 = !$hasFeature('laporan');
    $g5 = request()->routeIs(['laba-rugi.*','neraca.*','cash-flow.*','ledger.*']);
  @endphp
  <div class="sb-accordion {{ $g5 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <span class="sb-link-main">
        <svg class="icon"><use href="#ic-trending"/></svg>
        <span class="sb-link-text">Laporan</span>
      </span>
      <span class="sb-link-end">
        @if($locked5)
          <span class="badge badge-lock"><svg class="icon-lock"><use href="#ic-lock"/></svg><span>Upgrade</span></span>
        @endif
        <svg class="icon chevron"><use href="#ic-chevron"/></svg>
      </span>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        @if($locked5)
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Laba Rugi</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Neraca</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Arus Kas</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Buku Besar</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
        @else
          <a href="{{ sb_url('laba-rugi.index') }}" class="sb-sublink {{ request()->routeIs('laba-rugi.*') ? 'active' : '' }} {{ \Route::has('laba-rugi.index') ? '' : 'soon' }}">Laba Rugi</a>
          <a href="{{ sb_url('neraca.index') }}" class="sb-sublink {{ request()->routeIs('neraca.*') ? 'active' : '' }} {{ \Route::has('neraca.index') ? '' : 'soon' }}">Neraca</a>
          <a href="{{ sb_url('cash-flow.index') }}" class="sb-sublink {{ request()->routeIs('cash-flow.*') ? 'active' : '' }} {{ \Route::has('cash-flow.index') ? '' : 'soon' }}">Arus Kas</a>
          <a href="{{ sb_url('ledger.index') }}" class="sb-sublink {{ request()->routeIs('ledger.*') ? 'active' : '' }} {{ \Route::has('ledger.index') ? '' : 'soon' }}">Buku Besar</a>
        @endif
      </div>
    </div>
  </div>

  {{-- ===== INVENTARIS — PLATINUM/GOLD ===== --}}
  @php
    $locked6 = !$hasFeature('inventaris');
    $g6 = request()->routeIs(['inventory.*','cogs.*']);
  @endphp
  <div class="sb-accordion {{ $g6 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <span class="sb-link-main">
        <svg class="icon"><use href="#ic-briefcase"/></svg>
        <span class="sb-link-text">Inventaris</span>
      </span>
      <span class="sb-link-end">
        @if($locked6)
          <span class="badge badge-lock"><svg class="icon-lock"><use href="#ic-lock"/></svg><span>Upgrade</span></span>
        @endif
        <svg class="icon chevron"><use href="#ic-chevron"/></svg>
      </span>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        @if($locked6)
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Stok Barang</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Harga Pokok Penjualan (HPP)</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
        @else
          <a href="{{ sb_url('inventory.index') }}" class="sb-sublink {{ request()->routeIs('inventory.*') ? 'active' : '' }} {{ \Route::has('inventory.index') ? '' : 'soon' }}">Stok Barang</a>
          <a href="{{ sb_url('cogs.index') }}" class="sb-sublink {{ request()->routeIs('cogs.*') ? 'active' : '' }} {{ \Route::has('cogs.index') ? '' : 'soon' }}">Harga Pokok Penjualan (HPP)</a>
        @endif
      </div>
    </div>
  </div>

  {{-- ===== PAYROLL — GOLD ONLY ===== --}}
  @php
    $locked7 = !$hasFeature('payroll');
    $g7 = request()->routeIs(['payroll.*','employees.*']);
  @endphp
  <div class="sb-accordion {{ $g7 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <span class="sb-link-main">
        <svg class="icon"><use href="#ic-users"/></svg>
        <span class="sb-link-text">Payroll</span>
      </span>
      <span class="sb-link-end">
        @if($locked7)
          <span class="badge badge-lock"><svg class="icon-lock"><use href="#ic-lock"/></svg><span>Upgrade</span></span>
        @endif
        <svg class="icon chevron"><use href="#ic-chevron"/></svg>
      </span>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        @if($locked7)
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Slip Gaji</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Data Karyawan</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
        @else
          <a href="{{ sb_url('payroll.index') }}" class="sb-sublink {{ request()->routeIs('payroll.*') ? 'active' : '' }} {{ \Route::has('payroll.index') ? '' : 'soon' }}">Slip Gaji</a>
          <a href="{{ sb_url('employees.index') }}" class="sb-sublink {{ request()->routeIs('employees.*') ? 'active' : '' }} {{ \Route::has('employees.index') ? '' : 'soon' }}">Data Karyawan</a>
        @endif
      </div>
    </div>
  </div>

  {{-- ===== PAJAK — GOLD ONLY ===== --}}
  @php
    $locked8 = !$hasFeature('pajak');
    $g8 = request()->routeIs(['taxes.*','tax-calendar.*']);
  @endphp
  <div class="sb-accordion {{ $g8 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <span class="sb-link-main">
        <svg class="icon"><use href="#ic-building"/></svg>
        <span class="sb-link-text">Pajak</span>
      </span>
      <span class="sb-link-end">
        @if($locked8)
          <span class="badge badge-lock"><svg class="icon-lock"><use href="#ic-lock"/></svg><span>Upgrade</span></span>
        @else
          <span class="badge">1</span>
        @endif
        <svg class="icon chevron"><use href="#ic-chevron"/></svg>
      </span>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        @if($locked8)
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>PPh</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>PPN</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Kalender Pajak</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
        @else
          <a href="{{ sb_url('taxes.pph') }}" class="sb-sublink {{ request()->routeIs('taxes.pph') ? 'active' : '' }} {{ \Route::has('taxes.pph') ? '' : 'soon' }}">PPh</a>
          <a href="{{ sb_url('taxes.ppn') }}" class="sb-sublink {{ request()->routeIs('taxes.ppn') ? 'active' : '' }} {{ \Route::has('taxes.ppn') ? '' : 'soon' }}">PPN</a>
          <a href="{{ sb_url('tax-calendar.index') }}" class="sb-sublink {{ request()->routeIs('tax-calendar.*') ? 'active' : '' }} {{ \Route::has('tax-calendar.index') ? '' : 'soon' }}">Kalender Pajak</a>
        @endif
      </div>
    </div>
  </div>

  {{-- ===== BUDGETING (single link) — GOLD ONLY ===== --}}
  <div class="sb-group-label">Keuangan</div>
  @php $locked9 = !$hasFeature('anggaran'); @endphp
  @if($locked9)
    <a href="{{ route('pricing.index') }}" class="sb-link locked">
      <span class="sb-link-main">
        <svg class="icon"><use href="#ic-target"/></svg>
        <span class="sb-link-text">Anggaran &amp; Forecasting</span>
      </span>
      <span class="sb-link-end">
        <svg class="icon-lock"><use href="#ic-lock"/></svg>
      </span>
    </a>
  @else
    <a href="{{ sb_url('budgets.index') }}" class="sb-link {{ request()->routeIs('budgets.*') ? 'active' : '' }} {{ \Route::has('budgets.index') ? '' : 'soon' }}">
      <span class="sb-link-main">
        <svg class="icon"><use href="#ic-target"/></svg>
        <span class="sb-link-text">Anggaran &amp; Forecasting</span>
      </span>
    </a>
  @endif

  {{-- ===== LAINNYA ===== --}}
  <div class="sb-group-label">Lainnya</div>
  @php
    $lockedTeam = !$hasFeature('multi_user');
    $g9 = request()->routeIs(['team-members.*','integrations.*','security.*','profile.*']);
  @endphp
  <div class="sb-accordion {{ $g9 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <span class="sb-link-main">
        <svg class="icon"><use href="#ic-shield"/></svg>
        <span class="sb-link-text">Pengaturan</span>
      </span>
      <span class="sb-link-end">
        <svg class="icon chevron"><use href="#ic-chevron"/></svg>
      </span>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        @if($lockedTeam)
          <a href="{{ route('pricing.index') }}" class="sb-sublink locked"><span>Multi-User &amp; Hak Akses</span><svg class="icon-lock-sm"><use href="#ic-lock"/></svg></a>
        @else
          <a href="{{ sb_url('team-members.index') }}" class="sb-sublink {{ request()->routeIs('team-members.*') ? 'active' : '' }} {{ \Route::has('team-members.index') ? '' : 'soon' }}">Multi-User &amp; Hak Akses</a>
        @endif
        <a href="{{ sb_url('integrations.index') }}" class="sb-sublink {{ request()->routeIs('integrations.*') ? 'active' : '' }} {{ \Route::has('integrations.index') ? '' : 'soon' }}">Integrasi</a>
        <a href="{{ sb_url('security.index') }}" class="sb-sublink {{ request()->routeIs('security.*') ? 'active' : '' }} {{ \Route::has('security.index') ? '' : 'soon' }}">Keamanan</a>
        <a href="{{ sb_url('profile.edit') }}" class="sb-sublink {{ request()->routeIs('profile.edit') ? 'active' : '' }} {{ \Route::has('profile.edit') ? '' : 'soon' }}">Profil Saya</a>
      </div>
    </div>
  </div>

  <div class="sb-bottom">
    <div class="sb-plan">
      <div class="lbl">Paket Aktif</div>
      <div class="name">
        {{ ucfirst($currentPlan) }}
        @if($currentPlan !== 'gold')
          <span class="plan-dot"></span>
        @endif
      </div>
      <a href="{{ route('pricing.index') }}">
        {{ $currentPlan === 'gold' ? 'Kelola paket' : 'Upgrade paket' }} →
      </a>
    </div>
  </div>
</aside>

<style>
  /*
    CATATAN: style dasar .sidebar, .sb-logo, .sb-link, .sb-group-label, .sb-bottom, .sb-plan
    SUDAH didefinisikan lengkap di layouts/app.blade.php.
    File ini HANYA berisi style tambahan untuk accordion/submenu/lock, plus override khusus
    wordmark logo (font, ukuran, jarak huruf) supaya tidak terjadi duplikasi/konflik CSS.
  */

  /* ===== WORDMARK: rapat, tanpa jarak, font lebih tegas/profesional ===== */
  .sb-logo{
    align-items: center;
    gap: 12px;
  }
  .logo-mark{
    width: 38px;
    height: 38px;
    border-radius: 12px;
    padding: 6px;
  }
  .sb-wordmark{
    font-family: 'Inter', sans-serif;
    font-weight: 800;
    font-size: 17px;
    letter-spacing: -0.01em;
    white-space: nowrap;
    word-spacing: 0;
    display: inline-flex;
    align-items: baseline;
    color: var(--text);
  }
  .sb-wordmark .grad{
    color: var(--emerald);
    margin: 0;
    padding: 0;
    letter-spacing: inherit;
  }

  /* ===== LAYOUT DASAR sb-link / sb-parent: dibagi jadi 2 zona ===== */
  /* Zona kiri (icon + teks) boleh menyusut & ellipsis, zona kanan (badge+chevron) FIXED */
  .sb-link,
  .sb-link.sb-parent{
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    width: 100%;
  }

  .sb-link-main{
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0; /* penting supaya text-overflow bekerja di flex child */
    flex: 1 1 auto;
  }
  .sb-link-main .icon{
    flex-shrink: 0;
    width: 17px;
    height: 17px;
  }
  .sb-link-text{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    min-width: 0;
  }

  .sb-link-end{
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
  }

  .sb-accordion{ margin-bottom:2px; }
  .sb-parent{ background:none; border:none; cursor:pointer; text-align:left; }
  .sb-parent .chevron{ width:14px; height:14px; transition: transform .25s ease; flex-shrink:0; }
  .sb-accordion.open > .sb-parent .chevron{ transform: rotate(180deg); }
  .sb-accordion.open > .sb-parent{ color:var(--text); }

  .sb-submenu{
    display:grid;
    grid-template-rows: 0fr;
    transition: grid-template-rows .28s ease;
  }
  .sb-submenu-inner{
    overflow:hidden;
    min-height:0;
    margin-left:14px;
    padding-left:15px;
    border-left:1px solid var(--border);
    opacity:0;
    transition: opacity .18s ease;
  }
  .sb-accordion.open .sb-submenu{ grid-template-rows:1fr; }
  .sb-accordion.open .sb-submenu-inner{ opacity:1; transition: opacity .25s ease .08s; }

  .sb-sublink{
    display:flex;
    align-items:center;
    justify-content: space-between;
    gap: 8px;
    padding:9px 12px;
    border-radius:10px;
    font-size:13px;
    color:var(--text-mute);
    transition: all .2s ease;
    margin:1px 0;
  }
  .sb-sublink > span:first-child{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    min-width: 0;
  }
  .sb-sublink:hover{ color:var(--text); background:var(--surface); }
  .sb-sublink.active{ color:var(--emerald); background:rgba(var(--emerald-rgb),0.1); font-weight:600; }

  .sb-sublink.soon{
    color: var(--text-faint);
    cursor: default;
    pointer-events: none;
  }
  .sb-sublink.soon::after{
    content: "Segera";
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .03em;
    color: var(--text-faint);
    background: var(--surface-strong);
    padding: 2px 7px;
    border-radius: 100px;
    flex-shrink: 0;
  }

  /* ===== LOCK STYLING (SVG icon, bukan emoji) ===== */
  .badge-lock{
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, rgba(245,158,11,0.2), rgba(245,158,11,0.1));
    color: #fbbf24;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 10px 4px 8px;
    border-radius: 100px;
    white-space: nowrap;
    flex-shrink: 0;
    border: 1px solid rgba(245,158,11,0.25);
    box-shadow: 0 2px 8px rgba(245,158,11,0.15);
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.04em;
  }
  .badge-lock:hover{
    transform: scale(1.05);
    background: linear-gradient(135deg, rgba(245,158,11,0.3), rgba(245,158,11,0.15));
    box-shadow: 0 4px 12px rgba(245,158,11,0.25);
    border-color: rgba(245,158,11,0.4);
  }
  .badge-lock .icon-lock{
    width: 11px;
    height: 11px;
    flex-shrink: 0;
    color: #fbbf24;
    filter: drop-shadow(0 1px 2px rgba(245,158,11,0.3));
  }
  .badge-lock span{
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
  }

  .icon-lock{
    width: 11px;
    height: 11px;
    flex-shrink: 0;
  }
  .icon-lock-sm{
    width: 12px;
    height: 12px;
    opacity: .7;
    flex-shrink: 0;
  }

  .sb-sublink.locked{
    color: var(--text-faint);
  }
  .sb-sublink.locked:hover{
    color: #F0A83C;
    background: rgba(240,168,60,0.08);
  }
  a.sb-link.locked{
    color: var(--text-faint);
  }
  a.sb-link.locked:hover{ color: #F0A83C; }
  a.sb-link.locked .icon-lock{ color: #F0A83C; }

  .plan-dot{
    display:inline-block; width:6px; height:6px; border-radius:50%;
    background:#F0A83C; margin-left:6px;
  }

  /* Scrollbar tipis khusus sidebar, mengikuti tema */
  .sidebar{
    scrollbar-width: thin;
    scrollbar-color: var(--border-hover) transparent;
  }
  .sidebar::-webkit-scrollbar{ width: 5px; }
  .sidebar::-webkit-scrollbar-thumb{ background: var(--border-hover); border-radius: 100px; }
  .sidebar::-webkit-scrollbar-track{ background: transparent; }

  /* ===== TOMBOL UPGRADE DI BAWAH ===== */
  .sb-plan a{
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #0f172a;
    text-decoration: none;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(245,158,11,0.2);
    margin-top: 6px;
    letter-spacing: 0.02em;
  }
  .sb-plan a:hover{
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(245,158,11,0.35);
  }
</style>

<script>
  document.querySelectorAll('[data-acc-toggle]').forEach(function(btn){
    btn.addEventListener('click', function(){
      var acc = btn.closest('.sb-accordion');
      var wasOpen = acc.classList.contains('open');
      document.querySelectorAll('.sb-accordion.open').forEach(function(el){
        if(el !== acc) el.classList.remove('open');
      });
      acc.classList.toggle('open', !wasOpen);
    });
  });
</script>