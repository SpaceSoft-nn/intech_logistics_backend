<?php

namespace App\Modules\Matrix\Domain\Factories;


use App\Modules\Matrix\App\Data\DTO\RegionEconomicFactorDTO;
use App\Modules\Matrix\Domain\Models\RegionEconomicFactor;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegionEconomicFactorFactory extends Factory
{
    protected $model = RegionEconomicFactor::class;

    public function definition(): array
    {

        $dtoArray = RegionEconomicFactorDTO::make(
            region_start_gar_id: $this->faker->uuid(),
            region_end_gar_id: $this->faker->uuid(),
            region_name_start: $this->faker->uuid(),
            region_name_end: $this->faker->uuid(),
            factor: 1,
            price: $this->faker->numberBetween(60, 110),
        )->toArray();

        return $dtoArray;
    }

}
