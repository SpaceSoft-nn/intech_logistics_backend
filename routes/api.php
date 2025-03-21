<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Test\TestController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Address\AddressController;
use App\Http\Controllers\API\Auth\PhoneLoginController;
use App\Http\Controllers\API\Avizo\AvizoEmailController;
use App\Http\Controllers\API\Avizo\AvizoPhoneController;
use App\Http\Controllers\API\Transfer\TransferContoller;
use App\Http\Controllers\API\Auth\RegistrationController;
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

//сделано создание user + organization вместе store
Route::post('/registration', [RegistrationController::class, 'store']);
// Route::post('/login', LoginController::class);

Route::prefix('login')->group(function () {

    Route::post('/phones', PhoneLoginController::class);
    Route::post('/', LoginController::class);

});

Route::post('/notification/send', [NotificationController::class, 'sendNotification']);
Route::post('/notification/confirm', [NotificationController::class, 'confirmCode']);

    //Organization
Route::prefix('organizations')->middleware('manuallyActivatedOrganization')->group(function () {


    Route::get('/', [OrganizationController::class, 'index']);
    Route::post('/', [OrganizationController::class, 'create']);
    Route::get('/{organization}', [OrganizationController:: class, 'show'])->whereUuid('organization');

    { //Работа с User

        Route::prefix('users')->middleware(['auth:sanctum', 'isActiveUser' ,'hasOrgHeader'])->group(function (){

            //получить всех пользователей по организации
            Route::get('/', [OrganizationController:: class, 'indexUsers']);

            //активировать пользователя от админа организации
            Route::patch('/{user}/active', [OrganizationController:: class, 'activeUsers'])->whereUuid('user');

        });

    }

});


//routing аутентификации по токену
Route::prefix('auth')->controller(AuthController::class)->group(function () {

    //Он не нужен в нем нету валидации
    //Route::post('/login', 'login');

    Route::middleware(['auth:sanctum', 'isActiveUser', 'isActiveUser'])->group(function () {

        Route::get('/me', 'user');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');

    });

});

    //Address
Route::prefix('/addresses')->middleware('manuallyActivatedOrganization')->controller(AuthController::class)->group(function () {

    Route::get('/', [AddressController::class, 'index']);
    Route::post('/', [AddressController::class, 'store']);

    Route::get('/{address}', [AddressController:: class, 'show'])->whereUuid('address');

    Route::patch('/{address}', [AddressController::class, 'update'])->whereUuid('orderUnit');
});



    //orderUnit
Route::prefix('/orders')->middleware('manuallyActivatedOrganization')->group(function () {

    {
        //Вернуть все записи если заказчик - только заказы которые принадлежат ему, если перевозчик - то все
        Route::get('/', [OrderUnitController::class, 'index'])->middleware(['hasOrgHeader', 'auth:sanctum', 'isActiveUser']);

        #TODO Возможно в будущем нужна фильтрация
        // Route::get('/{status?}', [OrderUnitController::class, 'index'])->middleware(['hasOrgHeader', 'auth:sanctum']);

        //Вернуть 1 запись по uuid
        Route::get('/{orderUnit}', [OrderUnitController::class, 'show'])->whereUuid('orderUnit');

        Route::middleware(['isCustomerOrganization'])->group(function () {

            //Создать заказ
            Route::post('/', [OrderUnitController::class, 'store']);

            //Поиск цены от параметров Order
            Route::post('/select-offers', [OrderUnitController::class, 'selectPrice']);

            Route::patch('/{orderUnit}', [OrderUnitController::class, 'update'])->whereUuid('orderUnit');

            //обновление orderUnit в том случае если находится в статусе черновик
            Route::patch('/{orderUnit}/draft', [OrderUnitController::class, 'updateDraft'])->whereUuid('orderUnit');

            {   //contractors

                //Возврат всех подрятчиков откликнувшиеся на заказ. Возвращаем в зависимости от организации
                Route::get('/contractors', [OrderUnitController::class, 'getContractorsAll']);

                //Возврат всех подрятчиков откликнувшиеся на заказ.
                Route::get('/{orderUnit}/contractors', [OrderUnitController::class, 'getContractors'])->whereUuid('orderUnit', 'organization');

                //Добавление исполнителей к заказу (отклик)
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
                Route::patch('/{agreementOrderAccept}/accept', [AgreementOrderUnitController::class, 'agreementAccept'])->whereUuid('agreementOrderAccept');

                //вернуть agreementOrderAccept по uuid
                Route::get('/{agreementOrderAccept}/accept', [AgreementOrderUnitController::class, 'getAgreementOrderAccept'])->whereUuid('agreementOrderAccept');

            });

            //Заказчик выбирает подрядчика (исполнителя) - *присылает agreement_order_accept с апи
            Route::post('{orderUnit}/agreements', [AgreementOrderUnitController::class, 'agreementOrder'])->whereUuid('orderUnit')->middleware('isCustomerOrganization');

            //Возвращаем выбранный отклик Заказчиком
            Route::get('/{orderUnit}/agreements', [AgreementOrderUnitController::class, 'getAgreementOrderByOrder'])->whereUuid('orderUnit');

        }

    }

    //Алгоритм поиска доп заказов по главному заказу (вектора движение)
    Route::get('/get-schem', [OrderUnitController::class, 'algorithm']);

});



    //transfer
