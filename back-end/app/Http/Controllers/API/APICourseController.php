<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;
// use App\Models\Student;

class APICourseController extends Controller
{
    public function index()
    {
        // Retrieve all courses
        $courses = Course::all();

        // Return the courses as a response
        return response()->json($courses);
    }
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'code' => 'required|unique:courses',
            'name' => 'required',
            'description' => 'required',
        ]);

        // Create a new course
        $course = Course::create($validatedData);

        // Return the created course as a response
        return response()->json($course);
    }



    public function show($id)
    {
        $course = Course::with(['students' => function ($query) use ($id) {
            $query->whereHas('courses', function ($query) use ($id) {
                $query->where('course_code', $id);
            });
        }, 'students.grades' => function ($query) use ($id) {
            $query->where('course_code', $id);
        }, 'grades'])->findOrFail($id);

        // Prepare the response data
        $responseData = [
            'course' => $course,
            'students' => $course->students->map(function ($student) use ($id) {
                $grades = $student->grades->filter(function ($grade) use ($id) {
                    return $grade->course_code == $id;
                })->mapWithKeys(function ($grade) {
                    return [$grade->gradeItem->name => $grade->grade];
                })->all();

                return [
                    'id' => $student->id,
                    'name' => $student->full_name,
                    'code' => $student->code,
                    'grades' => $grades,
                ];
            }),
        ];

        return response()->json($responseData);
    }

    public function update(Request $request, $code)
    {
        // Find the course by code
        $course = Course::where('code', $code)->firstOrFail();

        // Validate the request data
        $validatedData = $request->validate([
            'code' => 'required|unique:courses,code,' . $code . ',code',
            'name' => 'required',
            'description' => 'required',
        ]);

        // Update the course
        $course->update($validatedData);

        // Return the updated course as a response
        return response()->json($course);
    }


    public function enrollStudent(Request $request, $id)
    {
        // Find the course by ID
        $course = Course::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        // Enroll the student in the course
        $course->students()->attach($validatedData['student_id']);

        // Return a success response
        return response()->json(['message' => 'Student enrolled successfully']);
    }


    public function grades($id)
    {
        // Find the course by ID with the enrolled students and their grades
        $course = Course::with('students.grades')->findOrFail($id);

        // Return the course with grades as a response
        return response()->json($course);
    }

    // Add additional methods for specific course functionality here
    public function addStudent($courseId, $studentId)
    {
        $course = Course::findOrFail($courseId);
        $student = Student::findOrFail($studentId);

        // Check if the student is already enrolled in the course
        $enrollment = Enrollment::where('course_code', $courseId)
            ->where('student_code', $studentId)
            ->first();

        if ($enrollment) {
            return response()->json([
                'message' => 'Student is already enrolled in the course.'
            ], 422);
        }

        // Create a new enrollment record
        $enrollment = new Enrollment([
            'course_code' => $courseId,
            'student_code' => $studentId,
        ]);
        $enrollment->save();

        return response()->json([
            'message' => 'Student added to the course successfully.'
        ]);
    }

    public function removeStudent($courseId, $studentId)
    {
        $course = Course::findOrFail($courseId);
        $student = Student::findOrFail($studentId);

        // Find and delete the enrollment record
        $enrollment = Enrollment::where('course_code', $courseId)
            ->where('student_code', $studentId)
            ->first();

        if (!$enrollment) {
            return response()->json([
                'message' => 'Student is not enrolled in the course.'
            ], 422);
        }

        $enrollment->delete();

        return response()->json([
            'message' => 'Student removed from the course successfully.'
        ]);
    }
}
