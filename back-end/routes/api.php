<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\APIStudentController;
use App\Http\Controllers\API\APICourseController;
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
Route::get('/students', [APIStudentController::class, 'index']);
Route::post('/students', [APIStudentController::class, 'store']);
Route::get('/students/{code}', [APIStudentController::class, 'show']);
Route::put('/students/{code}', [APIStudentController::class, 'update']);
Route::delete('/students/{code}', [APIStudentController::class, 'destroy']);

// Courses Management
Route::get('/courses', [APICourseController::class, 'index']);
Route::get('/courses/{code}', [APICourseController::class, 'show']);
Route::post('/courses', [APICourseController::class, 'store']);
Route::put('/courses/{code}', [APICourseController::class, 'update']);
Route::delete('/courses/{code}', [APICourseController::class, 'destroy']);

// Enrollment and Grading
// Removed unused routes

// Add student to course
Route::post('/courses/{courseId}/students/{studentId}', [APICourseController::class, 'addStudent'] );

// Remove student from course
Route::delete('/courses/{courseId}/students/{studentId}', [APICourseController::class, 'removeStudent'] );