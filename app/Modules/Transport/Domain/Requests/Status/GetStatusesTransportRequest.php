<?php

namespace App\Modules\Transport\Domain\Requests\Status;


use App\Modules\Base\Requests\ApiRequest;

class GetStatusesTransportRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            "email" => ['required', 'email'],

        ];
    }
}
