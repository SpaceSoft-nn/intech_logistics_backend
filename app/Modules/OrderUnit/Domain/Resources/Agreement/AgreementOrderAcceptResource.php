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
            "agreement_order" => $this->agreement,
            "order_bool" => $this->order_bool,
            "contractor_bool" => $this->executor_bool,
        ];
    }
}
