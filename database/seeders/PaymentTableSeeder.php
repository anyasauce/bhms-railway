<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use Faker\Factory as Faker;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $roomIds = \App\Models\Room::pluck('id')->toArray();
        $rooms = \App\Models\Room::pluck('room_name')->toArray();

        for ($i = 0; $i < 20; $i++) {
            Payment::create([
                'name' => $faker->name,
                'room_id' => $faker->randomElement($roomIds),
                'room_name' => $faker->randomElement($rooms),
                'amount' => $faker->randomFloat(2, 1500, 2000),
                'description' => $faker->sentence,
                'payment_due_date' => $faker->date,
                'status' => $faker->randomElement(['pending', 'paid']),
            ]);
        }
    }
}
