<?php

namespace App\Modules\Transfer\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;

class TransferCreateRequest extends ApiRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
           "id_order_array" => ['required', 'array'],
            //'id_order_array.*' => ['required', 'uuid', 'exists:order_units,id'],
           'id_order_array.*' => ['required', 'uuid'],
        ];
    }

}
