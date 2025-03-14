<?php

namespace App\Modules\OfferContractor\Domain\Resources;

use app\Modules\Transport\Domain\Resources\TransportResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferContractorResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "city_name_start" => $this->city_name_start,
            "city_name_end" => $this->city_name_end,
            "price_for_distance" => $this->price_for_distance,

            "transport_id" => TransportResource::make($this->transport),
            "user_id" => $this->user_id,
            "organization_id" => $this->organization_id,

            "status" => $this->status,

            "add_load_space" => $this->add_load_space,
            "road_back" => $this->road_back,
            "directly_road" => $this->directly_road,

            "description" => $this->description ?? null,
            "order_unit_id" => $this->order_unit_id ?? null,

        ];
    }
}
