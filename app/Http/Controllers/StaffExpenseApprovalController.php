<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseSubmission;
use App\Models\User;
use App\Notifications\ExpenseReviewed;
use Illuminate\Http\Request;

class StaffExpenseApprovalController extends Controller
{
    /**
     * Tampilkan daftar pengajuan pengeluaran yang masih pending,
     * khusus untuk perusahaan staff yang sedang login.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        $pendingSubmissions = ExpenseSubmission::where('company_id', $user->company_id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        // Ambil nama-nama user yang mengajukan, tanpa perlu relasi Eloquent
        // di model ExpenseSubmission (biar gak nabrak kalau relasinya belum ada)
        $submitterIds = $pendingSubmissions->pluck('submitted_by')->unique();
        $submitterNames = User::whereIn('id', $submitterIds)->pluck('name', 'id');

        $historySubmissions = ExpenseSubmission::where('company_id', $user->company_id)
            ->whereIn('status', ['approved', 'rejected'])
            ->latest('reviewed_at')
            ->limit(20)
            ->get();

        $historySubmitterIds = $historySubmissions->pluck('submitted_by')->unique();
        $historyReviewerIds  = $historySubmissions->pluck('reviewed_by')->filter()->unique();
        $historyNames = User::whereIn('id', $historySubmitterIds->merge($historyReviewerIds)->unique())
            ->pluck('name', 'id');

        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        return view('staff.expense-approvals.index', compact(
            'user',
            'company',
            'pendingSubmissions',
            'submitterNames',
            'historySubmissions',
            'historyNames',
            'currencySymbol'
        ));
    }

    /**
     * Setujui pengajuan: ubah status submission + catat sebagai Expense resmi.
     */
    public function approve(Request $request, ExpenseSubmission $submission)
    {
        $user = $request->user();

        abort_unless($submission->company_id === $user->company_id, 403);

        if ($submission->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $submission->update([
            'status'      => 'approved',
            'reviewed_by' => $user->id,
            'reviewed_at' => now(),
        ]);

        Expense::create([
            'company_id'             => $submission->company_id,
            'expense_submission_id'  => $submission->id,
            'created_by'             => $user->id,
            'description'            => $submission->description,
            'category'               => $submission->category ?? 'Lainnya',
            'expense_date'           => $submission->expense_date,
            'amount'                 => $submission->amount,
            'status'                 => 'pending',
            'notes'                  => $submission->note,
        ]);

        // Kirim notifikasi balik ke user yang mengajukan
        $submission->submitter->notify(new ExpenseReviewed($submission));

        return redirect()
            ->route('staff.expense-approvals.index')
            ->with('success', 'Pengajuan disetujui dan sudah dicatat ke pembukuan.');
    }

    /**
     * Tolak pengajuan: ubah status submission, tidak membuat Expense.
     */
    public function reject(Request $request, ExpenseSubmission $submission)
    {
        $user = $request->user();

        abort_unless($submission->company_id === $user->company_id, 403);

        if ($submission->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $submission->update([
            'status'      => 'rejected',
            'reviewed_by' => $user->id,
            'reviewed_at' => now(),
        ]);

        // Kirim notifikasi balik ke user yang mengajukan
        $submission->submitter->notify(new ExpenseReviewed($submission));

        return redirect()
            ->route('staff.expense-approvals.index')
            ->with('success', 'Pengajuan ditolak.');
    }
}