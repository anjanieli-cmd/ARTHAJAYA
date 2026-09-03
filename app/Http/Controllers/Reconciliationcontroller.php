<?php

namespace App\Http\Controllers;

use App\Models\Reconciliation;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReconciliationController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = Reconciliation::where('company_id', $company->id)->latest();

        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->whereRaw('LOWER(description) LIKE ?', ["%{$q}%"]);
        }

        $reconciliations = $query->get();

        if ($request->ajax()) {
            return view('reconciliation.index', compact('user', 'company', 'reconciliations'))->render();
        }

        return view('reconciliation.index', compact('user', 'company', 'reconciliations'));
    }

    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        return view('reconciliation.create', compact('user', 'company'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $data = $request->validate([
            'account_id'           => 'nullable|integer',
            'period'                => 'nullable|string',
            'reconciliation_date'   => 'required|date',
            'bank_balance'          => 'required|numeric',
            'book_balance'          => 'required|numeric',
            'notes'                 => 'nullable|string',
            'status'                => 'nullable|string',
        ]);

        $reconciliation = Reconciliation::create([
            'company_id'   => $company->id,
            'account_id'   => $data['account_id'] ?? null,
            'period'       => $data['period'] ?? null,
            'description'  => 'Rekonsiliasi ' . ($data['period'] ?? ''),
            'date'         => $data['reconciliation_date'],
            'bank_balance' => (int) $data['bank_balance'],
            'book_balance' => (int) $data['book_balance'],
            'status'       => $data['status'] ?? 'belum',
            'notes'        => $data['notes'] ?? null,
        ]);

        $this->logActivity('created', "Menambahkan rekonsiliasi periode {$reconciliation->period}", $reconciliation);

        return redirect()->route('reconciliation.index')->with('success', 'Rekonsiliasi berhasil ditambahkan!');
    }

    public function show(Reconciliation $reconciliation)
    {
        $this->authorizeCompany($reconciliation);
        $user = Auth::user();
        $company = $user->company;
        return view('reconciliation.show', compact('user', 'company', 'reconciliation'));
    }

    public function edit(Reconciliation $reconciliation)
    {
        $this->authorizeCompany($reconciliation);
        $user = Auth::user();
        $company = $user->company;
        return view('reconciliation.edit', compact('user', 'company', 'reconciliation'));
    }

    public function update(Request $request, Reconciliation $reconciliation)
    {
        $this->authorizeCompany($reconciliation);

        $reconciliation->update($request->only([
            'description', 'date', 'bank_balance', 'book_balance', 'status', 'notes',
        ]));

        $this->logActivity('updated', "Mengupdate rekonsiliasi periode {$reconciliation->period}", $reconciliation);

        return redirect()->route('reconciliation.index')->with('success', 'Rekonsiliasi berhasil diupdate!');
    }

    public function destroy(Reconciliation $reconciliation)
    {
        $this->authorizeCompany($reconciliation);

        $period = $reconciliation->period;
        $reconciliation->delete();

        $this->logActivity('deleted', "Menghapus rekonsiliasi periode {$period}");

        return redirect()->route('reconciliation.index')->with('success', 'Rekonsiliasi berhasil dihapus!');
    }

    private function authorizeCompany(Reconciliation $reconciliation): void
    {
        abort_unless($reconciliation->company_id === Auth::user()->company->id, 404);
    }
}