<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use app\Http\Controllers\RegistrationController;
use app\Http\Controllers\ApplicationStatusController;
use app\Http\Controllers\ReminderController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('applications', ApplicationController::class);

Route::post('applications/{id}/status', [ApplicationStatusController::class, 'updateStatus']);
Route::post('registrations', [RegistrationController::class, 'store']);
Route::post('applications/{id}/reminder', [ReminderController::class, 'sendReminder']);
