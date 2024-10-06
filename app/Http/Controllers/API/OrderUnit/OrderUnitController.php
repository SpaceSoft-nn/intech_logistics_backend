<?php

namespace App\Http\Controllers\API\OrderUnit;

use App\Http\Controllers\Controller;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\RentagleArrayVO;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Interactor\CoordinateCheckerInteractor;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
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

    public function algorithm(Request $request, CoordinateCheckerInteractor $coordinator)
    {
        $startLat = 55.0694070;
        $startLng = 32.6917860;
        $endLat = 55.8931570;
        $endLng = 52.3094200;

        $orders = OrderUnit::all()->where("order_status", StatusOrderUnitEnum::wait);

        $cordinstes = $orders->flatMap(function($order) {

            return [
                $order->id => [
                    ['lat' => $order->adress_start->latitude , 'lng' => $order->adress_start->longitude],
                    ['lat' => $order->adress_end->latitude , 'lng' => $order->adress_end->longitude],
                ]
            ];

        })->all();

        $rectangle = $coordinator->checkCoordinatesInRectangle($cordinstes, RentagleArrayVO::make($startLat, $startLng, $endLat, $endLng));

        $orders = OredUnitCollection::make($orders->find($rectangle));

        dd($orders);
    }




    // public function algorithm(Request $request)
    // {
    //     $lat1 = 55.5904650;
    //     $lon1 = 37.6593260;
    //     $lat2 = 55.7628140;
    //     $lon2 = 49.2325460;


    //     // Шаг 1: Расчет основного угла
    //     // Получаем основной угол в радианах и преобразуем его в градусы
    //     $bearing = $this->initialBearing($lat1, $lon1, $lat2, $lon2);


    //     // Шаг 2: Расчет расстояния
    //     $distance = $this->haversineDistance($lat1, $lon1, $lat2, $lon2);


    //     // Шаг 3: Новые углы
    //     {
    //         $newBearing1 = fmod(($bearing + 30 + 360), 360);
    //         $newBearing2 = fmod(($bearing - 30 + 360), 360);
    //     }

    //     {
    //         // Шаг 4: Преобразование углов в радианы
    //         $newBearing1Rad = deg2rad($newBearing1);
    //         $newBearing2Rad = deg2rad($newBearing2);
    //     }

    //     dd($newBearing1, $newBearing2,  $bearing);


    // }


    // // Функция для вычисления азимута
    // function initialBearing($lat1, $lon1, $lat2, $lon2) {
    //     $lat1 = deg2rad($lat1);
    //     $lat2 = deg2rad($lat2);
    //     $dlon = deg2rad($lon2 - $lon1);

    //     $y = sin($dlon) * cos($lat2);
    //     $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dlon);

    //     $bearing = atan2($y, $x);
    //     return (rad2deg($bearing) + 360) % 360;
    // }


    // private function haversineDistance($lat1, $lon1, $lat2, $lon2) {
    //     $R = 6371; // Радиус Земли в километрах

    //     // Перевод координат из градусов в радианы
    //     $lat1 = deg2rad($lat1);
    //     $lon1 = deg2rad($lon1);
    //     $lat2 = deg2rad($lat2);
    //     $lon2 = deg2rad($lon2);

    //     $deltaLat = $lat2 - $lat1;
    //     $deltaLon = $lon2 - $lon1;

    //     // Формула Haversine
    //     $a = sin($deltaLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($deltaLon / 2) ** 2;
    //     $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    //     return $R * $c; // Расстояние в километрах
    // }
}
