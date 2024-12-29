<?php

use App\Http\Controllers\API\Address\AddressController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegistrationController;
use App\Http\Controllers\API\IndividualPeople\IndividualPeopleController;
use App\Http\Controllers\API\IndividualPeople\TypePeople\DriverPeopleController;
use App\Http\Controllers\API\Matrix\MatrixDistanceController;
use App\Http\Controllers\API\Matrix\RegionEconomicFactorController;
use App\Http\Controllers\API\Notification\NotificationController;
use App\Http\Controllers\API\OfferContractor\OfferContractorController;
use App\Http\Controllers\API\OrderUnit\AgreementOrderUnitController;
use App\Http\Controllers\API\OrderUnit\OrderUnitController;
use App\Http\Controllers\API\Organization\OrganizationController;
use App\Http\Controllers\API\Tender\LotTenderController\LotTenderController;
use App\Http\Controllers\API\Tender\ResponseTenderController\ResponseTenderController;
use App\Http\Controllers\API\Test\TestController;
use App\Http\Controllers\API\Transfer\TransferContoller;
use App\Http\Controllers\API\Transport\TransportController;
use App\Http\Controllers\API\User\UserController;
use App\Modules\Auth\Presentation\HTTP\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/registration', RegistrationController::class);
Route::post('/login', LoginController::class);


Route::post('/notification/send', [NotificationController::class, 'sendNotification']);
Route::post('/notification/confirm', [NotificationController::class, 'confirmCode']);

    //Organization
Route::get('/organization', [OrganizationController::class, 'index']);
Route::get('/organization/{organization}', [OrganizationController:: class, 'show'])->whereUuid('organization');
Route::post('/organization', [OrganizationController::class, 'create']);

    //User
Route::prefix('user')->controller(AuthController::class)->group(function () {
    Route::post('/', [UserController:: class, 'create'])->middleware(['auth:sanctum']);

});

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/me', [AuthController:: class, 'user'])->middleware(['auth:sanctum']);
});




//routing аутентификации по токену
Route::prefix('auth')->controller(AuthController::class)->group(function () {

    //Он не нужен в нем нету валидации
    //Route::post('/login', 'login');

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('/me', 'user');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');

    });

});

    //Address
Route::get('/addresses', [AddressController::class, 'index']);
Route::get('/addresses/{address}', [AddressController:: class, 'show'])->whereUuid('address');
Route::post('/addresses', [AddressController::class, 'create']);

    //orderUnit
Route::prefix('/orders')->group(function () {

    { //Установка статутса транспортировки события: в пути, на разгрузке...
        #TODO Возможно в будущем uuid заказа нужно будет отправлять в теле запроса.
        Route::post('/{orderUnit}/status-transportation', [OrderUnitController::class, 'setStatusTransportationEvent'])->whereUuid('orderUnit');
    }

    {
        //Вернуть все записи
        Route::get('/', [OrderUnitController::class, 'index']);

        //Вернуть 1 запись по uuid
        Route::get('/{orderUnit}', [OrderUnitController::class, 'show'])->whereUuid('orderUnit');

        Route::post('/', [OrderUnitController::class, 'store']);

            //Поиск цены от параметров Order
        Route::post('/select-offers', [OrderUnitController::class, 'selectPrice']);

        Route::patch('/{orderUnit}', [OrderUnitController::class, 'update'])->whereUuid('orderUnit');
    }


    //Алгоритм поиска доп заказов по главному заказу (вектора движение)
    Route::get('/get-schem', [OrderUnitController::class, 'algorithm']);


    {
        //Возврат всех подрятчиков откликнувшиеся на заказ. (Временно возвращаем все записи из таблицы)
        Route::get('/contractors', [OrderUnitController::class, 'getContractorsAll'])->whereUuid('orderUnit', 'organization');

        //Возврат всех подрятчиков откликнувшиеся на заказ.
        Route::get('/{orderUnit}/contractors', [OrderUnitController::class, 'getContractors'])->whereUuid('orderUnit', 'organization');

        //Добавление исполнителей к заказу
        Route::post('/{orderUnit}/contractors/{organization}', [OrderUnitController::class, 'addСontractor'])->whereUuid('orderUnit', 'organization');


        {   //AgreementOrderUnit

            #TODO Поменять сваггер
            Route::prefix('/agreement')->group(function () {

                //Заказчик выбирает подрядчика (исполнителя) - *присылает agreement_order_accept с апи
                Route::post('/{orderUnit}/agreement-order', [AgreementOrderUnitController::class, 'agreementOrder'])->whereUuid('orderUnit');

                #TODO нужен endpoint на возврат всех agreementOrderAccept (В Теории)

                //Утверждения Двух сторонний договор, о принятии в работу Заказа,
                //P.S Заказчик/Подрядчик - true/true - что бы была возможность создать Transfer
                Route::patch('/{agreementOrderAccept}/agreement-accept', [AgreementOrderUnitController::class, 'agreementAccept'])->whereUuid('agreementOrderAccept');



                //вернуть agreementOrderAccept по uuid
                Route::get('/{agreementOrderAccept}/agreement-order-accept', [AgreementOrderUnitController::class, 'getAgreementOrderAccept'])->whereUuid('agreementOrderAccept');
                //Вернуть agreementOrder по uuid
                Route::get('/{agreementOrder}/agreement-order', [AgreementOrderUnitController::class, 'getAgreementOrder'])->whereUuid('agreementOrder');
                //Вернуть agreementOrder по uuid agreementOrderAccept
                Route::get('/{agreementOrderAccept}/by-agreement-order-accept', [AgreementOrderUnitController::class, 'getAgreementOrderByAccept'])->whereUuid('agreementOrderAccept');

            });

        }

    }

});



    //transfer
