<?php

namespace App\Modules\Permission\Domain\Interface;

interface IPermission
{
    public function accessSelect(int $permission) : bool;
    public function accessCreate(int $permission) : bool;
    public function accessUpdate(int $permission) : bool;
    public function accessDelete(int $permission) : bool;
    public function accessAll(int $permission) : bool;
}
