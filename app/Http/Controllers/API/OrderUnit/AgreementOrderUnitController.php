<?php

namespace App\Http\Controllers\API\OrderUnit;

use App\Http\Controllers\Controller;
use function App\Helpers\isAuthorized;
use function App\Helpers\array_success;
use function App\Helpers\Mylog;

use App\Modules\User\Domain\Models\User;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\OrderUnit\Domain\Requests\AgreementOrderRequest;
use App\Modules\OrderUnit\Domain\Services\AgreementOrderService;
use App\Modules\OrderUnit\Domain\Services\AgreementOrderAcceptService;


use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;

use App\Modules\OrderUnit\Domain\Resources\Agreement\AgreementOrderResource;
use App\Modules\OrderUnit\Domain\Resources\Agreement\AgreementOrderAcceptResource;

class AgreementOrderUnitController extends Controller
{

    /**
    * Принятие подрятчика на заказ от заказчика.
    */
    public function agreementOrder(
        OrderUnit $orderUnit,
        AgreementOrderRequest $request,
        AgreementOrderService $service,
    ) {
        #TODO Проверять что заказ принадлежит user (Добавить роли - либо у нас можно к любому заказу приставлять любые отклики)
        $validated = $request->validated();


        /**
        * @var AgreementOrder
        */
        $model = $service->acceptCotractorToOrder(
            AgreementOrderCreateDTO::make(
                order_unit_id: $orderUnit->id,
                organization_order_units_invoce_id: $validated['organization_order_units_invoce_id'],

                //Здесь устанавливается null, т.к есть ещё endpoint по подтвреждению двух стороннего договора и документа, где уже буде устанавливаться значение явно
                organization_contractor_id: null, #TODO Внутри серверса мы уставливаем сразу, без ЭДО, если у нас будет функционал отмены ЭДО или отклика, могут быть проблемы. предусмотреть это
            )
        );



        return response()->json(array_success(AgreementOrderResource::make($model), 'Заказчик успешно выбрал подрятчика, запись создана.'), 201);
    }

    /**
    * Двух сторонний договор, о принятии в работу Заказа,
    * P.S Заказчик/Подрядчик - true/true - что бы создался Transfer
    */
    public function agreementAccept(
        AgreementOrderAccept $agreementOrderAccept,
        AuthService $auth,
        AgreementOrderAcceptService $service,
    ) {

        #TODO вынести логику в сервес

        /**
        * @var User
        */
        $user = isAuthorized($auth);


        $result = $service->acceptAgreement($user, $agreementOrderAccept);

        return $result->status
            ? response()->json(array_success(AgreementOrderAcceptResource::make($result->data) ?? null, $result->message), 200)
            : response()->json(array_success(null, $result->message), 403);
    }

    /**
     * #TODO Проверять что пользователь имеет отношение к AgreementOrderAccept
     * Получаем agreementOrderAccept по UUID
     */
    public function getAgreementOrderAccept(AgreementOrderAccept $agreementOrderAccept)
    {
        return response()->json(array_success(AgreementOrderAcceptResource::make($agreementOrderAccept), 'Запись успешна возвращена.'), 200);
    }

    /**
     * #TODO Проверять что пользователь имеет отношение к AgreementOrder
     * Получаем agreementOrder по UUID
    */
    public function getAgreementOrder(AgreementOrder $agreementOrder)
    {
        return response()->json(array_success(AgreementOrderResource::make($agreementOrder), 'Запись успешна возвращена.'), 200);
    }

      /**
     * #TODO Получить запись AgreementOrder по AgreementOrderAccept
     * Получаем agreementOrderAccept по UUID
     */
    public function getAgreementOrderByAccept(AgreementOrderAccept $agreementOrderAccept)
    {

        $agreementOrder = $agreementOrderAccept->agreement;

        return response()->json(array_success(AgreementOrderResource::make($agreementOrder), 'Запись успешна возвращена.'), 200);
    }

    /**
    * Возвращаем AgreementOrder по OrderUnit - uuid (заказу)
    */
    public function getAgreementOrderByOrder(
        OrderUnit $orderUnit,
    ) {

        abort_unless($orderUnit, 404);

        $model = AgreementOrder::where('order_unit_id',  $orderUnit->id)->first();

        return is_null($model)
        ? response()->json(array_success(null, 'Запись выбранного отклика успешно возвращена.'), 200)
        : response()->json(array_success(AgreementOrderResource::make($model), 'Запись выбранного отклика успешно возвращена.'), 200);

    }

}
