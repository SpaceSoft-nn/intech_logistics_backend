<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectroMovent\Azimut;

use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Interface\Algorithm\IVectorMoventAlgorithm;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Support\Collection;

/**
 *  Класс алгоритма по вычислению вектора и его направления относительно главного по дистанции азимуту векторов
 */
final class AzimutAlgorithmVectorMovent implements IVectorMoventAlgorithm
{


    public function __construct(
        private OrderUnitRepository $repOrdeUnit,
    ) { }


    public function run(OrderUnit $mainVector, OrderUnit $otherVector) : bool
    {
        return $this->interactorLogic($mainVector, $otherVector);
    }

    /**
     * Возваращет true, если вектор будет направлен в сторону главного вектора
     * @param Collection $mainVector
     * @param Collection $otherVector
     *
     * @return bool
     */
    private function trueAzimut(Collection $mainVector, Collection $otherVector) : bool
    {
        #TODO Нужно в будущем уменьшить угол, т.к если он будет искать ровно до 90 - у нас будет не очень хорошая ситуация на карте при двежнии
        $coordinatMainStart = $mainVector->first();
        $coordinatMainEnd = $mainVector->last();

        $coordinatOtherStart = $otherVector->first();
        $coordinatOtherEnd = $otherVector->last();


        $azimutMainVector = $this->calculateBearing($coordinatMainStart[0], $coordinatMainStart[1], $coordinatMainEnd[0], $coordinatMainEnd[1]);
        $azimutOtherVector = $this->calculateBearing($coordinatOtherStart[0], $coordinatOtherStart[1], $coordinatOtherEnd[0], $coordinatOtherEnd[1]);


        //получаем значения азимута в области круга 360
        $azimutMainVector90gradUp = $this->addNinteDegree($azimutMainVector + 90);
        $azimutMainVector90gradDown = $this->addNinteDegree($azimutMainVector - 90);


        //проверяем что вектор попадает в границу направления главного вектора
        if( $azimutMainVector90gradUp >= $azimutOtherVector && $azimutOtherVector <= $azimutMainVector90gradDown)
        {
            return true;
        }

        return false;

    }

    /**
     * маппинг + вызов логики TrueAzimut
     * @param OrderUnit $mainVector
     * @param OrderUnit $otherVector
     *
     * @return [type]
     */
    private function interactorLogic(OrderUnit $mainVector, OrderUnit $otherVector) : bool
    {
        $mainVectorCoordinat = $this->mappingVectorCordinatToArray($mainVector);
        $otherVectorCoordinat = $this->mappingVectorCordinatToArray($otherVector);

        return $this->trueAzimut($mainVectorCoordinat, $otherVectorCoordinat);
    }

    /**
     * получаем значения азимута в области значения круга 360 градусов
     * @param float $azimut
     *
     * @return float
     */
    private function addNinteDegree(float $azimut) : float
    {
        return ($azimut >= 0) ? ($azimut % 360) : (360 + ($azimut % 360));
    }

    /**
     * Мапим из модели в массив координат
     * @param OrderUnit $mainVector - Это наш вектор движение или другими словами Order
     *
     * @return Collection
    */
    private function mappingVectorCordinatToArray(OrderUnit $otherOrder) : Collection
    {



        /**
        * @var Adress
        */
        $adressStart = $this->repOrdeUnit->firstPivotPriorityAdress($otherOrder);
        $adressEnd = $this->repOrdeUnit->lastPivotPriorityAdress($otherOrder);

        return collect([
            [$adressStart->latitude, $adressStart->longitude],
            [$adressEnd->latitude, $adressEnd->longitude],
        ]);
    }

    /**
    * Вычисляет угол азимута.
    */
    private function calculateBearing($lat1, $lng1, $lat2, $lng2) : float
    {

        //Вычисление разности долготы между двумя точками (в радианах).
        $deltaLng = deg2rad($lng2 - $lng1);

        //Преобразование широты обеих точек из градусов в радианы.
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);

        //Вычисление компонентов y и x:
        $y = sin($deltaLng) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos(   $deltaLng);

        $bearing = rad2deg(atan2($y, $x));

        return (fmod($bearing + 360, 360)); // в градусах
    }
}
