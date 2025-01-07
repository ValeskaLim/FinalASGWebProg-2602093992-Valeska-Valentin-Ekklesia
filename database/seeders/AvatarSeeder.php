<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $i) {
            $imageUrl = "https://dummyimage.com/100x100/000/fff&text=Avatar$i";

            DB::table('avatars')->insert([
                'name' => $faker->unique()->firstName() . ' Avatar',
                'image_url' => $imageUrl,
                'price' => $faker->numberBetween(10, 100000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
