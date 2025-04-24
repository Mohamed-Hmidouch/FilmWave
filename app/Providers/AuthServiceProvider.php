<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Comment;
use App\Models\Episode;
use App\Models\Playlist;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate pour vérifier si l'utilisateur peut voir la section commentaires
        Gate::define('view-comments', function (User $user) {
            return $user->isPremium();
        });

        // Gate pour vérifier si l'utilisateur peut ajouter des commentaires
        Gate::define('add-comment', function (User $user) {
            return $user->isPremium();
        });

        // Gate pour vérifier si l'utilisateur peut ajouter des épisodes à une playlist
        Gate::define('add-to-playlist', function (User $user, Episode $episode = null) {
            return $user->isPremium();
        });

        // Gate pour vérifier si l'utilisateur peut évaluer des épisodes
        Gate::define('rate-episode', function (User $user, Episode $episode = null) {
            return $user->isPremium();
        });
    }
}
