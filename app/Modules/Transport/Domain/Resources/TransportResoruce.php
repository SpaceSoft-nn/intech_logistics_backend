<?php

namespace App\Modules\Transport\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportResoruce extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "type" => $this->type,
            "brand_model" => $this->brand_model,
            "year" => $this->year,
            "transport_number" => $this->transport_number,
            "body_volume" => $this->body_volume,
            "body_weight" => $this->body_weight,
            "type_status" => $this->type_status,
            "organization_id" => $this->organization_id,
            "driver_id" => $this->driver_id,
            "description" => $this->description,

        ];
    }
}
