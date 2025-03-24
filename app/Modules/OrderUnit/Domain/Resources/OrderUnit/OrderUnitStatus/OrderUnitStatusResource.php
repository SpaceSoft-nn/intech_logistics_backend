<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitStatus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderUnitStatusResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [

            "id" => $this->id,
            "status" => $this->status,
            "created_at" => $this->status,

        ];
    }
}
