<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_code',
        'student_code',
        'grade_item_name',
        'grade',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_code', 'code');
    }

    public function gradeItem()
    {
        return $this->belongsTo(GradeItem::class, 'grade_item_name', 'name');
    }
}
