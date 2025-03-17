<?php

namespace App\Modules\OrderUnit\Domain\Requests\OrderUnit;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\Address\Domain\Rules\ArrayAddressRule;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\OrderUnit\Domain\Rule\ArrayCargoGoodRule;
use Illuminate\Validation\Rule;

class OrderUnitCreateRequest extends ApiRequest
{

    //Сохраняем состояние валидации 1 раз, что бы не вызывать её множество раз при создании VO
    private array $validatedData = [];

    public function authorize(): bool
    {
        #TODO - Проверять относится ли organization_id - к user_id
        return true;
    }

    public function rules(): array
    {
        #TODO Моного запросов в бд в validation*
        // Получаем названия всех кейсов
        $typeLoadingTruckMethod = array_column(TypeLoadingTruckMethod::cases(), 'name');
        $typeTransportWeight = array_column(TypeTransportWeight::cases(), 'name');
        $orderStatus = array_column(StatusOrderUnitEnum::cases(), 'name');

        return [

            //Работа с Адрессами
            "start_address_id" => ['required', 'uuid', "exists:addresses,id"], //Адресс начало.
            "end_address_id" => ['required', 'uuid', "exists:addresses,id"], //Адресс окончания.

            "start_date_delivery" => ['required', 'date', 'date_format:d.m.Y'], // Дата начала заказа
            "end_date_delivery" => ['required', 'date', 'date_format:d.m.Y', 'after_or_equal:start_date_delivery'], // Дата окончания заказа


            //массивы
            'address_array' => ['nullable', new ArrayAddressRule()], //массив аддрессов (Главный вектор и промежуточные адресса Догрузы/Выгрузы)
            'goods_array' => ['required', new ArrayCargoGoodRule()], //массив грузов

            'type_transport_weight'  => ['required', Rule::in($typeTransportWeight)], //Выбор транспорта по габаритам

            "order_status" => ['nullable', Rule::in($orderStatus)], //Устанавливаем статус заказа вручную

            "organization_id" => ['required', 'uuid', "exists:organizations,id"], //организация к которой принадлежит заказ
            // "organization_id" => ['required', 'uuid'], //организация к которой принадлежит заказ

            "end_date_order" => ['required', 'date', 'date_format:d.m.Y', 'before:start_date_delivery'], //Дата окончание order

            "type_load_truck" => ['required', Rule::in($typeLoadingTruckMethod)], //типа загрузки ftl, ltl, custom

            "order_total" => ['required', 'numeric'], //Цена #TODO цена может быть в копейках предусмотреть работу с ценой в laravel

            "description" => ['nullable', 'string', 'max:1000'], //Описание

        ];
    }


    /**
    * Получить или сохранить валидированные данные.
    *
    * @return array
    */
    private function getValidatedData(): array
    {
        if (empty($this->validatedData)) {
            $this->validatedData = $this->validated();
        }

        return $this->validatedData;
    }

    /**
    * @return OrderUnitVO
    */
    public function createOrderUnitVO(): OrderUnitVO
    {
        return OrderUnitVO::fromArrayToObject($this->getValidatedData());
    }

    /**
    * @return ?CargoGoodVO[]
    */
    public function createCargoGoodVO(): ?array
    {
        return CargoGoodVO::fromArrayToObject($this->getValidatedData());
    }

    public function createOrderUnitAddressDTO() : OrderUnitAddressDTO
    {
        return OrderUnitAddressDTO::fromArrayToObject($this->getValidatedData());
    }

}
