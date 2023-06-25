<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use Faker\Factory as Faker;
class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) {
            Course::create([
                'code' => 'C00' . $i,
                'name' => $faker->word . ' Course',
                'description' => $faker->sentence,
            ]);
        }
    }
}
