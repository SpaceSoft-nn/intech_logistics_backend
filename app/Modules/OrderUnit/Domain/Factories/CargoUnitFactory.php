<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoUnitVO;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\PalletSpace\Domain\Models\PalletSpace;
use Illuminate\Database\Eloquent\Factories\Factory;

class CargoUnitFactory extends Factory
{
    protected $model = CargoUnit::class;

    public function definition(): array
    {
        /**
        * @var PalletSpace
        */
        $palletSpace = PalletSpace::factory()->create();

        /**
        * @var CargoUnitVO
        */
        $cargoUnitVO = CargoUnitVO::make(
            description: $this->faker->text(),
            pallets_space_id: $palletSpace->id,
            customer_pallets_space : null,
        );

        return $cargoUnitVO->toArrayNotNull();
    }

}
