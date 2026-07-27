<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Support\Carbon;

class SystemStatsController extends Controller
{
    public function index()
    {
        $totalCompanies = Company::count();
        $activeCompanies = Company::where('status', 'active')->count();
        $totalUsers = User::count();
        $totalInvoices = Invoice::count();
        $totalInvoiceAmount = Invoice::sum('total');
        $totalClients = Client::count();
        $totalQuotes = Quote::count();

        $usersByLevel = [
            'admin' => User::where('access_level', 'admin')->count(),
            'staff' => User::where('access_level', 'staff')->count(),
            'user'  => User::where('access_level', 'user')->count(),
        ];

        // Pertumbuhan company & user 6 bulan terakhir
        $months = collect(range(5, 0))->map(function ($i) {
            return Carbon::now()->subMonths($i)->startOfMonth();
        });

        $companyGrowth = $months->map(function ($month) {
            return [
                'label' => $month->translatedFormat('M Y'),
                'count' => Company::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        });

        $userGrowth = $months->map(function ($month) {
            return [
                'label' => $month->translatedFormat('M Y'),
                'count' => User::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        });

        $maxCompanyGrowth = max(1, $companyGrowth->max('count'));
        $maxUserGrowth = max(1, $userGrowth->max('count'));

        $topCompanies = Company::withCount('invoices')
            ->orderByDesc('invoices_count')
            ->limit(5)
            ->get();

        return view('admin.stats.index', compact(
            'totalCompanies', 'activeCompanies', 'totalUsers', 'totalInvoices',
            'totalInvoiceAmount', 'totalClients', 'totalQuotes', 'usersByLevel',
            'companyGrowth', 'userGrowth', 'maxCompanyGrowth', 'maxUserGrowth',
            'topCompanies'
        ));
    }
}