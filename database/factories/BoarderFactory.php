<?php

namespace Database\Factories;

use App\Models\Boarder;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoarderFactory extends Factory
{
    protected $model = Boarder::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'room_id' => \App\Models\Room::factory(),
            'phone_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'guardian_name' => $this->faker->name(),
            'guardian_phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'balance' => $this->faker->randomFloat(2, 0, 5000),
        ];
    }
}
