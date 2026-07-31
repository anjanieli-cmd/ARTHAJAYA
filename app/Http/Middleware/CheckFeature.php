<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckFeature
{
    public function handle(Request $request, Closure $next, string $feature)
    {
        $company = auth()->user()?->company;

        if (!$company || !$company->hasFeature($feature)) {
            return redirect()->route('pricing.index')
                ->with('error', 'Fitur ini butuh upgrade paket.');
        }

        return $next($request);
    }
}