<?php

namespace App\Modules\IndividualPeople\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\IndividualPeople\Domain\Resources\Passport\PassportResource;

class IndividualPeopleResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id_individual_people" => $this->id,

            "position" => $this->position,
            "other_contact" => $this->other_contact,
            "personal_area_id" => $this->personal_area_id,
            "email" => $this->email,
            "phone" => $this->phone,
            "comment" => $this->comment,
            "passport" => PassportResource::make($this->passport),

        ];
    }
}
