<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Auth;

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

    // ===== INVOICES =====
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoices', 'index')->name('invoices.index');
        Route::get('/invoices/create', 'create')->name('invoices.create');
        Route::post('/invoices', 'store')->name('invoices.store');
        Route::get('/invoices/{invoice}', 'show')->name('invoices.show');
        Route::get('/invoices/{invoice}/edit', 'edit')->name('invoices.edit');
        Route::put('/invoices/{invoice}', 'update')->name('invoices.update');
        Route::delete('/invoices/{invoice}', 'destroy')->name('invoices.destroy');
        Route::delete('/invoices/bulk-destroy', 'bulkDestroy')->name('invoices.bulk-destroy');
    });

    // ===== CLIENTS =====
    Route::get('/clients', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('clients.index', compact('user', 'company'));
    })->name('clients.index');

    // ===== QUOTES =====
    Route::get('/quotes', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('quotes.index', compact('user', 'company'));
    })->name('quotes.index');

    // ===== PIUTANG & UTANG (AR / AP) =====
    Route::get('/receivables', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('receivables.index', compact('user', 'company'));
    })->name('receivables.index');

    Route::get('/payables', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('payables.index', compact('user', 'company'));
    })->name('payables.index');

    Route::get('/aging', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('aging.index', compact('user', 'company'));
    })->name('aging.index');

    // ===== PEMBELIAN & BIAYA =====
    Route::get('/expenses', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('expenses.index', compact('user', 'company'));
    })->name('expenses.index');

    Route::get('/expense-categories', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('expense-categories.index', compact('user', 'company'));
    })->name('expense-categories.index');

    // ===== PERBANKAN =====
    Route::get('/reconciliation', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('reconciliation.index', compact('user', 'company'));
    })->name('reconciliation.index');

    Route::get('/bank-mutations', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('bank-mutations.index', compact('user', 'company'));
    })->name('bank-mutations.index');

    // ===== LAPORAN =====
    Route::get('/reports/profit-loss', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('reports.profit-loss', compact('user', 'company'));
    })->name('reports.profit-loss');

    Route::get('/reports/balance-sheet', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('reports.balance-sheet', compact('user', 'company'));
    })->name('reports.balance-sheet');

    Route::get('/reports/cash-flow', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('reports.cash-flow', compact('user', 'company'));
    })->name('reports.cash-flow');

    Route::get('/reports/general-ledger', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('reports.general-ledger', compact('user', 'company'));
    })->name('reports.general-ledger');

    // ===== INVENTARIS =====
    Route::get('/inventory', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('inventory.index', compact('user', 'company'));
    })->name('inventory.index');

    Route::get('/cogs', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('cogs.index', compact('user', 'company'));
    })->name('cogs.index');

    // ===== PAYROLL =====
    Route::get('/payroll', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('payroll.index', compact('user', 'company'));
    })->name('payroll.index');

    Route::get('/employees', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('employees.index', compact('user', 'company'));
    })->name('employees.index');

    // ===== PAJAK =====
    Route::get('/taxes/pph', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('taxes.pph', compact('user', 'company'));
    })->name('taxes.pph');

    Route::get('/taxes/ppn', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('taxes.ppn', compact('user', 'company'));
    })->name('taxes.ppn');

    Route::get('/tax-calendar', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('tax-calendar.index', compact('user', 'company'));
    })->name('tax-calendar.index');

    // ===== BUDGETING =====
    Route::get('/budgets', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('budgets.index', compact('user', 'company'));
    })->name('budgets.index');

    // ===== PENGGATURAN =====
    Route::get('/users', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('users.index', compact('user', 'company'));
    })->name('users.index');

    Route::get('/integrations', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('integrations.index', compact('user', 'company'));
    })->name('integrations.index');

    Route::get('/security', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('security.index', compact('user', 'company'));
    })->name('security.index');

    Route::get('/profile', function () {
        $user = Auth::user();
        $company = $user->company;
        return view('profile.edit', compact('user', 'company'));
    })->name('profile.edit');
});