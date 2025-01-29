<?php

namespace App\Http\Controllers\API\OrderUnit;

use App\Http\Controllers\Controller;
use function App\Helpers\array_error;
use function App\Helpers\array_success;
use App\Modules\Address\Domain\Models\Address;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Base\Actions\GetTypeCabinetByOrganization;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitUpdateDTO;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitResource;
use App\Modules\OrderUnit\Domain\Interactor\CoordinateCheckerInteractor;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderPriceResource;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitUpdateAction;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitCollection;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitCreateRequest;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitUpdateRequest;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitAlgorithmRequest;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitSelectPriceRequest;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Requests\AddContractorRequest;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\DTO\OrgOrderInvoiceCreateDTO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Resources\OrgOrderInvoiceResource;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Resources\OrgOrderInvoiceCollection;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Services\OrganizationOrderInvoiceService;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice\InvoiceOrderVO;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderAndContractors\OrdersAndContractorFilterAction;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\ContractorComporeOrderUnitCollection;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\ContractorComporeOrderUnitResource;

class OrderUnitController extends Controller
{

    /**
     * Вернуть все заказы
     */
    public function index(
        GetTypeCabinetByOrganization $action,
        OrderUnitRepository $rep,
    ) {

        /** @var array */
        $array = $action->isCustomer();

        /** @var Organization */
        $organization = $array['organization'];

        if($array['status']) {

            //Возвращаем все созданные заказы, ЗАКАЗЧИКА

            return response()->json(array_success(OrderUnitCollection::make($organization->order_units), 'Return all orders by organization Customer .'), 200);

        } else {

            //получаем все ордеры, и указываем на какие откликнулся перевозчик
            $orders = $rep->getOrdersFilterByContractor($organization->id);

            #TODO Костыль который попросил сделать фротенд - здесь нужно пересмотреть, очень много запросов будет в бд.
            return response()->json(array_success(ContractorComporeOrderUnitCollection::make($orders), 'Возращены все заказы, с фильтрацией при выборе перевозчикам заказа.'), 200);
        }

    }

    /**
    * Вернуть 1 заказ
    */
    public function show(
        OrderUnit $orderUnit,
        GetTypeCabinetByOrganization $action,
        OrderUnitRepository $rep,
    ) {

       /** @var array */
       $array = $action->isCustomer();

       /** @var Organization */
       $organization = $array['organization'];

       if($array['status']) {

           //Возвращаем все созданные заказы, ЗАКАЗЧИКА

           return response()->json(array_success(OrderUnit::make($orderUnit), 'Return order by organization Customer .'), 200);

       } else {

           //получаем все ордеры, и указываем на какие откликнулся перевозчик
           $order = $rep->getOrderFilterByContractor($organization->id, $orderUnit->id);

           #TODO Костыль который попросил сделать фротенд - здесь нужно пересмотреть, очень много запросов будет в бд.
           return response()->json(array_success(ContractorComporeOrderUnitResource::make($order), 'Возращены все заказы, с фильтрацией при выборе перевозчикам заказа.'), 200);
       }

    }

    /**
     * Поски цены для заказа (временно на рандоме)
     * @param OrderUnitSelectPriceRequest $request
     *
     * @return void
     */
    public function selectPrice(
        OrderUnitSelectPriceRequest $request,
        CoordinateCheckerInteractor $interactor
        //Request $request
    ) {
        $validated = $request->validated();

        /**
         * @var Address
        */
        $star_address = Address::find($validated['start_address_id']);

        /**
         * @var Address
        */
        $end_address = Address::find($validated['end_address_id']);



        //Получаем расстояние между адрессами, что бы найти цену за 1км
        $distance = $interactor->calculateVectorLength($star_address->latitude, $star_address->longitude, $end_address->latitude, $end_address->longitude);

        // $order = OrderUnit::factory()->create([
        //     "Address_start_id" => $validated['start_Address_id'],
        //     "Address_end_id" => $validated['end_Address_id'],
        // ]);

        //TODO Нужна логика высчитывание цены в зависимости от заказа
        $test = "test";



        return response()->json(array_success(OrderPriceResource::make($test, $distance / 1000), 'Return Select Price.'), 200);
    }

