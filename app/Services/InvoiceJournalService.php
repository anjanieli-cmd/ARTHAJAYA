<?php

namespace App\Services;

use App\Models\ChartOfAccount;
use App\Models\Invoice;
use App\Models\JournalEntry;
use Illuminate\Support\Facades\Log;

/**
 * Logic posting jurnal AR (Piutang Usaha) untuk Faktur.
 * Dipakai oleh InvoiceController (faktur langsung) dan QuoteController
 * (waktu penawaran dikonversi jadi faktur), biar nggak duplikat kode.
 */
class InvoiceJournalService
{
    private const PIUTANG_CODE = '1-103';
    private const PENDAPATAN_CODE = '4-101';
    private const KAS_CODE = '1-102';

    /**
     * Akui piutang begitu faktur "sent": debit Piutang Usaha (1-103),
     * kredit Pendapatan Penjualan (4-101). Idempotent.
     */
    public function syncReceivableRecognitionJournal($company, Invoice $invoice): void
    {
        $piutangId = ChartOfAccount::where('company_id', $company->id)->where('code', self::PIUTANG_CODE)->value('id');
        $pendapatanId = ChartOfAccount::where('company_id', $company->id)->where('code', self::PENDAPATAN_CODE)->value('id');

        if (!$piutangId || !$pendapatanId) {
            Log::warning("Akun Piutang Usaha (" . self::PIUTANG_CODE . ") atau Pendapatan Penjualan (" . self::PENDAPATAN_CODE . ") tidak ditemukan untuk company #{$company->id}. Sudah jalankan MissingArApAccountsSeeder?");
            return;
        }

        $existing = JournalEntry::where('reference_type', 'receivable_recognition')->where('reference_id', $invoice->id)->get();
        $debitEntry = $existing->first(fn ($e) => (float) $e->debit > 0);
        $creditEntry = $existing->first(fn ($e) => (float) $e->credit > 0);

        $description = 'Piutang faktur ' . $invoice->invoice_number;
        $date = optional($invoice->issue_date)->format('Y-m-d') ?? now()->format('Y-m-d');

        $payloadDebit = [
            'company_id' => $company->id, 'chart_of_account_id' => $piutangId,
            'transaction_date' => $date, 'description' => $description,
            'debit' => $invoice->total, 'credit' => 0,
            'reference_type' => 'receivable_recognition', 'reference_id' => $invoice->id,
        ];
        $payloadCredit = [
            'company_id' => $company->id, 'chart_of_account_id' => $pendapatanId,
            'transaction_date' => $date, 'description' => $description,
            'debit' => 0, 'credit' => $invoice->total,
            'reference_type' => 'receivable_recognition', 'reference_id' => $invoice->id,
        ];

        $debitEntry ? $debitEntry->update($payloadDebit) : JournalEntry::create($payloadDebit);
        $creditEntry ? $creditEntry->update($payloadCredit) : JournalEntry::create($payloadCredit);
    }

    /**
     * Catat pelunasan piutang saat faktur "paid": debit Kas (1-102),
     * kredit Piutang Usaha (1-103).
     */
    public function syncReceivablePaymentJournal($company, Invoice $invoice): void
    {
        $kasId = ChartOfAccount::where('company_id', $company->id)->where('code', self::KAS_CODE)->value('id');
        $piutangId = ChartOfAccount::where('company_id', $company->id)->where('code', self::PIUTANG_CODE)->value('id');

        if (!$kasId || !$piutangId) {
            Log::warning("Akun Kas (" . self::KAS_CODE . ") atau Piutang Usaha (" . self::PIUTANG_CODE . ") tidak ditemukan untuk company #{$company->id}.");
            return;
        }

        $existing = JournalEntry::where('reference_type', 'receivable_payment')->where('reference_id', $invoice->id)->get();
        $debitEntry = $existing->first(fn ($e) => (float) $e->debit > 0);
        $creditEntry = $existing->first(fn ($e) => (float) $e->credit > 0);

        $description = 'Pelunasan faktur ' . $invoice->invoice_number;

        $payloadDebit = [
            'company_id' => $company->id, 'chart_of_account_id' => $kasId,
            'transaction_date' => now()->format('Y-m-d'), 'description' => $description,
            'debit' => $invoice->total, 'credit' => 0,
            'reference_type' => 'receivable_payment', 'reference_id' => $invoice->id,
        ];
        $payloadCredit = [
            'company_id' => $company->id, 'chart_of_account_id' => $piutangId,
            'transaction_date' => now()->format('Y-m-d'), 'description' => $description,
            'debit' => 0, 'credit' => $invoice->total,
            'reference_type' => 'receivable_payment', 'reference_id' => $invoice->id,
        ];

        $debitEntry ? $debitEntry->update($payloadDebit) : JournalEntry::create($payloadDebit);
        $creditEntry ? $creditEntry->update($payloadCredit) : JournalEntry::create($payloadCredit);
    }

    public function deleteReceivableRecognitionJournal(Invoice $invoice): void
    {
        JournalEntry::where('reference_type', 'receivable_recognition')->where('reference_id', $invoice->id)->delete();
    }

    public function deleteReceivablePaymentJournal(Invoice $invoice): void
    {
        JournalEntry::where('reference_type', 'receivable_payment')->where('reference_id', $invoice->id)->delete();
    }
}