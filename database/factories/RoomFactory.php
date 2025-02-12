<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        return [
            'room_name' => 'Room ' . $this->faker->unique()->numberBetween(1, 100),
            'slots' => $this->faker->numberBetween(1, 4),
            'status' => 'available',
            'price' => $this->faker->randomFloat(2, 500, 5000),
        ];
    }
}
