<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\ActivityLog;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use Illuminate\Console\Command;

class BackfillOpeningBalanceJournal extends Command
{
    /**
     * Jalankan dengan: php artisan arthajaya:backfill-opening-balance
     * Tambahkan --dry-run untuk lihat dulu apa yang AKAN terjadi, tanpa
     * benar-benar menulis apapun ke database.
     */
    protected $signature = 'arthajaya:backfill-opening-balance {--dry-run}';

    protected $description = 'Catat saldo awal lama (company yang datanya belum tersambung ke Buku Besar) sebagai jurnal + riwayat aktivitas, dengan tanggal di-anchor ke waktu rekening itu pertama kali dibuat -- bukan hari ini.';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        $accounts = Account::with('company')
            ->where('initial_balance', '>', 0)
            ->get();

        $created = 0;
        $skipped = 0;

        foreach ($accounts as $account) {
            $alreadyLogged = JournalEntry::where('reference_type', 'account_opening_balance')
                ->where('reference_id', $account->id)
                ->exists();

            if ($alreadyLogged) {
                $skipped++;
                continue;
            }

            $company = $account->company;

            if (! $company) {
                $this->warn("Account #{$account->id} tidak punya company, dilewati.");
                $skipped++;
                continue;
            }

            // Prioritas 1: pakai chart_of_account_id yang sudah tersimpan
            // di baris account ini (kalau ada -- paling akurat, karena
            // itu ID asli, bukan tebakan lewat kode/nama akun).
            // Prioritas 2: cari akun bernama "Kas" di COA company ini.
            $cashAccountId = $account->chart_of_account_id
                ?? ChartOfAccount::where('company_id', $company->id)
                    ->whereRaw('LOWER(name) = ?', ['kas'])
                    ->value('id');

            // Sama untuk akun ekuitas: coba kode 3-101 dulu (default sistem),
            // fallback ke tipe 'equity' apapun kodenya.
            $equityAccountId = ChartOfAccount::where('company_id', $company->id)
                ->where('code', '3-101')
                ->value('id')
                ?? ChartOfAccount::where('company_id', $company->id)
                    ->where('type', 'equity')
                    ->value('id');

            if (! $cashAccountId || ! $equityAccountId) {
                $this->warn("Company #{$company->id} ({$company->name}): akun Kas atau Modal/Ekuitas tidak ditemukan di COA, dilewati -- perlu dicek manual.");
                $skipped++;
                continue;
            }

            // Anchor tanggal & waktu ke created_at rekening ini -- itu
            // adalah waktu SEBENARNYA saldo awal pertama kali disimpan,
            // walau baru kita sambungkan ke Buku Besar sekarang.
            $anchorDateTime = $account->created_at ?? now();
            $anchorDate = $anchorDateTime->format('Y-m-d');

            $description = 'Saldo awal - ' . ($account->bank_name ?: 'Kas');

            $this->line("Company #{$company->id} ({$company->name}): akan mencatat saldo awal Rp"
                . number_format($account->initial_balance, 0, ',', '.')
                . " pada tanggal {$anchorDate}" . ($dryRun ? ' [DRY RUN]' : ''));

            if ($dryRun) {
                $created++;
                continue;
            }

            JournalEntry::create([
                'company_id'          => $company->id,
                'chart_of_account_id' => $cashAccountId,
                'transaction_date'    => $anchorDate,
                'description'         => $description,
                'debit'               => $account->initial_balance,
                'credit'              => 0,
                'reference_type'      => 'account_opening_balance',
                'reference_id'        => $account->id,
            ]);

            JournalEntry::create([
                'company_id'          => $company->id,
                'chart_of_account_id' => $equityAccountId,
                'transaction_date'    => $anchorDate,
                'description'         => $description,
                'debit'               => 0,
                'credit'              => $account->initial_balance,
                'reference_type'      => 'account_opening_balance',
                'reference_id'        => $account->id,
            ]);

            $currencySymbol = $company->currency_symbol;

            $log = new ActivityLog([
                'user_id' => optional($company->users()->oldest()->first())->id,
                'action'       => 'set_initial_balance',
                'description'  => "Mencatat saldo awal {$currencySymbol}"
                    . number_format($account->initial_balance, 0, ',', '.')
                    . ($account->bank_name ? " di rekening {$account->bank_name}." : '.'),
                'subject_type' => Account::class,
                'subject_id'   => $account->id,
                'ip_address'   => null,
            ]);
            // Timpa timestamp default supaya tercatat di waktu ASLI
            // (waktu account dibuat), bukan waktu command ini dijalankan.
            $log->created_at = $anchorDateTime;
            $log->updated_at = $anchorDateTime;
            $log->save();

            $created++;
        }

        $this->newLine();
        $this->info("Selesai" . ($dryRun ? ' (dry run, belum ada yang benar-benar disimpan)' : '')
            . ". {$created} akun diproses, {$skipped} dilewati (sudah ada / data tidak lengkap).");

        return self::SUCCESS;
    }
}