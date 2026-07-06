<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
        // Share konfigurasi info situs (nama, telp, alamat, ig, wa) ke semua
        // view, menggantikan $GLOBALS['siteConfig'] di project PHP native.
        View::share('siteConfig', config('site'));
    }
}
