<?php

namespace App\Modules\OfferContractor\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Organization\Domain\Resources\OrganizationResource;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitResource;

class AgreementOrderContractorResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            "invoice"  => OfferContractorCustomerResource::make($this->offer_contractor_invoice_order_customer),
            // "agreement_order_contractor_accept_id"  => $this->agreement_order_contractor_accept,
            "order"  => OrderUnitResource::make($this->order_unit),
            "organization"  => OrganizationResource::make($this->organization_contractor_id),
            "user_id" => $this->user,
        ];
    }
}
