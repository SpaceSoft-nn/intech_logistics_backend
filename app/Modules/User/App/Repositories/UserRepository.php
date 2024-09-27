<?php

namespace App\Modules\User\App\Repositories;

use App\Modules\Base\CoreRepository;
use App\Modules\User\Domain\Models\User as Model;

class UserRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }


}
