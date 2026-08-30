<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Paksa semua URL yang di-generate Laravel (asset(), url(), route(), dll)
        // pakai HTTPS di production, supaya nggak kena mixed content block
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Share $company otomatis ke SEMUA view, termasuk navigation.blade.php
        View::composer('*', function ($view) {
            if (Auth::check() && !$view->offsetExists('company')) {
                $view->with('company', Auth::user()->company);
            }
        });

        Blade::if('feature', function (string $key) {
            $company = Auth::check() ? Auth::user()->company : null;
            return $company && $company->hasFeature($key);
        });
    }
}