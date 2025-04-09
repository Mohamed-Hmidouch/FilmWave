<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'price','plan_type'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isPremium()
    {
        return $this->plan_type === 'premium';
    }


    public static function premium()
    {
        return self::where('plan_type', 'premium')->get();
    }

    public static function free()
    {
        return self::where('plan_type', 'free')->get();
    }
}
