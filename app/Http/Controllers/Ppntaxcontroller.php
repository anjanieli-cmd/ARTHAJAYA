<?php

namespace App\Http\Controllers;

use App\Models\PpnTax;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PpnTaxController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = PpnTax::where('company_id', $company->id)->latest();

        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('period', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%");
            });
        }

        $ppnData = $query->get();

        if ($request->ajax()) {
            return view('taxes.ppn', compact('user', 'company', 'ppnData'))->render();
        }

        return view('taxes.ppn', compact('user', 'company', 'ppnData'));
    }

    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        return view('taxes.create_ppn', compact('user', 'company'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $data = $request->validate([
            'period' => 'required|string',
            'output' => 'required|numeric',
            'input'  => 'required|numeric',
            'due'    => 'nullable|date',
            'status' => 'nullable|string',
            'notes'  => 'nullable|string',
        ]);

        $ppn = PpnTax::create([
            'company_id' => $company->id,
            'period'     => $data['period'],
            'output'     => (int) $data['output'],
            'input'      => (int) $data['input'],
            'ppn'        => (int) $data['output'] - (int) $data['input'],
            'status'     => $data['status'] ?? 'pending',
            'due_date'   => $data['due'] ?? null,
            'notes'      => $data['notes'] ?? null,
        ]);

        $this->logActivity('created', "Menambahkan PPN periode {$ppn->period}", $ppn);

        return redirect()->route('taxes.ppn')->with('success', 'PPN berhasil ditambahkan!');
    }

    public function show(PpnTax $ppn)
    {
        $this->authorizeCompany($ppn);
        $user = Auth::user();
        $company = $user->company;
        return view('taxes.show_ppn', compact('user', 'company', 'ppn'));
    }

    public function edit(PpnTax $ppn)
    {
        $this->authorizeCompany($ppn);
        $user = Auth::user();
        $company = $user->company;
        return view('taxes.edit_ppn', compact('user', 'company', 'ppn'));
    }

    public function update(Request $request, PpnTax $ppn)
    {
        $this->authorizeCompany($ppn);

        $output = (int) $request->input('output', $ppn->output);
        $input = (int) $request->input('input', $ppn->input);

        $ppn->update([
            'period'   => $request->input('period', $ppn->period),
            'output'   => $output,
            'input'    => $input,
            'ppn'      => $output - $input,
            'status'   => $request->input('status', $ppn->status),
            'due_date' => $request->input('due', $ppn->due_date),
            'notes'    => $request->input('notes', $ppn->notes),
        ]);

        $this->logActivity('updated', "Mengupdate PPN periode {$ppn->period}", $ppn);

        return redirect()->route('taxes.ppn')->with('success', 'PPN berhasil diupdate!');
    }

    public function destroy(PpnTax $ppn)
    {
        $this->authorizeCompany($ppn);

        $period = $ppn->period;
        $ppn->delete();

        $this->logActivity('deleted', "Menghapus data PPN periode {$period}");

        return redirect()->route('taxes.ppn')->with('success', 'Data PPN berhasil dihapus!');
    }

    public function pay(PpnTax $ppn)
    {
        $this->authorizeCompany($ppn);

        $ppn->update(['status' => 'paid']);

        $this->logActivity('updated', "Membayar PPN periode {$ppn->period}", $ppn);

        return redirect()->route('taxes.ppn')->with('success', 'PPN berhasil dibayar!');
    }

    private function authorizeCompany(PpnTax $ppn): void
    {
        abort_unless($ppn->company_id === Auth::user()->company->id, 404);
    }
}