Route::prefix('/transfer')->middleware('manuallyActivatedOrganization')->group(function () {

    Route::get('', [TransferContoller:: class, 'index']);
    Route::get('/{transfer}', [TransferContoller:: class, 'show'])->whereUuid('transfer');
    Route::post('', [TransferContoller:: class, 'store'])->middleware('isCustomerOrganization');

});

    //Матрица расстояний
Route::prefix('/matrix-distance')->middleware('manuallyActivatedOrganization')->group(function () {

    Route::get('/', [MatrixDistanceController:: class, 'index']);
    Route::get('/filter', [MatrixDistanceController:: class, 'show']);
    Route::post('/', [MatrixDistanceController:: class, 'store']);

});


    //Предложения перевозчика
Route::prefix('/offer-contractors')->middleware(['manuallyActivatedOrganization'])->group(function () {

    Route::get('/', [OfferContractorController::class, 'index']);

    Route::get('/{offerContractor}', [OfferContractorController::class, 'show']);

    Route::middleware(['isCarrierOrganization'])->group(function () {

        //создание предложения от перевозчика
        Route::post('/', [OfferContractorController::class, 'store']);

        //Частичное обновление #TODO - есть проблема с 'безопаностью' обновление статуса, нужно в будущем продумать как ограничить обновление во всех статусов, кроме draft
        Route::patch('/{offerContractor}', [OfferContractorController::class, 'update']);

        //перевозчик выбирает (организацию - заказчика) на исполнение заявки предложения
        Route::post('/{offerContractor}/agreements', [OfferContractorController::class, 'agreementOffer'])->whereUuid('offerContractor');

        //Вернуть подтверждённую заявку (выбранная организация - заказчика на исполнения) по предложению (если имется)
        Route::get('/{offerContractor}/agreements', [OfferContractorController::class, 'getAgreementOffer'])->whereUuid('offerContractor')->withoutMiddleware(['isCarrierOrganization']);

        //Утверждения Двух сторонний договор, о принятии в работу Предложения и принятии заказа,
        //P.S Заказчик/Подрядчик - true/true - что бы была возможность создать Transfer
        Route::patch('agreements/{agreementOrderContractorAccept}/accept', [OfferContractorController::class, 'agreementOfferAccept'])->whereUuid('agreementOrderContractorAccept');

    });




    { // отклик

        //Отклик Заказчика на предложения перевозчика
        Route::post('/{offerContractor}/customers/{organization}', [OfferContractorController::class, 'addCustomer'])->whereUuid('offerContractor', 'organization')
            ->middleware('isCustomerOrganization');

        //Получить все отклики
        Route::get('/{offerContractor}/customers', [OfferContractorController::class, 'getAddCustomer'])->whereUuid('offerContractor');
    }

    //Создание заказа после утверждения двух-стороннего договора на предложении от перевозчика
    // Route::post('/{agreementOrderContractorAccept}/agreement-offer-order', [OfferContractorController::class, 'agreementOfferOrder'])->whereUuid('agreementOrderContractorAccept')->middleware('isCustomerOrganization');

});

    //Endpoint transports
