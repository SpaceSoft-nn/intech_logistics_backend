<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;
use App\Modules\OrderUnit\Domain\Interactor\Agreement\AgreementOrderInteractor;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;

/**
 * Сервес для указание подрядчика для заказа
 */
final class AgreementOrderService
{

    public function __construct(
        private AgreementOrderInteractor $agreementOrderInteractor
    ) { }


    /**
     * @param AgreementOrderCreateDTO $dto
     *
     * @return ?AgreementOrder
     */
    public function acceptCotractorToOrder(AgreementOrderCreateDTO $dto) : ?AgreementOrder
    {
        return $this->agreementOrderInteractor->execute($dto);
    }
}
