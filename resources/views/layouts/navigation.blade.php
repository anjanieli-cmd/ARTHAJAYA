<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <span class="logo-mark">
      <img src="{{ asset('logos.png') }}" alt="{{ $company->name ?? 'Arthajaya' }}">
    </span>
    Artha<span class="dot">jaya</span>
  </div>

  @php
    // Helper lokal: kembalikan URL kalau route ada, atau '#' kalau belum dibuat.
    // Juga tandai link yang belum aktif supaya user tahu fitur belum tersedia.
    if (!function_exists('sb_url')) {
        function sb_url(string $name, array $params = []): string {
            return \Route::has($name) ? route($name, $params) : '#';
        }
    }
  @endphp

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
        <a href="{{ sb_url('invoices.index') }}" class="sb-sublink {{ request()->routeIs('invoices.*') ? 'active' : '' }} {{ \Route::has('invoices.index') ? '' : 'soon' }}">Semua Faktur</a>
        <a href="{{ sb_url('quotes.index') }}" class="sb-sublink {{ request()->routeIs('quotes.*') ? 'active' : '' }} {{ \Route::has('quotes.index') ? '' : 'soon' }}">Penawaran / Quotation</a>
        <a href="{{ sb_url('clients.index') }}" class="sb-sublink {{ request()->routeIs('clients.*') ? 'active' : '' }} {{ \Route::has('clients.index') ? '' : 'soon' }}">Klien</a>
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
        <a href="{{ sb_url('receivables.index') }}" class="sb-sublink {{ request()->routeIs('receivables.*') ? 'active' : '' }} {{ \Route::has('receivables.index') ? '' : 'soon' }}">Piutang Usaha (AR)</a>
        <a href="{{ sb_url('payables.index') }}" class="sb-sublink {{ request()->routeIs('payables.*') ? 'active' : '' }} {{ \Route::has('payables.index') ? '' : 'soon' }}">Utang Usaha (AP)</a>
        <a href="{{ sb_url('aging.index') }}" class="sb-sublink {{ request()->routeIs('aging.*') ? 'active' : '' }} {{ \Route::has('aging.index') ? '' : 'soon' }}">Aging Report (30/60/90 hari)</a>
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
        <a href="{{ sb_url('expenses.index') }}" class="sb-sublink {{ request()->routeIs('expenses.*') ? 'active' : '' }} {{ \Route::has('expenses.index') ? '' : 'soon' }}">Pengeluaran</a>
        <a href="{{ sb_url('expense-categories.index') }}" class="sb-sublink {{ request()->routeIs('expense-categories.*') ? 'active' : '' }} {{ \Route::has('expense-categories.index') ? '' : 'soon' }}">Kategori Biaya</a>
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
        <a href="{{ sb_url('reconciliation.index') }}" class="sb-sublink {{ request()->routeIs('reconciliation.*') ? 'active' : '' }} {{ \Route::has('reconciliation.index') ? '' : 'soon' }}">Rekonsiliasi Bank</a>
        <a href="{{ sb_url('bank-mutations.index') }}" class="sb-sublink {{ request()->routeIs('bank-mutations.*') ? 'active' : '' }} {{ \Route::has('bank-mutations.index') ? '' : 'soon' }}">Mutasi Rekening</a>
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
        <a href="{{ sb_url('reports.profit-loss') }}" class="sb-sublink {{ request()->routeIs('reports.profit-loss') ? 'active' : '' }} {{ \Route::has('reports.profit-loss') ? '' : 'soon' }}">Laba Rugi</a>
        <a href="{{ sb_url('reports.balance-sheet') }}" class="sb-sublink {{ request()->routeIs('reports.balance-sheet') ? 'active' : '' }} {{ \Route::has('reports.balance-sheet') ? '' : 'soon' }}">Neraca</a>
        <a href="{{ sb_url('reports.cash-flow') }}" class="sb-sublink {{ request()->routeIs('reports.cash-flow') ? 'active' : '' }} {{ \Route::has('reports.cash-flow') ? '' : 'soon' }}">Arus Kas</a>
        <a href="{{ sb_url('reports.general-ledger') }}" class="sb-sublink {{ request()->routeIs('reports.general-ledger') ? 'active' : '' }} {{ \Route::has('reports.general-ledger') ? '' : 'soon' }}">Buku Besar</a>
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
        <a href="{{ sb_url('inventory.index') }}" class="sb-sublink {{ request()->routeIs('inventory.*') ? 'active' : '' }} {{ \Route::has('inventory.index') ? '' : 'soon' }}">Stok Barang</a>
        <a href="{{ sb_url('cogs.index') }}" class="sb-sublink {{ request()->routeIs('cogs.*') ? 'active' : '' }} {{ \Route::has('cogs.index') ? '' : 'soon' }}">Harga Pokok Penjualan (HPP)</a>
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
        <a href="{{ sb_url('payroll.index') }}" class="sb-sublink {{ request()->routeIs('payroll.*') ? 'active' : '' }} {{ \Route::has('payroll.index') ? '' : 'soon' }}">Slip Gaji</a>
        <a href="{{ sb_url('employees.index') }}" class="sb-sublink {{ request()->routeIs('employees.*') ? 'active' : '' }} {{ \Route::has('employees.index') ? '' : 'soon' }}">Data Karyawan</a>
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
        <a href="{{ sb_url('taxes.pph') }}" class="sb-sublink {{ request()->routeIs('taxes.pph') ? 'active' : '' }} {{ \Route::has('taxes.pph') ? '' : 'soon' }}">PPh</a>
        <a href="{{ sb_url('taxes.ppn') }}" class="sb-sublink {{ request()->routeIs('taxes.ppn') ? 'active' : '' }} {{ \Route::has('taxes.ppn') ? '' : 'soon' }}">PPN</a>
        <a href="{{ sb_url('tax-calendar.index') }}" class="sb-sublink {{ request()->routeIs('tax-calendar.*') ? 'active' : '' }} {{ \Route::has('tax-calendar.index') ? '' : 'soon' }}">Kalender Pajak</a>
      </div>
    </div>
  </div>

  {{-- ===== BUDGETING (single link) ===== --}}
  <div class="sb-group-label">Keuangan</div>
  <a href="{{ sb_url('budgets.index') }}" class="sb-link {{ request()->routeIs('budgets.*') ? 'active' : '' }} {{ \Route::has('budgets.index') ? '' : 'soon' }}">
    <svg class="icon"><use href="#ic-target"/></svg> Anggaran &amp; Forecasting
  </a>

  {{-- ===== LAINNYA ===== --}}
  <div class="sb-group-label">Lainnya</div>
  {{-- CATATAN: menu "Multi-User & Hak Akses" memakai route 'team-members.*',
       bukan 'users.*', sesuai nama resource yang sudah dibuat. --}}
  @php $g9 = request()->routeIs(['team-members.*','integrations.*','security.*','profile.*']); @endphp
  <div class="sb-accordion {{ $g9 ? 'open' : '' }}">
    <button type="button" class="sb-link sb-parent" data-acc-toggle>
      <svg class="icon"><use href="#ic-shield"/></svg> Pengaturan
      <svg class="icon chevron"><use href="#ic-chevron"/></svg>
    </button>
    <div class="sb-submenu">
      <div class="sb-submenu-inner">
        <a href="{{ sb_url('team-members.index') }}" class="sb-sublink {{ request()->routeIs('team-members.*') ? 'active' : '' }} {{ \Route::has('team-members.index') ? '' : 'soon' }}">Multi-User &amp; Hak Akses</a>
        <a href="{{ sb_url('integrations.index') }}" class="sb-sublink {{ request()->routeIs('integrations.*') ? 'active' : '' }} {{ \Route::has('integrations.index') ? '' : 'soon' }}">Integrasi</a>
        <a href="{{ sb_url('security.index') }}" class="sb-sublink {{ request()->routeIs('security.*') ? 'active' : '' }} {{ \Route::has('security.index') ? '' : 'soon' }}">Keamanan</a>
        <a href="{{ sb_url('profile.edit') }}" class="sb-sublink {{ request()->routeIs('profile.edit') ? 'active' : '' }} {{ \Route::has('profile.edit') ? '' : 'soon' }}">Profil Saya</a>
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
  /* ===== SIDEBAR BASE (mandiri — supaya partial ini tampil benar di halaman manapun ia di-include) ===== */
  .sidebar{
    width:262px; flex-shrink:0; background:var(--surface); border-right:1px solid var(--border);
    padding:22px 16px; display:flex; flex-direction:column; gap:2px; position:sticky; top:0; height:100vh; overflow-y:auto;
  }
  .sb-logo{ display:flex; align-items:center; gap:10px; font-family:'Space Grotesk'; font-weight:700; font-size:17px; padding:6px 10px 22px; }
  .logo-mark{ width:28px; height:28px; border-radius:8px; background:var(--surface-strong); border:1px solid var(--border-hover); display:flex; align-items:center; justify-content:center; overflow:hidden; padding:3px; flex-shrink:0; }
  .logo-mark img{ width:100%; height:100%; object-fit:contain; display:block; }
  .sb-logo .dot{ color:var(--emerald); }
  .sb-group-label{ font-size:11px; text-transform:uppercase; letter-spacing:.08em; color:var(--text-faint); padding:16px 12px 8px; }
  .sb-link{ display:flex; align-items:center; gap:11px; padding:10px 12px; border-radius:11px; font-size:13.5px; font-weight:500; color:var(--text-mute); transition:all .2s ease; }
  .sb-link .icon{ width:16px; height:16px; flex-shrink:0; }
  .sb-link:hover{ background:var(--surface-strong); color:var(--text); }
  .sb-link.active{ background:rgba(var(--emerald-rgb),0.1); color:var(--emerald); }
  .sb-link .badge{ margin-left:auto; background:var(--emerald); color:#052117; font-size:10.5px; font-weight:700; padding:2px 7px; border-radius:100px; }
  .sb-bottom{ margin-top:auto; padding-top:16px; }
  .sb-plan{ background:var(--surface-strong); border:1px solid var(--border); border-radius:14px; padding:14px; }
  .sb-plan .lbl{ font-size:11px; color:var(--text-faint); }
  .sb-plan .name{ font-size:13.5px; font-weight:600; margin:3px 0 8px; }
  .sb-plan a{ font-size:12px; color:var(--emerald); font-weight:600; }

  @media (max-width: 900px){
    .sidebar{ display:none; }
  }

  /* ===== ACCORDION / SUBMENU ===== */
  .sb-accordion{ margin-bottom:2px; }
  .sb-parent{ width:100%; background:none; border:none; cursor:pointer; text-align:left; }
  .sb-parent .chevron{ margin-left:auto; width:14px; height:14px; transition: transform .25s ease; flex-shrink:0; }
  .sb-parent .badge{ margin-left:auto; }
  .sb-parent .badge + .chevron{ margin-left:8px; }
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
    display:block;
    padding:9px 12px;
    border-radius:10px;
    font-size:13px;
    color:var(--text-mute);
    transition: all .2s ease;
    margin:1px 0;
    position:relative;
  }
  .sb-sublink:hover{ color:var(--text); background:var(--surface); }
  .sb-sublink.active{ color:var(--emerald); background:rgba(var(--emerald-rgb),0.1); font-weight:600; }

  /* Link ke fitur yang route-nya belum dibuat: nonaktifkan klik & beri label "Segera" */
  .sb-sublink.soon{
    color: var(--text-faint);
    cursor: default;
    pointer-events: none;
  }
  .sb-sublink.soon::after{
    content: "Segera";
    float: right;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .03em;
    color: var(--text-faint);
    background: var(--surface-strong);
    padding: 2px 7px;
    border-radius: 100px;
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