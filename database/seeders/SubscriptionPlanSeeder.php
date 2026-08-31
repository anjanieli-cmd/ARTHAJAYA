<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name'           => 'Free',
                'slug'           => 'free',
                'description'    => "Akses semua fitur dasar\nLaporan keuangan\nManajemen klien",
                'price'          => 0,
                'billing_period' => 'monthly',
                'max_users'      => 1,
                'is_active'      => true,
                'color'          => '#6366f1',
                'icon'           => 'i-zap',
            ],
            [
                'name'           => 'Silver',
                'slug'           => 'silver',
                'description'    => "Invoice & penawaran\nPiutang & utang\nRekonsiliasi bank",
                'price'          => 150000,
                'billing_period' => 'monthly',
                'max_users'      => 3,
                'is_active'      => true,
                'color'          => '#818cf8',
                'icon'           => 'i-star',
            ],
            [
                'name'           => 'Gold',
                'slug'           => 'gold',
                'description'    => "Semua fitur Silver\nPayroll karyawan\nAnggaran & forecast\nAkses multi-user",
                'price'          => 350000,
                'billing_period' => 'monthly',
                'max_users'      => 10,
                'is_active'      => true,
                'color'          => '#f59e0b',
                'icon'           => 'i-diamond',
            ],
            [
                'name'           => 'Platinum',
                'slug'           => 'platinum',
                'description'    => "Semua fitur Gold\nInventaris & stok\nMulti-user tanpa batas\nDukungan prioritas",
                'price'          => 750000,
                'billing_period' => 'monthly',
                'max_users'      => null,
                'is_active'      => true,
                'color'          => '#a855f7',
                'icon'           => 'i-rocket',
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}