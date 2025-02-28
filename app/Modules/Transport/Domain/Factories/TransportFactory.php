<?php

namespace App\Modules\Transport\Domain\Factories;

use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;
use App\Modules\Transport\App\Data\Enums\TransportBodyType;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransportFactory extends Factory
{
    protected $model = Transport::class;

    public function definition(): array
    {


        /** @var IndividualPeople */
        $individualPeople = IndividualPeople::factory()
        ->for(
            DriverPeople::factory(), 'individualable'
        )
        ->create();

        /** @var DriverPeople  */
        $driver = $individualPeople->individualable;

        $type_loading = array_column(TransportLoadingType::cases(), 'name');
        $type_weight = array_column(TransportTypeWeight::cases(), 'name');
        $type_body = array_column(TransportBodyType::cases(), 'name');
        $type_status = array_column(TransportStatusEnum::cases(), 'name');

        $organization = Organization::factory()->create();

        /**
        * @var TransportVO
        */
        $transportVO = TransportVO::make(
            brand_model : "Volvo FH",
            year : $this->faker->numberBetween(1995, 2024),
            transport_number : $this->faker->numberBetween(0, 2020),
            body_volume : $this->faker->numberBetween(15, 100),
            body_weight : $this->faker->numberBetween(5000, 40000),

            type_loading : $this->faker->randomElement($type_loading),
            type_weight : $this->faker->randomElement($type_weight),
            type_body : $this->faker->randomElement($type_body),
            type_status : $this->faker->randomElement($type_status),

            organization_id : $organization->id,
            driver_id : $driver->id,
            description : $this->faker->text(),
        );


        return $transportVO->toArrayNotNull();
    }

}
