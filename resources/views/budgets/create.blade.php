<x-app-layout>
  <x-slot name="title">Buat Anggaran</x-slot>

  <style>
    /* ============================================
       BUDGET CREATE - Premium Design
       (konsisten dengan budgets/index.blade.php)
       ============================================ */

    .bc-wrap {
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

    .bc-wrap * { box-sizing: border-box; }
    .bc-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

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

    .bc-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .bc-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .bc-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .bc-header-left { flex: 1; min-width: 200px; }

    .bc-badge {
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

    .bc-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .bc-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .bc-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .bc-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .bc-btn {
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

    .bc-btn .icon { width: 16px; height: 16px; }
    .bc-btn:hover { transform: translateY(-2px); }
    .bc-btn:active { transform: translateY(0) scale(0.97); }

    .bc-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .bc-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .bc-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .bc-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .bc-btn .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: scale(0);
      animation: rippleAnim 0.6s ease-out forwards;
      pointer-events: none;
    }

    /* FORM LAYOUT - Grid */
    .bc-form-wrap {
      display: grid;
      grid-template-columns: 1fr 340px;
      gap: 24px;
      align-items: start;
    }

    @media (max-width: 1024px) {
      .bc-form-wrap { grid-template-columns: 1fr; gap: 24px; }
    }

    .bc-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: border-color 0.22s ease;
    }

    .bc-card:hover { border-color: var(--border-hover); }

    .bc-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .bc-card .title .icon {
      width: 18px;
      height: 18px;
      color: var(--theme-primary);
      margin-right: 8px;
      vertical-align: middle;
    }

    /* FORM GROUP */
    .bc-form-group { margin-bottom: 18px; }
    .bc-form-group:last-child { margin-bottom: 0; }

    .bc-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 5px;
    }

    .bc-form-group .required { color: var(--danger); margin-left: 2px; }

    .bc-form-group input,
    .bc-form-group select,
    .bc-form-group textarea {
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

    .bc-form-group input:focus,
    .bc-form-group select:focus,
    .bc-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
    }

    .bc-form-group input::placeholder,
    .bc-form-group textarea::placeholder { color: var(--text-tertiary); }

    .bc-form-group textarea { resize: vertical; min-height: 80px; }

    .bc-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .bc-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 13px;
    }

    .bc-form-group select option:checked,
    .bc-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .bc-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    @media (max-width: 480px) {
      .bc-form-row { grid-template-columns: 1fr; gap: 0; }
    }

    /* ERROR VALIDATION */
    .bc-error {
      font-size: 12px;
      color: var(--danger);
      margin-top: 5px;
    }

    .bc-form-group input.is-invalid,
    .bc-form-group select.is-invalid { border-color: var(--danger); }

    /* INFO BOX */
    .bc-info-box {
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

    .bc-info-box .icon { width: 20px; height: 20px; flex-shrink: 0; }
    .bc-info-box .message { font-size: 13px; font-weight: 500; }

    /* SIDEBAR - Preview & Tips */
    .bc-sidebar {
      position: sticky;
      top: 24px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .bc-preview {
      background: linear-gradient(160deg, rgba(var(--emerald-rgb), 0.12), var(--surface) 60%);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-md);
      padding: 24px 28px;
      transition: all 0.3s ease;
    }

    .bc-preview:hover {
      border-color: var(--theme-primary);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .bc-preview .lbl {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--text-tertiary);
      font-weight: 600;
      margin-bottom: 8px;
    }

    .bc-preview .progress-bar {
      height: 8px;
      border-radius: 100px;
      background: var(--bg-card-active);
      overflow: hidden;
      margin: 10px 0 8px;
    }

    .bc-preview .progress-bar .fill {
      height: 100%;
      border-radius: 100px;
      background: var(--theme-gradient);
      transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
      width: 0%;
    }

    .bc-preview .amt {
      font-family: 'Space Grotesk', 'Inter', sans-serif;
      font-size: 28px;
      font-weight: 700;
      color: var(--theme-primary);
      line-height: 1.2;
    }

    .bc-preview .sub {
      font-size: 13px;
      color: var(--text-secondary);
      margin-top: 6px;
    }

    .bc-preview .sub strong { color: var(--text-primary); font-weight: 600; }

    .bc-preview .status-pill {
      display: inline-block;
      margin-top: 10px;
      font-size: 10px;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 100px;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      background: var(--bg-card-active);
      color: var(--text-tertiary);
    }

    .bc-preview .status-pill.on-track { background: var(--success-soft); color: var(--success); }
    .bc-preview .status-pill.over-budget { background: var(--danger-soft); color: var(--danger); }
    .bc-preview .status-pill.under-budget { background: var(--warning-soft); color: var(--warning); }

    .bc-tips {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 20px 24px;
    }

    .bc-tips h4 {
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--text-tertiary);
      font-weight: 600;
      margin: 0 0 12px;
    }

    .bc-tips ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .bc-tips li {
      font-size: 13px;
      color: var(--text-secondary);
      padding-left: 18px;
      position: relative;
      line-height: 1.5;
    }

    .bc-tips li::before {
      content: '✦';
      position: absolute;
      left: 0;
      color: var(--theme-primary);
      font-size: 10px;
      top: 1px;
    }

    /* FORM ACTIONS */
    .bc-form-actions { display: flex; gap: 10px; margin-top: 24px; }
    .bc-form-actions .bc-btn { flex: 1; justify-content: center; }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .bc-wrap { padding: 0 16px; }
      .bc-card { padding: 24px 28px; }
    }

    @media (max-width: 768px) {
      .bc-wrap { padding: 0 12px; }
      .bc-header h1 { font-size: 24px; }
      .bc-sidebar { position: relative; top: 0; }
      .bc-preview .amt { font-size: 24px; }
      .bc-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .bc-header { flex-direction: column; }
      .bc-actions { width: 100%; }
      .bc-actions .bc-btn { flex: 1; justify-content: center; }
      .bc-form-actions { flex-direction: column; }
      .bc-form-actions .bc-btn { flex: none; }
      .bc-card { padding: 16px; }
      .bc-preview { padding: 20px; }
    }

    @media (max-width: 380px) {
      .bc-wrap { padding: 0 8px; }
      .bc-header h1 { font-size: 20px; }
      .bc-btn { font-size: 12px; padding: 8px 14px; }
      .bc-btn .icon { width: 14px; height: 14px; }
      .bc-card { padding: 12px; }
    }
  </style>

  <div class="bc-wrap">

    <!-- ===== HEADER ===== -->
    <div class="bc-header animate-in" style="animation-delay: 0.05s;">
      <div class="bc-header-left">
        <div class="bc-badge">
          <span class="dot"></span>
          Keuangan
        </div>
        <h1>Buat Anggaran</h1>
        <p class="subtitle">Tambahkan kategori anggaran baru beserta target dan realisasinya</p>
      </div>
      <div class="bc-actions">
        <a href="{{ route('budgets.index') }}" class="bc-btn bc-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow"/></svg>
          Kembali
        </a>
      </div>
    </div>

    @if ($errors->any())
      <div class="bc-info-box" style="background:var(--danger-soft);border-color:var(--danger);color:var(--danger);">
        <svg class="icon"><use href="#ic-alert"/></svg>
        <span class="message">Ada input yang belum sesuai, cek lagi ya di bawah.</span>
      </div>
    @endif

    <!-- ===== FORM ===== -->
    <form method="POST" action="{{ route('budgets.store') }}" class="bc-form-wrap" id="budgetForm">
      @csrf

      <!-- Main Form -->
      <div class="bc-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-target"/></svg>
          Detail Anggaran
        </div>

        <div class="bc-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <span class="message">Progress dan status akan dihitung otomatis dari target &amp; realisasi.</span>
        </div>

        <!-- Kategori & Periode -->
        <div class="bc-form-row">
          <div class="bc-form-group">
            <label>Kategori <span class="required">*</span></label>
            <input type="text" name="category" id="categoryInput" value="{{ old('category') }}"
                   class="{{ $errors->has('category') ? 'is-invalid' : '' }}"
                   placeholder="Contoh: Bahan Baku" required>
            @error('category') <div class="bc-error">{{ $message }}</div> @enderror
          </div>
          <div class="bc-form-group">
            <label>Periode <span class="required">*</span></label>
            <input type="text" name="period" id="periodInput" value="{{ old('period', date('Y')) }}"
                   class="{{ $errors->has('period') ? 'is-invalid' : '' }}"
                   placeholder="Contoh: 2026" required>
            @error('period') <div class="bc-error">{{ $message }}</div> @enderror
          </div>
        </div>

        <!-- Target & Actual -->
        <div class="bc-form-row">
          <div class="bc-form-group">
            <label>Target Anggaran (Rp) <span class="required">*</span></label>
            <input type="number" name="target" id="targetInput" value="{{ old('target') }}"
                   class="{{ $errors->has('target') ? 'is-invalid' : '' }}"
                   placeholder="0" min="0" step="1000" required>
            @error('target') <div class="bc-error">{{ $message }}</div> @enderror
          </div>
          <div class="bc-form-group">
            <label>Realisasi Saat Ini (Rp)</label>
            <input type="number" name="actual" id="actualInput" value="{{ old('actual', 0) }}"
                   placeholder="0" min="0" step="1000">
          </div>
        </div>

        <!-- Status -->
        <div class="bc-form-group">
          <label>Status <span class="required">*</span></label>
          <select name="status" id="statusInput" class="{{ $errors->has('status') ? 'is-invalid' : '' }}" required>
            <option value="" disabled {{ old('status') ? '' : 'selected' }}>Pilih status</option>
            <option value="on_track" {{ old('status') === 'on_track' ? 'selected' : '' }}>On Track</option>
            <option value="over_budget" {{ old('status') === 'over_budget' ? 'selected' : '' }}>Over Budget</option>
            <option value="under_budget" {{ old('status') === 'under_budget' ? 'selected' : '' }}>Under Budget</option>
          </select>
          @error('status') <div class="bc-error">{{ $message }}</div> @enderror
        </div>

        <!-- Notes -->
        <div class="bc-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Tambahkan catatan untuk anggaran ini...">{{ old('notes') }}</textarea>
        </div>

        <!-- Actions -->
        <div class="bc-form-actions">
          <button type="submit" class="bc-btn bc-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan Anggaran
          </button>
          <a href="{{ route('budgets.index') }}" class="bc-btn bc-btn-ghost">
            Batal
          </a>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="bc-sidebar animate-in" style="animation-delay: 0.15s;">
        <div class="bc-preview">
          <div class="lbl">Preview Progress</div>
          <div class="amt" id="previewProgress">0%</div>
          <div class="progress-bar">
            <div class="fill" id="previewFill"></div>
          </div>
          <div class="sub" id="previewSub">Rp0 dari <strong>Rp0</strong></div>
          <span class="status-pill" id="previewStatus">Belum diisi</span>
        </div>

        <div class="bc-tips">
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
        } else {
          previewStatus.textContent = 'Belum diisi';
        }
      }

      [targetInput, actualInput, statusInput].forEach(function (el) {
        el.addEventListener('input', updatePreview);
        el.addEventListener('change', updatePreview);
      });

      updatePreview();

      // Ripple effect (skip link)
      document.querySelectorAll('.bc-btn').forEach(function (btn) {
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