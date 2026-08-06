<x-user-layout>
    <x-slot name="title">Riwayat Pengeluaran</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        $totalAmount = $mySubmissions->sum('amount');
        $approvedAmount = $mySubmissions->where('status', 'approved')->sum('amount');
        $pendingAmount = $mySubmissions->where('status', 'pending')->sum('amount');
        $rejectedAmount = $mySubmissions->where('status', 'rejected')->sum('amount');
    @endphp

    <style>
        /* ============================================
           RIWAYAT PENGELUARAN - Premium Design
           ============================================ */
        
        .riwayat-wrap {
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
            
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .riwayat-wrap * { box-sizing: border-box; }
        .riwayat-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .riwayat-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .riwayat-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* ===== HEADER ===== */
        .riwayat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .riwayat-header-left { flex: 1; min-width: 200px; }

        .riwayat-badge {
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

        .riwayat-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .riwayat-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .riwayat-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .riwayat-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .riwayat-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .riwayat-btn {
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
            font-family: 'Inter', sans-serif;
        }

        .riwayat-btn .icon { width: 16px; height: 16px; }
        .riwayat-btn:hover { transform: translateY(-2px); }
        .riwayat-btn:active { transform: translateY(0) scale(0.97); }

        .riwayat-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .riwayat-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .riwayat-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== STATS ===== */
        .riwayat-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .riwayat-stat {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .riwayat-stat::before {
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

        .riwayat-stat:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .riwayat-stat:hover::before { opacity: 1; }

        .riwayat-stat .number {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .riwayat-stat .number.green { color: var(--success); }
        .riwayat-stat .number.blue { color: var(--info); }
        .riwayat-stat .number.purple { color: var(--theme-primary); }
        .riwayat-stat .number.red { color: var(--danger); }

        .riwayat-stat .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 4px;
        }

        /* ===== TABLE CARD ===== */
        .riwayat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px 28px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .riwayat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--theme-gradient);
            border-radius: var(--radius-md) var(--radius-md) 0 0;
        }

        .riwayat-card:hover { border-color: var(--border-hover); }

        .riwayat-card .card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .riwayat-card .card-head h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .riwayat-card .card-head h3 .icon {
            width: 20px;
            height: 20px;
            color: var(--theme-primary);
        }

        .riwayat-card .card-head .count {
            font-size: 12px;
            color: var(--text-tertiary);
            background: var(--bg-card-active);
            padding: 4px 12px;
            border-radius: 100px;
        }

        /* ===== TABLE ===== */
        .riwayat-table-wrap { overflow-x: auto; }

        .riwayat-table {
            width: 100%;
            border-collapse: collapse;
        }

        .riwayat-table thead th {
            padding: 12px 10px 14px;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-tertiary);
            border-bottom: 1.5px solid var(--border-color);
        }

        .riwayat-table thead th:last-child { text-align: right; }

        .riwayat-table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .riwayat-table tbody tr:last-child { border-bottom: none; }

        .riwayat-table tbody tr:hover {
            background: var(--bg-card-active);
        }

        .riwayat-table tbody td {
            padding: 14px 10px;
            vertical-align: middle;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .riwayat-table tbody td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .riwayat-table .description-cell {
            color: var(--text-primary);
            font-weight: 500;
        }

        .riwayat-table .amount-cell {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            color: var(--text-primary);
        }

        .riwayat-table .category-cell {
            display: inline-block;
            padding: 3px 12px;
            background: var(--bg-card-active);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 500;
            color: var(--text-secondary);
        }

        /* ===== STATUS PILLS ===== */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .status-pill .dot-status {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-pill.pending {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .status-pill.pending .dot-status { background: var(--warning); }

        .status-pill.approved {
            background: var(--success-soft);
            color: var(--success);
        }

        .status-pill.approved .dot-status { background: var(--success); }

        .status-pill.rejected {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .status-pill.rejected .dot-status { background: var(--danger); }

        /* ===== EMPTY STATE ===== */
        .riwayat-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-tertiary);
        }

        .riwayat-empty .empty-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            color: var(--text-tertiary);
            opacity: 0.3;
        }

        .riwayat-empty h4 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 4px;
        }

        .riwayat-empty p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 20px;
        }

        .riwayat-empty .empty-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            background: var(--theme-gradient);
            color: #fff;
            text-decoration: none;
            box-shadow: 0 4px 16px var(--theme-glow);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .riwayat-empty .empty-action:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .riwayat-empty .empty-action .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .riwayat-stats { grid-template-columns: 1fr 1fr; }
            .riwayat-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .riwayat-wrap { padding: 0 12px; }
            .riwayat-header { flex-direction: column; }
            .riwayat-actions { width: 100%; }
            .riwayat-actions .riwayat-btn { flex: 1; justify-content: center; font-size: 12px; padding: 8px 12px; }
            .riwayat-card { padding: 16px; }
            .riwayat-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
            .riwayat-stat .number { font-size: 20px; }
            .riwayat-header h1 { font-size: 22px; }
            .riwayat-table thead th,
            .riwayat-table tbody td {
                padding: 10px 6px;
                font-size: 12px;
            }
            .riwayat-table .category-cell {
                font-size: 10px;
                padding: 2px 10px;
            }
            .status-pill {
                font-size: 10px;
                padding: 3px 10px;
            }
        }

        @media (max-width: 480px) {
            .riwayat-wrap { padding: 0 8px; }
            .riwayat-stats { grid-template-columns: 1fr; }
            .riwayat-card { padding: 12px; }
            .riwayat-card .card-head h3 { font-size: 14px; }
            .riwayat-card .card-head .count { font-size: 11px; }
            .riwayat-table thead th,
            .riwayat-table tbody td {
                padding: 8px 4px;
                font-size: 11px;
            }
            .riwayat-table .description-cell { font-size: 12px; }
            .riwayat-empty .empty-icon { width: 48px; height: 48px; }
            .riwayat-empty h4 { font-size: 16px; }
            .riwayat-empty p { font-size: 13px; }
        }

        @media (max-width: 380px) {
            .riwayat-table thead th:nth-child(2),
            .riwayat-table tbody td:nth-child(2) {
                display: none;
            }
        }
    </style>

    <div class="riwayat-wrap">

        <!-- ===== HEADER ===== -->
        <div class="riwayat-header animate-in" style="animation-delay: 0.05s;">
            <div class="riwayat-header-left">
                <div class="riwayat-badge">
                    <span class="dot"></span>
                    Riwayat
                </div>
                <h1>Riwayat Pengeluaran</h1>
                <p class="subtitle">
                    Semua pengajuan pengeluaran yang pernah kamu buat — 
                    <strong>pantau status dan histori pengeluaranmu</strong>
                </p>
            </div>
            <div class="riwayat-actions">
                <a href="{{ route('user.expenses.create') }}" class="riwayat-btn riwayat-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Ajukan Baru
                </a>
            </div>
        </div>

        <!-- ===== STATS ===== -->
        <div class="riwayat-stats animate-in" style="animation-delay: 0.08s;">
            <div class="riwayat-stat">
                <div class="number purple mono">{{ $mySubmissions->count() }}</div>
                <div class="label">Total Pengajuan</div>
            </div>
            <div class="riwayat-stat">
                <div class="number blue mono">{{ $currencySymbol }}{{ number_format($totalAmount, 0, ',', '.') }}</div>
                <div class="label">Total Nominal</div>
            </div>
            <div class="riwayat-stat">
                <div class="number green mono">{{ $currencySymbol }}{{ number_format($approvedAmount, 0, ',', '.') }}</div>
                <div class="label">Disetujui</div>
            </div>
            <div class="riwayat-stat">
                <div class="number red mono">{{ $currencySymbol }}{{ number_format($pendingAmount + $rejectedAmount, 0, ',', '.') }}</div>
                <div class="label">Pending + Ditolak</div>
            </div>
        </div>

        <!-- ===== TABLE CARD ===== -->
        <div class="riwayat-card animate-in" style="animation-delay: 0.12s;">
            <div class="card-head">
                <h3>
                    <svg class="icon"><use href="#ic-file-text"/></svg>
                    Daftar Pengajuan
                </h3>
                <span class="count">{{ $mySubmissions->count() }} pengajuan</span>
            </div>

            @if ($mySubmissions->isEmpty())
                <div class="riwayat-empty">
                    <svg class="empty-icon"><use href="#ic-inbox"/></svg>
                    <h4>Belum Ada Pengajuan</h4>
                    <p>Kamu belum pernah mengajukan pengeluaran. Mulai ajukan sekarang!</p>
                    <a href="{{ route('user.expenses.create') }}" class="empty-action">
                        <svg class="icon" style="width:16px;height:16px;"><use href="#ic-plus"/></svg>
                        Ajukan Pengeluaran
                    </a>
                </div>
            @else
                <div class="riwayat-table-wrap">
                    <table class="riwayat-table">
                        <thead>
                            <tr>
                                <th style="width:30%;">Deskripsi</th>
                                <th style="width:15%;">Kategori</th>
                                <th style="width:15%;">Tanggal</th>
                                <th style="width:18%;">Status</th>
                                <th style="width:22%;text-align:right;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mySubmissions as $item)
                                <tr>
                                    <td class="description-cell">{{ $item->description }}</td>
                                    <td>
                                        <span class="category-cell">{{ $item->category ?? '-' }}</span>
                                    </td>
                                    <td>{{ $item->expense_date->format('d M Y') }}</td>
                                    <td>
                                        @php
                                            $status = $item->status;
                                            $statusData = [
                                                'pending' => ['class' => 'pending', 'label' => 'Menunggu'],
                                                'approved' => ['class' => 'approved', 'label' => 'Disetujui'],
                                                'rejected' => ['class' => 'rejected', 'label' => 'Ditolak'],
                                            ][$status] ?? ['class' => 'pending', 'label' => 'Menunggu'];
                                        @endphp
                                        <span class="status-pill {{ $statusData['class'] }}">
                                            <span class="dot-status"></span>
                                            {{ $statusData['label'] }}
                                        </span>
                                    </td>
                                    <td class="amount-cell">{{ $currencySymbol }}{{ number_format($item->amount, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-plus" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
        <symbol id="ic-file-text" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></symbol>
        <symbol id="ic-inbox" viewBox="0 0 24 24"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.riwayat-btn, .empty-action');
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (this.tagName === 'A' && this.getAttribute('href') && this.getAttribute('href') !== '#') {
                        return;
                    }
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });

        });
    </script>
</x-user-layout>