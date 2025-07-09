<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\HelpdeskController;

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
Route::get('dummy', [DashboardController::class, 'dummy'])->middleware('auth')->name('dummy');
Route::get('complaint', [HelpdeskController::class, 'complaint'])->middleware('auth')->name('complaint');
Route::patch('confirm-complaint', [HelpdeskController::class, 'confirmComplaint'])->middleware('auth')->name('confirm-complaint');
Route::post('add-complaint', [HelpdeskController::class, 'saveComplaint'])->middleware('auth')->name('add-complaint');
Route::delete('del-complaint', [HelpdeskController::class, 'deleteComplaint'])->middleware('auth')->name('del-complaint');
Route::put('edit-complaint', [HelpdeskController::class, 'editComplaint'])->middleware('auth')->name('edit-complaint');
Route::get('confirmed-complaint', [HelpdeskController::class, 'confirmedComplaint'])->middleware('auth')->name('confirmed-complaint');
Route::put('complaint-action', [HelpdeskController::class, 'complaintAction'])->middleware('auth')->name('complaint-action');
