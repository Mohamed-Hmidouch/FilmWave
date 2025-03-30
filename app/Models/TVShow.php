<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TVShow extends Model
{
    use HasFactory;

    protected $fillable = ['content_id', 'seasons', 'episodes', 'current_episode'];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    public function episodes()
{
    return $this->hasMany(Episode::class);
}
}
