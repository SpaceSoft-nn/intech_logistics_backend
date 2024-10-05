<?php

namespace App\Modules\Adress\Domain\Factories;

use App\Modules\Adress\App\Data\DTO\ValueObject\AdressVO;
use App\Modules\Adress\App\Data\Enums\TypeAdressEnum;
use App\Modules\Adress\Domain\Models\Adress;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdressFactory extends Factory
{
    protected $model = Adress::class;

    /**
     *
     * @return array
     */
    public function definition(): array
    {

        /**
        * @var AdressVO
        */

        $adressVO = AdressVO::make(

            region: $this->faker->state(),
            city: $this->faker->city(),
            street: $this->faker->streetName(),
            building: $this->faker->buildingNumber,
            apartment: $this->faker->randomNumber(3),
            house_number: $this->faker->buildingNumber,
            postal_code: $this->faker->postcode,
            latitude:$this->faker->latitude(55.0, 56.0),
            longitude:$this->faker->longitude(37.0, 38.0),
            type_adress: TypeAdressEnum::work,

        );

        return $adressVO->toArrayNotNull();
    }

}
