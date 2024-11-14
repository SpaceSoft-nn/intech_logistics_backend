<?php

namespace App\Modules\Organization\Common\Tests\Feature;

use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\App\Data\Enums\OrganizationEnum;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\App\Repositories\OrganizationRepository;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Interactor\UserCreateInteractor;
use App\Modules\User\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;

class OrganizationTest extends TestCase
{
    use RefreshDatabase;

    protected $faker;

    protected function setUp(): void
    {
        parent::setUp(); // Не забываем вызывать родительский метод
        $this->faker = Faker::create();
    }

    public function test_organization_create()
    {
        {
            $rep = app(OrganizationRepository::class);
            $user = $this->create_user();

            $organization = $rep->save(
                OrganizationVO::make(
                    owner_id: $user->id,
                    name: $this->faker->name,
                    address: $this->faker->address,
                    okved: $this->faker->text,
                    founded_date: $this->faker->date,
                    type: OrganizationEnum::legal,
                    inn: "123456789012",
                    registration_number: "1234567890123",
                )
            );

            $this->assertNotNull($organization);
        }
    }


    /**
     * Проверка создания organization через Factory
     * @return [type]
     */
    public function test_create_organizatrion_factory()
    {
        $organization = Organization::factory()->create();

        $this->assertNotNull($organization);
    }

    #private //создание с бизнес логикой и кабинетом
    private function create_user() : User
    {
        $interactor = app(UserCreateInteractor::class);

        //TODO Логика для UserRoleEnum::observed/manager не работает! при присоединение кабинетов.


        $model = $interactor->run(
            UserCreateDTO::make(
                UserVO::make(
                    first_name: $this->faker->firstName,
                    last_name: $this->faker->lastName,
                    father_name: $this->faker->firstName,
                    password: $this->faker->password,
                    role: UserRoleEnum::admin,
                    personal_area_id: null,
                    email_id: null,
                    phone_id: null,
                ),
            )
        );

        return $model;
    }
}
