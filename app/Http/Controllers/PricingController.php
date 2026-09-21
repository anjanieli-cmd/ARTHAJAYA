<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    /**
     * Tampilkan halaman pricing.
     *
     * Warna & ikon paket diambil langsung dari kolom `color` dan `icon`
     * di database (diisi lewat halaman admin) — tidak ada override
     * hardcode di sini, supaya apa yang diset di admin langsung
     * konsisten muncul di halaman pricing.
     */
    public function index()
    {
        $user    = Auth::user();
        $company = $user->company;

        $plans = Plan::orderBy('price')->get();

        $currentPlan = $company->plan ?? 'free';

        return view('pricing.index', compact('user', 'company', 'plans', 'currentPlan'));
    }

    public function select(Request $request, string $plan)
    {
        $exists = Plan::where('slug', $plan)->exists();

        if (!$exists && $plan !== 'free') {
            abort(404, 'Paket tidak ditemukan.');
        }

        $company = Auth::user()->company;

        $company->update([
            'plan'             => $plan,
            'plan_upgraded_at' => now(),
        ]);

        $label = $plan === 'free' ? 'kembali ke paket Free' : 'upgrade ke paket ' . ucfirst($plan);

        return redirect()->route('pricing.index')
            ->with('success', "Berhasil {$label}!");
    }
}