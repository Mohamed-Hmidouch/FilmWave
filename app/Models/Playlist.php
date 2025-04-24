<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id', 'is_public'];

    /**
     * Obtenir l'utilisateur propriétaire de cette playlist
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir tous les contenus de cette playlist
     */
    public function contents()
    {
        return $this->belongsToMany(Content::class, 'content_playlist')
                    ->withTimestamps();
    }

    /**
     * Alias pour ajouter un contenu à la playlist
     */
    public function addContent($contentId)
    {
        return $this->contents()->attach($contentId);
    }

    /**
     * Alias pour retirer un contenu de la playlist
     */
    public function removeContent($contentId)
    {
        return $this->contents()->detach($contentId);
    }
} 