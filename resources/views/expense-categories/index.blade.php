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

    $totalKategori     = count($categories);
    $totalSemuaBiaya   = collect($categories)->sum('total');
    $kategoriTerbesar  = collect($categories)->sortByDesc('total')->first();
  @endphp

  <div class="page-head">
    <div>
      <div class="eyebrow"><svg class="icon" style="width:13px;height:13px;"><use href="#ic-trending-down"/></svg> Pembelian &amp; Biaya</div>
      <h1>Kategori Biaya</h1>
      <p>Kelompokkan pengeluaran usaha agar laporan lebih rapi — {{ $totalKategori }} kategori aktif.</p>
    </div>
    <div class="actions">
      <a href="{{ Route::has('expenses.index') ? route('expenses.index') : '#' }}" class="btn btn-outline">
        <svg class="icon"><use href="#ic-trending-down"/></svg> Lihat Pengeluaran
      </a>
      <a href="#" class="btn btn-primary">
        <svg class="icon"><use href="#ic-plus"/></svg> Kategori Baru
      </a>
    </div>
  </div>

  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-briefcase"/></svg></div></div>
      <div class="lbl">Jumlah Kategori</div>
      <div class="val mono">{{ $totalKategori }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-trending-down"/></svg></div></div>
      <div class="lbl">Total Biaya Semua Kategori</div>
      <div class="val mono">{{ $currencySymbol }}{{ number_format($totalSemuaBiaya, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-trending"/></svg></div></div>
      <div class="lbl">Kategori Terbesar</div>
      <div class="val">{{ $kategoriTerbesar['name'] ?? '-' }}</div>
    </div>
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Daftar Kategori</h3>
      <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}" class="sub-link">Buku besar biaya <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
    </div>
    <table class="tx-table">
      <thead>
        <tr>
          <th>Nama Kategori</th>
          <th>Deskripsi</th>
          <th style="text-align:center">Transaksi</th>
          <th style="text-align:right">Total Biaya</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($categories as $c)
          <tr>
            <td>
              <div class="tx-who">
                <div class="tx-ic"><svg class="icon"><use href="#ic-briefcase"/></svg></div>
                <div class="tx-name">{{ $c['name'] }}</div>
              </div>
            </td>
            <td>{{ $c['desc'] }}</td>
            <td style="text-align:center">{{ $c['count'] }}</td>
            <td class="amt-cell neg">{{ $currencySymbol }}{{ number_format($c['total'], 0, ',', '.') }}</td>
            <td>
              <div class="row-actions">
                <a href="#">Edit</a>
                <a href="#">Hapus</a>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="5"><div class="empty-state">Belum ada kategori biaya.</div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</x-app-layout>