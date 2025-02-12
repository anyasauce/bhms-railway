<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'josiahdanielle09gallenero@gmail.com'],
            [
                'name' => 'Josiah Danielle Gallenero',
                'password' => Hash::make('123123123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
