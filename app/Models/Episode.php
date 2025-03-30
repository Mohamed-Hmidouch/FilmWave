<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = ['tv_show_id', 'title', 'description', 'duration', 'season_number', 'episode_number', 'file_path'];
    
    public function tvShow()
    {
        return $this->belongsTo(TVShow::class);
    }
}
