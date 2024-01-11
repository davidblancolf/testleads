<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Http::macro('scoring', function () {
            return Http::withHeaders([
                "Content-Type"=> "application/json",
                "cache-control"=> "no-cache"])
                ->timeout(config("scoring.timeout"))
                ->baseUrl(config('scoring.host'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
