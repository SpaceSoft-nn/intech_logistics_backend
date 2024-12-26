<?php

namespace App\Modules\Tender\Domain\Resources\Response;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class LotTenderResponseResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [

            "id_lot_tender_response" => $this->id,
            "lot_tender_id" => $this->lot_tender_id,
            "organization_contractor_id" => $this->organization_contractor_id,
            "invoice_lot_tender_id" => $this->invoice_lot_tender,

        ];
    }
}
