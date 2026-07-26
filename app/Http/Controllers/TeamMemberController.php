<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Your existing index method
        $stats = [
            'total_count' => TeamMember::count(),
            'active_count' => TeamMember::where('status', 'active')->count(),
            'invited_count' => TeamMember::where('status', 'invited')->count(),
            'suspended_count' => TeamMember::where('status', 'suspended')->count(),
        ];

        $members = TeamMember::when(request('q'), function($query) {
                $query->where('name', 'like', '%'.request('q').'%')
                      ->orWhere('email', 'like', '%'.request('q').'%');
            })
            ->when(request('role'), function($query) {
                $query->where('role', request('role'));
            })
            ->paginate(10);

        return view('team-members.index', compact('stats', 'members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('team-members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Your store logic
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Cari member berdasarkan ID
        $member = TeamMember::findOrFail($id);
        
        // Jika Anda memiliki relasi permissions
        // $member->load('permissions');
        
        // Data dummy untuk permission jika tidak ada di database
        if (!isset($member->permissions)) {
            $member->permissions = [
                'view_dashboard' => true,
                'manage_users' => $member->role === 'Admin',
                'manage_products' => $member->role !== 'Viewer',
                'manage_orders' => $member->role !== 'Viewer',
                'manage_reports' => $member->role === 'Admin' || $member->role === 'Manager',
                'manage_settings' => $member->role === 'Admin',
                'view_analytics' => $member->role !== 'Viewer',
                'export_data' => $member->role !== 'Viewer',
                'manage_inventory' => $member->role === 'Admin' || $member->role === 'Manager',
                'manage_customers' => $member->role !== 'Viewer',
                'view_financials' => $member->role === 'Admin',
                'manage_team' => $member->role === 'Admin',
            ];
        }

        // Data dummy untuk activity log
        if (!isset($member->activity_log)) {
            $member->activity_log = [
                (object) ['action' => 'Login', 'time' => now()->subHours(2), 'ip' => '192.168.1.1'],
                (object) ['action' => 'Updated profile', 'time' => now()->subHours(5), 'ip' => '192.168.1.1'],
                (object) ['action' => 'Viewed dashboard', 'time' => now()->subDay(), 'ip' => '192.168.1.5'],
            ];
        }

        // Data dummy untuk joined_at dan last_active
        if (!isset($member->joined_at)) {
            $member->joined_at = now()->subMonths(3);
        }
        if (!isset($member->last_active)) {
            $member->last_active = now()->subHours(1);
        }

        return view('team-members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $member = TeamMember::findOrFail($id);
        return view('team-members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Your update logic
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);
        $member->delete();

        return redirect()->route('team-members.index')
            ->with('success', 'Anggota berhasil dihapus!');
    }
}