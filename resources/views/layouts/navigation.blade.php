<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <span class="logo-mark">
      <img src="{{ asset('logo.png') }}" alt="{{ $company->name ?? 'Arthajaya' }}">
    </span>
    Artha<span class="dot">jaya</span>
  </div>

  {{-- ===== DASHBOARD ===== --}}
  <div class="sb-group-label">Menu</div>
  <a href="{{ route('dashboard') }}" class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <svg class="icon"><use href="#ic-activity"/></svg> Dashboard
  </a>

  {{-- ===== PENJUALAN (dropdown) ===== --}}
  @php $g1 = request()->routeIs(['invoices.*','quotes.*','clients.*']); @endphp
  <div class="sb-accordion {{ $g1 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <svg class="icon"><use href="#ic-invoice"/></svg> Penjualan
      <span class="badge">3</span>
      <svg class="icon chevron"><use href="#ic-chevron"/></svg>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        <a href="{{ Route::has('invoices.index') ? route('invoices.index') : '#' }}" class="sb-sublink {{ request()->routeIs('invoices.*') ? 'active' : '' }}">Semua Faktur</a>
        <a href="{{ Route::has('quotes.index') ? route('quotes.index') : '#' }}" class="sb-sublink {{ request()->routeIs('quotes.*') ? 'active' : '' }}">Penawaran / Quotation</a>
        <a href="{{ Route::has('clients.index') ? route('clients.index') : '#' }}" class="sb-sublink {{ request()->routeIs('clients.*') ? 'active' : '' }}">Klien</a>
      </div>
    </div>
  </div>

  {{-- ===== PIUTANG & UTANG / AR-AP (dropdown) ===== --}}
  @php $g2 = request()->routeIs(['receivables.*','payables.*','aging.*']); @endphp
  <div class="sb-accordion {{ $g2 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <svg class="icon"><use href="#ic-receive"/></svg> Piutang &amp; Utang
      <svg class="icon chevron"><use href="#ic-chevron"/></svg>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        <a href="{{ route('receivables.index') }}" class="sb-sublink {{ request()->routeIs('receivables.*') ? 'active' : '' }}">Piutang Usaha (AR)</a>
        <a href="{{ route('payables.index') }}" class="sb-sublink {{ request()->routeIs('payables.*') ? 'active' : '' }}">Utang Usaha (AP)</a>
        <a href="{{ route('aging.index') }}" class="sb-sublink {{ request()->routeIs('aging.*') ? 'active' : '' }}">Aging Report (30/60/90 hari)</a>
      </div>
    </div>
  </div>

  {{-- ===== PEMBELIAN & BIAYA (dropdown) ===== --}}
  @php $g3 = request()->routeIs(['expenses.*','expense-categories.*']); @endphp
  <div class="sb-accordion {{ $g3 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <svg class="icon"><use href="#ic-trending-down"/></svg> Pembelian &amp; Biaya
      <svg class="icon chevron"><use href="#ic-chevron"/></svg>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
<<<<<<< HEAD
        <a href="{{ Route::has('expenses.index') ? route('expenses.index') : '#' }}" class="sb-sublink {{ request()->routeIs('expenses.*') ? 'active' : '' }}">Pengeluaran</a>
        <a href="{{ Route::has('expense-categories.index') ? route('expense-categories.index') : '#' }}" class="sb-sublink {{ request()->routeIs('expense-categories.*') ? 'active' : '' }}">Kategori Biaya</a>
=======
        <a href="{{ route('expenses.index') }}" class="sb-sublink {{ request()->routeIs('expenses.*') ? 'active' : '' }}">Pengeluaran</a>
        <a href="{{ route('expense-categories.index') }}" class="sb-sublink {{ request()->routeIs('expense-categories.*') ? 'active' : '' }}">Kategori Biaya</a>
