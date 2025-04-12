<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'release_year',
        'duration',
        'type',
        'cover_image',
        'maturity_rating',
        'views_count'
    ];

    public function series()
    {
        return $this->hasOne(Series::class);
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

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('value');
    }
}
