<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * Get the episodes for the season.
     */
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
} 