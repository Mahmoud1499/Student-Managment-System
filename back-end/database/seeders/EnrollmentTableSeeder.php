<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Student;
use Faker\Factory as Faker;
class EnrollmentTableSeeder extends Seeder
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

        foreach ($courses as $course) {
            // Randomly select a number of students to enroll in the course
            $numStudents = $faker->numberBetween(1, $students->count());

            // Get a random subset of students
            $enrolledStudents = $students->random($numStudents);

            $course->students()->attach($enrolledStudents);
        }
    }
}
