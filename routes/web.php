<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\NeracaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CashFlowController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\ChartOfAccountController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CogsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ReceivableController;
use App\Http\Controllers\PayableController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CompanyManagementController;
use App\Http\Controllers\Admin\SystemStatsController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminSecurityController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\UserDashboardController; // <-- TAMBAHKAN INI
use App\Http\Controllers\StaffExpenseApprovalController;
use App\Http\Controllers\StaffTicketController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\ActivityHistoryController;


// Homepage
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Onboarding routes (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding.show');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
    Route::post('/onboarding/update', [OnboardingController::class, 'update'])->name('onboarding.update');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================================================================
// DASHBOARD & PROTECTED ROUTES (auth + onboarding complete + STAFF ONLY)
// ================================================================
Route::middleware(['auth', 'onboarding.complete', 'access:staff'])->group(function () {

    // ===== DASHBOARD =====
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $company = $user->company;
        $account = $company ? $company->accounts()->first() : null;

        return view('staff.dashboard', compact('user', 'company', 'account'));
    })->name('dashboard');

    // ===== NOTIFIKASI =====
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notifications.index');
        Route::post('/notifications/{id}/read', 'markAsRead')->name('notifications.read');
        Route::post('/notifications/read-all', 'markAllAsRead')->name('notifications.readAll');
    });

    // ===== INVOICES =====
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoices', 'index')->name('invoices.index');
        Route::get('/invoices/create', 'create')->name('invoices.create');
        Route::post('/invoices', 'store')->name('invoices.store');
        Route::get('/invoices/export', 'export')->name('invoices.export');
        Route::get('/invoices/{invoice}', 'show')->name('invoices.show');
        Route::get('/invoices/{invoice}/edit', 'edit')->name('invoices.edit');
        Route::put('/invoices/{invoice}', 'update')->name('invoices.update');
        Route::delete('/invoices/{invoice}', 'destroy')->name('invoices.destroy');
        Route::post('/invoices/{invoice}/send', 'send')->name('invoices.send');
    });

    // ===== CLIENTS =====
    Route::resource('clients', ClientController::class);

    // ===== QUOTES =====
    Route::controller(QuoteController::class)->group(function () {
        Route::get('/quotes', 'index')->name('quotes.index');
        Route::get('/quotes/create', 'create')->name('quotes.create');
        Route::post('/quotes', 'store')->name('quotes.store');
        Route::get('/quotes/{quote}', 'show')->name('quotes.show');
        Route::get('/quotes/{quote}/edit', 'edit')->name('quotes.edit');
        Route::put('/quotes/{quote}', 'update')->name('quotes.update');
        Route::delete('/quotes/{quote}', 'destroy')->name('quotes.destroy');
        Route::delete('/quotes/bulk-destroy', 'bulkDestroy')->name('quotes.bulk-destroy');
    });

    // ===== PIUTANG & UTANG (AR / AP) =====
    Route::middleware(['feature:piutang_utang'])->group(function () {
        Route::get('/receivables', [ReceivableController::class, 'index'])->name('receivables.index');
        Route::get('/receivables/create', [ReceivableController::class, 'create'])->name('receivables.create');
        Route::post('/receivables', [ReceivableController::class, 'store'])->name('receivables.store');
        Route::get('/receivables/{receivable}', [ReceivableController::class, 'show'])->name('receivables.show');
        Route::get('/receivables/{receivable}/edit', [ReceivableController::class, 'edit'])->name('receivables.edit');
        Route::put('/receivables/{receivable}', [ReceivableController::class, 'update'])->name('receivables.update');
        Route::delete('/receivables/{receivable}', [ReceivableController::class, 'destroy'])->name('receivables.destroy');

        // ===== PAYABLES =====
        Route::get('/payables', [PayableController::class, 'index'])->name('payables.index');
        Route::get('/payables/create', [PayableController::class, 'create'])->name('payables.create');
        Route::post('/payables', [PayableController::class, 'store'])->name('payables.store');
        Route::get('/payables/{payable}', [PayableController::class, 'show'])->name('payables.show');
        Route::get('/payables/{payable}/edit', [PayableController::class, 'edit'])->name('payables.edit');
        Route::put('/payables/{payable}', [PayableController::class, 'update'])->name('payables.update');
        Route::delete('/payables/{payable}', [PayableController::class, 'destroy'])->name('payables.destroy');

        // ===== AGING =====
        Route::get('/aging', function () {
            $user = Auth::user();
            $company = $user->company;

            $defaultArRows = [
                ['name' => 'PT Andalas Maju Bersama', 'invoice' => '#0568', 'current' => 5750000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'Nusantara Logistik',      'invoice' => '#0571', 'current' => 18400000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'Bumi Retail Group',       'invoice' => '#0552', 'current' => 0, 'd30' => 9200000, 'd60' => 0, 'd90' => 0],
                ['name' => 'Kopi Kenangan Senja',     'invoice' => '#0560', 'current' => 0, 'd30' => 2800000, 'd60' => 0, 'd90' => 0],
                ['name' => 'Toko Elektronik Jaya',    'invoice' => '#0498', 'current' => 0, 'd30' => 0, 'd60' => 6100000, 'd90' => 0],
                ['name' => 'CV Bangun Perkasa',       'invoice' => '#0421', 'current' => 0, 'd30' => 0, 'd60' => 0, 'd90' => 3400000],
            ];

            $defaultApRows = [
                ['name' => 'Toko Bangunan Sentosa',   'invoice' => '#B-0112', 'current' => 12500000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'CV Kertas Nusantara',     'invoice' => '#B-0119', 'current' => 3200000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'PLN — Listrik Kantor',    'invoice' => '#B-0125', 'current' => 0, 'd30' => 4100000, 'd60' => 0, 'd90' => 0],
                ['name' => 'Distributor Kain Batik',  'invoice' => '#B-0103', 'current' => 0, 'd30' => 21400000, 'd60' => 0, 'd90' => 0],
            ];

            $arRows = session()->has('aging_ar') ? session('aging_ar') : $defaultArRows;
            $apRows = session()->has('aging_ap') ? session('aging_ap') : $defaultApRows;

            if (request()->filled('q')) {
                $q = strtolower(request('q'));

                $arRows = array_filter($arRows, function ($row) use ($q) {
                    return str_contains(strtolower($row['name']), $q)
                        || str_contains(strtolower($row['invoice']), $q);
                });
                $arRows = array_values($arRows);

                $apRows = array_filter($apRows, function ($row) use ($q) {
                    return str_contains(strtolower($row['name']), $q)
                        || str_contains(strtolower($row['invoice']), $q);
                });
                $apRows = array_values($apRows);
            }

            if (request()->ajax()) {
                return view('aging.index', compact('user', 'company', 'arRows', 'apRows'))->render();
            }

            return view('aging.index', compact('user', 'company', 'arRows', 'apRows'));
        })->name('aging.index');

        Route::get('/aging/show/{index}', function ($index) {
            $user = Auth::user();
            $company = $user->company;

            $arRows = [
                ['name' => 'PT Andalas Maju Bersama', 'invoice' => '#0568', 'current' => 5750000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'Nusantara Logistik',      'invoice' => '#0571', 'current' => 18400000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'Bumi Retail Group',       'invoice' => '#0552', 'current' => 0, 'd30' => 9200000, 'd60' => 0, 'd90' => 0],
                ['name' => 'Kopi Kenangan Senja',     'invoice' => '#0560', 'current' => 0, 'd30' => 2800000, 'd60' => 0, 'd90' => 0],
                ['name' => 'Toko Elektronik Jaya',    'invoice' => '#0498', 'current' => 0, 'd30' => 0, 'd60' => 6100000, 'd90' => 0],
                ['name' => 'CV Bangun Perkasa',       'invoice' => '#0421', 'current' => 0, 'd30' => 0, 'd60' => 0, 'd90' => 3400000],
            ];

            $apRows = [
                ['name' => 'Toko Bangunan Sentosa',   'invoice' => '#B-0112', 'current' => 12500000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'CV Kertas Nusantara',     'invoice' => '#B-0119', 'current' => 3200000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'PLN — Listrik Kantor',    'invoice' => '#B-0125', 'current' => 0, 'd30' => 4100000, 'd60' => 0, 'd90' => 0],
                ['name' => 'Distributor Kain Batik',  'invoice' => '#B-0103', 'current' => 0, 'd30' => 21400000, 'd60' => 0, 'd90' => 0],
            ];

            $type = request('type', 'ar');
            $data = $type === 'ar' ? $arRows : $apRows;

            if (!isset($data[$index])) {
                abort(404, 'Data tidak ditemukan');
            }

            $row = $data[$index];

            return view('aging.show', compact('user', 'company', 'row', 'index', 'type'));
        })->name('aging.show');

        Route::delete('/aging/delete/{index}', function ($index) {
            return redirect()->route('aging.index')->with('success', 'Data berhasil dihapus!');
        })->name('aging.destroy');

        Route::get('/aging/export-pdf', function () {
            $arRows = [
                ['name' => 'PT Andalas Maju Bersama', 'invoice' => '#0568', 'current' => 5750000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'Nusantara Logistik',      'invoice' => '#0571', 'current' => 18400000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'Bumi Retail Group',       'invoice' => '#0552', 'current' => 0, 'd30' => 9200000, 'd60' => 0, 'd90' => 0],
                ['name' => 'Kopi Kenangan Senja',     'invoice' => '#0560', 'current' => 0, 'd30' => 2800000, 'd60' => 0, 'd90' => 0],
                ['name' => 'Toko Elektronik Jaya',    'invoice' => '#0498', 'current' => 0, 'd30' => 0, 'd60' => 6100000, 'd90' => 0],
                ['name' => 'CV Bangun Perkasa',       'invoice' => '#0421', 'current' => 0, 'd30' => 0, 'd60' => 0, 'd90' => 3400000],
            ];

            $apRows = [
                ['name' => 'Toko Bangunan Sentosa',   'invoice' => '#B-0112', 'current' => 12500000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'CV Kertas Nusantara',     'invoice' => '#B-0119', 'current' => 3200000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
                ['name' => 'PLN — Listrik Kantor',    'invoice' => '#B-0125', 'current' => 0, 'd30' => 4100000, 'd60' => 0, 'd90' => 0],
                ['name' => 'Distributor Kain Batik',  'invoice' => '#B-0103', 'current' => 0, 'd30' => 21400000, 'd60' => 0, 'd90' => 0],
            ];

            $type = request('type', 'ar');
            $data = $type === 'ar' ? $arRows : $apRows;
            $title = $type === 'ar' ? 'Piutang (AR)' : 'Utang (AP)';

            return view('aging.export', compact('data', 'title', 'type'));
        })->name('aging.export-pdf');

        Route::get('/aging/export-excel', function () {
            return redirect()->route('aging.index')->with('success', 'File Excel berhasil diekspor!');
        })->name('aging.export-excel');
    });

    // ===== PEMBELIAN & BIAYA =====
    Route::get('/expenses', function () {
        $user = Auth::user();
        $company = $user->company;

        $defaultExpenses = [
            ['desc' => 'Beli kain mori 50 meter', 'kategori' => 'Bahan Baku', 'date' => '2026-07-01', 'status' => 'lunas', 'amount' => 2500000],
            ['desc' => 'Ongkir bahan dari Solo',   'kategori' => 'Transportasi', 'date' => '2026-07-03', 'status' => 'lunas', 'amount' => 350000],
            ['desc' => 'Tagihan listrik workshop', 'kategori' => 'Utilitas', 'date' => '2026-07-06', 'status' => 'pending', 'amount' => 820000],
        ];

        $expenses = session()->has('expenses') ? session('expenses') : $defaultExpenses;

        if (request()->filled('q')) {
            $q = strtolower(request('q'));
            $expenses = array_filter($expenses, function ($e) use ($q) {
                return str_contains(strtolower($e['desc']), $q)
                    || str_contains(strtolower($e['kategori']), $q);
            });
            $expenses = array_values($expenses);
        }

        if (request()->ajax()) {
            return view('expenses.index', compact('user', 'company', 'expenses'))->render();
        }

        return view('expenses.index', compact('user', 'company', 'expenses'));
    })->name('expenses.index');

    Route::get('/expenses/create', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('expenses.create', compact('user', 'company'));
    })->name('expenses.create');

    Route::post('/expenses', function () {
        $description = request('description');
        $category_id = request('category_id');
        $date = request('date');
        $amount = request('amount');
        $status = request('status');
        $notes = request('notes');

        $categories = [
            1 => 'Bahan Baku',
            2 => 'Transportasi',
            3 => 'Utilitas',
            4 => 'Produksi',
            5 => 'Marketing',
            6 => 'Operasional',
        ];

        $expenses = session('expenses', []);
        $newExpense = [
            'desc' => $description,
            'kategori' => $categories[$category_id] ?? 'Lainnya',
            'date' => $date,
            'status' => $status,
            'amount' => (int) $amount,
            'notes' => $notes ?? '',
        ];

        array_unshift($expenses, $newExpense);
        session(['expenses' => $expenses]);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dicatat!');
    })->name('expenses.store');

    Route::get('/expenses/show/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $expenses = session('expenses', []);

        if (!isset($expenses[$index])) {
            abort(404, 'Pengeluaran tidak ditemukan');
        }

        $expense = $expenses[$index];
        return view('expenses.show', compact('user', 'company', 'expense', 'index'));
    })->name('expenses.show');

    Route::get('/expenses/edit/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $expenses = session('expenses', []);

        if (!isset($expenses[$index])) {
            abort(404, 'Pengeluaran tidak ditemukan');
        }

        $expense = $expenses[$index];
        return view('expenses.edit', compact('user', 'company', 'expense', 'index'));
    })->name('expenses.edit');

    Route::put('/expenses/update/{index}', function ($index) {
        $expenses = session('expenses', []);

        if (!isset($expenses[$index])) {
            abort(404, 'Pengeluaran tidak ditemukan');
        }

        $expenses[$index]['desc'] = request('desc', $expenses[$index]['desc']);
        $expenses[$index]['kategori'] = request('kategori', $expenses[$index]['kategori']);
        $expenses[$index]['date'] = request('date', $expenses[$index]['date']);
        $expenses[$index]['status'] = request('status', $expenses[$index]['status']);
        $expenses[$index]['amount'] = request('amount', $expenses[$index]['amount']);
        $expenses[$index]['notes'] = request('notes', $expenses[$index]['notes'] ?? '');

        session(['expenses' => $expenses]);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diupdate!');
    })->name('expenses.update');

    Route::delete('/expenses/delete/{index}', function ($index) {
        $expenses = session('expenses', []);

        if (isset($expenses[$index])) {
            unset($expenses[$index]);
        }

        session(['expenses' => array_values($expenses)]);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus!');
    })->name('expenses.destroy');

    // ===== KATEGORI BIAYA =====
