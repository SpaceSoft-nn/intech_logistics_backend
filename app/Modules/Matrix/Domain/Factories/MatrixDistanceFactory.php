<?php

namespace App\Modules\Matrix\Domain\Factories;

use App\Modules\Matrix\App\Data\DTO\MatrixDistanceVO;
use App\Modules\Matrix\Domain\Models\MatrixDistance;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatrixDistanceFactory extends Factory
{
    protected $model = MatrixDistance::class;

    public function definition(): array
    {


        $dtoArray = MatrixDistanceVO::make(
            city_start_gar_id: $this->faker->uuid(),
            city_end_gar_id: $this->faker->uuid(),
            city_name_start: $this->faker->city(),
            city_name_end: $this->faker->city(),
            distance: $this->faker->numberBetween(20, 1000),
        )->toArray();

        return $dtoArray;
    }

}
