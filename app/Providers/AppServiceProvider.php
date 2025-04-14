<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SeriesRepository;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\TagRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;

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

        // Lier l'interface TagRepositoryInterface à l'implémentation TagRepository
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        
        // Lier l'interface CategoryRepositoryInterface à l'implémentation CategoryRepository
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
