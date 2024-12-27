<?php

namespace App\Modules\Tender\Domain\Requests;

use App\Modules\Address\Domain\Rules\ArrayAddressRule;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\Domain\Rule\ArrayCargoGoodRule;

class CreateOrderByRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            //Работа с Адрессами
            "start_address_id" => ['required', 'uuid', "exists:addresses,id"], //Адресс начало.
            "end_address_id" => ['required', 'uuid', "exists:addresses,id"], //Адресс окончания.

            "start_date_delivery" => ['required', 'date'], // Дата начала заказа
            "end_date_delivery" => ['required', 'date'], // Дата окончания заказа

            //массивы
            'address_array' => ['nullable', new ArrayAddressRule()], //массив аддрессов (Главный вектор и промежуточные адресса Догрузы/Выгрузы)
            'goods_array' => ['required', new ArrayCargoGoodRule()], //массив грузов

            "end_date_order" => ['required', 'date'], //Дата окончание order

            "order_total" => ['required', 'numeric'], //Цена #TODO цена может быть в копейках предусмотреть работу с ценой в laravel

            "description" => ['nullable', 'string', 'max:1000'], //Описание
        ];
    }
}
