<?php

namespace App\Modules\Transfer\Domain\Actions\LinkManyToMany;

use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\Transfer\Domain\Models\Transfer;

class LinkTransferToCargoUnitAction
{
      /**
     * Нам нужно сохранять связь многие ко многим таким способом (что бы laravel связи работали)
     * @param Transfer $transfer
     * @param CargoUnit $cargoUnit
     *
     * @return bool
     */
    public static function run(Transfer $transfer, CargoUnit $cargoUnit) : bool
    {
        try {

            //Сохраняем связь от user к personal area
            $transfer->cargo_units()->syncWithoutDetaching([$cargoUnit->id]);

            return true;

        } catch (\Throwable $th) {

            return false;

        }

    }
}
