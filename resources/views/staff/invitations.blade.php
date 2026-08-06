<x-app-layout>
  <x-slot name="title">Kode Undangan</x-slot>

  <style>
    .inv-wrap {
      --theme-primary: var(--emerald);
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

      --radius-sm: 10px;
      --radius-md: 16px;

      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .inv-wrap * { box-sizing: border-box; }
    .inv-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .inv-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .inv-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .inv-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 24px;
      padding: 0 4px;
    }
    .inv-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.06em;
    }
    .inv-eyebrow .icon { width: 14px; height: 14px; color: var(--theme-primary); }
    .inv-header h1 {
      font-size: 26px;
      font-weight: 700;
      margin: 4px 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--emerald));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }
    .inv-header .subtitle { font-size: 14px; color: var(--text-secondary); margin: 0; }

    .inv-btn {
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
      position: relative;
      overflow: hidden;
    }
    .inv-btn .icon { width: 16px; height: 16px; }
    .inv-btn:hover { transform: translateY(-2px); }
    .inv-btn:active { transform: translateY(0) scale(0.97); }
    .inv-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }
    .inv-btn-primary:hover { box-shadow: 0 8px 28px var(--theme-glow); color: #fff; }
    .inv-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }
    .inv-btn-ghost:hover { background: var(--bg-card-hover); border-color: var(--border-hover); color: var(--text-primary); }
    .inv-btn .ripple {
      position: absolute; border-radius: 50%; background: rgba(255,255,255,0.2);
      transform: scale(0); animation: rippleAnim 0.6s ease-out forwards; pointer-events: none;
    }
    @keyframes rippleAnim { to { transform: scale(4); opacity: 0; } }

    /* ALERTS */
    .inv-alert {
      border-radius: var(--radius-md);
      padding: 16px 24px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 14px;
      flex-wrap: wrap;
    }
    .inv-alert-success {
      background: linear-gradient(135deg, rgba(var(--emerald-rgb), 0.1), var(--bg-card));
      border: 1px solid rgba(var(--emerald-rgb), 0.25);
    }
    .inv-alert-success .icon { color: var(--success); width: 22px; height: 22px; flex-shrink: 0; }
    .inv-alert-error {
      background: var(--danger-soft);
      border: 1px solid rgba(232, 90, 90, 0.25);
      color: var(--danger);
      font-size: 13px;
    }
    .inv-alert-error p { margin: 0; }
    .inv-alert-success strong { color: var(--text-primary); font-size: 14px; margin-right: 4px; }

    .code-badge {
      font-family: 'IBM Plex Mono', monospace;
      font-size: 15px;
      font-weight: 700;
      letter-spacing: 0.06em;
      padding: 4px 14px;
      border-radius: 8px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      color: var(--theme-primary);
      display: inline-block;
    }

    .btn-copy {
      padding: 6px 16px;
      border-radius: var(--radius-sm);
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .btn-copy:hover { background: var(--bg-card-hover); border-color: var(--border-hover); color: var(--text-primary); }

    /* CARD */
    .inv-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 24px 28px;
      margin-bottom: 24px;
      transition: all 0.3s ease;
    }
    .inv-card:hover { border-color: var(--border-hover); }
    .inv-card .card-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 8px;
    }
    .inv-card .card-head h3 { font-size: 15px; font-weight: 600; color: var(--text-primary); margin: 0; }
    .inv-card .card-note { font-size: 12px; color: var(--text-tertiary); margin: 8px 0 0; }

    /* TABLE */
    .inv-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
    .inv-table thead th {
      padding: 8px 4px 12px;
      text-align: left;
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--text-tertiary);
      border-bottom: 1px solid var(--border-color);
    }
    .inv-table tbody tr { border-bottom: 1px solid var(--border-color); transition: background 0.2s ease; }
    .inv-table tbody tr:last-child { border-bottom: none; }
    .inv-table tbody tr:hover { background: var(--bg-card-active); }
    .inv-table tbody td { padding: 12px 4px; vertical-align: middle; font-size: 13px; color: var(--text-secondary); }

    .status-pill {
      display: inline-block;
      padding: 2px 12px;
      border-radius: 100px;
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }
    .status-active { background: var(--success-soft); color: var(--success); }
    .status-used { background: var(--bg-card-active); color: var(--text-tertiary); border: 1px solid var(--border-color); }
    .status-expired { background: var(--danger-soft); color: var(--danger); }

    .inv-empty { text-align: center; padding: 32px 12px; color: var(--text-tertiary); font-size: 13px; }

    @media (max-width: 640px) {
      .inv-header { flex-direction: column; }
      .inv-header .inv-btn { width: 100%; justify-content: center; }
      .inv-table { display: block; overflow-x: auto; }
    }
  </style>

  <div class="inv-wrap">

    <div class="inv-header animate-in" style="animation-delay: 0.05s;">
      <div>
        <div class="inv-eyebrow">
          <svg class="icon"><use href="#ic-badge"/></svg> Undangan
        </div>
        <h1>Kode Undangan</h1>
        <p class="subtitle">Generate kode buat mengundang User baru gabung ke perusahaan kamu.</p>
      </div>
      <form method="POST" action="{{ route('staff.invitations.store') }}">
        @csrf
        <button type="submit" class="inv-btn inv-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg> Generate Kode
        </button>
      </form>
    </div>

    @if (session('newCode'))
      <div class="inv-alert inv-alert-success animate-in" style="animation-delay: 0.08s;">
        <svg class="icon"><use href="#ic-check"/></svg>
        <div>
          <strong>Kode berhasil dibuat:</strong>
          <span class="code-badge">{{ session('newCode') }}</span>
        </div>
        <button type="button" class="btn-copy" data-copy="{{ session('newCode') }}" style="margin-left:auto;">Salin</button>
      </div>
    @endif

    @if ($errors->any())
      <div class="inv-alert inv-alert-error animate-in" style="animation-delay: 0.08s;">
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <div class="inv-card animate-in" style="animation-delay: 0.15s;">
      <div class="card-head">
        <h3>Riwayat Kode</h3>
      </div>
      <p class="card-note">Kode berlaku 7 hari sejak dibuat, dan cuma bisa dipakai sekali.</p>

      @if ($invitations->isEmpty())
        <div class="inv-empty">Belum ada kode undangan yang dibuat.</div>
      @else
        <table class="inv-table">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Status</th>
              <th>Dibuat</th>
              <th>Kedaluwarsa</th>
              <th>Dipakai Oleh</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($invitations as $invitation)
              <tr>
                <td><span class="code-badge">{{ $invitation->code }}</span></td>
                <td>
                  @if ($invitation->used_at)
                    <span class="status-pill status-used">Terpakai</span>
                  @elseif ($invitation->expires_at->isPast())
                    <span class="status-pill status-expired">Kedaluwarsa</span>
                  @else
                    <span class="status-pill status-active">Aktif</span>
                  @endif
                </td>
                <td>{{ $invitation->created_at->format('d M Y H:i') }}</td>
                <td>{{ $invitation->expires_at->format('d M Y H:i') }}</td>
                <td>{{ optional($invitation->usedByUser)->name ?? '-' }}</td>
                <td>
                  @if (!$invitation->used_at && !$invitation->expires_at->isPast())
                    <button type="button" class="btn-copy" data-copy="{{ $invitation->code }}">Salin</button>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-badge" viewBox="0 0 24 24"><circle cx="12" cy="9" r="6"/><path d="M9 14.5 7 22l5-3 5 3-2-7.5"/></symbol>
    <symbol id="ic-plus" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
    <symbol id="ic-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ripple effect
      document.querySelectorAll('.inv-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
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

      // Copy to clipboard
      document.querySelectorAll('.btn-copy').forEach(btn => {
        btn.addEventListener('click', function() {
          const code = this.getAttribute('data-copy');
          navigator.clipboard.writeText(code).then(() => {
            const original = this.textContent;
            this.textContent = 'Tersalin!';
            setTimeout(() => { this.textContent = original; }, 1500);
          });
        });
      });
    });
  </script>

</x-app-layout>