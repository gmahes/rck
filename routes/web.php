<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterController;

Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('verify', [AuthController::class, 'verify'])->middleware('guest')->name('verify');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('employees', [MasterController::class, 'employees'])->middleware('auth')->name('employees');
