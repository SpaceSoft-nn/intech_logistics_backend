<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\Domain\Interactor\Status\SetTransportationStatusInteractor;

final class TransportationStatusService
{

    public function __construct(
        private SetTransportationStatusInteractor $setTransportationStatusInteractor
    ) { }


    /**
     * Устанавливаем актуальный статус транспортировки для заказа
     * @param string $order_unit_id
     *
     * @return [type]
     */
    public function setTransportationStatus(string $order_unit_id)
    {
        return $this->setTransportationStatusInteractor->execute($order_unit_id);
    }


}
