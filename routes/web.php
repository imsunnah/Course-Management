<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;


Route::get('/', [AuthenticatedSessionController::class, 'create']);
Route::get('/error', function () {return view('errors.custom');})->name('error.page');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::resource('courses', CourseController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('categories/{category}/toggle', [CategoryController::class, 'toggleStatus'])->name('categories.toggle');
});

require __DIR__ . '/auth.php';
