<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureOnboardingComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Kalau user belum punya company_id, redirect ke onboarding
        if ($user && !$user->company_id && !$request->routeIs('onboarding.*')) {
            return redirect()->route('onboarding.show');
        }

        return $next($request);
    }
}