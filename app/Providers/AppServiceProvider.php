<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (! empty($user->gemini_api_key)) {
                config(['gemini.api_key' => $user->gemini_api_key]);
            }
        }
    }
}
