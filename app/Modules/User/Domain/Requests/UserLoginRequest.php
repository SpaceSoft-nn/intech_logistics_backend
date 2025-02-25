<?php

namespace App\Modules\User\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\Notification\Domain\Rule\EmailRule;
use App\Modules\Notification\Domain\Rule\PhoneRule;
use App\Modules\User\Domain\Models\User;

class UserLoginRequest extends ApiRequest
{

    public function authorize(): bool
    {
        #TODO Надо проверять что пользователь по email иди phone вообще существует
        if($this->input('email'))
        {
            $email = EmailList::where('value', $this->input('email'))->first();

            /** @var EmailList */
            $user = $email?->user;

            abort_unless( (bool) $user?->active, 403, 'Пользователь не активирован.');

            return true;
        }

        if($this->input('phone'))
        {
            $phone = PhoneList::where('value', $this->input('phone'))->first();

            /** @var PhoneList */
            $user = $phone?->user;

            abort_unless( (bool) $user?->active, 403, 'Пользователь не активирован.');

            return true;
        }

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
            'password' => ['required', 'string'],
        ];
    }

}
