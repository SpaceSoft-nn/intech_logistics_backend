<?php

namespace App\Http\Controllers\API\OrderUnit;

use App\Http\Controllers\Controller;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Interactor\CoordinateCheckerInteractor;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitAlgorithmRequest;
use App\Modules\OrderUnit\Domain\Requests\OrderUnit\OrderUnitCreateRequest;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OredUnitCollection;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OredUnitResource;
use Illuminate\Http\Request;

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

    public function create(OrderUnitCreateRequest $request)
    {
        $validated = $request->validated();

        $order = OrderUnit::factory()->create([
            "adress_start_id" => $validated['start_adress_id'],
            "adress_end_id" => $validated['end_adress_id'],
        ]);

        return response()->json(array_success(OredUnitResource::make($order), 'Return Orders.'), 200);
    }

    public function algorithm(OrderUnitAlgorithmRequest $request, CoordinateCheckerInteractor $coordinator)
    {

        $orders = OrderUnit::all()->where("order_status", StatusOrderUnitEnum::wait);

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
