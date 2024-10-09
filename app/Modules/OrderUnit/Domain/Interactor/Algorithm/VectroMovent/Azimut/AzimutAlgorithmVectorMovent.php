<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectroMovent\Azimut;

use App\Modules\OrderUnit\Domain\Interface\Algorithm\IVectorMoventAlgorithm;

/**
 *  Класс алгоритма по вычислению вектора и его направления относительно главного по дистанции азимуту векторов
 */
class AzimutAlgorithmVectorMovent implements IVectorMoventAlgorithm
{
    public function run(Collection $startCoordinat, Collection $otherVector) : bool
    {
        
    }
}
