<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ===== AUTH CONTROLLERS =====
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OnboardingController;

// ===== FITUR UTAMA =====
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\QuoteController;

// ===== LAPORAN =====
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\NeracaController;
use App\Http\Controllers\CashFlowController;
use App\Http\Controllers\LedgerController;

// ===== INVENTARIS =====
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CogsController;

// ===== PAYROLL (dari web.php kamu) =====
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ReceivableController;

// ===== NOTIFIKASI (dari Teman A) =====
use App\Http\Controllers\NotificationController;

// ===== PENGATURAN (dari Teman B) =====
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecurityController;

// ──────────────────────────────────────────
// HOMEPAGE
// ──────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ──────────────────────────────────────────
// AUTH ROUTES (guest only)
// ──────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ──────────────────────────────────────────
// ONBOARDING (auth required)
// ──────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding.show');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
    Route::post('/onboarding/update', [OnboardingController::class, 'update'])->name('onboarding.update');
});

// ──────────────────────────────────────────
// LOGOUT
// ──────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ──────────────────────────────────────────
// PROTECTED ROUTES (auth + onboarding complete)
// ──────────────────────────────────────────
Route::middleware(['auth', 'onboarding.complete'])->group(function () {

    // ===== DASHBOARD =====
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $company = $user->company;
        $account = $company ? $company->accounts()->first() : null;
        return view('dashboard', compact('user', 'company', 'account'));
    })->name('dashboard');

    // ===== NOTIFIKASI (Teman A) =====
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notifications.index');
        Route::post('/notifications/{id}/read', 'markAsRead')->name('notifications.read');
        Route::post('/notifications/read-all', 'markAllAsRead')->name('notifications.readAll');
    });

    // ===== INVOICES (web.php kamu — pakai session logic) =====
    Route::get('/invoices', function () {
        $user = Auth::user();
        $company = $user->company;

        if (!session()->has('invoices')) {
            session(['invoices' => [
                ['id' => 1, 'client' => 'PT Andalas Maju Bersama', 'invoice' => 'INV-2026-0001', 'date' => '2026-06-10', 'due' => '2026-07-10', 'status' => 'sent',    'amount' => 5750000],
                ['id' => 2, 'client' => 'Nusantara Logistik',      'invoice' => 'INV-2026-0002', 'date' => '2026-06-15', 'due' => '2026-06-25', 'status' => 'sent',    'amount' => 18400000],
                ['id' => 3, 'client' => 'Ruang Kriya Studio',      'invoice' => 'INV-2026-0003', 'date' => '2026-06-18', 'due' => '2026-06-28', 'status' => 'sent',    'amount' => 6200000],
                ['id' => 4, 'client' => 'Bumi Retail Group',       'invoice' => 'INV-2026-0004', 'date' => '2026-05-25', 'due' => '2026-06-02', 'status' => 'overdue', 'amount' => 9200000],
                ['id' => 5, 'client' => 'Kopi Kenangan Senja',     'invoice' => 'INV-2026-0005', 'date' => '2026-06-01', 'due' => '2026-06-15', 'status' => 'paid',    'amount' => 2800000],
                ['id' => 6, 'client' => 'Warung Sinar Abadi',      'invoice' => 'INV-2026-0006', 'date' => '2026-05-20', 'due' => '2026-05-28', 'status' => 'paid',    'amount' => 4100000],
                ['id' => 7, 'client' => 'Toko Elektronik Jaya',    'invoice' => 'INV-2026-0007', 'date' => '2026-05-10', 'due' => '2026-06-10', 'status' => 'overdue', 'amount' => 6100000],
                ['id' => 8, 'client' => 'CV Bangun Perkasa',       'invoice' => 'INV-2026-0008', 'date' => '2026-04-01', 'due' => '2026-05-01', 'status' => 'overdue', 'amount' => 3400000],
            ]]);
        }

        $invoices = session('invoices');
        return view('invoices.index', compact('user', 'company', 'invoices'));
    })->name('invoices.index');

    Route::get('/invoices/create', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('invoices.create', compact('user', 'company'));
    })->name('invoices.create');

    Route::post('/invoices', function () {
        $client_id = request('client_id');
        $number    = request('number');
        $date      = request('date');
        $notes     = request('notes');
        $items     = request('items');
        $status    = request('status');

        $clients = [
            1 => 'PT Andalas Maju Bersama',
            2 => 'Nusantara Logistik',
            3 => 'Ruang Kriya Studio',
            4 => 'Bumi Retail Group',
        ];

        $subtotal = 0;
        if ($items) {
            foreach ($items as $item) {
                $subtotal += $item['quantity'] * $item['price'];
            }
        }

        $dueDate   = date('Y-m-d', strtotime($date . ' +14 days'));
        $isOverdue = strtotime($dueDate) < strtotime(date('Y-m-d'));

        if ($status == 'paid') {
            $finalStatus = 'paid';
        } elseif ($isOverdue) {
            $finalStatus = 'overdue';
        } else {
            $finalStatus = 'sent';
        }

        $invoices   = session('invoices', []);
        $newInvoice = [
            'id'      => count($invoices) + 1,
            'client'  => $clients[$client_id] ?? 'Unknown Client',
            'invoice' => $number,
            'date'    => $date,
            'due'     => $dueDate,
            'status'  => $finalStatus,
            'amount'  => $subtotal,
            'notes'   => $notes,
            'items'   => $items,
        ];

        array_unshift($invoices, $newInvoice);
        session(['invoices' => $invoices]);

        return redirect()->route('invoices.index')->with('success', 'Faktur berhasil dibuat!');
    })->name('invoices.store');

    Route::get('/invoices/{id}', function ($id) {
        $user    = Auth::user();
        $company = $user->company;

        try {
            $invoice = App\Models\Invoice::findOrFail($id);
            return view('invoices.show', compact('user', 'company', 'invoice'));
        } catch (\Exception $e) {
            $invoices    = session('invoices', []);
            $invoiceData = collect($invoices)->firstWhere('id', (int)$id);
            if (!$invoiceData) abort(404, 'Faktur tidak ditemukan');
            $invoice = (object) $invoiceData;
            return view('invoices.show', compact('user', 'company', 'invoice'));
        }
    })->name('invoices.show');

    Route::get('/invoices/{id}/edit', function ($id) {
        $user     = Auth::user();
        $company  = $user->company;
        $invoices = session('invoices', []);
        $invoice  = collect($invoices)->firstWhere('id', (int)$id);
        if (!$invoice) abort(404, 'Faktur tidak ditemukan');
        return view('invoices.edit', compact('user', 'company', 'invoice'));
    })->name('invoices.edit');

    Route::put('/invoices/{id}', function ($id) {
        $invoices = session('invoices', []);
        foreach ($invoices as $key => $inv) {
            if ($inv['id'] == (int)$id) {
                $invoices[$key]['client'] = request('client', $inv['client']);
                $invoices[$key]['date']   = request('date', $inv['date']);
                $invoices[$key]['status'] = request('status', $inv['status']);
            }
        }
        session(['invoices' => $invoices]);
        return redirect()->route('invoices.index')->with('success', 'Faktur berhasil diperbarui!');
    })->name('invoices.update');

    Route::delete('/invoices/{id}', function ($id) {
        $invoices = session('invoices', []);
        $invoices = array_filter($invoices, fn($inv) => $inv['id'] != (int)$id);
        session(['invoices' => array_values($invoices)]);
        return redirect()->route('invoices.index')->with('success', 'Faktur berhasil dihapus!');
    })->name('invoices.destroy');

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
    Route::get('/receivables', function () {
        $user = Auth::user(); $company = $user->company;
        return view('receivables.index', compact('user', 'company'));
    })->name('receivables.index');

    Route::get('/payables', function () {
        $user = Auth::user(); $company = $user->company;
        return view('payables.index', compact('user', 'company'));
    })->name('payables.index');

    Route::get('/aging', function () {
        $user = Auth::user(); $company = $user->company;
        return view('aging.index', compact('user', 'company'));
    })->name('aging.index');

    // ===== PEMBELIAN & BIAYA =====
    Route::get('/expenses', function () {
        $user = Auth::user(); $company = $user->company;
        return view('expenses.index', compact('user', 'company'));
    })->name('expenses.index');

    Route::get('/expense-categories', function () {
        $user = Auth::user(); $company = $user->company;
        return view('expense-categories.index', compact('user', 'company'));
    })->name('expense-categories.index');

    // ===== PERBANKAN =====
    Route::get('/reconciliation', function () {
        $user = Auth::user(); $company = $user->company;
        return view('reconciliation.index', compact('user', 'company'));
    })->name('reconciliation.index');

    Route::get('/bank-mutations', function () {
        $user = Auth::user(); $company = $user->company;
        return view('bank-mutations.index', compact('user', 'company'));
    })->name('bank-mutations.index');

    // ===== LAPORAN (Teman B — pakai except('show')) =====
    Route::resource('laba-rugi', LabaRugiController::class)->except('show');
    Route::resource('neraca', NeracaController::class)->except('show');
    Route::resource('cash-flow', CashFlowController::class)->except('show');
    Route::resource('ledger', LedgerController::class)->except('show');

    // ===== INVENTARIS (Teman B — tanpa route show) =====
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

    // ===== PAYROLL (web.php kamu) =====
    Route::get('/payroll', function () {
        $user = Auth::user(); $company = $user->company;
        return view('payroll.index', compact('user', 'company'));
    })->name('payroll.index');

    Route::get('/employees', function () {
        $user = Auth::user(); $company = $user->company;
        return view('employees.index', compact('user', 'company'));
    })->name('employees.index');

    // ===== PAJAK =====
    Route::get('/taxes/pph', function () {
        $user = Auth::user(); $company = $user->company;
        return view('taxes.pph', compact('user', 'company'));
    })->name('taxes.pph');

    Route::get('/taxes/ppn', function () {
        $user = Auth::user(); $company = $user->company;
        return view('taxes.ppn', compact('user', 'company'));
    })->name('taxes.ppn');

    Route::get('/tax-calendar', function () {
        $user = Auth::user(); $company = $user->company;
        return view('tax-calendar.index', compact('user', 'company'));
    })->name('tax-calendar.index');

    // ===== BUDGETING (web.php kamu — lengkap dengan export) =====
    Route::get('/budgets', function () {
        $user = Auth::user(); $company = $user->company;
        return view('budgets.index', compact('user', 'company'));
    })->name('budgets.index');

    Route::get('/budgets/export', function () {
        $budgets = session('budgets', [
            ['category' => 'Pendapatan',      'period' => '2026', 'target' => 850000000, 'actual' => 785000000, 'progress' => 92,  'status' => 'on_track'],
            ['category' => 'Bahan Baku',      'period' => '2026', 'target' => 120000000, 'actual' => 98000000,  'progress' => 82,  'status' => 'on_track'],
            ['category' => 'Biaya Produksi',  'period' => '2026', 'target' => 95000000,  'actual' => 102000000, 'progress' => 107, 'status' => 'over_budget'],
            ['category' => 'Marketing',       'period' => '2026', 'target' => 45000000,  'actual' => 38500000,  'progress' => 86,  'status' => 'on_track'],
            ['category' => 'Operasional',     'period' => '2026', 'target' => 65000000,  'actual' => 72000000,  'progress' => 111, 'status' => 'over_budget'],
            ['category' => 'Utilitas',        'period' => '2026', 'target' => 28000000,  'actual' => 26500000,  'progress' => 95,  'status' => 'on_track'],
            ['category' => 'Pengembangan',    'period' => '2026', 'target' => 35000000,  'actual' => 21000000,  'progress' => 60,  'status' => 'under_budget'],
        ]);

        $currencySymbol = 'Rp';
        $no = 1; $totalTarget = 0; $totalActual = 0;

        $rows = '';
        foreach ($budgets as $row) {
            $target      = $row['target'];
            $actual      = $row['actual'];
            $selisih     = $actual - $target;
            $selisihText = ($selisih >= 0 ? '+' : '') . number_format($selisih, 0, ',', '.');
            $selisihColor = $selisih >= 0 ? '#34B583' : '#E85A5A';
            $statusLabel = ['on_track' => 'On Track', 'over_budget' => 'Over Budget', 'under_budget' => 'Under Budget'][$row['status']] ?? $row['status'];
            $totalTarget += $target; $totalActual += $actual;

            $rows .= "<tr>
                <td>{$no}</td>
                <td><strong>{$row['category']}</strong></td>
                <td>{$row['period']}</td>
                <td style='text-align:right'>{$currencySymbol} " . number_format($target, 0, ',', '.') . "</td>
                <td style='text-align:right'>{$currencySymbol} " . number_format($actual, 0, ',', '.') . "</td>
                <td style='text-align:right;color:{$selisihColor}'>{$selisihText}</td>
                <td style='text-align:center'><strong>{$row['progress']}%</strong></td>
                <td>{$statusLabel}</td>
            </tr>";
            $no++;
        }

        $totalSelisih     = $totalActual - $totalTarget;
        $totalSelisihText = ($totalSelisih >= 0 ? '+' : '') . number_format($totalSelisih, 0, ',', '.');
        $totalSelisihColor = $totalSelisih >= 0 ? '#34B583' : '#E85A5A';

        $html = "
        <html><head><meta charset='UTF-8'>
        <style>
            table{border-collapse:collapse;width:100%;font-family:Arial,sans-serif}
            th{background:#6C5CE7;color:#fff;padding:10px 12px;text-align:left;font-weight:bold;border:1px solid #5A4BD1}
            td{padding:8px 12px;border:1px solid #ddd;text-align:left}
            .total-row{background:#f0f0f0;font-weight:bold}
        </style></head><body>
        <div style='font-size:18px;font-weight:bold;margin-bottom:10px'>Laporan Anggaran &amp; Forecasting</div>
        <div style='font-size:12px;color:#666;margin-bottom:20px'>Periode: " . date('F Y') . " | Dicetak: " . date('d F Y H:i') . "</div>
        <table><thead><tr>
            <th>No</th><th>Kategori</th><th>Periode</th>
            <th style='text-align:right'>Target</th><th style='text-align:right'>Realisasi</th>
            <th style='text-align:right'>Selisih</th><th style='text-align:center'>Progress</th><th>Status</th>
        </tr></thead><tbody>
        {$rows}
        <tr class='total-row'>
            <td colspan='2' style='text-align:right'><strong>TOTAL</strong></td><td></td>
            <td style='text-align:right'><strong>{$currencySymbol} " . number_format($totalTarget, 0, ',', '.') . "</strong></td>
            <td style='text-align:right'><strong>{$currencySymbol} " . number_format($totalActual, 0, ',', '.') . "</strong></td>
            <td style='text-align:right;color:{$totalSelisihColor}'><strong>{$totalSelisihText}</strong></td>
            <td colspan='2'></td>
        </tr>
        </tbody></table>
        <div style='margin-top:20px;font-size:11px;color:#999;text-align:center'>Laporan ini dihasilkan secara otomatis oleh Arthajaya System</div>
        </body></html>";

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="Anggaran_' . date('Y-m-d') . '.xls"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    })->name('budgets.export');

    // ===== PENGATURAN =====

    // Multi-User & Hak Akses (Teman B)
    Route::resource('team-members', TeamMemberController::class);

    // Integrasi (Teman B — pakai controller proper)
    Route::resource('integrations', IntegrationController::class);

    // Keamanan (Teman B — lebih lengkap)
    Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
    Route::put('/security/password', [SecurityController::class, 'updatePassword'])->name('security.password.update');
    Route::post('/security/two-factor/toggle', [SecurityController::class, 'toggleTwoFactor'])->name('security.two-factor.toggle');
    Route::delete('/security/sessions/{sessionId}', [SecurityController::class, 'revokeSession'])->name('security.sessions.revoke');
    Route::post('/security/sessions/revoke-others', [SecurityController::class, 'revokeOtherSessions'])->name('security.sessions.revoke-others');

    // Profil (Teman B — pakai controller proper)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Users (dari web.php kamu)
    Route::get('/users', function () {
        $user = Auth::user(); $company = $user->company;
        return view('users.index', compact('user', 'company'));
    })->name('users.index');

});