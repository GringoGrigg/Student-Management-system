<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::resource('students', StudentController::class);

// Root route redirects to students index
Route::get('/', function () {
    return redirect()->route('students.index');
});