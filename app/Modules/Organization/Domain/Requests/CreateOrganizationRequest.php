<?php

namespace App\Modules\Organization\Domain\Requests;

use App\Modules\Auth\Domain\Interface\AuthServiceInterface;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\App\Data\Enums\OrganizationEnum;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Rules\OgrnepRule;
use App\Modules\Organization\Domain\Rules\OgrnRule;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CreateOrganizationRequest extends ApiRequest
{
    public function authorize(AuthServiceInterface $auth): bool
    {
        #TODO добавить в сервес auth работу с ролями

        /**
        * @var User
        */
        $user = $auth->getUserAuth();

        if(is_null($user)) { return false; }

        return UserRoleEnum::onlyAdmin($user->role);
    }

    public function rules(): array
    {

        $typeCabinet = array_column(TypeCabinetEnum::cases(), 'name');
        $typeOrganization = array_column(OrganizationEnum::cases(), 'name');

        $rules = [

            'name' => ['required' , 'string' , 'max:101' , 'min:2'],
            'address' => ['required' , 'string' , 'max:255' , 'min:12'],
            'phone' => ['required' , 'string'],
            'email' => ['required', "string", "email:filter", "max:100"],
            'website' => ['required', "string"],
            'type' =>  ['required', 'string' , Rule::in($typeOrganization)],
            'description' => ['nullable', 'string'],
            'okved' => ['nullable', 'string'],
            'founded_date' => ['nullable', 'date'],
            'inn' => ['required' , 'numeric', 'regex:/^(([0-9]{12})|([0-9]{10}))?$/'],
            'type_cabinet' => ['required' , Rule::in($typeCabinet)],

        ];

        // Если тип ооо, добавляем к правилам валидации kpp и ogrn
        if (OrganizationEnum::stringByCaseToObject(strtolower($this->input('type'))) == OrganizationEnum::legal) {
            $rules['kpp'] = ['required', 'numeric' , 'regex:/^([0-9]{9})?$/'];
            $rules['registration_number'] = ['required' , 'numeric' , 'regex:/^([0-9]{13})?$/' , (new OgrnRule)];
        }

        // если ИП, добавляем огрнип
        if( OrganizationEnum::stringByCaseToObject($this->input('type')) == OrganizationEnum::individual )
        {
            $rules['registration_number'] = ['required' , 'numeric' , 'regex:/^\d{15}$/', (new OgrnepRule)];
        }

        return $rules;
    }

    public function getValueObject(): OrganizationVO
    {
        return OrganizationVO::fromArrayToObject($this->validated());
    }

    /**
     * Получаем кабинет пользователя
     * @return TypeCabinetEnum
     */
    public function getTypeCabinet() : TypeCabinetEnum
    {
        return TypeCabinetEnum::stringByCaseToObject(Arr::get($this->validated(), 'type_cabinet' , null));
    }

}
