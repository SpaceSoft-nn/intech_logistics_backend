<?php

namespace App\Modules\Transport\Domain\Resources\TransportStatus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportStatusCalendarResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "date" => $this->date,
            "order" => $this->order,
            "enum_transportation_status" => $this->enumTransportation,
            "transport" => $this->transport,

        ];
    }
}
