<?php

namespace App\Modules\IndividualFace\Domain\Factories;

use App\Modules\IndividualFace\App\Data\DTO\ValueObject\DriverVO;
use App\Modules\IndividualFace\Domain\Models\Driver;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\User\Domain\Models\PersonalArea;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition(): array
    {

        $personal_area = PersonalArea::factory()->create();
        $individual_people = IndividualPeople::factory()->create();

        /**
        * @var DriverVO
        */
        $DriverVO = DriverVO::make(
            personal_area_id: $personal_area->id,
            individual_people_id: $individual_people->id,
            organization_id: null,
        );

        return $DriverVO->toArrayNotNull();
    }

}
