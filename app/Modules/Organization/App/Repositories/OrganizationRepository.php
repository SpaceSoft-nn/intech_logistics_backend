<?php

namespace App\Modules\Organization\App\Repositories;

use App\Modules\Base\CoreRepository;
use App\Modules\Organization\Domain\Models\Organization as Model;

class OrganizationRepository extends CoreRepository
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
