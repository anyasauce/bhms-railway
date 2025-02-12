<?php

// Room.php model
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['room_name', 'slots', 'status', 'price', 'room_image'];

    public function boarders()
    {
        return $this->hasMany(Boarder::class);
    }
}

