<?php

namespace App\Modules\Tender\Domain\Services;

use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;
use App\Modules\Tender\App\Data\ValueObject\Response\AgreementTenderVO;
use App\Modules\Tender\Domain\Interactor\AgreementTenderAcceptInteractor;
use App\Modules\Tender\Domain\Interactor\CreateAgreementTenderInteractor;
use App\Modules\Tender\Domain\Interactor\CreateResponseTenderInteractor;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTenderAccept;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;

final class AgreementTenderService
{
    public function __construct(
        private CreateResponseTenderInteractor $createResponseTenderInteractor,
        private CreateAgreementTenderInteractor $сreateAgreementTenderInteractor,
        private AgreementTenderAcceptInteractor $agreementTenderAcceptInteractor,
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

    /**
     * Подтврждения соглашения между сторонами, на принятие тендера в работу - после двух-стороннего подтврждения создаются заказы с минимальной информацией
     * #TODO - тут создавать заказы, после подтврждения и предусмотреть нормальную логику работы при ролях
     * @param AgreementTenderAccept $agreementTenderAccept
     *
     * @return AgreementTenderAccept
     */
    public function agreementTenderAccept(AgreementTenderAccept $agreementTenderAccept) : AgreementTenderAccept
    {
        return $this->agreementTenderAcceptInteractor->execute($agreementTenderAccept);
    }

}

