<?php

use App\Http\Controllers\API\Address\AddressController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegistrationController;
use App\Http\Controllers\API\Matrix\MatrixDistanceController;
use App\Http\Controllers\API\Matrix\RegionEconomicFactorController;
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

    //Address
Route::get('/addresses', [AddressController:: class, 'get']);
Route::post('/addresses', [AddressController:: class, 'create']);

    //orderUnit
Route::prefix('/orders')->group(function () {


    {
        //Вернуть все записи
        Route::get('/', [OrderUnitController:: class, 'index']);

        //Вернуть 1 запись по uuid
        Route::get('/{orderUnit}', [OrderUnitController:: class, 'show'])->whereUuid('orderUnit');

        Route::post('/', [OrderUnitController:: class, 'create']);

            //Поиск цены от параметров Order
        Route::post('/select-offers', [OrderUnitController:: class, 'selectPrice']);

        Route::patch('/{orderUnit}', [OrderUnitController:: class, 'update'])->whereUuid('orderUnit');
    }


    //Алгоритм поиска доп заказов по главному заказу (вектора движение)
    Route::get('/get-schem', [OrderUnitController:: class, 'algorithm']);


    {
        //Возврат всех подрятчиков откликнувшиеся на заказ.
        Route::get('/{orderUnit}/contractors', [OrderUnitController:: class, 'getContractors'])->whereUuid('orderUnit', 'organization');

        //Добавление исполнителей к заказу
        Route::post('/{orderUnit}/contractors/{organization}', [OrderUnitController:: class, 'addСontractor'])->whereUuid('orderUnit', 'organization');

        //Заказчик выбирает подрядчика (исполнителя) - *присылает agreement_order_accept с апи
        Route::post('/{orderUnit}/agreement-order', [OrderUnitController:: class, 'agreementOrder'])->whereUuid('orderUnit');

        //Выбрать исполнителя
        Route::post('/{agreementOrderAccept}/agreement-accept', [OrderUnitController:: class, 'agreementAccept'])->whereUuid('agreementOrderAccept');

    }

});



    //transfer
Route::prefix('/transfer')->group(function () {

    Route::get('', [TransferContoller:: class, 'index']);
    Route::get('/{transfer}', [TransferContoller:: class, 'show'])->whereUuid('transfer');
    Route::post('', [TransferContoller:: class, 'create']);

});

    //MatrixDistance
Route::get('/matrix-distance', [MatrixDistanceController:: class, 'get']);

    //RegionEconomicFactor
Route::get('/region-economic-status', [RegionEconomicFactorController:: class, 'get']);
