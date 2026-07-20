<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntegrationController extends Controller
{
    protected function providers(): array
    {
        return [
            'whatsapp' => ['label' => 'WhatsApp Business', 'type' => 'messaging', 'desc' => 'Kirim notifikasi & faktur lewat WhatsApp.'],
            'midtrans' => ['label' => 'Midtrans', 'type' => 'payment', 'desc' => 'Terima pembayaran online otomatis.'],
            'xendit'   => ['label' => 'Xendit', 'type' => 'payment', 'desc' => 'Payment gateway alternatif.'],
            'smtp'     => ['label' => 'Email SMTP', 'type' => 'email', 'desc' => 'Kirim faktur & penawaran lewat email.'],
            'accurate' => ['label' => 'Accurate Online', 'type' => 'accounting', 'desc' => 'Sinkronisasi data akuntansi.'],
            'gdrive'   => ['label' => 'Google Drive', 'type' => 'storage', 'desc' => 'Backup dokumen otomatis.'],
        ];
    }

    public function index()
    {
        $connected = Integration::where('company_id', Auth::user()->company_id)->get()->keyBy('provider');
        $providers = $this->providers();

        return view('integrations.index', compact('connected', 'providers'));
    }

    public function create(Request $request)
    {
        $providers = $this->providers();
        $selected = $request->query('provider');

        return view('integrations.create', compact('providers', 'selected'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider'    => 'required|string',
            'name'        => 'required|string|max:255',
            'api_key'     => 'nullable|string',
            'api_secret'  => 'nullable|string',
            'webhook_url' => 'nullable|url',
        ]);

        $providers = $this->providers();
        $type = $providers[$validated['provider']]['type'] ?? 'other';

        Integration::updateOrCreate(
            ['company_id' => Auth::user()->company_id, 'provider' => $validated['provider']],
            [
                'name'         => $validated['name'],
                'type'         => $type,
                'api_key'      => $validated['api_key'] ?? null,
                'api_secret'   => $validated['api_secret'] ?? null,
                'webhook_url'  => $validated['webhook_url'] ?? null,
                'status'       => 'connected',
                'connected_at' => now(),
            ]
        );

        return redirect()->route('integrations.index')->with('success', 'Integrasi berhasil dihubungkan.');
    }

    public function edit(Integration $integration)
    {
        $providers = $this->providers();
        return view('integrations.edit', compact('integration', 'providers'));
    }

    public function update(Request $request, Integration $integration)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'api_key'     => 'nullable|string',
            'api_secret'  => 'nullable|string',
            'webhook_url' => 'nullable|url',
            'status'      => 'required|in:connected,disconnected,error',
        ]);

        $integration->update($validated);

        return redirect()->route('integrations.index')->with('success', 'Pengaturan integrasi diperbarui.');
    }

    public function destroy(Integration $integration)
    {
        $integration->delete();
        return redirect()->route('integrations.index')->with('success', 'Integrasi berhasil diputus.');
    }
}