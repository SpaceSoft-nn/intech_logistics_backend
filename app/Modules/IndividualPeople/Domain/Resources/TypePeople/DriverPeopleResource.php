<?php

namespace App\Modules\IndividualPeople\Domain\Resources\TypePeople;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverPeopleResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id_driver_people" => $this->id,

            "personal_area_id" => $this->personal_area_id,
            "individual_people_id" => $this->individual_people_id,
            "organization_id" => $this->organization_id,

            "series" => $this->organization_id,
            "number" => $this->organization_id,
            "date_get" => $this->organization_id,

        ];
    }
}
