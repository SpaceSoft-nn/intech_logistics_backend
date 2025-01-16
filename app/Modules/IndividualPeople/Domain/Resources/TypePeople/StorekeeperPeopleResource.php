<?php

namespace App\Modules\IndividualPeople\Domain\Resources\TypePeople;

use App\Modules\IndividualPeople\Domain\Resources\IndividualPeopleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StorekeeperPeopleResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id_storekeeper_people" => $this->id,

            "personal_area_id" => $this->personal_area_id,
            "individual_people" => IndividualPeopleResource::make($this->individual_people),
            "organization_id" => $this->organization_id,

        ];
    }
}
