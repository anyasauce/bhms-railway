<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $fillable = [
        'boarder_id',
        'email',
        'psa_birth_cert',
        'boarder_valid_id',
        'boarder_selfie',
        'guardian_valid_id',
        'guardian_selfie',
    ];

    public function boarder()
    {
        return $this->belongsTo(Boarder::class, 'boarder_id', 'boarder_id');
    }

}
