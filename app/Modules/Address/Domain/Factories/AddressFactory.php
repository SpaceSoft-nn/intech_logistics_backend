<?php

namespace App\Modules\Address\Domain\Factories;

use App\Modules\Address\App\Data\DTO\ValueObject\AddressVO;
use App\Modules\Address\Domain\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    /**
     *
     * @return array
     */
    public function definition(): array
    {

        /**
        * @var AddressVO
        */

        $AddressVO = AddressVO::make(

            region: $this->faker->state(),
            city: $this->faker->city(),
            street: $this->faker->streetName(),
            building: $this->faker->buildingNumber,
            postal_code: $this->faker->postcode,
            latitude:$this->faker->latitude(55.0, 56.0),
            longitude:$this->faker->longitude(37.0, 38.0),

        );

        return $AddressVO->toArrayNotNull();
    }

}
