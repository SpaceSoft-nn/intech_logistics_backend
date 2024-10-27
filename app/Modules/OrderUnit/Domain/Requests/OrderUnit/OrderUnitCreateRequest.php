<?php

namespace App\Modules\OrderUnit\Domain\Requests\OrderUnit;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use Illuminate\Validation\Rule;

class OrderUnitCreateRequest extends ApiRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        // Получаем названия всех кейсов
        $type = array_column(TypeLoadingTruckMethod::cases(), 'name');

        return [

            "start_adress_id" => ['required', 'uuid', "exists:addresses,id"], //Адресс начало.
            "end_adress_id" => ['required', 'uuid', "exists:addresses,id"], //Адресс окончания.

            "start_date_delivery" => ['required', 'date'], // Дата начала заказа
            "end_date_delivery" => ['required', 'date'], // Дата окончания заказа

            "organization_id" => ['required', 'uuid', "exists:organizations,id"],

            "end_date_order" => ['required', 'date'], //Дата окончание order

            "product_type" => ['required', 'string', 'max:255'], //Тип продукта
            "body_volume" => ['required', 'numeric', 'min:1'], //Объём продукта

            "type_load_truck" => ['required', Rule::in($type)],

            "order_total" => ['required', 'numeric'], //Цена #TODO цена может быть в копейках предусмотреть работу с ценой в laravel

            "description" => ['nullable', 'string', 'max:1000'], //Описание

        ];
    }

    /**
    * @return UserVO
    */
    public function getValueObject(): OrderUnitVO
    {
        return OrderUnitVO::fromArrayToObject($this->validated());
    }

}
