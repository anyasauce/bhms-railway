<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use Faker\Factory as Faker;
class RoomsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            Room::create([
                'room_name' => 'Room ' . $faker->unique()->numberBetween(100, 999),
                'slots' => $faker->numberBetween(1, 10),
                'price' => $faker->randomFloat(2, 1000, 2000),
            ]);
        }
    }

}
