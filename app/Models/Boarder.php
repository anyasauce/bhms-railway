<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Boarder extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'boarder_id',
        'first_name',
        'last_name',
        'password',
        'room_id',
        'phone_number',
        'email',
        'guardian_name',
        'guardian_phone_number',
        'address',
        'balance',
        'reset_token',
        'referral_code',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'boarder_id', 'boarder_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'boarder_id');
    }

    public function documents()
    {
        return $this->hasOne(Documents::class, 'boarder_id', 'boarder_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'referral_code', 'referral_code');
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }
    public function referredApplications()
    {
        return $this->hasManyThrough(
            Application::class,
            Referral::class,
            'referrer_id',
            'id',
            'boarder_id',
            'referred_application_id'
        );
    }



}
