<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\MgxVO;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use Illuminate\Database\Eloquent\Factories\Factory;

class MgxFactory extends Factory
{
    protected $model = Mgx::class;

    public function definition(): array
    {
        /**
        * @var MgxVO
        */
        $mgxVO = MgxVO::make(
            width: $this->faker->randomFloat(2, 1, 6),
            length: $this->faker->randomFloat(2, 1, 6),
            height: $this->faker->randomFloat(2, 1, 6),
            weight: $this->faker->numberBetween(10000, 38000),
        );

        return $mgxVO->toArray();
    }

}
