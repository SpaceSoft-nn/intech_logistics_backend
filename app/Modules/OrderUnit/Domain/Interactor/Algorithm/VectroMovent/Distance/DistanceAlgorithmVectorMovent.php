<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectroMovent\Distance;

use App\Modules\OrderUnit\Domain\Interface\Algorithm\IVectorMoventAlgorithm;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Support\Collection;

/**
 * Класс алгоритма по вычислению вектора и его направления относительно главного по дистанции векторов
 */
class DistanceAlgorithmVectorMovent implements IVectorMoventAlgorithm
{
    public function run(OrderUnit $mainVector, OrderUnit $otherVector) : bool
    {
        $arrayStartMainVector = $this->mappingMainVector($mainVector);

        $itemCoordinat = $this->mappingVectorCordinatToArray($otherVector);

        return $this->statusVectorDirections($arrayStartMainVector, $itemCoordinat);
    }

    private function statusVectorDirections(Collection $startCoordinat, Collection $otherVector) : bool
    {

        $starOtherVectorStart = $otherVector->first();
        $starOtherVectorEnd = $otherVector->last();

        //Высчитываем расстояние координат начального вектора и координаты конца другого вектора
        $startMain_endOther = $this->calculateVectorLength($startCoordinat[0], $startCoordinat[1], $starOtherVectorEnd[0], $starOtherVectorEnd[1]);

        //Высчитываем расстояние координат начального вектора и координаты начало другого вектора
        $startMain_startOther = $this->calculateVectorLength($startCoordinat[0], $startCoordinat[1], $starOtherVectorStart[0], $starOtherVectorStart[1]);

        return $this->trueDirection($startMain_startOther, $startMain_endOther);
    }

    /**
     * Метод для сравнения расстояний, если расстояние $startMain_startOther (Начало главного вектора/ Начало другого вектора)
     * меньше, чем $startMain_endOther (Начало главного вектора/ Конец другого вектора), то возвращаем true, значит направления
     * дополнительного вектора в сторону главного вектора
     * @param float $startMain_startOther
     * @param float $startMain_endOther
     *
     * @return bool
     */
    private function trueDirection(float $startMain_startOther, float $startMain_endOther) : bool
    {
        return ($startMain_startOther < $startMain_endOther) ? true : false;
    }

    /**
    * Вычисляет длину вектора между двумя точками в метрах.
    */
    private function calculateVectorLength($lat1, $lng1, $lat2, $lng2) {
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
     * Мапим из модели в массив координат
     * @param OrderUnit $mainVector
     *
     * @return Collection
     */
    private function mappingVectorCordinatToArray(OrderUnit $otherOrder) : Collection
    {
        /**
        * @var Adress
        */
        $adressStart = $otherOrder->adress_start;
        $adressEnd = $otherOrder->adress_end;

        return collect([
            [$adressStart->latitude, $adressStart->longitude],
            [$adressEnd->latitude, $adressEnd->longitude],
        ]);
    }

    /**
     * Мапим основной вектор и присылаем начальную координату
     * @param OrderUnit $mainVector
     *
     * @return Collection
     */
    private function mappingMainVector(OrderUnit $mainVector) : Collection
    {
        /**
        * @var Adress
        */
        $adress = $mainVector->adress_start;

        return collect([$adress->latitude, $adress->longitude]);
    }
}
