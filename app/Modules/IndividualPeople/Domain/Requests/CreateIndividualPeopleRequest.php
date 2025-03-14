<?php

namespace App\Modules\IndividualPeople\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\IndividualPeople\App\Data\ValueObject\PassportVO;
use App\Modules\IndividualPeople\App\Data\DTO\CreateIndividualPeopleDTO;
use App\Modules\IndividualPeople\App\Data\ValueObject\IndividualPeopleVO;

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

            'personal_area_id' => ['required', 'uuid', 'exists:personal_areas,id'], #TODO Будет добавляться в зависимости от роли у user

            'email' => ['string', 'email'],
            'phone' => ["numeric", "regex:/^(7|8)(\d{10})$/"], // Возможно phone будет обязательным

            #TODO Проверить в чем проблема кастомных прави валидации: они не работают - добавить свою правила валидации
            // 'email' => (new EmailRule)->toArray(),
            // 'phone' => (new PhoneRule)->toArray(),
            'other_contact' => ['nullable', 'string'],
            'comment' => ['nullable', 'string', 'max:1000'],

            'passport_series' => ['required', 'digits:4'],
            'passport_number' => ['required', 'digits:6'],
            'issue_date' => ['required', 'date', 'date_format:d.m.Y', 'before_or_equal:today'],
            'issued_by' => ['required', 'string', 'min:3'],
            'department_code' => ['nullable', 'regex:/^\d{3}-\d{3}$/'],

        ];
    }


    public function createCreateIndividualPeopleDTO() : CreateIndividualPeopleDTO
    {

        return CreateIndividualPeopleDTO::make(
            individualPeopleVO: $this->createCreateIndividualPeopleVO(),
            passportVO: $this->createPassportVO(),
        );
    }

    public function createCreateIndividualPeopleVO() : IndividualPeopleVO
    {
        return IndividualPeopleVO::fromArrayToObject($this->validated());
    }

    public function createPassportVO() : PassportVO
    {
        return PassportVO::fromArrayToObject($this->validated());
    }

}
