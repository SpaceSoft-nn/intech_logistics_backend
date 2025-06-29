<?php

namespace App\Modules\Transfer\Domain\Resources;

use App\Modules\Address\Domain\Resources\AddressResource;
use App\Modules\OrderUnit\Domain\Resources\CargoUnit\CargoUnitCollection;
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

        $this->loadMissing([
            'cargo_units',
        ]);

        return [
            "transport_id" => $this->transport_id,
            "delivery_start" => $this->delivery_start,
            "delivery_end" => $this->delivery_end,
            "address_start_id" => AddressResource::make($this->address_start),
            "address_end_id" => AddressResource::make($this->address_end),
            "order_total" => $this->order_total,
            "description" => $this->description,
            "body_volume" => $this->body_volume,
            "cargo_units" => CargoUnitCollection::make($this->cargo_units),
        ];
    }
}
