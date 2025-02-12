<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'referral_code',
        'status',
    ];

    protected $table = 'applications';


    public function boarder()
    {
        return $this->belongsTo(Boarder::class, 'referral_code', 'referral_code');
    }
}
