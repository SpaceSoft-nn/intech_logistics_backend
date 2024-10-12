<?php

namespace App\Modules\Matrix\Domain\Factories;


use App\Modules\Adress\Domain\Models\Adress;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegionEconomicFactorFactory extends Factory
{
    protected $model = Adress::class;

    public function definition(): array
    {

        return [];
        // return $adressVO->toArrayNotNull();
    }

}
