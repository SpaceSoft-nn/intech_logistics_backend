<?php

namespace App\Modules\OfferContractor\Domain\Resources;

use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgreementOrderContractorAcceptResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,
            // 'agreement_order_contractor_id' => $this->agreement_order_contractor,
            'is_customer' => $this->order_bool,
            'is_contactor' => $this->contractor_bool,
            "order" => OrderUnitResource::make($this->order),

        ];
    }
}
