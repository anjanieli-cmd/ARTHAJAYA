<?php

namespace App\Http\Controllers;

use App\Models\PpnTax;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PpnTaxController extends Controller
{
    use LogsActivity;

    /**
     * =========================================================
     * INDEX
     * =========================================================
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        $query = PpnTax::where('company_id', $company->id)
            ->latest('id');

        if ($request->filled('q')) {
            $q = strtolower(trim($request->q));

            $query->where(function ($sub) use ($q) {
                $sub->whereRaw(
                    'LOWER(period) LIKE ?',
                    ["%{$q}%"]
                )->orWhereRaw(
                    'LOWER(status) LIKE ?',
                    ["%{$q}%"]
                );
            });
        }

        $ppnData = $query->get();

        if ($request->ajax()) {
            return view(
                'taxes.ppn',
                compact('user', 'company', 'ppnData')
            )->render();
        }

        return view(
            'taxes.ppn',
            compact('user', 'company', 'ppnData')
        );
    }

    /**
     * =========================================================
     * CREATE
     * =========================================================
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        return view(
            'taxes.create_ppn',
            compact('user', 'company')
        );
    }

    /**
     * =========================================================
     * STORE
     * =========================================================
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        $validated = $request->validate([
            'period' => [
                'required',
                'string',
                'max:100',
            ],

            'output' => [
                'required',
                'numeric',
                'min:0',
            ],

            'input' => [
                'required',
                'numeric',
                'min:0',
            ],

            'due' => [
                'nullable',
                'date',
            ],

            'status' => [
                'nullable',
                'in:pending,paid',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $output = (float) $validated['output'];
        $input = (float) $validated['input'];

        /*
         * PPN terutang:
         * PPN Keluaran - PPN Masukan
         *
         * Kalau hasilnya negatif, dibuat 0.
         */
        $ppn = max(0, $output - $input);

        try {
            DB::beginTransaction();

            $ppnTax = PpnTax::create([
                'company_id' => $company->id,
                'period' => $validated['period'],
                'output' => $output,
                'input' => $input,
                'ppn' => $ppn,
                'status' => $validated['status'] ?? 'pending',
                'due_date' => $validated['due'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            $this->logActivity(
                'created',
                "Menambahkan PPN periode {$ppnTax->period}",
                $ppnTax
            );

            DB::commit();

            return redirect()
                ->route('taxes.ppn')
                ->with(
                    'success',
                    'PPN berhasil ditambahkan!'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error(
                'Gagal menyimpan PPN.',
                [
                    'company_id' => $company->id,
                    'error' => $e->getMessage(),
                ]
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'PPN gagal disimpan. Silakan periksa kembali data yang dimasukkan.'
                );
        }
    }

    /**
     * =========================================================
     * SHOW
     * =========================================================
     */
    public function show(PpnTax $ppn)
    {
        $this->authorizeCompany($ppn);

        $user = Auth::user();
        $company = $user->company;

        return view(
            'taxes.show_ppn',
            compact('user', 'company', 'ppn')
        );
    }

    /**
     * =========================================================
     * EDIT
     * =========================================================
     */
    public function edit(PpnTax $ppn)
    {
        $this->authorizeCompany($ppn);

        $user = Auth::user();
        $company = $user->company;

        return view(
            'taxes.edit_ppn',
            compact('user', 'company', 'ppn')
        );
    }

    /**
     * =========================================================
     * UPDATE
     * =========================================================
     */
    public function update(
        Request $request,
        PpnTax $ppn
    ) {
        $this->authorizeCompany($ppn);

        $validated = $request->validate([
            'period' => [
                'required',
                'string',
                'max:100',
            ],

            'output' => [
                'required',
                'numeric',
                'min:0',
            ],

            'input' => [
                'required',
                'numeric',
                'min:0',
            ],

            'due' => [
                'nullable',
                'date',
            ],

            'status' => [
                'nullable',
                'in:pending,paid',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $output = (float) $validated['output'];
        $input = (float) $validated['input'];

        $ppn = max(0, $output - $input);

        $ppn->update([
            'period' => $validated['period'],
            'output' => $output,
            'input' => $input,
            'ppn' => $ppn,
            'status' => $validated['status'] ?? $ppn->status,
            'due_date' => $validated['due'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        $this->logActivity(
            'updated',
            "Mengupdate PPN periode {$ppn->period}",
            $ppn
        );

        return redirect()
            ->route('taxes.ppn')
            ->with(
                'success',
                'PPN berhasil diupdate!'
            );
    }

    /**
     * =========================================================
     * DESTROY
     * =========================================================
     */
    public function destroy(PpnTax $ppn)
    {
        $this->authorizeCompany($ppn);

        $period = $ppn->period;

        $ppn->delete();

        $this->logActivity(
            'deleted',
            "Menghapus data PPN periode {$period}"
        );

        return redirect()
            ->route('taxes.ppn')
            ->with(
                'success',
                'Data PPN berhasil dihapus!'
            );
    }

    /**
     * =========================================================
     * PAY
     * =========================================================
     */
    public function pay(PpnTax $ppn)
    {
        $this->authorizeCompany($ppn);

        if ($ppn->status === 'paid') {
            return redirect()
                ->route('taxes.ppn')
                ->with(
                    'error',
                    'PPN ini sudah dibayar sebelumnya!'
                );
        }

        $ppn->update([
            'status' => 'paid',
        ]);

        $this->logActivity(
            'updated',
            "Membayar PPN periode {$ppn->period}",
            $ppn
        );

        return redirect()
            ->route('taxes.ppn')
            ->with(
                'success',
                'PPN berhasil dibayar!'
            );
    }

    /**
     * =========================================================
     * AUTHORIZE COMPANY
     * =========================================================
     */
    private function authorizeCompany(PpnTax $ppn): void
    {
        abort_unless(
            $ppn->company_id === Auth::user()->company->id,
            404
        );
    }
}