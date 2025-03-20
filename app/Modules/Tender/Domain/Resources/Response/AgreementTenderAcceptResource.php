<?php

namespace App\Modules\Tender\Domain\Resources\Response;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class AgreementTenderAcceptResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
            // "agreement_tender_id" => $this->agreement_tender_id,
            "is_customer" => $this->tender_creater_bool,
            "is_contactor" => $this->contractor_bool,
        ];
    }
}
