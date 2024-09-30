<?php

namespace App\Modules\User\Requests\Entry;

use App\Modules\User\Domain\Rules\EmailRule;
use App\Modules\User\Domain\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
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
            'agreement' => ['required', 'boolean'],
        ];
    }

    // public function getValueObject(): UserVO
    // {
    //     return UserVO::fromArray($this->validated());
    // }

}
