<?php

namespace App\Modules\Address\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "region" => $this->region,
            "city" => $this->city,
            "street" => $this->street,
            "building" => $this->building,
            "postal_code" => $this->postal_code,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "nomination" => $this->nomination,
            "point_name" => $this->point_name,
        ];
    }
}
