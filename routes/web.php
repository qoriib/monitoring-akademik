<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Models\Achievement;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.handle');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'studentCount' => Student::count(),
            'subjectCount' => Subject::count(),
            'scoreCount' => Score::count(),
            'achievementCount' => Achievement::count(),
        ]);
    })->name('dashboard');
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('students', StudentController::class);
    Route::resource('scores', ScoreController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('achievements', AchievementController::class);
});
