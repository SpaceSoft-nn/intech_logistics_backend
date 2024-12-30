<?php

namespace App\Modules\Tender\Domain\Requests;

use App\Modules\Address\Domain\Rules\ArrayAddressRule;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\Domain\Rule\ArrayCargoGoodRule;

class AddInfoOrderByTenderRequest extends ApiRequest
{

    private $validatedData;

    public function authorize(): bool
    {
        #TODO Проверять что данный заказ, относится к данному тендеру при передаче
        return true;
    }

    public function rules(): array
    {

        return [

            //Работа с Адрессами
            "start_address_id" => ['required', 'uuid', "exists:addresses,id"], //Адресс начало.
            "end_address_id" => ['required', 'uuid', "exists:addresses,id"], //Адресс окончания.

            "start_date_delivery" => ['required', 'date'], // Дата начала заказа
            "end_date_delivery" => ['required', 'date'], // Дата окончания заказа

            //массивы
            'goods_array' => ['required', new ArrayCargoGoodRule()], //массив грузов
            'address_array' => ['nullable', new ArrayAddressRule()], //массив аддрессов (Главный вектор и промежуточные адресса Догрузы/Выгрузы)

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
