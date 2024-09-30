<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/registration', RegistrationController::class);
Route::post('/login', LoginController::class);
