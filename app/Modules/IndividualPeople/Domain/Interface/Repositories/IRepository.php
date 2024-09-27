<?php

namespace App\Modules\IndividualPeople\Domain\Interface\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function save($email);
    public function getById($uuid) : ?Model;
}
