<?php

namespace App\Modules\User\Common\Tests\Feature;

use App\Modules\Organization\App\Data\DTO\User\LinkUserToOrganizationDTO;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Actions\Organization\LinkUserToOrganizationAction;
use App\Modules\User\Domain\Interactor\UserCreateInteractor;
use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $faker;

    protected function setUp(): void
    {
        parent::setUp(); // Не забываем вызывать родительский метод
        $this->faker = Faker::create();
    }

    public function test_create_user_interactor()
    {
        $interactor = app(UserCreateInteractor::class);
        $status = $interactor->run(
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
                )
            )
        );

        $this->assertNotNull($status);
    }

    public function test_create_factory_personal_area()
    {
        $model = PersonalArea::factory()->create();

        $this->assertNotNull($model);
    }

    /**
     * Тестирование привязки user к Organization (action)
     * @return void
     */
    public function test_link_user_to_organization_ation() : void
    {
        $user = User::factory()->create();
        $this->assertNotNull($user);

        $organization = Organization::factory()->create();
        $this->assertNotNull($organization);

        $user = User::find($organization->owner_id);

        //Связываем при связи многие ко многим через промежуточную таблицу
        LinkUserToOrganizationAction::run(LinkUserToOrganizationDTO::make($user, $organization, TypeCabinetEnum::customer));

        $this->assertNotEmpty($user->organizations);
        $this->assertNotEmpty($organization->users);

    }
}
