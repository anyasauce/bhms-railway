<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Boarders extends Authenticatable
{
    use HasFactory;

    protected $table = 'boarders';
    protected $fillable = ['first_name', 'last_name', 'email', 'password'];

    protected $hidden = ['password'];

    public function transactions()
    {
        return $this->hasMany(Payment::class, 'id');
    }
}
