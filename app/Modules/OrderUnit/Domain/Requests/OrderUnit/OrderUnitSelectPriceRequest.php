<?php

namespace App\Modules\OrderUnit\Domain\Requests\OrderUnit;

use App\Modules\Base\Requests\ApiRequest;

class OrderUnitSelectPriceRequest extends ApiRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            "start_Address_id" => ['required', 'uuid', "exists:addresses,id"],
            "end_Address_id" => ['required', 'uuid', "exists:addresses,id"],
            "organization_id" => ['required', 'uuid', "exists:organizations,id"],

            "end_date_order" => ['required', 'date'], //Дата окончание order

            "product_type" => ['required', 'string', 'max:255'], //Тип продукта
            "body_volume" => ['required', 'numeric', 'min:1'], //Объём продукта

            "description" => ['nullable', 'string', 'max:1000'], //Описание
        ];
    }

}
