<?php

namespace App\Modules\OrderUnit\Domain\Actions;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnitToCargoGood\OrderUnitToCargoGood;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;

use function App\Helpers\Mylog;

class LinkOrderUnitToCargoGoodAction
{
    /**
     * @param OrderUnitToCargoGood $dto
     *
     * @return bool
     */
    public static function run(OrderUnitToCargoGood $dto) : bool
    {
        /**
        * @var CargoGood
        */
        $cargoGood = $dto->cargoGood;

        /**
        * @var CargoUnit
        */
        $cargoUnit = $dto->cargoUnit;

        try {

            //Сохраняем связь от user к personal area
            $cargoGood->cargo_units()->syncWithoutDetaching(
                [ $cargoUnit->id => ['factor' => $dto->factor] ]
            );

            return true;

        } catch (\Throwable $th) {

            Mylog($th, 'Ошибка при линковке связи многие:многие - LinkOrderUnitToCargoGoodAction');
            throw new \Exception('Ошибка в связывании LinkOrderUnitToCargoGoodAction', 500);

        }
        
        return false;
    }
}
