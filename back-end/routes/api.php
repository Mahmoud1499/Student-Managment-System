<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\CourseController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Students Management
Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{code}', [StudentController::class, 'show']);
Route::put('/students/{code}', [StudentController::class, 'update']);
Route::delete('/students/{code}', [StudentController::class, 'destroy']);

// Courses Management
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{code}', [CourseController::class, 'show']);

// Enrollment and Grading
Route::post('/courses/{code}/enrollment', [CourseController::class, 'storeEnrollment']);
Route::delete('/courses/{code}/enrollment/{studentCode}', [CourseController::class, 'removeEnrollment']);
Route::get('/courses/{code}/grades', [CourseController::class, 'grades']);
