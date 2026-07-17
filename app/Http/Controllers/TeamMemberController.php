<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamMemberController extends Controller
{
    protected function permissionModules(): array
    {
        return [
            'invoices' => ['label' => 'Faktur', 'actions' => ['view', 'create', 'edit', 'delete']],
            'quotes'   => ['label' => 'Penawaran', 'actions' => ['view', 'create', 'edit', 'delete']],
            'clients'  => ['label' => 'Klien', 'actions' => ['view', 'create', 'edit', 'delete']],
            'expenses' => ['label' => 'Pengeluaran', 'actions' => ['view', 'create', 'edit', 'delete']],
            'reports'  => ['label' => 'Laporan', 'actions' => ['view', 'export']],
            'settings' => ['label' => 'Pengaturan', 'actions' => ['view', 'edit']],
        ];
    }

    public function index(Request $request)
    {
        $members = TeamMember::where('company_id', Auth::user()->company_id)
            ->when($request->q, fn ($q) => $q->where(function ($qq) use ($request) {
                $qq->where('name', 'like', "%{$request->q}%")
                   ->orWhere('email', 'like', "%{$request->q}%");
            }))
            ->when($request->role, fn ($q) => $q->where('role', $request->role))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total_count'     => TeamMember::where('company_id', Auth::user()->company_id)->count(),
            'active_count'    => TeamMember::where('company_id', Auth::user()->company_id)->where('status', 'active')->count(),
            'invited_count'   => TeamMember::where('company_id', Auth::user()->company_id)->where('status', 'invited')->count(),
            'suspended_count' => TeamMember::where('company_id', Auth::user()->company_id)->where('status', 'suspended')->count(),
        ];

        return view('team-members.index', compact('members', 'stats'));
    }

    public function create()
    {
        $modules = $this->permissionModules();
        return view('team-members.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:team_members,email',
            'role'          => 'required|in:Admin,Manager,Staff,Viewer',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        TeamMember::create([
            'company_id'  => Auth::user()->company_id,
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'role'        => $validated['role'],
            'permissions' => $validated['permissions'] ?? [],
            'status'      => 'invited',
            'invited_at'  => now(),
        ]);

        return redirect()->route('team-members.index')->with('success', 'Undangan berhasil dikirim.');
    }

    public function edit(TeamMember $teamMember)
    {
        $modules = $this->permissionModules();
        return view('team-members.edit', compact('teamMember', 'modules'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:team_members,email,' . $teamMember->id,
            'role'          => 'required|in:Admin,Manager,Staff,Viewer',
            'status'        => 'required|in:invited,active,suspended',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        $teamMember->update([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'role'        => $validated['role'],
            'status'      => $validated['status'],
            'permissions' => $validated['permissions'] ?? [],
        ]);

        return redirect()->route('team-members.index')->with('success', 'Akses anggota berhasil diperbarui.');
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return redirect()->route('team-members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}