<?php

namespace App\Modules\OrderUnit\Domain\Requests\OrderUnit;

use App\Modules\Base\Requests\ApiRequest;

class OrderUnitCreateRequest extends ApiRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "start_adress_id" => ['required', 'uuid', "exists:adresses,id"],
            "end_adress_id" => ['required', 'uuid', "exists:adresses,id"],
        ];
    }


}
