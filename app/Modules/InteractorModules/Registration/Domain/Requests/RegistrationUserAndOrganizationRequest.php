<?php

namespace App\Modules\InteractorModules\Registration\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\InteractorModules\Registration\App\Data\DTO\CreateRegisterAllDTO;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\Notification\Domain\Rule\EmailRule;
use App\Modules\Notification\Domain\Rule\PhoneRule;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\App\Data\Enums\OrganizationEnum;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Rules\OgrnepRule;
use App\Modules\Organization\Domain\Rules\OgrnRule;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use Illuminate\Validation\Rule;
use Arr;
use Illuminate\Validation\ValidationException;

class RegistrationUserAndOrganizationRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * После успешкой валидации делаем ещё проверку.
     */
    protected function passedValidation()
    {
        $email = $this->input('email');
        $phone = $this->input('phone');
        //выкидываем ошибку - если у нас прислали email и phone вместе
        abort_if( isset($email) && isset($phone) , 400, 'Only Email or Phone');
    }


    public function rules(): array
    {

        $typeCabinet = array_column(TypeCabinetEnum::cases(), 'name');
        $typeOrganization = array_column(OrganizationEnum::cases(), 'name');

        $rules = [

                //user strat
            'email' => (new EmailRule)->addRule('unique:email_list,value')->toArray(),
            'phone' => (new PhoneRule)->addRule('unique:phone_list,value')->toArray(),
            'password' => ['required', 'string', 'confirmed'],

            'first_name' => ['required', 'string', "max:130", 'min:2', 'alpha'],
            'last_name' => ['required', 'string' , "max:130", 'min:2', 'alpha'],
            'father_name' => ['required', 'string', "max:130", 'min:2', 'alpha'],
            // 'role' => ['required', 'string', Rule::enum(UserRoleEnum::class)->only([UserRoleEnum::admin])],

            'agreement' => ['required', 'boolean'],
                //user end

            //Organization start
                'organization' => ['required' , 'array'],
                'organization.name' => ['required' , 'string' , 'max:101' , 'min:2'],
                'organization.type' =>  ['required', 'string' , Rule::in($typeOrganization)],
                'organization.type_cabinet' => ['required' , Rule::in($typeCabinet)],
                'organization.address' => ['nullable' , 'string' , 'max:255' , 'min:2'],
                'organization.phone' => ['nullable' , 'string'],
                'organization.email' => ['nullable', "string", "email:filter", "max:100"],
                'organization.website' => ['nullable', "string"],
                'organization.description' => ['nullable', 'string'],
                'organization.okved' => ['nullable', 'string'],
                'organization.founded_date' => ['nullable', 'date'],
                // 'organization.inn' => ['required' , 'numeric', 'regex:/^(([0-9]{12})|([0-9]{10}))?$/', 'unique:organizations,inn'],
                'organization.inn' => ['required' , 'numeric', 'regex:/^(([0-9]{12})|([0-9]{10}))?$/'],
            //Organization end

        ];

        if(is_null($this->input('organization.type'))){
            $this->fail('organization.type', 'Не указан тип для организации.');
        }


        // Если тип ооо, добавляем к правилам валидации kpp и ogrn
        if (OrganizationEnum::stringByCaseToObject(strtolower($this->input('organization.type'))) == OrganizationEnum::legal) {
            $rules['organization.kpp'] = ['required', 'numeric' , 'regex:/^([0-9]{9})?$/'];
            // $rules['organization.registration_number'] = ['required' , 'numeric' , 'regex:/^([0-9]{13})?$/' , (new OgrnRule), 'unique:organizations,registration_number'];
            // $rules['organization.registration_number'] = ['required' , 'numeric' , 'regex:/^([0-9]{13})?$/' , 'unique:organizations,registration_number'];
            $rules['organization.registration_number'] = ['required' , 'numeric' , 'regex:/^([0-9]{13})?$/'];
        }

        // если ИП, добавляем огрнип
        if( OrganizationEnum::stringByCaseToObject($this->input('organization.type')) == OrganizationEnum::individual )
        {
            // $rules['organization.registration_number'] = ['required' , 'numeric' , 'regex:/^\d{15}$/', (new OgrnepRule), 'unique:organizations,registration_number'];
            // $rules['organization.registration_number'] = ['required' , 'numeric' , 'regex:/^\d{15}$/', 'unique:organizations,registration_number'];
            $rules['organization.registration_number'] = ['required' , 'numeric' , 'regex:/^\d{15}$/'];
        }

        return $rules;
    }



    // Метод для принудительного выбрасывания ошибки валидации
    protected function fail($field, $message)
    {
        $validator = validator($this->all(), []);
        $validator->getMessageBag()->add($field, $message);

        throw new ValidationException($validator);
    }


    public function createRegisterAllDTO() : CreateRegisterAllDTO
    {
        $data = $this->validated();


        return CreateRegisterAllDTO::make(
            registrationDTO: RegistrationDTO::make(
                userDTO: UserCreateDTO::make(
                    userVO: UserVO::fromArrayToObject($data),
                    userAuth: null,
                ),
                phone: Arr::get($data, 'phone', null),
                email: Arr::get($data, 'email', null),
            ),
            organizationVO: OrganizationVO::fromArrayToObject($data['organization']),
            type_cabinet: TypeCabinetEnum::stringByCaseToObject(Arr::get($data, 'organization.type_cabinet')),
            inn: Arr::get($data, 'organization.inn'),
        );
    }

}
