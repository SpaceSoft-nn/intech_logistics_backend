<?php

namespace App\Modules\Tender\Domain\Services;

use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;
use App\Modules\Tender\Domain\Interactor\CreateResponseTenderInteractor;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;

final class AgreementTenderService
{
    public function __construct(
        private CreateResponseTenderInteractor $createResponseTenderInteractor,
    ) { }

    /**
     * Перевозчик откликается на тендер, создание записи:
     * InvoiceLotTender  и LotTenderResponse
     * @param CreateResponseTenderDTO $dto
     *
     * @return LotTenderResponse
     */
    public function respondToTender(CreateResponseTenderDTO $dto) : LotTenderResponse
    {
        return $this->createResponseTenderInteractor->execute($dto);
    }
}

