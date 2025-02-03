<?php

namespace App\Modules\User\Domain\Actions;

use App\Modules\Permission\Domain\Services\PermissionService;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\User as Model;

class CreateUserAction
{
    public static function make(UserVO $vo) : Model
    {
       return (new self())->run($vo);
    }

    public function run(UserVO $vo) : Model
    {

        $model = Model::query()->create($vo->toArrayNotNull());

        return $model;
    }
}
