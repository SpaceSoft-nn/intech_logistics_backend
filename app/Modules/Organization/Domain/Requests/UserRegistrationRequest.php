<?php

namespace App\Modules\Organization\Domain\Requests;

use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Rules\EmailRule;
use App\Modules\User\Domain\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Password;

class UserRegistrationRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * После успешкой валидации делаем ещё проверку.
     * @return [type]
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
        return [
            'email' => (new EmailRule)->toArray(),
            'phone' => (new PhoneRule)->addRule('unique:App\Modules\User\Models\User')->toArray(),
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],


            'first_name' => ['required', 'string', "max:130", 'min:2', 'alpha'],
            'last_name' => ['required', 'string' , "max:130", 'min:2', 'alpha'],
            'father_name' => ['required', 'string', "max:130", 'min:2', 'alpha'],
            'role' => ['required', 'boolean', Rule::enum(UserRoleEnum::class)],

            'agreement' => ['required', 'boolean'],
        ];
    }

    /**
    * @return UserVO
    */
    public function getValueObject(): UserVO
    {
        return UserVO::fromArrayToObject($this->validated());
    }

}
