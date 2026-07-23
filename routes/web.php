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
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CogsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ReceivableController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\CompanyController;

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

// Dashboard & Protected routes (auth + onboarding complete)
Route::middleware(['auth', 'onboarding.complete'])->group(function () {

    // ===== DASHBOARD =====
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $company = $user->company;
        $account = $company ? $company->accounts()->first() : null;

        return view('dashboard', compact('user', 'company', 'account'));
    })->name('dashboard');

    // ===== NOTIFIKASI =====
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notifications.index');
        Route::post('/notifications/{id}/read', 'markAsRead')->name('notifications.read');
        Route::post('/notifications/read-all', 'markAllAsRead')->name('notifications.readAll');
    });

    // ===== INVOICES (PASTIKAN URUTAN BENAR) =====
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoices', 'index')->name('invoices.index');
        Route::get('/invoices/create', 'create')->name('invoices.create');
        Route::post('/invoices', 'store')->name('invoices.store');
        // EXPORT HARUS DIATAS {invoice} BIAR GA KETABRAK
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
    Route::get('/receivables', [ReceivableController::class, 'index'])->name('receivables.index');
    Route::get('/receivables/create', [ReceivableController::class, 'create'])->name('receivables.create');
    Route::post('/receivables', [ReceivableController::class, 'store'])->name('receivables.store');
    Route::get('/receivables/{receivable}', [ReceivableController::class, 'show'])->name('receivables.show');
    Route::get('/receivables/{receivable}/edit', [ReceivableController::class, 'edit'])->name('receivables.edit');
    Route::put('/receivables/{receivable}', [ReceivableController::class, 'update'])->name('receivables.update');
    Route::delete('/receivables/{receivable}', [ReceivableController::class, 'destroy'])->name('receivables.destroy');

    // ===== PAYABLES =====
    Route::get('/payables', function () {
        $user = Auth::user();
        $company = $user->company;

        if (!session()->has('payables')) {
            session(['payables' => [
                ['vendor' => 'Toko Bangunan Sentosa',  'bill' => '#B-0112', 'date' => '2026-06-05', 'due' => '2026-07-20', 'status' => 'lancar', 'amount' => 12500000],
                ['vendor' => 'CV Kertas Nusantara',    'bill' => '#B-0119', 'date' => '2026-06-12', 'due' => '2026-07-12', 'status' => 'lancar', 'amount' => 3200000],
                ['vendor' => 'PLN — Listrik Kantor',   'bill' => '#B-0125', 'date' => '2026-06-01', 'due' => '2026-06-15', 'status' => 'jatuh_tempo', 'amount' => 4100000],
                ['vendor' => 'Distributor Kain Batik', 'bill' => '#B-0103', 'date' => '2026-05-20', 'due' => '2026-06-05', 'status' => 'jatuh_tempo', 'amount' => 21400000],
                ['vendor' => 'Jasa Ekspedisi Cepat',   'bill' => '#B-0098', 'date' => '2026-05-10', 'due' => '2026-05-24', 'status' => 'lunas', 'amount' => 1850000],
            ]]);
        }

        $payables = session('payables');

        return view('payables.index', compact('user', 'company', 'payables'));
    })->name('payables.index');

    Route::get('/payables/create', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('payables.create', compact('user', 'company'));
    })->name('payables.create');

    Route::post('/payables', function () {
        $vendor_id = request('vendor_id');
        $number = request('number');
        $date = request('date');
        $due_date = request('due_date');
        $category = request('category');
        $notes = request('notes');
        $items = request('items');
        $status = request('status');

        $vendors = [
            1 => 'Toko Bangunan Sentosa',
            2 => 'CV Kertas Nusantara',
            3 => 'Distributor Kain Batik',
            4 => 'Jasa Ekspedisi Cepat',
            5 => 'PLN — Listrik Kantor',
        ];

        $subtotal = 0;
        if ($items) {
            foreach ($items as $item) {
                $subtotal += $item['quantity'] * $item['price'];
            }
        }

        $statusMapping = [
            'draft' => 'lancar',
            'sent' => 'lancar',
            'paid' => 'lunas',
        ];

        $payables = session('payables', []);
        $newBill = [
            'vendor' => $vendors[$vendor_id] ?? 'Vendor Unknown',
            'bill' => $number,
            'date' => $date,
            'due' => $due_date,
            'status' => $statusMapping[$status] ?? 'lancar',
            'amount' => $subtotal,
        ];

        array_unshift($payables, $newBill);
        session(['payables' => $payables]);

        return redirect()->route('payables.index')->with('success', 'Tagihan berhasil dibuat!');
    })->name('payables.store');

    Route::get('/payables/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $payables = session('payables', []);

        if (!isset($payables[$index])) {
            abort(404, 'Tagihan tidak ditemukan');
        }

        $payable = $payables[$index];
        return view('payables.show', compact('user', 'company', 'payable', 'index'));
    })->name('payables.show');

    Route::get('/payables/{index}/edit', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $payables = session('payables', []);

        if (!isset($payables[$index])) {
            abort(404, 'Tagihan tidak ditemukan');
        }

        $payable = $payables[$index];
        return view('payables.edit', compact('user', 'company', 'payable', 'index'));
    })->name('payables.edit');

    Route::put('/payables/{index}', function ($index) {
        $payables = session('payables', []);

        if (!isset($payables[$index])) {
            abort(404, 'Tagihan tidak ditemukan');
        }

        $payables[$index]['vendor'] = request('vendor', $payables[$index]['vendor']);
        $payables[$index]['bill']   = request('bill', $payables[$index]['bill']);
        $payables[$index]['date']   = request('date', $payables[$index]['date']);
        $payables[$index]['due']    = request('due', $payables[$index]['due']);
        $payables[$index]['status'] = request('status', $payables[$index]['status']);
        $payables[$index]['amount'] = request('amount', $payables[$index]['amount']);

        session(['payables' => $payables]);

        return redirect()->route('payables.index')->with('success', 'Tagihan berhasil diupdate!');
    })->name('payables.update');

    Route::delete('/payables/{index}', function ($index) {
        $payables = session('payables', []);

        if (isset($payables[$index])) {
            unset($payables[$index]);
        }

        session(['payables' => array_values($payables)]);

        return redirect()->route('payables.index')->with('success', 'Tagihan berhasil dihapus!');
    })->name('payables.destroy');

    // ===== AGING =====
    Route::get('/aging', function () {
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

    // ===== PEMBELIAN & BIAYA =====
    Route::get('/expenses', function () {
        $user = Auth::user();
        $company = $user->company;

        if (!session()->has('expenses')) {
            session(['expenses' => [
                ['desc' => 'Beli kain mori 50 meter', 'kategori' => 'Bahan Baku', 'date' => '2026-07-01', 'status' => 'lunas', 'amount' => 2500000],
                ['desc' => 'Ongkir bahan dari Solo',   'kategori' => 'Transportasi', 'date' => '2026-07-03', 'status' => 'lunas', 'amount' => 350000],
                ['desc' => 'Tagihan listrik workshop', 'kategori' => 'Utilitas', 'date' => '2026-07-06', 'status' => 'pending', 'amount' => 820000],
            ]]);
        }

        $expenses = session('expenses');

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

    Route::get('/expense-categories', function () {
        $user = Auth::user();
        $company = $user->company;

        if (!session()->has('expense_categories')) {
            session(['expense_categories' => [
                ['name' => 'Bahan Baku', 'desc' => 'Kain, pewarna, malam, dan perlengkapan batik', 'count' => 2, 'total' => 3475000],
                ['name' => 'Transportasi', 'desc' => 'Pengiriman bahan & produk jadi', 'count' => 1, 'total' => 350000],
                ['name' => 'Utilitas', 'desc' => 'Listrik, air, dan internet workshop', 'count' => 1, 'total' => 820000],
                ['name' => 'Produksi', 'desc' => 'Upah pengrajin & biaya proses produksi', 'count' => 1, 'total' => 4200000],
                ['name' => 'Marketing', 'desc' => 'Promosi, konten, dan iklan online', 'count' => 1, 'total' => 600000],
            ]]);
        }

        $categories = session('expense_categories');

        return view('expense-categories.index', compact('user', 'company', 'categories'));
    })->name('expense-categories.index');

    Route::get('/expense-categories/create', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('expense-categories.create', compact('user', 'company'));
    })->name('expense-categories.create');

    Route::post('/expense-categories', function () {
        $name = request('name');
        $description = request('description');

        $categories = session('expense_categories', []);
        $newCategory = [
            'name' => $name,
            'desc' => $description,
            'count' => 0,
            'total' => 0,
        ];

        array_unshift($categories, $newCategory);
        session(['expense_categories' => $categories]);

        return redirect()->route('expense-categories.index')->with('success', 'Kategori berhasil dibuat!');
    })->name('expense-categories.store');

    Route::get('/expense-categories/show/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $categories = session('expense_categories', []);

        if (!isset($categories[$index])) {
            abort(404, 'Kategori tidak ditemukan');
        }

        $category = $categories[$index];
        return view('expense-categories.show', compact('user', 'company', 'category', 'index'));
    })->name('expense-categories.show');

    Route::get('/expense-categories/edit/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $categories = session('expense_categories', []);

        if (!isset($categories[$index])) {
            abort(404, 'Kategori tidak ditemukan');
        }

        $category = $categories[$index];
        return view('expense-categories.edit', compact('user', 'company', 'category', 'index'));
    })->name('expense-categories.edit');

    Route::put('/expense-categories/update/{index}', function ($index) {
        $categories = session('expense_categories', []);

        if (!isset($categories[$index])) {
            abort(404, 'Kategori tidak ditemukan');
        }

        $categories[$index]['name'] = request('name', $categories[$index]['name']);
        $categories[$index]['desc'] = request('desc', $categories[$index]['desc']);

        session(['expense_categories' => $categories]);

        return redirect()->route('expense-categories.index')->with('success', 'Kategori berhasil diupdate!');
    })->name('expense-categories.update');

    Route::delete('/expense-categories/delete/{index}', function ($index) {
        $categories = session('expense_categories', []);

        if (isset($categories[$index])) {
            unset($categories[$index]);
        }

        session(['expense_categories' => array_values($categories)]);

        return redirect()->route('expense-categories.index')->with('success', 'Kategori berhasil dihapus!');
    })->name('expense-categories.destroy');

    // ===== PERBANKAN =====
    Route::get('/reconciliation', function () {
        $user = Auth::user();
        $company = $user->company;

        if (!session()->has('reconciliations')) {
            session(['reconciliations' => [
                ['desc' => 'Transfer masuk dari Nusantara Logistik', 'date' => '2026-07-02', 'bank' => 18400000, 'buku' => 18400000, 'status' => 'cocok'],
                ['desc' => 'Pembayaran listrik workshop',            'date' => '2026-07-06', 'bank' => 820000,    'buku' => 820000,    'status' => 'cocok'],
                ['desc' => 'Setoran tunai penjualan',                'date' => '2026-07-09', 'bank' => 1500000,   'buku' => 0,          'status' => 'belum'],
                ['desc' => 'Biaya admin bank',                       'date' => '2026-07-10', 'bank' => 25000,     'buku' => 0,          'status' => 'belum'],
            ]]);
        }

        $reconciliations = session('reconciliations');

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

        if (!session()->has('bank_mutations')) {
            session(['bank_mutations' => [
                ['desc' => 'Transfer masuk - Nusantara Logistik',   'date' => '2026-07-02', 'type' => 'masuk',  'amount' => 18400000, 'saldo' => 24650000],
                ['desc' => 'Pembayaran listrik workshop',            'date' => '2026-07-06', 'type' => 'keluar', 'amount' => 820000,   'saldo' => 23830000],
                ['desc' => 'Setoran tunai penjualan',                'date' => '2026-07-09', 'type' => 'masuk',  'amount' => 1500000,  'saldo' => 25330000],
                ['desc' => 'Biaya admin bank',                       'date' => '2026-07-10', 'type' => 'keluar', 'amount' => 25000,    'saldo' => 25305000],
            ]]);
        }

        $mutations = session('bank_mutations');

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

    // ===== LAPORAN =====
    Route::resource('laba-rugi', LabaRugiController::class);
    Route::resource('neraca', NeracaController::class);
    Route::resource('cash-flow', CashFlowController::class);
    Route::resource('ledger', LedgerController::class);

    // ===== INVENTARIS =====
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{item}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{item}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{item}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    Route::get('/cogs', [CogsController::class, 'index'])->name('cogs.index');
    Route::get('/cogs/create', [CogsController::class, 'create'])->name('cogs.create');
    Route::post('/cogs', [CogsController::class, 'store'])->name('cogs.store');
    Route::get('/cogs/{entry}/edit', [CogsController::class, 'edit'])->name('cogs.edit');
    Route::put('/cogs/{entry}', [CogsController::class, 'update'])->name('cogs.update');
    Route::delete('/cogs/{entry}', [CogsController::class, 'destroy'])->name('cogs.destroy');

    // ===== PAYROLL =====
    Route::get('/payroll', function () {
        $user = Auth::user();
        $company = $user->company;

        if (!session()->has('payrolls')) {
            session(['payrolls' => [
                ['employee' => 'Budi Santoso',      'position' => 'Pengrajin Batik', 'period' => 'Juli 2026', 'basic_salary' => 4500000, 'allowance' => 500000, 'deduction' => 150000, 'total' => 4850000, 'status' => 'paid'],
                ['employee' => 'Siti Rahayu',        'position' => 'Desainer',        'period' => 'Juli 2026', 'basic_salary' => 5200000, 'allowance' => 750000, 'deduction' => 200000, 'total' => 5750000, 'status' => 'paid'],
                ['employee' => 'Agus Wijaya',        'position' => 'Marketing',       'period' => 'Juli 2026', 'basic_salary' => 4800000, 'allowance' => 600000, 'deduction' => 180000, 'total' => 5220000, 'status' => 'pending'],
                ['employee' => 'Dewi Lestari',       'position' => 'Admin',           'period' => 'Juli 2026', 'basic_salary' => 4000000, 'allowance' => 400000, 'deduction' => 120000, 'total' => 4280000, 'status' => 'pending'],
            ]]);
        }

        $payrolls = session('payrolls');

        return view('payroll.index', compact('user', 'company', 'payrolls'));
    })->name('payroll.index');

    Route::get('/payroll/create', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('payroll.create', compact('user', 'company'));
    })->name('payroll.create');

    Route::post('/payroll', function () {
        $employee_id = request('employee_id');
        $period = request('period');
        $basic_salary = request('basic_salary');
        $allowance = request('allowance') ?? 0;
        $deduction = request('deduction') ?? 0;
        $status = request('status');
        $notes = request('notes');

        $employees = [
            1 => ['name' => 'Budi Santoso', 'position' => 'Pengrajin Batik'],
            2 => ['name' => 'Siti Rahayu', 'position' => 'Desainer'],
            3 => ['name' => 'Agus Wijaya', 'position' => 'Marketing'],
            4 => ['name' => 'Dewi Lestari', 'position' => 'Admin'],
            5 => ['name' => 'Hendra Gunawan', 'position' => 'Pengrajin Batik'],
        ];

        $total = (int) $basic_salary + (int) $allowance - (int) $deduction;

        $payrolls = session('payrolls', []);
        $newPayroll = [
            'employee' => $employees[$employee_id]['name'] ?? 'Unknown',
            'position' => $employees[$employee_id]['position'] ?? '-',
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

    Route::get('/employees', function () {
        $user = Auth::user();
        $company = $user->company;

        if (!session()->has('employees')) {
            session(['employees' => [
                ['name' => 'Budi Santoso', 'position' => 'Pengrajin Batik', 'department' => 'Produksi', 'email' => 'budi@arvessa.com', 'phone' => '0812-3456-7890', 'salary' => 4500000, 'status' => 'active', 'joined' => '2023-01-15'],
                ['name' => 'Siti Rahayu', 'position' => 'Desainer', 'department' => 'Kreatif', 'email' => 'siti@arvessa.com', 'phone' => '0813-4567-8901', 'salary' => 5200000, 'status' => 'active', 'joined' => '2023-03-01'],
                ['name' => 'Agus Wijaya', 'position' => 'Marketing', 'department' => 'Marketing', 'email' => 'agus@arvessa.com', 'phone' => '0814-5678-9012', 'salary' => 4800000, 'status' => 'active', 'joined' => '2023-06-10'],
                ['name' => 'Dewi Lestari', 'position' => 'Admin', 'department' => 'Operasional', 'email' => 'dewi@arvessa.com', 'phone' => '0815-6789-0123', 'salary' => 4000000, 'status' => 'active', 'joined' => '2023-08-20'],
            ]]);
        }

        $employees = session('employees');

        return view('employees.index', compact('user', 'company', 'employees'));
    })->name('employees.index');

    Route::get('/employees/create', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('employees.create', compact('user', 'company'));
    })->name('employees.create');

    Route::post('/employees', function () {
        $name = request('name');
        $position = request('position');
        $department = request('department');
        $email = request('email');
        $phone = request('phone');
        $joined = request('joined');
        $salary = request('salary');
        $status = request('status');
        $address = request('address');

        $employees = session('employees', []);
        $newEmployee = [
            'name' => $name,
            'position' => $position,
            'department' => $department,
            'email' => $email,
            'phone' => $phone,
            'joined' => $joined,
            'salary' => (int) $salary,
            'status' => $status,
            'address' => $address,
        ];

        array_unshift($employees, $newEmployee);
        session(['employees' => $employees]);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan!');
    })->name('employees.store');

    Route::get('/employees/show/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $employees = session('employees', []);

        if (!isset($employees[$index])) {
            abort(404, 'Karyawan tidak ditemukan');
        }

        $employee = $employees[$index];
        return view('employees.show', compact('user', 'company', 'employee', 'index'));
    })->name('employees.show');

    Route::get('/employees/edit/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $employees = session('employees', []);

        if (!isset($employees[$index])) {
            abort(404, 'Karyawan tidak ditemukan');
        }

        $employee = $employees[$index];
        return view('employees.edit', compact('user', 'company', 'employee', 'index'));
    })->name('employees.edit');

    Route::put('/employees/update/{index}', function ($index) {
        $employees = session('employees', []);

        if (!isset($employees[$index])) {
            abort(404, 'Karyawan tidak ditemukan');
        }

        $employees[$index]['name']       = request('name', $employees[$index]['name']);
        $employees[$index]['position']   = request('position', $employees[$index]['position']);
        $employees[$index]['department'] = request('department', $employees[$index]['department']);
        $employees[$index]['email']      = request('email', $employees[$index]['email']);
        $employees[$index]['phone']      = request('phone', $employees[$index]['phone']);
        $employees[$index]['joined']     = request('joined', $employees[$index]['joined']);
        $employees[$index]['salary']     = (int) request('salary', $employees[$index]['salary']);
        $employees[$index]['status']     = request('status', $employees[$index]['status']);
        $employees[$index]['address']    = request('address', $employees[$index]['address'] ?? '');

        session(['employees' => $employees]);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil diupdate!');
    })->name('employees.update');

    Route::delete('/employees/delete/{index}', function ($index) {
        $employees = session('employees', []);

        if (isset($employees[$index])) {
            unset($employees[$index]);
        }

        session(['employees' => array_values($employees)]);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dihapus!');
    })->name('employees.destroy');

    // ===== PAJAK =====
    Route::get('/taxes/pph', function () {
        $user = Auth::user();
        $company = $user->company;

        if (!session()->has('pph_data')) {
            session(['pph_data' => [
                ['period' => 'Januari 2026', 'gross' => 45000000, 'deduction' => 5000000, 'taxable' => 40000000, 'tax' => 1250000, 'status' => 'paid', 'due' => '2026-02-15'],
                ['period' => 'Februari 2026', 'gross' => 48000000, 'deduction' => 5200000, 'taxable' => 42800000, 'tax' => 1350000, 'status' => 'paid', 'due' => '2026-03-15'],
                ['period' => 'Maret 2026', 'gross' => 52000000, 'deduction' => 5500000, 'taxable' => 46500000, 'tax' => 1500000, 'status' => 'pending', 'due' => '2026-04-15'],
            ]]);
        }

        $pphData = session('pph_data');

        return view('taxes.pph', compact('user', 'company', 'pphData'));
    })->name('taxes.pph');

    Route::get('/taxes/pph/create', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('taxes.create_pph', compact('user', 'company'));
    })->name('taxes.pph.create');

    Route::post('/taxes/pph', function () {
        $period = request('period');
        $gross = request('gross');
        $deduction = request('deduction');
        $tax = request('tax');
        $due = request('due');
        $status = request('status');
        $notes = request('notes');

        $pphData = session('pph_data', []);
        $newPph = [
            'period' => $period,
            'gross' => (int) $gross,
            'deduction' => (int) $deduction,
            'taxable' => (int) $gross - (int) $deduction,
            'tax' => (int) $tax,
            'status' => $status,
            'due' => $due,
            'notes' => $notes,
        ];

        array_unshift($pphData, $newPph);
        session(['pph_data' => $pphData]);

        return redirect()->route('taxes.pph')->with('success', 'PPh berhasil ditambahkan!');
    })->name('taxes.pph.store');

    Route::get('/taxes/pph/show/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $pphData = session('pph_data', []);

        if (!isset($pphData[$index])) {
            abort(404, 'Data PPh tidak ditemukan');
        }

        $pph = $pphData[$index];
        return view('taxes.show_pph', compact('user', 'company', 'pph', 'index'));
    })->name('taxes.pph.show');

    Route::get('/taxes/pph/edit/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $pphData = session('pph_data', []);

        if (!isset($pphData[$index])) {
            abort(404, 'Data PPh tidak ditemukan');
        }

        $pph = $pphData[$index];
        return view('taxes.edit_pph', compact('user', 'company', 'pph', 'index'));
    })->name('taxes.pph.edit');

    Route::put('/taxes/pph/update/{index}', function ($index) {
        $pphData = session('pph_data', []);

        if (!isset($pphData[$index])) {
            abort(404, 'Data PPh tidak ditemukan');
        }

        $gross = request('gross', $pphData[$index]['gross']);
        $deduction = request('deduction', $pphData[$index]['deduction']);

        $pphData[$index]['period']    = request('period', $pphData[$index]['period']);
        $pphData[$index]['gross']     = (int) $gross;
        $pphData[$index]['deduction'] = (int) $deduction;
        $pphData[$index]['taxable']   = (int) $gross - (int) $deduction;
        $pphData[$index]['tax']       = (int) request('tax', $pphData[$index]['tax']);
        $pphData[$index]['status']    = request('status', $pphData[$index]['status']);
        $pphData[$index]['due']       = request('due', $pphData[$index]['due']);
        $pphData[$index]['notes']     = request('notes', $pphData[$index]['notes'] ?? '');

        session(['pph_data' => $pphData]);

        return redirect()->route('taxes.pph')->with('success', 'PPh berhasil diupdate!');
    })->name('taxes.pph.update');

    Route::delete('/taxes/pph/delete/{index}', function ($index) {
        $pphData = session('pph_data', []);

        if (isset($pphData[$index])) {
            unset($pphData[$index]);
        }

        session(['pph_data' => array_values($pphData)]);

        return redirect()->route('taxes.pph')->with('success', 'Data PPh berhasil dihapus!');
    })->name('taxes.pph.destroy');

    Route::get('/taxes/ppn', function () {
        $user = Auth::user();
        $company = $user->company;

        if (!session()->has('ppn_data')) {
            session(['ppn_data' => [
                ['period' => 'Januari 2026', 'output' => 4500000, 'input' => 1200000, 'ppn' => 3300000, 'status' => 'paid', 'due' => '2026-02-28'],
                ['period' => 'Februari 2026', 'output' => 4800000, 'input' => 1500000, 'ppn' => 3300000, 'status' => 'paid', 'due' => '2026-03-31'],
                ['period' => 'Maret 2026', 'output' => 5200000, 'input' => 1800000, 'ppn' => 3400000, 'status' => 'pending', 'due' => '2026-04-30'],
            ]]);
        }

        $ppnData = session('ppn_data');

        return view('taxes.ppn', compact('user', 'company', 'ppnData'));
    })->name('taxes.ppn');

    Route::get('/taxes/ppn/create', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('taxes.create_ppn', compact('user', 'company'));
    })->name('taxes.ppn.create');

    Route::post('/taxes/ppn', function () {
        $period = request('period');
        $output = request('output');
        $input = request('input');
        $due = request('due');
        $status = request('status');
        $notes = request('notes');

        $ppnData = session('ppn_data', []);
        $newPpn = [
            'period' => $period,
            'output' => (int) $output,
            'input' => (int) $input,
            'ppn' => (int) $output - (int) $input,
            'status' => $status,
            'due' => $due,
            'notes' => $notes,
        ];

        array_unshift($ppnData, $newPpn);
        session(['ppn_data' => $ppnData]);

        return redirect()->route('taxes.ppn')->with('success', 'PPN berhasil ditambahkan!');
    })->name('taxes.ppn.store');

    Route::get('/taxes/ppn/show/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $ppnData = session('ppn_data', []);

        if (!isset($ppnData[$index])) {
            abort(404, 'Data PPN tidak ditemukan');
        }

        $ppn = $ppnData[$index];
        return view('taxes.show_ppn', compact('user', 'company', 'ppn', 'index'));
    })->name('taxes.ppn.show');

    Route::get('/taxes/ppn/edit/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $ppnData = session('ppn_data', []);

        if (!isset($ppnData[$index])) {
            abort(404, 'Data PPN tidak ditemukan');
        }

        $ppn = $ppnData[$index];
        return view('taxes.edit_ppn', compact('user', 'company', 'ppn', 'index'));
    })->name('taxes.ppn.edit');

    Route::put('/taxes/ppn/update/{index}', function ($index) {
        $ppnData = session('ppn_data', []);

        if (!isset($ppnData[$index])) {
            abort(404, 'Data PPN tidak ditemukan');
        }

        $output = request('output', $ppnData[$index]['output']);
        $input = request('input', $ppnData[$index]['input']);

        $ppnData[$index]['period'] = request('period', $ppnData[$index]['period']);
        $ppnData[$index]['output'] = (int) $output;
        $ppnData[$index]['input']  = (int) $input;
        $ppnData[$index]['ppn']    = (int) $output - (int) $input;
        $ppnData[$index]['status'] = request('status', $ppnData[$index]['status']);
        $ppnData[$index]['due']    = request('due', $ppnData[$index]['due']);
        $ppnData[$index]['notes']  = request('notes', $ppnData[$index]['notes'] ?? '');

        session(['ppn_data' => $ppnData]);

        return redirect()->route('taxes.ppn')->with('success', 'PPN berhasil diupdate!');
    })->name('taxes.ppn.update');

    Route::delete('/taxes/ppn/delete/{index}', function ($index) {
        $ppnData = session('ppn_data', []);

        if (isset($ppnData[$index])) {
            unset($ppnData[$index]);
        }

        session(['ppn_data' => array_values($ppnData)]);

        return redirect()->route('taxes.ppn')->with('success', 'Data PPN berhasil dihapus!');
    })->name('taxes.ppn.destroy');

    Route::get('/tax-calendar', function () {
        $user = Auth::user();
        $company = $user->company;

        if (!session()->has('calendar_events')) {
            session(['calendar_events' => [
                ['date' => '2026-07-15', 'title' => 'PPh Pasal 21', 'type' => 'pph', 'status' => 'upcoming', 'desc' => 'Laporan PPh 21 masa Juni 2026'],
                ['date' => '2026-07-20', 'title' => 'PPN Masa', 'type' => 'ppn', 'status' => 'upcoming', 'desc' => 'Laporan PPN masa Juni 2026'],
                ['date' => '2026-07-25', 'title' => 'PPh Pasal 23', 'type' => 'pph', 'status' => 'upcoming', 'desc' => 'Laporan PPh 23 masa Juni 2026'],
            ]]);
        }

        $calendarEvents = session('calendar_events');

        return view('tax-calendar.index', compact('user', 'company', 'calendarEvents'));
    })->name('tax-calendar.index');

    Route::get('/tax-calendar/create', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('tax-calendar.create', compact('user', 'company'));
    })->name('tax-calendar.create');

    Route::post('/tax-calendar', function () {
        $title = request('title');
        $date = request('date');
        $type = request('type');
        $desc = request('desc');
        $status = request('status');

        $calendarEvents = session('calendar_events', []);
        $newEvent = [
            'title' => $title,
            'date' => $date,
            'type' => $type,
            'status' => $status,
            'desc' => $desc,
        ];

        array_unshift($calendarEvents, $newEvent);
        session(['calendar_events' => $calendarEvents]);

        return redirect()->route('tax-calendar.index')->with('success', 'Event berhasil ditambahkan!');
    })->name('tax-calendar.store');

    Route::get('/tax-calendar/show/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $calendarEvents = session('calendar_events', []);

        if (!isset($calendarEvents[$index])) {
            abort(404, 'Event tidak ditemukan');
        }

        $event = $calendarEvents[$index];
        return view('tax-calendar.show', compact('user', 'company', 'event', 'index'));
    })->name('tax-calendar.show');

    Route::get('/tax-calendar/edit/{index}', function ($index) {
        $user = Auth::user();
        $company = $user->company;
        $calendarEvents = session('calendar_events', []);

        if (!isset($calendarEvents[$index])) {
            abort(404, 'Event tidak ditemukan');
        }

        $event = $calendarEvents[$index];
        return view('tax-calendar.edit', compact('user', 'company', 'event', 'index'));
    })->name('tax-calendar.edit');

    Route::put('/tax-calendar/update/{index}', function ($index) {
        $calendarEvents = session('calendar_events', []);

        if (!isset($calendarEvents[$index])) {
            abort(404, 'Event tidak ditemukan');
        }

        $calendarEvents[$index]['title']  = request('title', $calendarEvents[$index]['title']);
        $calendarEvents[$index]['date']   = request('date', $calendarEvents[$index]['date']);
        $calendarEvents[$index]['type']   = request('type', $calendarEvents[$index]['type']);
        $calendarEvents[$index]['status'] = request('status', $calendarEvents[$index]['status']);
        $calendarEvents[$index]['desc']   = request('desc', $calendarEvents[$index]['desc']);

        session(['calendar_events' => $calendarEvents]);

        return redirect()->route('tax-calendar.index')->with('success', 'Event berhasil diupdate!');
    })->name('tax-calendar.update');

    Route::delete('/tax-calendar/delete/{index}', function ($index) {
        $calendarEvents = session('calendar_events', []);

        if (isset($calendarEvents[$index])) {
            unset($calendarEvents[$index]);
        }

        session(['calendar_events' => array_values($calendarEvents)]);

        return redirect()->route('tax-calendar.index')->with('success', 'Event berhasil dihapus!');
    })->name('tax-calendar.destroy');

    // ===== BUDGETING =====
    Route::get('/budgets', function () {
        $user = Auth::user();
        $company = $user->company;

        if (!session()->has('budgets')) {
            session(['budgets' => [
                ['category' => 'Pendapatan', 'period' => '2026', 'target' => 850000000, 'actual' => 785000000, 'progress' => 92, 'status' => 'on_track'],
                ['category' => 'Bahan Baku', 'period' => '2026', 'target' => 120000000, 'actual' => 98000000, 'progress' => 82, 'status' => 'on_track'],
                ['category' => 'Biaya Produksi', 'period' => '2026', 'target' => 95000000, 'actual' => 102000000, 'progress' => 107, 'status' => 'over_budget'],
                ['category' => 'Marketing', 'period' => '2026', 'target' => 45000000, 'actual' => 38500000, 'progress' => 86, 'status' => 'on_track'],
                ['category' => 'Operasional', 'period' => '2026', 'target' => 65000000, 'actual' => 72000000, 'progress' => 111, 'status' => 'over_budget'],
                ['category' => 'Utilitas', 'period' => '2026', 'target' => 28000000, 'actual' => 26500000, 'progress' => 95, 'status' => 'on_track'],
                ['category' => 'Pengembangan', 'period' => '2026', 'target' => 35000000, 'actual' => 21000000, 'progress' => 60, 'status' => 'under_budget'],
            ]]);
        }

        $budgets = session('budgets');

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

    // ===== PENGATURAN =====
    Route::get('/users', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('users.index', compact('user', 'company'));
    })->name('users.index');

    // Multi-User & Hak Akses (pakai TeamMemberController)
    Route::resource('team-members', TeamMemberController::class);

    // Profil Perusahaan (pakai CompanyController)
    Route::get('/company/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::patch('/company', [CompanyController::class, 'update'])->name('company.update');

    // Integrasi (pakai IntegrationController)
    Route::resource('integrations', IntegrationController::class);

    // Keamanan (pakai SecurityController — lengkap dengan password, 2FA, session)
    Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
    Route::put('/security/password', [SecurityController::class, 'updatePassword'])->name('security.password.update');
    Route::post('/security/two-factor/toggle', [SecurityController::class, 'toggleTwoFactor'])->name('security.two-factor.toggle');
    Route::delete('/security/sessions/{sessionId}', [SecurityController::class, 'revokeSession'])->name('security.sessions.revoke');
    Route::post('/security/sessions/revoke-others', [SecurityController::class, 'revokeOtherSessions'])->name('security.sessions.revoke-others');

    // Profile (pakai ProfileController — butuh route update & destroy)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});