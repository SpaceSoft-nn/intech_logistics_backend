<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\Domain\Interactor\Status\SetTransportationStatusInteractor;
use App\Modules\OrderUnit\Domain\Models\Status\TransporationStatus;

final class TransportationStatusService
{

    public function __construct(
        private SetTransportationStatusInteractor $setTransportationStatusInteractor,
    ) { }


    /**
     * Устанавливаем актуальный статус транспортировки для заказа
     * @param string $order_unit_id
     *
     * @return TransporationStatus
     */
    public function setTransportationStatus(string $order_unit_id) : ?TransporationStatus
    {
        return $this->setTransportationStatusInteractor->execute($order_unit_id);
    }

}
