<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $company = $user->company;

        // Ambil semua plan aktif dari database, urut dari harga terendah
        $plans = SubscriptionPlan::where('is_active', true)
            ->orderBy('price')
            ->get();

        // Plan yang sedang aktif di company ini
        $currentPlan = $company->plan ?? 'free';

        return view('pricing.index', compact('user', 'company', 'plans', 'currentPlan'));
    }

    public function select(Request $request, string $plan)
    {
        $exists = SubscriptionPlan::where('slug', $plan)->where('is_active', true)->exists();

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