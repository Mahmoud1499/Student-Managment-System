<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;

class StudentTest extends TestCase
{
    /**
     * Test adding a student.
     */
    public function test_add_student()
    {
        $student = new Student();
        $student->name = 'Test Student';
        $student->save();
    
        $this->assertDatabaseHas('students', ['name' => 'Test Student']);
    }

    /**
     * Test editing a student.
     */
    public function test_edit_student()
    {
        $student = new Student();
        $student->name = 'Test Student';
        $student->save();
    
        $student->name = 'Edited Test Student';
        $student->save();
    
        $this->assertDatabaseHas('students', ['name' => 'Edited Test Student']);
    }

    /**
     * Test deleting a student.
     */
    public function test_delete_student()
    {
        $student = new Student();
        $student->name = 'Test Student';
        $student->save();
    
        $student->delete();
    
        $this->assertDatabaseMissing('students', ['name' => 'Test Student']);
    }
}