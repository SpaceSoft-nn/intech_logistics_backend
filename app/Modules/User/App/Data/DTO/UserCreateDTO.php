<?php

namespace App\Modules\User\App\Data\DTO;

use App\Modules\User\App\Data\Enums\UserRoleEnum;

class UserCreateDTO
{
    public readonly string $first_name;
    public readonly string $last_name;
    public readonly string $father_name;

    public readonly UserRoleEnum $role;
    public readonly ?int $permission;

    public readonly ?string $personal_area_id;
    public readonly ?string $email_id;
    public readonly ?string $phone_id;

    public static function make(
        string $first_name,
        string $last_name,
        string $father_name,
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
            role: $role,
            permission: $permission,
            personal_area_id: $personal_area_id,
            email_id: $email_id,
            phone_id: $phone_id,
        );

    }
}
