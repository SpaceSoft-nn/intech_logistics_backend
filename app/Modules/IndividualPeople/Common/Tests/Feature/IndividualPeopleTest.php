<?php

namespace App\Modules\IndividualPeople\Common\Tests\Feature;

use Tests\TestCase;
use Faker\Factory as Faker;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Interactor\UserCreateInteractor;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\IndividualPeople\App\Data\DTO\CreateIndividualPeopleDTO;
use App\Modules\IndividualPeople\Domain\Services\IndividualPeopleService;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO as UserUserCreateDTO;

class IndividualPeopleTest extends TestCase
{
    // use RefreshDatabase;

    protected $faker;

    protected function setUp(): void
    {
        parent::setUp(); // Не забываем вызывать родительский метод
        $this->faker = Faker::create();
    }

    public function test_create_individual_people()
    {
        $interactor = app(UserCreateInteractor::class);
        $rep = app(IndividualPeopleService::class);

        /** @var UserVO */
        $userVO = UserVO::make(
            first_name: $this->faker->name,
            last_name: $this->faker->name,
            father_name: $this->faker->name,
            password: bcrypt('password'),
            role: UserRoleEnum::admin,
            email_id: null,
            phone_id: null,
        );

        $user = $interactor->run($userVO);

        $invPeople = $rep->createIndividualPeople(
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

    /**
     * Проверка работы фабрики
     * @return [type]
     */
    public function test_create_factory_individual_people()
    {
        $model = IndividualPeople::factory()->create();

        $this->assertNotNull($model);
    }
}
