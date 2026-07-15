<x-app-layout>
  <x-slot name="title">Dashboard</x-slot>

  <div class="page-head">
    <div>
      <div class="eyebrow"><svg class="icon" style="width:13px;height:13px;"><use href="#ic-building"/></svg> Dashboard Perusahaan</div>
      <h1>{{ $company->name ?? 'Perusahaan Belum Diatur' }}</h1>
      <p>{{ $company->industry ?? 'Industri belum diisi' }} @if($company->city ?? false) • {{ $company->city }}@endif — Diperbarui {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
    <div class="actions">
      <a href="#" class="btn btn-outline">
        <svg class="icon"><use href="#ic-receive"/></svg> Catat Transaksi
      </a>
      <a href="#" class="btn btn-primary">
        <svg class="icon"><use href="#ic-plus"/></svg> Faktur Baru
      </a>
    </div>
  </div>

  <!-- COMPANY PROFILE - DATA REAL DARI ONBOARDING -->
  <div class="card company-card">
    <div class="company-card-inner">
      <div class="company-logo">
        @if(!empty($company->logo))
          <img src="{{ asset('storage/'.$company->logo) }}" alt="{{ $company->name }}">
        @else
          {{ strtoupper(substr($company->name ?? 'PT', 0, 2)) }}
        @endif
      </div>
      <div class="company-meta">
        <h2>{{ $company->name ?? 'Nama Perusahaan' }}</h2>
        <div class="company-tags">
          <span class="tag-pill">{{ $company->industry ?? 'Industri belum diisi' }}</span>
          @if($company->business_size ?? false)<span class="tag-pill">{{ $company->business_size }}</span>@endif
          <span class="tag-pill">{{ $company->city ?? '-' }}, {{ $company->country ?? 'Indonesia' }}</span>
        </div>
        <div class="company-details">
          <div><span class="k">Alamat</span><span class="v">{{ $company->address ?? '-' }}</span></div>
          <div><span class="k">Mata Uang</span><span class="v">{{ $company->currency ?? 'IDR' }} ({{ $company->currency_symbol ?? 'Rp' }})</span></div>
          <div><span class="k">Zona Waktu</span><span class="v">{{ $company->timezone ?? '-' }}</span></div>
          <div><span class="k">Tahun Fiskal</span><span class="v">{{ $company->fiscal_start_month ?? 'Januari' }} — {{ $company->fiscal_year ?? date('Y') }}</span></div>
        </div>
      </div>
      <a href="#" class="btn btn-outline company-edit-btn">
        <svg class="icon"><use href="#ic-settings"/></svg> Edit Profil
      </a>
    </div>
  </div>

  <!-- STAT CARDS - DATA REAL DARI DATABASE -->
  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-head">
        <div class="ic"><svg class="icon"><use href="#ic-bank"/></svg></div>
        <div class="chg up"><svg class="icon"><use href="#ic-trending"/></svg> 3.8%</div>
      </div>
      <div class="lbl">Total Saldo Kas</div>
      <div class="val mono">
        {{ $account ? $account->currency_symbol ?? 'Rp' : 'Rp' }}{{ number_format($account->initial_balance ?? 0, 0, ',', '.') }}
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-head">
        <div class="ic"><svg class="icon"><use href="#ic-receive"/></svg></div>
        <div class="chg up"><svg class="icon"><use href="#ic-trending"/></svg> 12.5%</div>
      </div>
      <div class="lbl">Pemasukan Bulan Ini</div>
      <div class="val mono">{{ $company->currency_symbol ?? 'Rp' }}184.600.000</div>
    </div>
    <div class="stat-card">
      <div class="stat-head">
        <div class="ic"><svg class="icon"><use href="#ic-invoice"/></svg></div>
        <div class="chg down"><svg class="icon"><use href="#ic-trending-down"/></svg> 4.2%</div>
      </div>
      <div class="lbl">Pengeluaran Bulan Ini</div>
      <div class="val mono">{{ $company->currency_symbol ?? 'Rp' }}36.507.500</div>
    </div>
    <div class="stat-card">
      <div class="stat-head">
        <div class="ic"><svg class="icon"><use href="#ic-doc"/></svg></div>
        <div class="chg down">3 jatuh tempo</div>
      </div>
      <div class="lbl">Faktur Belum Dibayar</div>
      <div class="val mono">{{ $company->currency_symbol ?? 'Rp' }}87.500.000</div>
    </div>
  </div>

  <!-- MAIN GRID -->
  <div class="dash-layout">
    <div class="stack">

      <!-- BALANCE / QUICK ACTIONS - DATA REAL (rekening dari onboarding) -->
      <div class="card balance-card">
        <div class="balance-top">
          <div>
            <div class="balance-lbl">Saldo Kas Konsolidasi</div>
            <div class="balance-amt mono">
              {{ $account ? $account->currency_symbol ?? 'Rp' : 'Rp' }}{{ number_format($account->initial_balance ?? 0, 0, ',', '.') }}
            </div>
            @if($account)
              <div class="balance-sub">{{ $account->bank_name ?? 'Kas Tunai' }} @if($account->account_number ?? false) • {{ $account->account_number }} @endif</div>
            @endif
            <div class="balance-delta"><svg class="icon"><use href="#ic-trending"/></svg> +Rp16.850.000 (3.8%) bulan ini</div>
          </div>
          <div class="quick-actions">
            <div class="qa-btn"><div class="ic"><svg class="icon"><use href="#ic-invoice"/></svg></div>Faktur</div>
            <div class="qa-btn"><div class="ic"><svg class="icon"><use href="#ic-receive"/></svg></div>Terima</div>
            <div class="qa-btn"><div class="ic"><svg class="icon"><use href="#ic-bank"/></svg></div>Rekonsil</div>
            <div class="qa-btn"><div class="ic"><svg class="icon"><use href="#ic-dots"/></svg></div>Lainnya</div>
          </div>
        </div>
        <div class="mini-spark" id="balanceSpark">
          <i data-h="35"></i><i data-h="55"></i><i data-h="40"></i><i data-h="70"></i>
          <i data-h="50"></i><i data-h="85"></i><i data-h="65"></i><i data-h="90"></i>
          <i data-h="60"></i><i data-h="78"></i><i data-h="95"></i><i data-h="88"></i>
        </div>
      </div>

      <!-- RECENT TRANSACTIONS - MASIH DUMMY (NANTI BISA DIGANTI) -->
      <div class="card">
        <div class="card-head">
          <h3>Transaksi Terbaru</h3>
          <a href="#" class="sub-link">Lihat semua <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
        </div>
        @php
            $dummyTransactions = [
                ['title' => 'Faktur #0568 — PT Andalas Maju', 'date' => '21 Jun 2026, 09:40', 'status' => 'paid', 'amount' => -5750, 'icon' => 'invoice'],
                ['title' => 'Sewa Kantor — Juni 2026', 'date' => '20 Jun 2026, 08:30', 'status' => 'paid', 'amount' => -42900000, 'icon' => 'building'],
                ['title' => 'Pembayaran Klien — Kopi Kenangan Senja', 'date' => '18 Jun 2026, 10:20', 'status' => 'paid', 'amount' => 2800000, 'icon' => 'briefcase'],
                ['title' => 'Faktur #0571 — Nusantara Logistik', 'date' => '15 Jun 2026, 14:05', 'status' => 'pending', 'amount' => 18400000, 'icon' => 'invoice'],
                ['title' => 'Faktur #0552 — Bumi Retail Group', 'date' => '02 Jun 2026, 11:15', 'status' => 'overdue', 'amount' => 9200000, 'icon' => 'invoice'],
            ];
        @endphp
        <table class="tx-table">
          <thead>
            <tr><th>Deskripsi</th><th>Status</th><th style="text-align:right">Jumlah</th></tr>
          </thead>
          <tbody>
            @foreach($dummyTransactions as $tx)
              <tr>
                <td>
                  <div class="tx-who">
                    <div class="tx-ic"><svg class="icon"><use href="#ic-{{ $tx['icon'] }}"/></svg></div>
                    <div><div class="tx-name">{{ $tx['title'] }}</div><div class="tx-date">{{ $tx['date'] }}</div></div>
                  </div>
                </td>
                <td><span class="status-pill {{ $tx['status'] }}">{{ ucfirst($tx['status']) }}</span></td>
                <td class="amt-cell {{ $tx['amount'] >= 0 ? 'pos' : 'neg' }}">{{ $tx['amount'] >= 0 ? '+' : '-' }}{{ $company->currency_symbol ?? 'Rp' }}{{ number_format(abs($tx['amount']), 0, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="stack">
      <!-- EXPENSE DONUT - MASIH DUMMY -->
      <div class="card">
        <div class="card-head">
          <h3>Ringkasan Pengeluaran</h3>
          <span class="sub-link">Bulan Ini <svg class="icon"><use href="#ic-chevron"/></svg></span>
        </div>
        <div class="donut-wrap">
          <div class="donut">
            <svg viewBox="0 0 120 120">
              <circle cx="60" cy="60" r="52" style="stroke:var(--surface-strong)"></circle>
              <circle cx="60" cy="60" r="52" style="stroke:var(--emerald)" stroke-dasharray="326.7" stroke-dashoffset="326.7" class="donut-anim"></circle>
            </svg>
            <div class="donut-center"><div class="amt">{{ $company->currency_symbol ?? 'Rp' }}36,5jt</div><div class="lbl">Total</div></div>
          </div>
          <div class="legend">
            <div class="legend-row"><span><i class="dot" style="background:var(--emerald)"></i>Operasional</span><span class="amt">{{ $company->currency_symbol ?? 'Rp' }}14.603.000</span></div>
            <div class="legend-row"><span><i class="dot" style="background:#4E8FF0"></i>Gaji</span><span class="amt">{{ $company->currency_symbol ?? 'Rp' }}9.126.875</span></div>
            <div class="legend-row"><span><i class="dot" style="background:#F0C05A"></i>Sewa</span><span class="amt">{{ $company->currency_symbol ?? 'Rp' }}5.476.125</span></div>
            <div class="legend-row"><span><i class="dot" style="background:#9B7BE0"></i>Pemasaran</span><span class="amt">{{ $company->currency_symbol ?? 'Rp' }}3.650.800</span></div>
          </div>
        </div>
      </div>

      <!-- BILLING TARGET - MASIH DUMMY -->
      <div class="card">
        <div class="card-head"><h3>Target Penagihan</h3><svg class="icon" style="color:var(--emerald)"><use href="#ic-target"/></svg></div>
        <div class="balance-amt mono" style="font-size:22px;">{{ $company->currency_symbol ?? 'Rp' }}62,5jt</div>
        <div style="font-size:12px;color:var(--text-mute);margin-top:4px;">dari target Rp150.000.000</div>
        <div class="progress-bar"><div class="progress-fill" id="targetFill"></div></div>
        <div class="progress-labels"><span>42%</span><span>Sisa 18 hari</span></div>
      </div>

      <!-- TIM PERUSAHAAN - DATA REAL DARI UNDANGAN ONBOARDING (jika ada) -->
      <div class="card">
        <div class="card-head">
          <h3>Tim Perusahaan</h3>
          <a href="#" class="sub-link">Kelola <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
        </div>
        @if(!empty($teamMembers) && count($teamMembers))
          @foreach($teamMembers as $member)
            <div class="team-row">
              <div class="team-avatar">{{ strtoupper(substr($member->name ?? $member->email, 0, 1)) }}</div>
              <div class="team-info">
                <div class="n">{{ $member->name ?? $member->email }}</div>
                <div class="c">{{ $member->email }}</div>
              </div>
              <span class="team-role-pill">{{ $member->role ?? 'Anggota' }}</span>
            </div>
          @endforeach
        @else
          <div class="empty-state">Belum ada anggota tim diundang. Undang rekan kerja lewat menu Pengaturan.</div>
        @endif
      </div>

      <!-- UPCOMING INVOICES - MASIH DUMMY -->
      <div class="card">
        <div class="card-head">
          <h3>Faktur Akan Jatuh Tempo</h3>
          <a href="#" class="sub-link">Semua <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
        </div>
        <div class="inv-row">
          <div class="info"><div class="n">#0571 — Nusantara Logistik</div><div class="c">Jatuh tempo 25 Jun 2026</div></div>
          <div class="amt">{{ $company->currency_symbol ?? 'Rp' }}18.400.000</div>
        </div>
        <div class="inv-row">
          <div class="info"><div class="n">#0574 — Ruang Kriya Studio</div><div class="c">Jatuh tempo 28 Jun 2026</div></div>
          <div class="amt">{{ $company->currency_symbol ?? 'Rp' }}6.200.000</div>
        </div>
        <div class="inv-row">
          <div class="info"><div class="n">#0552 — Bumi Retail Group</div><div class="c" style="color:var(--danger)">Terlambat 4 hari</div></div>
          <div class="amt">{{ $company->currency_symbol ?? 'Rp' }}9.200.000</div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .donut-anim{ animation: donut1 1.6s ease-out .2s forwards; }
    @keyframes donut1{ to{ stroke-dashoffset: 130.7; } }
  </style>

  <x-slot name="scripts">
    <script>
      // spark bars grow-in
      document.querySelectorAll('#balanceSpark i').forEach((bar, i) => {
        setTimeout(() => { bar.style.height = bar.dataset.h + '%'; }, i * 60);
      });

      // billing target progress fill
      const targetFill = document.getElementById('targetFill');
      if(targetFill) setTimeout(() => { targetFill.style.width = '42%'; }, 200);
    </script>
  </x-slot>
</x-app-layout>