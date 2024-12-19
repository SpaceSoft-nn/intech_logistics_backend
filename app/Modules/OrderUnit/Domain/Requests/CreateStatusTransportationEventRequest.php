<?php

namespace App\Modules\OrderUnit\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\App\Data\Enums\StatusTransportationEventOrderEnum;
use Illuminate\Validation\Rule;

class CreateStatusTransportationEventRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $status = array_column(StatusTransportationEventOrderEnum::cases(), 'name');

        return [
            'status' => ['required', Rule::in($status)], // organization_order_units_invoce Откликнувшиеся перевозчики на заказ (Order)
        ];
    }

    #TODO Возможно заказ нужно принимать в запросе
    // /**
    //  * @return StatusTransportationEventVO
    //  */
    // public function createStatusTransportationEventVO() : StatusTransportationEventVO
    // {
    //     return StatusTransportationEventVO::fromArrayToObject($this->validated());
    // }

}
