<?php

namespace App\Modules\OfferContractor\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OfferContractor\App\Data\ValueObject\InvoiceOrderCustomerVO;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use Illuminate\Validation\Rule;

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
        $transportLoadingType = array_column(TransportLoadingType::cases(), 'name');

        return [
            'order_total' => ['required', 'numeric'],
            'body_volume' => ['required', 'numeric'],
            'type_product' => ['required', 'string', "max:255"],
            'type_transport_weight' => ['required',  Rule::in($transportTypeWeight)],
            'type_load_truck' => ['required', Rule::in($transportLoadingType)],
            'start_address_id' => ['required', 'uuid', "exists:addresses,id"],
            'end_address_id' => ['required', 'uuid', "exists:addresses,id"],
            'start_date' => ['required', 'date', 'date_format:d.m.Y'],
            'end_date' => ['required', 'date', 'date_format:d.m.Y' ,'after_or_equal:start_date'],
            'description' => ['nullable', 'string', "max:1000"],
        ];
    }

    public function createInvoiceOrderCustomerVO() : InvoiceOrderCustomerVO
    {
        return InvoiceOrderCustomerVO::fromArrayToObject($this->validated());
    }

}
