<?php

namespace App\Modules\OrderUnit\Domain\Actions;

use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;

use function App\Helpers\Mylog;

class LinkOrderUnitToCargoUnitAction
{
    /**
     * Устанавливаем связь многие ко многим через промежуточную таблицу
     * @param OrderUnit $orderUnit
     * @param CargoUnit $cargoUnit
     *
     * @return bool
     */
    public static function run(OrderUnit $orderUnit, CargoUnit $cargoUnit) : bool
    {
        try {

            //Сохраняем связь от user к personal area
            $orderUnit->cargo_units()->syncWithoutDetaching([ $cargoUnit->id => ['factor' => 1] ]);

            return true;

        } catch (\Throwable $th) {

            Mylog($th, 'Ошибка при линковке связи многие:многие - LinkOrderUnitToCargoUnitAction');
            return false;

        }

    }
}
