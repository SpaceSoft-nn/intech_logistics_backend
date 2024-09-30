<?php

namespace App\Modules\User\Common\Tests\Feature;

use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Interactor\UserCreateInteractor;
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
                    permission: null,
                    personal_area_id: null,
                    email_id: null,
                    phone_id: null,
                )
            )
        );
        
        $this->assertNotNull($status);
    }
}
