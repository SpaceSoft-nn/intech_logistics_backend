<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitStatus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OrderUnitStatusResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [

            // "id" => $this->id,
            "status" => $this->status,
            "created_at" => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),

        ];
    }
}
