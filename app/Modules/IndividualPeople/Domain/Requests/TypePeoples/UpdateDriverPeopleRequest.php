<?php

namespace App\Modules\IndividualPeople\Domain\Requests\TypePeoples;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\IndividualPeople\App\Data\DTO\CreateDriverPeopleDTO;
use App\Modules\IndividualPeople\App\Data\ValueObject\DriverPeopleVO;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;

class UpdateDriverPeopleRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function passes($attribute, $value): bool
    {
        // Проверка, что хотя бы одно поле было передано
        return !empty(array_filter($value));
    }


    public function rules(): array
    {
        return [

            'individual_people_id' => ['sometimes', 'nullable' ,'uuid', 'exists:individual_peoples,id'],

            'series' => ['sometimes', 'nullable', 'regex:/^\d{4}$/'],
            'number' => ['sometimes', 'nullable', 'regex:/^\d{6}$/'],
            'date_get' => ['sometimes', 'nullable', 'date', 'date_format:d.m.Y'],

        ];
    }

    /**
    * Получаем из модели значение, и приопределяем их из валидации
    * @return DriverPeopleVO
    */
    public function updateDriverPeopleVO(DriverPeople $transport): DriverPeopleVO
    {
        return DriverPeopleVO::mappingForUpdate($transport, $this->validated());
    }

    public function createDriverPeopleVO() : DriverPeopleVO
    {
        return DriverPeopleVO::fromArrayToObject($this->validated());
    }

    public function createDriverPeopleDTO(?DriverPeopleVO $driverPeopleVO = null, DriverPeople $driverPeople) : CreateDriverPeopleDTO
    {

        $validated = $this->validated();

        return CreateDriverPeopleDTO::make(
            vo: $driverPeopleVO ?? DriverPeopleVO::fromArrayToObject($validated),
            individual_people_id: $validated['individual_people_id'] ?? $driverPeople->individual_people->id,
        );
    }


}
