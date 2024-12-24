<?php

namespace App\Modules\IndividualPeople\Domain\Factories;

use App\Modules\IndividualPeople\App\Data\ValueObject\DriverPeopleVO;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\User\Domain\Models\PersonalArea;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class DriverPeopleFactory extends Factory
{
    protected $model = DriverPeople::class;


    public function definition(): array
    {
        /**
        * @var PersonalArea
        */
        $personal_area = PersonalArea::factory()->create();

        /**
         * @var
         */
        $individualPeople = IndividualPeople::factory()->create();

        $VO = DriverPeopleVO::make(
            personal_area_id: $personal_area->id,
            individual_people_id: $individualPeople->id,
            organization_id: null,
        );


        return $VO->toArrayNotNull();
    }
}
