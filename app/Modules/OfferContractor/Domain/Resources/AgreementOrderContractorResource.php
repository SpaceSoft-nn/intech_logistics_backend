<?php

namespace App\Modules\OfferContractor\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgreementOrderContractorResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            'id_agreement_order_contractor' => $this->id,
            "offer_contractor_invoice_order_customer_id"  => $this->offer_contractor_invoice_order_customer,
            "agreement_order_contractor_accept_id"  => $this->agreement_order_contractor_accept,
            "order_unit_id"  => $this->order_unit_id,
            "organization_contractor_id"  => $this->organization_contractor_id,
            "user_id" => $this->user,
        ];
    }
}
