<?php

namespace App\Modules\Permission\Domain\Services;

use App\Modules\Permission\App\Data\Enums\Permission;
use App\Modules\Permission\Domain\Interface\IPermission;
use App\Modules\User\App\Data\Enums\UserRoleEnum;

class PermissionService implements IPermission
{
    public function accessSelect(int $permission) : bool
    {
        return Permission::accessByValue($permission, Permission::SELECT);
    }

    public function accessCreate(int $permission) : bool
    {
        return Permission::accessByValue($permission, Permission::CREATE);
    }

    public function accessUpdate(int $permission) : bool
    {
        return Permission::accessByValue($permission, Permission::UPDATE);
    }

    public function accessDelete(int $permission) : bool
    {
        return Permission::accessByValue($permission, Permission::DELETE);
    }

    public function accessAll(int $permission) : bool
    {
        return Permission::accessByAll($permission);
    }

    public function permissionByRole(UserRoleEnum $enum) : int
    {
        return Permission::permissionByRole($enum->value);
    }
}
