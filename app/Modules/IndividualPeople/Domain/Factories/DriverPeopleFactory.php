<?php

namespace App\Modules\IndividualPeople\Domain\Factories;

use App\Modules\IndividualPeople\App\Data\ValueObject\DriverPeopleVO;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
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

        $vo = DriverPeopleVO::make(
            personal_area_id: $personal_area->id,
            organization_id: null,
            series: $this->faker->numerify('####'),
            number: $this->faker->numerify('######'),
            date_get: $this->faker->date('d.m.Y'),
        );

        return $vo->toArrayNotNull();
    }
}
