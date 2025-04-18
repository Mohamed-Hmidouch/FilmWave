<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
        'season_number',
        'title',
        'description',
        'release_date',
    ];

    /**
     * Get the series that owns the season.
     */
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    /**
     * Get the episodes for this season.
     * Cette relation utilise une approche personnalisée pour le chargement eager
     */
    public function episodes()
    {
        return (new HasMany(
            Episode::query(),
            $this,
            'season_number',
            'season_number'
        ))->where('series_id', $this->series_id);
    }

    protected function scopeWithEpisodes($query)
    {
        return $query->with(['episodes' => function($q) {
            $q->where('series_id', $this->series_id);
        }]);
    }
}