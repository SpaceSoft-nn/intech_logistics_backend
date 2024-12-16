<?php

namespace App\Modules\OfferContractor\App\Data\DTO;

use App\Modules\OfferContractor\App\Data\ValueObject\InvoiceOrderCustomerVO;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\Organization\Domain\Models\Organization;

class OfferCotractorAddCustomerDTO
{

    public function __construct(

        public readonly InvoiceOrderCustomerVO $invoiceOrderCustomerVO,
        public Organization $organization,
        public OfferContractor $offerContractor,

    ) {}

    public static function make(

        InvoiceOrderCustomerVO $invoiceOrderCustomerVO,
        Organization $organization,
        OfferContractor $offerContractor,

    ) : self {

        return new self(
            invoiceOrderCustomerVO: $invoiceOrderCustomerVO,
            organization: $organization,
            offerContractor: $offerContractor,
        );

    }

}
