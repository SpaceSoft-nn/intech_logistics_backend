<?php

namespace App\Http\Controllers\API\OrderUnit;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\DTO\OrgOrderInvoiceCreateDTO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice\InvoiceOrderVO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Requests\AddContractorRequest;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Resources\OrgOrderInvoiceCollection;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Services\OrganizationOrderInvoiceService;
use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitUpdateDTO;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitUpdateAction;
use App\Modules\OrderUnit\Domain\Interactor\CoordinateCheckerInteractor;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Requests\AgreementOrderRequest;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitAlgorithmRequest;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitCreateRequest;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitSelectPriceRequest;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitUpdateRequest;
use App\Modules\OrderUnit\Domain\Resources\Agreement\AgreementOrderAcceptResource;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderPriceResource;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitCollection;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitResource;
use App\Modules\OrderUnit\Domain\Services\AgreementOrderAcceptService;
use App\Modules\OrderUnit\Domain\Services\AgreementOrderService;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Models\User;
use Illuminate\Http\Request;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class OrderUnitController extends Controller
{
    /**
     * Вернуть все заказы
     */
    public function index(Request $request)
    {
        /**
        * @var OrderUnit[]
        */
        $orders = OrderUnit::all();

        return response()->json(array_success(OrderUnitCollection::make($orders), 'Return Orders.'), 200);
    }

    /**
    * Вернуть 1 заказ
    */
    public function show(OrderUnit $orderUnit)
    {
        return response()->json(array_success(OrderUnitResource::make($orderUnit), 'Return Order.'), 200);
    }

    /**
     * Поски цены для заказа (временно на рандоме)
     * @param OrderUnitSelectPriceRequest $request
     *
     * @return [type]
     */
    public function selectPrice(OrderUnitSelectPriceRequest $request)
    {
        $validated = $request->validated();
        // dd($validated, 1);


        // $order = OrderUnit::factory()->create([
        //     "Address_start_id" => $validated['start_Address_id'],
        //     "Address_end_id" => $validated['end_Address_id'],
        // ]);

        //TODO Нужна логика высчитывание цены в зависимости от заказа
        $test = "test";

        return response()->json(array_success(OrderPriceResource::make($test), 'Return Select Price.'), 200);
    }

    /**
     * Создание заказа
     * @param OrderUnitCreateRequest $request
     *
     */
    public function create(
        OrderUnitCreateRequest $request,
        OrderUnitService $service
    ) {

        $validated = $request->validated();

        $order = $service->createOrderUnit(
            OrderUnitCreateDTO::make(
                start_address_id: $validated['start_address_id'],
                end_address_id: $validated['end_address_id'],
                start_date_delivery: $validated['start_date_delivery'],
                end_date_delivery: $validated['end_date_delivery'],
                organization_id: $validated['organization_id'],
                end_date_order: $validated['end_date_order'],
                type_load_truck: $validated['type_load_truck'],
                order_total: $validated['order_total'],
                address_array: $validated['address_array'] ?? null,
                product_type: $validated['product_type'] ?? null,
                body_volume: $validated['body_volume'] ?? null,
                user_id: $validated['user_id'] ?? null,
                contractors_id: $validated['contractors_id'] ?? null,
                description: $validated['description'] ?? null,
            )
        );

        return response()->json(array_success(OrderUnitResource::make($order), 'Return create Order.'), 201);
    }

    /**
     * Обновление данных
     * @param OrderUnit $orderUnit
     * @param OrderUnitUpdateRequest $request
     *
     */
    public function update(OrderUnit $orderUnit, OrderUnitUpdateRequest $request)
    {
        $validated = $request->validated();

        $status = OrderUnitUpdateAction::make(
            OrderUnitUpdateDTO::make(
                order: $orderUnit,
                change_price: $validated['change_price'] ?? null,
                change_time: $validated['change_time'] ?? null,
                order_status: $validated['order_status'] ?? null,
            )
        );

        return ($status)
            ? response()->json(array_success(null, 'Update order successfully.'), 200)
            : response()->json(array_error(null, 'Update order error.'), 404);

    }

    /**
     * Добавление исполнителя к заказу
     */
    public function addСontractor(
        OrderUnit $orderUnit,
        Organization $organization,
        AddContractorRequest $request,
        OrganizationOrderInvoiceService $service,
    ) {

        #TODO Проверять что организация принадлежит к user от корого идёт запрос

        /**
        * @var InvoiceOrderVO
        */
        $invoceOrder = $request->getValueObject();

        $status = $service->addСontractor(
            OrgOrderInvoiceCreateDTO::make(
                organization: $organization,
                order: $orderUnit,
                invoiceOrderVO: $invoceOrder,
            )
        );

        return ($status)
        ? response()->json(array_success(null, 'Successfully added a contractor to the order.'), 201)
        : response()->json(array_error(null, 'Error added a contractor to the order.'), 404);

    }

    /**
     * Возврат всех подрятчиков откликнувшиеся на заказ.
     * @param OrderUnit $orderUnit
     *
     */
    public function getContractors(OrderUnit $orderUnit)
    {
        $arrays = OrganizationOrderUnitInvoice::where('order_unit_id', $orderUnit->id)->get();

        return response()->json(array_success(OrgOrderInvoiceCollection::make($arrays), 'Возвращены все подрядчики откликнувшиеся на заказ.'), 200);
    }

    /**
    * Принятие подрятчика на заказ от заказчика.
    */
    public function agreementOrder(
        OrderUnit $orderUnit,
        AgreementOrderRequest $request,
        AgreementOrderService $service,
    ) {
        #TODO Проверять что заказ принадлежит user
        $validated = $request->validated();

        /**
        * @var AgreementOrderAccept
        */
        $model = $service->acceptCotractorToOrder(
            AgreementOrderCreateDTO::make(
                order_unit_id: $orderUnit->id,
                organization_order_units_invoce_id: $validated['organization_order_units_invoce_id'],
                organization_contractor_id: null,
            )
        );


        return response()->json(array_success(AgreementOrderAcceptResource::make($model), 'Заказчик успешно выбрал подрятчика, запись создана.'), 201);
    }


    /**
     * Поиск входящих векторов относительно главного вектора (заказа)
     * @param OrderUnitAlgorithmRequest $request
     * @param CoordinateCheckerInteractor $coordinator
     *
     */
    public function algorithm(OrderUnitAlgorithmRequest $request, CoordinateCheckerInteractor $coordinator)
    {

        $orders = OrderUnit::all()->where("order_status", StatusOrderUnitEnum::draft);

        {
            $orderMain = $orders->where('id', $request['main_order'])->first();
            abort_if(is_null($orderMain), 404, "Предоставленный заказ не существует.");
        }

        {
            //Если указали дистанцию, меняем с дефолтного значения на указанное
            if(!empty($request['search_distance']))
            {
                $distance = $request['search_distance'] * 1000;
                $coordinator->setDistance($distance);
            }
        }

        //Вызываем логику работу поиска точек в прямоугольнике
        $rectangle = $coordinator->run($orderMain , $orders);

        return response()->json(array_success(OrderUnitCollection::make($orders->find($rectangle)->values()->all()), 'Возвращены все заказы входящие в область, главного заказа.'), 200);
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
        $user = $auth->getUserAuth();

        $result = $service->acceptAgreement($user, $agreementOrderAccept);

        return $result->status
            ? response()->json(array_success(null, $result->message), 200)
            : response()->json(array_success(null, $result->message), 403);
    }
}
