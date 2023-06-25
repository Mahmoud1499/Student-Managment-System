<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            Student::create([
                'code' => $faker->unique()->randomNumber(7),
                'full_name' => $faker->name,
                'date_of_birth' => $faker->date(),
                'email' => $faker->email,
                'level_id' => $faker->numberBetween(1, 4),
            ]);
        }
    }
}
