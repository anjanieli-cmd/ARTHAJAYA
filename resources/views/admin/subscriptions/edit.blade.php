<x-admin-layout>
<x-slot name="title">Edit Paket Langganan</x-slot>

<style>
@keyframes fadeUp{ from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
.au{animation:fadeUp .5s cubic-bezier(.16,1,.3,1) forwards;opacity:0}
.d1{animation-delay:.04s}.d2{animation-delay:.09s}

.ph{margin-bottom:26px}
.ph h1{font-size:26px;font-weight:800;margin:0 0 5px;font-family:'Space Grotesk',sans-serif;color:var(--text)}
.ph p{font-size:13.5px;color:var(--text-mute);margin:0}
.ph p strong{color:var(--text)}

.form-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;overflow:hidden;max-width:640px}
.fc-head{padding:18px 22px;border-bottom:1px solid var(--border);background:linear-gradient(135deg,var(--surface) 70%,rgba(var(--emerald-rgb),.04));display:flex;align-items:center;gap:10px}
.fc-head .hi{width:34px;height:34px;border-radius:9px;background:rgba(var(--emerald-rgb),.12);border:1px solid rgba(var(--emerald-rgb),.2);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.fc-head .hi svg{width:15px;height:15px;color:var(--emerald)}
.fc-head h3{font-size:14px;font-weight:700;color:var(--text);margin:0 0 2px}
.fc-head p{font-size:11.5px;color:var(--text-mute);margin:0}
.fc-body{padding:24px;display:flex;flex-direction:column;gap:18px}
.fc-foot{padding:18px 24px;border-top:1px solid var(--border);display:flex;gap:10px}

.fg{display:flex;flex-direction:column;gap:6px}
.fg label{font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--text-mute)}
.fg label .opt{font-size:10.5px;font-weight:400;color:var(--text-faint);text-transform:none;letter-spacing:0}
.fc{width:100%;padding:11px 14px;border-radius:10px;background:var(--surface-strong);border:1px solid var(--border);color:var(--text);font-size:13.5px;outline:none;font-family:inherit;transition:border-color .15s,box-shadow .15s}
.fc:focus{border-color:var(--emerald);box-shadow:0 0 0 3px rgba(var(--emerald-rgb),.1)}
textarea.fc{resize:vertical;min-height:130px;line-height:1.6}
select.fc{appearance:none;background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2'><polyline points='6 9 12 15 18 9'/></svg>");background-repeat:no-repeat;background-position:right 14px center;background-size:12px;padding-right:36px}
.fhint{font-size:11.5px;color:var(--text-faint);line-height:1.5}
.form-error{color:var(--danger);font-size:12px;margin-top:2px}
.fg-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}

