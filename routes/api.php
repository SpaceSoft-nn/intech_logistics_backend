<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Test\TestController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Address\AddressController;
use App\Http\Controllers\API\Transfer\TransferContoller;
use App\Http\Controllers\API\Auth\RegistrationController;
use App\Http\Controllers\API\Avizo\AvizoEmailController;
use App\Http\Controllers\API\Avizo\AvizoPhoneController;
use App\Http\Controllers\API\OrderUnit\OrderUnitController;
use App\Http\Controllers\API\Transport\TransportController;
use App\Http\Controllers\API\Matrix\MatrixDistanceController;
use App\Http\Controllers\API\Notification\NotificationController;
use App\Http\Controllers\API\Organization\OrganizationController;
use App\Modules\Auth\Presentation\Http\Controllers\AuthController;
use App\Http\Controllers\API\Matrix\RegionEconomicFactorController;
use App\Http\Controllers\API\OrderUnit\AgreementOrderUnitController;
use App\Http\Controllers\API\OfferContractor\OfferContractorController;
use App\Http\Controllers\API\IndividualPeople\IndividualPeopleController;
use App\Http\Controllers\API\Tender\LotTenderController\LotTenderController;
use App\Http\Controllers\API\IndividualPeople\TypePeople\DriverPeopleController;
use App\Http\Controllers\API\IndividualPeople\TypePeople\StorekeeperPeopleController;
use App\Http\Controllers\API\Tender\ResponseTenderController\ResponseTenderController;


Route::post('/registration', [RegistrationController::class, 'store']);
Route::post('/login', LoginController::class);


Route::post('/notification/send', [NotificationController::class, 'sendNotification']);
Route::post('/notification/confirm', [NotificationController::class, 'confirmCode']);

    //Organization
Route::prefix('organizations')->controller(AuthController::class)->group(function () {


    Route::get('/', [OrganizationController::class, 'index']);
    Route::post('/', [OrganizationController::class, 'create']);
    Route::get('/{organization}', [OrganizationController:: class, 'show'])->whereUuid('organization');
    Route::get('/{organization}/orders', [OrganizationController:: class, 'orders'])->whereUuid('organization');
    Route::get('/{organization}/drivers', [OrganizationController:: class, 'drivers'])->whereUuid('organization');
    Route::get('/{organization}/transports', [OrganizationController:: class, 'transports'])->whereUuid('organization');

});



    //User
