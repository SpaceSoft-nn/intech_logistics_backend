<?php

namespace App\Modules\User\App\Data\DTO\User\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\User\App\Data\DTO\Base\BaseDTO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use Illuminate\Contracts\Support\Arrayable;

class UserVO extends BaseDTO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $father_name,
        public readonly string $password,

        public readonly UserRoleEnum $role,
        public readonly ?int $permission,

        public readonly ?string $personal_area_id,
        public readonly ?string $email_id,
        public readonly ?string $phone_id,
    ) {}


    public static function make(
        string $first_name,
        string $last_name,
        string $father_name,
        string $password,
        UserRoleEnum $role,
        ?int $permission,
        ?string $personal_area_id,
        ?string $email_id,
        ?string $phone_id,
    ) : self
    {
        return new self(
            first_name: $first_name,
            last_name: $last_name,
            father_name: $father_name,
            password: $password,
            role: $role,
            permission: $permission,
            personal_area_id: $personal_area_id,
            email_id: $email_id,
            phone_id: $phone_id,
        );
    }

    public function toArray() : array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
            'password' => $this->password,
            'role' => $this->role,
            'permission' => $this->permission,
            'personal_area_id' => $this->personal_area_id,
            'email_id' => $this->email_id,
            'phone_id' => $this->phone_id,
        ];
    }
}
