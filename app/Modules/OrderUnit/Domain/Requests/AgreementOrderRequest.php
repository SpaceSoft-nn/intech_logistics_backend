<?php

namespace App\Modules\OrderUnit\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;

class AgreementOrderRequest extends ApiRequest
{


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_order_units_invoce_id' => ['required', 'uuid', 'exists:organization_order_unit_invoces,id'], // organization_order_units_invoce Откликнувшиеся перевозчики на заказ (Order)
        ];
    }

}
