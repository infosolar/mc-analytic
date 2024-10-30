<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_SCHEMA_SECURE', true) === true) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        } else {
            \Illuminate\Support\Facades\URL::forceScheme('http');
        }
    }
}
