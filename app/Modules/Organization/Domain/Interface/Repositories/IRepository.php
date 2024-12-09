<?php

namespace App\Modules\Organization\Domain\Interface\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function save($dto);
    public function getById(string $uuid) : ?Model;
}
