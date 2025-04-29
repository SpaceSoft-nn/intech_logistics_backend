<?php

namespace App\Modules\Transport\Domain\Resources\TransportStatus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportationStatusCalendarResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "date" => $this->date,
            "address" => $this->address,
            "order" => $this->order,
            "event" => $this->enumTransportation->enum_name,
            "transport" => $this->transport,

        ];
    }
}
