<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $primaryKey = 'number';
    public $incrementing = false;
    protected $keyType = 'integer';

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
