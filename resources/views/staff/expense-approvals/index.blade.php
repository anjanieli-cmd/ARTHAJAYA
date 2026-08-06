<x-app-layout>
    <x-slot name="title">Persetujuan Pengeluaran</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        function formatTanggalApproval($date) {
            if (empty($date)) return '-';
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return $date;
            }
        }

        function formatWaktuApproval($date) {
            if (empty($date)) return '-';
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y, H:i');
            } catch (\Exception $e) {
                return $date;
            }
        }
    @endphp

    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="ap-ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </symbol>
            <symbol id="ap-ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="ap-ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ap-ic-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ap-ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="ap-ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ap-ic-history" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 3v5h5"/><path d="M3.05 13A9 9 0 1 0 6 5.3L3 8"/><path d="M12 7v5l4 2"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .appr-wrap {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text);
            padding: 0 24px;
        }
        .appr-wrap * { box-sizing: border-box; }
        .appr-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes apprFadeSlideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes apprPulseGlow { 0%, 100% { opacity: 1; } 50% { opacity: 0.6; } }
        .appr-wrap .animate-in { animation: apprFadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .appr-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* ===== HEADER ===== */
        .appr-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; flex-wrap: wrap; margin-bottom: 28px; padding: 0 4px; }
        .appr-header-left { flex: 1; min-width: 200px; }
        .appr-badge { display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px 6px 10px; background: rgba(var(--emerald-rgb), 0.25); border: 1px solid rgba(var(--emerald-rgb), 0.25); border-radius: 100px; font-size: 11px; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: var(--emerald); margin-bottom: 12px; }
        .appr-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--emerald); animation: apprPulseGlow 2s ease-in-out infinite; }
        .appr-header h1 { font-size: 28px; font-weight: 700; margin: 0 0 6px; background: linear-gradient(135deg, var(--text) 60%, var(--emerald)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; letter-spacing: -0.02em; }
        .appr-header .subtitle { font-size: 14px; color: var(--text-mute); margin: 0; }
        .appr-header .subtitle strong { color: var(--text); font-weight: 600; }

        /* ===== ALERTS ===== */
        .appr-alert { border-radius: 16px; padding: 14px 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; font-size: 13px; }
        .appr-alert-success { background: rgba(52, 181, 131, 0.14); border: 1px solid rgba(52, 181, 131, 0.3); color: #34B583; }
        .appr-alert-error { background: rgba(232, 90, 90, 0.12); border: 1px solid rgba(232, 90, 90, 0.3); color: #E85A5A; }

        /* ===== CARD ===== */
        .appr-card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; transition: border-color 0.22s ease; margin-bottom: 24px; }
        .appr-card:hover { border-color: var(--border-hover); }
        .appr-card-header { display: flex; justify-content: space-between; align-items: center; padding: 18px 24px; border-bottom: 1px solid var(--border); gap: 12px; flex-wrap: wrap; }
        .appr-card-header .title-group { display: flex; align-items: center; gap: 10px; }
        .appr-card-header .title-group .ic { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; background: rgba(var(--emerald-rgb), 0.12); color: var(--emerald); flex-shrink: 0; }
        .appr-card-header .title-group .ic .icon { width: 16px; height: 16px; }
        .appr-card-header h3 { font-size: 15px; font-weight: 600; color: var(--text); margin: 0; }
        .appr-card-header .count-pill { font-size: 11px; font-weight: 700; padding: 4px 11px; border-radius: 100px; background: rgba(var(--emerald-rgb), 0.14); color: var(--emerald); }

        .appr-table-wrap { overflow-x: auto; }
        .appr-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        .appr-table th { text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-faint); padding: 12px 16px 10px; border-bottom: 1px solid var(--border); white-space: nowrap; }
        .appr-table th.text-right { text-align: right; }
        .appr-table th.text-center { text-align: center; }
        .appr-table td { padding: 14px 16px; border-bottom: 1px solid var(--border); color: var(--text); vertical-align: middle; }
        .appr-table tbody tr:last-child td { border-bottom: none; }
        .appr-table tbody tr:hover { background: var(--surface-strong); }

        .appr-user { display: flex; align-items: center; gap: 10px; }
        .appr-user .av { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--emerald), var(--emerald-dim)); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; color: #052117; flex-shrink: 0; }
        .appr-user .nm { font-weight: 500; color: var(--text); }

        .appr-desc { font-weight: 500; color: var(--text); }
        .appr-desc .note { display: block; font-size: 11.5px; color: var(--text-faint); font-weight: 400; margin-top: 2px; max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .appr-category { font-size: 11.5px; font-weight: 500; padding: 4px 11px; border-radius: 100px; background: rgba(255,255,255,0.04); color: var(--text-mute); display: inline-block; border: 1px solid var(--border); white-space: nowrap; }

        .appr-amount { font-weight: 600; font-size: 13.5px; text-align: right; color: var(--text); white-space: nowrap; }

        .appr-status { font-size: 10.5px; font-weight: 700; padding: 4px 12px; border-radius: 100px; display: inline-block; text-transform: uppercase; letter-spacing: 0.04em; white-space: nowrap; }
        .appr-status.approved { background: rgba(52, 181, 131, 0.14); color: #34B583; }
        .appr-status.rejected { background: rgba(232, 90, 90, 0.12); color: #E85A5A; }

        .appr-actions { display: flex; gap: 8px; justify-content: center; flex-wrap: wrap; }
        .appr-actions form { display: inline-block; }
        .appr-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 9px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s ease; font-family: 'Inter', sans-serif; }
        .appr-btn .icon { width: 13px; height: 13px; }
        .appr-btn-approve { background: rgba(52, 181, 131, 0.14); color: #34B583; }
        .appr-btn-approve:hover { background: #34B583; color: #052117; transform: translateY(-1px); }
        .appr-btn-reject { background: rgba(232, 90, 90, 0.12); color: #E85A5A; }
        .appr-btn-reject:hover { background: #E85A5A; color: #fff; transform: translateY(-1px); }

        .appr-empty { text-align: center; padding: 48px 20px; color: var(--text-faint); }
        .appr-empty .empty-icon { width: 48px; height: 48px; margin: 0 auto 14px; color: var(--emerald); opacity: 0.45; }
        .appr-empty h4 { font-size: 15px; font-weight: 600; margin: 0 0 4px; color: var(--text); }
        .appr-empty p { color: var(--text-mute); margin: 0; font-size: 13px; }

        @media (max-width: 768px) {
            .appr-wrap { padding: 0 12px; }
            .appr-header h1 { font-size: 22px; }
            .appr-table { font-size: 12.5px; }
            .appr-table th, .appr-table td { padding: 10px 12px; }
            .appr-desc .note { max-width: 160px; }
        }
    </style>

    <div class="appr-wrap">

        <!-- ===== HEADER ===== -->
        <div class="appr-header animate-in" style="animation-delay: 0.05s;">
            <div class="appr-header-left">
                <div class="appr-badge">
                    <span class="dot"></span>
                    Pembelian &amp; Biaya
                </div>
                <h1>Persetujuan Pengeluaran</h1>
                <p class="subtitle">
                    Tinjau pengajuan pengeluaran dari tim —
                    <strong>{{ $pendingSubmissions->count() }} menunggu persetujuan</strong>
                </p>
            </div>
        </div>

        <!-- ===== ALERTS ===== -->
        @if (session('success'))
            <div class="appr-alert appr-alert-success animate-in" style="animation-delay: 0.07s;">
                <svg class="icon"><use href="#ap-ic-check-circle"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="appr-alert appr-alert-error animate-in" style="animation-delay: 0.07s;">
                <svg class="icon"><use href="#ap-ic-alert"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- ===== MENUNGGU PERSETUJUAN ===== -->
        <div class="appr-card animate-in" style="animation-delay: 0.10s;">
            <div class="appr-card-header">
                <div class="title-group">
                    <div class="ic"><svg class="icon"><use href="#ap-ic-inbox"/></svg></div>
                    <h3>Menunggu Persetujuan</h3>
                </div>
                <span class="count-pill">{{ $pendingSubmissions->count() }} pengajuan</span>
            </div>

            <div class="appr-table-wrap">
                <table class="appr-table">
                    <thead>
                        <tr>
                            <th>Pengaju</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th class="text-right">Jumlah</th>
                            <th class="text-center" style="width:200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingSubmissions as $submission)
                            <tr>
                                <td>
                                    <div class="appr-user">
                                        <div class="av">{{ strtoupper(substr($submitterNames[$submission->submitted_by] ?? 'U', 0, 1)) }}</div>
                                        <span class="nm">{{ $submitterNames[$submission->submitted_by] ?? 'Pengguna' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="appr-desc">
                                        {{ $submission->description }}
                                        @if($submission->note)
                                            <span class="note">{{ $submission->note }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td><span class="appr-category">{{ $submission->category ?? 'Lainnya' }}</span></td>
                                <td>{{ formatTanggalApproval($submission->expense_date) }}</td>
                                <td class="appr-amount mono">{{ $currencySymbol }}{{ number_format($submission->amount, 0, ',', '.') }}</td>
                                <td>
                                    <div class="appr-actions">
                                        <form action="{{ route('staff.expense-approvals.approve', $submission->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="appr-btn appr-btn-approve">
                                                <svg class="icon"><use href="#ap-ic-check"/></svg>
                                                Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('staff.expense-approvals.reject', $submission->id) }}" method="POST"
                                              onsubmit="return confirm('Tolak pengajuan dari {{ addslashes($submitterNames[$submission->submitted_by] ?? 'pengguna ini') }}?');">
                                            @csrf
                                            <button type="submit" class="appr-btn appr-btn-reject">
                                                <svg class="icon"><use href="#ap-ic-x"/></svg>
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="appr-empty">
                                        <svg class="empty-icon"><use href="#ap-ic-inbox"/></svg>
                                        <h4>Tidak Ada Pengajuan Pending</h4>
                                        <p>Semua pengajuan pengeluaran sudah ditinjau.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===== RIWAYAT ===== -->
        <div class="appr-card animate-in" style="animation-delay: 0.15s;">
            <div class="appr-card-header">
                <div class="title-group">
                    <div class="ic"><svg class="icon"><use href="#ap-ic-history"/></svg></div>
                    <h3>Riwayat Peninjauan</h3>
                </div>
                <span class="count-pill">{{ $historySubmissions->count() }} terbaru</span>
            </div>

            <div class="appr-table-wrap">
                <table class="appr-table">
                    <thead>
                        <tr>
                            <th>Pengaju</th>
                            <th>Deskripsi</th>
                            <th class="text-right">Jumlah</th>
                            <th class="text-center">Status</th>
                            <th>Ditinjau Oleh</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($historySubmissions as $submission)
                            <tr>
                                <td>
                                    <div class="appr-user">
                                        <div class="av">{{ strtoupper(substr($historyNames[$submission->submitted_by] ?? 'U', 0, 1)) }}</div>
                                        <span class="nm">{{ $historyNames[$submission->submitted_by] ?? 'Pengguna' }}</span>
                                    </div>
                                </td>
                                <td class="appr-desc">{{ $submission->description }}</td>
                                <td class="appr-amount mono">{{ $currencySymbol }}{{ number_format($submission->amount, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="appr-status {{ $submission->status }}">
                                        {{ $submission->status === 'approved' ? 'Diterima' : 'Ditolak' }}
                                    </span>
                                </td>
                                <td>{{ $historyNames[$submission->reviewed_by] ?? '-' }}</td>
                                <td>{{ formatWaktuApproval($submission->reviewed_at) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="appr-empty">
                                        <svg class="empty-icon"><use href="#ap-ic-history"/></svg>
                                        <h4>Belum Ada Riwayat</h4>
                                        <p>Pengajuan yang sudah ditinjau akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>