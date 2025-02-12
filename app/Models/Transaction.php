<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'boarder_id',
        'type',
        'amount',
        'description',
        'created_at',
        'updated_at',
    ];
    public function boarder()
    {
        return $this->belongsTo(Boarder::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
