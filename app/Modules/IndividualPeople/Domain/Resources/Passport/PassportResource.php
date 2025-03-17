<?php

namespace App\Modules\IndividualPeople\Domain\Resources\Passport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassportResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            'id_passport' => $this->id,

            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
            'passport_series' => $this->passport_series,
            'passport_number' => $this->passport_number,
            'issue_date' => $this->issue_date,
            'issued_by' => $this->issued_by,
            'department_code' => $this->department_code,
            'individual_people_id' => $this->individual_people_id,
            'birth_day' => $this->birth_day,

        ];
    }
}
