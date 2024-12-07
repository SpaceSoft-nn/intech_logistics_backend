<?php

namespace App\Modules\Matrix\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatrixDistanceResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'city_start_gar_id' => $this->city_start_gar_id ?? null,
            'city_end_gar_id' => $this->city_end_gar_id ?? null,

            'city_name_start' => $this->city_name_start,
            'city_name_end' => $this->city_name_end,

            'distance' => $this->distance,
        ];
    }
}
