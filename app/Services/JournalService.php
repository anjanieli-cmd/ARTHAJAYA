<?php

namespace App\Services;

use App\Models\ChartOfAccount;
use App\Models\JournalEntry;

class JournalService
{
    /**
     * Catat 1 transaksi jadi 2 baris jurnal (debit & credit).
     *
     * @param int $companyId
     * @param string $debitAccountCode  kode akun yang di-DEBIT, contoh '5-101'
     * @param string $creditAccountCode kode akun yang di-CREDIT, contoh '1-101'
     * @param float $amount
     * @param string $description
     * @param string|null $referenceType
     * @param int|null $referenceId
     * @param string|null $date
     */
    public static function record(
        int $companyId,
        string $debitAccountCode,
        string $creditAccountCode,
        float $amount,
        string $description,
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $date = null
    ): void {
        $date = $date ?? now()->toDateString();

        $debitAccount = ChartOfAccount::where('company_id', $companyId)
            ->where('code', $debitAccountCode)
            ->firstOrFail();

        $creditAccount = ChartOfAccount::where('company_id', $companyId)
            ->where('code', $creditAccountCode)
            ->firstOrFail();

        // Baris Debit
        JournalEntry::create([
            'company_id' => $companyId,
            'chart_of_account_id' => $debitAccount->id,
            'transaction_date' => $date,
            'debit' => $amount,
            'credit' => 0,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);

        // Baris Credit
        JournalEntry::create([
            'company_id' => $companyId,
            'chart_of_account_id' => $creditAccount->id,
            'transaction_date' => $date,
            'debit' => 0,
            'credit' => $amount,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }
}