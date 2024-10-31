<?php

namespace App\Modules\OrderUnit\Domain\Requests\OrderUnit;

use App\Modules\Address\Domain\Rules\ArrayAddressRule;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderUnitCreateRequest extends ApiRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        #TODO - Проверять относится ли organization_id - к user_id
        return true;
    }

    public function rules(): array
    {
        #TODO Моного запросов в бд в validation*
        // Получаем названия всех кейсов
        $type = array_column(TypeLoadingTruckMethod::cases(), 'name');

        return [

            "start_Address_id" => ['required', 'uuid', "exists:addresses,id"], //Адресс начало.
            "end_Address_id" => ['required', 'uuid', "exists:addresses,id"], //Адресс окончания.

            "start_date_delivery" => ['required', 'date'], // Дата начала заказа
            "end_date_delivery" => ['required', 'date'], // Дата окончания заказа

            'address_array' => ['nullable', new ArrayAddressRule()],

            "organization_id" => ['required', 'uuid', "exists:organizations,id"],

            "end_date_order" => ['required', 'date'], //Дата окончание order

            "product_type" => ['required', 'string', 'max:255'], //Тип продукта
            "body_volume" => ['required', 'numeric', 'min:1'], //Объём продукта

            "type_load_truck" => ['required', Rule::in($type)],

            "order_total" => ['required', 'numeric'], //Цена #TODO цена может быть в копейках предусмотреть работу с ценой в laravel

            "description" => ['nullable', 'string', 'max:1000'], //Описание

        ];
    }

    // /**
    // * @return UserVO
    // */
    // public function getValueObject(): OrderUnitVO
    // {
    //     return OrderUnitVO::fromArrayToObject($this->validated());
    // }

}
