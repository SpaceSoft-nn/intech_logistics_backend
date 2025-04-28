<?php

namespace App\Modules\Transport\Domain\Requests\Status;


use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Notification\Domain\Rule\EmailRule;
use App\Modules\Notification\Domain\Rule\PhoneRule;

class GetStatusesTransportRequest extends ApiRequest
{

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

            'email' => ["required_without_all:phone", "exclude_with:phone", "string", "email", "max:100", "exists:individual_peoples,email"],
            'phone' => ["required_without_all:email", "exclude_with:email", "numeric", "regex:/^(7|8)(\d{10})$/", "exists:individual_peoples,phone"],

        ];
    }
}
