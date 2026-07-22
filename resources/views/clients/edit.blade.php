<x-app-layout>
    <x-slot name="title">Edit Klien</x-slot>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </symbol>
            <symbol id="ic-save" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </symbol>
            <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="9" y1="22" x2="9" y2="18"/><line x1="15" y1="22" x2="15" y2="18"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="16" y2="10"/><line x1="8" y1="14" x2="12" y2="14"/>
            </symbol>
            <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </symbol>
            <symbol id="ic-phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
            </symbol>
            <symbol id="ic-map-pin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
            </symbol>
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .client-edit-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .client-edit-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(20px);} to{ opacity:1; transform:translateY(0);} }
        .client-edit-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        /* ===== BREADCRUMB ===== */
        .breadcrumb{
            display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted); margin-bottom:20px;
        }
        .breadcrumb a{ color:var(--text-secondary); text-decoration:none; transition:color .2s ease; }
        .breadcrumb a:hover{ color:var(--text); }
        .breadcrumb .sep{ color:var(--text-faint); }
        .breadcrumb .current{ color:var(--text); font-weight:600; }

        /* ===== HEADER ===== */
        .page-head{
            display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap; margin-bottom:28px;
        }
        .page-head-left{ flex:1; min-width:200px; }
        .page-head h1{
            font-size:28px; font-weight:700; margin:0 0 4px; letter-spacing:-.02em;
            display:flex; align-items:center; gap:12px; flex-wrap:wrap;
        }
        .page-head h1 .client-name{
            font-family:'Space Grotesk', sans-serif;
            background:var(--surface-hover); padding:2px 14px; border-radius:8px;
            font-size:20px; color:var(--text-secondary);
        }
        .page-head p{ font-size:14px; color:var(--text-muted); margin:0; }

        .head-actions{ display:flex; gap:10px; flex-wrap:wrap; }

        /* ===== BUTTONS ===== */
        .btn{
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            padding:11px 22px; border-radius:var(--radius-sm); font-size:13.5px; font-weight:600;
            cursor:pointer; border:none; transition:all .22s cubic-bezier(.16,1,.3,1);
            white-space:nowrap; text-decoration:none; position:relative; overflow:hidden;
        }
        .btn .icon{ width:16px; height:16px; flex-shrink:0; }
        .btn-primary{
            background:linear-gradient(135deg, var(--accent), var(--accent-dim));
            color:#052117; box-shadow:0 4px 18px var(--accent-glow);
        }
        .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 10px 28px var(--accent-glow); }
        .btn-primary::after{
            content:''; position:absolute; top:-50%; left:-50%; width:200%; height:200%;
            background:linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform:rotate(45deg) translateX(-100%); transition:transform .6s ease;
        }
        .btn-primary:hover::after{ transform:rotate(45deg) translateX(100%); }
        .btn-outline{
            background:var(--surface); border:1px solid var(--border); color:var(--text);
        }
        .btn-outline:hover{
            background:var(--surface-strong); border-color:var(--border-hover); transform:translateY(-2px);
        }
        .btn-sm{ padding:8px 16px; font-size:12.5px; }

        /* ===== FORM PANEL ===== */
        .form-panel{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg);
            overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.06);
        }
        .form-panel-header{
            padding:24px 32px; border-bottom:1px solid var(--border);
            display:flex; align-items:center; gap:12px;
        }
        .form-panel-header .icon-wrap{
            width:40px; height:40px; border-radius:12px;
            background:var(--accent-soft); color:var(--accent);
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .form-panel-header .icon-wrap .icon{ width:20px; height:20px; }
        .form-panel-header h2{
            font-size:16px; font-weight:600; color:var(--text); margin:0;
        }
        .form-panel-header p{
            font-size:13px; color:var(--text-muted); margin:2px 0 0;
        }

        .form-body{ padding:32px; }

        /* ===== INFO BOX ===== */
        .info-box{
            display:flex; align-items:center; justify-content:space-between;
            background:var(--surface-hover); border:1px solid var(--border);
            border-radius:var(--radius-sm); padding:14px 20px; margin-bottom:24px;
            flex-wrap:wrap; gap:10px;
        }
        .info-box .left{ display:flex; align-items:center; gap:12px; }
        .info-box .left .icon{
            width:18px; height:18px; color:var(--text-muted);
        }
        .info-box .label{
            font-size:11.5px; color:var(--text-muted); font-weight:500;
        }
        .info-box .value{
            font-size:16px; font-weight:700; font-family:'Space Grotesk', sans-serif;
            color:var(--text);
        }

        /* ===== FORM GRID ===== */
        .field-grid{ display:grid; grid-template-columns:1fr 1fr; gap:24px; }
        .field-grid .full{ grid-column:1/-1; }

        .field-group{ display:flex; flex-direction:column; gap:6px; }
        .field-group label{
            font-size:12.5px; font-weight:600; color:var(--text-secondary);
            display:flex; align-items:center; gap:6px;
        }
        .field-group label .opt{
            font-weight:400; color:var(--text-muted); font-size:11.5px;
        }
        .field-group label .required{
            color:var(--danger); font-size:14px;
        }

        .field-group .input-wrap{
            position:relative;
        }
        .field-group .input-wrap .icon{
            position:absolute; left:14px; top:50%; transform:translateY(-50%);
            width:16px; height:16px; color:var(--text-muted); pointer-events:none;
        }
        .field-group input,
        .field-group select,
        .field-group textarea{
            width:100%; padding:11px 16px; border-radius:var(--radius-sm);
            background:var(--surface-hover); border:1px solid var(--border);
            color:var(--text); font-size:13.5px; outline:none;
            transition:all .2s ease; font-family:inherit;
        }
        .field-group input.has-icon{ padding-left:42px; }
        .field-group input:focus,
        .field-group select:focus,
        .field-group textarea:focus{
            border-color:var(--accent); background:var(--surface);
            box-shadow:0 0 0 4px rgba(var(--emerald-rgb),0.08);
        }
        .field-group input::placeholder{
            color:var(--text-muted);
        }
        .field-group textarea{
            resize:vertical; min-height:80px; padding:12px 16px; font-size:13.5px; line-height:1.6;
        }
        .field-group .field-hint{
            font-size:11.5px; color:var(--text-muted); margin-top:4px;
        }
        .field-group .field-error{
            font-size:12px; color:var(--danger); margin-top:4px; display:flex; align-items:center; gap:4px;
        }

        /* ===== FORM DIVIDER ===== */
        .form-divider{
            display:flex; align-items:center; gap:16px; margin:28px 0 24px;
        }
        .form-divider::before,
        .form-divider::after{
            content:''; flex:1; height:1px; background:var(--border);
        }
        .form-divider span{
            font-size:11.5px; text-transform:uppercase; letter-spacing:.08em;
            color:var(--text-muted); font-weight:600; white-space:nowrap;
        }

        /* ===== FORM ACTIONS ===== */
        .form-actions{
            display:flex; justify-content:flex-end; gap:12px; padding-top:24px;
            border-top:1px solid var(--border); margin-top:8px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1100px){ .field-grid{ grid-template-columns:1fr 1fr; } }
        @media (max-width: 768px){
            .page-head{ flex-direction:column; }
            .head-actions{ width:100%; }
            .head-actions .btn{ flex:1; }
            .field-grid{ grid-template-columns:1fr; gap:16px; }
            .form-body{ padding:20px; }
            .form-panel-header{ padding:18px 20px; flex-wrap:wrap; }
            .form-panel-header .icon-wrap{ width:32px; height:32px; }
            .form-panel-header .icon-wrap .icon{ width:16px; height:16px; }
            .form-actions{ flex-direction:column-reverse; }
            .form-actions .btn{ flex:1; justify-content:center; }
            .page-head h1{ font-size:22px; flex-direction:column; align-items:flex-start; }
            .page-head h1 .client-name{ font-size:16px; }
            .info-box{ flex-direction:column; align-items:flex-start; }
        }
        @media (max-width: 480px){
            .form-panel-header h2{ font-size:15px; }
            .form-panel-header p{ font-size:12px; }
        }
    </style>

    <div class="client-edit-wrap">

        {{-- ===== BREADCRUMB ===== --}}
        <div class="breadcrumb animate-in" style="animation-delay:.02s;">
            <a href="{{ route('clients.index') }}">Klien</a>
            <span class="sep">›</span>
            <a href="{{ route('clients.show', $client) }}">{{ $client->name }}</a>
            <span class="sep">›</span>
            <span class="current">Edit</span>
        </div>

        {{-- ===== HEADER ===== --}}
        <div class="page-head animate-in" style="animation-delay:.05s;">
            <div class="page-head-left">
                <h1>
                    <span>Edit Klien</span>
                    <span class="client-name">{{ $client->name }}</span>
                </h1>
                <p>
                    Perbarui data klien untuk keperluan faktur dan penawaran.
                </p>
            </div>
            <div class="head-actions">
                <a href="{{ route('clients.show', $client) }}" class="btn btn-outline btn-sm">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali ke Detail
                </a>
            </div>
        </div>

        {{-- ===== FORM ===== --}}
        <form method="POST" action="{{ route('clients.update', $client) }}" class="animate-in" style="animation-delay:.10s;">
            @csrf
            @method('PUT')

            <div class="form-panel">
                {{-- Panel Header --}}
                <div class="form-panel-header">
                    <div class="icon-wrap">
                        <svg class="icon"><use href="#ic-edit"/></svg>
                    </div>
                    <div>
                        <h2>Edit Informasi Klien</h2>
                        <p>Perbarui data klien {{ $client->name }}</p>
                    </div>
                </div>

                {{-- Form Body --}}
                <div class="form-body">

                    {{-- Info Box --}}
                    <div class="info-box">
                        <div class="left">
                            <svg class="icon"><use href="#ic-info"/></svg>
                            <div>
                                <div class="label">Klien ID</div>
                                <div class="value">#{{ $client->id }}</div>
                            </div>
                        </div>
                        <div style="font-size:12px; color:var(--text-muted);">
                            <svg class="icon" style="width:14px;height:14px;display:inline;vertical-align:middle;"><use href="#ic-file-text"/></svg>
                            Total faktur: {{ $client->invoices_count ?? 0 }}
                        </div>
                    </div>

                    {{-- Baris 1: Nama Klien & Perusahaan --}}
                    <div class="field-grid">
                        {{-- Nama Klien --}}
                        <div class="field-group">
                            <label>
                                Nama Klien
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrap">
                                <svg class="icon"><use href="#ic-user"/></svg>
                                <input type="text" name="name" class="has-icon" value="{{ old('name', $client->name) }}" placeholder="Masukkan nama klien..." required>
                            </div>
                            @error('name')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Nama lengkap atau nama panggilan klien.</div>
                        </div>

                        {{-- Nama Perusahaan --}}
                        <div class="field-group">
                            <label>
                                Nama Perusahaan
                                <span class="opt">(opsional)</span>
                            </label>
                            <div class="input-wrap">
                                <svg class="icon"><use href="#ic-building"/></svg>
                                <input type="text" name="company_name" class="has-icon" value="{{ old('company_name', $client->company_name) }}" placeholder="Masukkan nama perusahaan...">
                            </div>
                            @error('company_name')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Nama perusahaan tempat klien bekerja.</div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="form-divider">
                        <span>Kontak</span>
                    </div>

                    {{-- Baris 2: Email & Telepon --}}
                    <div class="field-grid">
                        {{-- Email --}}
                        <div class="field-group">
                            <label>
                                Email
                                <span class="opt">(opsional)</span>
                            </label>
                            <div class="input-wrap">
                                <svg class="icon"><use href="#ic-mail"/></svg>
                                <input type="email" name="email" class="has-icon" value="{{ old('email', $client->email) }}" placeholder="Masukkan alamat email...">
                            </div>
                            @error('email')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Alamat email untuk mengirim faktur/penawaran.</div>
                        </div>

                        {{-- Telepon --}}
                        <div class="field-group">
                            <label>
                                Telepon
                                <span class="opt">(opsional)</span>
                            </label>
                            <div class="input-wrap">
                                <svg class="icon"><use href="#ic-phone"/></svg>
                                <input type="text" name="phone" class="has-icon" value="{{ old('phone', $client->phone) }}" placeholder="Masukkan nomor telepon...">
                            </div>
                            @error('phone')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Nomor telepon atau WhatsApp klien.</div>
                        </div>
                    </div>

                    {{-- Baris 3: Alamat (full width) --}}
                    <div class="field-grid" style="margin-top:8px;">
                        <div class="field-group full">
                            <label>
                                Alamat
                                <span class="opt">(opsional)</span>
                            </label>
                            <div class="input-wrap" style="position:relative;">
                                <svg class="icon" style="position:absolute; left:14px; top:14px; width:16px; height:16px; color:var(--text-muted); pointer-events:none;"><use href="#ic-map-pin"/></svg>
                                <textarea name="address" style="padding-left:42px;" placeholder="Masukkan alamat lengkap klien...">{{ old('address', $client->address) }}</textarea>
                            </div>
                            @error('address')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Alamat lengkap klien untuk keperluan pengiriman.</div>
                        </div>
                    </div>

                    {{-- Baris 4: Catatan (full width) --}}
                    <div class="field-grid" style="margin-top:8px;">
                        <div class="field-group full">
                            <label>
                                Catatan
                                <span class="opt">(opsional)</span>
                            </label>
                            <textarea name="notes" placeholder="Tambahkan catatan tambahan tentang klien...">{{ old('notes', $client->notes) }}</textarea>
                            @error('notes')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Informasi tambahan yang perlu dicatat tentang klien.</div>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="form-actions">
                        <a href="{{ route('clients.show', $client) }}" class="btn btn-outline">
                            <svg class="icon"><use href="#ic-arrow-left"/></svg>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="icon"><use href="#ic-save"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>