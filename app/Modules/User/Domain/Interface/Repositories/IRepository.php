<?php

namespace App\Modules\User\Domain\Interface\Repositories;

use App\Modules\User\App\Data\DTO\Base\BaseDTO;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function save(BaseDTO $email) : Model;
    public function getById($uuid) : ?Model;
}
