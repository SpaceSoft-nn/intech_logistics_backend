<?php

namespace App\Modules\Avizo\Domain\Requests\AvizoPhone;

use App\Modules\Base\Requests\ApiRequest;

class ConfirmAvizoPhoneRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "code_confirm" => ['required', 'numeric', 'digits:6'], //код подтверждения
        ];
    }

}
