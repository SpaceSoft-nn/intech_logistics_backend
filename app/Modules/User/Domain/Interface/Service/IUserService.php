<?php

namespace App\Modules\User\Domain\Interface\Service;

use App\Modules\User\App\Data\DTO\User\UserManagerCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\User;

interface IUserService
{
    public function createUserAdmin(UserVO $vo) : User;
    public function createUserManager(UserManagerCreateDTO $dto) : User;
    public function getUser(string $uuid) : ?User;
}
