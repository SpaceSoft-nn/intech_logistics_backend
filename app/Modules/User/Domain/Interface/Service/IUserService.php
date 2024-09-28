<?php

namespace App\Modules\User\Domain\Interface\Service;

use App\Modules\User\App\Data\DTO\Base\BaseDTO;
use App\Modules\User\Domain\Models\User;

interface IUserService
{
    public function createUser(BaseDTO $dto) : User;
    public function getUser(string $uuid) : ?User;
}
