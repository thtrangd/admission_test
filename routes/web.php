<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReminderController;

Route::get('/', [ApplicationController::class, 'index'])->name('applications.index');
Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');

Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');
Route::post('/reminders/send', [ReminderController::class, 'send'])->name('reminders.send');

