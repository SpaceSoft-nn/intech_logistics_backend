<?php

namespace App\Modules\OrderUnit\Domain\Actions\CargoUnit;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoUnitVO;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use Exception;

use function App\Helpers\Mylog;

class CreateCargoUnitAction
{
    /**
     * @param CargoUnitVO $vo
     *
     * @return CargoUnit
     */
    public static function make(CargoUnitVO $vo) : CargoUnit
    {
        return (new self())->run($vo);
    }

    /**
     * @param CargoUnitVO $vo
     *
     * @return CargoUnit
     */
    private function run(CargoUnitVO $vo) : CargoUnit
    {

        try {

            $сargoUnit = CargoUnit::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $сargoUnit;
    }
}
