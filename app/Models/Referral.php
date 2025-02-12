<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = ['referrer_id', 'referred_application_id', 'points'];

    public function referrer()
    {
        return $this->belongsTo(Boarder::class, 'referrer_id', 'boarder_id');
    }

    public function referredApplication()
    {
        return $this->belongsTo(Application::class, 'referred_application_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'referred_application_id');
    }
}
