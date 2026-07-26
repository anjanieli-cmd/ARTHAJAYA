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
    ], $budget);

    $statusLabel = [
        'on_track' => 'On Track',
        'over_budget' => 'Over Budget',
        'under_budget' => 'Under Budget'
    ];

    $statusPill = [
        'on_track' => 'on-track',
        'over_budget' => 'over-budget',
        'under_budget' => 'under-budget'
    ];

    $progress = $budget['target'] > 0 ? round(($budget['actual'] / $budget['target']) * 100) : 0;
    $progressColor = $progress > 100 ? 'red' : ($progress < 70 ? 'yellow' : 'green');
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
      padding: 0 24px;
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

    @keyframes rippleAnim {
      to { transform: scale(4); opacity: 0; }
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
      font-family: 'Inter', sans-serif;
    }

    .be-btn .icon { width: 16px; height: 16px; }
    .be-btn:hover { transform: translateY(-2px); }
    .be-btn:active { transform: translateY(0) scale(0.97); }

    .be-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
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

    /* FORM LAYOUT - Grid */
    .be-form-wrap {
      display: grid;
      grid-template-columns: 1fr 340px;
      gap: 24px;
      align-items: start;
    }

    @media (max-width: 1024px) {
      .be-form-wrap { grid-template-columns: 1fr; gap: 24px; }
    }

    .be-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: border-color 0.22s ease;
    }

    .be-card:hover { border-color: var(--border-hover); }

    .be-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .be-card .title .icon {
      width: 18px;
      height: 18px;
      color: var(--theme-primary);
      margin-right: 8px;
      vertical-align: middle;
    }

    /* FORM GROUP */
    .be-form-group { margin-bottom: 18px; }
    .be-form-group:last-child { margin-bottom: 0; }

    .be-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 5px;
    }

    .be-form-group .required { color: var(--danger); margin-left: 2px; }

    .be-form-group input,
    .be-form-group select,
    .be-form-group textarea {
      width: 100%;
      padding: 10px 14px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 13px;
      font-family: 'Inter', sans-serif;
      transition: all 0.2s ease;
      outline: none;
    }

    .be-form-group input:focus,
    .be-form-group select:focus,
    .be-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
    }

    .be-form-group input::placeholder,
    .be-form-group textarea::placeholder { color: var(--text-tertiary); }

    .be-form-group textarea { resize: vertical; min-height: 80px; }

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
      font-size: 13px;
    }

    .be-form-group select option:checked,
    .be-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .be-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    @media (max-width: 480px) {
      .be-form-row { grid-template-columns: 1fr; gap: 0; }
    }

    /* INFO BOX */
    .be-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-primary);
      border-radius: var(--radius-sm);
      padding: 12px 16px;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--theme-primary);
    }

    .be-info-box .icon { width: 20px; height: 20px; flex-shrink: 0; }
    .be-info-box .message { font-size: 13px; font-weight: 500; }

    /* SIDEBAR - Preview & Tips */
    .be-sidebar {
      position: sticky;
      top: 24px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .be-preview {
      background: linear-gradient(160deg, rgba(var(--emerald-rgb), 0.12), var(--surface) 60%);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-md);
      padding: 24px 28px;
      transition: all 0.3s ease;
    }

    .be-preview:hover {
      border-color: var(--theme-primary);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .be-preview .lbl {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--text-tertiary);
      font-weight: 600;
      margin-bottom: 8px;
    }

    .be-preview .progress-bar {
      height: 8px;
      border-radius: 100px;
      background: var(--bg-card-active);
      overflow: hidden;
      margin: 10px 0 8px;
    }

    .be-preview .progress-bar .fill {
      height: 100%;
      border-radius: 100px;
      transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .be-preview .progress-bar .fill.green { background: var(--success); }
    .be-preview .progress-bar .fill.red { background: var(--danger); }
    .be-preview .progress-bar .fill.yellow { background: var(--warning); }

    .be-preview .amt {
      font-family: 'Space Grotesk', 'Inter', sans-serif;
      font-size: 28px;
      font-weight: 700;
      color: var(--theme-primary);
      line-height: 1.2;
    }

    .be-preview .sub {
      font-size: 13px;
      color: var(--text-secondary);
      margin-top: 6px;
    }

    .be-preview .sub strong { color: var(--text-primary); font-weight: 600; }

    .be-preview .status-pill {
      display: inline-block;
      margin-top: 10px;
      font-size: 10px;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 100px;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .be-preview .status-pill.on-track { background: var(--success-soft); color: var(--success); }
    .be-preview .status-pill.over-budget { background: var(--danger-soft); color: var(--danger); }
    .be-preview .status-pill.under-budget { background: var(--warning-soft); color: var(--warning); }

    .be-tips {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 20px 24px;
    }

    .be-tips h4 {
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--text-tertiary);
      font-weight: 600;
      margin: 0 0 12px;
    }

    .be-tips ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .be-tips li {
      font-size: 13px;
      color: var(--text-secondary);
      padding-left: 18px;
      position: relative;
      line-height: 1.5;
    }

    .be-tips li::before {
      content: '✦';
      position: absolute;
      left: 0;
      color: var(--theme-primary);
      font-size: 10px;
      top: 1px;
    }

    /* FORM ACTIONS */
    .be-form-actions { display: flex; gap: 10px; margin-top: 24px; }
    .be-form-actions .be-btn { flex: 1; justify-content: center; }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .be-wrap { padding: 0 16px; }
      .be-card { padding: 24px 28px; }
    }

    @media (max-width: 768px) {
      .be-wrap { padding: 0 12px; }
      .be-header h1 { font-size: 24px; }
      .be-sidebar { position: relative; top: 0; }
      .be-preview .amt { font-size: 24px; }
      .be-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .be-header { flex-direction: column; }
      .be-actions { width: 100%; }
      .be-actions .be-btn { flex: 1; justify-content: center; }
      .be-form-actions { flex-direction: column; }
      .be-form-actions .be-btn { flex: none; }
      .be-card { padding: 16px; }
      .be-preview { padding: 20px; }
    }

    @media (max-width: 380px) {
      .be-wrap { padding: 0 8px; }
      .be-header h1 { font-size: 20px; }
      .be-btn { font-size: 12px; padding: 8px 14px; }
      .be-btn .icon { width: 14px; height: 14px; }
      .be-card { padding: 12px; }
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
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow"/></svg>
          Kembali
        </a>
      </div>
    </div>

    @if ($errors->any())
      <div class="be-info-box" style="background:var(--danger-soft);border-color:var(--danger);color:var(--danger);">
        <svg class="icon"><use href="#ic-alert"/></svg>
        <span class="message">Ada input yang belum sesuai, cek lagi ya di bawah.</span>
      </div>
    @endif

    <!-- ===== FORM ===== -->
    <form method="POST" action="{{ route('budgets.update', $budget['id']) }}" class="be-form-wrap" id="budgetForm">
      @csrf
      @method('PUT')

      <!-- Main Form -->
      <div class="be-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-target"/></svg>
          Detail Anggaran
        </div>

        <div class="be-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <span class="message">Progress dan status akan dihitung otomatis dari target &amp; realisasi.</span>
        </div>

        <!-- Kategori - INPUT MANUAL -->
        <div class="be-form-group">
          <label>Kategori <span class="required">*</span></label>
          <input type="text" name="category" id="categoryInput" 
                 value="{{ old('category', $budget['category']) }}"
                 class="{{ $errors->has('category') ? 'is-invalid' : '' }}"
                 placeholder="Contoh: Bahan Baku, Marketing, Operasional, dll" required>
          @error('category') <div class="be-error">{{ $message }}</div> @enderror
        </div>

        <!-- Periode & Target -->
        <div class="be-form-row">
          <div class="be-form-group">
            <label>Periode <span class="required">*</span></label>
            <input type="text" name="period" id="periodInput" value="{{ old('period', $budget['period']) }}"
                   class="{{ $errors->has('period') ? 'is-invalid' : '' }}"
                   placeholder="Contoh: 2026" required>
            @error('period') <div class="be-error">{{ $message }}</div> @enderror
          </div>
          <div class="be-form-group">
            <label>Target Anggaran (Rp) <span class="required">*</span></label>
            <input type="number" name="target" id="targetInput" value="{{ old('target', $budget['target']) }}"
                   class="{{ $errors->has('target') ? 'is-invalid' : '' }}"
                   placeholder="0" min="0" step="1000" required>
            @error('target') <div class="be-error">{{ $message }}</div> @enderror
          </div>
        </div>

        <!-- Realisasi -->
        <div class="be-form-group">
          <label>Realisasi (Rp)</label>
          <input type="number" name="actual" id="actualInput" value="{{ old('actual', $budget['actual']) }}"
                 placeholder="0" min="0" step="1000">
        </div>

        <!-- Status -->
        <div class="be-form-group">
          <label>Status <span class="required">*</span></label>
          <select name="status" id="statusInput" class="{{ $errors->has('status') ? 'is-invalid' : '' }}" required>
            <option value="on_track" {{ old('status', $budget['status']) == 'on_track' ? 'selected' : '' }}>On Track</option>
            <option value="over_budget" {{ old('status', $budget['status']) == 'over_budget' ? 'selected' : '' }}>Over Budget</option>
            <option value="under_budget" {{ old('status', $budget['status']) == 'under_budget' ? 'selected' : '' }}>Under Budget</option>
          </select>
          @error('status') <div class="be-error">{{ $message }}</div> @enderror
        </div>

        <!-- Catatan -->
        <div class="be-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Tambahkan catatan untuk anggaran ini...">{{ old('notes', $budget['notes']) }}</textarea>
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

      <!-- Sidebar -->
      <div class="be-sidebar animate-in" style="animation-delay: 0.15s;">
        <div class="be-preview">
          <div class="lbl">Progress Saat Ini</div>
          <div class="amt" id="previewProgress">{{ $progress }}%</div>
          <div class="progress-bar">
            <div class="fill {{ $progressColor }}" id="previewFill" style="width: {{ min($progress, 100) }}%;"></div>
          </div>
          <div class="sub" id="previewSub">{{ $currencySymbol }}{{ number_format($budget['actual'], 0, ',', '.') }} dari <strong>{{ $currencySymbol }}{{ number_format($budget['target'], 0, ',', '.') }}</strong></div>
          <span class="status-pill {{ $statusPill[$budget['status']] }}" id="previewStatus">{{ $statusLabel[$budget['status']] }}</span>
        </div>

        <div class="be-tips">
          <h4>Tips Mengisi Anggaran</h4>
          <ul>
            <li>Progress dihitung otomatis: realisasi ÷ target × 100%.</li>
            <li>Status "Over Budget" cocok kalau realisasi diperkirakan bakal lewat target.</li>
            <li>Realisasi boleh dikosongkan (0) kalau anggaran baru mau dimulai.</li>
          </ul>
        </div>
      </div>

    </form>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <symbol id="ic-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
      </symbol>
      <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"/>
      </symbol>
      <symbol id="ic-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
      </symbol>
      <symbol id="ic-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
      </symbol>
      <symbol id="ic-target" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
      </symbol>
    </defs>
  </svg>

  <style>
    /* Error validation */
    .be-error {
      font-size: 12px;
      color: var(--danger);
      margin-top: 5px;
    }

    .be-form-group input.is-invalid,
    .be-form-group select.is-invalid {
      border-color: var(--danger);
    }

    .be-form-group input.is-invalid:focus,
    .be-form-group select.is-invalid:focus {
      border-color: var(--danger);
      box-shadow: 0 0 0 3px rgba(232, 90, 90, 0.15);
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      function fmtRupiah(n) {
        n = isNaN(n) ? 0 : n;
        return 'Rp' + n.toLocaleString('id-ID', { maximumFractionDigits: 0 });
      }

      const targetInput = document.getElementById('targetInput');
      const actualInput = document.getElementById('actualInput');
      const statusInput = document.getElementById('statusInput');

      const previewProgress = document.getElementById('previewProgress');
      const previewFill = document.getElementById('previewFill');
      const previewSub = document.getElementById('previewSub');
      const previewStatus = document.getElementById('previewStatus');

      function updatePreview() {
        const target = parseFloat(targetInput.value) || 0;
        const actual = parseFloat(actualInput.value) || 0;
        const progress = target > 0 ? Math.round((actual / target) * 100) : 0;

        previewProgress.textContent = progress + '%';
        previewFill.style.width = Math.min(progress, 100) + '%';
        previewSub.innerHTML = fmtRupiah(actual) + ' dari <strong>' + fmtRupiah(target) + '</strong>';

        // Update color
        previewFill.className = 'fill';
        if (progress > 100) {
          previewFill.classList.add('red');
        } else if (progress < 70) {
          previewFill.classList.add('yellow');
        } else {
          previewFill.classList.add('green');
        }

        const status = statusInput.value;
        previewStatus.className = 'status-pill';
        if (status === 'on_track') {
          previewStatus.classList.add('on-track');
          previewStatus.textContent = 'On Track';
        } else if (status === 'over_budget') {
          previewStatus.classList.add('over-budget');
          previewStatus.textContent = 'Over Budget';
        } else if (status === 'under_budget') {
          previewStatus.classList.add('under-budget');
          previewStatus.textContent = 'Under Budget';
        }
      }

      [targetInput, actualInput, statusInput].forEach(function (el) {
        el.addEventListener('input', updatePreview);
        el.addEventListener('change', updatePreview);
      });

      updatePreview();

      // Ripple effect
      document.querySelectorAll('.be-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
          if (this.tagName === 'A') return;
          const rect = this.getBoundingClientRect();
          const ripple = document.createElement('span');
          ripple.className = 'ripple';
          const size = Math.max(rect.width, rect.height);
          ripple.style.width = ripple.style.height = size + 'px';
          ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
          ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
          this.appendChild(ripple);
          setTimeout(function () { if (ripple.parentNode) ripple.remove(); }, 600);
        });
      });
    });
  </script>

</x-app-layout>