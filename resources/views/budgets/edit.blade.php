<x-app-layout>
  <x-slot name="title">Edit Anggaran</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // Pastikan $budget adalah array
    if (is_object($budget)) {
        $budget = (array) $budget;
    }

    // Default values jika ada yang kosong
    $budget = array_merge([
        'id' => 0,
        'category' => '',
        'period' => date('Y'),
        'target' => 0,
        'actual' => 0,
        'status' => 'on_track',
        'notes' => '',
        'created_by' => '-',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ], $budget);
  @endphp

  <style>
    /* ============================================
       BUDGET EDIT - Premium Design
       ============================================ */
    
    .be-wrap {
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
    }

    .be-wrap * { box-sizing: border-box; }
    .be-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .be-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .be-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .be-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .be-header-left { flex: 1; min-width: 200px; }

    .be-badge {
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

    .be-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .be-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .be-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .be-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .be-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .be-btn {
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

    .be-btn .icon { width: 16px; height: 16px; }
    .be-btn:hover { transform: translateY(-2px); }
    .be-btn:active { transform: translateY(0) scale(0.97); }

    .be-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
      border: none;
    }

    .be-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .be-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .be-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .be-btn .ripple {
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

    /* FORM - FULL WIDTH */
    .be-form {
      width: 100%;
    }

    .be-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 32px 40px;
      transition: border-color 0.22s ease;
      width: 100%;
    }

    .be-card:hover { border-color: var(--border-hover); }

    .be-card .title {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .be-card .title .icon {
      width: 20px;
      height: 20px;
      color: var(--theme-primary);
    }

    .be-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* FORM GROUP */
    .be-form-group {
      margin-bottom: 20px;
    }

    .be-form-group:last-child { margin-bottom: 0; }

    .be-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 6px;
    }

    .be-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .be-form-group input,
    .be-form-group select,
    .be-form-group textarea {
      width: 100%;
      padding: 11px 16px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      transition: all 0.2s ease;
      outline: none;
    }

    .be-form-group input:focus,
    .be-form-group select:focus,
    .be-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .be-form-group input::placeholder,
    .be-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .be-form-group textarea {
      resize: vertical;
      min-height: 90px;
    }

    .be-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .be-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 14px;
    }

    .be-form-group select option:checked,
    .be-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .be-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    /* INFO BOX */
    .be-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-sm);
      padding: 14px 18px;
      margin-bottom: 24px;
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .be-info-box .icon {
      width: 22px;
      height: 22px;
      flex-shrink: 0;
      margin-top: 1px;
      color: var(--theme-primary);
    }

    .be-info-box .message {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.6;
    }

    .be-info-box .message strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    /* FORM ACTIONS */
    .be-form-actions {
      display: flex;
      gap: 12px;
      margin-top: 28px;
      padding-top: 24px;
      border-top: 1px solid var(--border-color);
    }

    .be-form-actions .be-btn {
      flex: 1;
      justify-content: center;
      padding: 12px 24px;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .be-card { padding: 28px 32px; }
    }

    @media (max-width: 768px) {
      .be-card { padding: 24px 28px; }
      .be-header h1 { font-size: 24px; }
      .be-form-row { grid-template-columns: 1fr; gap: 0; }
    }

    @media (max-width: 640px) {
      .be-header { flex-direction: column; }
      .be-actions { width: 100%; }
      .be-actions .be-btn { flex: 1; justify-content: center; }
      .be-form-actions { flex-direction: column; }
      .be-form-actions .be-btn { flex: none; }
      .be-card { padding: 20px; }
    }

    @media (max-width: 380px) {
      .be-header h1 { font-size: 20px; }
      .be-btn { font-size: 12px; padding: 8px 14px; }
      .be-btn .icon { width: 14px; height: 14px; }
      .be-card { padding: 16px; }
    }
  </style>

  <div class="be-wrap">

    <!-- ===== HEADER ===== -->
    <div class="be-header animate-in" style="animation-delay: 0.05s;">
      <div class="be-header-left">
        <div class="be-badge">
          <span class="dot"></span>
          Keuangan
        </div>
        <h1>Edit Anggaran</h1>
        <p class="subtitle">
          Perbarui data anggaran untuk — <strong>{{ $budget['category'] ?: 'Kategori' }}</strong>
        </p>
      </div>
      <div class="be-actions">
        <a href="{{ route('budgets.index') }}" class="be-btn be-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <!-- ===== FORM ===== -->
    <form action="{{ route('budgets.update', ['index' => $budget['id']]) }}" method="POST" class="be-form">
      @csrf
      @method('PUT')

      <div class="be-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-target"/></svg>
          Informasi Anggaran
          <span class="line"></span>
        </div>

        <div class="be-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <div class="message">
            <strong>Perhatian:</strong> Perbarui data anggaran sesuai dengan perkembangan terbaru. Pastikan semua data diisi dengan benar.
          </div>
        </div>

        <!-- Kategori -->
        <div class="be-form-group">
          <label>Kategori <span class="required">*</span></label>
          <select name="category" required>
            <option value="">Pilih Kategori</option>
            <option value="Pendapatan" {{ $budget['category'] == 'Pendapatan' ? 'selected' : '' }}>Pendapatan</option>
            <option value="Bahan Baku" {{ $budget['category'] == 'Bahan Baku' ? 'selected' : '' }}>Bahan Baku</option>
            <option value="Biaya Produksi" {{ $budget['category'] == 'Biaya Produksi' ? 'selected' : '' }}>Biaya Produksi</option>
            <option value="Marketing" {{ $budget['category'] == 'Marketing' ? 'selected' : '' }}>Marketing</option>
            <option value="Operasional" {{ $budget['category'] == 'Operasional' ? 'selected' : '' }}>Operasional</option>
            <option value="Utilitas" {{ $budget['category'] == 'Utilitas' ? 'selected' : '' }}>Utilitas</option>
            <option value="Pengembangan" {{ $budget['category'] == 'Pengembangan' ? 'selected' : '' }}>Pengembangan</option>
            <option value="Gaji" {{ $budget['category'] == 'Gaji' ? 'selected' : '' }}>Gaji</option>
            <option value="Pajak" {{ $budget['category'] == 'Pajak' ? 'selected' : '' }}>Pajak</option>
            <option value="Lainnya" {{ $budget['category'] == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
          </select>
        </div>

        <!-- Periode & Target -->
        <div class="be-form-row">
          <div class="be-form-group">
            <label>Periode <span class="required">*</span></label>
            <select name="period" required>
              <option value="2024" {{ $budget['period'] == '2024' ? 'selected' : '' }}>2024</option>
              <option value="2025" {{ $budget['period'] == '2025' ? 'selected' : '' }}>2025</option>
              <option value="2026" {{ $budget['period'] == '2026' ? 'selected' : '' }}>2026</option>
              <option value="2027" {{ $budget['period'] == '2027' ? 'selected' : '' }}>2027</option>
            </select>
          </div>
          <div class="be-form-group">
            <label>Target Anggaran <span class="required">*</span></label>
            <input type="number" name="target" value="{{ $budget['target'] }}" placeholder="0" min="0" step="1000" required>
          </div>
        </div>

        <!-- Realisasi -->
        <div class="be-form-group">
          <label>Realisasi</label>
          <input type="number" name="actual" value="{{ $budget['actual'] }}" placeholder="0" min="0" step="1000">
        </div>

        <!-- Status -->
        <div class="be-form-group">
          <label>Status <span class="required">*</span></label>
          <select name="status" required>
            <option value="on_track" {{ $budget['status'] == 'on_track' ? 'selected' : '' }}>On Track</option>
            <option value="over_budget" {{ $budget['status'] == 'over_budget' ? 'selected' : '' }}>Over Budget</option>
            <option value="under_budget" {{ $budget['status'] == 'under_budget' ? 'selected' : '' }}>Under Budget</option>
          </select>
        </div>

        <!-- Catatan -->
        <div class="be-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Tambahkan catatan untuk anggaran ini...">{{ $budget['notes'] }}</textarea>
        </div>

        <!-- Actions -->
        <div class="be-form-actions">
          <button type="submit" class="be-btn be-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Update Anggaran
          </button>
          <a href="{{ route('budgets.index') }}" class="be-btn be-btn-ghost">
            Batal
          </a>
        </div>
      </div>

    </form>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
    <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
    <symbol id="ic-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.be-btn');
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