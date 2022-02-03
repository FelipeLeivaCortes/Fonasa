<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin');
});

Route::get('/admin', function () {
    return view('index');
})->name('admin');

Route::resource('/admin/hospitals', HospitalController::class)->names('admin.hospitals');

Route::resource('/admin/patients', PatientController::class)->names('admin.patients');

Route::resource('/admin/records', RecordController::class)->names('admin.records');

Route::get('/admin/critical_patients', [PatientController::class, 'critical_patients'])->name('admin.critical_patients');