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
        $validatedData = $this->validateCourseData($request);

        // Create a new course
        $course = Course::create($validatedData);

        // Return the created course as a response
        return response()->json($course);
    }

    /**
     * Validate the course data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function validateCourseData(Request $request)
    {
        return $request->validate([
            'code' => 'required|unique:courses',
            'name' => 'required',
            'description' => 'required',
        ]);
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
        $validatedData = $this->validateCourseData($request);

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
        if ($this->isStudentEnrolled($courseId, $studentId)) {
            return response()->json([
                'message' => 'Student is already enrolled in the course.'
            ], 422);
        }

        // Create a new enrollment record
        $this->createEnrollment($courseId, $studentId);

        return response()->json([
            'message' => 'Student added to the course successfully.'
        ]);
    }

    /**
     * Check if a student is enrolled in a course.
     *
     * @param  int  $courseId
     * @param  int  $studentId
     * @return bool
     */
    protected function isStudentEnrolled($courseId, $studentId)
    {
        return Enrollment::where('course_code', $courseId)
            ->where('student_code', $studentId)
            ->first() !== null;
    }

    /**
     * Create a new enrollment record.
     *
     * @param  int  $courseId
     * @param  int  $studentId
     */
    protected function createEnrollment($courseId, $studentId)
    {
        $enrollment = new Enrollment([
            'course_code' => $courseId,
            'student_code' => $studentId,
        ]);
        $enrollment->save();
    }

    public function removeStudent($courseId, $studentId)
    {
        // Check if the student is enrolled in the course
        if (!$this->isStudentEnrolled($courseId, $studentId)) {
            return response()->json([
                'message' => 'Student is not enrolled in the course.'
            ], 422);
        }

        // Delete the enrollment record
        $this->deleteEnrollment($courseId, $studentId);

        return response()->json([
            'message' => 'Student removed from the course successfully.'
        ]);
    }

    /**
     * Delete an enrollment record.
     *
     * @param  int  $courseId
     * @param  int  $studentId
     */
    protected function deleteEnrollment($courseId, $studentId)
    {
        $enrollment = Enrollment::where('course_code', $courseId)
            ->where('student_code', $studentId)
            ->first();
        $enrollment->delete();
    }
}