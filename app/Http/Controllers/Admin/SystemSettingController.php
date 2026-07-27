<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    private array $keys = ['app_name', 'maintenance_mode', 'maintenance_message', 'support_email'];

    public function index()
    {
        $settings = [];
        foreach ($this->keys as $key) {
            $settings[$key] = SystemSetting::get($key);
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'app_name'            => 'required|string|max:255',
            'support_email'       => 'nullable|email',
            'maintenance_message' => 'nullable|string',
        ]);

        SystemSetting::set('app_name', $data['app_name']);
        SystemSetting::set('support_email', $data['support_email'] ?? '');
        SystemSetting::set('maintenance_message', $data['maintenance_message'] ?? '');
        SystemSetting::set('maintenance_mode', $request->boolean('maintenance_mode') ? '1' : '0');

        ActivityLog::record('update_system_settings', 'Memperbarui pengaturan sistem.');

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}