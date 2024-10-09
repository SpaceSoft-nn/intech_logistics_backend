<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectroMovent;

use App\Modules\OrderUnit\Domain\Interface\Algorithm\IVectorMoventAlgorithm;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Support\Collection;

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
    * @param Illuminate\Support\Collection<int, OrderUnit> $orders
    *
    * @return array
    */
    public function run(OrderUnit $mainVector, Collection $otherVector) : array
    {
        return $this->startLogic($mainVector, $otherVector);
    }

    /**
     * Подготовка и запуск в работу логики алгоритма
     * @param \Illuminate\Database\Eloquent\Collection<int, OrderUnit> $orders
     *
     * @return array
     */
    private function startLogic(OrderUnit $mainVector, Collection $otherVector) : array
    {


        $result = $otherVector->map(function ($item) use ($mainVector)  {

            // Это наш коллбэк, который определяет, нужно ли возвращать элемент или нет
            if ($this->distanceAlgorith->run($mainVector, $item)) {
                return $item->id;
            }
            // Вернуть null, если алгоритм не прошёл проверку
            return null;

        })->filter()->all();

        return $result;
    }

}
