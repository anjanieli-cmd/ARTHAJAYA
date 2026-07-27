<?php

namespace App\Http\Middleware;

use App\Enums\AccessLevel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasAccessLevel
{
    /**
     * Contoh pemakaian di routes:
     * ->middleware('access:admin')
     * ->middleware('access:admin,staff')
     */
    public function handle(Request $request, Closure $next, ...$levels)
    {
        if (!Auth::check()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $userLevel = Auth::user()->access_level; // instance AccessLevel enum

        $allowed = array_map(fn ($l) => AccessLevel::from($l), $levels);

        if (!in_array($userLevel, $allowed)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}