<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegistrationController;
use App\Http\Controllers\API\Notification\NotificationController;
use Illuminate\Support\Facades\Route;


Route::post('/registration', RegistrationController::class);
Route::post('/login', LoginController::class);


Route::post('/notification/send', [NotificationController::class, 'sendNotification']);
Route::post('/notification/confirm', [NotificationController::class, 'confirmCode']);
