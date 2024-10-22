<?php

namespace App\Http\Controllers\API\OrderUnit;

use App\Http\Controllers\Controller;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitUpdateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitCreate;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitUpdate;
use App\Modules\OrderUnit\Domain\Interactor\CoordinateCheckerInteractor;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitAlgorithmRequest;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitCreateRequest;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitSelectPriceRequest;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitUpdateRequest;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderPriceResource;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OredUnitCollection;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OredUnitResource;
use Illuminate\Http\Request;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class OrderUnitController extends Controller
{
    /**
     * Вернуть все заказы
     */
    public function get(Request $request)
    {
        /**
        * @var OrderUnit[]
        */
        $order = OrderUnit::all();

        return response()->json(array_success(OredUnitCollection::make($order), 'Return Orders.'), 200);
    }

    public function selectPrice(OrderUnitSelectPriceRequest $request)
    {
        $validated = $request->validated();
        // dd($validated, 1);


        // $order = OrderUnit::factory()->create([
        //     "adress_start_id" => $validated['start_adress_id'],
        //     "adress_end_id" => $validated['end_adress_id'],
        // ]);

        //TODO Нужна логика высчитывание цены в зависимости от заказа
        $test = "test";

        return response()->json(array_success(OrderPriceResource::make($test), 'Return Select Price.'), 200);
    }

    public function create(OrderUnitCreateRequest $request)
    {
        /**
        * @var OrderUnitVO
        */
        $orderUnitVO = $request->getValueObject();


        $order = OrderUnitCreate::make($orderUnitVO);


        return response()->json(array_success(OredUnitResource::make($order), 'Return create Order.'), 201);
    }

    public function update(OrderUnit $orderUnit, OrderUnitUpdateRequest $request)
    {
        $validated = $request->validated();

        $status = OrderUnitUpdate::make(
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
     * Поиск входящих векторов относительно главного вектора (заказа)
     * @param OrderUnitAlgorithmRequest $request
     * @param CoordinateCheckerInteractor $coordinator
     *
     * @return [type]
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

        return response()->json(array_success(OredUnitCollection::make($orders->find($rectangle)->values()->all()), 'Возвращены все заказы входящие в область, главного заказа.'), 200);
    }

}
