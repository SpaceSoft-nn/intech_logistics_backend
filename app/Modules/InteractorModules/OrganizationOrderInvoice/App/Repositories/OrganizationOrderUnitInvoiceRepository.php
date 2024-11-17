<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice as Model;

class OrganizationOrderUnitInvoiceRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    public function get(string $uuid) : ?Model
    {
        return $this->query()->findOrFail($uuid);
    }

}
