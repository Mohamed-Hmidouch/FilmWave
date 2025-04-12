<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;


    protected $fillable = [
        'content_id', 
        'seasons',
        'total_episodes',
    ];

    /**
     * Get the content that owns the series.
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * The actors that belong to the series.
     */
    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    /**
     * Get episodes by season
     */
    public function episodesBySeason($season)
    {
        return $this->episodes()->where('season_number', $season)->orderBy('episode_number')->get();
    }
}
