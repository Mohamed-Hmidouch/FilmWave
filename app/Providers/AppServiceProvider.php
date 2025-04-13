<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SeriesRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SeriesRepository::class, function ($app) {
            return new SeriesRepository();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
