<?php

namespace App\Modules\OrderUnit\Domain\Resources\CargoGood;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CargoGoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "name_value" => $this->end_date_order,
            "product_type" => $this->body_volume,
            "type_pallet" => $this->order_total,
            "cargo_units_count" => $this->description,

            "body_volume" => $this->type_load_truck,
            "description" => $this->end_date_order,
            "mgx" => $this->mgx,

        ];
    }
}
