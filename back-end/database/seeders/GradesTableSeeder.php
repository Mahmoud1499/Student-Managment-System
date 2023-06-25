<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Course;
use App\Models\Student;
use App\Models\GradeItem;
use Faker\Factory as Faker;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        $courses = Course::all();
        $students = Student::all();
        $gradeItems = GradeItem::all();

        foreach ($courses as $course) {
            foreach ($students as $student) {
                foreach ($gradeItems as $gradeItem) {
                    Grade::create([
                        'course_code' => $course->code,
                        'student_code' => $student->code,
                        'grade_item_name' => $gradeItem->name,
                        'grade' => $faker->numberBetween(0, $gradeItem->max_degree),
                    ]);
                }
            }
        }
    }
}
