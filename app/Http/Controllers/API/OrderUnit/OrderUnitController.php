<?php

namespace App\Http\Controllers\API\OrderUnit;

use App\Http\Controllers\Controller;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\RentagleArrayVO;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectroMovent\VectorMoventTrue;
use App\Modules\OrderUnit\Domain\Interactor\CoordinateCheckerInteractor;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Requests\OrderUnitAlgorithmRequest;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OredUnitCollection;
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
        $rectangle = $coordinator->checkCoordinatesInRectangle($orders, RentagleArrayVO::make($orderMain));

        return response()->json(array_success(OredUnitCollection::make($orders->find($rectangle)->values()->all()), 'Возвращены все заказы входящие в область, главного заказа.'), 200);
    }

    public function algorithm2(
        OrderUnitAlgorithmRequest $request,
        VectorMoventTrue $vectorMove,
        CoordinateCheckerInteractor $coordinator
    ) {

        $orders = OrderUnit::all()->where("order_status", StatusOrderUnitEnum::wait);

        {
            $orderMain = $orders->where('id', $request['main_order'])
                ->load('adress_start', 'adress_end')
                ->first();

            abort_if(is_null($orderMain), 404, "Предоставленный заказ не существует.");

            #TODO Изменить логику - будет большая нагрузка
            //Возвращаем все связи, либо в алгоритмах будет множество запросов.
            $orders = $orders->load('adress_start', 'adress_end');
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
        $rectangle = $coordinator->checkCoordinatesInRectangle($orders, RentagleArrayVO::make($orderMain));

        // dd($orderMain);
        // dd($orders->find($rectangle)->values());


        // $mainVector = collect([
        //     collect([$lat1 = 55.0694070, $lng1 = 32.6917860]),
        //     collect([$lat2 = 55.8931570, $lng2 = 52.3094200]),
        // ]);


        // $otherVector = collect([
        //     collect([$lat1 = 55.401565, $lng1 = 35.645124]),
        //     collect([$lat2 = 55.580045, $lng2 = 37.907854]),
        // ]);


        $status = $vectorMove->run($orderMain, $orders->find($rectangle)->values());

        dd(5);

    }

}
