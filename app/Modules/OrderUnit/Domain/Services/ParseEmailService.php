<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\Domain\Models\Status\TransporationStatus;
use App\Modules\OrderUnit\Domain\Interactor\Status\ParseEmailAndChangeTransportStatusInteractor;

class ParseEmailService
{

    public function __construct(
        private ParseEmailAndChangeTransportStatusInteractor $parseEmailAndChangeTransportStatusInteractor,
    ) { }

    /**
     * Парсим email на сообщение, находим по email водителя, и зависимый заказ, меняем статус
     * @param string $email
     *
     * @return ?TransporationStatus
    */
    public function parseEmailAndChangeTransportStatus(string $email) : ?TransporationStatus
    {
        return $this->parseEmailAndChangeTransportStatusInteractor->execute($email);
    }


}
