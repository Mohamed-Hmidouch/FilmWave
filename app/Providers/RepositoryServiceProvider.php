<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use App\Repositories\SeriesRepositoryRepositoryEloquent;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\TagRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SeriesRepositoryInterface::class, SeriesRepositoryRepositoryEloquent::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}