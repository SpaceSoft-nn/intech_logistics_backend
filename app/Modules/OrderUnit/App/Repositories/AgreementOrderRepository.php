<?php

namespace App\Modules\OrderUnit\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder as Model;

class AgreementOrderRepository extends CoreRepository
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
        return Model::findOrFail($uuid);
    }

    /**
     * Проверяем что в модели существует main_order и значит он вляется главным.
     * @param Model $model
     * @param mixed $main_order_id
     *
     * @return bool
     */
    public function isMainOrder(Model $model, $main_order_id) : bool
    {
        return $model->order_unit_id === $main_order_id;
    }


    /**
     * Проверяем что заказчик для данного заказа уже выбрал исполнителя
     * @param string $order_id
     * @return bool
     */
    public function checkStatusAgreementOrder(string $order_id) : bool
    {
        $status = $this->query()->where("order_unit_id", $order_id)->first();

        return $status ? true : false;
    }




}
