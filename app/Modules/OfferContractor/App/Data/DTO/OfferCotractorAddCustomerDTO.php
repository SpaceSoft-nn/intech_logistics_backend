<?php

namespace App\Modules\OfferContractor\App\Data\DTO;

use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OfferContractor\App\Data\ValueObject\InvoiceOrderCustomerVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;

readonly class OfferCotractorAddCustomerDTO
{

     /**
     * @param InvoiceOrderCustomerVO $invoiceOrderCustomerVO
     * @param Organization $organization
     * @param OfferContractor $offerContractor
     * @param CargoGoodVO[] $cargoGoodVO
    */
    public function __construct(

        public readonly InvoiceOrderCustomerVO $invoiceOrderCustomerVO,
        public Organization $organization,
        public OfferContractor $offerContractor,
        public array $cargoGoodVO_array,

    ) {}

    public static function make(

        InvoiceOrderCustomerVO $invoiceOrderCustomerVO,
        Organization $organization,
        OfferContractor $offerContractor,
        array $cargoGoodVO_array,

    ) : self {

        return new self(
            invoiceOrderCustomerVO: $invoiceOrderCustomerVO,
            organization: $organization,
            offerContractor: $offerContractor,
            cargoGoodVO_array: $cargoGoodVO_array,
        );

    }

}
