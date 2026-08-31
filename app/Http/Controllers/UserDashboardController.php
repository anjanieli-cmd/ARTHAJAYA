<?php

namespace App\Http\Controllers;

use App\Models\ExpenseSubmission;
use App\Models\ExpenseCategory;
use App\Models\User;
use App\Notifications\ExpenseSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserDashboardController extends Controller
{
    /**
     * Dashboard User
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        // Ringkasan read-only company (kalau company belum ada, kosongin aja)
        $ledgerEntries = session('ledger_entries', []);

        $currentMonth = date('Y-m');
        $totalIncome = 0;
        $totalExpense = 0;

        foreach ($ledgerEntries as $entry) {
            $entryDate = substr($entry['date'] ?? '', 0, 7);
            $amount = $entry['amount'] ?? 0;
            if ($entryDate === $currentMonth) {
                $amount > 0 ? $totalIncome += $amount : $totalExpense += abs($amount);
            }
        }

        $totalBalance = ($company?->accounts()->first()->initial_balance ?? 0);
        foreach ($ledgerEntries as $entry) {
            $totalBalance += $entry['amount'] ?? 0;
        }

        // Riwayat submission milik user ini sendiri
        $mySubmissions = ExpenseSubmission::where('submitted_by', $user->id)
            ->latest()
            ->get();

        $pendingCount = ExpenseSubmission::where('submitted_by', $user->id)
            ->where('status', 'pending')
            ->count();

        // Hitung statistik tambahan
        $approvedThisMonth = $mySubmissions->filter(function ($s) {
            return $s->status === 'approved' && $s->reviewed_at && $s->reviewed_at->format('Y-m') === date('Y-m');
        })->sum('amount');

        $rejectedCount = $mySubmissions->where('status', 'rejected')->count();

        // Currency symbol
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        return view('user.dashboard', compact(
            'user',
            'company',
            'totalBalance',
            'totalIncome',
            'totalExpense',
            'mySubmissions',
            'pendingCount',
            'approvedThisMonth',
            'rejectedCount',
            'currencySymbol'
        ));
    }

    /**
     * Tampilkan form ajukan pengeluaran
     */
    public function createExpense(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        // Ambil kategori dari database
        $categories = ExpenseCategory::where('company_id', $company->id)
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        // Jika belum ada kategori di database, fallback ke default
        if (empty($categories)) {
            $categories = ['Operasional', 'Transportasi', 'Perlengkapan', 'Konsumsi', 'Marketing', 'Lainnya'];
        }

        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        return view('user.expenses.create', compact('user', 'company', 'currencySymbol', 'categories'));
    }

    /**
     * Simpan pengajuan pengeluaran
     */
    public function storeExpense(Request $request)
    {
        $user = $request->user();

        if (! $user->company_id) {
            return back()->withErrors(['company' => 'Kamu belum tergabung ke perusahaan manapun.']);
        }

        $validated = $request->validate([
            'description'  => ['required', 'string', 'max:255'],
            'amount'       => ['required', 'numeric', 'min:1'],
            'category'     => ['nullable', 'string', 'max:100'],
            'expense_date' => ['required', 'date'],
            'notes'        => ['nullable', 'string', 'max:500'],
        ]);

        $submission = ExpenseSubmission::create([
            'company_id'   => $user->company_id,
            'submitted_by' => $user->id,
            'description'  => $validated['description'],
            'amount'       => $validated['amount'],
            'category'     => $validated['category'] ?? 'Lainnya',
            'expense_date' => $validated['expense_date'],
            'notes'        => $validated['notes'] ?? null,
            'status'       => 'pending',
        ]);

        // Kirim notifikasi ke semua staff di company yang sama
        $staff = User::where('company_id', $user->company_id)
            ->where('access_level', \App\Enums\AccessLevel::Staff)
            ->get();

        foreach ($staff as $s) {
            $s->notify(new ExpenseSubmitted($submission));
        }

        return redirect()->route('user.expenses.create')->with('success', 'Pengeluaran berhasil diajukan, menunggu persetujuan Staff.');
    }

    /**
     * Tampilkan riwayat pengeluaran user
     */
    public function expenseHistory(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        $mySubmissions = ExpenseSubmission::where('submitted_by', $user->id)
            ->latest()
            ->get();

        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        return view('user.expenses.index', compact('user', 'company', 'mySubmissions', 'currencySymbol'));
    }

    /**
     * Tampilkan ringkasan kas
     */
    public function expenseSummary(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        // Hitung statistik dari ledger
        $ledgerEntries = session('ledger_entries', []);
        $totalBalance = ($company?->accounts()->first()->initial_balance ?? 0);
        $totalIncome = 0;
        $totalExpense = 0;
        $currentMonth = date('Y-m');

        // Data bulanan untuk chart
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $monthlyData[$month] = ['income' => 0, 'expense' => 0];
        }

        foreach ($ledgerEntries as $entry) {
            $entryDate = substr($entry['date'] ?? '', 0, 7);
            $amount = $entry['amount'] ?? 0;

            if ($entryDate === $currentMonth) {
                $amount > 0 ? $totalIncome += $amount : $totalExpense += abs($amount);
            }
            $totalBalance += $amount;

            if (isset($monthlyData[$entryDate])) {
                if ($amount > 0) {
                    $monthlyData[$entryDate]['income'] += $amount;
                } else {
                    $monthlyData[$entryDate]['expense'] += abs($amount);
                }
            }
        }

        // Hitung rasio kas
        $cashRatio = $totalBalance > 0 ? round(($totalIncome / max(1, $totalBalance)) * 100, 1) : 0;

        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        return view('user.expenses.summary', compact(
            'user',
            'company',
            'totalBalance',
            'totalIncome',
            'totalExpense',
            'monthlyData',
            'cashRatio',
            'currencySymbol'
        ));
    }

    // ============================================================
    // ===== PROFIL USER =====
    // ============================================================

    /**
     * Tampilkan halaman profil user
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        return view('user.profile', compact('user', 'company'));
    }

    /**
     * Update profil user
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'current_password.current_password' => 'Password saat ini salah.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'profile_photo.max' => 'Ukuran foto maksimal 2MB.',
            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau svg.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.profile')
                ->withErrors($validator)
                ->withInput();
        }

        // Update basic info
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('supabase')->exists($user->profile_photo)) {
                Storage::disk('supabase')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'supabase');
            $user->profile_photo = $path;
        }

        // Handle remove photo
        if ($request->has('remove_photo') && $request->remove_photo == '1') {
            if ($user->profile_photo && Storage::disk('supabase')->exists($user->profile_photo)) {
                Storage::disk('supabase')->delete($user->profile_photo);
            }
            $user->profile_photo = null;
        }

        // Update password if provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('user.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}