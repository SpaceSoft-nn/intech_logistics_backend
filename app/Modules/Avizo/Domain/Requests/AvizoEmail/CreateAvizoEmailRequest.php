<?php

namespace App\Modules\Avizo\Domain\Requests\AvizoEmail;

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

}
