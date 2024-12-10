<?php

namespace App\Modules\Transport\Domain\Factories;

use App\Modules\IndividualFace\Domain\Models\Driver;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;
use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeEnum;
use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransportFactory extends Factory
{
    protected $model = Transport::class;

    public function definition(): array
    {

        $driver = Driver::factory()->create();

        $typeTransportEnum = array_column(TransportTypeEnum::cases(), 'name');
        $transportStatusEnum = array_column(TransportStatusEnum::cases(), 'name');

        $organization = Organization::factory()->create();


        /**
        * @var TransportVO
        */
        $transportVO = TransportVO::make(
            type : $this->faker->randomElement($typeTransportEnum),
            brand_model : "Volvo FH",
            year : $this->faker->numberBetween(1995, 2024),
            transport_number : $this->faker->numberBetween(0, 2020),
            body_volume : $this->faker->numberBetween(15, 100),
            body_weight : $this->faker->numberBetween(5000, 40000),
            type_status : $this->faker->randomElement($transportStatusEnum),
            organization_id : $organization->id,
            driver_id : $driver->id,
            description : $this->faker->text(),
        );


        return $transportVO->toArrayNotNull();
    }

}
