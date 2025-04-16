<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'file_path',
        'quality',
        'size_mb'
    ];

    /**
     * Get the content that this file belongs to
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * Get the file's URL
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
} 