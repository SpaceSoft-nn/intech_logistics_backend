<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectroMovent;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectroMovent\Distance\DistanceAlgorithmVectorMovent;
use App\Modules\OrderUnit\Domain\Interface\Algorithm\IVectorMoventAlgorithm;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

/**
 * Класс который проверяет, что вектор находящийся в прямоугольнике (является попутным главному вектору, а не обратным)
 */
final class VectorMoventTrue
{

    public function __construct(
        public IVectorMoventAlgorithm $distanceAlgorith,
    ) { }


    /**
    * @param OrderUnit $mainVector
    * @param \Illuminate\Database\Eloquent\Collection<int, OrderUnit> $orders
    *
    * @return [type]
    */
    public function run(OrderUnit $mainVector, Collection $otherVector)
    {
        $this->startLogic($mainVector, $otherVector);
    }

    /**
     * Подготовка и запуск в работу логики алгоритма
     * @param \Illuminate\Database\Eloquent\Collection<int, OrderUnit> $orders
     *
     * @return [type]
     */
    private function startLogic(OrderUnit $mainVector, Collection $otherVector)
    {


        $result = $otherVector->map(function ($item) use ($mainVector)  {

            // Это наш коллбэк, который определяет, нужно ли возвращать элемент или нет
            if ($this->distanceAlgorith->run($mainVector, $item)) {
                return $item;
            }

            // Вернуть null, если алгоритм не прошёл проверку
            return null;

        })->filter();

        return $result;
    }

}
