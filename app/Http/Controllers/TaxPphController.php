<?php

namespace App\Http\Controllers;

use App\Models\TaxPph;
use App\Services\JournalService;
use Illuminate\Http\Request;

class TaxPphController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        $query = TaxPph::where('company_id', $company->id)->orderByDesc('id');

        if ($q = $request->get('q')) {
            $q = strtolower($q);
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(period) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('CAST(tax AS CHAR) LIKE ?', ["%{$q}%"]);
            });
        }

        $pphData = $query->get()->map(function ($item) {
            return [
                '_index'    => $item->id,
                'period'    => $item->period,
                'gross'     => (int) $item->gross,
                'deduction' => (int) $item->deduction,
                'taxable'   => (int) $item->taxable,
                'tax'       => (int) $item->tax,
                'status'    => $item->status,
                'due'       => $item->due->format('Y-m-d'),
                'notes'     => $item->notes,
            ];
        })->toArray();

        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        if ($request->ajax()) {
            return view('taxes.pph', compact('user', 'company', 'pphData', 'currencySymbol'))->render();
        }

        return view('taxes.pph', compact('user', 'company', 'pphData', 'currencySymbol'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        return view('taxes.create_pph', compact('user', 'company'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'period'     => 'required|string|max:100',
            'gross'      => 'required|numeric|min:0',
            'deduction'  => 'nullable|numeric|min:0',
            'tax'        => 'required|numeric|min:0',
            'status'     => 'required|in:pending,paid',
            'due'        => 'required|date',
            'notes'      => 'nullable|string',
        ]);

        $gross = (float) $validated['gross'];
        $deduction = (float) ($validated['deduction'] ?? 0);

        $pph = TaxPph::create([
            'company_id' => $user->company_id,
            'period'     => $validated['period'],
            'gross'      => $gross,
            'deduction'  => $deduction,
            'taxable'    => $gross - $deduction,
            'tax'        => $validated['tax'],
            'status'     => $validated['status'],
            'due'        => $validated['due'],
            'notes'      => $validated['notes'] ?? null,
        ]);

        // Catat kewajiban pajak ke jurnal: Debit Biaya, Credit Utang Pajak
        JournalService::record(
            companyId: $user->company_id,
            debitAccountCode: '5-101',   // Biaya Operasional (proxy biaya pajak)
            creditAccountCode: '2-102',  // Utang Pajak
            amount: $validated['tax'],
            description: 'PPh periode ' . $validated['period'],
            referenceType: TaxPph::class,
            referenceId: $pph->id,
            date: $validated['due'],
        );

        return redirect()->route('taxes.pph')->with('success', 'PPh berhasil ditambahkan!');
    }

    public function show(Request $request, $index)
    {
        $user = $request->user();
        $pph = TaxPph::where('company_id', $user->company_id)->findOrFail($index);

        return view('taxes.show_pph', [
            'user' => $user,
            'company' => $user->company,
            'pph' => [
                '_index' => $pph->id,
                'period' => $pph->period,
                'gross' => (int) $pph->gross,
                'deduction' => (int) $pph->deduction,
                'taxable' => (int) $pph->taxable,
                'tax' => (int) $pph->tax,
                'status' => $pph->status,
                'due' => $pph->due->format('Y-m-d'),
                'notes' => $pph->notes,
            ],
            'index' => $pph->id,
        ]);
    }

    public function edit(Request $request, $index)
    {
        $user = $request->user();
        $pph = TaxPph::where('company_id', $user->company_id)->findOrFail($index);

        return view('taxes.edit_pph', [
            'user' => $user,
            'company' => $user->company,
            'pph' => [
                '_index' => $pph->id,
                'period' => $pph->period,
                'gross' => (int) $pph->gross,
                'deduction' => (int) $pph->deduction,
                'taxable' => (int) $pph->taxable,
                'tax' => (int) $pph->tax,
                'status' => $pph->status,
                'due' => $pph->due->format('Y-m-d'),
                'notes' => $pph->notes,
            ],
            'index' => $pph->id,
        ]);
    }

    public function update(Request $request, $index)
    {
        $user = $request->user();
        $pph = TaxPph::where('company_id', $user->company_id)->findOrFail($index);

        $gross = (float) $request->input('gross', $pph->gross);
        $deduction = (float) $request->input('deduction', $pph->deduction);

        $pph->update([
            'period'    => $request->input('period', $pph->period),
            'gross'     => $gross,
            'deduction' => $deduction,
            'taxable'   => $gross - $deduction,
            'tax'       => $request->input('tax', $pph->tax),
            'status'    => $request->input('status', $pph->status),
            'due'       => $request->input('due', $pph->due),
            'notes'     => $request->input('notes', $pph->notes),
        ]);

        return redirect()->route('taxes.pph')->with('success', 'PPh berhasil diupdate!');
    }

    public function destroy(Request $request, $index)
    {
        $user = $request->user();
        $pph = TaxPph::where('company_id', $user->company_id)->findOrFail($index);
        $pph->delete();

        return redirect()->route('taxes.pph')->with('success', 'Data PPh berhasil dihapus!');
    }

    public function pay(Request $request, $index)
    {
        $user = $request->user();
        $pph = TaxPph::where('company_id', $user->company_id)->findOrFail($index);

        if ($pph->status === 'paid') {
            return redirect()->route('taxes.pph')->with('error', 'PPh ini sudah dibayar sebelumnya!');
        }

        $pph->update(['status' => 'paid']);

        // Pelunasan: Debit Utang Pajak, Credit Kas
        JournalService::record(
            companyId: $user->company_id,
            debitAccountCode: '2-102',   // Utang Pajak (berkurang)
            creditAccountCode: '1-101',  // Kas (berkurang)
            amount: $pph->tax,
            description: 'Pembayaran PPh periode ' . $pph->period,
            referenceType: TaxPph::class,
            referenceId: $pph->id,
            date: now()->toDateString(),
        );

        return redirect()->route('taxes.pph')->with('success', 'PPh berhasil dibayar!');
    }
}