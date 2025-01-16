<?php

namespace App\Modules\IndividualPeople\Domain\Factories;

use App\Modules\User\Domain\Models\PersonalArea;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\IndividualPeople\Domain\Models\StorekeeperPeople;
use App\Modules\IndividualPeople\App\Data\ValueObject\StorekeeperPeopleVO;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class StorekeeperPeopleFactory extends Factory
{
    protected $model = StorekeeperPeople::class;

    public function definition(): array
    {
        /**
        * @var PersonalArea
        */
        $personal_area = PersonalArea::factory()->create();

        /**
         * @var
         */

        $vo = StorekeeperPeopleVO::make(
            personal_area_id: $personal_area->id,
            organization_id: null,
        );

        return $vo->toArrayNotNull();
    }
}
