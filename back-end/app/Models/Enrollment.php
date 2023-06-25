<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'course_code',
        'student_code',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_code', 'code');
    }
}
