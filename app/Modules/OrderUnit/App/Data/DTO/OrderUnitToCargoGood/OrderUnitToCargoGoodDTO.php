<?php

namespace App\Modules\OrderUnit\App\Data\DTO\CargoUnitToCargoGood;

use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;


final readonly class OrderUnitToCargoGoodDTO
{
    public function __construct(

        public CargoGood $cargoGood,
        public OrderUnit $orderUnit,
    ) { }

    public static function make(

        CargoGood $cargoGood,
        OrderUnit $orderUnit,

    ) : self {

        return new self(
            cargoGood: $cargoGood,
            orderUnit: $orderUnit,
        );

    }

}
