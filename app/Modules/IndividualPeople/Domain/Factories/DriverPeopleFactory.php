<?php

namespace App\Modules\IndividualPeople\Domain\Factories;

use App\Modules\IndividualPeople\App\Data\ValueObject\DriverPeopleVO;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\User\Domain\Models\PersonalArea;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

use function App\Helpers\add_time_random;

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

        // Получим текущую дату и время в ru формате
        $date = Carbon::now()->format('d.m.Y');
        $ru_format_date = add_time_random($date, 4);

        $vo = DriverPeopleVO::make(
            personal_area_id: $personal_area->id,
            organization_id: null,
            series: $this->faker->numerify('####'),
            number: $this->faker->numerify('######'),
            date_get: $ru_format_date,
        );

        return $vo->toArrayNotNull();
    }
}
