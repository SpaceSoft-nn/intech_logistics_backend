<?php

namespace App\Modules\IndividualPeople\Domain\Requests\TypePeoples;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\IndividualPeople\App\Data\DTO\CreateDriverPeopleDTO;
use App\Modules\IndividualPeople\App\Data\ValueObject\DriverPeopleVO;

class CreateDriverPeopleRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'personal_area_id' => ['required', 'uuid', 'exists:personal_areas,id'], #TODO - Должно браться из токена по user?
            'individual_people_id' => ['required', 'uuid', 'exists:individual_peoples,id'],
            'organization_id' => ['nullable', 'uuid', 'exists:organizations,id'], #TODO - Должно браться из токена по user?

            'series' => ['required', 'regex:/^\d{4}$/'],
            'number' => ['required', 'regex:/^\d{6}$/'],
            'date_get' => ['required', 'date', 'date_format:d.m.Y'],

        ];
    }

    public function createDriverPeopleVO() : DriverPeopleVO
    {
        return DriverPeopleVO::fromArrayToObject($this->validated());
    }


    public function createDriverPeopleDTO() : CreateDriverPeopleDTO
    {

        $validated = $this->validated();

        return CreateDriverPeopleDTO::make(
            vo: DriverPeopleVO::fromArrayToObject($validated),
            individual_people_id: $validated['individual_people_id'],
        );
    }


}
