<?php

namespace App\Modules\OrderUnit\App\Data\DTO\CargoUnitToCargoGood;

use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use Arr;
use InvalidArgumentException;

use function App\Helpers\Mylog;

final readonly class CargoUnitToCargoGoodDTO
{

    public function __construct(

        public CargoGood $cargoGood,
        public CargoUnit $cargoUnit,
        public float $factor,

    ) {


        // Проверка значения $factor
        if (! ($this->factor <= 100) ) {
            Mylog('Ошибка в OrderUnitToCargoGood, значение factor не должно быть больше 100');
            throw new InvalidArgumentException('Значение factor не должно быть больше 100.');
        }
    }

    public static function make(

        CargoGood $cargoGood,
        CargoUnit $cargoUnit,
        float $factor,

    ) : self {

        return new self(
            cargoGood: $cargoGood,
            cargoUnit: $cargoUnit,
            factor: $factor,
        );

    }

}
