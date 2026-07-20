<x-app-layout>
    <x-slot name="title">Detail Aging Report</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    @endphp

    <style>
        .detail-modern {
            --theme-primary: var(--emerald);
            --theme-light: var(--emerald);
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

            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);

            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;

            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }

        .detail-modern * {
            box-sizing: border-box;
        }

        .detail-modern .mono {
            font-family: 'IBM Plex Mono', monospace;
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.02em;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .detail-modern .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .detail-modern .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            display: inline-block;
            vertical-align: middle;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .detail-header-left h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .detail-header-left .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .detail-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .detail-btn {
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
        }

        .detail-btn .icon {
            width: 16px;
            height: 16px;
        }

        .detail-btn:hover {
            transform: translateY(-2px);
        }

        .detail-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .detail-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .detail-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .detail-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .detail-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .detail-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        @keyframes rippleAnim {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .detail-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px;
            transition: border-color 0.22s ease;
        }

        .detail-card:hover {
            border-color: var(--border-hover);
        }

        .detail-badge {
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
            margin-bottom: 20px;
        }

        .detail-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .detail-item {
            padding: 16px 20px;
            background: var(--bg-card-active);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .detail-item:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
        }

        .detail-item .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            margin-bottom: 6px;
        }

        .detail-item .value {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .detail-item .value.mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        .detail-item .value.success {
            color: var(--success);
        }

        .detail-item .value.danger {
            color: var(--danger);
        }

        .detail-item .value.primary {
            color: var(--theme-primary);
        }

        .detail-divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 24px 0;
        }

        .detail-total {
            background: var(--theme-soft);
            border: 1px solid var(--theme-glow);
            border-radius: var(--radius-sm);
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .detail-total .label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .detail-total .value {
            font-size: 24px;
            font-weight: 700;
            color: var(--theme-primary);
            font-family: 'IBM Plex Mono', monospace;
        }

        .detail-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            margin-top: 12px;
        }

        .detail-status .icon {
            width: 20px;
            height: 20px;
        }

        .detail-status.success {
            background: var(--success-soft);
            color: var(--success);
        }

        .detail-status.warning {
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .detail-status.danger {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .detail-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        @media (max-width: 768px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }
            .detail-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .detail-header-actions {
                width: 100%;
            }
            .detail-header-actions .detail-btn {
                flex: 1;
                justify-content: center;
            }
            .detail-total {
                flex-direction: column;
                text-align: center;
            }
            .detail-actions {
                flex-direction: column;
            }
            .detail-actions .detail-btn {
                justify-content: center;
            }
        }
    </style>

    <div class="detail-modern">

        <!-- HEADER -->
        <div class="detail-header animate-in" style="animation-delay: 0.05s;">
            <div class="detail-header-left">
                <div class="detail-badge">
                    <span class="dot"></span>
                    {{ $type === 'ar' ? 'Piutang Usaha' : 'Utang Usaha' }}
                </div>
                <h1>Detail Aging Report</h1>
                <p class="subtitle">
                    Informasi lengkap untuk invoice <strong>{{ $row['invoice'] }}</strong>
                </p>
            </div>
            <div class="detail-header-actions">
                <a href="{{ route('aging.index') }}" class="detail-btn detail-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5"/>
                        <path d="M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
                <button type="button" class="detail-btn detail-btn-primary"
                        onclick="window.print()">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect x="6" y="14" width="12" height="8"/>
                    </svg>
                    Cetak
                </button>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="detail-card animate-in" style="animation-delay: 0.10s;">
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="label">Nama / Vendor</div>
                    <div class="value">{{ $row['name'] }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Nomor Invoice</div>
                    <div class="value mono">{{ $row['invoice'] }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Current (Belum Jatuh Tempo)</div>
                    <div class="value mono success">{{ $currencySymbol . number_format($row['current'], 0, ',', '.') }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">30 Hari</div>
                    <div class="value mono">{{ $row['d30'] > 0 ? $currencySymbol . number_format($row['d30'], 0, ',', '.') : '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">60 Hari</div>
                    <div class="value mono">{{ $row['d60'] > 0 ? $currencySymbol . number_format($row['d60'], 0, ',', '.') : '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">90+ Hari</div>
                    <div class="value mono danger">{{ $row['d90'] > 0 ? $currencySymbol . number_format($row['d90'], 0, ',', '.') : '-' }}</div>
                </div>
            </div>

            <hr class="detail-divider">

            @php
                $total = $row['current'] + $row['d30'] + $row['d60'] + $row['d90'];
                $statusClass = '';
                $statusText = '';
                $statusIcon = '';
                if ($row['d90'] > 0) {
                    $statusClass = 'danger';
                    $statusText = 'Sangat Kritis (90+ hari)';
                    $statusIcon = 'alert-triangle';
                } elseif ($row['d60'] > 0) {
                    $statusClass = 'danger';
                    $statusText = 'Perlu Perhatian (60 hari)';
                    $statusIcon = 'alert-circle';
                } elseif ($row['d30'] > 0) {
                    $statusClass = 'warning';
                    $statusText = 'Mendekati Jatuh Tempo (30 hari)';
                    $statusIcon = 'clock';
                } else {
                    $statusClass = 'success';
                    $statusText = 'Dalam Kondisi Lancar';
                    $statusIcon = 'check-circle';
                }
            @endphp

            <div class="detail-total">
                <span class="label">Total Keseluruhan</span>
                <span class="value">{{ $currencySymbol . number_format($total, 0, ',', '.') }}</span>
            </div>

            <div style="text-align:center;">
                <span class="detail-status {{ $statusClass }}">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        @if($statusIcon == 'alert-triangle')
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        @elseif($statusIcon == 'alert-circle')
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        @elseif($statusIcon == 'clock')
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        @else
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        @endif
                    </svg>
                    {{ $statusText }}
                </span>
            </div>

            <div class="detail-actions">
                <a href="{{ route('aging.index') }}" class="detail-btn detail-btn-ghost" style="flex:1; justify-content:center;">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5"/>
                        <path d="M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Daftar
                </a>
                <button type="button" class="detail-btn detail-btn-primary" style="flex:1; justify-content:center;"
                        onclick="window.print()">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect x="6" y="14" width="12" height="8"/>
                    </svg>
                    Cetak Laporan
                </button>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ripple effect
            document.querySelectorAll('.detail-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });
        });
    </script>

</x-app-layout>