Route::prefix('/transports')->middleware('manuallyActivatedOrganization')->group(function () {

    Route::get('/', [TransportController::class, 'index'])->middleware(['hasOrgHeader', 'auth:sanctum', 'isActiveUser']);
    Route::get('/{transport}', [TransportController::class, 'show'])->whereUuid('transport');
    Route::post('/', [TransportController::class, 'store'])->middleware('isCarrierOrganization');

});

Route::prefix('/individual-peoples')->middleware('manuallyActivatedOrganization')->group(function () {


    Route::get('/', [IndividualPeopleController::class, 'index']);
    Route::get('/{individualPeople}', [IndividualPeopleController::class, 'show'])->whereUuid('individualPeople');
    Route::post('/', [IndividualPeopleController::class, 'store']);

    Route::prefix('/drivers')->group(function () {

        Route::get('/', [DriverPeopleController::class, 'index'])->middleware(['hasOrgHeader', 'auth:sanctum', 'isActiveUser']);
        Route::get('/{driverPeople}', [DriverPeopleController::class, 'show'])->whereUuid('driverPeople')->middleware('isCarrierOrganization');
        Route::post('/', [DriverPeopleController::class, 'store']);

    });

    Route::prefix('/storekeepers')->group(function () {

        Route::get('/', [StorekeeperPeopleController::class, 'index']);
        Route::get('/{storekeeper}', [StorekeeperPeopleController::class, 'show'])->whereUuid('storekeeper');
        Route::post('/', [StorekeeperPeopleController::class, 'store']);

    });


});

Route::prefix('/tenders')->middleware(['manuallyActivatedOrganization', 'auth:sanctum'])->group(function () {


    Route::get('/', [LotTenderController::class, 'index'])->middleware(['hasOrgHeader', 'isActiveUser']);


    Route::middleware(['isCarrierOrganization'])->group(function () {

        //Добавление исполнителей к заказу *(отклик)
        Route::post('/{lotTender}/contractors/{organization}', [ResponseTenderController::class, 'addСontractorForTender'])->whereUuid('lotTender', 'organization');

    });

    Route::middleware(['isCustomerOrganization'])->group(function () {

        {
            //Создание Тендера
            Route::post('/', [LotTenderController::class, 'store']);

            //частичное обновление тендера
            Route::patch('/{lotTender}', [LotTenderController::class, 'update']);

            //Вернуть всех исполнителей откликнувшиеся на Тендер
            Route::get('/{lotTender}/contractors', [ResponseTenderController::class, 'getСontractorForTender'])->whereUuid('lotTender');

            // Выбор "создателем тендера" - перевозчика на выполнение тендера
            Route::post('/{lotTenderResponse}/agreements', [ResponseTenderController::class, 'agreementTender'])->whereUuid('lotTenderResponse');

            //Вернуть принятый отклик на тендер
            Route::get('/{lotTender}/agreements', [LotTenderController::class, 'getAgreementTenderByTender'])->withoutMiddleware('isCustomerOrganization')->whereUuid('lotTender');

            //Добавить к заказу дополнительную информацию - нужна будет обязательно для того что бы точно дополнить тендер к заказу
            Route::patch('/{lotTender}/orders/{orderUnit}', [LotTenderController::class, 'addInfoOrderByTender'])->whereUuid('lotTender', 'orderUnit');
        }

    });


    Route::get('/{lotTender}', [LotTenderController::class, 'show'])->whereUuid('lotTender');



    {

        //ЭДО Подтверждения соглашения с двух сторон, о взятие тендера и работу со стороны перевозчика, и отдачи в работу со стороны создателя тендера, !создание заказов после утверждения!
        Route::patch('/agreements/{agreementTenderAccept}/accept', [ResponseTenderController::class, 'agreementTenderAccept'])->whereUuid('agreementTenderAccept');


        //Получить все заказы по тендеру
        Route::get('/{lotTender}/orders', [LotTenderController::class, 'getAllOrderFromTender'])->whereUuid('lotTender');

    }

});

Route::prefix('/avizos')->middleware('manuallyActivatedOrganization')->group(function () {

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
