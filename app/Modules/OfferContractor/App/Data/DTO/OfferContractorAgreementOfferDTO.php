<?php

namespace App\Modules\OfferContractor\App\Data\DTO;

use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer;

class OfferContractorAgreementOfferDTO
{

    public function __construct(

        public string $offer_contractor_customer_id,
        public OfferContractor $offerContractor,

    ) {}

    public static function make(

        string $offer_contractor_customer_id,
        OfferContractor $offerContractor,

    ) : self {

        return new self(
            offer_contractor_customer_id: $offer_contractor_customer_id,
            offerContractor: $offerContractor,
        );

    }

}
