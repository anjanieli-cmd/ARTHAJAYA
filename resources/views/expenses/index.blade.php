<x-app-layout>
  <x-slot name="title">Pengeluaran</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY - ganti dengan query Expense model nanti
    $expenses = [
        ['desc' => 'Beli kain mori 50 meter',            'kategori' => 'Bahan Baku',     'date' => '01 Jul 2026', 'status' => 'lunas',   'amount' => 2500000],
        ['desc' => 'Ongkir bahan dari Solo',              'kategori' => 'Transportasi',   'date' => '03 Jul 2026', 'status' => 'lunas',   'amount' => 350000],
        ['desc' => 'Tagihan listrik workshop',            'kategori' => 'Utilitas',       'date' => '06 Jul 2026', 'status' => 'pending', 'amount' => 820000],
        ['desc' => 'Upah pengrajin batik tulis',          'kategori' => 'Produksi',       'date' => '08 Jul 2026', 'status' => 'lunas',   'amount' => 4200000],
        ['desc' => 'Iklan Instagram koleksi baru',        'kategori' => 'Marketing',      'date' => '10 Jul 2026', 'status' => 'pending', 'amount' => 600000],
        ['desc' => 'Beli pewarna alami indigo',           'kategori' => 'Bahan Baku',     'date' => '12 Jul 2026', 'status' => 'lunas',   'amount' => 975000],
    ];

    $statusLabel = ['lunas' => 'Lunas', 'pending' => 'Pending'];
    $statusPill  = ['lunas' => 'paid', 'pending' => 'pending'];

    $totalPengeluaran = collect($expenses)->sum('amount');
    $totalLunas       = collect($expenses)->where('status', 'lunas')->sum('amount');
    $totalPending     = collect($expenses)->where('status', 'pending')->sum('amount');
    $countPending     = collect($expenses)->where('status', 'pending')->count();
  @endphp

  <div class="page-head">
    <div>
      <div class="eyebrow"><svg class="icon" style="width:13px;height:13px;"><use href="#ic-trending-down"/></svg> Pembelian &amp; Biaya</div>
      <h1>Pengeluaran</h1>
      <p>Catatan seluruh biaya dan pembelian usaha — {{ count($expenses) }} transaksi.</p>
    </div>
    <div class="actions">
      <a href="{{ Route::has('expense-categories.index') ? route('expense-categories.index') : '#' }}" class="btn btn-outline">
        <svg class="icon"><use href="#ic-briefcase"/></svg> Kategori Biaya
      </a>
      <a href="#" class="btn btn-primary">
        <svg class="icon"><use href="#ic-plus"/></svg> Catat Pengeluaran
      </a>
    </div>
  </div>

  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-trending-down"/></svg></div></div>
      <div class="lbl">Total Pengeluaran</div>
      <div class="val mono">{{ $currencySymbol }}{{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-invoice"/></svg></div></div>
      <div class="lbl">Sudah Dibayar</div>
      <div class="val mono">{{ $currencySymbol }}{{ number_format($totalLunas, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-briefcase"/></svg></div><div class="chg down">{{ $countPending }} transaksi</div></div>
      <div class="lbl">Menunggu Pembayaran</div>
      <div class="val mono">{{ $currencySymbol }}{{ number_format($totalPending, 0, ',', '.') }}</div>
    </div>
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Daftar Pengeluaran</h3>
      <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}" class="sub-link">Buku besar biaya <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
    </div>
    <table class="tx-table">
      <thead>
        <tr>
          <th>Deskripsi</th>
          <th>Kategori</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th style="text-align:right">Jumlah</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($expenses as $e)
          <tr>
            <td>
              <div class="tx-who">
                <div class="tx-ic"><svg class="icon"><use href="#ic-invoice"/></svg></div>
                <div class="tx-name">{{ $e['desc'] }}</div>
              </div>
            </td>
            <td>{{ $e['kategori'] }}</td>
            <td>{{ $e['date'] }}</td>
            <td><span class="status-pill {{ $statusPill[$e['status']] }}">{{ $statusLabel[$e['status']] }}</span></td>
            <td class="amt-cell neg">{{ $currencySymbol }}{{ number_format($e['amount'], 0, ',', '.') }}</td>
            <td>
              <div class="row-actions">
                <a href="#">Edit</a>
                <a href="#">Hapus</a>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="6"><div class="empty-state">Belum ada pengeluaran tercatat.</div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</x-app-layout>