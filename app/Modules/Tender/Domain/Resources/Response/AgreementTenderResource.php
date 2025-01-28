<?php

namespace App\Modules\Tender\Domain\Resources\Response;

use App\Modules\Tender\Domain\Resources\LotTenderResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class AgreementTenderResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [

            "id_areement_tender" => $this->id,
            "lot_tender_response_id" => LotTenderResponseResource::make($this->lot_tender_response),
            "organization_tender_create_id" => $this->organization_tender_create_id,
            "lot_tender_id" => LotTenderResource::make($this->lot_tender),
            "agreement_tender_accept_id" => AgreementTenderAcceptResource::make($this->agreement_tender_accept),

        ];
    }
}
