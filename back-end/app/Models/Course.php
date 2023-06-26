<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'code',
        'name',
        'description',
    ];
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'course_code', 'student_code');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'course_code', 'code');
    }
}
