<x-app-layout>
  <x-slot name="title">Undang Anggota</x-slot>

  <style>
    .inv-layout{display:grid;grid-template-columns:340px 1fr;gap:20px;align-items:start;}
    @media (max-width:1000px){ .inv-layout{grid-template-columns:1fr;} }

    /* ===== KIRI: ROLE ===== */
    .inv-side{position:sticky;top:20px;display:flex;flex-direction:column;gap:16px;}
    .inv-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:24px;}
    .inv-card h3{font-size:15px;font-weight:700;margin-bottom:4px;color:var(--text);}
    .inv-card .desc{font-size:12.5px;color:var(--text-mute);line-height:1.5;margin-bottom:18px;}

    .role-option{display:flex;align-items:flex-start;gap:12px;padding:14px;border-radius:14px;border:1px solid var(--border);margin-bottom:10px;cursor:pointer;transition:all .15s ease;background:var(--surface-strong);}
    .role-option:last-child{margin-bottom:0;}
    .role-option:hover{border-color:var(--border-hover);}
    .role-option.checked{border-color:var(--emerald);background:rgba(var(--emerald-rgb),0.08);}
    .role-radio{width:18px;height:18px;border-radius:50%;border:2px solid var(--border-hover);flex-shrink:0;margin-top:1px;position:relative;transition:all .15s ease;}
    .role-option.checked .role-radio{border-color:var(--emerald);}
    .role-option.checked .role-radio:after{content:'';position:absolute;inset:3px;border-radius:50%;background:var(--emerald);}
    .role-option input{display:none;}
    .role-text .t{font-size:13.5px;font-weight:700;color:var(--text);}
    .role-text .d{font-size:11.5px;color:var(--text-mute);margin-top:2px;}

    .role-icon{width:34px;height:34px;border-radius:10px;background:var(--surface);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--text-mute);font-size:15px;font-weight:700;}
    .role-option.checked .role-icon{color:var(--emerald);}

    .inv-hint{background:rgba(var(--emerald-rgb),0.06);border:1px solid rgba(var(--emerald-rgb),0.2);border-radius:14px;padding:16px 18px;}
    .inv-hint .t{font-size:12.5px;font-weight:700;color:var(--emerald);margin-bottom:6px;}
    .inv-hint p{font-size:11.5px;color:var(--text-mute);line-height:1.7;}

    /* ===== KANAN: FORM ===== */
    .inv-main{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:28px;}
    .form-group{margin-bottom:18px;}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:var(--text);}
    .form-control{width:100%;padding:11px 14px;border-radius:12px;background:var(--surface-strong);border:1px solid var(--border);color:var(--text);font-size:13.5px;outline:none;transition:all .2s ease;font-family:inherit;}
    .form-control:focus{border-color:var(--border-hover);}
    .form-error{color:var(--danger);font-size:12px;margin-top:4px;}

    .perm-section-title{font-size:14px;font-weight:700;color:var(--text);margin:24px 0 4px;padding-top:20px;border-top:1px solid var(--border);}
    .perm-section-title:first-of-type{border-top:none;padding-top:0;margin-top:6px;}
    .perm-section-sub{font-size:12px;color:var(--text-mute);margin-bottom:16px;}

    .perm-module{background:var(--surface-strong);border:1px solid var(--border);border-radius:14px;padding:16px 18px;margin-bottom:12px;}
    .perm-module-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;}
    .perm-module-head .mh{font-weight:700;font-size:13px;color:var(--text);}
    .perm-select-all{font-size:11px;color:var(--emerald);font-weight:600;cursor:pointer;user-select:none;}
    .perm-checks{display:flex;flex-wrap:wrap;gap:18px;}

    .chk-label{display:flex;align-items:center;gap:8px;font-size:12.5px;color:var(--text-mute);cursor:pointer;user-select:none;}
    .chk-box{width:17px;height:17px;border-radius:5px;border:1.5px solid var(--border-hover);background:var(--surface);flex-shrink:0;position:relative;transition:all .15s ease;}
    .chk-label input{display:none;}
    .chk-label input:checked + .chk-box{background:var(--emerald);border-color:var(--emerald);}
    .chk-label input:checked + .chk-box:after{content:'';position:absolute;left:4px;top:1px;width:5px;height:9px;border:solid #052117;border-width:0 2px 2px 0;transform:rotate(45deg);}
    .chk-label input:checked ~ .chk-text{color:var(--text);font-weight:600;}

    .form-actions{display:flex;gap:12px;margin-top:26px;padding-top:22px;border-top:1px solid var(--border);}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:11px 24px;border-radius:12px;font-size:13.5px;font-weight:600;cursor:pointer;border:none;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface-strong);border:1px solid var(--border);color:var(--text);}
  </style>

  <div class="page-head">
    <div><h1>Undang Anggota Baru</h1><p>Tambahkan anggota tim dan atur hak aksesnya.</p></div>
  </div>

  <form method="POST" action="{{ route('team-members.store') }}" id="inviteForm">
    @csrf
    <div class="inv-layout">

      {{-- ===== KIRI: ROLE ===== --}}
      <div class="inv-side">
        <div class="inv-card">
          <h3>Pilih Role</h3>
          <div class="desc">Role menentukan template awal hak akses. Kamu masih bisa mengubah detail izin di sebelah kanan.</div>

          @php
            $roles = [
              'Admin'   => ['desc' => 'Akses penuh ke semua fitur.', 'initial' => 'A'],
              'Manager' => ['desc' => 'Kelola operasional harian.', 'initial' => 'M'],
              'Staff'   => ['desc' => 'Input data transaksi.', 'initial' => 'S'],
              'Viewer'  => ['desc' => 'Hanya bisa melihat data.', 'initial' => 'V'],
            ];
          @endphp

          @foreach($roles as $role => $info)
            <label class="role-option {{ old('role') == $role || (!old('role') && $role == 'Admin') ? 'checked' : '' }}" data-role-option>
              <input type="radio" name="role" value="{{ $role }}" data-role-radio {{ old('role', 'Admin') == $role ? 'checked' : '' }} required>
              <span class="role-icon">{{ $info['initial'] }}</span>
              <span class="role-text">
                <div class="t">{{ $role }}</div>
                <div class="d">{{ $info['desc'] }}</div>
              </span>
            </label>
          @endforeach
          @error('role')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="inv-hint">
          <div class="t">Tips</div>
          <p>Memilih role otomatis mencentang hak akses standarnya. Kamu tetap bisa menyesuaikan setiap izin secara manual di sebelah kanan sebelum mengirim undangan.</p>
        </div>
      </div>

      {{-- ===== KANAN: FORM ===== --}}
      <div class="inv-main">
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
          @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
          @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="perm-section-title">Hak Akses Detail</div>
        <div class="perm-section-sub">Centang izin yang boleh diakses anggota ini pada setiap modul.</div>

        @foreach($modules as $key => $mod)
          <div class="perm-module" data-module="{{ $key }}">
            <div class="perm-module-head">
              <span class="mh">{{ $mod['label'] }}</span>
              <span class="perm-select-all" data-select-all="{{ $key }}">Pilih Semua</span>
            </div>
            <div class="perm-checks">
              @foreach($mod['actions'] as $action)
                <label class="chk-label">
                  <input type="checkbox" name="permissions[]" value="{{ $key }}.{{ $action }}"
                    data-module-check="{{ $key }}"
                    {{ in_array($key.'.'.$action, old('permissions', [])) ? 'checked' : '' }}>
                  <span class="chk-box"></span>
                  <span class="chk-text">{{ ucfirst($action) }}</span>
                </label>
              @endforeach
            </div>
          </div>
        @endforeach

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Kirim Undangan</button>
          <a href="{{ route('team-members.index') }}" class="btn btn-outline">Batal</a>
        </div>
      </div>

    </div>
  </form>

  <script>
    // Template hak akses otomatis per role
    const roleTemplates = {
      Admin:   'all',
      Manager: ['invoices.view','invoices.create','invoices.edit','quotes.view','quotes.create','quotes.edit','clients.view','clients.create','clients.edit','expenses.view','expenses.create','expenses.edit','reports.view','reports.export'],
      Staff:   ['invoices.view','invoices.create','quotes.view','quotes.create','clients.view','expenses.view','expenses.create'],
      Viewer:  ['invoices.view','quotes.view','clients.view','expenses.view','reports.view'],
    };

    function applyRoleTemplate(role) {
      const checks = document.querySelectorAll('[data-module-check]');
      checks.forEach(chk => {
        if (roleTemplates[role] === 'all') {
          chk.checked = true;
        } else {
          chk.checked = roleTemplates[role]?.includes(chk.value) ?? false;
        }
      });
    }

    document.querySelectorAll('[data-role-radio]').forEach(radio => {
      radio.addEventListener('change', function () {
        document.querySelectorAll('[data-role-option]').forEach(el => el.classList.remove('checked'));
        this.closest('[data-role-option]').classList.add('checked');
        applyRoleTemplate(this.value);
      });
    });

    document.querySelectorAll('[data-select-all]').forEach(btn => {
      btn.addEventListener('click', function () {
        const mod = this.dataset.selectAll;
        const checks = document.querySelectorAll(`[data-module-check="${mod}"]`);
        const allChecked = Array.from(checks).every(c => c.checked);
        checks.forEach(c => c.checked = !allChecked);
        this.textContent = allChecked ? 'Pilih Semua' : 'Batal Semua';
      });
    });

    // Preset awal sesuai role default (Admin) saat halaman pertama dimuat, kecuali sudah ada old() input
    @if(!old('permissions'))
      applyRoleTemplate('{{ old('role', 'Admin') }}');
    @endif
  </script>
</x-app-layout>