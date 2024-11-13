<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoUnitVO;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

class CargoUnitFactory extends Factory
{
    protected $model = CargoUnit::class;

    public function definition(): array
    {
        /**
        * @var CargoUnitVO
        */
        $cargoUnitVO = CargoUnitVO::make(
            pallets_space: $this->faker->randomElement(['Паллет EUR', 'Паллет FIN', 'Паллет ECOM']),
            customer_pallets_space : false,
        );


        return $cargoUnitVO->toArrayNotNull();
    }

}
