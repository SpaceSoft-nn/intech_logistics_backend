<?php

namespace App\Modules\User\Domain\Factories;

use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {

        $user = UserVO::make(
            first_name: $this->faker->name,
            last_name: $this->faker->name,
            father_name: $this->faker->name,
            password: bcrypt('password'),
            role: UserRoleEnum::admin,
            personal_area_id: null,
            email_id: null,
            phone_id: null,
        );

        $arrayUser = $user->toArrayNotNull();


        //P.S addAuthActiveByUser - можно вызывать через factory
        return $this->addAuthActiveByUser($arrayUser);
    }

    public function addAuthActiveByUser(array $user)
    {
        $user['auth'] = true;
        return $user;
    }
}
