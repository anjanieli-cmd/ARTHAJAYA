<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = Budget::where('company_id', $company->id)->latest();

        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(category) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(period) LIKE ?', ["%{$q}%"]);
            });
        }

        $budgets = $query->get();

        if ($request->ajax()) {
            return view('budgets.index', compact('user', 'company', 'budgets'))->render();
        }

        return view('budgets.index', compact('user', 'company', 'budgets'));
    }

    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        return view('budgets.create', compact('user', 'company'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $data = $request->validate([
            'category' => 'required|string|max:255',
            'period'   => 'required|string',
            'target'   => 'required|numeric',
            'actual'   => 'nullable|numeric',
            'status'   => 'nullable|string',
            'notes'    => 'nullable|string',
        ]);

        $target = (int) $data['target'];
        $actual = (int) ($data['actual'] ?? 0);
        $progress = $target > 0 ? (int) round(($actual / $target) * 100) : 0;

        $budget = Budget::create([
            'company_id' => $company->id,
            'category'   => $data['category'],
            'period'     => $data['period'],
            'target'     => $target,
            'actual'     => $actual,
            'progress'   => $progress,
            'status'     => $data['status'] ?? 'on_track',
            'notes'      => $data['notes'] ?? null,
        ]);

        $this->logActivity('created', "Membuat anggaran kategori {$budget->category}", $budget);

        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil dibuat!');
    }

    public function show(Budget $budget)
    {
        $this->authorizeCompany($budget);
        $user = Auth::user();
        $company = $user->company;
        return view('budgets.show', compact('user', 'company', 'budget'));
    }

    public function edit(Budget $budget)
    {
        $this->authorizeCompany($budget);
        $user = Auth::user();
        $company = $user->company;
        return view('budgets.edit', compact('user', 'company', 'budget'));
    }

    public function update(Request $request, Budget $budget)
    {
        $this->authorizeCompany($budget);

        $target = (int) $request->input('target', $budget->target);
        $actual = (int) $request->input('actual', $budget->actual);
        $progress = $target > 0 ? (int) round(($actual / $target) * 100) : 0;

        $budget->update([
            'category' => $request->input('category', $budget->category),
            'period'   => $request->input('period', $budget->period),
            'target'   => $target,
            'actual'   => $actual,
            'progress' => $progress,
            'status'   => $request->input('status', $budget->status),
            'notes'    => $request->input('notes', $budget->notes),
        ]);

        $this->logActivity('updated', "Mengupdate anggaran kategori {$budget->category}", $budget);

        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil diupdate!');
    }

    public function destroy(Budget $budget)
    {
        $this->authorizeCompany($budget);

        $category = $budget->category;
        $budget->delete();

        $this->logActivity('deleted', "Menghapus anggaran kategori {$category}");

        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil dihapus!');
    }

    public function export()
    {
        $company = Auth::user()->company;
        $budgets = Budget::where('company_id', $company->id)->get();

        $currencySymbol = 'Rp';

        $html = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
              xmlns:x="urn:schemas-microsoft-com:office:excel"
              xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta charset="UTF-8">
            <!--[if gte mso 9]>
            <xml>
                <x:ExcelWorkbook>
                    <x:ExcelWorksheets>
                        <x:ExcelWorksheet>
                            <x:Name>Anggaran</x:Name>
                            <x:WorksheetOptions>
                                <x:DisplayGridlines/>
                            </x:WorksheetOptions>
                        </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                </x:ExcelWorkbook>
            </xml>
            <![endif]-->
            <style>
                table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; }
                th { background: #6C5CE7; color: #ffffff; padding: 10px 12px; text-align: left; font-weight: bold; border: 1px solid #5A4BD1; }
                td { padding: 8px 12px; border: 1px solid #ddd; text-align: left; }
                .total-row { background: #f0f0f0; font-weight: bold; }
                .title { font-size: 18px; font-weight: bold; margin-bottom: 10px; color: #1a1a2e; }
                .subtitle { font-size: 12px; color: #666; margin-bottom: 20px; }
                .footer { margin-top: 20px; font-size: 11px; color: #999; text-align: center; }
            </style>
        </head>
        <body>
            <div class="title">Laporan Anggaran & Forecasting</div>
            <div class="subtitle">Periode: ' . date('F Y') . ' | Dicetak: ' . date('d F Y H:i') . '</div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Periode</th>
                        <th style="text-align:right">Target</th>
                        <th style="text-align:right">Realisasi</th>
                        <th style="text-align:right">Selisih</th>
                        <th style="text-align:center">Progress</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';

        $no = 1;
        $totalTarget = 0;
        $totalActual = 0;

        foreach ($budgets as $row) {
            $target = $row->target;
            $actual = $row->actual;
            $selisih = $actual - $target;
            $selisihText = ($selisih >= 0 ? '+' : '') . number_format($selisih, 0, ',', '.');
            $selisihColor = $selisih >= 0 ? '#34B583' : '#E85A5A';
            $statusLabel = [
                'on_track' => 'On Track',
                'over_budget' => 'Over Budget',
                'under_budget' => 'Under Budget',
            ][$row->status] ?? $row->status;

            $totalTarget += $target;
            $totalActual += $actual;

            $html .= '
                    <tr>
                        <td>' . $no++ . '</td>
                        <td><strong>' . e($row->category) . '</strong></td>
                        <td>' . e($row->period) . '</td>
                        <td style="text-align:right">' . $currencySymbol . ' ' . number_format($target, 0, ',', '.') . '</td>
                        <td style="text-align:right">' . $currencySymbol . ' ' . number_format($actual, 0, ',', '.') . '</td>
                        <td style="text-align:right; color:' . $selisihColor . '">' . $selisihText . '</td>
                        <td style="text-align:center"><strong>' . $row->progress . '%</strong></td>
                        <td>' . $statusLabel . '</td>
                    </tr>';
        }

        $totalSelisih = $totalActual - $totalTarget;
        $totalSelisihText = ($totalSelisih >= 0 ? '+' : '') . number_format($totalSelisih, 0, ',', '.');
        $totalSelisihColor = $totalSelisih >= 0 ? '#34B583' : '#E85A5A';

        $html .= '
                    <tr class="total-row">
                        <td colspan="2" style="text-align:right"><strong>TOTAL</strong></td>
                        <td></td>
                        <td style="text-align:right"><strong>' . $currencySymbol . ' ' . number_format($totalTarget, 0, ',', '.') . '</strong></td>
                        <td style="text-align:right"><strong>' . $currencySymbol . ' ' . number_format($totalActual, 0, ',', '.') . '</strong></td>
                        <td style="text-align:right; color:' . $totalSelisihColor . '"><strong>' . $totalSelisihText . '</strong></td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>

            <div class="footer">Laporan ini dihasilkan secara otomatis oleh Arvessa System</div>
        </body>
        </html>';

        $filename = 'Anggaran_Forecasting_' . date('Y-m-d') . '.xls';

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    private function authorizeCompany(Budget $budget): void
    {
        abort_unless($budget->company_id === Auth::user()->company->id, 404);
    }
}