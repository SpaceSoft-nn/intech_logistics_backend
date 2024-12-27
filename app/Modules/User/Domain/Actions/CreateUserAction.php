<?php

namespace App\Modules\User\Domain\Actions;

use App\Modules\Permission\Domain\Services\PermissionService;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\User as Model;

class CreateUserAction
{
    public static function make(UserVO $dto) : Model
    {
       return (new self())->run($dto);
    }

    public function run(UserVO $dto) : Model
    {

        $model = Model::query()
            ->createOrFirst(

                [
                    'email_id' => $dto->email_id,
                    'phone_id' => $dto->phone_id,
                ],

                [
                    'first_name' => $dto->first_name,
                    'last_name' => $dto->last_name,
                    'father_name' => $dto->father_name,
                    'password' => $dto->password,

                    'role' => $dto->role,
                    'permission' => app(PermissionService::class)->permissionByRole($dto->role),

                    'active' => true,
                    'auth' => true,

                    'personal_area_id' => $dto->personal_area_id,
                    'email_id' => $dto->email_id,
                    'phone_id' => $dto->phone_id,
                ],
            );

        return $model;
    }
}
