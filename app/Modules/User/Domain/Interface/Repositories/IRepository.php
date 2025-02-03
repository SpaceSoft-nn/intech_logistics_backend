<?php

namespace App\Modules\User\Domain\Interface\Repositories;

use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function save(UserVO $vo) : Model;
    public function getById($uuid) : ?Model;
}
