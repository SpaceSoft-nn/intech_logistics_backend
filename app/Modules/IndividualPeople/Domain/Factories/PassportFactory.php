<?php

namespace App\Modules\IndividualPeople\Domain\Factories;

use App\Modules\IndividualPeople\App\Data\ValueObject\PassportVO;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\IndividualPeople\Domain\Models\Passport;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class PassportFactory extends Factory
{
    protected $model = Passport::class;

    public function definition(): array
    {

        // $individual_people = IndividualPeople::factory()->create();

        // Получим текущую дату и время в ru формате
        $date = Carbon::now()->format('d.m.Y');

        $vo = PassportVO::make(
            first_name: $this->faker->firstNameMale(),
            last_name: $this->faker->lastName(),
            father_name: $this->faker->name(),
            passport_series: $this->faker->numerify('####'),
            passport_number: $this->faker->numerify('######'),
            issue_date: $date,
            issued_by: $this->faker->paragraph(),
            department_code: $this->faker->numerify('######'),
            birth_day: $date,
            // individual_people_id: $individual_people->id,
        );


        return $vo->toArrayNotNull();
    }
}
