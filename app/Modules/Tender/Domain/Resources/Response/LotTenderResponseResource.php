<?php

namespace App\Modules\Tender\Domain\Resources\Response;

use App\Modules\Organization\Domain\Resources\OrganizationResource;
use App\Modules\Tender\Domain\Resources\LotTenderResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class LotTenderResponseResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "lot_tender_id" => LotTenderResource::make($this->tender),
            "organization_contractor_id" => OrganizationResource::make($this->organization_contractor),
            "invoice_lot_tender_id" => InvoiceLotTenderResource::make($this->invoice_lot_tender),

        ];
    }
}
