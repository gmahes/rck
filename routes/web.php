<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\OperasionalController;

Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('verify', [AuthController::class, 'verify'])->middleware('guest')->name('verify');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('employees', [MasterController::class, 'employees'])->middleware(['auth', 'administrator'])->name('employees');
Route::post('add-employee', [MasterController::class, 'addEmployee'])->middleware('auth')->name('add-employee');
Route::put('edit-employee/{username}', [MasterController::class, 'editEmployee'])->middleware('auth')->name('edit-employee');
Route::delete('del-employee/{username}', [MasterController::class, 'delEmployee'])->middleware('auth')->name('del-employee');
Route::patch('reset-password/{username}', [MasterController::class, 'resetPassword'])->middleware('auth')->name('reset-password');
Route::post('change-password/{username}', [DashboardController::class, 'changePassword'])->middleware('auth')->name('change-password');
Route::get('omzet', [OperasionalController::class, 'omzet'])->middleware('auth')->name('omzet');
Route::get('drivers', [MasterController::class, 'drivers'])->middleware('auth')->name('drivers');
Route::post('add-driver', [MasterController::class, 'addDriver'])->middleware('auth')->name('add-driver');
Route::put('edit-driver/{id}', [MasterController::class, 'editDriver'])->middleware('auth')->name('edit-driver');
Route::delete('del-driver/{id}', [MasterController::class, 'delDriver'])->middleware('auth')->name('del-driver');
Route::get('dummy', [DashboardController::class, 'dummy'])->middleware('auth')->name('dummy');
Route::post('add-omzet', [OperasionalController::class, 'addOmzet'])->middleware('auth')->name('add-omzet');
