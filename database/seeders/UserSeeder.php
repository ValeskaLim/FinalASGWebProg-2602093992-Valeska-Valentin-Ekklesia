<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'username' => $faker->userName,
                'password' => Hash::make('12345678'),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'hobbies' => implode(', ', $faker->words(3)),
                'phone_number' => $faker->phoneNumber,
                'instagram_link' => $faker->unique()->url,
                'registration_price' => $faker->numberBetween(1000, 10000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
