<?php

namespace App\Modules\Tender\Domain\Resources\Response;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\Domain\Resources\LotTenderResource;
use App\Modules\Organization\Domain\Resources\OrganizationResource;

class AgreementTenderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "contractor_invoice" => InvoiceLotTenderResource::make($this->invoiceTender),
            "organization_contractor" => OrganizationResource::make($this->organization_contractor),
            "tender" => LotTenderResource::make($this->lot_tender),
            "agreement_tender_accept" => AgreementTenderAcceptResource::make($this->agreement_tender_accept),

        ];
    }
}
