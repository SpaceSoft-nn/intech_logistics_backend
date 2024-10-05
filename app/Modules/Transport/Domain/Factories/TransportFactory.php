<?php

namespace App\Modules\Transport\Domain\Factories;

use App\Modules\IndividualFace\Domain\Models\Driver;
use App\Modules\Transaport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\App\Data\DTO\ValueObject\TrasportVO;
use App\Modules\Transport\App\Data\Enums\TransportStatusEnum as EnumsTransportStatusEnum;
use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransportFactory extends Factory
{
    protected $model = Transport::class;

    public function definition(): array
    {

        $driver = Driver::factory()->create();

        /**
        * @var TrasportVO
        */
        $trasportVO = TrasportVO::make(
            type : "Грузовик",
            brand_model : "Volvo FH",
            year : $this->faker->numberBetween(1995, 2024),
            transport_number : $this->faker->numberBetween(0, 2020),
            body_volume : $this->faker->numberBetween(15, 100),
            body_weight : $this->faker->numberBetween(5000, 40000),
            type_status : EnumsTransportStatusEnum::free,
            organization_id : null,
            driver_id : $driver->id,
            description : $this->faker->text(),
        );


        return $trasportVO->toArrayNotNull();
    }

}
