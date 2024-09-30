<?php

namespace App\Modules\User\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Notification\Domain\Rule\EmailRule;
use App\Modules\Notification\Domain\Rule\PhoneRule;
use Illuminate\Validation\Rules\Password;

class UserLoginRequest extends ApiRequest
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
            'phone' => (new PhoneRule)->toArray(),
            'password' => ['required', 'string', Password::defaults()],
        ];
    }

}
