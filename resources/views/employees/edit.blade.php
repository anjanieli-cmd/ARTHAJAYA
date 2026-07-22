<x-app-layout>
  <x-slot name="title">Edit HPP</x-slot>

  <style>
    /* ============================================
       HPP EDIT - Premium Design
       ============================================ */
    
    .hpp-wrap {
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
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
      max-width: 100%;
      padding: 0 24px;
    }

    .hpp-wrap * { box-sizing: border-box; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .hpp-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .hpp-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .hpp-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .hpp-header-left { flex: 1; min-width: 200px; }

    .hpp-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 16px 6px 12px;
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

    .hpp-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .hpp-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .hpp-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .hpp-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .hpp-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .hpp-btn {
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

    .hpp-btn .icon { width: 16px; height: 16px; }
    .hpp-btn:hover { transform: translateY(-2px); }
    .hpp-btn:active { transform: translateY(0) scale(0.97); }

    .hpp-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .hpp-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .hpp-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .hpp-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .hpp-btn .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: scale(0);
      animation: rippleAnim 0.6s ease-out forwards;
      pointer-events: none;
    }

    @keyframes rippleAnim {
      to { transform: scale(4); opacity: 0; }
    }

    /* FORM LAYOUT - FULL WIDTH */
    .hpp-form {
      width: 100%;
      max-width: 100%;
      display: grid;
      grid-template-columns: 1fr 340px;
      gap: 24px;
      align-items: start;
    }

    @media (max-width: 1024px) {
      .hpp-form {
        grid-template-columns: 1fr;
        gap: 24px;
      }
    }

    .hpp-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 32px 40px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      width: 100%;
    }

    .hpp-card:hover {
      border-color: var(--border-hover);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .hpp-card .title {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .hpp-card .title .icon {
      width: 20px;
      height: 20px;
      color: var(--theme-primary);
    }

    .hpp-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* FORM GROUP */
    .hpp-form-group {
      margin-bottom: 20px;
    }

    .hpp-form-group:last-child { margin-bottom: 0; }

    .hpp-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
    }

    .hpp-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .hpp-form-group input,
    .hpp-form-group select,
    .hpp-form-group textarea {
      width: 100%;
      padding: 12px 16px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s ease;
      outline: none;
    }

    .hpp-form-group input:focus,
    .hpp-form-group select:focus,
    .hpp-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .hpp-form-group input::placeholder,
    .hpp-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .hpp-form-group textarea {
      resize: vertical;
      min-height: 90px;
    }

    .hpp-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .hpp-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 14px;
    }

    .hpp-form-group select option:checked,
    .hpp-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .hpp-form-group select option:disabled {
      color: #6b7280;
    }

    .hpp-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 20px;
    }

    @media (max-width: 768px) {
      .hpp-form-row {
        grid-template-columns: 1fr 1fr;
        gap: 14px;
      }
    }

    @media (max-width: 480px) {
      .hpp-form-row {
        grid-template-columns: 1fr;
        gap: 0;
      }
    }

    /* INFO BOX */
    .hpp-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-sm);
      padding: 14px 18px;
      margin-bottom: 20px;
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .hpp-info-box .icon {
      width: 22px;
      height: 22px;
      flex-shrink: 0;
      margin-top: 1px;
      color: var(--theme-primary);
    }

    .hpp-info-box .message {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.6;
    }

    .hpp-info-box .message strong {
      color: var(--text-primary);
    }

    /* SIDEBAR - Summary & Tips */
    .hpp-sidebar {
      position: sticky;
      top: 24px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .hpp-total-ticker {
      background: linear-gradient(160deg, rgba(var(--emerald-rgb), 0.12), var(--surface) 60%);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-md);
      padding: 24px 28px;
      transition: all 0.3s ease;
    }

    .hpp-total-ticker:hover {
      border-color: var(--theme-primary);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .hpp-total-ticker .lbl {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--text-tertiary);
      font-weight: 600;
      margin-bottom: 8px;
    }

    .hpp-total-ticker .amt {
      font-family: 'Space Grotesk', 'Inter', sans-serif;
      font-size: 32px;
      font-weight: 700;
      color: var(--theme-primary);
      line-height: 1.2;
    }

    .hpp-total-ticker .sub {
      font-size: 13px;
      color: var(--text-secondary);
      margin-top: 6px;
    }

    .hpp-total-ticker .sub strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .hpp-tips {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 20px 24px;
    }

    .hpp-tips h4 {
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--text-tertiary);
      font-weight: 600;
      margin: 0 0 12px;
    }

    .hpp-tips ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .hpp-tips li {
      font-size: 13px;
      color: var(--text-secondary);
      padding-left: 18px;
      position: relative;
      line-height: 1.5;
    }

    .hpp-tips li::before {
      content: '✦';
      position: absolute;
      left: 0;
      color: var(--theme-primary);
      font-size: 10px;
      top: 1px;
    }

    /* FORM ACTIONS */
    .hpp-form-actions {
      display: flex;
      gap: 12px;
      margin-top: 24px;
      padding-top: 24px;
      border-top: 1px solid var(--border-color);
    }

    .hpp-form-actions .hpp-btn {
      flex: 1;
      justify-content: center;
      padding: 14px 24px;
      font-size: 14px;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .hpp-wrap { padding: 0 16px; }
      .hpp-card { padding: 24px 28px; }
    }

    @media (max-width: 768px) {
      .hpp-wrap { padding: 0 12px; }
      .hpp-card { padding: 20px; }
      .hpp-header h1 { font-size: 24px; }
      .hpp-sidebar { position: relative; top: 0; }
      .hpp-total-ticker .amt { font-size: 28px; }
    }

    @media (max-width: 640px) {
      .hpp-header { 
        flex-direction: column; 
      }
      .hpp-actions { 
        width: 100%; 
      }
      .hpp-actions .hpp-btn { 
        flex: 1; 
        justify-content: center; 
      }
      .hpp-form-actions { 
        flex-direction: column; 
      }
      .hpp-form-actions .hpp-btn { 
        flex: none; 
      }
      .hpp-card { padding: 16px; }
      .hpp-total-ticker { padding: 20px; }
    }

    @media (max-width: 380px) {
      .hpp-header h1 { 
        font-size: 20px; 
      }
      .hpp-btn { 
        font-size: 12px; 
        padding: 8px 14px; 
      }
      .hpp-btn .icon { 
        width: 14px; 
        height: 14px; 
      }
      .hpp-card { padding: 12px; }
    }
  </style>

  <div class="hpp-wrap">

    <!-- ===== HEADER ===== -->
    <div class="hpp-header animate-in" style="animation-delay: 0.05s;">
      <div class="hpp-header-left">
        <div class="hpp-badge">
          <span class="dot"></span>
          Inventory &amp; COGS
        </div>
        <h1>Edit HPP</h1>
        <p class="subtitle">
          Perbarui data transaksi HPP untuk — <strong>{{ $entry->item_name }}</strong>
        </p>
      </div>
      <div class="hpp-actions">
        <a href="{{ route('cogs.index') }}" class="hpp-btn hpp-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <!-- ===== FORM ===== -->
    <form method="POST" action="{{ route('cogs.update', $entry) }}" class="hpp-form" id="cogsForm">
      @csrf
      @method('PUT')

      <!-- Main Form -->
      <div class="hpp-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-box"/></svg>
          Data Transaksi HPP
          <span class="line"></span>
        </div>

        <!-- Info Box -->
        <div class="hpp-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <div class="message">
            <strong>Perhatian:</strong> Mengubah jumlah terjual akan otomatis menyesuaikan stok barang terkait. 
            Harga pokok per unit diambil dari harga beli, bukan harga jual.
          </div>
        </div>

        <!-- Item Name -->
        <div class="hpp-form-group">
          <label>Nama Item <span class="required">*</span></label>
          <input type="text" name="item_name" value="{{ $entry->item_name }}" placeholder="Contoh: Batik Tulis Klasik" required>
        </div>

        <!-- Qty, Cost, Total -->
        <div class="hpp-form-row">
          <div class="hpp-form-group">
            <label>Jumlah Terjual <span class="required">*</span></label>
            <input type="number" name="quantity" id="qtyInput" value="{{ $entry->quantity }}" placeholder="0" min="0" step="1" required>
          </div>
          <div class="hpp-form-group">
            <label>Harga Pokok / Unit <span class="required">*</span></label>
            <input type="number" name="unit_cost" id="costInput" value="{{ $entry->unit_cost }}" placeholder="0" min="0" step="100" required>
          </div>
          <div class="hpp-form-group">
            <label>Total HPP (Otomatis)</label>
            <input type="text" id="totalDisplay" value="Rp0" readonly style="background: var(--bg-card-active); cursor: default; font-weight: 600; color: var(--theme-primary);">
          </div>
        </div>

        <!-- Hidden total field -->
        <input type="hidden" name="total_cost" id="totalInput" value="{{ $entry->total_cost }}">

        <!-- Notes -->
        <div class="hpp-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Tambahkan catatan untuk transaksi ini...">{{ $entry->notes }}</textarea>
        </div>

        <!-- Actions -->
        <div class="hpp-form-actions">
          <button type="submit" class="hpp-btn hpp-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan Perubahan
          </button>
          <a href="{{ route('cogs.index') }}" class="hpp-btn hpp-btn-ghost">
            Batal
          </a>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="hpp-sidebar animate-in" style="animation-delay: 0.15s;">
        <div class="hpp-total-ticker">
          <div class="lbl">Total HPP Transaksi Ini</div>
          <div class="amt" id="totalTicker">Rp0</div>
          <div class="sub" id="totalSub">0 unit × <strong>Rp0</strong></div>
        </div>

        <div class="hpp-tips">
          <h4>Tips Pencatatan HPP</h4>
          <ul>
            <li>Mengubah jumlah terjual akan otomatis menyesuaikan stok barang terkait.</li>
            <li>Harga pokok per unit diambil dari harga beli, bukan harga jual.</li>
            <li>Total dihitung otomatis: jumlah terjual × harga pokok per unit.</li>
          </ul>
        </div>
      </div>

    </form>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
    <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
    <symbol id="ic-box" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      function fmtRupiah(n){
        n = isNaN(n) ? 0 : n;
        return 'Rp' + n.toLocaleString('id-ID', {maximumFractionDigits:0});
      }

      function updateTicker(){
        var qty = parseFloat(document.getElementById('qtyInput')?.value) || 0;
        var cost = parseFloat(document.getElementById('costInput')?.value) || 0;
        var total = qty * cost;
        
        // Update display
        document.getElementById('totalTicker').textContent = fmtRupiah(total);
        document.getElementById('totalSub').innerHTML = qty + ' unit × <strong>' + fmtRupiah(cost) + '</strong>';
        document.getElementById('totalDisplay').value = fmtRupiah(total);
        document.getElementById('totalInput').value = total;
      }

      // Auto update on input
      const form = document.getElementById('cogsForm');
      form.addEventListener('input', updateTicker);
      
      // Initial update
      setTimeout(updateTicker, 50);

      // Ripple effect
      const buttons = document.querySelectorAll('.hpp-btn');
      buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
          const rect = this.getBoundingClientRect();
          const ripple = document.createElement('span');
          ripple.className = 'ripple';
          const size = Math.max(rect.width, rect.height);
          ripple.style.width = ripple.style.height = size + 'px';
          ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
          ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
          this.appendChild(ripple);
          setTimeout(() => { ripple.remove(); }, 600);
        });
      });
    });
  </script>

</x-app-layout>