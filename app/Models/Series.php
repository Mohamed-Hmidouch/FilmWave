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
        return $this->hasManyThrough(Episode::class, Season::class);
    }

    /**
     * Get episodes by season
     */
    public function episodesBySeason($season)
    {
        return $this->episodes()->where('season_number', $season)->orderBy('episode_number')->get();
    }
}
