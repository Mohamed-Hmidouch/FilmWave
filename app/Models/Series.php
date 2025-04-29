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


    public function content()
    {
        return $this->belongsTo(Content::class);
    }


    public function seasons()
    {
        return $this->hasMany(Season::class);
    }


    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }


    public function episodes()
    {
        return $this->hasMany(Episode::class, 'series_id', 'id');
    }


    public function episodesBySeason($season)
    {
        return $this->episodes()->where('season_number', $season)->orderBy('episode_number')->get();
    }

    public function loadSeasonsWithEpisodes()
    {
        $this->load('seasons');
        
        if ($this->seasons) {
            foreach ($this->seasons as $season) {
                $episodes = Episode::where('series_id', $this->id)
                                 ->where('season_number', $season->season_number)
                                 ->get();
                
                $season->setRelation('episodes', $episodes);
            }
        }
        
        return $this;
    }
}
