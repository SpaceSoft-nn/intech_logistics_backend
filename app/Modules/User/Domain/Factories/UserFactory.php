<?php

namespace App\Modules\User\Domain\Factories;

use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\App\Data\DTO\UserCreateDTO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Create a new factory instance for the model.
    */
    protected static function newFactory()
    {
        return User::new();
    }

    public function definition(): array
    {

        $user = UserVO::make(
            first_name: $this->faker->name,
            last_name: $this->faker->name,
            father_name: $this->faker->name,
            password: bcrypt('password'),
            role: UserRoleEnum::admin,
            permission: 15,
            personal_area_id: null,
            email_id: null,
            phone_id: null,
        );

        $arrayUser = $user->toArrayNotNull();

        return $this->addAuthActiveByUser($arrayUser);
    }

    public function addAuthActiveByUser(array $user)
    {
        $user['auth'] = true;
        return $user;
    }
}
