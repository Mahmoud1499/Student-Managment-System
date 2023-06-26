<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'number');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'student_code', 'course_code');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_code', 'code');
    }
}
