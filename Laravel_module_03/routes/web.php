php<?php

use Illuminate\Support\Facades\Route;
use App\Models\Employee;

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
    return view('welcome');
});

Route::get('/test_database', function () {

  $employee = new Employee;
    $employee->name = 'John Smith';
    $employee->email = 'john.smith@example.com';
    $employee->password = 'pass';
    $employee->save();
    return 'Employee added to database';


});

