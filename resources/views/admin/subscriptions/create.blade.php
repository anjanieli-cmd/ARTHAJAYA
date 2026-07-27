<x-admin-layout>
    <x-slot name="title">Tambah Paket Langganan</x-slot>

    <style>
        .page-head{ margin-bottom:28px; }
        .page-head h1{ font-size:26px; margin-bottom:6px; font-family:'Space Grotesk',sans-serif; }
        .page-head p{ font-size:13.5px; color:var(--text-mute); }

        .form-card{ 
            background:var(--surface); 
            border:1px solid var(--border); 
            border-radius:18px; 
            padding:32px; 
            max-width:800px;
        }
        .form-card-header{
            padding-bottom:20px;
            border-bottom:1px solid var(--border);
            margin-bottom:24px;
        }
        .form-card-header h2{ 
            font-size:16px; 
            font-weight:700; 
            font-family:'Space Grotesk',sans-serif;
            margin-bottom:4px;
        }
        .form-card-header p{ 
            font-size:13px; 
            color:var(--text-mute); 
        }

        .form-group{ margin-bottom:22px; }
        .form-group label{ 
            display:block; 
            font-size:12.5px; 
            font-weight:600; 
            margin-bottom:7px;
            color:var(--text);
        }
        .form-group .label-desc{
            font-size:11px;
            font-weight:400;
            color:var(--text-faint);
            margin-left:6px;
        }
        .form-control{ 
            width:100%; 
            padding:12px 16px; 
            border-radius:12px; 
            background:var(--surface-strong); 
            border:1px solid var(--border); 
            color:var(--text); 
            font-size:14px; 
            outline:none; 
            font-family:inherit;
            transition:border-color .15s, box-shadow .15s;
        }
        .form-control:focus{ 
            border-color:var(--emerald); 
            box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.12); 
        }
        .form-control::placeholder{
            color:var(--text-faint);
            opacity:0.7;
        }
        textarea.form-control{ 
            resize:vertical; 
            min-height:100px; 
            font-family:inherit;
        }
        .form-error{ 
            color:var(--danger); 
            font-size:12.5px; 
            margin-top:6px; 
            display:flex;
            align-items:center;
            gap:6px;
        }
        .form-error svg{ width:14px; height:14px; flex-shrink:0; }
        .grid-2{ display:grid; grid-template-columns:1fr 1fr; gap:20px; }

        .toggle-row{ 
            display:flex; 
            align-items:center; 
            gap:12px; 
            padding:14px 16px;
            background:var(--surface-strong);
            border-radius:12px;
            border:1px solid var(--border);
            margin-top:4px;
        }
        .toggle-row input[type="checkbox"]{
            width:18px;
            height:18px;
            accent-color:var(--emerald);
            cursor:pointer;
            flex-shrink:0;
        }
        .toggle-row label{ 
            margin:0; 
            font-size:13.5px;
            font-weight:500;
            cursor:pointer;
        }
        .toggle-row .toggle-hint{
            font-size:11.5px;
            color:var(--text-faint);
            margin-left:auto;
        }

        .form-actions{ 
            display:flex; 
            gap:12px; 
            margin-top:28px;
            padding-top:24px;
            border-top:1px solid var(--border);
        }
        .btn{ 
            display:inline-flex; 
            align-items:center; 
            gap:8px; 
            padding:12px 28px; 
            border-radius:12px; 
            font-size:14px; 
            font-weight:600; 
            cursor:pointer; 
            border:none; 
            text-decoration:none;
            transition:all .2s ease;
        }
        .btn svg{ width:16px; height:16px; }
        .btn-primary{ 
            background:var(--emerald); 
            color:#1a1005; 
            box-shadow:0 4px 16px rgba(var(--emerald-rgb),0.3);
        }
        .btn-primary:hover{ 
            transform:translateY(-2px); 
            box-shadow:0 8px 24px rgba(var(--emerald-rgb),0.4); 
        }
        .btn-outline{ 
            background:var(--surface-strong); 
            border:1px solid var(--border); 
            color:var(--text-mute); 
        }
        .btn-outline:hover{ 
            background:var(--surface); 
            border-color:var(--border-hover); 
            color:var(--text); 
        }

        .info-banner{
            display:flex;
            align-items:flex-start;
            gap:12px;
            padding:14px 18px;
            background:rgba(var(--emerald-rgb),0.06);
            border:1px solid rgba(var(--emerald-rgb),0.15);
            border-radius:12px;
            margin-bottom:24px;
        }
        .info-banner svg{
            width:18px;
            height:18px;
            color:var(--emerald);
            flex-shrink:0;
            margin-top:1px;
        }
        .info-banner .text{
            font-size:13px;
            color:var(--text-mute);
            line-height:1.5;
        }
        .info-banner .text strong{
            color:var(--text);
        }

        @media (max-width:768px){
            .grid-2{ grid-template-columns:1fr; }
            .form-card{ padding:20px; }
            .toggle-row{ flex-wrap:wrap; }
            .toggle-row .toggle-hint{ margin-left:0; width:100%; }
        }
    </style>

    {{-- SVG Icons --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="ic-alert-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </symbol>
            <symbol id="ic-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="12" y1="8" x2="12.01" y2="8"/>
            </symbol>
        </defs>
    </svg>

    <div class="page-head">
        <h1>Tambah Paket Langganan</h1>
        <p>Buat paket langganan baru yang bisa dipilih oleh perusahaan di Arvessa.</p>
    </div>

    <div class="form-card">
        <div class="info-banner">
            <svg><use href="#ic-info"/></svg>
            <div class="text">
                <strong>Tips:</strong> Buat paket dengan nama yang jelas (misal: Basic, Pro, Enterprise) dan harga yang sesuai. 
                Paket yang <strong>aktif</strong> akan muncul di halaman pendaftaran perusahaan.
            </div>
        </div>

        <div class="form-card-header">
            <h2>Informasi Paket Baru</h2>
            <p>Isi semua data paket langganan dengan lengkap.</p>
        </div>

        <form method="POST" action="{{ route('admin.subscription-plans.store') }}">
            @csrf

            <div class="form-group">
                <label>Nama Paket <span class="label-desc">(wajib)</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="contoh: Pro, Enterprise, Ultimate" required>
                @error('name')
                    <div class="form-error">
                        <svg><use href="#ic-alert-circle"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" placeholder="Jelaskan fitur dan keunggulan paket ini...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="form-error">
                        <svg><use href="#ic-alert-circle"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Harga <span class="label-desc">(Rp)</span></label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', 0) }}" min="0" required placeholder="0">
                    @error('price')
                        <div class="form-error">
                            <svg><use href="#ic-alert-circle"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Periode Tagihan</label>
                    <select name="billing_period" class="form-control">
                        <option value="monthly" {{ old('billing_period')==='monthly' ? 'selected' : '' }}>📅 Bulanan</option>
                        <option value="yearly" {{ old('billing_period')==='yearly' ? 'selected' : '' }}>📆 Tahunan</option>
                    </select>
                    @error('billing_period')
                        <div class="form-error">
                            <svg><use href="#ic-alert-circle"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Maksimal User <span class="label-desc">(kosongkan jika tidak terbatas)</span></label>
                <input type="number" name="max_users" class="form-control" value="{{ old('max_users') }}" min="1" placeholder="contoh: 10">
                @error('max_users')
                    <div class="form-error">
                        <svg><use href="#ic-alert-circle"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <div class="toggle-row">
                    <input type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="isActive">Paket aktif</label>
                    <span class="toggle-hint">✓ Perusahaan bisa langsung memilih paket ini</span>
                </div>
                @error('is_active')
                    <div class="form-error">
                        <svg><use href="#ic-alert-circle"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg><use href="#ic-plus"/></svg>
                    Simpan Paket
                </button>
                <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-outline">
                    <svg><use href="#ic-x"/></svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>