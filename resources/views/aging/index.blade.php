<x-app-layout>
  <x-slot name="title">Aging Report</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY - ganti dengan query aging Receivable/Payable model nanti
    $arRows = [
        ['name' => 'PT Andalas Maju Bersama', 'invoice' => '#0568', 'current' => 5750000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
        ['name' => 'Nusantara Logistik',      'invoice' => '#0571', 'current' => 18400000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
        ['name' => 'Bumi Retail Group',       'invoice' => '#0552', 'current' => 0, 'd30' => 9200000, 'd60' => 0, 'd90' => 0],
        ['name' => 'Kopi Kenangan Senja',     'invoice' => '#0560', 'current' => 0, 'd30' => 2800000, 'd60' => 0, 'd90' => 0],
        ['name' => 'Toko Elektronik Jaya',    'invoice' => '#0498', 'current' => 0, 'd30' => 0, 'd60' => 6100000, 'd90' => 0],
        ['name' => 'CV Bangun Perkasa',       'invoice' => '#0421', 'current' => 0, 'd30' => 0, 'd60' => 0, 'd90' => 3400000],
    ];

    $apRows = [
        ['name' => 'Toko Bangunan Sentosa',   'invoice' => '#B-0112', 'current' => 12500000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
        ['name' => 'CV Kertas Nusantara',     'invoice' => '#B-0119', 'current' => 3200000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
        ['name' => 'PLN — Listrik Kantor',    'invoice' => '#B-0125', 'current' => 0, 'd30' => 4100000, 'd60' => 0, 'd90' => 0],
        ['name' => 'Distributor Kain Batik',  'invoice' => '#B-0103', 'current' => 0, 'd30' => 21400000, 'd60' => 0, 'd90' => 0],
    ];

    $sumBucket = fn($rows, $key) => collect($rows)->sum($key);
  @endphp

  <div class="page-head">
    <div>
      <div class="eyebrow"><svg class="icon" style="width:13px;height:13px;"><use href="#ic-trending"/></svg> Piutang &amp; Utang</div>
      <h1>Aging Report</h1>
      <p>Rincian umur piutang dan utang dalam kelompok 0, 1–30, 31–60, dan 61–90+ hari.</p>
    </div>
    <div class="actions">
      <a href="#" class="btn btn-outline"><svg class="icon"><use href="#ic-doc"/></svg> Ekspor PDF</a>
    </div>
  </div>

  <div class="tabs" id="agingTabs" style="display:flex;gap:8px;margin-bottom:20px;">
    <button type="button" class="btn btn-primary" data-tab="ar">Piutang (AR)</button>
    <button type="button" class="btn btn-outline" data-tab="ap">Utang (AP)</button>
  </div>

  <div data-panel="ar">
    <div class="stat-grid">
      <div class="stat-card"><div class="lbl">Lancar (0 hari)</div><div class="val mono">{{ $currencySymbol }}{{ number_format($sumBucket($arRows, 'current'), 0, ',', '.') }}</div></div>
      <div class="stat-card"><div class="lbl">1–30 Hari</div><div class="val mono">{{ $currencySymbol }}{{ number_format($sumBucket($arRows, 'd30'), 0, ',', '.') }}</div></div>
      <div class="stat-card"><div class="lbl">31–60 Hari</div><div class="val mono">{{ $currencySymbol }}{{ number_format($sumBucket($arRows, 'd60'), 0, ',', '.') }}</div></div>
      <div class="stat-card"><div class="lbl">61–90+ Hari</div><div class="val mono">{{ $currencySymbol }}{{ number_format($sumBucket($arRows, 'd90'), 0, ',', '.') }}</div></div>
    </div>

    <div class="card">
      <div class="card-head"><h3>Piutang per Klien</h3></div>
      <table class="tx-table">
        <thead>
          <tr>
            <th>Klien</th><th>No. Faktur</th>
            <th style="text-align:right">Lancar</th>
            <th style="text-align:right">1–30 Hari</th>
            <th style="text-align:right">31–60 Hari</th>
            <th style="text-align:right">61–90+ Hari</th>
          </tr>
        </thead>
        <tbody>
          @foreach($arRows as $row)
            <tr>
              <td>{{ $row['name'] }}</td>
              <td class="mono">{{ $row['invoice'] }}</td>
              <td class="amt-cell" style="text-align:right">{{ $row['current'] ? $currencySymbol.number_format($row['current'],0,',','.') : '—' }}</td>
              <td class="amt-cell" style="text-align:right">{{ $row['d30'] ? $currencySymbol.number_format($row['d30'],0,',','.') : '—' }}</td>
              <td class="amt-cell" style="text-align:right">{{ $row['d60'] ? $currencySymbol.number_format($row['d60'],0,',','.') : '—' }}</td>
              <td class="amt-cell neg" style="text-align:right">{{ $row['d90'] ? $currencySymbol.number_format($row['d90'],0,',','.') : '—' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div data-panel="ap" style="display:none;">
    <div class="stat-grid">
      <div class="stat-card"><div class="lbl">Lancar (0 hari)</div><div class="val mono">{{ $currencySymbol }}{{ number_format($sumBucket($apRows, 'current'), 0, ',', '.') }}</div></div>
      <div class="stat-card"><div class="lbl">1–30 Hari</div><div class="val mono">{{ $currencySymbol }}{{ number_format($sumBucket($apRows, 'd30'), 0, ',', '.') }}</div></div>
      <div class="stat-card"><div class="lbl">31–60 Hari</div><div class="val mono">{{ $currencySymbol }}{{ number_format($sumBucket($apRows, 'd60'), 0, ',', '.') }}</div></div>
      <div class="stat-card"><div class="lbl">61–90+ Hari</div><div class="val mono">{{ $currencySymbol }}{{ number_format($sumBucket($apRows, 'd90'), 0, ',', '.') }}</div></div>
    </div>

    <div class="card">
      <div class="card-head"><h3>Utang per Vendor</h3></div>
      <table class="tx-table">
        <thead>
          <tr>
            <th>Vendor</th><th>No. Tagihan</th>
            <th style="text-align:right">Lancar</th>
            <th style="text-align:right">1–30 Hari</th>
            <th style="text-align:right">31–60 Hari</th>
            <th style="text-align:right">61–90+ Hari</th>
          </tr>
        </thead>
        <tbody>
          @foreach($apRows as $row)
            <tr>
              <td>{{ $row['name'] }}</td>
              <td class="mono">{{ $row['invoice'] }}</td>
              <td class="amt-cell" style="text-align:right">{{ $row['current'] ? $currencySymbol.number_format($row['current'],0,',','.') : '—' }}</td>
              <td class="amt-cell" style="text-align:right">{{ $row['d30'] ? $currencySymbol.number_format($row['d30'],0,',','.') : '—' }}</td>
              <td class="amt-cell" style="text-align:right">{{ $row['d60'] ? $currencySymbol.number_format($row['d60'],0,',','.') : '—' }}</td>
              <td class="amt-cell neg" style="text-align:right">{{ $row['d90'] ? $currencySymbol.number_format($row['d90'],0,',','.') : '—' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <x-slot name="scripts">
    <script>
      document.querySelectorAll('#agingTabs [data-tab]').forEach(btn => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('#agingTabs [data-tab]').forEach(b => b.className = 'btn btn-outline');
          btn.className = 'btn btn-primary';
          document.querySelectorAll('[data-panel]').forEach(p => {
            p.style.display = p.dataset.panel === btn.dataset.tab ? '' : 'none';
          });
        });
      });
    </script>
  </x-slot>
</x-app-layout>