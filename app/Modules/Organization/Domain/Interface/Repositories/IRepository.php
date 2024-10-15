<?php

namespace App\Modules\Organization\Domain\Interface\Repositories;

use App\Modules\Organization\App\Data\DTO\Base\BaseDTO;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function save($dto);
    public function getById(string $uuid) : ?Model;
}
