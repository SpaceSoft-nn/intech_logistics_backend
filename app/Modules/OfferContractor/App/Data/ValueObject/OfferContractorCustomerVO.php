<?php

namespace App\Modules\OfferContractor\App\Data\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

readonly class OfferContractorCustomerVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public string $invoice_order_customer_id,
        public string $offer_contractor_id,
        public string $organization_id,
        public?string $user_id = null,
    ) {}

    public static function make(
        string $invoice_order_customer_id,
        string $offer_contractor_id,
        string $organization_id,
        string $user_id = null,
    ) : self {


        return new self(
            invoice_order_customer_id: $invoice_order_customer_id,
            offer_contractor_id: $offer_contractor_id,
            organization_id: $organization_id,
            user_id: $user_id,
        );

    }

    public function toArray() : array
    {
        return [
            "invoice_order_customer_id" => $this->invoice_order_customer_id,
            "offer_contractor_id" => $this->offer_contractor_id,
            "organization_id" => $this->organization_id,
            "user_id" => $this->user_id,
        ];
    }

    // public static function fromArrayToObject(array $data) : self
    // {
    //     return self::make(

    //     );
    // }
}
