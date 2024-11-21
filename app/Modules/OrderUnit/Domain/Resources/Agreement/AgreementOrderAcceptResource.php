<?php

namespace App\Modules\OrderUnit\Domain\Resources\Agreement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgreementOrderAcceptResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "agreement_order_accept_id" => $this->id,
            "agreement_order" => $this->agreement,
            "order_bool" => $this->order_bool,
            "contractor_bool" => $this->contractor_bool,
        ];
    }
}