Route::get('/expense-categories', function () {
    $user = Auth::user();
    $company = $user->company;

    $query = \App\Models\ExpenseCategory::where('company_id', $company->id);

    if (request()->filled('q')) {
        $q = strtolower(request('q'));
        $query->where(function ($sub) use ($q) {
            $sub->whereRaw('LOWER(name) LIKE ?', ["%{$q}%"])
                ->orWhereRaw('LOWER(desc) LIKE ?', ["%{$q}%"]);
        });
    }

    $categoriesRaw = $query->orderBy('name')->get();

    // Hitung count & total transaksi per kategori dari data expenses (masih session)
    $expenses = session('expenses', []);
    $categories = $categoriesRaw->map(function ($cat) use ($expenses) {
        $matching = array_filter($expenses, fn ($e) => ($e['kategori'] ?? '') === $cat->name);
        return [
            'id'    => $cat->id,
            'name'  => $cat->name,
            'desc'  => $cat->desc,
            'count' => count($matching),
            'total' => array_sum(array_column($matching, 'amount')),
        ];
    })->values();

    if (request()->ajax()) {
        return view('expense-categories.index', compact('user', 'company', 'categories'))->render();
    }

    return view('expense-categories.index', compact('user', 'company', 'categories'));
})->name('expense-categories.index');

