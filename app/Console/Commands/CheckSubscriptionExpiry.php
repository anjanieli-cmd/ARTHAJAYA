<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionExpiredMail;
use App\Mail\SubscriptionExpiringMail;
use App\Models\Company;
use App\Models\SubscriptionNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckSubscriptionExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek company yang langganannya mau/sudah habis, lalu kirim email pengingat ke Staff company tsb.';

    /**
     * Hari-H sebelum expired untuk kirim reminder.
     */
    private array $reminderDays = [7, 3, 1];

    public function handle(): int
    {
        $this->sendReminders();
        $this->sendExpiredNotices();

        $this->info('Selesai cek langganan.');

        return self::SUCCESS;
    }

    /**
     * Kirim email pengingat H-7, H-3, H-1 sebelum expired.
     */
    private function sendReminders(): void
    {
        foreach ($this->reminderDays as $daysLeft) {
            $targetDate = now()->addDays($daysLeft)->toDateString();

            $companies = Company::whereNotNull('plan_expires_at')
                ->whereDate('plan_expires_at', $targetDate)
                ->with('staffUsers')
                ->get();

            foreach ($companies as $company) {
                $type = "h-{$daysLeft}";

                if (SubscriptionNotification::alreadySent($company->id, $type, $company->plan_expires_at)) {
                    continue;
                }

                $recipients = $company->staffUsers->pluck('email')->filter()->unique();

                if ($recipients->isEmpty()) {
                    $this->warn("Company #{$company->id} ({$company->name}) tidak punya Staff dengan email, dilewati.");
                    continue;
                }

                try {
                    foreach ($recipients as $email) {
                        Mail::to($email)->send(new SubscriptionExpiringMail($company, $daysLeft));
                    }

                    SubscriptionNotification::markSent($company->id, $type, $company->plan_expires_at);

                    $this->line("Reminder H-{$daysLeft} terkirim ke " . $recipients->implode(', ') . " ({$company->name}).");
                } catch (\Throwable $e) {
                    Log::error("Gagal kirim reminder H-{$daysLeft} ke company #{$company->id}: " . $e->getMessage());
                    $this->error("Gagal kirim ke {$company->name}: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Kirim email pemberitahuan untuk company yang langganannya sudah expired.
     */
    private function sendExpiredNotices(): void
    {
        $companies = Company::whereNotNull('plan_expires_at')
            ->where('plan_expires_at', '<', now())
            ->with('staffUsers')
            ->get();

        foreach ($companies as $company) {
            if (SubscriptionNotification::alreadySent($company->id, 'expired', $company->plan_expires_at)) {
                continue;
            }

            $recipients = $company->staffUsers->pluck('email')->filter()->unique();

            if ($recipients->isEmpty()) {
                $this->warn("Company #{$company->id} ({$company->name}) tidak punya Staff dengan email, dilewati.");
                continue;
            }

            try {
                foreach ($recipients as $email) {
                    Mail::to($email)->send(new SubscriptionExpiredMail($company));
                }

                SubscriptionNotification::markSent($company->id, 'expired', $company->plan_expires_at);

                $this->line("Notifikasi expired terkirim ke " . $recipients->implode(', ') . " ({$company->name}).");
            } catch (\Throwable $e) {
                Log::error("Gagal kirim notif expired ke company #{$company->id}: " . $e->getMessage());
                $this->error("Gagal kirim ke {$company->name}: " . $e->getMessage());
            }
        }
    }
}