<?php

namespace App\Console\Commands;

use App\Models\Company;
use Illuminate\Console\Command;

class ExpireSubscriptions extends Command
{
    protected $signature = 'subscriptions:expire';
    protected $description = 'Balikin company yang plan-nya expired ke paket free';

    public function handle(): void
    {
        $expired = Company::where('plan', '!=', 'free')
            ->whereNotNull('plan_expires_at')
            ->where('plan_expires_at', '<', now())
            ->get();

        foreach ($expired as $company) {
            $company->update([
                'plan' => 'free',
                'subscription_plan_id' => null,
                'plan_expires_at' => null,
            ]);

            $this->info("Company #{$company->id} ({$company->name}) diturunkan ke free.");
        }

        $this->info("Selesai. Total {$expired->count()} company diturunkan.");
    }
}