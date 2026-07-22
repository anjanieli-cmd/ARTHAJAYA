<x-app-layout>
  <x-slot name="title">Edit Profil Perusahaan</x-slot>

  <style>
    .cp-layout{display:grid;grid-template-columns:280px 1fr;gap:20px;align-items:start;}
    @media (max-width:1000px){ .cp-layout{grid-template-columns:1fr;} }

    .cp-side{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:26px 22px;text-align:center;position:sticky;top:20px;}
    .cp-logo-wrap{width:96px;height:96px;margin:0 auto 16px;}
    .cp-logo{width:96px;height:96px;border-radius:20px;background:var(--surface-strong);border:2px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:30px;font-weight:700;color:var(--emerald);overflow:hidden;font-family:'Space Grotesk';}
    .cp-logo img{width:100%;height:100%;object-fit:cover;}
    .cp-name{font-size:16px;font-weight:700;color:var(--text);}
    .cp-industry{font-size:12.5px;color:var(--text-mute);margin-top:2px;margin-bottom:18px;}

    .cp-upload-form{border-top:1px solid var(--border);padding-top:16px;text-align:left;}
    .cp-upload-form label.filelabel{display:block;font-size:12px;font-weight:600;color:var(--text-mute);margin-bottom:8px;}
    .cp-file-input input[type=file]{width:100%;color:var(--text-mute);font-size:12px;}
    .cp-file-input input[type=file]::file-selector-button{background:var(--surface-strong);border:1px solid var(--border);color:var(--text);padding:7px 12px;border-radius:9px;font-size:11.5px;font-weight:600;cursor:pointer;margin-right:8px;}
    .cp-upload-form .btn{width:100%;justify-content:center;margin-top:10px;}

    .cp-meta{text-align:left;border-top:1px solid var(--border);padding-top:16px;margin-top:18px;}
    .cp-meta-row{display:flex;justify-content:space-between;font-size:12.5px;padding:7px 0;}
    .cp-meta-row .k{color:var(--text-faint);}
    .cp-meta-row .v{font-weight:600;color:var(--text);}

    .cp-main{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:28px;}
    .cp-main h2{font-size:15px;font-weight:700;margin-bottom:4px;color:var(--text);}
    .cp-main .desc{font-size:12.5px;color:var(--text-mute);margin-bottom:22px;}

    .form-group{margin-bottom:16px;}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:var(--text);}
    .form-control{width:100%;padding:11px 14px;border-radius:12px;background:var(--surface-strong);border:1px solid var(--border);color:var(--text);font-size:13.5px;outline:none;transition:all .2s ease;font-family:inherit;appearance:none;}
    .form-control:focus{border-color:var(--border-hover);}
    .form-control::placeholder{color:var(--text-faint);}
    select.form-control{
      background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
      background-repeat:no-repeat; background-position: right 14px center; background-size:14px; padding-right:38px;
    }
    html{ --dropdown-bg:#12161F; --dropdown-text:#EAF0F6; }
    html[data-theme="light"]{ --dropdown-bg:#FFFFFF; --dropdown-text:#131A26; }
    html[data-theme="dark"] select.form-control{ color-scheme: dark; }
    html[data-theme="light"] select.form-control{ color-scheme: light; }
    select.form-control option{ background: var(--dropdown-bg); color: var(--dropdown-text); padding: 8px; }

    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .form-error{color:var(--danger);font-size:12px;margin-top:4px;}
    .form-actions{display:flex;align-items:center;gap:14px;margin-top:6px;}

    .btn{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:12px;font-size:13.5px;font-weight:600;cursor:pointer;border:none;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface-strong);border:1px solid var(--border);color:var(--text);}

    .alert-success{background:rgba(var(--emerald-rgb),0.1);border:1px solid rgba(var(--emerald-rgb),0.3);color:var(--emerald);padding:12px 16px;border-radius:12px;font-size:13px;margin-bottom:18px;}
  </style>

  <div class="page-head">
    <div>
      <h1>Edit Profil Perusahaan</h1>
      <p>Kelola data perusahaan yang tampil di faktur dan dashboard.</p>
    </div>
  </div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <div class="cp-layout">

    {{-- ===== SIDEBAR KIRI: LOGO ===== --}}
    <div class="cp-side">
      <div class="cp-logo-wrap">
        <div class="cp-logo">
          @if($company->logo ?? false)
            <img src="{{ asset('storage/'.$company->logo) }}" alt="{{ $company->name }}">
          @else
            {{ strtoupper(substr($company->name ?? 'PT', 0, 2)) }}
          @endif
        </div>
      </div>
      <div class="cp-name">{{ $company->name ?? 'Nama Perusahaan' }}</div>
      <div class="cp-industry">{{ $company->industry ?? 'Industri belum diisi' }}</div>

      <form method="post" action="{{ route('company.update') }}" enctype="multipart/form-data" class="cp-upload-form">
        @csrf
        @method('patch')
        <input type="hidden" name="name" value="{{ $company->name }}">
        <input type="hidden" name="industry" value="{{ $company->industry }}">
        <input type="hidden" name="city" value="{{ $company->city }}">
        <input type="hidden" name="currency" value="{{ $company->currency ?? 'IDR' }}">
        <input type="hidden" name="fiscal_start_month" value="{{ $company->fiscal_start_month ?? 'Januari' }}">
        <input type="hidden" name="fiscal_year" value="{{ $company->fiscal_year ?? date('Y') }}">

        <label class="filelabel">Ganti Logo (JPG/PNG, maks 2MB)</label>
        <div class="cp-file-input">
          <input type="file" name="logo" accept="image/jpeg,image/png,image/jpg">
        </div>
        @error('logo')<div class="form-error">{{ $message }}</div>@enderror
        <button type="submit" class="btn btn-primary">Unggah Logo</button>
      </form>

      <div class="cp-meta">
        <div class="cp-meta-row"><span class="k">Mata Uang</span><span class="v">{{ $company->currency ?? 'IDR' }}</span></div>
        <div class="cp-meta-row"><span class="k">Tahun Fiskal</span><span class="v">{{ $company->fiscal_year ?? date('Y') }}</span></div>
      </div>
    </div>

    {{-- ===== KONTEN KANAN: FORM DATA ===== --}}
    <div class="cp-main">
      <h2>Informasi Perusahaan</h2>
      <div class="desc">Data ini dipakai sebagai kop faktur, penawaran, dan tampilan dashboard.</div>

      <form method="post" action="{{ route('company.update') }}">
        @csrf
        @method('patch')

        <div class="form-group">
          <label>Nama Perusahaan</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}" required>
          @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label>Jenis Industri</label>
            <select name="industry" class="form-control">
              <option value="">Pilih industri</option>
              @foreach(['Retail & E-commerce','Jasa & Konsultasi','Manufaktur','Teknologi / Software','F&B / Kuliner','Logistik & Distribusi','Konstruksi & Properti','Lainnya'] as $opt)
                <option value="{{ $opt }}" {{ old('industry', $company->industry) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Kota</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $company->city) }}" placeholder="cth. Surabaya">
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label>Mata Uang Utama</label>
            <select name="currency" class="form-control" required>
              <option value="IDR" {{ old('currency', $company->currency) == 'IDR' ? 'selected' : '' }}>IDR — Rupiah Indonesia</option>
              <option value="USD" {{ old('currency', $company->currency) == 'USD' ? 'selected' : '' }}>USD — Dolar Amerika</option>
              <option value="SGD" {{ old('currency', $company->currency) == 'SGD' ? 'selected' : '' }}>SGD — Dolar Singapura</option>
              <option value="MYR" {{ old('currency', $company->currency) == 'MYR' ? 'selected' : '' }}>MYR — Ringgit Malaysia</option>
            </select>
          </div>
          <div class="form-group">
            <label>Tahun Buku Aktif</label>
            @php($currentYear = date('Y'))
            <select name="fiscal_year" class="form-control" required>
              @for($y = $currentYear - 1; $y <= $currentYear + 1; $y++)
                <option value="{{ $y }}" {{ old('fiscal_year', $company->fiscal_year) == $y ? 'selected' : '' }}>{{ $y }}</option>
              @endfor
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Bulan Mulai Tahun Fiskal</label>
          <select name="fiscal_start_month" class="form-control" required>
            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m)
              <option value="{{ $m }}" {{ old('fiscal_start_month', $company->fiscal_start_month) == $m ? 'selected' : '' }}>{{ $m }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <a href="{{ route('dashboard') }}" class="btn btn-outline">Batal</a>
        </div>
      </form>
    </div>

  </div>
</x-app-layout>