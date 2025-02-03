<?php

namespace App\Modules\User\Domain\Interface\Service;

use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\User;

interface IUserService
{
    public function createUser(UserVO $vo) : User;
    public function getUser(string $uuid) : ?User;
}
