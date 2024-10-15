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
        return UserRoleEnum::onlyAdmin($user->role);
    }

    public function rules(): array
    {

        $rules = [

            'name' => ['required' , 'string' , 'max:101' , 'min:2'],
            'address' => ['required' , 'string' , 'max:255' , 'min:12'],
            'phone' => ['required' , 'string'],
            'email' => ['required', "string", "email:filter", "max:100"],
            'website' => ['required', "string"],
            'type' =>  ['required', 'string' , Rule::enum(OrganizationEnum::class)->only([OrganizationEnum::ooo, OrganizationEnum::ie])],
            'description' => ['nullable', 'string'],
            'industry' => ['nullable', 'string'],
            'founded_date' => ['nullable', 'date'],
            'inn' => ['required' , 'numeric', 'regex:/^(([0-9]{12})|([0-9]{10}))?$/'],
            'type_cabinet' => ['required' , Rule::enum(TypeCabinetEnum::class)],

        ];

        // Если тип ооо, добавляем к правилам валидации kpp и ogrn
        if (strtolower($this->input('type')) == strtolower(OrganizationEnum::ooo->value)) {
            $rules['kpp'] = ['required', 'numeric' , 'regex:/^([0-9]{9})?$/'];
            $rules['registration_number'] = ['required' , 'numeric' , 'regex:/^([0-9]{13})?$/' , (new OgrnRule)];
        }

        // если ИП, добавляем огрнип
        if( strtolower($this->input('type')) == strtolower(OrganizationEnum::ie->value))
        {
            $rules['registration_number_individual'] = ['required' , 'numeric' , 'regex:/^\d{15}$/', (new OgrnepRule)];
        }

        return $rules;
    }

    public function getValueObject(): OrganizationVO
    {
        return OrganizationVO::fromArray($this->validated());
    }

    /**
     * Получаем кабинет пользователя
     * @return [type]
     */
    public function getTypeCabinet() : TypeCabinetEnum
    {
        return TypeCabinetEnum::returnObjectByString(Arr::get($this->validated(), 'type_cabinet' , null));
    }

}
