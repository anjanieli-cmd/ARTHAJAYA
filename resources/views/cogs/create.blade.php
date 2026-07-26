<x-app-layout>
    <x-slot name="title">Catat HPP</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    @endphp

    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </symbol>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
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
        .cogs-create-wrap {
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

        .cogs-create-wrap * { box-sizing: border-box; }
        .cogs-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

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

        .cogs-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .cogs-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .cogs-create-wrap .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== HEADER ===== */
        .cc-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .cc-header-left { flex: 1; min-width: 200px; }

        .cc-badge {
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

        .cc-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .cc-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .cc-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cc-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .cc-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .cc-btn {
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

        .cc-btn .icon { width: 16px; height: 16px; }
        .cc-btn:hover { transform: translateY(-2px); }
        .cc-btn:active { transform: translateY(0) scale(0.97); }

        .cc-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .cc-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .cc-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cc-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        /* ===== FORM LAYOUT ===== */
        .cc-wrap {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .cc-wrap {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }

        /* ===== CARD ===== */
        .cc-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 40px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            width: 100%;
        }

        .cc-card:hover {
            border-color: var(--border-hover);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .cc-card .title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cc-card .title .icon {
            width: 20px;
            height: 20px;
            color: var(--theme-primary);
        }

        .cc-card .title .line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, var(--border-color), transparent);
        }

        /* ===== INFO BOX ===== */
        .cc-info-box {
            background: var(--theme-soft);
            border: 1px solid var(--theme-glow);
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .cc-info-box .icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            margin-top: 1px;
            color: var(--theme-primary);
        }

        .cc-info-box .message {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .cc-info-box .message strong {
            color: var(--text-primary);
        }

        /* ===== FORM FIELD ===== */
        .cc-field {
            margin-bottom: 20px;
        }

        .cc-field:last-child { margin-bottom: 0; }

        .cc-field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .cc-field label .req {
            color: var(--danger);
            margin-left: 2px;
        }

        .cc-field label .opt {
            color: var(--text-tertiary);
            font-weight: 400;
        }

        .cc-input {
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

        .cc-input:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card-hover);
            box-shadow: 0 0 0 4px var(--theme-glow);
        }

        .cc-input::placeholder {
            color: var(--text-tertiary);
        }

        select.cc-input {
            cursor: pointer;
            appearance: auto;
            -webkit-appearance: auto;
            color-scheme: dark;
        }

        select.cc-input option {
            background-color: #12181f;
            color: #f2f4f7;
            padding: 10px 14px;
            font-size: 14px;
        }

        select.cc-input option:checked,
        select.cc-input option:hover {
            background-color: #17352c;
            color: #34d399;
        }

        textarea.cc-input {
            resize: vertical;
            min-height: 80px;
        }

        .cc-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .cc-grid-3 {
                grid-template-columns: 1fr 1fr;
                gap: 14px;
            }
        }

        @media (max-width: 640px) {
            .cc-grid-3 {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }

        .cc-hint {
            font-size: 11px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        .cc-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 4px;
        }

        /* ===== SIDEBAR ===== */
        .cc-sidebar {
            position: sticky;
            top: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .cc-total-ticker {
            background: linear-gradient(160deg, rgba(var(--emerald-rgb), 0.12), var(--surface) 60%);
            border: 1px solid var(--theme-glow);
            border-radius: var(--radius-md);
            padding: 24px 28px;
            transition: all 0.3s ease;
        }

        .cc-total-ticker:hover {
            border-color: var(--theme-primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .cc-total-ticker .lbl {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-tertiary);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .cc-total-ticker .amt {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--theme-primary);
            line-height: 1.2;
        }

        .cc-total-ticker .sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 6px;
        }

        .cc-total-ticker .sub strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .cc-tips {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 24px;
        }

        .cc-tips h4 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-tertiary);
            font-weight: 600;
            margin: 0 0 12px;
        }

        .cc-tips ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .cc-tips li {
            font-size: 13px;
            color: var(--text-secondary);
            padding-left: 18px;
            position: relative;
            line-height: 1.5;
        }

        .cc-tips li::before {
            content: '✦';
            position: absolute;
            left: 0;
            color: var(--theme-primary);
            font-size: 10px;
            top: 1px;
        }

        /* ===== FORM ACTIONS ===== */
        .cc-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        .cc-actions .cc-btn {
            flex: 1;
            justify-content: center;
            padding: 14px 24px;
            font-size: 14px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .cogs-create-wrap { padding: 0 12px; }
            .cc-card { padding: 20px 24px; }
            .cc-header { flex-direction: column; }
            .cc-header h1 { font-size: 24px; }
            .cc-actions { width: 100%; }
            .cc-actions .cc-btn { flex: 1; justify-content: center; }
            .cc-sidebar { position: relative; top: 0; }
            .cc-total-ticker .amt { font-size: 28px; }
            .cc-actions { flex-direction: column; }
            .cc-actions .cc-btn { flex: none; }
        }

        @media (max-width: 640px) {
            .cogs-create-wrap { padding: 0 8px; }
            .cc-card { padding: 16px; }
            .cc-header h1 { font-size: 20px; }
            .cc-btn { font-size: 12px; padding: 8px 14px; }
            .cc-btn .icon { width: 14px; height: 14px; }
            .cc-total-ticker .amt { font-size: 24px; }
        }

        @media (max-width: 380px) {
            .cogs-create-wrap { padding: 0 4px; }
            .cc-card { padding: 12px; }
        }
    </style>

    <div class="cogs-create-wrap">

        <!-- ===== HEADER ===== -->
        <div class="cc-header animate-in" style="animation-delay: 0.05s;">
            <div class="cc-header-left">
                <div class="cc-badge">
                    <span class="dot"></span>
                    Akuntansi
                </div>
                <h1>Catat Harga Pokok Penjualan</h1>
                <p class="subtitle">
                    Catat HPP dari transaksi penjualan barang — 
                    <strong>total otomatis dihitung</strong>
                </p>
            </div>
            <div class="cc-actions">
                <a href="{{ route('cogs.index') }}" class="cc-btn cc-btn-ghost">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- ===== FORM ===== -->
        <div class="cc-wrap animate-in" style="animation-delay: 0.10s;">
            <!-- Main Form -->
            <div class="cc-card">
                <div class="title">
                    <svg class="icon"><use href="#ic-package"/></svg>
                    Data Transaksi HPP
                    <span class="line"></span>
                </div>

                <form method="POST" action="{{ route('cogs.store') }}" id="cogsForm">
                    @csrf

                    <!-- Info Box -->
                    <div class="cc-info-box">
                        <svg class="icon"><use href="#ic-info"/></svg>
                        <div class="message">
                            <strong>Perhatian:</strong> Pilih barang dari inventaris agar stok otomatis berkurang. 
                            Harga pokok per unit diambil dari harga beli, bukan harga jual.
                        </div>
                    </div>

                    <!-- Item Name -->
                    <div class="cc-field">
                        <label>Nama Barang <span class="req">*</span></label>
                        <input type="text" name="item_name" id="itemName" class="cc-input" placeholder="Contoh: Batik Tulis Klasik" required>
                    </div>

                    <!-- Qty, Cost, Total -->
                    <div class="cc-grid-3">
                        <div class="cc-field">
                            <label>Jumlah Terjual <span class="req">*</span></label>
                            <input type="number" name="quantity_sold" id="qtyInput" class="cc-input" placeholder="0" min="0" step="1" required>
                        </div>
                        <div class="cc-field">
                            <label>Harga Pokok / Unit <span class="req">*</span></label>
                            <input type="number" name="unit_cost" id="costInput" class="cc-input" placeholder="0" min="0" step="100" required>
                        </div>
                        <div class="cc-field">
                            <label>Total HPP <span class="opt">(otomatis)</span></label>
                            <input type="text" id="totalDisplay" class="cc-input" value="Rp0" readonly style="cursor: default; font-weight: 700; color: var(--theme-primary);">
                            <input type="hidden" name="total_cogs" id="totalHidden" value="0">
                        </div>
                    </div>

                    <!-- Sale Date -->
                    <div class="cc-field" style="margin-top: 4px;">
                        <label>Tanggal Penjualan <span class="req">*</span></label>
                        <input type="date" name="sale_date" id="saleDate" class="cc-input" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- Notes -->
                    <div class="cc-field">
                        <label>Catatan <span class="opt">(opsional)</span></label>
                        <textarea name="notes" id="notes" class="cc-input" placeholder="Tambahkan catatan untuk transaksi ini..."></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="cc-actions">
                        <button type="submit" class="cc-btn cc-btn-primary">
                            <svg class="icon"><use href="#ic-check"/></svg>
                            Simpan Catatan
                        </button>
                        <a href="{{ route('cogs.index') }}" class="cc-btn cc-btn-ghost">
                            <svg class="icon"><use href="#ic-x"/></svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="cc-sidebar">
                <div class="cc-total-ticker">
                    <div class="lbl">Total HPP Transaksi Ini</div>
                    <div class="amt mono" id="totalTicker">Rp0</div>
                    <div class="sub" id="totalSub">0 unit × <strong>Rp0</strong></div>
                </div>

                <div class="cc-tips">
                    <h4>📘 Tips Pencatatan HPP</h4>
                    <ul>
                        <li>Pilih barang dari inventaris agar stok otomatis berkurang.</li>
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
            const buttons = document.querySelectorAll('.cc-btn');
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