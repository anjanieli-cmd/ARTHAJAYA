<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OnboardingController;
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
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $company = $user->company;
        $account = $company ? $company->accounts()->first() : null;

        return view('dashboard', compact('user', 'company', 'account'));
    })->name('dashboard');

    // Piutang & Utang (AR / AP)
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

    Route::get('/aging-report', function () {
        $user = Auth::user();
        $company = $user->company;

        return view('aging.index', compact('user', 'company'));
    })->name('aging.index');
});