>>>>>>> 70d67f7 (fix pengeluaran)
      </div>
    </div>
  </div>

  {{-- ===== PERBANKAN (dropdown) ===== --}}
  @php $g4 = request()->routeIs(['reconciliation.*','bank-mutations.*']); @endphp
  <div class="sb-accordion {{ $g4 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <svg class="icon"><use href="#ic-bank"/></svg> Perbankan
      <svg class="icon chevron"><use href="#ic-chevron"/></svg>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        <a href="{{ Route::has('reconciliation.index') ? route('reconciliation.index') : '#' }}" class="sb-sublink {{ request()->routeIs('reconciliation.*') ? 'active' : '' }}">Rekonsiliasi Bank</a>
        <a href="{{ Route::has('bank-mutations.index') ? route('bank-mutations.index') : '#' }}" class="sb-sublink {{ request()->routeIs('bank-mutations.*') ? 'active' : '' }}">Mutasi Rekening</a>
      </div>
    </div>
  </div>

  {{-- ===== LAPORAN (dropdown) ===== --}}
  @php $g5 = request()->routeIs(['reports.*']); @endphp
  <div class="sb-accordion {{ $g5 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <svg class="icon"><use href="#ic-trending"/></svg> Laporan
      <svg class="icon chevron"><use href="#ic-chevron"/></svg>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        <a href="{{ Route::has('reports.profit-loss') ? route('reports.profit-loss') : '#' }}" class="sb-sublink {{ request()->routeIs('reports.profit-loss') ? 'active' : '' }}">Laba Rugi</a>
        <a href="{{ Route::has('reports.balance-sheet') ? route('reports.balance-sheet') : '#' }}" class="sb-sublink {{ request()->routeIs('reports.balance-sheet') ? 'active' : '' }}">Neraca</a>
        <a href="{{ Route::has('reports.cash-flow') ? route('reports.cash-flow') : '#' }}" class="sb-sublink {{ request()->routeIs('reports.cash-flow') ? 'active' : '' }}">Arus Kas</a>
        <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}" class="sb-sublink {{ request()->routeIs('reports.general-ledger') ? 'active' : '' }}">Buku Besar</a>
      </div>
    </div>
  </div>

  {{-- ===== INVENTARIS (dropdown) ===== --}}
  @php $g6 = request()->routeIs(['inventory.*','cogs.*']); @endphp
  <div class="sb-accordion {{ $g6 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <svg class="icon"><use href="#ic-briefcase"/></svg> Inventaris
      <svg class="icon chevron"><use href="#ic-chevron"/></svg>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        <a href="{{ Route::has('inventory.index') ? route('inventory.index') : '#' }}" class="sb-sublink {{ request()->routeIs('inventory.*') ? 'active' : '' }}">Stok Barang</a>
        <a href="{{ Route::has('cogs.index') ? route('cogs.index') : '#' }}" class="sb-sublink {{ request()->routeIs('cogs.*') ? 'active' : '' }}">Harga Pokok Penjualan (HPP)</a>
      </div>
    </div>
  </div>

  {{-- ===== PAYROLL (dropdown) ===== --}}
  @php $g7 = request()->routeIs(['payroll.*','employees.*']); @endphp
  <div class="sb-accordion {{ $g7 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <svg class="icon"><use href="#ic-users"/></svg> Payroll
      <svg class="icon chevron"><use href="#ic-chevron"/></svg>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        <a href="{{ Route::has('payroll.index') ? route('payroll.index') : '#' }}" class="sb-sublink {{ request()->routeIs('payroll.*') ? 'active' : '' }}">Slip Gaji</a>
        <a href="{{ Route::has('employees.index') ? route('employees.index') : '#' }}" class="sb-sublink {{ request()->routeIs('employees.*') ? 'active' : '' }}">Data Karyawan</a>
      </div>
    </div>
  </div>

  {{-- ===== PAJAK (dropdown) ===== --}}
  @php $g8 = request()->routeIs(['taxes.*','tax-calendar.*']); @endphp
  <div class="sb-accordion {{ $g8 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <svg class="icon"><use href="#ic-building"/></svg> Pajak
      <span class="badge">1</span>
      <svg class="icon chevron"><use href="#ic-chevron"/></svg>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        <a href="{{ Route::has('taxes.pph') ? route('taxes.pph') : '#' }}" class="sb-sublink {{ request()->routeIs('taxes.pph') ? 'active' : '' }}">PPh</a>
        <a href="{{ Route::has('taxes.ppn') ? route('taxes.ppn') : '#' }}" class="sb-sublink {{ request()->routeIs('taxes.ppn') ? 'active' : '' }}">PPN</a>
        <a href="{{ Route::has('tax-calendar.index') ? route('tax-calendar.index') : '#' }}" class="sb-sublink {{ request()->routeIs('tax-calendar.*') ? 'active' : '' }}">Kalender Pajak</a>
      </div>
    </div>
  </div>

  {{-- ===== BUDGETING (single link) ===== --}}
  <div class="sb-group-label">Keuangan</div>
  <a href="{{ Route::has('budgets.index') ? route('budgets.index') : '#' }}" class="sb-link {{ request()->routeIs('budgets.*') ? 'active' : '' }}">
    <svg class="icon"><use href="#ic-target"/></svg> Anggaran &amp; Forecasting
  </a>

  {{-- ===== LAINNYA ===== --}}
  <div class="sb-group-label">Lainnya</div>
  @php $g9 = request()->routeIs(['users.*','integrations.*','security.*','profile.*']); @endphp
  <div class="sb-accordion {{ $g9 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <svg class="icon"><use href="#ic-shield"/></svg> Pengaturan
      <svg class="icon chevron"><use href="#ic-chevron"/></svg>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        <a href="{{ Route::has('users.index') ? route('users.index') : '#' }}" class="sb-sublink {{ request()->routeIs('users.*') ? 'active' : '' }}">Multi-User &amp; Hak Akses</a>
        <a href="{{ Route::has('integrations.index') ? route('integrations.index') : '#' }}" class="sb-sublink {{ request()->routeIs('integrations.*') ? 'active' : '' }}">Integrasi</a>
        <a href="{{ Route::has('security.index') ? route('security.index') : '#' }}" class="sb-sublink {{ request()->routeIs('security.*') ? 'active' : '' }}">Keamanan</a>
        <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}" class="sb-sublink {{ request()->routeIs('profile.edit') ? 'active' : '' }}">Profil Saya</a>
      </div>
    </div>
  </div>

  <div class="sb-bottom">
    <div class="sb-plan">
      <div class="lbl">Perusahaan Aktif</div>
      <div class="name">{{ $company->name ?? 'Belum diatur' }}</div>
      <a href="#">Kelola perusahaan →</a>
    </div>
  </div>
</aside>

<style>
  .sb-accordion{ margin-bottom:2px; }
  .sb-parent{ width:100%; background:none; border:none; cursor:pointer; text-align:left; }
  .sb-parent .chevron{ margin-left:auto; width:14px; height:14px; transition: transform .25s ease; flex-shrink:0; }
  .sb-parent .badge{ margin-left:auto; }
  .sb-parent .badge + .chevron{ margin-left:8px; }
  .sb-accordion.open > .sb-parent .chevron{ transform: rotate(180deg); }
  .sb-accordion.open > .sb-parent{ color:var(--text); }

  /* ===== FIX: wrapper tunggal per grid row, biar collapse-nya bener ===== */
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
    display:block;
    padding:9px 12px;
    border-radius:10px;
    font-size:13px;
    color:var(--text-mute);
    transition: all .2s ease;
    margin:1px 0;
  }
  .sb-sublink:hover{ color:var(--text); background:var(--surface); }
  .sb-sublink.active{ color:var(--emerald); background:rgba(var(--emerald-rgb),0.1); font-weight:600; }
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