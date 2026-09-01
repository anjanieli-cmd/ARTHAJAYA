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

        // Route yang dikecualikan dari redirect ke onboarding
        $excludedRoutes = [
            'onboarding.*',
            'payment.checkout',
            'payment.process',
            'midtrans.notification', // webhook, request-nya dari server Midtrans bukan user login
        ];

        if ($user && !$user->company_id && !$request->routeIs($excludedRoutes)) {
            return redirect()->route('onboarding.show');
        }

        return $next($request);
    }
}