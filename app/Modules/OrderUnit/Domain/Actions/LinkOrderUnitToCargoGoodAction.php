<?php

namespace App\Modules\OrderUnit\Domain\Actions;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnitToCargoGood\OrderUnitToCargoGoodDTO;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;

use function App\Helpers\Mylog;

class LinkOrderUnitToCargoGoodAction
{
    /**
     * @param OrderUnitToCargoGoodDTO $dto
     *
     * @return bool
     */
    public static function run(OrderUnitToCargoGoodDTO $dto) : bool
    {

        /**
        * @var CargoGood
        */
        $cargoGood = $dto->cargoGood;

        /**
        * @var OrderUnit
        */
        $orderUnit = $dto->orderUnit;

        try {

            //Сохраняем связь от user к personal area
            $cargoGood->order_units()->syncWithoutDetaching(
                [ $orderUnit->id ]
            );

            return true;

        } catch (\Throwable $th) {

            Mylog($th, 'Ошибка при линковке связи многие:многие - LinkCargoUnitToCargoGoodAction');
            throw new \Exception('Ошибка в связывании LinkCargoUnitToCargoGoodAction', 500);

        }

        return false;
    }
}
