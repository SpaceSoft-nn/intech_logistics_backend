<?php

namespace App\Modules\Tender\Domain\Services;

use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;
use App\Modules\Tender\App\Data\ValueObject\Response\AgreementTenderVO;
use App\Modules\Tender\Domain\Interactor\CreateAgreementTenderInteractor;
use App\Modules\Tender\Domain\Interactor\CreateResponseTenderInteractor;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;

final class AgreementTenderService
{
    public function __construct(
        private CreateResponseTenderInteractor $createResponseTenderInteractor,
        private CreateAgreementTenderInteractor $сreateAgreementTenderInteractor,
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

    /**
     * Создатель тендера выбирает подрядчика на выполнения тендера
     * @param AgreementTenderVO $AgreementTenderVO
     *
     * @return AgreementTender
     */
    public function agreementTender(AgreementTenderVO $AgreementTenderVO) : AgreementTender
    {
        return $this->сreateAgreementTenderInteractor->execute($AgreementTenderVO);
    }
}

