<?php

namespace App\Modules\IndividualPeople\Common\Tests\Feature;

use App\Modules\IndividualPeople\App\Data\DTO\CreateIndividualPeopleDTO;
use App\Modules\IndividualPeople\Domain\Actions\CreateIndividualPeople;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO as UserUserCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\App\Data\DTO\UserCreateDTO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Interactor\UserCreateInteractor;
use App\Modules\User\Domain\Models\PersonalArea;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndividualPeopleTest extends TestCase
{
    use RefreshDatabase;

    protected $faker;

    protected function setUp(): void
    {
        parent::setUp(); // Не забываем вызывать родительский метод
        $this->faker = Faker::create();
    }

    public function test_create_individual_people()
    {
        $interactor = app(UserCreateInteractor::class);
        
        $user = $interactor->run(
            UserUserCreateDTO::make(
                UserVO::make(
                    first_name: $this->faker->name,
                    last_name: $this->faker->name,
                    father_name: $this->faker->name,
                    password: bcrypt('password'),
                    role: UserRoleEnum::admin,
                    permission: 15,
                    personal_area_id: null,
                    email_id: null,
                    phone_id: null,
                )
            )
        );

        $invPeople = CreateIndividualPeople::make(
            CreateIndividualPeopleDTO::make(
                first_name: $this->faker->name,
                last_name: $this->faker->name,
                father_name: $this->faker->name,
                position: $this->faker->text,
                other_contact: $this->faker->text,
                comment: $this->faker->text,
                personal_area_id: $user->personal_areas->first()->id,
            )
        );

        $this->assertNotNull($invPeople);
    }
}
