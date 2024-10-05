<?php

namespace App\Modules\Adress\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdressResource extends JsonResource
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
            "region" => $this->region,
            "city" => $this->city,
            "street" => $this->street,
            "building" => $this->building,
            "apartment" => $this->apartment,
            "house_number" => $this->house_number,
            "postal_code" => $this->postal_code,
            "type_adress" => $this->type_adress,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
        ];
    }
}
