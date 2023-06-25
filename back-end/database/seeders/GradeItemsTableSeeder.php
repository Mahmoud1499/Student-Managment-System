<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GradeItem;
use Faker\Factory as Faker;

class GradeItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        $gradeItems = ['Practical Exam', 'Oral Exam', 'Midterm Exam', 'Final Exam'];

        foreach ($gradeItems as $item) {
            GradeItem::create([
                'name' => $item,
                'max_degree' => $faker->numberBetween(50, 100),
            ]);
        }
    }
}
