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
        Schema::create('students', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->string('email');
            $table->unsignedInteger('level_id');
            $table->timestamps();

            $table->foreign('level_id')->references('number')->on('levels');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
