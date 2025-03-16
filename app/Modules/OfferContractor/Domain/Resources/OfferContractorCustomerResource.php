<?php

namespace App\Modules\OfferContractor\Domain\Resources;

use App\Modules\Organization\Domain\Resources\OrganizationResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferContractorCustomerResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [

            "id_offer_contractor_customer" => $this->id,
            "customer_invoice" => InvoiceOrderCustomerResource::make($this->invoice_order_customer),
            "offer_contractor" => OfferContractorResource::make($this->offer_contractor),
            "organization_id" => OrganizationResource::make($this->organization),
            "created_at" => Carbon::parse($this->created_at)->format('d.m.Y'),
            "user_id" => $this->user_id,

        ];
    }
}
