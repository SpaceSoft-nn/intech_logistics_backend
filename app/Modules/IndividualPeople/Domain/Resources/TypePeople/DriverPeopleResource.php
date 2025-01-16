<?php

namespace App\Modules\IndividualPeople\Domain\Resources\TypePeople;

use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\IndividualPeople\Domain\Resources\IndividualPeopleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverPeopleResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id_driver_people" => $this->id,

            "personal_area_id" => $this->personal_area_id,
            "individual_people_id" => IndividualPeopleResource::make($this->individual_people),
            "organization_id" => $this->organization_id,

            "series" => $this->series,
            "number" => $this->number,
            "date_get" => $this->date_get,

        ];
    }
}
