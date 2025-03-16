<?php

namespace App\Modules\OfferContractor\Domain\Requests;

use Illuminate\Validation\Rule;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Address\Domain\Rules\ArrayAddressRule;
use App\Modules\OrderUnit\Domain\Rule\ArrayCargoGoodRule;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\OfferContractor\App\Data\ValueObject\InvoiceOrderCustomerVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;

class OfferContractorAddCustomerRequest extends ApiRequest
{

    public function authorize(): bool
    {
        #TODO Проверять что пользователь который обратился на endpoint относится к оргиназции Заказчика
        return true;
    }


    public function rules(): array
    {

        $transportTypeWeight = array_column(TransportTypeWeight::cases(), 'name');
        // $transportLoadingType = array_column(TransportLoadingType::cases(), 'name');
        $typeLoadingTruckMethod = array_column(TypeLoadingTruckMethod::cases(), 'name');

        return [

            'start_address_id' => ['required', 'uuid', "exists:addresses,id"],
            'end_address_id' => ['required', 'uuid', "exists:addresses,id"],

            'start_date' => ['required', 'date', 'date_format:d.m.Y'],
            'end_date' => ['required', 'date', 'date_format:d.m.Y' ,'after_or_equal:start_date'],

            // 'address_array' => ['nullable', new ArrayAddressRule()],
            'goods_array' => ['required', new ArrayCargoGoodRule()],

            'order_total' => ['required', 'numeric'],
            'body_volume' => ['required', 'numeric'],
            'type_product' => ['required', 'string', "max:255"],
            'type_transport_weight' => ['required',  Rule::in($transportTypeWeight)],
            'type_load_truck' => ['required', Rule::in($typeLoadingTruckMethod)],


            'description' => ['nullable', 'string', "max:1000"],
        ];
    }

    public function createInvoiceOrderCustomerVO() : InvoiceOrderCustomerVO
    {
        #TODO $this->validated() - сделать так что бы вызывался 1 раз
        return InvoiceOrderCustomerVO::fromArrayToObject($this->validated());
    }

    /**
    * @return CargoGoodVO[]
    */
    public function createCargoGoodVO(): ?array
    {
        #TODO $this->validated() - сделать так что бы вызывался 1 раз
        return CargoGoodVO::fromArrayToObject($this->validated());
    }

}
