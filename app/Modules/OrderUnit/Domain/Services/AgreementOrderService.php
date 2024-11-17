<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;
use App\Modules\OrderUnit\Domain\Interactor\Agreement\AgreementOrderInteractor;
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
     * @return ?AgreementOrderAccept
     */
    public function acceptCotractorToOrder(AgreementOrderCreateDTO $dto) : ?AgreementOrderAccept
    {
        return $this->agreementOrderInteractor->execute($dto);
    }
}
