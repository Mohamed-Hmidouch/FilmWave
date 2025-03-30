<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['content_id', 'user_id', 'value'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
