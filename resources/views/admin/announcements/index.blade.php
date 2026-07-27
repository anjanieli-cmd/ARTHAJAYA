<x-admin-layout>
    <x-slot name="title">Broadcast Pengumuman</x-slot>

    <style>
        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes slideInTimeline{ from{ opacity:0; transform:translateX(-14px);} to{ opacity:1; transform:translateX(0);} }
        @keyframes dotPulse{ 0%{ box-shadow:0 0 0 0 rgba(var(--emerald-rgb),0.5);} 100%{ box-shadow:0 0 0 10px rgba(var(--emerald-rgb),0);} }
        @keyframes highlightFlash{ 0%{ background:rgba(var(--emerald-rgb),0.16);} 100%{ background:var(--surface);} }
        @keyframes spin{ to{ transform:rotate(360deg);} }

        .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) backwards; }

        .page-head{ margin-bottom:24px; }
        .page-head h1{ font-size:25px; margin-bottom:6px; font-family:'Space Grotesk',sans-serif; }
        .page-head p{ font-size:13.5px; color:var(--text-mute); }

        .bc-layout{ display:grid; grid-template-columns:340px 1fr; gap:22px; align-items:start; }
        @media (max-width:900px){ .bc-layout{ grid-template-columns:1fr; } }

        /* ===== KIRI: compose form (sticky card) ===== */
        .compose-card{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px; position:sticky; top:100px; }
        .compose-card h3{ font-family:'Space Grotesk',sans-serif; font-size:15.5px; margin-bottom:6px; }
        .compose-card .sub{ font-size:12px; color:var(--text-faint); margin-bottom:18px; }
        .form-group{ margin-bottom:14px; }
        .form-group label{ display:block; font-size:12.5px; font-weight:600; margin-bottom:6px; }
        .form-control{ width:100%; padding:10px 13px; border-radius:11px; background:var(--surface-strong); border:1px solid var(--border); color:var(--text); font-size:13px; outline:none; font-family:inherit; transition:border-color .2s ease; }
        .form-control:focus{ border-color:var(--border-hover); }
        textarea.form-control{ min-height:110px; resize:vertical; }
        .btn-send{
            width:100%; display:flex; align-items:center; justify-content:center; gap:8px;
            padding:11px; border-radius:11px; background:var(--emerald); color:#1a1005; font-size:13.5px; font-weight:700;
            border:none; cursor:pointer; transition:transform .15s ease, opacity .15s ease;
        }
        .btn-send:hover{ transform:translateY(-2px); }
        .btn-send:active{ transform:scale(.96); }
        .btn-send:disabled{ opacity:.6; cursor:not-allowed; transform:none; }
        .btn-send .spinner{ width:14px; height:14px; border:2px solid rgba(26,16,5,0.3); border-top-color:#1a1005; border-radius:50%; animation:spin .6s linear infinite; display:none; }
        .btn-send.loading .spinner{ display:block; }
        .btn-send.loading .label{ display:none; }

        /* ===== KANAN: timeline ===== */
        .timeline{ position:relative; padding-left:28px; }
        .timeline::before{ content:''; position:absolute; left:9px; top:6px; bottom:6px; width:2px; background:linear-gradient(var(--border), transparent); }
        .tl-item{ position:relative; margin-bottom:18px; animation:slideInTimeline .4s cubic-bezier(.16,1,.3,1) backwards; }
        .tl-item.flash{ animation:highlightFlash 1.6s ease; }
        .tl-dot{ position:absolute; left:-28px; top:18px; width:12px; height:12px; border-radius:50%; background:var(--emerald); border:3px solid var(--bg); }
        .tl-dot.new{ animation:dotPulse 1.2s ease-out 2; }
        .tl-card{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:18px 20px; transition:border-color .2s ease; }
        .tl-card:hover{ border-color:var(--border-hover); }
        .tl-head{ display:flex; justify-content:space-between; align-items:flex-start; gap:10px; margin-bottom:6px; }
        .tl-title{ font-size:14px; font-weight:700; color:var(--text); }
        .tl-del{ background:none; border:none; color:var(--text-faint); cursor:pointer; font-size:11px; padding:2px 6px; border-radius:6px; flex-shrink:0; }
        .tl-del:hover{ color:var(--danger); background:rgba(232,90,90,0.1); }
        .tl-msg{ font-size:13px; color:var(--text-mute); line-height:1.55; white-space:pre-line; margin-bottom:10px; }
        .tl-meta{ font-size:11px; color:var(--text-faint); display:flex; gap:8px; align-items:center; }
        .tl-meta .dot-sep{ width:3px; height:3px; border-radius:50%; background:var(--text-faint); }

        .tl-empty{ padding:40px 20px; text-align:center; color:var(--text-faint); font-size:13.5px; background:var(--surface); border:1px dashed var(--border); border-radius:16px; }
    </style>

    <div class="page-head animate-in" style="animation-delay:.05s;">
        <h1>Broadcast Pengumuman</h1>
        <p>Kirim pengumuman yang akan tercatat dan dapat dilihat riwayatnya di sini.</p>
    </div>

    <div class="bc-layout">
        {{-- ===== KIRI: FORM ===== --}}
        <div class="compose-card animate-in" style="animation-delay:.1s;">
            <h3>Buat Pengumuman</h3>
            <div class="sub">Isi judul dan pesan singkat untuk dibagikan.</div>

            <form id="announceForm">
                @csrf
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" placeholder="contoh: Maintenance Terjadwal" required>
                </div>
                <div class="form-group">
                    <label>Pesan</label>
                    <textarea name="message" class="form-control" placeholder="Tulis isi pengumuman..." required></textarea>
                </div>
                <button type="submit" class="btn-send" id="sendBtn">
                    <span class="spinner"></span>
                    <span class="label">Kirim Pengumuman</span>
                </button>
            </form>
        </div>

        {{-- ===== KANAN: TIMELINE ===== --}}
        <div>
            <div class="timeline" id="timeline">
                @forelse($announcements as $i => $a)
                    <div class="tl-item" style="animation-delay:{{ min($i * 0.06, 0.4) }}s;">
                        <div class="tl-dot"></div>
                        <div class="tl-card">
                            <div class="tl-head">
                                <div class="tl-title">{{ $a->title }}</div>
                                <form method="POST" action="{{ route('admin.announcements.destroy', $a) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="tl-del">Hapus</button>
                                </form>
                            </div>
                            <div class="tl-msg">{{ $a->message }}</div>
                            <div class="tl-meta">
                                <span>{{ $a->creator->name ?? 'Sistem' }}</span>
                                <span class="dot-sep"></span>
                                <span>{{ $a->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="tl-empty" id="timelineEmpty">Belum ada pengumuman yang dikirim.</div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        (function(){
            var form = document.getElementById('announceForm');
            var btn = document.getElementById('sendBtn');
            var timeline = document.getElementById('timeline');
            var empty = document.getElementById('timelineEmpty');

            form.addEventListener('submit', function(e){
                e.preventDefault();
                btn.disabled = true;
                btn.classList.add('loading');

                var formData = new FormData(form);

                fetch('{{ route("admin.announcements.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(function(res){ return res.json(); })
                .then(function(data){
                    if(!data.success) throw new Error('Gagal');

                    if(empty){ empty.remove(); }

                    var a = data.announcement;
                    var item = document.createElement('div');
                    item.className = 'tl-item flash';
                    item.innerHTML =
                        '<div class="tl-dot new"></div>' +
                        '<div class="tl-card">' +
                            '<div class="tl-head">' +
                                '<div class="tl-title"></div>' +
                                '<form method="POST" action="/admin/announcements/' + a.id + '" onsubmit="return confirm(\'Hapus pengumuman ini?\')">' +
                                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                    '<input type="hidden" name="_method" value="DELETE">' +
                                    '<button type="submit" class="tl-del">Hapus</button>' +
                                '</form>' +
                            '</div>' +
                            '<div class="tl-msg"></div>' +
                            '<div class="tl-meta"><span></span><span class="dot-sep"></span><span>Baru saja</span></div>' +
                        '</div>';

                    item.querySelector('.tl-title').textContent = a.title;
                    item.querySelector('.tl-msg').textContent = a.message;
                    item.querySelector('.tl-meta span').textContent = a.creator;

                    timeline.insertBefore(item, timeline.firstChild);

                    form.reset();
                })
                .catch(function(err){
                    alert('Gagal mengirim pengumuman. Coba lagi.');
                    console.error(err);
                })
                .finally(function(){
                    btn.disabled = false;
                    btn.classList.remove('loading');
                });
            });
        })();
    </script>
</x-admin-layout>