    /**
     * Создание заказа
     * @param OrderUnitCreateRequest $request
     *
     */
    public function store(
        OrderUnitCreateRequest $request,
        OrderUnitService $service
    ) {

        /**
        * @var OrderUnitVO
        */
        $orderUnitVO = $request->createOrderUnitVO();

        /**
        * @var ?CargoGoodVO[]
        */
        $cargoGoodVO = $request->createCargoGoodVO();

        /**
        * @var OrderUnitAddressDTO
        */
        $orderUnitAddressDTO = $request->createOrderUnitAddressDTO();


        /**
        * @var OrderUnit
        */
        $order = $service->createOrderUnit(
            OrderUnitCreateDTO::make(
                orderUnitVO: $orderUnitVO,
                orderUnitAddressDTO: $orderUnitAddressDTO,
                cargoGoodVO : $cargoGoodVO,
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
    public function update(
        OrderUnit $orderUnit,
        OrderUnitUpdateRequest $request
    ) {
        $validated = $request->validated();

        /**
         * @var OrderUnitUpdateDTO
         */
        $orderUnitUpdateDTO = OrderUnitUpdateDTO::make(
            order: $orderUnit,
            change_price: $validated['change_price'] ?? null,
            change_time: $validated['change_time'] ?? null,
            order_status: $validated['order_status'] ?? null,
        );


        $status = OrderUnitUpdateAction::make($orderUnitUpdateDTO);

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

        #TODO Проверять что организация принадлежит к user от которого идёт запрос

        /**
        * @var InvoiceOrderVO
        */
        $invoceOrder = $request->getValueObject();

        /**
        * @var OrganizationOrderUnitInvoice
        */
        $model = $service->addСontractor(
            OrgOrderInvoiceCreateDTO::make(
                organization: $organization,
                order: $orderUnit,
                invoiceOrderVO: $invoceOrder,
            )
        );

        return ($model)
        ? response()->json(array_success(OrgOrderInvoiceResource::make($model), 'Successfully added a contractor to the order.'), 201)
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
     * Возврат всех подрятчиков откликнувшиеся на заказ.
     * @param OrderUnit $orderUnit
     *
    */
    public function getContractorsAll()
    {
        $arrays = OrganizationOrderUnitInvoice::all();

        return response()->json(array_success(OrgOrderInvoiceCollection::make($arrays), 'Возвращены все подрядчики откликнувшиеся на заказ.'), 200);
    }

    public function compare()
    {
        #TODO вынести в middleware
        $organization_id = request()->header('organization_id');

        $organization = Organization::find($organization_id);

        abort_unless( $organization, 404, 'Организации не существует');



    }


    /**
     * Поиск входящих векторов относительно главного вектора (заказа)
     * @param OrderUnitAlgorithmRequest $request
     * @param CoordinateCheckerInteractor $coordinator
     *
     */
    public function algorithm(OrderUnitAlgorithmRequest $request, CoordinateCheckerInteractor $coordinator)
    {
        //Тут надо добавлять ещё логику, что статус должен быть опубликован
        //получаем заказы где нету множество адрессов (только отправка и прибытия)
        $orders = OrderUnit::all()->where('address_is_array', false);

        //Получаем адресса у которых только статус: опубликован
        $orders = $orders->filter(function ($order) {
            // Предполагается, что вы имеете доступ к методу or отношению, которое возвращает последний адрес.
            $lastAddress = $order->actual_status; // Это пример, измените в зависимости от вашей модели

            // Проверяем статус на соответствие
            return $lastAddress->status->value == 'Опубликован';
        });

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

}
