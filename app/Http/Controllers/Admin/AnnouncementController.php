<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('creator')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $announcement = Announcement::create([
            'title'      => $data['title'],
            'message'    => $data['message'],
            'created_by' => auth()->id(),
        ]);

        ActivityLog::record(
            'broadcast_announcement',
            "Mengirim pengumuman: {$announcement->title}.",
            $announcement
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'announcement' => [
                    'id'         => $announcement->id,
                    'title'      => $announcement->title,
                    'message'    => $announcement->message,
                    'creator'    => auth()->user()->name,
                    'created_at' => $announcement->created_at->diffForHumans(),
                ],
            ]);
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dikirim.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        ActivityLog::record('delete_announcement', "Menghapus pengumuman: {$announcement->title}.");

        return back()->with('success', 'Pengumuman dihapus.');
    }
}