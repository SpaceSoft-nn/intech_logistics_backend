<?php

namespace App\Modules\IndividualPeople\Domain\Factories;

use App\Modules\IndividualPeople\App\Data\DTO\CreateIndividualPeopleDTO;
use App\Modules\IndividualPeople\App\Data\ValueObject\IndividualPeopleVO;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\IndividualPeople\Domain\Models\Passport;
use App\Modules\User\Domain\Models\PersonalArea;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class IndividualPeopleFactory extends Factory
{
    protected $model = IndividualPeople::class;


    public function definition(): array
    {
        /**
        * @var PersonalArea
        */
        $personal_area = PersonalArea::factory()->create();

        $mobilePhone = '79' . $this->faker->numerify('#########');

        $vo = IndividualPeopleVO::make(

            position: $this->faker->name(),
            other_contact: $this->faker->phoneNumber(). ' ' . $this->faker->email(),
            comment: $this->faker->paragraph(),
            phone: $mobilePhone,
            email: $this->faker->email(),
            remuved: false,
            personal_area_id: $personal_area->id,

        );

        return $vo->toArrayNotNull();
    }
}
