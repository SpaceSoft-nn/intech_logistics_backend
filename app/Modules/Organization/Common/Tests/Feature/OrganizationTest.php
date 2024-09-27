<?php

namespace App\Modules\Organization\Common\Tests\Feature;

use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\App\Data\Enums\OrganizationEnum;
use App\Modules\Organization\App\Repositories\OrganizationRepository;
use App\Modules\User\App\Data\DTO\UserCreateDTO;
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
                OrganizationCreateDTO::make(
                    owner_id: $user->id,
                    name: $this->faker->name,
                    address: $this->faker->address,
                    industry: $this->faker->text,
                    founded_date: $this->faker->date,
                    type: OrganizationEnum::ooo,
                    inn: "123456789012",
                    registration_number: "1234567890123",
                )
            );

            $this->assertNotNull($organization);
        }
    }

    #private
    private function create_user() : User
    {
        $interactor = app(UserCreateInteractor::class);
        $model = $interactor->run(
            UserCreateDTO::make(
                first_name: $this->faker->firstName,
                last_name: $this->faker->lastName,
                father_name: $this->faker->firstName,
                password: $this->faker->password,
                role: UserRoleEnum::observed,
                permission: null,
                personal_area_id: null,
                email_id: null,
                phone_id: null,
            )
        );

        return $model;
    }
}
