<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChartOfAccountController extends Controller
{
    /**
     * Daftar tipe akun yang valid, dipakai buat validasi & dropdown di view.
     */
    private array $types = [
        'asset',
        'liability',
        'equity',
        'revenue',
        'expense',
    ];

    public function index(Request $request)
    {
        $user = $request->user();
        $companyId = $user->company_id;

        $search = $request->get('search');
        $type = $request->get('type');

        $accounts = ChartOfAccount::where('company_id', $companyId)
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            }))
            ->when($type, fn ($q) => $q->where('type', $type))
            ->orderBy('code')
            ->get();

        // Hitung jumlah akun per tipe, buat badge di tab filter
        $counts = ChartOfAccount::where('company_id', $companyId)
            ->selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        return view('coa.index', compact(
            'accounts',
            'search',
            'type',
            'counts'
        ));
    }

    public function create()
    {
        return view('coa.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('chart_of_accounts', 'code')
                    ->where('company_id', $user->company_id),
            ],
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in($this->types)],
            'normal_balance' => ['required', Rule::in(['debit', 'credit'])],
            'is_active' => 'sometimes|boolean',
        ]);

        $coa = ChartOfAccount::create([
            'company_id' => $user->company_id,
            'code' => $validated['code'],
            'name' => $validated['name'],
            'type' => $validated['type'],
            'normal_balance' => $validated['normal_balance'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Catat aktivitas tambah akun
        $this->logActivity(
            'created',
            'Menambahkan akun: ' . $coa->code . ' - ' . $coa->name,
            $coa
        );

        return redirect()
            ->route('coa.index')
            ->with('success', 'Akun baru berhasil ditambahkan ke Chart of Accounts.');
    }

    public function edit(Request $request, ChartOfAccount $coa)
    {
        abort_unless(
            $coa->company_id === $request->user()->company_id,
            403
        );

        return view('coa.edit', ['account' => $coa]);
    }

    public function update(Request $request, ChartOfAccount $coa)
    {
        abort_unless(
            $coa->company_id === $request->user()->company_id,
            403
        );

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('chart_of_accounts', 'code')
                    ->where('company_id', $request->user()->company_id)
                    ->ignore($coa->id),
            ],
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in($this->types)],
            'normal_balance' => ['required', Rule::in(['debit', 'credit'])],
            'is_active' => 'sometimes|boolean',
        ]);

        $coa->update([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'type' => $validated['type'],
            'normal_balance' => $validated['normal_balance'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Catat aktivitas edit akun
        $this->logActivity(
            'updated',
            'Memperbarui akun: ' . $coa->code . ' - ' . $coa->name,
            $coa
        );

        return redirect()
            ->route('coa.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(Request $request, ChartOfAccount $coa)
    {
        abort_unless(
            $coa->company_id === $request->user()->company_id,
            403
        );

        // Jangan sampai akun yang sudah punya transaksi di Buku Besar terhapus,
        // karena bakal ninggalin journal_entries yang "yatim" / data neraca jadi rusak.
        $hasEntries = JournalEntry::where(
            'chart_of_account_id',
            $coa->id
        )->exists();

        if ($hasEntries) {
            return redirect()
                ->route('coa.index')
                ->with(
                    'error',
                    'Akun "' . $coa->name . '" tidak bisa dihapus karena sudah punya transaksi di Buku Besar. Nonaktifkan saja akunnya kalau sudah tidak dipakai.'
                );
        }

        // Simpan identitas akun sebelum dihapus
        $accountDescription = $coa->code . ' - ' . $coa->name;

        // Catat aktivitas HAPUS sebelum delete()
        $this->logActivity(
            'deleted',
            'Menghapus akun: ' . $accountDescription,
            $coa
        );

        $coa->delete();

        return redirect()
            ->route('coa.index')
            ->with('success', 'Akun berhasil dihapus.');
    }

    /**
     * Mencatat aktivitas ke tabel activity_logs.
     */
    protected function logActivity(
        string $action,
        string $description,
        $subject = null
    ): void {
        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject
                ? get_class($subject)
                : null,
            'subject_id' => $subject->id ?? null,
            'ip_address' => request()->ip(),
        ]);
    }
}
