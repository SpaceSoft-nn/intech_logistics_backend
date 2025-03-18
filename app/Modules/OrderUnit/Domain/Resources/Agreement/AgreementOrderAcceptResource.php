<?php

namespace App\Modules\OrderUnit\Domain\Resources\Agreement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgreementOrderAcceptResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "agreement_order" => AgreementOrderResource::make($this->agreement)->setRelations([]),
            "is_customer" => $this->order_bool,
            "is_contractor" => $this->contractor_bool,
        ];
    }
}
