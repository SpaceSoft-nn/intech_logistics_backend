<?php

namespace App\Modules\Matrix\Domain\Factories;

use App\Modules\GAR\Domain\Services\GARService;
use App\Modules\Matrix\App\Data\DTO\MatrixDistanceDTO;
use App\Modules\Matrix\Domain\Models\MatrixDistance;
use App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectorLength\calculateVectorLength;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatrixDistanceFactory extends Factory
{
    protected $model = MatrixDistance::class;

    public function definition(): array
    {


        $dtoArray = MatrixDistanceDTO::make(
            city_start_gar_id: $this->faker->uuid(),
            city_end_gar_id: $this->faker->uuid(),
            city_name_start: $this->faker->city(),
            city_name_end: $this->faker->city(),
            distance: $this->faker->numberBetween(20, 1000),
        )->toArray();

        return $dtoArray;
    }

}
