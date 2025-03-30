<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'duration', 'genre'];


    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }

    public function movie()
    {
        return $this->hasOne(Movie::class);
    }

    public function tvShow()
    {
        return $this->hasOne(TVShow::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('value');
    }
}
