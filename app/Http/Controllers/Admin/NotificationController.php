<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->map(function ($n) {
                return [
                    'id'         => $n->id,
                    'title'      => $n->title,
                    'message'    => $n->message,
                    'icon'       => $n->icon,
                    'url'        => $n->url ?? '#',
                    'is_read'    => $n->is_read,
                    'created_at' => $n->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'unread_count'  => AdminNotification::where('is_read', false)->count(),
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        AdminNotification::where('id', $id)->update(['is_read' => true]);

        return response()->json([
            'unread_count' => AdminNotification::where('is_read', false)->count(),
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        AdminNotification::where('is_read', false)->update(['is_read' => true]);

        return response()->json([
            'unread_count' => 0,
        ]);
    }
}