<?php

namespace App\Modules\OrderUnit\Domain\Requests\OrderUnit;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\Domain\Rule\ArrayCargoGoodRule;

class OrderUnitSelectPriceRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            "start_address_id" => ['required', 'uuid', "exists:addresses,id"],
            "end_address_id" => ['required', 'uuid', "exists:addresses,id"],

            "goods_array" => ['required', new ArrayCargoGoodRule()], //массив грузов
            "start_date_delivery" => ['required', 'date', 'date_format:d.m.Y'], // Дата начала заказа
            "end_date_delivery" => ['required', 'date', 'date_format:d.m.Y', 'after_or_equal:start_date_delivery'], // Дата окончания заказа

        ];
    }

}
