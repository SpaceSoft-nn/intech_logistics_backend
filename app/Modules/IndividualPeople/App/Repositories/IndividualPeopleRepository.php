<?php

namespace App\Modules\IndividualPeople\App\Repositories;

use App\Modules\Base\CoreRepository;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople as Model;

class IndividualPeopleRepository extends CoreRepository
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
