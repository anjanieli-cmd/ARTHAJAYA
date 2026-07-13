<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <span class="logo-mark">
      <img src="{{ asset('logo.png') }}" alt="{{ $company->name ?? 'Arthajaya' }}">
    </span>
    Artha<span class="dot">jaya</span>
  </div>

  <div class="sb-group-label">Menu</div>
  <a href="{{ route('dashboard') }}" class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <svg class="icon"><use href="#ic-activity"/></svg> Dashboard
  </a>
  <a href="#" class="sb-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
    <svg class="icon"><use href="#ic-invoice"/></svg> Faktur
    <span class="badge">3</span>
  </a>
  <a href="#" class="sb-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
    <svg class="icon"><use href="#ic-users"/></svg> Klien
  </a>
  <a href="#" class="sb-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
    <svg class="icon"><use href="#ic-doc"/></svg> Transaksi
  </a>
  <a href="#" class="sb-link {{ request()->routeIs('reconciliation.*') ? 'active' : '' }}">
    <svg class="icon"><use href="#ic-bank"/></svg> Rekonsiliasi Bank
  </a>
  <a href="#" class="sb-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
    <svg class="icon"><use href="#ic-trending"/></svg> Laporan
  </a>

  <div class="sb-group-label">Lainnya</div>
  <a href="{{ route('profile.edit') }}" class="sb-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
    <svg class="icon"><use href="#ic-settings"/></svg> Pengaturan
  </a>

  <div class="sb-bottom">
    <div class="sb-plan">
      <div class="lbl">Perusahaan Aktif</div>
      <div class="name">{{ $company->name ?? 'Belum diatur' }}</div>
      <a href="#">Kelola perusahaan →</a>
    </div>
  </div>
</aside>