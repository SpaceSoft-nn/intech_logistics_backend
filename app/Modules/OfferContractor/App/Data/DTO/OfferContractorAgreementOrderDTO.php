<?php

namespace App\Modules\OfferContractor\App\Data\DTO;

use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractorAccept;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;

final readonly class OfferContractorAgreementOrderDTO
{

    public function __construct(

        public OrderUnitCreateDTO $orderUnitCreateDTO,
        public AgreementOrderContractorAccept $agreementOrderContractorAccept,

    ) {}

    public static function make(

        OrderUnitCreateDTO $orderUnitCreateDTO,
        AgreementOrderContractorAccept $agreementOrderContractorAccept,

    ) : self {

        return new self(
            orderUnitCreateDTO: $orderUnitCreateDTO,
            agreementOrderContractorAccept: $agreementOrderContractorAccept,
        );

    }

}
