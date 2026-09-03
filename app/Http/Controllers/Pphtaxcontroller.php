<?php

namespace App\Http\Controllers;

use App\Models\PphTax;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PphTaxController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = PphTax::where('company_id', $company->id)->latest();

        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('period', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%");
            });
        }

        $pphData = $query->get();

        if ($request->ajax()) {
            return view('taxes.pph', compact('user', 'company', 'pphData'))->render();
        }

        return view('taxes.pph', compact('user', 'company', 'pphData'));
    }

    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        return view('taxes.create_pph', compact('user', 'company'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $data = $request->validate([
            'period'    => 'required|string',
            'gross'     => 'required|numeric',
            'deduction' => 'required|numeric',
            'tax'       => 'required|numeric',
            'due'       => 'nullable|date',
            'status'    => 'nullable|string',
            'notes'     => 'nullable|string',
        ]);

        $pph = PphTax::create([
            'company_id' => $company->id,
            'period'     => $data['period'],
            'gross'      => (int) $data['gross'],
            'deduction'  => (int) $data['deduction'],
            'taxable'    => (int) $data['gross'] - (int) $data['deduction'],
            'tax'        => (int) $data['tax'],
            'status'     => $data['status'] ?? 'pending',
            'due_date'   => $data['due'] ?? null,
            'notes'      => $data['notes'] ?? null,
        ]);

        $this->logActivity('created', "Menambahkan PPh periode {$pph->period}", $pph);

        return redirect()->route('taxes.pph')->with('success', 'PPh berhasil ditambahkan!');
    }

    public function show(PphTax $pph)
    {
        $this->authorizeCompany($pph);
        $user = Auth::user();
        $company = $user->company;
        return view('taxes.show_pph', compact('user', 'company', 'pph'));
    }

    public function edit(PphTax $pph)
    {
        $this->authorizeCompany($pph);
        $user = Auth::user();
        $company = $user->company;
        return view('taxes.edit_pph', compact('user', 'company', 'pph'));
    }

    public function update(Request $request, PphTax $pph)
    {
        $this->authorizeCompany($pph);

        $gross = (int) $request->input('gross', $pph->gross);
        $deduction = (int) $request->input('deduction', $pph->deduction);

        $pph->update([
            'period'    => $request->input('period', $pph->period),
            'gross'     => $gross,
            'deduction' => $deduction,
            'taxable'   => $gross - $deduction,
            'tax'       => (int) $request->input('tax', $pph->tax),
            'status'    => $request->input('status', $pph->status),
            'due_date'  => $request->input('due', $pph->due_date),
            'notes'     => $request->input('notes', $pph->notes),
        ]);

        $this->logActivity('updated', "Mengupdate PPh periode {$pph->period}", $pph);

        return redirect()->route('taxes.pph')->with('success', 'PPh berhasil diupdate!');
    }

    public function destroy(PphTax $pph)
    {
        $this->authorizeCompany($pph);

        $period = $pph->period;
        $pph->delete();

        $this->logActivity('deleted', "Menghapus data PPh periode {$period}");

        return redirect()->route('taxes.pph')->with('success', 'Data PPh berhasil dihapus!');
    }

    public function pay(PphTax $pph)
    {
        $this->authorizeCompany($pph);

        $pph->update(['status' => 'paid']);

        $this->logActivity('updated', "Membayar PPh periode {$pph->period}", $pph);

        return redirect()->route('taxes.pph')->with('success', 'PPh berhasil dibayar!');
    }

    private function authorizeCompany(PphTax $pph): void
    {
        abort_unless($pph->company_id === Auth::user()->company->id, 404);
    }
}