<?php

namespace App\Modules\Transport\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\Transport\Domain\Models\Transport as Model;

class TransportRepository extends CoreRepository
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
