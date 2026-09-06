<?php

namespace App\Http\Controllers;

use App\Models\BankMutation;
use App\Models\Expense;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard utama. Sebelumnya kartu-kartu di sini baca dari
     * session('ledger_entries'|'expense_categories'|'invoices') yang
     * memang tidak pernah diisi controller manapun (peninggalan versi
     * lama sebelum modul dikonversi ke database), plus ada fallback
     * dummy hardcoded kalau data kosong. Sekarang semuanya dihitung
     * langsung dari tabel asli: BankMutation (kas), Expense (pengeluaran),
     * dan Invoice (piutang/faktur).
     */
    public function index()
    {
        $user = Auth::user();
        $company = $user->company;

        if (! $company) {
            return view('staff.dashboard', [
                'user' => $user,
                'company' => $company,
                'account' => null,
            ]);
        }

        $account = $company->accounts()->first();
        $companyId = $company->id;
        $today = Carbon::today();
        $currentMonth = $today->format('Y-m');

        // ===== SALDO KAS & ARUS KAS (dari BankMutation) =====
        $initialBalanceTotal = (float) $company->accounts()->sum('initial_balance');

        $mutations = BankMutation::where('company_id', $companyId)->get();

        $netMutations = $mutations->sum(function ($m) {
            return $m->type === 'masuk' ? (float) $m->amount : -1 * (float) $m->amount;
        });

        $totalBalance = $initialBalanceTotal + $netMutations;

        $totalIncome = (float) $mutations
            ->filter(fn ($m) => $m->type === 'masuk' && optional($m->date)->format('Y-m') === $currentMonth)
            ->sum('amount');

        $totalExpense = (float) $mutations
            ->filter(fn ($m) => $m->type === 'keluar' && optional($m->date)->format('Y-m') === $currentMonth)
            ->sum('amount');

        // 5 transaksi kas terbaru
        $recentTransactions = $mutations
            ->sortByDesc(fn ($m) => optional($m->date)->format('Y-m-d') . '-' . str_pad($m->id, 10, '0', STR_PAD_LEFT))
            ->take(5)
            ->map(fn ($m) => [
                'description' => $m->description,
                'date' => optional($m->date)->format('d M Y'),
                'amount' => $m->type === 'masuk' ? (float) $m->amount : -1 * (float) $m->amount,
                'status' => 'lunas',
            ])
            ->values()
            ->toArray();

        // Arus kas 6 bulan terakhir
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = $today->copy()->subMonths($i)->format('Y-m');
            $monthlyData[$month] = ['income' => 0, 'expense' => 0];
        }

        foreach ($mutations as $m) {
            $monthKey = optional($m->date)->format('Y-m');

            if ($monthKey && isset($monthlyData[$monthKey])) {
                if ($m->type === 'masuk') {
                    $monthlyData[$monthKey]['income'] += (float) $m->amount;
                } else {
                    $monthlyData[$monthKey]['expense'] += (float) $m->amount;
                }
            }
        }

        // ===== RINGKASAN PENGELUARAN (donut, dari Expense bulan berjalan) =====
        $colors = ['var(--theme-primary)', '#4E8FF0', '#F0C05A', '#9B7BE0', '#E85A9C', '#F0A25A'];

        $expenseByCategory = Expense::with('category')
            ->where('company_id', $companyId)
            ->whereYear('date', $today->year)
            ->whereMonth('date', $today->month)
            ->get()
            ->groupBy(fn ($e) => $e->category->name ?? 'Lainnya')
            ->map(fn ($group) => (float) $group->sum('amount'));

        $donutData = [];
        $colorIndex = 0;

        foreach ($expenseByCategory as $name => $total) {
            if ($total > 0) {
                $donutData[] = [
                    'name' => $name,
                    'total' => $total,
                    'color' => $colors[$colorIndex % count($colors)],
                ];
                $colorIndex++;
            }
        }

        $donutTotal = array_sum(array_column($donutData, 'total'));

        // ===== FAKTUR AKAN JATUH TEMPO (dari Invoice) =====
        $upcomingInvoices = Invoice::with('client')
            ->where('company_id', $companyId)
            ->where('status', 'sent')
            ->orderBy('due_date')
            ->take(3)
            ->get()
            ->map(fn (Invoice $inv) => [
                'number' => $inv->invoice_number,
                'client' => $inv->client->name ?? 'Klien terhapus',
                'due_date' => optional($inv->due_date)->format('Y-m-d'),
                'amount' => (float) $inv->total,
                'is_overdue' => $inv->due_date && $inv->due_date->isPast(),
            ])
            ->values()
            ->toArray();

        // ===== FAKTUR BELUM DIBAYAR (stat card) =====
        $outstandingBase = Invoice::where('company_id', $companyId)->where('status', 'sent');

        $countOutstanding = (clone $outstandingBase)->count();
        $totalOutstanding = (float) (clone $outstandingBase)->sum('total');
        $totalOverdue = (float) (clone $outstandingBase)->where('due_date', '<', $today)->sum('total');
        $totalPending = $totalOutstanding - $totalOverdue;

        // ===== TIM PERUSAHAAN =====
        $teamMembers = $company->users()->where('id', '!=', $user->id)->get();

        return view('staff.dashboard', compact(
            'user',
            'company',
            'account',
            'totalBalance',
            'totalIncome',
            'totalExpense',
            'recentTransactions',
            'monthlyData',
            'donutData',
            'donutTotal',
            'upcomingInvoices',
            'totalPending',
            'totalOverdue',
            'countOutstanding',
            'teamMembers'
        ));
    }
}