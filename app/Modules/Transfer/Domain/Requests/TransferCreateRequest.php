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

            "main_order_id" => ['required', 'uuid', 'exists:order_units,id'],

            "agreement_order_id" => ['required', 'array', 'min:1'],
            "agreement_order_id.*" => ['required', 'uuid', 'exists:agreement_orders,id'],

            // "transport_id" => ['required', 'uuid', 'exists:transports,id'],
            "transport_id" => ['required', 'uuid'],
            "description" => ['nullable', 'string', 'min:3', 'max:1000'],

        ];
    }

}
