<?php

namespace App\Modules\Tender\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;

class CreateResponseTenderRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [

            'transport_id' => ['required' , 'uuid', 'exists:transports,id'],
            'price_for_km' => ['required' , 'numeric', "min:1"],
            'comment' => ['required' , 'string', "min:3" , "max:1000"],

        ];


    }

    public function createResponseTenderDTO() : CreateResponseTenderDTO
    {
        return CreateResponseTenderDTO::fromArrayToObject($this->validated());
    }



}
