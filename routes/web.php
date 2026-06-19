<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// ===== ROOT ROUTE =====
// Redirect root URL to student list
Route::get('/', function () {
    return redirect()->route('students.index');
});

// ===== STUDENT RESOURCE ROUTES =====
Route::resource('students', StudentController::class);

// ===== BONUS: SOFT DELETE ROUTES =====
Route::get('students/trashed', [StudentController::class, 'trashed'])->name('students.trashed');
Route::patch('students/{id}/restore', [StudentController::class, 'restore'])->name('students.restore');
Route::delete('students/{id}/force-delete', [StudentController::class, 'forceDelete'])->name('students.force-delete');

// ===== AUTH ROUTES (if you installed Breeze) =====
require __DIR__.'/auth.php'; // Comment this out if you don't have auth.php