Route::prefix('user')->controller(AuthController::class)->group(function () {

    Route::post('/', [UserController:: class, 'create'])->middleware(['auth:sanctum']);


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
        #TODO Нужна ли проверка на заказчика?
        Route::post('/{orderUnit}/status-transportation', [OrderUnitController::class, 'setStatusTransportationEvent'])->whereUuid('orderUnit');
    }

    {
        //Вернуть все записи если заказчик - только заказы которые принадлежат ему, если перевозчик - то все
        Route::get('/', [OrderUnitController::class, 'index'])->middleware(['hasOrgHeader', 'auth:sanctum']);

        Route::middleware(['isCustomerOrganization'])->group(function () {

            //Вернуть 1 запись по uuid
            Route::get('/{orderUnit}', [OrderUnitController::class, 'show'])->whereUuid('orderUnit');

            //Создать заказ
            Route::post('/', [OrderUnitController::class, 'store']);

            //Поиск цены от параметров Order
            Route::post('/select-offers', [OrderUnitController::class, 'selectPrice']);

            Route::patch('/{orderUnit}', [OrderUnitController::class, 'update'])->whereUuid('orderUnit');

            {   //contractors

                //Возврат всех подрятчиков откликнувшиеся на заказ. (Временно возвращаем все записи из таблицы)
                Route::get('/contractors', [OrderUnitController::class, 'getContractorsAll'])->whereUuid('orderUnit', 'organization');

                //Возврат всех подрятчиков откликнувшиеся на заказ.
                Route::get('/{orderUnit}/contractors', [OrderUnitController::class, 'getContractors'])->whereUuid('orderUnit', 'organization');

                //Добавление исполнителей к заказу
                Route::post('/{orderUnit}/contractors/{organization}', [OrderUnitController::class, 'addСontractor'])->whereUuid('orderUnit', 'organization')
                    ->withoutMiddleware('isCustomerOrganization')
                    ->middleware('isCarrierOrganization');

            }

        });

        {   //AgreementOrderUnit

            Route::prefix('/agreements')->group(function () {

                #TODO нужен endpoint на возврат всех agreementOrderAccept (В Теории)

                //Утверждения Двух сторонний договор, о принятии в работу Заказа,
                //P.S Заказчик/Подрядчик - true/true - что бы была возможность создать Transfer
                Route::patch('/{agreementOrderAccept}/agreement-order-accept', [AgreementOrderUnitController::class, 'agreementAccept'])->whereUuid('agreementOrderAccept');

                //вернуть agreementOrderAccept по uuid
                Route::get('/{agreementOrderAccept}/agreement-order-accept', [AgreementOrderUnitController::class, 'getAgreementOrderAccept'])->whereUuid('agreementOrderAccept');

                //Вернуть agreementOrder по uuid
                Route::get('/{agreementOrder}/agreement-order', [AgreementOrderUnitController::class, 'getAgreementOrder'])->whereUuid('agreementOrder');

            });

            //Заказчик выбирает подрядчика (исполнителя) - *присылает agreement_order_accept с апи
            Route::post('{orderUnit}/agreements/agreement-order', [AgreementOrderUnitController::class, 'agreementOrder'])->whereUuid('orderUnit')->middleware('isCustomerOrganization');

            //Возвращаем AgreementOrder по OrderUnit - uuid (заказу)
            Route::get('/{orderUnit}/agreements/agreement-order', [AgreementOrderUnitController::class, 'getAgreementOrderByOrder'])->whereUuid('orderUnit');

        }

    }

    //Алгоритм поиска доп заказов по главному заказу (вектора движение)
    Route::get('/get-schem', [OrderUnitController::class, 'algorithm']);

});



    //transfer
Route::prefix('/transfer')->group(function () {

    Route::get('', [TransferContoller:: class, 'index']);
    Route::get('/{transfer}', [TransferContoller:: class, 'show'])->whereUuid('transfer');
    Route::post('', [TransferContoller:: class, 'store'])->middleware('isCustomerOrganization');

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


    Route::middleware(['isCarrierOrganization'])->group(function () {

        Route::post('/', [OfferContractorController::class, 'store']);

        //перевозчик выбирает (организацию - заказчика) на исполнение заявки предложения
        Route::post('/{offerContractor}/agreement-offer', [OfferContractorController::class, 'agreementOffer'])->whereUuid('offerContractor');

        //Получение все предложения (от заказчиколв которые откликнулись) -> (по предложнию)
        Route::get('/{offerContractor}/customer', [OfferContractorController::class, 'getAddCustomer'])->whereUuid('offerContractor');

    });


    //Вернуть подтверждённую заявку (выбранная организация - заказчика на исполнения) по предложению (если имется)
    Route::get('/{offerContractor}/agreement-offer', [OfferContractorController::class, 'getAgreementOffer'])->whereUuid('offerContractor');

    //Утверждения Двух сторонний договор, о принятии в работу Предложения и принятии заказа,
    //P.S Заказчик/Подрядчик - true/true - что бы была возможность создать Transfer
    Route::patch('/{agreementOrderContractorAccept}/agreement-offer-accept', [OfferContractorController::class, 'agreementOfferAccept'])->whereUuid('agreementOrderContractorAccept');

    //Отклик Заказчика на предложения перевозчика
    Route::post('/{offerContractor}/customer/{organization}', [OfferContractorController::class, 'addCustomer'])->whereUuid('offerContractor', 'organization')->middleware('isCustomerOrganization');

    //Создание заказа после утверждения двух-стороннего договора на предложении от перевозчика
    Route::post('/{agreementOrderContractorAccept}/agreement-offer-order', [OfferContractorController::class, 'agreementOfferOrder'])->whereUuid('agreementOrderContractorAccept')->middleware('isCustomerOrganization');


});

    //Endpoint transports
