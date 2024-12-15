<?php

namespace App\Modules\OfferContractor\Domain\Factories;

use App\Modules\User\Domain\Models\User;
use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;

class OfferContractorFactory extends Factory
{
    protected $model = OfferContractor::class;

    public function definition(): array
    {
        /**
        * @var Transport
        */
        $tansport = Transport::factory()->create();

        /**
        * @var User
        */
        $user = User::factory()->create();

         /**
        * @var Organization
        */
        $organization = Organization::factory()->create();


        /**
        * @var OfferContractorVO
        */
        $offerContractorVO = OfferContractorVO::make(

            city_name_start : $this->faker->city(),
            city_name_end : $this->faker->city(),
            price_for_distance : $this->faker->numberBetween(75, 140),
            transport_id : $tansport->id,
            user_id : $user->id,
            organization_id : $organization->id,
            add_load_space : $this->faker->boolean(),
            road_back : $this->faker->boolean(),
            directly_road : $this->faker->boolean(),
            order_unit_id : null,
            description : $this->faker->text(),

        );


        return $offerContractorVO->toArrayNotNull();
    }

}
