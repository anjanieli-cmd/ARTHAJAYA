<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = $user->company;

        return view('pricing.index', compact('user', 'company'));
    }

    public function select(Request $request, string $plan)
    {
        if (!in_array($plan, ['free', 'platinum', 'gold'])) {
            abort(404);
        }

        $company = Auth::user()->company;

        $company->update([
            'plan' => $plan,
            'plan_upgraded_at' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', "Berhasil " . ($plan === 'free' ? 'kembali ke' : 'upgrade ke') . " paket " . ucfirst($plan) . "!");
    }
}