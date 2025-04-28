<?php

namespace App\Modules\Transport\App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Transport\Domain\Models\TransportationStatusСalendar as Model;

class TransportationStatusKalendarReposiroty extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

   public function findForOrderAndTransport(string $orderId, string $transportId) : Collection
   {
        return $this->query()
            ->where('order_unit_id', $orderId)
                ->where('transport_id', $transportId)->get();
   }

}
