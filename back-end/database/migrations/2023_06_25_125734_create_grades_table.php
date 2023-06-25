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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('course_code');
            $table->string('student_code');
            $table->string('grade_item_name');
            $table->unsignedInteger('grade');
            $table->timestamps();

            $table->foreign('course_code')->references('code')->on('courses');
            $table->foreign('student_code')->references('code')->on('students');
            $table->foreign('grade_item_name')->references('name')->on('grade_items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
