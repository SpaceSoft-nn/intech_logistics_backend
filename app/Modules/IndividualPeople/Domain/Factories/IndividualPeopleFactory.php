<?php

namespace App\Modules\IndividualPeople\Domain\Factories;

use App\Modules\IndividualPeople\App\Data\DTO\CreateIndividualPeopleDTO;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\IndividualPeople\Domain\Services\IndividualPeopleService;
use App\Modules\User\Domain\Models\PersonalArea;
use Illuminate\Database\Eloquent\Factories\Factory;

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

        $VO = CreateIndividualPeopleDTO::make(

            first_name: $this->faker->firstNameMale(),
            last_name: $this->faker->lastName(),
            father_name: $this->faker->name(),
            position: $this->faker->name(),
            other_contact: $this->faker->phoneNumber(). ' ' . $this->faker->email(),
            comment: $this->faker->paragraph(),
            phone: $this->faker->phoneNumber(),
            email: $this->faker->email(),
            remuved: false,
            personal_area_id: $personal_area->id,

        );


        return $VO->toArrayNotNull();
    }
}
