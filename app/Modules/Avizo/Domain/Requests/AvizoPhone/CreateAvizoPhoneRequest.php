<?php

namespace App\Modules\Avizo\Domain\Requests\AvizoPhone;

use App\Modules\Avizo\App\Data\ValueObject\AvizoPhoneVO;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Notification\Domain\Rule\PhoneRule;

class CreateAvizoPhoneRequest extends ApiRequest
{


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
           "phone_sender" => ['required', "numeric", "regex:/^(7|8)(\d{10})$/"], //отрпавитель
           "phone_confirmation" => ['required', "numeric", "regex:/^(7|8)(\d{10})$/"], //подтвреждающий
        ];
    }

    public function createAvisoEmailVO() : AvizoPhoneVO
    {
        return AvizoPhoneVO::fromArrayToObject($this->validated());
    }

}
