<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'boarder_id',
        'first_name',
        'last_name',
        'room_id',
        'room_name',
        'amount',
        'description',
        'payment_due_date',
        'status',
        'partial_amount',
        'checkout_session_id',
    ];

    protected $casts = [
        'payment_due_date' => 'datetime',
    ];
    public function boarder()
    {
        return $this->belongsTo(Boarder::class, 'boarder_id', 'boarder_id');
    }

}
