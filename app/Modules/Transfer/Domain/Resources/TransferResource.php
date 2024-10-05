<?php

namespace App\Modules\Transfer\Domain\Resources;

use App\Modules\Adress\Domain\Resources\AdressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "transport_id" => $this->transport_id,
            "delivery_start" => $this->delivery_start,
            "delivery_end" => $this->delivery_end,
            "adress_start_id" => AdressResource::make($this->adress_start),
            "adress_end_id" => AdressResource::make($this->adress_end),
            "order_total" => $this->order_total,
            "description" => $this->description,
            "body_volume" => $this->body_volume,
        ];
    }
}
