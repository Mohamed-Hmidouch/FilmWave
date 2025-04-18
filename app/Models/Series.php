<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id', 
        'title',
        'total_episodes',
        'views_count'
    ];

    /**
     * Get the content that owns the series.
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * Get the seasons for the series.
     */
    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    /**
     * The actors that belong to the series.
     */
    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    /**
     * Get all episodes for the series.
     */
    public function episodes()
    {
        // Utiliser hasMany avec les clés personnalisées pour la relation
        return $this->hasMany(Episode::class, 'series_id', 'id');
    }

    /**
     * Get episodes by season
     */
    public function episodesBySeason($season)
    {
        return $this->episodes()->where('season_number', $season)->orderBy('episode_number')->get();
    }

    /**
     * Load seasons with their episodes without using a direct relationship
     * Cette méthode contourne le problème de colonne season_id manquante
     */
    public function loadSeasonsWithEpisodes()
    {
        // Charger d'abord les saisons
        $this->load('seasons');
        
        // Pour chaque saison, charger manuellement les épisodes correspondants
        if ($this->seasons) {
            foreach ($this->seasons as $season) {
                // Charger les épisodes qui correspondent à cette saison
                $episodes = Episode::where('series_id', $this->id)
                                 ->where('season_number', $season->season_number)
                                 ->get();
                
                // Attacher les épisodes à la saison
                $season->setRelation('episodes', $episodes);
            }
        }
        
        return $this;
    }
}
