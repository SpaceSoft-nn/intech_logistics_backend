<?php

namespace App\Modules\OfferContractor\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgreementOrderContractorAcceptResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            'id_agreement_order_contractor_accept' => $this->id,
            'agreement_order_contractor_id' => $this->agreement_order_contractor,
            'order_bool' => $this->order_bool,
            'contractor_bool' => $this->contractor_bool,

        ];
    }
}
