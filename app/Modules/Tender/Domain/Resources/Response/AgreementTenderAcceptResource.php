<?php

namespace App\Modules\Tender\Domain\Resources\Response;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class AgreementTenderAcceptResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [
            "id_agreement_tender_accept" => $this->id,
            "agreement_tender_id" => $this->agreement_tender_id,
            "tender_creater_bool" => $this->tender_creater_bool,
            "contractor_bool" => $this->contractor_bool,
        ];
    }
}