Route::prefix('/transports')->group(function () {

    Route::get('/', [TransportController::class, 'index']);
    Route::get('/{transport}', [TransportController::class, 'show'])->whereUuid('transport');
    Route::post('/', [TransportController::class, 'store'])->middleware('isCarrierOrganization');

});

Route::prefix('/individual-people')->group(function () {


    Route::get('/', [IndividualPeopleController::class, 'index']);
    Route::get('/{individualPeople}', [IndividualPeopleController::class, 'show'])->whereUuid('individualPeople');
    Route::post('/', [IndividualPeopleController::class, 'store']);

    Route::prefix('/drivers')->group(function () {

        Route::get('/', [DriverPeopleController::class, 'index']);
        Route::get('/{driverPeople}', [DriverPeopleController::class, 'show'])->whereUuid('driverPeople')->middleware('isCarrierOrganization');
        Route::post('/', [DriverPeopleController::class, 'store']);

    });

    Route::prefix('/storekeepers')->group(function () {

        Route::get('/', [StorekeeperPeopleController::class, 'index']);
        Route::get('/{storekeeper}', [StorekeeperPeopleController::class, 'show'])->whereUuid('storekeeper');
        Route::post('/', [StorekeeperPeopleController::class, 'store']);

    });


});

Route::prefix('/tenders')->group(function () {

    Route::middleware(['isCustomerOrganization'])->group(function () {

        Route::post('/', [LotTenderController::class, 'store']);

        {
            //Добавление исполнителей к заказу
            Route::post('/{lotTender}/contractors/{organization}', [ResponseTenderController::class, 'addСontractorForTender'])->whereUuid('lotTender', 'organization');

            //Вернуть всех исполнителей откликнувшиеся на Тендер
            Route::get('/{lotTender}/contractors', [ResponseTenderController::class, 'getСontractorForTender'])->whereUuid('lotTender');

            // Выбор "создателем тендера" - перевозчика на выполнение тендера
            Route::post('/{lotTenderResponse}/agreement-tender', [ResponseTenderController::class, 'agreementTender'])->whereUuid('lotTenderResponse');

            //Добавить к заказу дополнительную информацию
            Route::patch('/{lotTender}/orders/{orderUnit}', [LotTenderController::class, 'addInfoOrderByTender'])->whereUuid('lotTender', 'orderUnit');
        }
    });


    Route::get('/', [LotTenderController::class, 'index']);
    Route::get('/{lotTender}', [LotTenderController::class, 'show'])->whereUuid('lotTender');

    {

        //Подтверждения соглашения с двух сторон, о взятие тендера и работу со стороны перевозчика, и отдачи в работу со стороны создателя тендера, !создание заказов после утверждения!
        Route::post('/{agreementTenderAccept}/agreement-tender-accept', [ResponseTenderController::class, 'agreementTenderAccept'])->whereUuid('agreementTenderAccept');

        //Получить все заказы по тендеру
        Route::get('/{lotTender}/orders', [LotTenderController::class, 'getAllOrderFromTender'])->whereUuid('lotTender');

    }

});

Route::prefix('/avizos')->group(function () {

    Route::prefix('/emails')->group(function () {

        Route::post('/', [AvizoEmailController::class, 'store']);

        //Перенесён в web
        // Route::post('/{uuid}/confirm', [AvizoEmailController::class, 'confirm'])->name('avizos.emails.confirm');

    });

    Route::prefix('/phones')->group(function () {

        Route::post('/', [AvizoPhoneController::class, 'store']);

        Route::post('/confirm', [AvizoPhoneController::class, 'confirm']);

    });

});

Route::get('/test', [TestController::class, 'index']);

    //RegionEconomicFactor
Route::get('/region-economic-status', [RegionEconomicFactorController:: class, 'get']);
