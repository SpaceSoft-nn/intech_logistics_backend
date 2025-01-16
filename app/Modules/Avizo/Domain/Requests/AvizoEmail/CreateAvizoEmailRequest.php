<?php

namespace App\Modules\Avizo\Domain\Requests\AvizoEmail;

use App\Modules\Avizo\App\Data\ValueObject\AvizoEmailVO;
use App\Modules\Base\Requests\ApiRequest;

class CreateAvizoEmailRequest extends ApiRequest
{


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
           "email_sender" => ['required', 'email'], //отрпавитель
           "email_confirmation" => ['required', 'email'], //подтвреждающий
        ];
    }

    public function createAvisoEmailVO() : AvizoEmailVO
    {
        return AvizoEmailVO::fromArrayToObject($this->validated());
    }

}
