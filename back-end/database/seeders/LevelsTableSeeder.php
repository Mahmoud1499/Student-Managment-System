<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;
use Faker\Factory as Faker;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        for ($i = 1; $i <= 4; $i++) {
            Level::create([
                'number' => $i,
                'name' => 'Level ' . $i,
                'description' => $faker->sentence,
            ]);
        }
    }
}
