<?php

namespace App\Modules\OfferContractor\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferContractorCustomerResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id_offer_contractor_customer" => $this->id,
            "invoice_order_customer_id" => $this->invoice_order_customer_id,
            "offer_contractor_id" => $this->offer_contractor_id,
            "organization_id" => $this->organization_id,
            "user_id" => $this->user_id,

        ];
    }
}
