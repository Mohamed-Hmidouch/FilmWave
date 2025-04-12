<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use App\Repositories\SeriesRepositoryRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SeriesRepositoryInterface::class, SeriesRepositoryRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}