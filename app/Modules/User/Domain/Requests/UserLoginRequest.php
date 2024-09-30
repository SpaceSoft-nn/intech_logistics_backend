<?php

namespace App\Modules\User\Domain\Requests;

use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Rules\EmailRule;
use App\Modules\User\Domain\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserLoginRequest extends FormRequest
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
