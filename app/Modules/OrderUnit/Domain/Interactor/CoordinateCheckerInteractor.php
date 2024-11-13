<?php

namespace App\Modules\OrderUnit\Domain\Interactor;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\RentagleArrayVO;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectroMovent\VectorMoventTrue;
use App\Modules\OrderUnit\Domain\Interface\Trait\Algorithm\CalculateBearingTrait;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Exception;
use Illuminate\Database\Eloquent\Collection;

use function App\Helpers\Mylog;


final class CoordinateCheckerInteractor
{

    use CalculateBearingTrait;

    private $distance = 100000; // высота прямоугольника
    private Collection $otherVector; //Добавляем массив "всех" OrderUnit (что бы не запрашивать каждый раз из БД)
    private OrderUnit $mainVector; //Добавляем массив "всех" OrderUnit (что бы не запрашивать каждый раз из БД)

    public function __construct(
        public VectorMoventTrue $vectorMov,
        public OrderUnitRepository $repOrderUnit,
    ) { }


    /**
     * Устанавливаем явно высоту прямоугольника
     * @param int $dist
     *
     * @return self
     */
    public function setDistance(int $dist) : self
    {
        $this->distance = $dist;
        return $this;
    }

    #TODO Вынести в сервес, разделить логику создание прямоугольника и остальных алгоритмов (будут пополняться), использовать цепочку обязанностей handler + декоратор
    /**
     * @param OrderUnit $mainVector
     * @param \Illuminate\Database\Eloquent\Collection<int, OrderUnit> $otherVector
     *
     * @return [type]
     */
    public function run(OrderUnit $mainVector, Collection $otherVector)
    {

        $this->otherVector = $otherVector;
        $this->mainVector = $mainVector;


        //строим прямоугольник проверяем что вектора входят
        $data = $this->checkCoordinatesInRectangle(RentagleArrayVO::make($mainVector), $otherVector);



        //проверяем что вектора которые входят, направлены в попутном направлении относительно главного вектора
        return $this->runVectorMoventTrue($data);
    }


    /**
     * Добавляем алгоритм проверки направления вектора
     * @return [type]
     */
    private function runVectorMoventTrue(array $data) : array
    {
        $data = $this->otherVector->find($data);

        return $this->vectorMov->run($this->mainVector, collect($data));
    }

    /**
     * Запускаем в работу метод поиска точки в прямоугольнике основного вектора
     * @param \Illuminate\Database\Eloquent\Collection<int, OrderUnit> $orders
     * @param RentagleArrayVO $sortPoints
     *
     * @return array
     */
    private function checkCoordinatesInRectangle(RentagleArrayVO $sortPoint, Collection $orders) : array
    {

        $rentagle = $this->buildingRectangle($sortPoint->startLat, $sortPoint->startLng, $sortPoint->endLat, $sortPoint->endLng);

        $vectors = $this->mappingArrayCollection($orders);

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

            $address_start = $this->repOrderUnit->firstPivotPriorityAddress($order);
            $address_end =  $this->repOrderUnit->lastPivotPriorityAddress($order);

            dd

            return [
                $order->id => [
                    ['lat' => $address_start->latitude , 'lng' => $address_start->longitude],
                    ['lat' => $address_end->latitude , 'lng' => $address_end->longitude],
                ]
            ];

        })->all();


        return $cordinstes;
    }

    private function checkCoordinatesInRectangleInner(array $vectors , array $sortPoints)
    {
        // Массив для хранения результатов проверки для каждого подмассива координат
        return collect($vectors)->filter(function ($coordinates) use ($sortPoints) {
            $start = $coordinates[0];
            $end = $coordinates[1];

            return $this->isPointInPolygon($start, $sortPoints) && $this->isPointInPolygon($end, $sortPoints);
        })->keys()->all();

    }

    //Создаём прямоугольник
    private function buildingRectangle(
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


    /**
     * Входят ли координаты в прямоугольник
     * @param mixed $coordinate
     * @param mixed $polygon
     *
     * @return bool
     */
    private function isPointInPolygon($coordinate, $polygon) : bool
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

    /**
     * Упорядочивание координат для создание прямоугольника
     * @param mixed $points
     *
     * @return array
     */
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
    public function calculateVectorLength($lat1, $lng1, $lat2, $lng2) : float
    {
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
     * Вычисляет смещенные координаты по азимуту и расстоянию.
     * P.S Тут добавляем расстояние смещение от главной координаты + угол, к примеру 90 градусов на 150 км (Будет перпендикуляр от начальной точки вектора навверх)
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
