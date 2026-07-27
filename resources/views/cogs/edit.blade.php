<x-app-layout>
    <x-slot name="title">Edit HPP - {{ $entry->item_name }}</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    @endphp

    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </symbol>
            <symbol id="ic-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
            </symbol>
            <symbol id="ic-package" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/>
                <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .cogs-edit-wrap {
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
            
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
            width: 100%;
            max-width: 100%;
        }

        .cogs-edit-wrap * { box-sizing: border-box; }
        .cogs-edit-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

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

        .cogs-edit-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .cogs-edit-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .cogs-edit-wrap .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== HEADER ===== */
        .ce-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ce-header-left { flex: 1; min-width: 200px; }

        .ce-badge {
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

        .ce-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ce-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ce-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ce-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .ce-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .ce-btn {
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

        .ce-btn .icon { width: 16px; height: 16px; }
        .ce-btn:hover { transform: translateY(-2px); }
        .ce-btn:active { transform: translateY(0) scale(0.97); }

        .ce-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ce-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .ce-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ce-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        /* ===== FORM LAYOUT ===== */
        .ce-wrap {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .ce-wrap {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }

        /* ===== CARD ===== */
        .ce-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 40px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            width: 100%;
        }

        .ce-card:hover {
            border-color: var(--border-hover);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .ce-card .title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ce-card .title .icon {
            width: 20px;
            height: 20px;
            color: var(--theme-primary);
        }

        .ce-card .title .line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, var(--border-color), transparent);
        }

        /* ===== INFO BOX ===== */
        .ce-info-box {
            background: var(--theme-soft);
            border: 1px solid var(--theme-glow);
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .ce-info-box .icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            margin-top: 1px;
            color: var(--theme-primary);
        }

        .ce-info-box .message {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .ce-info-box .message strong {
            color: var(--text-primary);
        }

        /* ===== FORM FIELD ===== */
        .ce-field {
            margin-bottom: 20px;
        }

        .ce-field:last-child { margin-bottom: 0; }

        .ce-field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .ce-field label .req {
            color: var(--danger);
            margin-left: 2px;
        }

        .ce-field label .opt {
            color: var(--text-tertiary);
            font-weight: 400;
        }

        .ce-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .ce-input:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card-hover);
            box-shadow: 0 0 0 4px var(--theme-glow);
        }

        .ce-input::placeholder {
            color: var(--text-tertiary);
        }

        select.ce-input {
            cursor: pointer;
            appearance: auto;
            -webkit-appearance: auto;
            color-scheme: dark;
        }

        select.ce-input option {
            background-color: #12181f;
            color: #f2f4f7;
            padding: 10px 14px;
            font-size: 14px;
        }

        select.ce-input option:checked,
        select.ce-input option:hover {
            background-color: #17352c;
            color: #34d399;
        }

        textarea.ce-input {
            resize: vertical;
            min-height: 80px;
        }

        .ce-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .ce-grid-3 {
                grid-template-columns: 1fr 1fr;
                gap: 14px;
            }
        }

        @media (max-width: 640px) {
            .ce-grid-3 {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }

        .ce-hint {
            font-size: 11px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        .ce-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 4px;
        }

        /* ===== SIDEBAR ===== */
        .ce-sidebar {
            position: sticky;
            top: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .ce-total-ticker {
            background: linear-gradient(160deg, rgba(var(--emerald-rgb), 0.12), var(--surface) 60%);
            border: 1px solid var(--theme-glow);
            border-radius: var(--radius-md);
            padding: 24px 28px;
            transition: all 0.3s ease;
        }

        .ce-total-ticker:hover {
            border-color: var(--theme-primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .ce-total-ticker .lbl {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-tertiary);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .ce-total-ticker .amt {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--theme-primary);
            line-height: 1.2;
        }

        .ce-total-ticker .sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 6px;
        }

        .ce-total-ticker .sub strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .ce-tips {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 24px;
        }

        .ce-tips h4 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-tertiary);
            font-weight: 600;
            margin: 0 0 12px;
        }

        .ce-tips ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .ce-tips li {
            font-size: 13px;
            color: var(--text-secondary);
            padding-left: 18px;
            position: relative;
            line-height: 1.5;
        }

        .ce-tips li::before {
            content: '✦';
            position: absolute;
            left: 0;
            color: var(--theme-primary);
            font-size: 10px;
            top: 1px;
        }

        /* ===== FORM ACTIONS ===== */
        .ce-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        .ce-actions .ce-btn {
            flex: 1;
            justify-content: center;
            padding: 14px 24px;
            font-size: 14px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .cogs-edit-wrap { padding: 0 12px; }
            .ce-card { padding: 20px 24px; }
            .ce-header { flex-direction: column; }
            .ce-header h1 { font-size: 24px; }
            .ce-actions { width: 100%; }
            .ce-actions .ce-btn { flex: 1; justify-content: center; }
            .ce-sidebar { position: relative; top: 0; }
            .ce-total-ticker .amt { font-size: 28px; }
            .ce-actions { flex-direction: column; }
            .ce-actions .ce-btn { flex: none; }
        }

        @media (max-width: 640px) {
            .cogs-edit-wrap { padding: 0 8px; }
            .ce-card { padding: 16px; }
            .ce-header h1 { font-size: 20px; }
            .ce-btn { font-size: 12px; padding: 8px 14px; }
            .ce-btn .icon { width: 14px; height: 14px; }
            .ce-total-ticker .amt { font-size: 24px; }
        }

        @media (max-width: 380px) {
            .cogs-edit-wrap { padding: 0 4px; }
            .ce-card { padding: 12px; }
        }
    </style>

    <div class="cogs-edit-wrap">

        <!-- ===== HEADER ===== -->
        <div class="ce-header animate-in" style="animation-delay: 0.05s;">
            <div class="ce-header-left">
                <div class="ce-badge">
                    <span class="dot"></span>
                    Akuntansi
                </div>
                <h1>Edit HPP</h1>
                <p class="subtitle">
                    Perbarui data transaksi HPP — 
                    <strong>{{ $entry->item_name }}</strong>
                </p>
            </div>
            <div class="ce-actions">
                <a href="{{ route('cogs.index') }}" class="ce-btn ce-btn-ghost">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- ===== FORM ===== -->
        <div class="ce-wrap animate-in" style="animation-delay: 0.10s;">
            <!-- Main Form -->
            <div class="ce-card">
                <div class="title">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Edit Data Transaksi HPP
                    <span class="line"></span>
                </div>

                <form method="POST" action="{{ route('cogs.update', ['entry' => $entry->id]) }}" id="cogsForm">
                    @csrf
                    @method('PUT')

                    <!-- Info Box -->
                    <div class="ce-info-box">
                        <svg class="icon"><use href="#ic-info"/></svg>
                        <div class="message">
                            <strong>Perhatian:</strong> Mengubah jumlah terjual akan otomatis menyesuaikan stok barang terkait. 
                            Harga pokok per unit diambil dari harga beli, bukan harga jual.
                        </div>
                    </div>

                    <!-- Item Name -->
                    <div class="ce-field">
                        <label>Nama Barang <span class="req">*</span></label>
                        <input type="text" name="item_name" id="itemName" class="ce-input" value="{{ $entry->item_name }}" placeholder="Contoh: Batik Tulis Klasik" required>
                    </div>

                    <!-- Qty, Cost, Total -->
                    <div class="ce-grid-3">
                        <div class="ce-field">
                            <label>Jumlah Terjual <span class="req">*</span></label>
                            <input type="number" name="quantity_sold" id="qtyInput" class="ce-input" value="{{ $entry->quantity_sold }}" placeholder="0" min="0" step="1" required>
                        </div>
                        <div class="ce-field">
                            <label>Harga Pokok / Unit <span class="req">*</span></label>
                            <input type="number" name="unit_cost" id="costInput" class="ce-input" value="{{ $entry->unit_cost }}" placeholder="0" min="0" step="100" required>
                        </div>
                        <div class="ce-field">
                            <label>Total HPP <span class="opt">(otomatis)</span></label>
                            <input type="text" id="totalDisplay" class="ce-input" value="Rp{{ number_format($entry->total_cogs, 0, ',', '.') }}" readonly style="cursor: default; font-weight: 700; color: var(--theme-primary);">
                            <input type="hidden" name="total_cogs" id="totalHidden" value="{{ $entry->total_cogs }}">
                        </div>
                    </div>

                    <!-- Sale Date -->
                    <div class="ce-field" style="margin-top: 4px;">
                        <label>Tanggal Penjualan <span class="req">*</span></label>
                        <input type="date" name="sale_date" id="saleDate" class="ce-input" value="{{ $entry->sale_date->format('Y-m-d') }}" required>
                    </div>

                    <!-- Notes -->
                    <div class="ce-field">
                        <label>Catatan <span class="opt">(opsional)</span></label>
                        <textarea name="notes" id="notes" class="ce-input" placeholder="Tambahkan catatan untuk transaksi ini...">{{ $entry->notes }}</textarea>
                    </div>

                    <!-- Actions -->
                    <div class="ce-actions">
                        <button type="submit" class="ce-btn ce-btn-primary">
                            <svg class="icon"><use href="#ic-check"/></svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('cogs.index') }}" class="ce-btn ce-btn-ghost">
                            <svg class="icon"><use href="#ic-x"/></svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="ce-sidebar">
                <div class="ce-total-ticker">
                    <div class="lbl">Total HPP Transaksi Ini</div>
                    <div class="amt mono" id="totalTicker">Rp{{ number_format($entry->total_cogs, 0, ',', '.') }}</div>
                    <div class="sub" id="totalSub">{{ $entry->quantity_sold }} unit × <strong>Rp{{ number_format($entry->unit_cost, 0, ',', '.') }}</strong></div>
                </div>

                <div class="ce-tips">
                    <h4>📘 Tips Pencatatan HPP</h4>
                    <ul>
                        <li>Mengubah jumlah terjual akan otomatis menyesuaikan stok barang terkait.</li>
                        <li>Harga pokok per unit diambil dari harga beli, bukan harga jual.</li>
                        <li>Total dihitung otomatis: jumlah terjual × harga pokok per unit.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function fmtRupiah(n) {
                n = isNaN(n) ? 0 : n;
                return 'Rp' + n.toLocaleString('id-ID', {maximumFractionDigits: 0});
            }

            function updateTicker() {
                var qty = parseFloat(document.getElementById('qtyInput')?.value) || 0;
                var cost = parseFloat(document.getElementById('costInput')?.value) || 0;
                var total = qty * cost;

                document.getElementById('totalTicker').textContent = fmtRupiah(total);
                document.getElementById('totalSub').innerHTML = qty + ' unit × <strong>' + fmtRupiah(cost) + '</strong>';
                document.getElementById('totalDisplay').value = fmtRupiah(total);
                document.getElementById('totalHidden').value = total;
            }

            const form = document.getElementById('cogsForm');
            form.addEventListener('input', updateTicker);
            setTimeout(updateTicker, 50);

            // Ripple effect
            const buttons = document.querySelectorAll('.ce-btn');
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
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

</x-app-layout>