.toggle-row{display:flex;align-items:center;justify-content:space-between;padding:12px 14px;background:var(--surface-strong);border-radius:12px;border:1px solid var(--border)}
.toggle-row .tl{font-size:13.5px;font-weight:600;color:var(--text)}
.toggle-row .ts{font-size:11.5px;color:var(--text-faint);margin-top:1px}
.sw{position:relative;display:inline-block;width:42px;height:24px;flex-shrink:0}
.sw input{opacity:0;width:0;height:0}
.sw-sl{position:absolute;inset:0;background:var(--border);border-radius:24px;cursor:pointer;transition:background .2s}
.sw-sl::before{content:'';position:absolute;width:18px;height:18px;left:3px;top:3px;background:#fff;border-radius:50%;transition:transform .2s}
.sw input:checked+.sw-sl{background:var(--emerald)}
.sw input:checked+.sw-sl::before{transform:translateX(18px)}

.color-picker{display:flex;flex-wrap:wrap;gap:10px}
.color-opt{position:relative;width:34px;height:34px;border-radius:50%;cursor:pointer;border:2px solid transparent;transition:transform .15s ease;flex-shrink:0}
.color-opt:hover{transform:scale(1.1)}
.color-opt input{position:absolute;opacity:0;inset:0;cursor:pointer;margin:0}
.color-opt .swatch{position:absolute;inset:3px;border-radius:50%;pointer-events:none}
.color-opt .tick{position:absolute;inset:0;display:none;align-items:center;justify-content:center;color:#fff;pointer-events:none}
.color-opt .tick svg{width:14px;height:14px;filter:drop-shadow(0 1px 2px rgba(0,0,0,.4))}
.color-opt input:checked ~ .tick{display:flex}
.color-opt:has(input:checked){border-color:var(--text)}

.icon-picker{display:flex;flex-wrap:wrap;gap:8px}
.icon-opt{position:relative;width:40px;height:40px;border-radius:10px;cursor:pointer;border:1.5px solid var(--border);background:var(--surface-strong);display:flex;align-items:center;justify-content:center;color:var(--text-mute);transition:all .15s ease;flex-shrink:0}
.icon-opt:hover{border-color:var(--border-hover);color:var(--text)}
.icon-opt input{position:absolute;opacity:0;inset:0;cursor:pointer;margin:0}
.icon-opt svg{width:17px;height:17px;pointer-events:none}
.icon-opt:has(input:checked){border-color:var(--emerald);background:rgba(var(--emerald-rgb),.12);color:var(--emerald)}

.btn{display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:12px;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .2s ease}
.btn svg{width:15px;height:15px}
.btn-primary{background:var(--emerald);color:#052117;box-shadow:0 4px 16px rgba(var(--emerald-rgb),.3)}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(var(--emerald-rgb),.4)}
.btn-outline{background:var(--surface-strong);border:1px solid var(--border);color:var(--text-mute)}
.btn-outline:hover{color:var(--text);border-color:var(--border-hover)}
</style>

<svg style="display:none;"><defs>
<symbol id="i-save"    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></symbol>
<symbol id="i-x"       viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
<symbol id="i-edit"    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></symbol>
<symbol id="i-zap"     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></symbol>
<symbol id="i-star"    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></symbol>
<symbol id="i-shield"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></symbol>
<symbol id="i-diamond" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41l-7.59-7.59a2.41 2.41 0 0 0-3.41 0Z"/></symbol>
<symbol id="i-rocket"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></symbol>
</defs></svg>

<div class="ph au d1">
    <h1>Edit Paket Langganan</h1>
    <p>Ubah detail paket <strong>{{ $plan->name }}</strong> — perubahan langsung berlaku di halaman pricing.</p>
</div>

<div class="form-card au d2">
    <div class="fc-head">
        <div class="hi"><svg><use href="#i-edit"/></svg></div>
        <div>
            <h3>Informasi Paket</h3>
            <p>Atur nama, harga, warna, ikon, dan fitur paket.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.subscription-plans.update', $plan) }}">
        @csrf
        @method('PUT')

        <div class="fc-body">

            <div class="fg">
                <label>Nama Paket <span class="opt">(wajib)</span></label>
                <input type="text" name="name" class="fc" value="{{ old('name', $plan->name) }}" placeholder="contoh: Pro, Enterprise, Ultimate" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="fg-row">
                <div class="fg">
                    <label>Harga <span class="opt">(Rp)</span></label>
                    <input type="number" name="price" class="fc" value="{{ old('price', $plan->price) }}" min="0" required placeholder="0">
                    @error('price')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="fg">
                    <label>Periode Tagihan</label>
                    <select name="billing_period" class="fc">
                        <option value="monthly" {{ old('billing_period', $plan->billing_period)==='monthly' ? 'selected' : '' }}>Bulanan</option>
                        <option value="yearly" {{ old('billing_period', $plan->billing_period)==='yearly' ? 'selected' : '' }}>Tahunan</option>
                    </select>
                </div>
            </div>

            <div class="fg">
                <label>Maksimal User <span class="opt">(kosongkan jika tidak terbatas)</span></label>
                <input type="number" name="max_users" class="fc" value="{{ old('max_users', $plan->max_users) }}" min="1" placeholder="tak terbatas">
            </div>

            {{-- ===== COLOR PICKER ===== --}}
            <div class="fg">
                <label>Warna Paket</label>
                @php
                    $colorOptions = [
                        '#6366f1' => 'Indigo', '#2A9D8F' => 'Teal', '#f59e0b' => 'Gold',
                        '#ec4899' => 'Pink', '#14b8a6' => 'Cyan', '#ef4444' => 'Merah',
                        '#3b82f6' => 'Biru', '#64748b' => 'Abu',
                    ];
                    $selectedColor = old('color', $plan->color ?: '#6366f1');
                @endphp
                <div class="color-picker">
                    @foreach($colorOptions as $hex => $label)
                    <label class="color-opt" title="{{ $label }}">
                        <input type="radio" name="color" value="{{ $hex }}" {{ $selectedColor === $hex ? 'checked' : '' }}>
                        <span class="swatch" style="background:{{ $hex }};"></span>
                        <span class="tick"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- ===== ICON PICKER ===== --}}
            <div class="fg">
                <label>Ikon Paket</label>
                @php
                    $iconOptions = ['i-zap', 'i-star', 'i-shield', 'i-diamond', 'i-rocket'];
                    $selectedIcon = old('icon', $plan->icon ?: 'i-zap');
                @endphp
                <div class="icon-picker">
                    @foreach($iconOptions as $ic)
                    <label class="icon-opt">
                        <input type="radio" name="icon" value="{{ $ic }}" {{ $selectedIcon === $ic ? 'checked' : '' }}>
                        <svg><use href="#{{ $ic }}"/></svg>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="fg">
                <label>Daftar Fitur <span class="opt">— satu fitur per baris</span></label>
                <textarea name="description" class="fc" placeholder="Semua fitur dasar&#10;Laporan keuangan&#10;Manajemen klien">{{ old('description', $plan->description) }}</textarea>
                <div class="fhint">Ikon tiap fitur otomatis dipilih dari kata kunci (payroll, pajak, laporan, dll) di halaman pricing.</div>
            </div>

            <div class="toggle-row">
                <div>
                    <div class="tl">Paket aktif</div>
                    <div class="ts">Perusahaan bisa memilih paket ini saat berlangganan</div>
                </div>
                <label class="sw">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                    <span class="sw-sl"></span>
                </label>
            </div>

        </div>

        <div class="fc-foot">
            <button type="submit" class="btn btn-primary">
                <svg><use href="#i-save"/></svg> Simpan Perubahan
            </button>
            <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-outline">
                <svg><use href="#i-x"/></svg> Batal
            </a>
        </div>
    </form>
</div>
</x-admin-layout>