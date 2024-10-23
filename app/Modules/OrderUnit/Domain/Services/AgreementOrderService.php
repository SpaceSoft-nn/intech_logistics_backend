<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;
use App\Modules\OrderUnit\Domain\Interactor\Agreement\AgreementOrderInteractor;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;

/**
 * Сервес для указание подрядчика для заказа
 */
class AgreementOrderService
{
    /**
     * @param AgreementOrderCreateDTO $dto
     *
     * @return ?AgreementOrderAccept
     */
    public function run(AgreementOrderCreateDTO $dto) : ?AgreementOrderAccept
    {
        return AgreementOrderInteractor::make($dto);
    }
}
