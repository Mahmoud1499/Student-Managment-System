<?php

namespace Tests\Feature;

use Tests\TestCase;

class CourseTest extends TestCase
{
    /**
     * Test adding a course.
     */
    public function test_add_course()
    {
        $course = new Course();
        $course->name = 'Test Course';
        $course->save();
    
        $this->assertDatabaseHas('courses', ['name' => 'Test Course']);
    }

    /**
     * Test editing a course.
     */
    public function test_edit_course()
    {
        $course = new Course();
        $course->name = 'Test Course';
        $course->save();
    
        $course->name = 'Edited Test Course';
        $course->save();
    
        $this->assertDatabaseHas('courses', ['name' => 'Edited Test Course']);
    }

    /**
     * Test deleting a course.
     */
    public function test_delete_course()
    {
        $course = new Course();
        $course->name = 'Test Course';
        $course->save();
    
        $course->delete();
    
        $this->assertDatabaseMissing('courses', ['name' => 'Test Course']);
    }
}