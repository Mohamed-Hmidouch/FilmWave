<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title','content_id', 'release_date', 'rating'];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    

}
