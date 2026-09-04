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
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\StaffExpenseApprovalController;
use App\Http\Controllers\StaffTicketController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\ActivityHistoryController;

// ===== MODUL YANG SUDAH DIKONVERSI KE DATABASE (bukan lagi session) =====
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReconciliationController;
use App\Http\Controllers\BankMutationController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ExpenseCategoryController;


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
        Route::post('/quotes/{quote}/convert-to-invoice', 'convertToInvoice')->name('quotes.convert-to-invoice');
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

        // ===== PAYABLES (sudah database, bukan session lagi) =====
        Route::resource('payables', PayableController::class);

        // ===== AGING ===== (belum dikonversi — sengaja masih dihitung dari data mentah/session,
        // karena ini data turunan dari Invoice + Payable, bukan tabel sendiri)
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

    // ===== PEMBELIAN & BIAYA (sudah database, bukan session lagi) =====
    Route::resource('expenses', ExpenseController::class);

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

        $expenses = \App\Models\Expense::where('company_id', $company->id)->get();
        $categories = $categoriesRaw->map(function ($cat) use ($expenses) {
            $matching = $expenses->where('expense_category_id', $cat->id);
            return [
                'id'    => $cat->id,
                'name'  => $cat->name,
                'desc'  => $cat->desc,
                'count' => $matching->count(),
                'total' => $matching->sum('amount'),
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

        $expenses = \App\Models\Expense::where('company_id', $company->id)
            ->where('expense_category_id', $category->id)
            ->get();

        $categoryData = [
            'id'    => $category->id,
            'name'  => $category->name,
            'desc'  => $category->desc,
            'count' => $expenses->count(),
            'total' => $expenses->sum('amount'),
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

    // ===== PERBANKAN (sudah database, bukan session lagi) =====
    Route::middleware(['feature:perbankan'])->group(function () {
        Route::resource('reconciliation', ReconciliationController::class);
        Route::resource('bank-mutations', BankMutationController::class);
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

    // ===== PAYROLL (sudah database, bukan session lagi) =====
    Route::middleware(['feature:payroll'])->group(function () {
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

        Route::resource('payroll', PayrollController::class)->except(['create']);

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

    // ===== PAJAK - PPH, PPN & TAX CALENDAR (sudah database, bukan session lagi) =====
    Route::middleware(['feature:pajak'])->group(function () {
        // --- PPh ---
        Route::get('/taxes/pph', [\App\Http\Controllers\TaxPphController::class, 'index'])->name('taxes.pph');
        Route::get('/taxes/pph/create', [\App\Http\Controllers\TaxPphController::class, 'create'])->name('taxes.pph.create');
        Route::post('/taxes/pph', [\App\Http\Controllers\TaxPphController::class, 'store'])->name('taxes.pph.store');
        Route::get('/taxes/pph/show/{index}', [\App\Http\Controllers\TaxPphController::class, 'show'])->name('taxes.pph.show');
        Route::get('/taxes/pph/edit/{index}', [\App\Http\Controllers\TaxPphController::class, 'edit'])->name('taxes.pph.edit');
        Route::put('/taxes/pph/update/{index}', [\App\Http\Controllers\TaxPphController::class, 'update'])->name('taxes.pph.update');
        Route::delete('/taxes/pph/delete/{index}', [\App\Http\Controllers\TaxPphController::class, 'destroy'])->name('taxes.pph.destroy');
        Route::get('/taxes/pph/pay/{index}', [\App\Http\Controllers\TaxPphController::class, 'pay'])->name('taxes.pph.pay');

        // --- PPN ---
        Route::get('/taxes/ppn', [\App\Http\Controllers\TaxPpnController::class, 'index'])->name('taxes.ppn');
        Route::get('/taxes/ppn/create', [\App\Http\Controllers\TaxPpnController::class, 'create'])->name('taxes.ppn.create');
        Route::post('/taxes/ppn', [\App\Http\Controllers\TaxPpnController::class, 'store'])->name('taxes.ppn.store');
        Route::get('/taxes/ppn/show/{index}', [\App\Http\Controllers\TaxPpnController::class, 'show'])->name('taxes.ppn.show');
        Route::get('/taxes/ppn/edit/{index}', [\App\Http\Controllers\TaxPpnController::class, 'edit'])->name('taxes.ppn.edit');
        Route::put('/taxes/ppn/update/{index}', [\App\Http\Controllers\TaxPpnController::class, 'update'])->name('taxes.ppn.update');
        Route::delete('/taxes/ppn/delete/{index}', [\App\Http\Controllers\TaxPpnController::class, 'destroy'])->name('taxes.ppn.destroy');
        Route::get('/taxes/ppn/pay/{index}', [\App\Http\Controllers\TaxPpnController::class, 'pay'])->name('taxes.ppn.pay');

        // --- Tax Calendar ---
        Route::get('/tax-calendar', [\App\Http\Controllers\TaxCalendarController::class, 'index'])->name('tax-calendar.index');
        Route::get('/tax-calendar/create', [\App\Http\Controllers\TaxCalendarController::class, 'create'])->name('tax-calendar.create');
        Route::post('/tax-calendar', [\App\Http\Controllers\TaxCalendarController::class, 'store'])->name('tax-calendar.store');
        Route::get('/tax-calendar/show/{index}', [\App\Http\Controllers\TaxCalendarController::class, 'show'])->name('tax-calendar.show');
        Route::get('/tax-calendar/edit/{index}', [\App\Http\Controllers\TaxCalendarController::class, 'edit'])->name('tax-calendar.edit');
        Route::put('/tax-calendar/update/{index}', [\App\Http\Controllers\TaxCalendarController::class, 'update'])->name('tax-calendar.update');
        Route::delete('/tax-calendar/delete/{index}', [\App\Http\Controllers\TaxCalendarController::class, 'destroy'])->name('tax-calendar.destroy');
    });

    // ===== BUDGETING (sudah database, bukan session lagi) =====
    Route::middleware(['feature:anggaran'])->group(function () {
        Route::get('/budgets/export', [BudgetController::class, 'export'])->name('budgets.export');
        Route::resource('budgets', BudgetController::class);
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

    // ===== APPROVAL PENGELUARAN =====
    Route::get('/expense-approvals', [StaffExpenseApprovalController::class, 'index'])->name('expense-approvals.index');
    Route::post('/expense-approvals/{submission}/approve', [StaffExpenseApprovalController::class, 'approve'])->name('expense-approvals.approve');
    Route::post('/expense-approvals/{submission}/reject', [StaffExpenseApprovalController::class, 'reject'])->name('expense-approvals.reject');
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

// ===== STAFF TICKETS (tanpa middleware auth, sesuai file asli) =====
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/tickets', [StaffTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [StaffTicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [StaffTicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [StaffTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [StaffTicketController::class, 'reply'])->name('tickets.reply');
});

// ===== RIWAYAT AKTIVITAS =====
Route::get('/riwayat', [ActivityHistoryController::class, 'index'])
    ->middleware('auth')
    ->name('history.index');

Route::resource(
    'expense-categories',
    ExpenseCategoryController::class
);