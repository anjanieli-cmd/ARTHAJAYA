<?php

namespace App\Services;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;

class SmtpConfigService
{
    /**
     * Timpa config mail.mailers.smtp bawaan Laravel dengan
     * pengaturan yang disimpan admin di tabel system_settings.
     * Aman dipanggil berkali-kali, dan aman dipanggil sebelum
     * tabel system_settings ada (misal saat proses migrate).
     */
    public static function apply(): void
    {
        if (!Schema::hasTable('system_settings')) {
            return;
        }

        $host = SystemSetting::get('smtp_host');

        // Kalau admin belum isi SMTP sama sekali, biarkan Laravel pakai .env seperti biasa.
        if (empty($host)) {
            return;
        }

        $password = SystemSetting::get('smtp_password');
        if (!empty($password)) {
            try {
                $password = Crypt::decryptString($password);
            } catch (\Throwable $e) {
                $password = null;
            }
        }

        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.host', $host);
        Config::set('mail.mailers.smtp.port', SystemSetting::get('smtp_port', 587));
        Config::set('mail.mailers.smtp.username', SystemSetting::get('smtp_username'));
        Config::set('mail.mailers.smtp.password', $password);

        $encryption = SystemSetting::get('smtp_encryption', 'tls');
        Config::set('mail.mailers.smtp.encryption', $encryption === 'none' ? null : $encryption);

        Config::set('mail.from.address', SystemSetting::get('smtp_from_address') ?: config('mail.from.address'));
        Config::set('mail.from.name', SystemSetting::get('smtp_from_name') ?: config('mail.from.name'));
    }
}