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

// Enrollment and Grading
Route::post('/courses/{code}/enrollment', [APICourseController::class, 'storeEnrollment']);
Route::delete('/courses/{code}/enrollment/{studentCode}', [APICourseController::class, 'removeEnrollment']);
Route::get('/courses/{code}/grades', [APICourseController::class, 'grades']);
