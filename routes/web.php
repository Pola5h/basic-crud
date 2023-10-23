<?php

use Illuminate\Support\Facades\Route;
use App\Models\Student;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $data = Student::latest()->paginate(5);
    return view('index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 5);
});

Route::resource('students', \App\Http\Controllers\StudentController::class);
