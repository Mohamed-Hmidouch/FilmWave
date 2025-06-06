<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'age'];



    public function tvShows()
    {
        return $this->belongsToMany(TVShow::class);
    }
}
