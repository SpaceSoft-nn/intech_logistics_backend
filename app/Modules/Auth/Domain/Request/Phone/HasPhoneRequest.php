<?php

namespace App\Modules\Auth\Domain\Request\Phone;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Notification\Domain\Rule\PhoneRule;

class HasPhoneRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'phone' => (new PhoneRule)->addRule('exists:phone_list,value')->toArray(),
        ];
    }

}
