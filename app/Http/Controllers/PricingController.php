<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    protected array $planStyles = [
        'free'    => ['color' => '#6366f1', 'icon' => 'i-zap'],
        'silver'  => ['color' => '#94a3b8', 'icon' => 'i-star'],
        'gold'    => ['color' => '#f59e0b', 'icon' => 'i-diamond'],
    ];

    public function index()
    {
        $user    = Auth::user();
        $company = $user->company;

        $plans = Plan::orderBy('price')->get()->map(function ($plan) {
            $style = $this->planStyles[$plan->slug] ?? ['color' => '#6366f1', 'icon' => 'i-zap'];
            $plan->color = $style['color'];
            $plan->icon  = $style['icon'];
            return $plan;
        });

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