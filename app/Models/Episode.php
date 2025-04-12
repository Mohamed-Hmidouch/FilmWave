<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
        'title',
        'description',
        'season_number',
        'episode_number',
        'file_path',
        'release_date',
        'views_count'
    ];    

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    /**
     * Get the episode's video URL
     */
    public function getVideoUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
