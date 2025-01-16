<?php

namespace App\Modules\IndividualPeople\Domain\Requests\TypePeoples;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\IndividualPeople\App\Data\DTO\CreateStorekeeperPeopleDTO;
use App\Modules\IndividualPeople\App\Data\ValueObject\StorekeeperPeopleVO;

class CreateStorekeeperPeopleRequest extends ApiRequest
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

        ];
    }

    // public function createStorekeeperPeopleVO() : StorekeeperPeopleVO
    // {
    //     return StorekeeperPeopleVO::fromArrayToObject($this->validated());
    // }

    public function createStorekeeperPeopleDTO() : CreateStorekeeperPeopleDTO
    {

        $validated = $this->validated();

        return CreateStorekeeperPeopleDTO::make(
            vo: StorekeeperPeopleVO::fromArrayToObject($validated),
            individual_people_id: $validated['individual_people_id'],
        );
    }

}
