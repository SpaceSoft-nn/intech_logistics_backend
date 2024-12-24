<?php

namespace App\Modules\IndividualPeople\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\IndividualPeople\App\Data\DTO\CreateIndividualPeopleDTO;


class CreateIndividualPeopleRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'first_name' => ['required', 'string', 'min:2', 'max:255'],
            'last_name' => ['required', 'string', 'min:2', 'max:255'],
            'father_name' => ['required', 'string', 'min:2', 'max:255'],

            'position' => ['required', 'string'], // иметь enum таблицу
            'other_contact' => ['required', 'string'],
            'personal_area_id' => ['required', 'uuid', 'exists:personal_areas,id'], #TODO Будет добавляться в зависимости от роли у user

            'email' => ['string', 'email'],
            'phone' => ["numeric", "regex:/^(7|8)(\d{10})$/"], // Возможно phone будет обязательным

            #TODO Проверить в чем проблема кастомных прави валидации: они не работают - добавить свою правила валидации
            // 'email' => (new EmailRule)->toArray(),
            // 'phone' => (new PhoneRule)->toArray(),

            'comment' => ['nullable', 'string', 'max:1000'],

        ];
    }

    public function createCreateIndividualPeopleDTO() : CreateIndividualPeopleDTO
    {

        return CreateIndividualPeopleDTO::fromArrayToObject($this->validated());
    }

}
