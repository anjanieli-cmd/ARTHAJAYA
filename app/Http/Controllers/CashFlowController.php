<?php

namespace App\Http\Controllers;

use App\Models\CashFlowItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashFlowController extends Controller
{
    protected array $activityLabels = [
        'operasional' => 'Aktivitas Operasional',
        'investasi'   => 'Aktivitas Investasi',
        'pendanaan'   => 'Aktivitas Pendanaan',
    ];

    public function index(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year = (int) $request->get('year', now()->year);

        $items = CashFlowItem::period($month, $year)
            ->orderBy('activity_type')
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $groups = [];

        foreach ($this->activityLabels as $key => $label) {
            $groupItems = $items->where('activity_type', $key);

            $masuk = (float) $groupItems
                ->where('direction', 'masuk')
                ->sum('amount');

            $keluar = (float) $groupItems
                ->where('direction', 'keluar')
                ->sum('amount');

            $groups[$key] = [
                'label' => $label,
                'items' => $groupItems,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'net' => $masuk - $keluar,
            ];
        }

        $totalMasuk = (float) $items
            ->where('direction', 'masuk')
            ->sum('amount');

        $totalKeluar = (float) $items
            ->where('direction', 'keluar')
            ->sum('amount');

        $netCashFlow = $totalMasuk - $totalKeluar;

        return view(
            'cash-flow.index',
            compact(
                'groups',
                'totalMasuk',
                'totalKeluar',
                'netCashFlow',
                'month',
                'year'
            )
        );
    }

    public function create()
    {
        return view('cash-flow.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'activity_type' => 'required|in:operasional,investasi,pendanaan',
            'direction' => 'required|in:masuk,keluar',
            'category' => 'required|string|max:100',
            'name' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0',
            'period_month' => 'required|integer|min:1|max:12',
            'period_year' => 'required|integer|min:2000|max:2100',
            'notes' => 'nullable|string',
        ]);

        $cashFlow = CashFlowItem::create($validated);

        /*
         * CATAT RIWAYAT AKTIVITAS
         */
        $activityLabel = $this->activityLabels[
            $cashFlow->activity_type
        ] ?? $cashFlow->activity_type;

        $directionLabel = $cashFlow->direction === 'masuk'
            ? 'Pemasukan'
            : 'Pengeluaran';

        $this->logActivity(
            'created',
            'Menambahkan transaksi arus kas: ' .
                $cashFlow->name .
                ' - ' .
                $activityLabel .
                ' (' .
                $directionLabel .
                ')',
            $cashFlow
        );

        return redirect()
            ->route('cash-flow.index', [
                'month' => $validated['period_month'],
                'year' => $validated['period_year'],
            ])
            ->with(
                'success',
                'Transaksi arus kas berhasil ditambahkan.'
            );
    }

    public function show(CashFlowItem $cash_flow)
    {
        return view(
            'cash-flow.show',
            [
                'item' => $cash_flow,
            ]
        );
    }

    public function edit(CashFlowItem $cash_flow)
    {
        return view(
            'cash-flow.edit',
            [
                'item' => $cash_flow,
            ]
        );
    }

    public function update(
        Request $request,
        CashFlowItem $cash_flow
    ) {
        $validated = $request->validate([
            'activity_type' => 'required|in:operasional,investasi,pendanaan',
            'direction' => 'required|in:masuk,keluar',
            'category' => 'required|string|max:100',
            'name' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0',
            'period_month' => 'required|integer|min:1|max:12',
            'period_year' => 'required|integer|min:2000|max:2100',
            'notes' => 'nullable|string',
        ]);

        // Simpan data lama untuk deskripsi riwayat.
        $oldName = $cash_flow->name;

        $cash_flow->update($validated);

        /*
         * CATAT RIWAYAT AKTIVITAS
         */
        $activityLabel = $this->activityLabels[
            $cash_flow->activity_type
        ] ?? $cash_flow->activity_type;

        $directionLabel = $cash_flow->direction === 'masuk'
            ? 'Pemasukan'
            : 'Pengeluaran';

        $this->logActivity(
            'updated',
            'Mengupdate transaksi arus kas: ' .
                $oldName .
                ' menjadi ' .
                $cash_flow->name .
                ' - ' .
                $activityLabel .
                ' (' .
                $directionLabel .
                ')',
            $cash_flow
        );

        return redirect()
            ->route('cash-flow.index', [
                'month' => $validated['period_month'],
                'year' => $validated['period_year'],
            ])
            ->with(
                'success',
                'Transaksi arus kas berhasil diperbarui.'
            );
    }

    public function destroy(CashFlowItem $cash_flow)
    {
        $month = $cash_flow->period_month;
        $year = $cash_flow->period_year;

        // Simpan data sebelum dihapus.
        $itemName = $cash_flow->name;
        $activityType = $this->activityLabels[
            $cash_flow->activity_type
        ] ?? $cash_flow->activity_type;

        $directionLabel = $cash_flow->direction === 'masuk'
            ? 'Pemasukan'
            : 'Pengeluaran';

        /*
         * CATAT RIWAYAT AKTIVITAS
         * sebelum data dihapus.
         */
        $this->logActivity(
            'deleted',
            'Menghapus transaksi arus kas: ' .
                $itemName .
                ' - ' .
                $activityType .
                ' (' .
                $directionLabel .
                ')',
            $cash_flow
        );

        $cash_flow->delete();

        return redirect()
            ->route('cash-flow.index', [
                'month' => $month,
                'year' => $year,
            ])
            ->with(
                'success',
                'Transaksi arus kas berhasil dihapus.'
            );
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