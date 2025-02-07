<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'referral_code', 'referred_by'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->referral_code = uniqid();
        });
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function referralEarnings()
    {
        return $this->hasMany(ReferralEarning::class);
    }
}
