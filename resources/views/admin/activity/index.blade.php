<x-admin-layout>
    <x-slot name="title">Log Aktivitas</x-slot>

    <style>
        .page-head{ margin-bottom:22px; }
        .page-head h1{ font-size:25px; margin-bottom:6px; font-family:'Space Grotesk',sans-serif; }
        .page-head p{ font-size:13.5px; color:var(--text-mute); }

        .log-card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden; }
        table{ width:100%; border-collapse:collapse; }
        th{ text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:var(--text-faint); font-weight:600; padding:14px 20px; border-bottom:1px solid var(--border); }
        td{ padding:14px 20px; font-size:13.5px; border-bottom:1px solid var(--border); vertical-align:top; }
        tbody tr:last-child td{ border-bottom:none; }
        tbody tr:hover{ background:var(--surface-strong); }

        .log-action{ display:inline-block; font-size:11px; font-weight:700; padding:3px 9px; border-radius:100px; background:var(--surface-strong); color:var(--emerald); text-transform:uppercase; letter-spacing:.03em; margin-bottom:4px; }
        .log-desc{ color:var(--text); }
        .log-meta{ font-size:11.5px; color:var(--text-faint); margin-top:2px; }
        .log-empty{ text-align:center; padding:40px 20px; color:var(--text-faint); font-size:13.5px; }
        .pagination-wrap{ margin-top:18px; }
    </style>

    <div class="page-head">
        <h1>Log Aktivitas</h1>
        <p>Riwayat semua aksi yang dilakukan admin di sistem — perubahan access level, penghapusan user, dan lain-lain.</p>
    </div>

    <div class="log-card">
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Admin</th>
                    <th>Aktivitas</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td style="white-space:nowrap;">{{ $log->created_at->format('d M Y, H:i') }}</td>
                        <td>{{ $log->user->name ?? 'Sistem' }}</td>
                        <td>
                            <span class="log-action">{{ str_replace('_', ' ', $log->action) }}</span>
                            <div class="log-desc">{{ $log->description }}</div>
                        </td>
                        <td class="log-meta">{{ $log->ip_address ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="log-empty">Belum ada aktivitas yang tercatat.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $logs->links() }}
    </div>
</x-admin-layout>