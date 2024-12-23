<?php

namespace App\Modules\OrderUnit\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\OrderUnit\App\Data\Enums\TransportationStatusEnum;
use App\Modules\OrderUnit\Domain\Models\Status\EnumTransportationStatus;
use App\Modules\OrderUnit\Domain\Models\Status\TransporationStatus as Model;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TransportationStatusReposiroty extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    /**
     * Вернуть общее количество записей по заданному заказу
     * @param string $order_unit_id
     *
     * @return int
     */
    public function getCountAddressStatus(string $order_unit_id) : int
    {
        return $this->query()->where('order_unit_id', $order_unit_id)->get()->count();
    }


    /**
     * Вернуть записи без статуса transit
     * @param string $order_unit_id
     *
     * @return Collection
     */
    public function getWithoutTransit(string $order_unit_id) : Collection
    {

        return $this->query()->where('order_unit_id', $order_unit_id)
                ->whereNot(function (Builder $query) {

                    $enumTransportationStatus = EnumTransportationStatus::where('enum_value', TransportationStatusEnum::transit)->first();

                    $query->where('enum_transporatrion_status_id', $enumTransportationStatus->id);

                })
                ->get();
    }

    public function getLastRecord(string $order_unit_id)
    {
        return $this->query()->where('order_unit_id', $order_unit_id)->latest()->first();
    }

}
