<?php

namespace App\Modules\OrderUnit\Domain\Interactor;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\RentagleArrayVO;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Exception;
use Illuminate\Database\Eloquent\Collection;

use function App\Helpers\Mylog;

final class CoordinateCheckerInteractor
{
    private $distance = 100000; // высота прямоугольника

    public function setDistance(int $dist) : self
    {
        $this->distance = $dist;
        return $this;
    }

    /**
     * Запускаем в работу методв поиска точки в прямоугольнике основного вектора
     * @param \Illuminate\Database\Eloquent\Collection<int, OrderUnit> $orders
     * @param RentagleArrayVO $sortPoints
     *
     * @return array
     */
    public function checkCoordinatesInRectangle(Collection $orders, RentagleArrayVO $sortPoint) : array
    {
        $rentagle = $this->buildingRectangle($sortPoint->startLat, $sortPoint->startLng, $sortPoint->endLat, $sortPoint->endLng);
        
        try {
            $vectors = $this->mappingArrayCollection($orders);
        } catch (\Throwable $th) {
            Mylog("Ошибка в алгоритме OrderUnit Algorithm, при маппинге Collection");
            throw new Exception("Ошибка на стороне сервера", 500);
        }

        $result = $this->checkCoordinatesInRectangleInner($vectors , $rentagle);

        return $result;
    }


    private function mappingArrayCollection(Collection $orders) : array
    {
        //подготавливаем наш массив к функции
        $cordinstes = $orders->flatMap(function($order) {

            return [
                $order->id => [
                    ['lat' => $order->adress_start->latitude , 'lng' => $order->adress_start->longitude],
                    ['lat' => $order->adress_end->latitude , 'lng' => $order->adress_end->longitude],
                ]
            ];

        })->all();

        return $cordinstes;
    }

    public function checkCoordinatesInRectangleInner(array $vectors , array $sortPoints)
    {
        // Массив для хранения результатов проверки для каждого подмассива координат
        return collect($vectors)->filter(function ($coordinates) use ($sortPoints) {
            $start = $coordinates[0];
            $end = $coordinates[1];

            return $this->isPointInPolygon($start, $sortPoints) && $this->isPointInPolygon($end, $sortPoints);
        })->keys()->all();

    }

    public function buildingRectangle(
        float $startLat,
        float $startLng,
        float $endLat,
        float $endLng,
    ) : array {

        // Азимут вектора
        $bearing = $this->calculateBearing($startLat, $startLng, $endLat, $endLng);

        // Уменьшение на 90 градусов для перпендикуляра вверх
        $upVectorStart = $this->calculateOffsetCoordinates($startLat, $startLng, $bearing - 90 , $this->distance);

        // Увеличение на 90 градусов для перпендикуляра вниз
        $downVectorStart = $this->calculateOffsetCoordinates($startLat, $startLng, $bearing + 90  ,  $this->distance);

        // Уменьшение на 90 градусов для перпендикуляра вверх
        $upVectorEnd = $this->calculateOffsetCoordinates($endLat, $endLng, $bearing - 90,  $this->distance);

        // Увеличение на 90 градусов для перпендикуляра вниз
        $downVectorEnd = $this->calculateOffsetCoordinates($endLat, $endLng, $bearing + 90 ,  $this->distance);

        $points = [
            $upVectorStart,
            $downVectorStart,
            $upVectorEnd,
            $downVectorEnd,
        ];

        //отсортированный массив (прямоугольник)
        return $this->sortPointsClockwise($points);
    }

    private function isPointInPolygon($coordinate, $polygon)
    {
        $x = $coordinate['lat'];
        $y = $coordinate['lng'];
        $inside = false;
        $numPoints = count($polygon);
        $j = $numPoints - 1;

        for ($i = 0; $i < $numPoints; $i++) {
            $xi = $polygon[$i]['lat'];
            $yi = $polygon[$i]['lng'];
            $xj = $polygon[$j]['lat'];
            $yj = $polygon[$j]['lng'];

            //метода трассировки луча
            $intersect = (($yi > $y) != ($yj > $y)) && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
            if ($intersect) {
                $inside = !$inside;
            }
            $j = $i;
        }

        return $inside;
    }

    private function sortPointsClockwise($points) : array
    {
        // Вычисление центра прямоугольника
        $centerLat = array_sum(array_column($points, 'lat')) / count($points);
        $centerLng = array_sum(array_column($points, 'lng')) / count($points);

        // Сортировка точек по углу относительно центра
        usort($points, function($a, $b) use ($centerLat, $centerLng) {
            $angleA = atan2($a['lat'] - $centerLat, $a['lng'] - $centerLng);
            $angleB = atan2($b['lat'] - $centerLat, $b['lng'] - $centerLng);

            // Поскольку мы хотим упорядочить точки по часовой стрелке, используем сравнение углов.
            return $angleB <=> $angleA;
        });

        return $points;
    }


    /**
     * Вычисляет длину вектора между двумя точками в метрах.
     */
    public function calculateVectorLength($lat1, $lng1, $lat2, $lng2) {
        $earthRadius = 6371000; // радиус Земли в метрах

        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLng = deg2rad($lng2 - $lng1);

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($deltaLng / 2) * sin($deltaLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance; // в метрах
    }

    /**
     * Вычисляет угол азимута.
     */
    public function calculateBearing($lat1, $lng1, $lat2, $lng2) {
        $deltaLng = deg2rad($lng2 - $lng1);
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);

        $y = sin($deltaLng) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($deltaLng);
        $bearing = rad2deg(atan2($y, $x));

        return (fmod($bearing + 360, 360)); // в градусах
    }

    /**
     * Вычисляет смещенные координаты по азимуту и расстоянию.
     */
    private function calculateOffsetCoordinates($lat, $lng, $bearing, $distance) : array
    {
        $earthRadius = 6371000; // радиус Земли в метрах

        $bearing = deg2rad($bearing); // преобразуем азимут в радианы
        $lat = deg2rad($lat);
        $lng = deg2rad($lng);

        $newLat = asin(sin($lat) * cos($distance / $earthRadius) +
                    cos($lat) * sin($distance / $earthRadius) * cos($bearing));
        $newLng = $lng + atan2(sin($bearing) * sin($distance / $earthRadius) * cos($lat),
                            cos($distance / $earthRadius) - sin($lat) * sin($newLat));


        return [
            'lat' => rad2deg($newLat),
            'lng' => rad2deg($newLng)
        ];
    }
}
