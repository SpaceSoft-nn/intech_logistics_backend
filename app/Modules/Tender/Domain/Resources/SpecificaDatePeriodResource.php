<?php

namespace App\Modules\Tender\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecificaDatePeriodResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [

            'id_specifical_date_period' => $this->id,
            'date' => $this->date,
            'count_transport' => $this->count_transport,

        ];
    }

}
