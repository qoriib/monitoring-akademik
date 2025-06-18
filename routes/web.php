<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.handle');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('students', StudentController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('achievements', AchievementController::class);

    Route::resource('classrooms', ClassroomController::class);
    Route::post('/classrooms/{classroom}/students', [ClassroomController::class, 'updateStudents'])->name('classrooms.students.update');
    Route::post('/classrooms/{classroom}/subjects', [ClassroomController::class, 'updateSubjects'])->name('classrooms.subjects.update');

    Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');
    Route::get('/scores/edit', [ScoreController::class, 'editForm'])->name('scores.edit-form');
    Route::post('/scores/edit', [ScoreController::class, 'store'])->name('scores.store');

    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/edit', [AttendanceController::class, 'editForm'])->name('attendances.edit-form');
    Route::post('/attendances/edit', [AttendanceController::class, 'store'])->name('attendances.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
