<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'type'];

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payment_method');
    }
}
