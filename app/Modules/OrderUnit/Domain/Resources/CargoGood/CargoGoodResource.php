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
            "name_value" => $this->name_value,
            "product_type" => $this->product_type,
            "type_pallet" => $this->type_pallet,
            "cargo_units_count" => $this->cargo_units_count,

            "body_volume" => $this->body_volume,
            "description" => $this->description,
            "mgx" => $this->mgx,

        ];
    }
}
