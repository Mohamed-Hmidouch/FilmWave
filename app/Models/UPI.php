<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UPI extends Model
{
    use HasFactory;

    protected $fillable = ['upi_id', 'ph_no'];

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payment_method');
    }
}
