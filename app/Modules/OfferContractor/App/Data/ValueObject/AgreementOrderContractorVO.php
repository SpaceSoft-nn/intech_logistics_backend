<?php

namespace App\Modules\OfferContractor\App\Data\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;

use Illuminate\Contracts\Support\Arrayable;

readonly class AgreementOrderContractorVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(


        public string $offer_contractor_invoice_order_customer_id,
        public string $offer_contractor_id,
        public string $organization_contractor_id,
        public ?string $order_unit_id,
        public ?string $user_id,

    ) {}

    public function setOrderUnitId(string $orderUnitId) : self
    {
        return self::make(
            offer_contractor_invoice_order_customer_id: $this->offer_contractor_invoice_order_customer_id,
            organization_contractor_id: $this->organization_contractor_id,
            offer_contractor_id: $this->offer_contractor_id,
            order_unit_id: $orderUnitId,
            user_id: $this->user_id,
        );
    }


    public static function make(

        string $offer_contractor_invoice_order_customer_id,
        string $organization_contractor_id,
        string $offer_contractor_id,
        string $order_unit_id = null,
        string $user_id = null,

    ) : self {


        return new self(
            offer_contractor_invoice_order_customer_id: $offer_contractor_invoice_order_customer_id,
            offer_contractor_id: $offer_contractor_id,
            order_unit_id: $order_unit_id,
            organization_contractor_id: $organization_contractor_id,
            user_id: $user_id,
        );

    }

    public function toArray() : array
    {
        return [
            "offer_contractor_invoice_order_customer_id" => $this->offer_contractor_invoice_order_customer_id,
            "offer_contractor_id" => $this->offer_contractor_id,
            "order_unit_id" => $this->order_unit_id,
            "organization_contractor_id" => $this->organization_contractor_id,
            "user_id" => $this->user_id,
        ];
    }


}
