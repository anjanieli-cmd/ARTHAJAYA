<?php

namespace Database\Seeders;

use App\Models\ChartOfAccount;
use App\Models\Company;
use Illuminate\Database\Seeder;

/**
 * COA yang aktif sekarang cuma punya 6 akun (1-101 Aset Tetap, 1-102 Kas,
 * 2-101 Utang Usaha, 3-101 Modal Pemilik, 4-101 Pendapatan Penjualan,
 * 5-101 Biaya Operasional). Kode 1-103, 1-104, dan 2-102 BELUM dipakai
 * sama sekali, jadi aman ditambahkan tanpa bentrok dengan data yang ada.
 *
 * Ini beda dari ChartOfAccountSeeder lama -- seeder lama pakai kode 1-101
 * untuk "Kas" dan 1-102 untuk "Bank", yang sekarang sudah tidak sesuai
 * dengan kode asli di database (1-101 = Aset Tetap, 1-102 = Kas). Jangan
 * jalankan ChartOfAccountSeeder lama lagi -- pakai seeder ini saja.
 *
 * Jalankan dengan:
 *   php artisan db:seed --class=MissingArApAccountsSeeder
 */
class MissingArApAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['code' => '1-103', 'name' => 'Piutang Usaha', 'type' => 'asset', 'normal_balance' => 'debit'],
            ['code' => '1-104', 'name' => 'Persediaan', 'type' => 'asset', 'normal_balance' => 'debit'],
            ['code' => '2-102', 'name' => 'Utang Pajak', 'type' => 'liability', 'normal_balance' => 'credit'],
        ];

        Company::all()->each(function ($company) use ($accounts) {
            foreach ($accounts as $acc) {
                ChartOfAccount::firstOrCreate(
                    ['company_id' => $company->id, 'code' => $acc['code']],
                    array_merge($acc, ['is_active' => true])
                );
            }
        });
    }
}