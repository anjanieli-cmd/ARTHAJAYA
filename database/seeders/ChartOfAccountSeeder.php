<?php

namespace Database\Seeders;

use App\Models\ChartOfAccount;
use App\Models\Company;
use Illuminate\Database\Seeder;

class ChartOfAccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            // Aset
            ['code' => '1-101', 'name' => 'Kas', 'type' => 'asset', 'normal_balance' => 'debit'],
            ['code' => '1-102', 'name' => 'Bank', 'type' => 'asset', 'normal_balance' => 'debit'],
            ['code' => '1-103', 'name' => 'Piutang Usaha', 'type' => 'asset', 'normal_balance' => 'debit'],
            ['code' => '1-104', 'name' => 'Persediaan', 'type' => 'asset', 'normal_balance' => 'debit'],

            // Kewajiban
            ['code' => '2-101', 'name' => 'Utang Usaha', 'type' => 'liability', 'normal_balance' => 'credit'],
            ['code' => '2-102', 'name' => 'Utang Pajak', 'type' => 'liability', 'normal_balance' => 'credit'],

            // Modal
            ['code' => '3-101', 'name' => 'Modal Pemilik', 'type' => 'equity', 'normal_balance' => 'credit'],

            // Pendapatan
            ['code' => '4-101', 'name' => 'Pendapatan Jasa', 'type' => 'revenue', 'normal_balance' => 'credit'],

            // Biaya
            ['code' => '5-101', 'name' => 'Biaya Operasional', 'type' => 'expense', 'normal_balance' => 'debit'],
            ['code' => '5-102', 'name' => 'Biaya Gaji', 'type' => 'expense', 'normal_balance' => 'debit'],
            ['code' => '5-103', 'name' => 'Biaya Sewa', 'type' => 'expense', 'normal_balance' => 'debit'],
        ];

        // Bikinin akun default ini untuk SETIAP company yang udah ada
        Company::all()->each(function ($company) use ($accounts) {
            foreach ($accounts as $acc) {
                ChartOfAccount::firstOrCreate(
                    ['company_id' => $company->id, 'code' => $acc['code']],
                    $acc
                );
            }
        });
    }
}