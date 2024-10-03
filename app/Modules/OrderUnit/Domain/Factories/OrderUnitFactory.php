<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\OrderUnit\Domain\Models\OrderUnits;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderUnitFactory extends Factory
{
    protected $model = OrderUnits::class;

    public function definition(): array
    {



        return $this->addAuthActiveByUser($arrayUser);
    }

}
