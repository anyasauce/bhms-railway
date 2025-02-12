<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Boarder;
use Faker\Factory as Faker;

class BoardersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $roomIds = \App\Models\Room::pluck('id')->toArray();

        for ($i = 0; $i < 20; $i++) {
            Boarder::create([
                'first_name' => $faker->first_name,
                'last_name' => $faker->last_name,
                'password' => $faker->password,
                'phone_number' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'guardian_name' => $faker->name,
                'guardian_phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'room_id' => $faker->randomElement($roomIds),
            ]);
        }
    }


}