Route::prefix('/transfer')->group(function () {

    Route::get('', [TransferContoller:: class, 'index']);
    Route::get('/{transfer}', [TransferContoller:: class, 'show'])->whereUuid('transfer');
    Route::post('', [TransferContoller:: class, 'store']);

});

    //Матрица расстояний
Route::prefix('/matrix-distance')->group(function () {

    Route::get('/', [MatrixDistanceController:: class, 'index']);
    Route::get('/filter', [MatrixDistanceController:: class, 'show']);
    Route::post('/', [MatrixDistanceController:: class, 'store']);

});

    //Предложения перевозчика
Route::prefix('/offer-contractors')->group(function () {

    Route::get('/', [OfferContractorController::class, 'index']);
    Route::post('/', [OfferContractorController::class, 'store']);

    //Отклик Заказчика на предложения перевозчика
    Route::post('/{offerContractor}/customer/{organization}', [OfferContractorController::class, 'addCustomer'])->whereUuid('offerContractor', 'organization');
    //Получение всех предложений (по предложнию)
    Route::get('/{offerContractor}/customer', [OfferContractorController::class, 'getAddCustomer'])->whereUuid('offerContractor');


    //Вернуть подвтреждённую заявку (выбранная организация - заказчика на исполнения) по предложению (если имется)
    Route::get('/{offerContractor}/agreement-offer', [OfferContractorController::class, 'getAgreementOffer'])->whereUuid('offerContractor');

    //перевозчик выбирает (организацию - заказчика) на исполнение заявки предложения
    Route::post('/{offerContractor}/agreement-offer', [OfferContractorController::class, 'agreementOffer'])->whereUuid('offerContractor');

    //Утверждения Двух сторонний договор, о принятии в работу Предложения и принятии заказа,
    //P.S Заказчик/Подрядчик - true/true - что бы была возможность создать Transfer
    Route::patch('/{agreementOrderContractorAccept}/agreement-offer-accept', [OfferContractorController::class, 'agreementOfferAccept'])->whereUuid('agreementOrderContractorAccept');

    //Создание заказа после утверждения двух-стороннего договора на предложении от перевозчика
    Route::post('/{agreementOrderContractorAccept}/agreement-offer-order', [OfferContractorController::class, 'agreementOfferOrder'])->whereUuid('agreementOrderContractorAccept');


});

    //Endpoint transports
Route::prefix('/transports')->group(function () {

    Route::get('/', [TransportController::class, 'index']);
    Route::get('/{transport}', [TransportController::class, 'show'])->whereUuid('transport');
    Route::post('/', [TransportController::class, 'store']);

});

Route::prefix('/individual-people')->group(function () {


    Route::get('/', [IndividualPeopleController::class, 'index']);
    Route::get('/{individualPeople}', [IndividualPeopleController::class, 'show'])->whereUuid('individualPeople');
    Route::post('/', [IndividualPeopleController::class, 'store']);

    Route::prefix('/drivers')->group(function () {

        Route::get('/', [DriverPeopleController::class, 'index']);
        Route::get('/{driverPeople}', [DriverPeopleController::class, 'show'])->whereUuid('driverPeople');
        Route::post('/', [DriverPeopleController::class, 'store']);

    });


});

Route::prefix('/tenders')->group(function () {

    Route::post('/', [LotTenderController::class, 'store']);
    Route::get('/', [LotTenderController::class, 'index'])->whereUuid('agreementDocumentTender');
    Route::get('/{lotTender}', [LotTenderController::class, 'show'])->whereUuid('lotTender');

    {
        //Добавление исполнителей к заказу
        Route::post('/{lotTender}/contractors/{organization}', [ResponseTenderController::class, 'addСontractorForTender'])->whereUuid('lotTender', 'organization');

        //Вернуть всех исполнителей откликнувшиеся на Тендер
        Route::get('/{lotTender}/contractors', [ResponseTenderController::class, 'getСontractorForTender'])->whereUuid('lotTender');

        // Выбор "создателем тендера" - перевозчика на выполнение тендера
        Route::post('/{lotTenderResponse}/agreement-tender', [ResponseTenderController::class, 'agreementTender'])->whereUuid('lotTenderResponse');

        //Подтверждения соглашения с двух сторон, о взятие тендера и работу со стороны перевозчика, и отдачи в работу со стороны создателя тендера
        Route::post('/{lotTenderResponse}/agreement-tender-accept', [ResponseTenderController::class, 'agreementTenderAccept'])->whereUuid('lotTenderResponse');



        //Дополнения заказа по тендеру
        Route::post('/{lotTender}/orders', [LotTenderController::class, 'addInfoOrderByTender'])->whereUuid('lotTender');

    }

});

Route::get('/test', [TestController::class, 'index']);

    //RegionEconomicFactor
Route::get('/region-economic-status', [RegionEconomicFactorController:: class, 'get']);