Route::get('/expense-categories/create', function () {
    $user = Auth::user();
    $company = $user->company;
    return view('expense-categories.create', compact('user', 'company'));
})->name('expense-categories.create');

Route::post('/expense-categories', function () {
    $user = Auth::user();
    $company = $user->company;

    request()->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    \App\Models\ExpenseCategory::create([
        'company_id' => $company->id,
        'name'       => request('name'),
        'desc'       => request('description'),
    ]);

    return redirect()->route('expense-categories.index')->with('success', 'Kategori berhasil dibuat!');
})->name('expense-categories.store');

Route::get('/expense-categories/show/{category}', function (\App\Models\ExpenseCategory $category) {
    $user = Auth::user();
    $company = $user->company;

    abort_unless($category->company_id === $company->id, 404, 'Kategori tidak ditemukan');

    $expenses = session('expenses', []);
    $matching = array_filter($expenses, fn ($e) => ($e['kategori'] ?? '') === $category->name);

    $categoryData = [
        'id'    => $category->id,
        'name'  => $category->name,
        'desc'  => $category->desc,
        'count' => count($matching),
        'total' => array_sum(array_column($matching, 'amount')),
    ];

    return view('expense-categories.show', compact('user', 'company', 'categoryData'));
})->name('expense-categories.show');

Route::get('/expense-categories/edit/{category}', function (\App\Models\ExpenseCategory $category) {
    $user = Auth::user();
    $company = $user->company;

    abort_unless($category->company_id === $company->id, 404, 'Kategori tidak ditemukan');

    return view('expense-categories.edit', compact('user', 'company', 'category'));
})->name('expense-categories.edit');

Route::put('/expense-categories/update/{category}', function (\App\Models\ExpenseCategory $category) {
    $user = Auth::user();
    $company = $user->company;

    abort_unless($category->company_id === $company->id, 404, 'Kategori tidak ditemukan');

    request()->validate([
        'name' => 'required|string|max:255',
        'desc' => 'nullable|string',
    ]);

    $category->update([
        'name' => request('name'),
        'desc' => request('desc'),
    ]);

    return redirect()->route('expense-categories.index')->with('success', 'Kategori berhasil diupdate!');
})->name('expense-categories.update');

