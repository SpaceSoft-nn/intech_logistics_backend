<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegistrationController;
use App\Http\Controllers\API\Notification\NotificationController;
use App\Http\Controllers\API\OrderUnit\OrderUnitController;
use App\Http\Controllers\API\Organization\OrganizationController;
use App\Http\Controllers\API\Transfer\TransferContoller;
use App\Http\Controllers\API\User\UserController;
use App\Modules\Auth\Presentation\HTTP\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/registration', RegistrationController::class);
Route::post('/login', LoginController::class);


Route::post('/notification/send', [NotificationController::class, 'sendNotification']);
Route::post('/notification/confirm', [NotificationController::class, 'confirmCode']);

    //Organization
Route::post('/organization', [OrganizationController:: class, 'create'])->middleware(['auth:sanctum']);

    //User
Route::post('/user', [UserController:: class, 'create'])->middleware(['auth:sanctum']);


//routing аутентификации по токену
Route::prefix('auth')->controller(AuthController::class)->group(function () {

    Route::post('/login', 'login');

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('/me', 'user');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');

    });

});

    //orderUnit
Route::get('/orders', [OrderUnitController:: class, 'get']);
Route::get('/orders/algorithm', [OrderUnitController:: class, 'algorithm']);
Route::get('/orders/algorithm2', [OrderUnitController:: class, 'algorithm2']);

    //transfer
Route::post('/transfer', [TransferContoller:: class, 'create']);
