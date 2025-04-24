<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use App\Repositories\SeriesRepository; // غير مستخدم بعد الآن
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\TagRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Services\CommentService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // تم نقل تسجيل مستودع السلسلات إلى RepositoryServiceProvider
        // ونستخدم الآن SeriesRepositoryInterface بدلاً من SeriesRepository

        // Lier l'interface TagRepositoryInterface à l'implémentation TagRepository
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        
        // Lier l'interface CategoryRepositoryInterface à l'implémentation CategoryRepository
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        
        // Enregistrer le service de commentaires
        $this->app->singleton(CommentService::class, function ($app) {
            return new CommentService();
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
