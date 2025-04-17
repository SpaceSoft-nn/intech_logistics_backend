<?php

namespace App\Http\Controllers\API\OrderUnit;

use Faker\Factory as Faker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function App\Helpers\array_error;
use function App\Helpers\array_success;
use function App\Helpers\Mylog;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Base\Actions\GetTypeCabinetByOrganization;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
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
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\ContractorComporeOrderUnitResource;

use App\Modules\OrderUnit\Domain\Resources\OrderUnit\ContractorComporeOrderUnitCollection;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitWrapp\OrderUnitWrappCollection;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Requests\AddContractorRequest;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\DTO\OrgOrderInvoiceCreateDTO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Resources\OrgOrderInvoiceResource;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Resources\OrgOrderInvoiceCollection;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Services\OrganizationOrderInvoiceService;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice\InvoiceOrderVO;
use App\Modules\OrderUnit\App\Data\Enums\PalletType\TypeSizePalletSpaceEnum;
use App\Modules\OrderUnit\Common\Helpers\Pallets\PalletSize;
use App\Modules\OrderUnit\Common\Helpers\Pallets\PalletSizeHelper;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitStatus\OrderUnitStatusCollection;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitStatus\OrderUnitStatusResource;
use Http;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class OrderUnitController extends Controller
{

    /**
     * Вернуть все заказы
     */
    public function index(
        Request $request,
        GetTypeCabinetByOrganization $action,
        OrderUnitRepository $rep,
    ) {

        /** @var array */
        $array = $action->isCustomer();

        /** @var Organization */
        $organization = $array['organization'];

        $statuses = explode(',', $request->query('status'));

        if($array['status']) {


            //Возвращаем все созданные заказы, ЗАКАЗЧИКА
            return response()->json(array_success(OrderUnitWrappCollection::make($organization->order_units), 'Return all orders by organization Customer.'), 200);

        } else {


            //получаем все ордеры, и указываем на какие откликнулся перевозчик
            $orders = $rep->getOrdersFilterByContractor($organization->id, $statuses);

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

           return response()->json(array_success(OrderUnitResource::make($orderUnit), 'Return order by organization Customer .'), 200);

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

        { //API Деловые линии

            /**
            * @var Address
            */
            $star_address = Address::find($validated['start_address_id']);

            /**
             * @var Address
            */
            $end_address = Address::find($validated['end_address_id']);

            $start_date_delivery =  Carbon::createFromFormat('d.m.Y',$validated['start_date_delivery'])->format('Y-m-d');
            $end_date_delivery =  $validated['end_date_delivery'];


            $mgx = $validated['goods_array'][0]['mgx'] ?? null;


            /** @var int */
            $count_cargo_unit = $validated['goods_array'][0]['cargo_units_count'];

            /** @var float  */
            $weight_general = $validated['goods_array'][0]['weight_general'];


            /** @var TypeSizePalletSpaceEnum  */
            $typePallet = TypeSizePalletSpaceEnum::stringByCaseToObject($validated['goods_array'][0]['type_pallet']);

            /** @var PalletSize */
            $palletSize = PalletSizeHelper::getSize($typePallet);

            if(!is_null($mgx)) {

                $data = [

                    'appkey' => env('APP_KEY_BUSINESS_LINE'),
                    'delivery' => [
                        'deliveryType' => [
                            'type' => 'auto'
                        ],
                        'derival' => [
                            'produceDate' => $start_date_delivery,
                            'variant' => 'address',
                            'address' => [
                                'search' => $star_address->nomination
                            ],
                            "time" => [
                                "worktimeEnd" => "19:30",
                                "worktimeStart" => "9:00",
                                "breakStart" => "12:00",
                                "breakEnd" => "13:00",
                                "exactTime" => false
                            ]
                        ],
                        'arrival' => [
                            'variant' => 'address',
                            'address' => [
                                'search' => $end_address->nomination
                            ],
                            "time" => [
                                "worktimeEnd" => "19:30",
                                "worktimeStart" => "9:00",
                                "breakStart" => "12:00",
                                "breakEnd" => "13:00",
                                "exactTime" => false
                            ]
                        ],
                    ],
                    'cargo' => [
                        'quantity' => $count_cargo_unit,
                        'length' => $mgx['length'],
                        'width' => $mgx['width'],
                        'height' => $mgx['height'],
                        'weight' => $mgx['weight'],
                        'totalWeight' => $mgx['weight'] * $count_cargo_unit,
                        'totalVolume' => $mgx['length'] * $mgx['width'] * $mgx['height'],
                    ]

                ];

            } else {

                $data = [

                    'appkey' => env('APP_KEY_BUSINESS_LINE'),
                    'delivery' => [
                        'deliveryType' => [
                            'type' => 'auto'
                        ],
                        'derival' => [
                            'produceDate' => $start_date_delivery,
                            'variant' => 'address',
                            'address' => [
                                'search' => $star_address->nomination
                            ],
                            "time" => [
                                "worktimeEnd" => "19:30",
                                "worktimeStart" => "9:00",
                                "breakStart" => "12:00",
                                "breakEnd" => "13:00",
                                "exactTime" => false
                            ]
                        ],
                        'arrival' => [
                            'variant' => 'address',
                            'address' => [
                                'search' => $end_address->nomination
                            ],
                            "time" => [
                                "worktimeEnd" => "19:30",
                                "worktimeStart" => "9:00",
                                "breakStart" => "12:00",
                                "breakEnd" => "13:00",
                                "exactTime" => false
                            ]
                        ],
                    ],
                    'cargo' => [
                        'quantity' => $count_cargo_unit,
                        'length' => $palletSize->length,
                        'width' => $palletSize->width,
                        'height' => $palletSize->height,
                        'weight' => $weight_general / $count_cargo_unit,
                        'totalWeight' => $weight_general,
                        'totalVolume' => $palletSize->length * $palletSize->width * $palletSize->height,
                    ]

                ];

            }


            $response = Http::post('https://api.dellin.ru/v2/calculator', $data);

            // Проверка ответа от сервера
            if ($response->successful()) {

                // Обработка успешного ответа
                $result = $response->json();
                // Можно, например, вывести результат
                $price_line_business = $result['data']['price'];

            } else {

                $responseBody = json_decode($response->body(), true);
                $jsonString = json_encode($responseBody, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); // обратно получили JSON-СТРОКУ

                Mylog($jsonString);

                $price_line_business = 0;

            }
        }


        try { //временно по задачи добавляем такое условие, что цены всегда приходит даже при ошибке


            //Получаем расстояние между адрессами, что бы найти цену за 1км
            $distance = $interactor->calculateVectorLength($star_address->latitude, $star_address->longitude, $end_address->latitude, $end_address->longitude);


            //TODO Нужна логика высчитывание цены в зависимости от заказа
            $test = "test";

            return response()->json(array_success(OrderPriceResource::make($test, $distance / 1000, $price_line_business), 'Return Select Price.'), 200);

        } catch (\Throwable $th) {

            $faker =  Faker::create();
            $distance = $faker->numberBetween(15, 6000);

            $test = "test";

            return response()->json(array_success(OrderPriceResource::make($test, $distance, $price_line_business), 'Return Select Price.'), 200);

        }


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

    /** Обновление заказа в статусе 'черновик' */
    public function updateDraft(
        OrderUnit $orderUnit,
        OrderUnitCreateRequest $request,
        OrderUnitService $service,
    ) {


        abort_unless(StatusOrderUnitEnum::isDraft($orderUnit->actual_status->status), 403, "Статус у заказа должен быть 'Черновик'");

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

        /** @var OrderUnitCreateDTO  */
        $dto  = OrderUnitCreateDTO::make(
            orderUnitVO: $orderUnitVO,
            orderUnitAddressDTO: $orderUnitAddressDTO,
            cargoGoodVO : $cargoGoodVO,
        );

        /** @var OrderUnit */
        $order = $service->updateDraftOrderUnit(
            dto: $dto,
            order: $orderUnit,
        );


        return response()->json(array_success(OrderUnitResource::make($order), 'Update Order Unit Successfully.'), 200);

    }

    //вернуть все статусы у заказа
    public function statuses(OrderUnit $orderUnit)
    {

        /** @var Collection */
        $statuses = $orderUnit->order_unit_statuses;

        return ($statuses->isNotEmpty())
            ? response()->json(array_success(OrderUnitStatusCollection::make($statuses), 'Вернули лог статусов для заказа.'), 200)
            : response()->json(array_error(null, 'Вернули лог статусов для заказа.'), 404);
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
    public function getContractorsAll(
        GetTypeCabinetByOrganization $action,
    )
    {
        /** @var array */
        $array = $action->isCustomer();

        /** @var Organization */
        $organization = $array['organization'];

        /** @var OrderUnit */
        $order_units = $organization->order_units()->pluck('id');

        $invoices = OrganizationOrderUnitInvoice::whereIn('order_unit_id', $order_units)->get();

        return response()->json(array_success(OrgOrderInvoiceCollection::make($invoices), 'Возвращены все подрядчики откликнувшиеся на заказ для организации заказчика.'), 200);
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
