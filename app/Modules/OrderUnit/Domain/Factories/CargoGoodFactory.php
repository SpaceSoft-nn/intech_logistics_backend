<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\OrderUnit\App\Data\DTO\CargoUnitToCargoGood\CargoUnitToCargoGoodDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\Domain\Actions\LinkCargoUnitToCargoGoodAction;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\OrderUnit\Domain\Models\Mgx;

use Illuminate\Database\Eloquent\Factories\Factory;

class CargoGoodFactory extends Factory
{
    protected $model = CargoGood::class;

    public function definition(): array
    {

        {

            /**
            * @var CargoGoodVO
            */
            $orderUnitVO = CargoGoodVO::make(
                product_type: $this->faker->word(),
                cargo_units_count: $this->faker->numberBetween(4, 12),
                body_volume: $this->faker->randomFloat(2, 1, 80),
                type_pallet: $this->faker->randomElement(['eur', 'fin', 'eco']),
                mgx: null,
                name_value: $this->faker->words(3, true),
                description: $this->faker->text(100),
            );

            return $orderUnitVO->toArrayNotNull();
        }

    }
    public function configure(): static
    {
        // Добавляем теги после создания поста
        return $this->afterCreating(function (CargoGood $cargoGood) {

            /**
            * @var Mgx
            */
            Mgx::factory()->create([
                'cargo_good_id' => $cargoGood->id
            ]);


            for ($i = 0; $i < $cargoGood->cargo_units_count; $i++) {

                $cargoUnit = CargoUnit::factory()->create([
                    'pallets_space' => $cargoGood->type_pallet,
                ]);

                LinkCargoUnitToCargoGoodAction::run(
                    CargoUnitToCargoGoodDTO::make(
                        cargoGood: $cargoGood,
                        cargoUnit: $cargoUnit,
                        factor: 95,
                    )
                );

            }



        });
    }


}
