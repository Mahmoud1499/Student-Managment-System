<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->string('course_code');
            $table->string('student_code');
            $table->timestamps();

            $table->primary(['course_code', 'student_code']);
            $table->foreign('course_code')->references('code')->on('courses');
            $table->foreign('student_code')->references('code')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
