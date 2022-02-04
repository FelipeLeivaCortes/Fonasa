<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\LobbyController;
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

Route::get('/admin/records/unlock', [RecordController::class, 'unlock'])->name('admin.records.unlock');

Route::resource('/admin/records', RecordController::class)->names('admin.records');

Route::get('/admin/lobby', [LobbyController::class, 'index'])->name('admin.lobby.index');

Route::get('/admin/lobby/oldest', [LobbyController::class, 'oldest'])->name('admin.lobby.oldest');

Route::get('/admin/lobby/childs', [LobbyController::class, 'get_childs'])->name('admin.lobby.childs');

Route::get('/admin/lobby/critical_smokers', [LobbyController::class, 'critical_smokers'])->name('admin.lobby.critical_smokers');