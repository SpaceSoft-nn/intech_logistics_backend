<?php

namespace App\Http\Controllers\API\OrderUnit;

use App\Http\Controllers\Controller;
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

    public function algorithm(Request $request)
    {
        $lat1 = 55.5904650;
        $lon1 = 37.6593260;
        $lat2 = 55.7628140;
        $lon2 = 49.2325460;

        // Пример других точек, которые нужно проверить
        $otherPoints = [
            [55.7, 40.0],
            [56.0, 50.0]
        ];

        list($lat, $lon) = $otherPoints[0];

        $perpendicularDistance = $this->crossTrackDistance($lat1, $lon1, $lat2, $lon2, $lat, $lon);

        // Шаг 1: Расчет основного угла
        $bearing = $this->initialBearing($lat1, $lon1, $lat2, $lon2);

        // Определение максимального допустимого расстояния по пути
        $maxDistance = $this->haversineDistance($lat1, $lon1, $lat2, $lon2);

        // Проверка, находятся ли другие точки в этой области
        foreach ($otherPoints as $point) {
            $isInArea = $this->isPointInPathArea($lat1, $lon1, $lat2, $lon2, $point, $maxDistance, 150);
            echo "Point (" . $point[0] . ", " . $point[1] . ") is " . ($isInArea ? "inside" : "outside") . " the area.\n";
        }

    }

    // Функция для вычисления азимута
    private function initialBearing($lat1, $lon1, $lat2, $lon2) {
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $dlon = deg2rad($lon2 - $lon1);

        $y = sin($dlon) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dlon);

        $bearing = atan2($y, $x);
        return (rad2deg($bearing) + 360) % 360;
    }

    // Функция для проверки, находится ли точка в области
    private function isPointInPathArea($lat1, $lon1, $lat2, $lon2, $point, $maxDistance, $sideDistance) {
        list($lat, $lon) = $point;

        $distanceToPoint = $this->haversineDistance($lat1, $lon1, $lat, $lon);

        // Проверка, находится ли точка на правильной стороне пути
        if ($distanceToPoint <= $maxDistance) {
            // Вычисление азимута к точке
            $bearingToPoint = $this->initialBearing($lat1, $lon1, $lat, $lon);
            $bearingFromStartToEnd = $this->initialBearing($lat1, $lon1, $lat2, $lon2);

            // Определение перпендикулярного расстояния от основной линии до точки
            $perpendicularDistance = $this->crossTrackDistance($lat1, $lon1, $lat2, $lon2, $lat, $lon);

            // Проверка перпендикулярного расстояния
            if (abs($perpendicularDistance) <= $sideDistance) {
                return true;
            }
        }
        return false;
    }

    // Функция для вычисления перпендикулярного расстояния
    private function crossTrackDistance($lat1, $lon1, $lat2, $lon2, $lat, $lon) {
        $R = 6371; // Радиус Земли в километрах
        $d13 = $this->haversineDistance($lat1, $lon1, $lat, $lon) / $R;
        $theta13 = deg2rad($this->initialBearing($lat1, $lon1, $lat, $lon));
        $theta12 = deg2rad($this->initialBearing($lat1, $lon1, $lat2, $lon2));

        $dXt = asin(sin($d13) * sin($theta13 - $theta12)) * $R;
        return $dXt;
    }

    // Функция для вычисления расстояния по формуле Haversine
    private function haversineDistance($lat1, $lon1, $lat2, $lon2) {
        $R = 6371; // Радиус Земли в километрах

        // Перевод координат из градусов в радианы
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        // Формула Haversine
        $a = sin($deltaLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($deltaLon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c; // Расстояние в километрах
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
