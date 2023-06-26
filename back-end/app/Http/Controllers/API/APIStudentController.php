<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Models\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIStudentController extends Controller
{
    //
    public function index()
    {
        // Retrieve all students
        $students = Student::withoutTrashed()->get();

        // Return the students as a response
        return response()->json($students);
    }

    public function show($id)
    {
        // Find the course by ID
        $course = Course::findOrFail($id);

        // Get all enrolled students with their grades for the course
        $students = $course->students()->with('grades')->get();

        // Prepare the data for the table
        $tableData = [];
        $gradeItems = $course->gradeItems;

        // Set the table headers
        $tableHeaders = ['Student Full Name', 'Student Code'];
        foreach ($gradeItems as $gradeItem) {
            $tableHeaders[] = $gradeItem->name;
        }
        $tableHeaders[] = 'Total';

        // Populate the table rows
        foreach ($students as $student) {
            $rowData = [
                $student->full_name,
                $student->code,
            ];

            $totalGrade = 0;
            foreach ($gradeItems as $gradeItem) {
                $grade = $student->grades->where('grade_item_id', $gradeItem->id)->first();
                $gradeValue = $grade ? $grade->grade : '-';
                $rowData[] = $gradeValue;
                $totalGrade += $gradeValue;
            }
            $rowData[] = $totalGrade;

            $tableData[] = $rowData;
        }

        // Return the table data as a response
        return response()->json([
            'headers' => $tableHeaders,
            'data' => $tableData,
        ]);
    }


    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'code' => 'required|unique:students',
            'full_name' => 'required',
            'date_of_birth' => 'required|date',
            'email' => 'required|email',
            'level_id' => 'required|exists:levels,id',
        ]);

        // Create a new student record
        $student = Student::create($validatedData);

        // Return the created student as a response
        return response()->json($student, 201);
    }

    public function update(Request $request, $id)
    {
        // Find the student by ID
        $student = Student::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'code' => 'required|unique:students,code,' . $student->id,
            'full_name' => 'required',
            'date_of_birth' => 'required|date',
            'email' => 'required|email',
            'level_id' => 'required|exists:levels,id',
        ]);

        // Update the student record
        $student->update($validatedData);

        // Return the updated student as a response
        return response()->json($student);
    }

    public function destroy($id)
    {
        // Find the student by ID
        $student = Student::findOrFail($id);

        // Soft delete the student record
        $student->delete();

        // Return a success response
        return response()->json(['message' => 'Student deleted successfully']);
    }


    // Add additional methods for filtering and searching students here

}
