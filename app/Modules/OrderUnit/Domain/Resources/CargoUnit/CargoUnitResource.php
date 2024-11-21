<?php

namespace App\Modules\OrderUnit\Domain\Resources\CargoUnit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CargoUnitResource extends JsonResource
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
            "pallets_space" => $this->pallets_space,
            "customer_pallets_space" => $this->customer_pallets_space,
            //"cargo_goods", - продумать как правильно возвращать паллеты (то есть указывать ещё и высоут если есть)

        ];
    }
}
