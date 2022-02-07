<?php

use App\Http\Controllers\AwaitingRoomController;
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

Route::post('/admin/records/max_patients', [RecordController::class, 'max_patients'])->name('admin.records.max_patients');

Route::resource('/admin/records', RecordController::class)->names('admin.records');

Route::get('/admin/lobby', [LobbyController::class, 'index'])->name('admin.lobby.index');

Route::post('/admin/lobby/get_data', [LobbyController::class, 'get_data'])->name('admin.lobby.get_data');

Route::post('/admin/lobby/get_records', [LobbyController::class, 'get_records'])->name('admin.lobby.get_records');

Route::post('/admin/lobby/critical_smokers', [LobbyController::class, 'critical_smokers'])->name('admin.lobby.critical_smokers');

Route::post('/admin/lobby/optimize_attendance', [LobbyController::class, 'optimize_attendance'])->name('admin.lobby.optimize_attendance');

Route::post('/admin/lobby/attend_patient', [LobbyController::class, 'attend_patient'])->name('admin.lobby.attend_patient');

Route::post('/admin/lobby/riskiest_patients', [LobbyController::class, 'riskiest_patients'])->name('admin.lobby.riskiest_patients');

Route::get('/admin/awaiting_room', [AwaitingRoomController::class, 'index'])->name('admin.awaiting_room');

Route::post('/admin/awaiting_room/get_data', [AwaitingRoomController::class, 'get_data'])->name('admin.awaiting_room.get_data');

Route::post('/admin/awaiting_room/get_records', [AwaitingRoomController::class, 'get_records'])->name('admin.awaiting_room.get_records');