<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    /**
     * Les contenus qui appartiennent à cette catégorie.
     */
    public function contents()
    {
        return $this->belongsToMany(Content::class);
    }
}