Route::delete('/expense-categories/delete/{category}', function (\App\Models\ExpenseCategory $category) {
    $user = Auth::user();
    $company = $user->company;

    abort_unless($category->company_id === $company->id, 404, 'Kategori tidak ditemukan');

    $category->delete();

    return redirect()->route('expense-categories.index')->with('success', 'Kategori berhasil dihapus!');
})->name('expense-categories.destroy');

    // ===== PERBANKAN =====
    Route::middleware(['feature:perbankan'])->group(function () {
        Route::get('/reconciliation', function () {
            $user = Auth::user();
            $company = $user->company;

            $defaultReconciliations = [
                ['desc' => 'Transfer masuk dari Nusantara Logistik', 'date' => '2026-07-02', 'bank' => 18400000, 'buku' => 18400000, 'status' => 'cocok'],
                ['desc' => 'Pembayaran listrik workshop',            'date' => '2026-07-06', 'bank' => 820000,    'buku' => 820000,    'status' => 'cocok'],
                ['desc' => 'Setoran tunai penjualan',                'date' => '2026-07-09', 'bank' => 1500000,   'buku' => 0,          'status' => 'belum'],
                ['desc' => 'Biaya admin bank',                       'date' => '2026-07-10', 'bank' => 25000,     'buku' => 0,          'status' => 'belum'],
            ];

            $reconciliations = session()->has('reconciliations') ? session('reconciliations') : $defaultReconciliations;

            if (request()->filled('q')) {
                $q = strtolower(request('q'));
                $reconciliations = array_filter($reconciliations, function ($r) use ($q) {
                    return str_contains(strtolower($r['desc']), $q);
                });
                $reconciliations = array_values($reconciliations);
            }

            if (request()->ajax()) {
                return view('reconciliation.index', compact('user', 'company', 'reconciliations'))->render();
            }

            return view('reconciliation.index', compact('user', 'company', 'reconciliations'));
        })->name('reconciliation.index');

        Route::get('/reconciliation/create', function () {
            $user = Auth::user();
            $company = $user->company;
            return view('reconciliation.create', compact('user', 'company'));
        })->name('reconciliation.create');

        Route::post('/reconciliation', function () {
            $account_id = request('account_id');
            $period = request('period');
            $reconciliation_date = request('reconciliation_date');
            $bank_balance = request('bank_balance');
            $book_balance = request('book_balance');
            $notes = request('notes');
            $status = request('status');

            $reconciliations = session('reconciliations', []);
            $newReconciliation = [
                'desc' => 'Rekonsiliasi ' . $period,
                'date' => $reconciliation_date,
                'bank' => (int) $bank_balance,
                'buku' => (int) $book_balance,
                'status' => $status,
                'notes' => $notes,
            ];

            array_unshift($reconciliations, $newReconciliation);
            session(['reconciliations' => $reconciliations]);

            return redirect()->route('reconciliation.index')->with('success', 'Rekonsiliasi berhasil ditambahkan!');
        })->name('reconciliation.store');

        Route::get('/reconciliation/show/{index}', function ($index) {
            $user = Auth::user();
            $company = $user->company;
            $reconciliations = session('reconciliations', []);

            if (!isset($reconciliations[$index])) {
                abort(404, 'Rekonsiliasi tidak ditemukan');
            }

            $reconciliation = $reconciliations[$index];
            return view('reconciliation.show', compact('user', 'company', 'reconciliation', 'index'));
        })->name('reconciliation.show');

        Route::get('/reconciliation/edit/{index}', function ($index) {
            $user = Auth::user();
            $company = $user->company;
            $reconciliations = session('reconciliations', []);

            if (!isset($reconciliations[$index])) {
                abort(404, 'Rekonsiliasi tidak ditemukan');
            }

            $reconciliation = $reconciliations[$index];
            return view('reconciliation.edit', compact('user', 'company', 'reconciliation', 'index'));
        })->name('reconciliation.edit');

        Route::put('/reconciliation/update/{index}', function ($index) {
            $reconciliations = session('reconciliations', []);

            if (!isset($reconciliations[$index])) {
                abort(404, 'Rekonsiliasi tidak ditemukan');
            }

            $reconciliations[$index]['desc']   = request('desc', $reconciliations[$index]['desc']);
            $reconciliations[$index]['date']   = request('date', $reconciliations[$index]['date']);
            $reconciliations[$index]['bank']   = request('bank', $reconciliations[$index]['bank']);
            $reconciliations[$index]['buku']   = request('buku', $reconciliations[$index]['buku']);
            $reconciliations[$index]['status'] = request('status', $reconciliations[$index]['status']);
            $reconciliations[$index]['notes']  = request('notes', $reconciliations[$index]['notes'] ?? '');

            session(['reconciliations' => $reconciliations]);

            return redirect()->route('reconciliation.index')->with('success', 'Rekonsiliasi berhasil diupdate!');
        })->name('reconciliation.update');

        Route::delete('/reconciliation/delete/{index}', function ($index) {
            $reconciliations = session('reconciliations', []);

            if (isset($reconciliations[$index])) {
                unset($reconciliations[$index]);
            }

            session(['reconciliations' => array_values($reconciliations)]);

            return redirect()->route('reconciliation.index')->with('success', 'Rekonsiliasi berhasil dihapus!');
        })->name('reconciliation.destroy');

        Route::get('/bank-mutations', function () {
            $user = Auth::user();
            $company = $user->company;

            $defaultMutations = [
                ['desc' => 'Transfer masuk - Nusantara Logistik',   'date' => '2026-07-02', 'type' => 'masuk',  'amount' => 18400000, 'saldo' => 24650000],
                ['desc' => 'Pembayaran listrik workshop',            'date' => '2026-07-06', 'type' => 'keluar', 'amount' => 820000,   'saldo' => 23830000],
                ['desc' => 'Setoran tunai penjualan',                'date' => '2026-07-09', 'type' => 'masuk',  'amount' => 1500000,  'saldo' => 25330000],
                ['desc' => 'Biaya admin bank',                       'date' => '2026-07-10', 'type' => 'keluar', 'amount' => 25000,    'saldo' => 25305000],
            ];

            $mutations = session()->has('bank_mutations') ? session('bank_mutations') : $defaultMutations;

            if (request()->filled('q')) {
                $q = strtolower(request('q'));
                $mutations = array_filter($mutations, function ($m) use ($q) {
                    return str_contains(strtolower($m['desc']), $q);
                });
                $mutations = array_values($mutations);
            }

            if (request()->ajax()) {
                return view('bank-mutations.index', compact('user', 'company', 'mutations'))->render();
            }

            return view('bank-mutations.index', compact('user', 'company', 'mutations'));
        })->name('bank-mutations.index');

        Route::get('/bank-mutations/create', function () {
            $user = Auth::user();
            $company = $user->company;
            return view('bank-mutations.create', compact('user', 'company'));
        })->name('bank-mutations.create');

        Route::post('/bank-mutations', function () {
            $account_id = request('account_id');
            $description = request('description');
            $date = request('date');
            $amount = request('amount');
            $balance = request('balance');
            $category = request('category');
            $notes = request('notes');
            $type = request('type', 'masuk');

            $mutations = session('bank_mutations', []);
            $newMutation = [
                'desc' => $description,
                'date' => $date,
                'type' => $type,
                'amount' => (int) $amount,
                'saldo' => (int) $balance,
                'category' => $category,
                'notes' => $notes,
            ];

            array_unshift($mutations, $newMutation);
            session(['bank_mutations' => $mutations]);

            return redirect()->route('bank-mutations.index')->with('success', 'Mutasi berhasil ditambahkan!');
        })->name('bank-mutations.store');

        Route::get('/bank-mutations/show/{index}', function ($index) {
            $user = Auth::user();
            $company = $user->company;
            $mutations = session('bank_mutations', []);

            if (!isset($mutations[$index])) {
                abort(404, 'Mutasi tidak ditemukan');
            }

            $mutation = $mutations[$index];
            return view('bank-mutations.show', compact('user', 'company', 'mutation', 'index'));
        })->name('bank-mutations.show');

        Route::get('/bank-mutations/edit/{index}', function ($index) {
            $user = Auth::user();
            $company = $user->company;
            $mutations = session('bank_mutations', []);

            if (!isset($mutations[$index])) {
                abort(404, 'Mutasi tidak ditemukan');
            }

            $mutation = $mutations[$index];
            return view('bank-mutations.edit', compact('user', 'company', 'mutation', 'index'));
        })->name('bank-mutations.edit');

        Route::put('/bank-mutations/update/{index}', function ($index) {
            $mutations = session('bank_mutations', []);

            if (!isset($mutations[$index])) {
                abort(404, 'Mutasi tidak ditemukan');
            }

            $mutations[$index]['desc']     = request('desc', $mutations[$index]['desc']);
            $mutations[$index]['date']     = request('date', $mutations[$index]['date']);
            $mutations[$index]['type']     = request('type', $mutations[$index]['type']);
            $mutations[$index]['amount']   = request('amount', $mutations[$index]['amount']);
            $mutations[$index]['saldo']    = request('saldo', $mutations[$index]['saldo']);
            $mutations[$index]['category'] = request('category', $mutations[$index]['category'] ?? '');
            $mutations[$index]['notes']    = request('notes', $mutations[$index]['notes'] ?? '');

            session(['bank_mutations' => $mutations]);

            return redirect()->route('bank-mutations.index')->with('success', 'Mutasi berhasil diupdate!');
        })->name('bank-mutations.update');

        Route::delete('/bank-mutations/delete/{index}', function ($index) {
            $mutations = session('bank_mutations', []);

            if (isset($mutations[$index])) {
                unset($mutations[$index]);
            }

            session(['bank_mutations' => array_values($mutations)]);

            return redirect()->route('bank-mutations.index')->with('success', 'Mutasi berhasil dihapus!');
        })->name('bank-mutations.destroy');
    });

    // ===== LAPORAN =====
    Route::middleware(['feature:laporan'])->group(function () {
        Route::resource('laba-rugi', LabaRugiController::class);
        Route::resource('neraca', NeracaController::class);
        Route::resource('cash-flow', CashFlowController::class);
        Route::resource('ledger', LedgerController::class);
        Route::resource('coa', ChartOfAccountController::class)->except(['show']);
    });

    // ===== INVENTARIS =====
    Route::middleware(['feature:inventaris'])->group(function () {
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
        Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
        Route::get('/inventory/{item}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
        Route::get('/inventory/{item}', [InventoryController::class, 'show'])->name('inventory.show');
        Route::put('/inventory/{item}', [InventoryController::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{item}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

        Route::get('/cogs', [CogsController::class, 'index'])->name('cogs.index');
        Route::get('/cogs/create', [CogsController::class, 'create'])->name('cogs.create');
        Route::post('/cogs', [CogsController::class, 'store'])->name('cogs.store');
        Route::get('/cogs/{entry}', [CogsController::class, 'show'])->name('cogs.show');
        Route::get('/cogs/{entry}/edit', [CogsController::class, 'edit'])->name('cogs.edit');
        Route::put('/cogs/{entry}', [CogsController::class, 'update'])->name('cogs.update');
        Route::delete('/cogs/{entry}', [CogsController::class, 'destroy'])->name('cogs.destroy');
    });

    // ===== PAYROLL =====
    Route::middleware(['feature:payroll'])->group(function () {
        Route::get('/payroll', function () {
            $user = Auth::user();
            $company = $user->company;

            $defaultPayrolls = [
                ['employee' => 'Budi Santoso',      'position' => 'Pengrajin Batik', 'period' => 'Juli 2026', 'basic_salary' => 4500000, 'allowance' => 500000, 'deduction' => 150000, 'total' => 4850000, 'status' => 'paid'],
                ['employee' => 'Siti Rahayu',        'position' => 'Desainer',        'period' => 'Juli 2026', 'basic_salary' => 5200000, 'allowance' => 750000, 'deduction' => 200000, 'total' => 5750000, 'status' => 'paid'],
                ['employee' => 'Agus Wijaya',        'position' => 'Marketing',       'period' => 'Juli 2026', 'basic_salary' => 4800000, 'allowance' => 600000, 'deduction' => 180000, 'total' => 5220000, 'status' => 'pending'],
                ['employee' => 'Dewi Lestari',       'position' => 'Admin',           'period' => 'Juli 2026', 'basic_salary' => 4000000, 'allowance' => 400000, 'deduction' => 120000, 'total' => 4280000, 'status' => 'pending'],
            ];

            $payrolls = session()->has('payrolls') ? session('payrolls') : $defaultPayrolls;

            if (request()->filled('q')) {
                $q = strtolower(request('q'));
                $payrolls = array_filter($payrolls, function ($p) use ($q) {
                    return str_contains(strtolower($p['employee']), $q)
                        || str_contains(strtolower($p['position']), $q)
                        || str_contains(strtolower($p['period']), $q);
                });
                $payrolls = array_values($payrolls);
            }

            if (request()->ajax()) {
                return view('payroll.index', compact('user', 'company', 'payrolls'))->render();
            }

            return view('payroll.index', compact('user', 'company', 'payrolls'));
        })->name('payroll.index');

        Route::get('/payroll/create', function () {
    $user = Auth::user();
    $company = $user->company;

    $employees = \App\Models\User::where('company_id', $company->id)
        ->where('access_level', \App\Enums\AccessLevel::User)
        ->with('employeeProfile')
        ->orderBy('name')
        ->get();

    return view('payroll.create', compact('user', 'company', 'employees'));
})->name('payroll.create');

    Route::post('/payroll', function () {
    $employee_id = request('employee_id');
    $position = request('position');   // ← TAMBAHKAN INI
    $period = request('period');
    $basic_salary = request('basic_salary');
    $allowance = request('allowance') ?? 0;
    $deduction = request('deduction') ?? 0;
    $status = request('status');
    $notes = request('notes');

    $employee = \App\Models\User::find($employee_id);

    $total = (int) $basic_salary + (int) $allowance - (int) $deduction;

    $payrolls = session('payrolls', []);
    $newPayroll = [
        'employee' => $employee->name ?? 'Unknown',
        'position' => $position ?: '-',   // ← AMBIL DARI INPUT FORM
        'period' => $period,
        'basic_salary' => (int) $basic_salary,
        'allowance' => (int) $allowance,
        'deduction' => (int) $deduction,
        'total' => $total,
        'status' => $status,
        'notes' => $notes,
    ];

    array_unshift($payrolls, $newPayroll);
    session(['payrolls' => $payrolls]);

    return redirect()->route('payroll.index')->with('success', 'Payroll berhasil dibuat!');
})->name('payroll.store');

        Route::get('/payroll/show/{index}', function ($index) {
    $user = Auth::user();
    $company = $user->company;
    $payrolls = session('payrolls', []);

    if (!isset($payrolls[$index])) {
        abort(404, 'Payroll tidak ditemukan');
    }

    $payroll = $payrolls[$index];
    return view('payroll.show', compact('user', 'company', 'payroll', 'index'));
})->name('payroll.show');

        Route::get('/payroll/edit/{index}', function ($index) {
            $user = Auth::user();
            $company = $user->company;
            $payrolls = session('payrolls', []);

            if (!isset($payrolls[$index])) {
                abort(404, 'Payroll tidak ditemukan');
            }

            $payroll = $payrolls[$index];
            return view('payroll.edit', compact('user', 'company', 'payroll', 'index'));
        })->name('payroll.edit');

        Route::put('/payroll/update/{index}', function ($index) {
            $payrolls = session('payrolls', []);

            if (!isset($payrolls[$index])) {
                abort(404, 'Payroll tidak ditemukan');
            }

            $basic_salary = request('basic_salary', $payrolls[$index]['basic_salary']);
            $allowance = request('allowance', $payrolls[$index]['allowance']);
            $deduction = request('deduction', $payrolls[$index]['deduction']);

            $payrolls[$index]['employee']     = request('employee', $payrolls[$index]['employee']);
            $payrolls[$index]['position']     = request('position', $payrolls[$index]['position']);
            $payrolls[$index]['period']       = request('period', $payrolls[$index]['period']);
            $payrolls[$index]['basic_salary'] = (int) $basic_salary;
            $payrolls[$index]['allowance']    = (int) $allowance;
            $payrolls[$index]['deduction']    = (int) $deduction;
            $payrolls[$index]['total']        = (int) $basic_salary + (int) $allowance - (int) $deduction;
            $payrolls[$index]['status']       = request('status', $payrolls[$index]['status']);
            $payrolls[$index]['notes']        = request('notes', $payrolls[$index]['notes'] ?? '');

            session(['payrolls' => $payrolls]);

            return redirect()->route('payroll.index')->with('success', 'Payroll berhasil diupdate!');
        })->name('payroll.update');

        Route::delete('/payroll/delete/{index}', function ($index) {
            $payrolls = session('payrolls', []);

            if (isset($payrolls[$index])) {
                unset($payrolls[$index]);
            }

            session(['payrolls' => array_values($payrolls)]);

            return redirect()->route('payroll.index')->with('success', 'Payroll berhasil dihapus!');
        })->name('payroll.destroy');

        // ===== EMPLOYEES / DATA KARYAWAN =====
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

        Route::get('/employees/create', function () {
            return redirect()->route('staff.invitations.index')
                ->with('info', 'Karyawan baru bergabung otomatis lewat kode undangan. Buat undangan di sini.');
        })->name('employees.create');

        Route::get('/employees/show/{index}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/employees/edit/{index}', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/employees/update/{index}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employees/delete/{index}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    });

        // ===== PAJAK - PPH =====
    Route::middleware(['feature:pajak'])->group(function () {
        Route::get('/taxes/pph', [\App\Http\Controllers\TaxPphController::class, 'index'])->name('taxes.pph');
        Route::get('/taxes/pph/create', [\App\Http\Controllers\TaxPphController::class, 'create'])->name('taxes.pph.create');
        Route::post('/taxes/pph', [\App\Http\Controllers\TaxPphController::class, 'store'])->name('taxes.pph.store');
        Route::get('/taxes/pph/show/{index}', [\App\Http\Controllers\TaxPphController::class, 'show'])->name('taxes.pph.show');
        Route::get('/taxes/pph/edit/{index}', [\App\Http\Controllers\TaxPphController::class, 'edit'])->name('taxes.pph.edit');
        Route::put('/taxes/pph/update/{index}', [\App\Http\Controllers\TaxPphController::class, 'update'])->name('taxes.pph.update');
        Route::delete('/taxes/pph/delete/{index}', [\App\Http\Controllers\TaxPphController::class, 'destroy'])->name('taxes.pph.destroy');
        Route::get('/taxes/pph/pay/{index}', [\App\Http\Controllers\TaxPphController::class, 'pay'])->name('taxes.pph.pay');

        // ===== PAJAK - PPN =====
        Route::get('/taxes/ppn', [\App\Http\Controllers\TaxPpnController::class, 'index'])->name('taxes.ppn');
        Route::get('/taxes/ppn/create', [\App\Http\Controllers\TaxPpnController::class, 'create'])->name('taxes.ppn.create');
        Route::post('/taxes/ppn', [\App\Http\Controllers\TaxPpnController::class, 'store'])->name('taxes.ppn.store');
        Route::get('/taxes/ppn/show/{index}', [\App\Http\Controllers\TaxPpnController::class, 'show'])->name('taxes.ppn.show');
        Route::get('/taxes/ppn/edit/{index}', [\App\Http\Controllers\TaxPpnController::class, 'edit'])->name('taxes.ppn.edit');
        Route::put('/taxes/ppn/update/{index}', [\App\Http\Controllers\TaxPpnController::class, 'update'])->name('taxes.ppn.update');
        Route::delete('/taxes/ppn/delete/{index}', [\App\Http\Controllers\TaxPpnController::class, 'destroy'])->name('taxes.ppn.destroy');
        Route::get('/taxes/ppn/pay/{index}', [\App\Http\Controllers\TaxPpnController::class, 'pay'])->name('taxes.ppn.pay');

        // ===== TAX CALENDAR =====
        Route::get('/tax-calendar', [\App\Http\Controllers\TaxCalendarController::class, 'index'])->name('tax-calendar.index');
        Route::get('/tax-calendar/create', [\App\Http\Controllers\TaxCalendarController::class, 'create'])->name('tax-calendar.create');
        Route::post('/tax-calendar', [\App\Http\Controllers\TaxCalendarController::class, 'store'])->name('tax-calendar.store');
        Route::get('/tax-calendar/show/{index}', [\App\Http\Controllers\TaxCalendarController::class, 'show'])->name('tax-calendar.show');
        Route::get('/tax-calendar/edit/{index}', [\App\Http\Controllers\TaxCalendarController::class, 'edit'])->name('tax-calendar.edit');
        Route::put('/tax-calendar/update/{index}', [\App\Http\Controllers\TaxCalendarController::class, 'update'])->name('tax-calendar.update');
        Route::delete('/tax-calendar/delete/{index}', [\App\Http\Controllers\TaxCalendarController::class, 'destroy'])->name('tax-calendar.destroy');
    });

    // ===== BUDGETING =====
    Route::middleware(['feature:anggaran'])->group(function () {
        Route::get('/budgets', function () {
            $user = Auth::user();
            $company = $user->company;

            $defaultBudgets = [
                ['category' => 'Pendapatan', 'period' => '2026', 'target' => 850000000, 'actual' => 785000000, 'progress' => 92, 'status' => 'on_track'],
                ['category' => 'Bahan Baku', 'period' => '2026', 'target' => 120000000, 'actual' => 98000000, 'progress' => 82, 'status' => 'on_track'],
                ['category' => 'Biaya Produksi', 'period' => '2026', 'target' => 95000000, 'actual' => 102000000, 'progress' => 107, 'status' => 'over_budget'],
                ['category' => 'Marketing', 'period' => '2026', 'target' => 45000000, 'actual' => 38500000, 'progress' => 86, 'status' => 'on_track'],
                ['category' => 'Operasional', 'period' => '2026', 'target' => 65000000, 'actual' => 72000000, 'progress' => 111, 'status' => 'over_budget'],
                ['category' => 'Utilitas', 'period' => '2026', 'target' => 28000000, 'actual' => 26500000, 'progress' => 95, 'status' => 'on_track'],
                ['category' => 'Pengembangan', 'period' => '2026', 'target' => 35000000, 'actual' => 21000000, 'progress' => 60, 'status' => 'under_budget'],
            ];

            $budgets = session()->has('budgets') ? session('budgets') : $defaultBudgets;

            if (request()->filled('q')) {
                $q = strtolower(request('q'));
                $budgets = array_filter($budgets, function ($b) use ($q) {
                    return str_contains(strtolower($b['category']), $q)
                        || str_contains(strtolower($b['period']), $q);
                });
                $budgets = array_values($budgets);
            }

            if (request()->ajax()) {
                return view('budgets.index', compact('user', 'company', 'budgets'))->render();
            }

            return view('budgets.index', compact('user', 'company', 'budgets'));
        })->name('budgets.index');

        Route::get('/budgets/create', function () {
            $user = Auth::user();
            $company = $user->company;
            return view('budgets.create', compact('user', 'company'));
        })->name('budgets.create');

        Route::post('/budgets', function () {
            $category = request('category');
            $period = request('period');
            $target = request('target');
            $actual = request('actual') ?? 0;
            $status = request('status');
            $notes = request('notes');

            $progress = $target > 0 ? round(($actual / $target) * 100) : 0;

            $budgets = session('budgets', []);
            $newBudget = [
                'category' => $category,
                'period' => $period,
                'target' => (int) $target,
                'actual' => (int) $actual,
                'progress' => $progress,
                'status' => $status,
                'notes' => $notes,
            ];

            array_unshift($budgets, $newBudget);
            session(['budgets' => $budgets]);

            return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil dibuat!');
        })->name('budgets.store');

        Route::get('/budgets/show/{index}', function ($index) {
            $user = Auth::user();
            $company = $user->company;
            $budgets = session('budgets', []);

            if (!isset($budgets[$index])) {
                abort(404, 'Anggaran tidak ditemukan');
            }

            $budget = $budgets[$index];
            return view('budgets.show', compact('user', 'company', 'budget', 'index'));
        })->name('budgets.show');

        Route::get('/budgets/edit/{index}', function ($index) {
            $user = Auth::user();
            $company = $user->company;
            $budgets = session('budgets', []);

            if (!isset($budgets[$index])) {
                abort(404, 'Anggaran tidak ditemukan');
            }

            $budget = $budgets[$index];
            return view('budgets.edit', compact('user', 'company', 'budget', 'index'));
        })->name('budgets.edit');

        Route::put('/budgets/update/{index}', function ($index) {
            $budgets = session('budgets', []);

            if (!isset($budgets[$index])) {
                abort(404, 'Anggaran tidak ditemukan');
            }

            $target = request('target', $budgets[$index]['target']);
            $actual = request('actual', $budgets[$index]['actual']);
            $progress = $target > 0 ? round(($actual / $target) * 100) : 0;

            $budgets[$index]['category'] = request('category', $budgets[$index]['category']);
            $budgets[$index]['period']   = request('period', $budgets[$index]['period']);
            $budgets[$index]['target']   = (int) $target;
            $budgets[$index]['actual']   = (int) $actual;
            $budgets[$index]['progress'] = $progress;
            $budgets[$index]['status']   = request('status', $budgets[$index]['status']);
            $budgets[$index]['notes']    = request('notes', $budgets[$index]['notes'] ?? '');

            session(['budgets' => $budgets]);

            return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil diupdate!');
        })->name('budgets.update');

        Route::delete('/budgets/delete/{index}', function ($index) {
            $budgets = session('budgets', []);

            if (isset($budgets[$index])) {
                unset($budgets[$index]);
            }

            session(['budgets' => array_values($budgets)]);

            return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil dihapus!');
        })->name('budgets.destroy');

        Route::get('/budgets/export', function () {
            $budgets = session('budgets', [
                ['category' => 'Pendapatan', 'period' => '2026', 'target' => 850000000, 'actual' => 785000000, 'progress' => 92, 'status' => 'on_track'],
                ['category' => 'Bahan Baku', 'period' => '2026', 'target' => 120000000, 'actual' => 98000000, 'progress' => 82, 'status' => 'on_track'],
                ['category' => 'Biaya Produksi', 'period' => '2026', 'target' => 95000000, 'actual' => 102000000, 'progress' => 107, 'status' => 'over_budget'],
                ['category' => 'Marketing', 'period' => '2026', 'target' => 45000000, 'actual' => 38500000, 'progress' => 86, 'status' => 'on_track'],
                ['category' => 'Operasional', 'period' => '2026', 'target' => 65000000, 'actual' => 72000000, 'progress' => 111, 'status' => 'over_budget'],
                ['category' => 'Utilitas', 'period' => '2026', 'target' => 28000000, 'actual' => 26500000, 'progress' => 95, 'status' => 'on_track'],
                ['category' => 'Pengembangan', 'period' => '2026', 'target' => 35000000, 'actual' => 21000000, 'progress' => 60, 'status' => 'under_budget'],
            ]);

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
                    th {
                        background: #6C5CE7;
                        color: #ffffff;
                        padding: 10px 12px;
                        text-align: left;
                        font-weight: bold;
                        border: 1px solid #5A4BD1;
                    }
                    td {
                        padding: 8px 12px;
                        border: 1px solid #ddd;
                        text-align: left;
                    }
                    .text-right { text-align: right; }
                    .text-center { text-align: center; }
                    .total-row { background: #f0f0f0; font-weight: bold; }
                    .status-on-track { color: #34B583; }
                    .status-over-budget { color: #E85A5A; }
                    .status-under-budget { color: #F0A83C; }
                    .title {
                        font-size: 18px;
                        font-weight: bold;
                        margin-bottom: 10px;
                        color: #1a1a2e;
                    }
                    .subtitle {
                        font-size: 12px;
                        color: #666;
                        margin-bottom: 20px;
                    }
                    .footer {
                        margin-top: 20px;
                        font-size: 11px;
                        color: #999;
                        text-align: center;
                    }
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
                $target = $row['target'];
                $actual = $row['actual'];
                $selisih = $actual - $target;
                $selisihText = ($selisih >= 0 ? '+' : '') . number_format($selisih, 0, ',', '.');
                $selisihColor = $selisih >= 0 ? '#34B583' : '#E85A5A';
                $progress = $row['progress'];
                $status = $row['status'];
                $statusLabel = [
                    'on_track' => 'On Track',
                    'over_budget' => 'Over Budget',
                    'under_budget' => 'Under Budget'
                ][$status] ?? $status;
                $statusClass = 'status-' . $status;

                $totalTarget += $target;
                $totalActual += $actual;

                $html .= '
                        <tr>
                            <td>' . $no++ . '</td>
                            <td><strong>' . $row['category'] . '</strong></td>
                            <td>' . $row['period'] . '</td>
                            <td style="text-align:right">' . $currencySymbol . ' ' . number_format($target, 0, ',', '.') . '</td>
                            <td style="text-align:right">' . $currencySymbol . ' ' . number_format($actual, 0, ',', '.') . '</td>
                            <td style="text-align:right; color:' . $selisihColor . '">' . $selisihText . '</td>
                            <td style="text-align:center">
                                <strong>' . $progress . '%</strong>
                            </td>
                            <td class="' . $statusClass . '">' . $statusLabel . '</td>
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

                <div class="footer">
                    Laporan ini dihasilkan secara otomatis oleh Arvessa System
                </div>
            </body>
            </html>';

            $filename = 'Anggaran_Forecasting_' . date('Y-m-d') . '.xls';

            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        })->name('budgets.export');
    });

    // ===== PENGATURAN =====
    Route::get('/users', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('users.index', compact('user', 'company'));
    })->name('users.index');

    // Multi-User & Hak Akses (pakai TeamMemberController) - HANYA UNTUK PLAN GOLD
    Route::middleware(['feature:multi_user'])->group(function () {
        Route::resource('team-members', TeamMemberController::class);
    });

    // Profil Perusahaan (pakai CompanyController)
    Route::get('/company/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::patch('/company', [CompanyController::class, 'update'])->name('company.update');

    // Integrasi (pakai IntegrationController)
    Route::resource('integrations', IntegrationController::class);

    // Keamanan (pakai SecurityController)
    Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
    Route::put('/security/password', [SecurityController::class, 'updatePassword'])->name('security.password.update');
    Route::post('/security/two-factor/toggle', [SecurityController::class, 'toggleTwoFactor'])->name('security.two-factor.toggle');
    Route::delete('/security/sessions/{sessionId}', [SecurityController::class, 'revokeSession'])->name('security.sessions.revoke');
    Route::post('/security/sessions/revoke-others', [SecurityController::class, 'revokeOtherSessions'])->name('security.sessions.revoke-others');

    // Profile (pakai ProfileController)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // ===== PRICING & PAYMENT =====
    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing.index');
    Route::post('/pricing/select/{plan}', [PricingController::class, 'select'])->name('pricing.select');

    Route::get('/payment/checkout/{plan}', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/payment/checkout/{plan}', [PaymentController::class, 'process'])->name('payment.process');

}); // ← INI MENUTUP GRUP BESAR Route::middleware(['auth', 'onboarding.complete', 'access:staff'])

// ===== WEBHOOK MIDTRANS — di luar semua middleware auth =====
Route::post('/midtrans/notification', [PaymentController::class, 'notification'])->name('midtrans.notification');
// ================================================================
// ADMIN ROUTES (hanya admin)
// ================================================================
Route::middleware(['auth', 'access:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        $user = Auth::user();

        $stats = [
            'total_users'      => \App\Models\User::count(),
            'total_companies'  => \App\Models\Company::count(),
            'total_admins'     => \App\Models\User::where('access_level', 'admin')->count(),
            'recent_activity'  => \App\Models\ActivityLog::with('user')->orderByDesc('created_at')->limit(5)->get(),
        ];

        return view('admin.dashboard', compact('user', 'stats'));
    })->name('dashboard');

    Route::resource('users', UserManagementController::class)
        ->except(['show']);

    Route::get('/companies', [CompanyManagementController::class, 'index'])->name('companies.index');
    Route::get('/companies/{company}/edit', [CompanyManagementController::class, 'edit'])->name('companies.edit');
    Route::put('/companies/{company}', [CompanyManagementController::class, 'update'])->name('companies.update');

    Route::get('/stats', [SystemStatsController::class, 'index'])->name('stats.index');

    Route::controller(AdminNotificationController::class)->prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{id}/read', 'markAsRead')->name('read');
        Route::post('/read-all', 'markAllAsRead')->name('readAll');
    });

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.index');
    Route::delete('/activity-logs/{log}', [ActivityLogController::class, 'destroy'])->name('logs.destroy');
    Route::delete('/activity-logs', [ActivityLogController::class, 'destroyAll'])->name('logs.destroy-all');

    // ── Subscription Plans ──────────────────────────────────────
    Route::resource('subscription-plans', SubscriptionPlanController::class)
        ->except(['show']);

    Route::patch('/subscription-plans/{subscriptionPlan}/toggle', [SubscriptionPlanController::class, 'toggleActive'])
        ->name('subscription-plans.toggle');
    // ────────────────────────────────────────────────────────────

    Route::get('/settings', [SystemSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SystemSettingController::class, 'update'])->name('settings.update');

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    Route::get('/security', [AdminSecurityController::class, 'index'])->name('security.index');
    Route::put('/security/password', [AdminSecurityController::class, 'updatePassword'])->name('security.password.update');
    Route::post('/security/two-factor/toggle', [AdminSecurityController::class, 'toggleTwoFactor'])->name('security.two-factor.toggle');

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
    Route::put('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.status');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
});

// ================================================================
// STAFF ROUTES (hanya staff) - DENGAN ONBOARDING.COMPLETE
// ================================================================
Route::middleware(['auth', 'onboarding.complete', 'access:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $company = $user->company;
        $account = $company ? $company->accounts()->first() : null;
        $teamMembers = $company ? $company->users()->where('id', '!=', $user->id)->get() : collect();

        return view('staff.dashboard', compact('user', 'company', 'account'));
    })->name('dashboard');

    // ===== INVITATIONS =====
    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
});

// ================================================================
// USER ROUTES (hanya user biasa)
// ================================================================
Route::middleware(['auth', 'access:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');

    // Expenses
    Route::get('/expenses/create', [UserDashboardController::class, 'createExpense'])->name('expenses.create');
    Route::post('/expenses', [UserDashboardController::class, 'storeExpense'])->name('expenses.store');
    Route::get('/expenses', [UserDashboardController::class, 'expenseHistory'])->name('expenses.index');
    Route::get('/expenses/summary', [UserDashboardController::class, 'expenseSummary'])->name('expenses.summary');
});

Route::middleware(['auth', 'onboarding.complete', 'access:staff'])->prefix('staff')->name('staff.')->group(function () {
    // ... route dashboard & invitations yang udah ada, biarin aja ...

    // ===== APPROVAL PENGELUARAN =====
    Route::get('/expense-approvals', [StaffExpenseApprovalController::class, 'index'])->name('expense-approvals.index');
    Route::post('/expense-approvals/{submission}/approve', [StaffExpenseApprovalController::class, 'approve'])->name('expense-approvals.approve');
    Route::post('/expense-approvals/{submission}/reject', [StaffExpenseApprovalController::class, 'reject'])->name('expense-approvals.reject');
});

Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/tickets', [StaffTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [StaffTicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [StaffTicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [StaffTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [StaffTicketController::class, 'reply'])->name('tickets.reply');
});

Route::get('/riwayat', [ActivityHistoryController::class, 'index'])
    ->middleware('auth')
    ->name('history.index');