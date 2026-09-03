<?php

namespace App\Http\Controllers;

use App\Models\TaxPpn;
use App\Services\JournalService;
use Illuminate\Http\Request;

class TaxPpnController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        $query = TaxPpn::where('company_id', $company->id)->orderByDesc('id');

        if ($q = $request->get('q')) {
            $q = strtolower($q);
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(period) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('CAST(ppn AS CHAR) LIKE ?', ["%{$q}%"]);
            });
        }

        $ppnData = $query->get()->map(function ($item) {
            return [
                '_index' => $item->id,
                'period' => $item->period,
                'output' => (int) $item->output,
                'input'  => (int) $item->input,
                'ppn'    => (int) $item->ppn,
                'status' => $item->status,
                'due'    => $item->due->format('Y-m-d'),
                'notes'  => $item->notes,
            ];
        })->toArray();

        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        if ($request->ajax()) {
            return view('taxes.ppn', compact('user', 'company', 'ppnData', 'currencySymbol'))->render();
        }

        return view('taxes.ppn', compact('user', 'company', 'ppnData', 'currencySymbol'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        return view('taxes.create_ppn', compact('user', 'company'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'period' => 'required|string|max:100',
            'output' => 'required|numeric|min:0',
            'input'  => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,paid',
            'due'    => 'required|date',
            'notes'  => 'nullable|string',
        ]);

        $output = (float) $validated['output'];
        $input = (float) ($validated['input'] ?? 0);

        $ppn = TaxPpn::create([
            'company_id' => $user->company_id,
            'period'     => $validated['period'],
            'output'     => $output,
            'input'      => $input,
            'ppn'        => $output - $input,
            'status'     => $validated['status'],
            'due'        => $validated['due'],
            'notes'      => $validated['notes'] ?? null,
        ]);

        JournalService::record(
            companyId: $user->company_id,
            debitAccountCode: '5-101',   // Biaya Operasional (proxy biaya pajak)
            creditAccountCode: '2-102',  // Utang Pajak
            amount: $output - $input,
            description: 'PPN periode ' . $validated['period'],
            referenceType: TaxPpn::class,
            referenceId: $ppn->id,
            date: $validated['due'],
        );

        return redirect()->route('taxes.ppn')->with('success', 'PPN berhasil ditambahkan!');
    }

    public function show(Request $request, $index)
    {
        $user = $request->user();
        $ppn = TaxPpn::where('company_id', $user->company_id)->findOrFail($index);

        return view('taxes.show_ppn', [
            'user' => $user,
            'company' => $user->company,
            'ppn' => [
                '_index' => $ppn->id,
                'period' => $ppn->period,
                'output' => (int) $ppn->output,
                'input' => (int) $ppn->input,
                'ppn' => (int) $ppn->ppn,
                'status' => $ppn->status,
                'due' => $ppn->due->format('Y-m-d'),
                'notes' => $ppn->notes,
            ],
            'index' => $ppn->id,
        ]);
    }

    public function edit(Request $request, $index)
    {
        $user = $request->user();
        $ppn = TaxPpn::where('company_id', $user->company_id)->findOrFail($index);

        return view('taxes.edit_ppn', [
            'user' => $user,
            'company' => $user->company,
            'ppn' => [
                '_index' => $ppn->id,
                'period' => $ppn->period,
                'output' => (int) $ppn->output,
                'input' => (int) $ppn->input,
                'ppn' => (int) $ppn->ppn,
                'status' => $ppn->status,
                'due' => $ppn->due->format('Y-m-d'),
                'notes' => $ppn->notes,
            ],
            'index' => $ppn->id,
        ]);
    }

    public function update(Request $request, $index)
    {
        $user = $request->user();
        $ppn = TaxPpn::where('company_id', $user->company_id)->findOrFail($index);

        $output = (float) $request->input('output', $ppn->output);
        $input = (float) $request->input('input', $ppn->input);

        $ppn->update([
            'period' => $request->input('period', $ppn->period),
            'output' => $output,
            'input'  => $input,
            'ppn'    => $output - $input,
            'status' => $request->input('status', $ppn->status),
            'due'    => $request->input('due', $ppn->due),
            'notes'  => $request->input('notes', $ppn->notes),
        ]);

        return redirect()->route('taxes.ppn')->with('success', 'PPN berhasil diupdate!');
    }

    public function destroy(Request $request, $index)
    {
        $user = $request->user();
        $ppn = TaxPpn::where('company_id', $user->company_id)->findOrFail($index);
        $ppn->delete();

        return redirect()->route('taxes.ppn')->with('success', 'Data PPN berhasil dihapus!');
    }

    public function pay(Request $request, $index)
    {
        $user = $request->user();
        $ppn = TaxPpn::where('company_id', $user->company_id)->findOrFail($index);

        if ($ppn->status === 'paid') {
            return redirect()->route('taxes.ppn')->with('error', 'PPN ini sudah dibayar sebelumnya!');
        }

        $ppn->update(['status' => 'paid']);

        JournalService::record(
            companyId: $user->company_id,
            debitAccountCode: '2-102',   // Utang Pajak (berkurang)
            creditAccountCode: '1-101',  // Kas (berkurang)
            amount: $ppn->ppn,
            description: 'Pembayaran PPN periode ' . $ppn->period,
            referenceType: TaxPpn::class,
            referenceId: $ppn->id,
            date: now()->toDateString(),
        );

        return redirect()->route('taxes.ppn')->with('success', 'PPN berhasil dibayar!');
    }
}