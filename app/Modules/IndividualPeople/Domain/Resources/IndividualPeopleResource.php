<?php

namespace App\Modules\IndividualPeople\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndividualPeopleResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id_individual_people" => $this->id,

            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "father_name" => $this->father_name,
            "position" => $this->position,
            "other_contact" => $this->other_contact,
            "personal_area_id" => $this->personal_area_id,
            "email" => $this->email,
            "phone" => $this->phone,
            "comment" => $this->comment,

        ];
    }
}
