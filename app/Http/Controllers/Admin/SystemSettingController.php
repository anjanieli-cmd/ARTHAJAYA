<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class SystemSettingController extends Controller
{
    private array $keys = [
        'app_name', 'maintenance_mode', 'maintenance_message', 'support_email',
        'smtp_host', 'smtp_port', 'smtp_username', 'smtp_encryption',
        'smtp_from_address', 'smtp_from_name',
    ];

    public function index()
    {
        $settings = [];
        foreach ($this->keys as $key) {
            $settings[$key] = SystemSetting::get($key);
        }

        // Password nggak pernah dikirim balik ke form dalam bentuk asli.
        // Cukup kasih tau form-nya "udah ada password tersimpan" atau belum.
        $settings['smtp_password_set'] = !empty(SystemSetting::get('smtp_password'));

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'app_name'            => 'required|string|max:255',
            'support_email'       => 'nullable|email',
            'maintenance_message' => 'nullable|string',

            'smtp_host'          => 'nullable|string|max:255',
            'smtp_port'          => 'nullable|integer',
            'smtp_username'      => 'nullable|string|max:255',
            'smtp_password'      => 'nullable|string|max:255',
            'smtp_encryption'    => 'nullable|in:tls,ssl,none',
            'smtp_from_address'  => 'nullable|email',
            'smtp_from_name'     => 'nullable|string|max:255',
        ]);

        SystemSetting::set('app_name', $data['app_name']);
        SystemSetting::set('support_email', $data['support_email'] ?? '');
        SystemSetting::set('maintenance_message', $data['maintenance_message'] ?? '');
        SystemSetting::set('maintenance_mode', $request->boolean('maintenance_mode') ? '1' : '0');

        SystemSetting::set('smtp_host', $data['smtp_host'] ?? '');
        SystemSetting::set('smtp_port', $data['smtp_port'] ?? '');
        SystemSetting::set('smtp_username', $data['smtp_username'] ?? '');
        SystemSetting::set('smtp_encryption', $data['smtp_encryption'] ?? 'tls');
        SystemSetting::set('smtp_from_address', $data['smtp_from_address'] ?? '');
        SystemSetting::set('smtp_from_name', $data['smtp_from_name'] ?? '');

        // Password cuma di-update kalau field-nya diisi (nggak dikosongin admin nggak sengaja)
        if (!empty($data['smtp_password'])) {
            SystemSetting::set('smtp_password', Crypt::encryptString($data['smtp_password']));
        }

        ActivityLog::record('update_system_settings', 'Memperbarui pengaturan sistem.');

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function testSmtp(Request $request)
    {
        $request->validate(['test_email' => 'required|email']);

        try {
            \App\Services\SmtpConfigService::apply();

            Mail::raw('Ini email percobaan dari pengaturan SMTP Arvessa. Kalau kamu menerima ini, berarti SMTP-nya sudah benar.', function ($message) use ($request) {
                $message->to($request->test_email)->subject('Test SMTP - Arvessa');
            });

            return back()->with('success', 'Email test berhasil dikirim ke ' . $request->test_email . '.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal mengirim email test: ' . $e->getMessage());
        }
    }
}